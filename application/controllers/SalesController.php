<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SalesController extends CI_Controller {

	public function __construct() {

		parent::__construct();
	 
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}
 

	public function sales () {
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

		$this->db->insert('sales',[
				'id' => null ,
				'date_time' => date('Y-m-d h:i:s')
			]);
		$sales_id = $this->db->insert_id();
		$sales = $this->security->xss_clean($sales);

		foreach ($sales as $sale) {
			$transactionProfit = $this->db->where('item_id', $sale['id'])->get('prices')->row()->capital;
			$data[] = [ 
				'item_id' => $sale['id'],
				'quantity' => $sale['quantity'],
				'sales_id' => $sales_id, 
				'price' => $sale['price'],
				'name' => $sale['name'],
				'discount' => $sale['discount'],
				'profit' => $transactionProfit,
				'user_id' => $this->session->userdata('id')
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
		echo $sales_id;
		return;
	}

	public function reports() {

		$this->start = $this->input->post('start');
		$this->limit = $this->input->post('length');
		$datasets = [];
		$totalSales = 0;
		$from = $this->input->post('columns[0][search][value]');
		$to = $this->input->post('columns[1][search][value]');
		$sales = $this->filterReports($from, $to);
		$count = count($sales);
		$totalExpenses = 0;
		$transactionProfit = 0;
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
		 		$item = $this->db->where('id', $desc->item_id)->get('items')->row();
		 		$user = $this->db->where('id', $desc->user_id)->get('users')->row();
		 		$staff = $user ? $user->username : 'Not found';
				$sub_total += ((float)$desc->quantity * (float) $desc->price) - $desc->discount;
				$saleProfit = ((float)$desc->price - (float)$desc->profit ) * (int)$desc->quantity;
				$transactionProfit += $saleProfit;
				$datasets[] = [ 
					date('Y-m-d', strtotime($sale->date_time)), 
					'₱' . number_format($saleProfit),
					$staff,
					$desc->name,
					$desc->quantity,
					'₱' . number_format((float)$desc->price),
					'₱' . number_format($desc->discount),
					'₱'. number_format(((float)$desc->quantity * (float)$desc->price) - $desc->discount),
					'
						<a class="btn btn-sm btn-danger delete-sale" data-id="'.$desc->id.'" href="'.base_url('SalesController/destroy/') . $desc->id.'">Delete</a>
					'
				];
			}
			$totalSales += $sub_total;
		}
		echo json_encode([
				'draw' => $this->input->post('draw'),
				'recordsTotal' => $count,
				'recordsFiltered' => $count,
				'data' => $datasets,
				'total_sales' => number_format($totalSales),
				'from' => $from,
				'to' => $to,
				'profit' => number_format($transactionProfit), 
				'expenses' => number_format($totalExpenses)
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
		if ($from && $to) {
			return $this->db->where('DATE_FORMAT(date_time, "%Y-%m-%d") >=', $from)
						->where('DATE_FORMAT(date_time, "%Y-%m-%d") <=', $to)
						->order_by('id', 'DESC')
						->get('sales', $this->start, $this->limit)->result();


		} 
		
		$date = date('Y-m-d');
		return $this->db->where('DATE_FORMAT(date_time, "%Y-%m-%d") =', $date)
					->order_by('id', 'DESC')
					->get('sales', $this->start, $this->limit)->result();
		 
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
}
?>