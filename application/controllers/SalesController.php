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

	public function index() {

		$data['content'] = 'sales/reports';
		$data['daily'] = $this->getDailySales();
		$data['todaysSales'] = $this->getTodaysSales();
		$data['todaysProfit'] = $this->getTodaysProfit();
		$data['bestEver'] = $this->bestSales();
		$data['allTimeSales'] = $this->allTimeSales();
		$this->load->view('master', $data);
	}

	public function getMonthlySales() {

		$lastYear = new DateTime( date("Y-m-d", strtotime("-1 year")) );
		$today = new DateTime( date('Y-m-d'));

		$sales = $this->db->where('DATE_FORMAT(created_at, "%Y-m-d") >=', $lastYear->format("Y-m-d"))
							->where('DATE_FORMAT(created_at, "%Y-%m-%d") <=', $today->format('Y-m-d'))
							->get('sales_description')
							->result();
		
		$data = $this->initDates("month", $lastYear, $today, 'Y M');
	
		foreach ( $sales as $sale) {

			$totalSales = $sale->price * $sale->quantity;
			$totalProfit = ($sale->price - $sale->capital) * $sale->quantity;
			$data['sales'][date("Y M", strtotime($sale->created_at))] += $totalSales >= 0 ? $totalSales : 0;
			$data['profit'][date("Y M", strtotime($sale->created_at))] += $totalProfit >= 0 ? $totalProfit : 0;
		}

		$data['labels'] = array_keys($data['sales']);
		$data['sales'] = array_values($data['sales']);
		$data['profit'] = array_values($data['profit']);

		echo json_encode($data);
	}

	public function getWeeklySales() {
		
	 
		$lastHalfQuarter = new DateTime( date("Y-m-d", strtotime("-24 weeks")) );
		$today = new DateTime( date("Y-m-d") );
		$sales = $this->db->where("DATE_FORMAT(created_at, '%Y-%m-%d') >=", $lastHalfQuarter->format('Y-m-d'))
							->where('DATE_FORMAT(created_at, "%Y-%m-%d") <=', $today->format('Y-m-d'))
							->get('sales_description')
							->result();

		$data = $this->initDates("weeks", $lastHalfQuarter, $today, 'Y-m-d');
	 
		foreach ( $data['sales'] as $key => $row) {
			
		 
			$start = (new DateTime($key))->modify('-7 days')->format('Y-m-d');
			$end = date("Y-m-d", strtotime($key));
 
			foreach ( $sales as $sale) {

				$saleDate = strtotime($sale->created_at);

				if ( $saleDate >= strtotime($start) && $saleDate <= strtotime($end) ) {
					
					$totalSales = $sale->quantity * $sale->price;
					$totalProfit = ($sale->price - $sale->capital) * $sale->quantity;
					$data['sales'][$key] += $totalSale >= 0 ? $totalSales : 0;	
					$data['profit'][$key] += $totalProfit >0 ? $totalProfit : 0;
				}	
			
			}

		}
		
		$data['labels'] = array_keys($data['sales']);
		$data['sales'] = array_values($data['sales']);
		$data['profit'] = array_values($data['profit']);
		echo json_encode($data);
	}

	public function getTodaysSales() {

		$date = date("Y-m-d");
		$sales = $this->db->select("SUM(quantity * price) as total")
							->from('sales_description')
							->where('DATE_FORMAT(created_at, "%Y-%m-%d") =', $date)
							->get()
							->row();

		foreach ($sales as $sale) {

			$created_at = strtotime($sale->created_at);
		}
	 
		return currency() . number_format($sales->total,2) ?? 0; 

	}

	public function bestSales() {

		$year = date('Y');
		$sales = $this->db->query('
					SELECT SUM(price * quantity) as total
					FROM sales_description
					GROUP BY DATE_FORMAT(created_at, "%'.$year.'-%m-%d")
					ORDER BY total DESC
					LIMIT 1
				')->row();
	 
		return currency() . number_format($sales->total,2) ?? 0; 
	}

	public function allTimeSales() {
		
		$sales = $this->db->select("SUM(price * quantity) as total")
							->from('sales_description') 
							->get()
							->row();
	 
		return currency() . number_format($sales->total,2) ?? 0;
	}

	public function getTodaysProfit() {

		$date = date("Y-m-d");
		$profit = $this->db->select("SUM((price - capital) * quantity) as total")
							->from('sales_description')
							->where('DATE_FORMAT(created_at, "%Y-%m-%d") =', $date)
							->get()
							->row();
	 
		return currency() . number_format($profit->total,2) ?? 0;
	}

	public function getDailySales() {

		$today = new DateTime(date('Y-m-d'));
		$last30Days = new DateTime(date('Y-m-d', strtotime('-20 days')));
 
		$sales = $this->db->where('DATE_FORMAT(created_at, "%Y-%m-%d") >=', $last30Days->format("Y-m-d"))
							->where('DATE_FORMAT(created_at, "%Y-%m-%d") <=', $today->format("Y-m-d"))
							->get('sales_description')
							->result();
	 
		$data = $this->initDates("day", $last30Days, $today);
 
		foreach ( $sales as $sale) {

			$data['sales'][date("M j", strtotime($sale->created_at))] += $sale->quantity * $sale->price;
			$data['profit'][date("M j", strtotime($sale->created_at))] += ($sale->price - $sale->capital) * $sale->quantity;
		} 

		return $data;
	}

	public function initDates($interval, $from, $to, $format = "M j") {

		$sales = array();
		$profit = array();
		
		for ( $i = $from; $i <= $to; $i->modify('+1 ' . $interval)) {
 
			$sales[$i->format($format)] = 0;
			$profit[$i->format($format)] = 0;
		}

		return array(
			'sales' => $sales,
			'profit' => $profit
		);
	}
 

	public function receipt($transaction_number) {

 		$sales = $this->db->where('transaction_number', $transaction_number)->get('sales')->row();

 		if (!$sales)
 			return `Could not find sales with transaction number: $transaction_number`;

 		$orderline = $this->db->where('transaction_number', $sales->transaction_number)->get('sales_description')->result();
 		$sales_person = $this->db->where('id', $sales->user_id)->get('users')->row();
 		$sales_person = $sales_person ? $sales_person->name : "Not found";

 		$data['total'] = 0;
 		$data['discount'] = 0;
 		$data['sale'] = $sales;
 		$data['orderline'] = $orderline;
 		$data['sales_person'] = $sales_person;

		$this->load->view('sales/receipt', $data);
	} 
 

	public function sales () {
		$data['widget_column'] = is_admin() ? 4 : 6; 
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

		$data = (object) array();
  
		if ( $range == "week") {

			$dataset = (object) array();
			$day = date('w');
			$week_end = date("Y-m-d");
			$week_start = date("Y-m-d", strtotime("-7 days"));
	 
            
			$start = new DateTime($week_start);
			$end = new DateTime($week_end);
 
			$sales = $this->db->where('DATE_FORMAT(created_at, "%Y-%m-%d") >=', $week_start)
							->where('DATE_FORMAT(created_at, "%Y-%m-%d") <=', $week_end)
							->get('sales_description')
							->result();
		  
			for ( $i = $start; $i <= $end; $i->modify('+1 day') ) {

				$date = $i->format('Y-m-d');
				$totalSales = 0;

				foreach ($sales as $sale) {

					$saleDate = date('Y-m-d', strtotime($sale->created_at));

					if ( $date == $saleDate) {

						$totalSales += $sale->quantity * $sale->price;
					}
				}

				$data[$date] = $totalSales;
			}
			 
		} else if ( $range == "month") {

			$end = date("Y-m");
			$start = date("Y-m", strtotime("-12 months")); 

			$sales = $this->db->where('DATE_FORMAT(created_at, "%Y-%m") >=', $start)
							->where('DATE_FORMAT(created_at, "%Y-%m") <=', $end)
							->get('sales_description')
							->result();
			$months = array('January', 'February', 'March', 'April','May','June','July','August','September','October','November','December');
			for ($i = 1; $i <= 12; $i++) {

				$totalSales = 0;
				foreach ($sales as $sale ) {

					$month = date("m", strtotime($sale->created_at));

					if ( (int)$month == $i) {
						$totalSales += $sale->quantity * $sale->price;
					} 

				}
				
				$data[$months[$i - 1]] = $totalSales;
			}

		} else if ( $range == "year") {
			$start = 2019;
			$end = date("Y");

			$sales = $this->db->where("DATE_FORMAT(created_at,'%Y') >=", $start)
							->where("DATE_FORMAT(created_at,'%Y') <=", $end)
							->get('sales_description')
							->result();
			
			for ($i = $start; $i <= $end; $i++) {

				$totalSale = 0;
				foreach ($sales as $sale) {

					$year = date("Y", strtotime($sale->created_at));

					if ( $year == $i) {

						$totalSales += $sale->quantity * $sale->price;
					}
				}

				$data[$i] = $totalSales;
			}
		}

		return $data;
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

	public function getSalesDescription($transaction_number) {
		 
		return $this->db->where('transaction_number', $transaction_number)->get('sales_description')->result();
 
	}

	public function insert() {
		$data = [];
		$sales = $this->input->post('sales');
		$this->load->model("PriceModel");
		$this->db->trans_begin();

		$last_sales_id = $this->db->select_max('id')->get('sales')->row()->id;
		$transaction_number = "TRN" . sprintf("%04s", ((int)$last_sales_id + 1 )  ); 
		$this->load->model('InventoryModel');
		$this->db->insert('sales',array(
			'date_time' => get_date_time(),
			'user_id' => $this->session->userdata('id'),
			'transaction_number' => $transaction_number
		));

		$sales = $this->security->xss_clean($sales);
	 
		foreach ($sales as $sale) {
			$transactionProfit = 0;
			$data[] = array(
				'barcode' => $sale['id'],
				'quantity' => $sale['quantity'],
				'transaction_number' => $transaction_number,
				'price' => $sale['price'],
				'name' => $sale['name'],
				'discount' => $sale['discount'],
				'profit' => $transactionProfit,
				'user_id' => $this->session->userdata('id'),
				'created_at' => get_date_time(),
				'capital' => $sale['capital'],
				'item_id' => $sale['id']
			); 
			$this->InventoryModel->insert( $sale['id'], $sale['quantity'], $sale['name'], $sale['currentStocks'], 'sell', $sale['price'], $sale['capital'] );
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
			$sales_description = $this->db->where('transaction_number', $sale->transaction_number)->get('sales_description')->result();
			$sub_total = 0;

			foreach ($sales_description as $desc) {
		 	 
		 		$user = $this->db->where('id', $desc->user_id)->get('users')->row();
		 		$staff = $user ? $user->username : 'Not found';
				$sub_total += ((float)$desc->quantity * (float) $desc->price) - $desc->discount;
				$saleProfit = ($desc->price - $desc->capital) * ($desc->quantity) - $desc->discount;
				$transactionProfit += $saleProfit;
				$datasets[] = array(
					date('Y-m-d h:i:s A', strtotime($sale->date_time)),
					$desc->name,
					$desc->quantity,
					$desc->returned,
					'₱' . number_format($desc->capital,2),
					'₱' . number_format($desc->price,2),
					'₱' . number_format($desc->discount,2),
					'₱'. number_format(((float)$desc->quantity * (float)$desc->price) - $desc->discount, 2),
					'₱' . number_format($saleProfit, 2)
				);

				$goodsCost += ($desc->capital * $desc->quantity);
			}

			$totalSales += $sub_total; 
			
		}

		$gross = $totalSales - $goodsCost;

		echo json_encode(array(
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
			'net' => number_format($gross - $totalExpenses,2 )
		));

	}

	public function destroy($id) {
		$sale = $this->db->where('id', $id)->get('sales_description')->row();
		$this->load->model('OrderingLevelModel');
		
		$this->db->trans_start();
		$this->OrderingLevelModel->addStocks($sale->item_id, $sale->quantity);
		$this->db->where('id', $id)->delete('sales_description');

		if ($this->db->trans_status() === FALSE) {

			$this->db->session->setFlashdata($errors);
			return $this->db->trans_rollback();
		} 
		
		//Do more stuff
		$this->db->session->setFlashdata($success);
		$this->db->trans_commit();
		
	          
		

 
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
 
		$sales_description = $this->db->where('transaction_number', $transaction_number)
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
			$datasets[] = (object) array(
				$item->id,
				$item->name,
				$price,
				$desc->quantity,
				$sub_total
			);
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
								->join('sales_description', 'sales_description.transaction_number = sales.transaction_number')
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
					currency() . number_format($sale->sub, 2),
					'<a 
						class="btn btn-primary btn-sm" 
						target="popup" 
						onclick="window.open(\''.base_url('SalesController/receipt/' . $sale->transaction_number).' \', \'popup\', \'width=800,height=800\' )">
					 	View Receipt
						</a>'
				];
		}



		echo json_encode(array(
			'draw' => $this->input->post('draw'),
			'recordsTotal' => $count,
			'recordsFiltered' => $count,
			'data' => $datasets,
		));

	}
}
?>