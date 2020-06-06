<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");
class SalesController extends AppController {

	public function __construct() {

		parent::__construct();
	 
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}

	}
 

	public function sales () {
		$data['widget_column'] = is_admin() ? 4 : 6;
		$data['dataset'] = $this->graphSales();
		$data['content'] = "sales/index";
		$this->load->view('master',$data);
		 
	}

	public function export() {
		$dompdf = new Dompdf\Dompdf;
		$html = "";
		$from = $this->input->get('start');
		$to = $this->input->get('end');
		$totalSales = 0;
		$tbody = "";
		$sales = $this->db->where('DATE_FORMAT(date_time, "%Y-%m-%d") >=', $from)
					->where('DATE_FORMAT(date_time, "%Y-%m-%d") <=', $to)
					->order_by('id', 'DESC')
					->get('sales')->result();
		foreach ($sales as $sale) {
			$sales_description = $this->db->where('sales_id', $sale->id)->get('sales_description')->result();
			$sub_total = 0;
		 	
			foreach ($sales_description as $desc) {
	 			
				$price = $desc->price;
				$sub_total += ((float)$desc->quantity * (float) $price);
				
				if ($desc) {
					$tbody .= "<tr>
						<td>".date('Y-m-d h:i:s a', strtotime($sale->date_time))."</td>
						<td>".ucwords($desc->name)."</td>
						<td>".$desc->quantity."</td>
						<td>".('<span class="sign">&#x20b1;</span>'. $price)."</td>
						<td>".('&#x20b1;'. number_format((float)$desc->quantity * (float)$price))."</td>
						</tr>
					";
				}	
				 
			}

			$totalSales += $sub_total;
			
		}

		$html .= "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
				<link type='text/css' href='".base_url('assets/print.css')."'>
			";
		$html .= "<h1 class='text-center'>Sales Reports</h1>";
		$html .= "<div class='date'><h4>Date:</h4>";
		$html .= "<div class='date'>From: " . $from . "</div>";
		$html .= "<div class='date'>To: " . $to . "</div></div>";
		$html .= "<div class='right'><h4>Total Sales:</h4><div>₱".number_format($totalSales)."</div></div>";
		$html .= "<div class='clearfix'></div>";
		$html .= "<br>";
		$html .= "<table class='table table-striped'>";
		$html .= "<thead><tr>";
		$html .= "<th>DateTime</th> <th>Item Name</th> <th>Quantity</th><th>Price</th><th>Sub Total</th>";
		$html .= "</tr></thead>";
		
		$html .= "<tbody>";
		$html .= $tbody;
		$html .= "</tbody>";
		$html .= "</table>";
	 
		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portraite');
		$dompdf->render();
		$dompdf->stream();
	}

	public function graphSales($range = "week") {
	 
		if ($range == "week") {
			$currentDate = date('Y-m-d');
			$lastWeek = date('Y-m-d', $this->lastWeek());
			$begin = new DateTime( $lastWeek );
			$end = new DateTime( $currentDate );
			$end = $end->modify( '+1 day' );
			$format = "D, d";
			$sqlDateFormat = "%Y-%m-%d";
			$dateFormat = 'Y-m-d';
			$int = "P1D";

		}else if ($range == "month") {
			$firstMonth = date('Y-1-1');
			$lastMonth = date('Y-12-1');
			$begin = new DateTime($firstMonth);
			$end = new DateTime($lastMonth);
			$end->modify('last day of this month');
			$format = "M";
			$sqlDateFormat = "%Y-%m";
			$dateFormat = "Y-m";
			$int = "P1M";
		}else if ($range == "year") {
		 
			$firstMonth = date('2016-1-1');
		 
			$lastMonth = date('Y-12-1');
			$begin = new DateTime($firstMonth);
			$end = new DateTime($lastMonth);

			$end->modify('last day of this month');
			$format = "Y";
			$sqlDateFormat = "%Y";
			$dateFormat = "Y";
			$int = "P1Y";
		}
		
		$datasets = [];

		$interval = new DateInterval($int);
		$daterange = new DatePeriod($begin, $interval ,$end);
		$total = 0;

		foreach($daterange as $date){
	 	  	
		 	$sales = $this->db->where('DATE_FORMAT(date_time,"'.$sqlDateFormat.'") =', $date->format($dateFormat)) 
						->get('sales')
						->result();
			
		    	if ($sales) {
		    		foreach ($sales as $sale) {
			    		$description = $this->getSalesDescription($sale->id);
			    		
					foreach ( $description as $descr) {
						$item = $this->db->where('id', $descr->item_id)->get('items')->row();
						$total += $descr->price * $descr->quantity;
					}	
				}

				$datasets[$date->format($format)][] = round($total,2);
		    	}else {
		    		$datasets[$date->format($format)][] = 0;
		    	}

		    	$total = 0;
		} 
		return $datasets;
	}

	public function graphFilter() {
		$type = $this->input->post('type');

		echo json_encode($this->graphSales($type));

		return;
	}

	public function hasSales($sales, $date) {
		foreach ($sales as $sale) {
			$saleDate = date('Y-m-d', strtotime($sale->date_time));
			if (!$saleDate == $date)
				continue;

			return true;
		}

		return false;
	}

	public function lastWeek() {
		return $sunday = strtotime(date("Y-m-d h:i:s")." -6 days");
	}

	public function getSalesDescription($id) {
		 
		return $this->db->where('sales_id', $id)->get('sales_description')->result();
 
	}

	public function insert() {
		$data = [];
		$sales = $this->input->post('sales');
		$this->load->model("PriceModel");
		$this->db->trans_begin();

		$last_sales_id = $this->db->select_max('id')->get('sales')->row()->id;
		$transaction_number = "TRN" . sprintf("%04s", ((int)$last_sales_id + 1 )  ); 

		$this->db->insert('sales',[ 
				'date_time' => get_date_time(),
				'user_id' => $this->session->userdata('id'),
				'transaction_number' => $transaction_number
			]);
		$sales_id = $this->db->insert_id();


		$sales = $this->security->xss_clean($sales);

		foreach ($sales as $sale) {
			$transactionProfit = 0;
			$data[] = [ 
				'item_id' => $sale['id'],
				'quantity' => $sale['quantity'],
				'sales_id' => $sales_id, 
				'price' => $sale['price'],
				'name' => $sale['name'],
				'discount' => $sale['discount'],
				'profit' => $transactionProfit,
				'user_id' => $this->session->userdata('id'),
				'created_at' => get_date_time(),
				'capital' => $sale['capital'],
				
			];
			
			$this->db->set('quantity', "quantity - $sale[quantity]" , false);
			$this->db->where('item_id', $sale['id']);
			$this->db->update('ordering_level');
		}
 

		$this->db->insert_batch('sales_description', $data);

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		        return false;
		}
		 
		$this->db->trans_commit(); 
		echo $transaction_number;
		return;
	}

	public function reports() {

		$this->start = $this->input->post('start');
		$this->limit = $this->input->post('length');
		$datasets = [];
		$totalSales = 0;
		$from = $this->input->post('columns[0][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[0][search][value]');
		$to = $this->input->post('columns[1][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[1][search][value]');
		$sales = $this->filterReports($from, $to);
		$count = count($sales);
		$totalExpenses = 0;
		$transactionProfit = 0;
		$gross = 0;
		$goodsCost = 0;
		$expenses = $this->db->select("SUM(cost) as total")
							->where('date >=', $from)
							->where('date <=', $to)
							->get('expenses')
							->row();

		if ($expenses) {
			$totalExpenses = $expenses->total;
		}

		foreach ($sales as $sale) {
			$sales_description = $this->db->where('sales_id', $sale->id)->get('sales_description')->result();
			$sub_total = 0;

			foreach ($sales_description as $desc) {
		 	 
		 		$user = $this->db->where('id', $desc->user_id)->get('users')->row();
		 		$staff = $user ? $user->username : 'Not found';
				$sub_total += ((float)$desc->quantity * (float) $desc->price) - $desc->discount;
				$saleProfit = ($desc->price - $desc->capital) * ($desc->quantity);
				$transactionProfit += $saleProfit;
				$datasets[] = [ 
					date('Y-m-d', strtotime($sale->date_time)),  
					$staff,
					$desc->name,
					$desc->quantity,
					$desc->returned,
					'₱' . number_format($desc->capital,2),
					'₱' . number_format($desc->price,2),
					'₱' . number_format($desc->discount,2),
					'₱'. number_format(((float)$desc->quantity * (float)$desc->price) - $desc->discount, 2),
					'₱' . number_format($saleProfit, 2)
				];

				$goodsCost += ($desc->capital * $desc->quantity);
			}

			$totalSales += $sub_total; 
			
		}

		$gross = $totalSales - $goodsCost;

		echo json_encode([
				'draw' => $this->input->post('draw'),
				'recordsTotal' => $count,
				'recordsFiltered' => $count,
				'data' => $datasets,
				'total_sales' => number_format($totalSales,2),
				'from' => $from,
				'to' => $to,
				'profit' => number_format($transactionProfit,2), 
				'expenses' => number_format($totalExpenses,2),
				'gross' => number_format($gross,2),
				'goodsCost' => number_format($goodsCost, 2),
				'net' => number_format($gross - $total)
			]);

	}

	public function destroy($id) {
		$sale = $this->db->where('id', $id)->get('sales_description')->row();
		$this->load->model('OrderingLevelModel');
		
		$this->db->trans_start();
		$this->OrderingLevelModel->addStocks($sale->item_id, $sale->quantity);
		$this->db->where('id', $id)->delete('sales_description');

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
	        echo "0";
	        return;
		}
		else
		{
			echo "1";
	        return $this->db->trans_commit();
		}

 
	}

	public function filterReports($from, $to) {
		$from = $from ? $from : date('Y-m-d');
		$to = $to ? $to : date('Y-m-d'); 

		return $this->db->where('DATE_FORMAT(date_time, "%Y-%m-%d") >=', $from)
					->where('DATE_FORMAT(date_time, "%Y-%m-%d") <=', $to)
					->order_by('id', 'DESC')
					->get('sales', $this->start, $this->limit)->result();
		 
	}

	public function find() {

		$transaction_number = $this->input->post('transaction_number');
 

		$sales = $this->db->where('transaction_number', $transaction_number)
								->get('sales')
								->row();
 

		if (!$sales) {
 			echo 0;
			return false;
		}


		$sales_description = $this->db->where('sales_id', $sales->id)
												->get('sales_description')
												->result();
		 
		echo json_encode([
			'sales' => $sales,
			'orderline' => $sales_description
		]);
	}

	public function details() {
		$id = $this->input->post('id');
		$datasets = [];
		$description = $this->db->where('sales_id', $id)->get('sales_description')->result();
		foreach ($description as $desc) {
			$item = $this->db->where('id', $desc->item_id)->get('items')->row();
			$price = $this->db->where('item_id', $item->id)->get('prices')->row()->price;
			$sub_total = (int)$price * (int)$desc->quantity;
			$datasets[] = [
				$item->id,
				$item->name,
				$price,
				$desc->quantity,
				$sub_total
			];
		}
		echo json_encode($datasets);
		return;
	}


	/*
		Get daily transactions for logged in user
	*/
	public function get_daily_transactions() {

		$date = date('Y-m-d');
		$user_id = $this->session->userdata('id');

		$datasets = [];

		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]'); 

		$sales = $this->db->select("sales.*, SUM(sales_description.price * sales_description.quantity) as sub")
								->from('sales')
								->join('sales_description', 'sales_description.sales_id = sales.id')
								->where('DATE_FORMAT(sales.date_time, "%Y-%m-%d") =', $date)
								->where('sales.user_id', $user_id)
								->like("sales.transaction_number", $search, "BOTH")
								->group_by('sales.id')
								->order_by('id', 'DESC')
								->limit($limit,$start)
								->get();

		
		$count = $sales->num_rows();

		$sales = $sales->result();


		foreach ($sales as $sale) {

			$datasets[] = [
					date('Y-m-d h:i:s A', strtotime($sale->date_time)),
					$sale->transaction_number, 
					$this->session->userdata('username'),
					currency() . number_format($sale->sub, 2)
				];
		}



		echo json_encode([
				'draw' => $this->input->post('draw'),
				'recordsTotal' => $count,
				'recordsFiltered' => $count,
				'data' => $datasets, 
			]);

	}
}
?>