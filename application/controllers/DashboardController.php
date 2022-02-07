<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");

class DashboardController extends AppController {
 	
 	public function __construct() {

 		parent::__construct();

 		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
 	}

	public function dashboard() {
  
 		$this->load->model('SalesModel');
		$this->load->model('ExpensesModel');
		$this->load->model('ItemModel');

 		$yesterday = date('Y-m-d', strtotime("-1 day"));
 		$lastweek = date('Y-m-d', strtotime('-30 days'));
 		$today = date('Y-m-d');

		$data['content'] = 'dashboard/dashboard';
		$data['dataset'] = json_encode( $this->line_chart( $today ) ); 
		$data['yesterday'] = json_encode( $this->line_chart( $yesterday ) );
		$data['top_products'] = $this->top10_product();
		$data['not_selling'] = $this->not_selling_products( $lastweek )->num_rows();
		$data['low_stocks'] = count(low_stocks());
		$data['average_sales_per_day'] = $this->average_sales_per_day();
		$data['no_stocks'] = count(noStocks());

		$daily_expenses = $this->ExpensesModel->daily_expenses()->total;
		$daily_sales = $this->SalesModel->daily_sales(date('d'))->total;

		$data['orders'] = $this->db->where('date_format(date_time, "%Y-%m-%d") =', date('Y-m-d'))->get('sales')->num_rows();
		$data['sales'] = number_format($this->SalesModel->get_sales(date('Y-m-d'))->total,2);
		$data['expenses'] =  number_format($daily_expenses, 2);
		$data['inventory_value'] = number_format( $this->ItemModel->inventory_value(), 2);
		$data['categories'] = array_column($this->inventoryAllocation(),'name');
		$data['total'] = array_column($this->inventoryAllocation(), 'total');
  
		$this->load->view('master', $data);
	}
 	 
	public function diagnoses() {

		$lastweek = date('Y-m-d', strtotime('-30 days'));
		$data['content'] = "dashboard/diagnoses";
		$data['not_selling'] = $this->not_selling_products($lastweek)->result();
		$data['out_of_stocks'] = noStocks();
		$data['low_stocks'] = low_stocks();
		$data['active'] = $this->input->get('active');
		$this->load->view('master', $data);
	}

	private function top10_product() {

		$date = date('Y-m');

		$sales = $this->db->select('SUM(sales_description.quantity) as qty, sales_description.name, ordering_level.quantity as quantity')
								->from('sales_description')
								->join('ordering_level', 'ordering_level.item_id = sales_description.barcode', 'left')
								->group_by('sales_description.barcode')
								->where('DATE_FORMAT(sales_description.created_at, "%Y-%m") =', $date)
								->where('sales_description.quantity >=', 1)
								->order_by('qty', "DESC")
								->limit(10)
								->get()
								->result();

		return $sales;

	} 

	public function average_sales_per_day() {

		$total = 0;
		$average_sales_per_day = 0;
		$last_month = date('Y-m-d', strtotime('-30 days'));


		$total = $this->db->select("SUM(sales_description.price * sales_description.quantity) as total")
					->from('sales_description')
					->where('DATE_FORMAT(created_at, "%Y-%m-%d") >', $last_month)
					->get()
					->row()
					->total;
	 
		
		if ( !$total ) 
			return "Not enough data";
  

		return  currency() . number_format($total / 30 ,2);
   
	}

	public function inventoryAllocation() {

		$categories = $this->db->select("DISTINCT SUM(items.capital *  ordering_level.quantity) as total, categories.name")
								->from('items')
								->join('ordering_level', 'ordering_level.item_id = items.id')
								->join('categories', 'categories.id = items.category_id')
								->order_by('total')
								->group_by('category_id')
								->limit(5)
								->get()
								->result();
		return $categories;
	}

	public function not_selling_products($lastweek) {

		/*
			1. Query Sold products last month
			2. Select All products that are not in the selling products
			3. Return the Query

		*/
		$selling_products = $this->db->select('barcode')
												->where('DATE_FORMAT(created_at, "%Y-%m-%d") >=', $lastweek)
												->get('sales_description')
												->result();


		if ( $selling_products )  {

			$selling_products = array_column($selling_products, 'barcode');

			$not_selling_products = $this->db->select("items.*, ordering_level.quantity")
													->from('items')
													->join('ordering_level', 'ordering_level.item_id = items.id')
													->where_not_in('items.id', $selling_products)
													->get();
		}else {

			$not_selling_products = $this->db->select("items.*, ordering_level.quantity")
													->from('items')
													->join('ordering_level', 'ordering_level.item_id = items.id') 
													->get();
		}
		
		
		return $not_selling_products;

	 
	}

	public function line_chart($date = null) {

		$date = $date ? $date : date('Y-m-d');

		$sales = $this->db->select("date_format(sales.date_time, '%H.%i') as time, sales.id,sales.id, SUM(sales_description.price * sales_description.quantity) as total_sales")
								->from('sales')
								->join('sales_description', 'sales_description.transaction_number = sales.transaction_number', 'LEFT')
								->where('date_format(sales.date_time, "%Y-%m-%d") =', $date)
								->group_by('sales.id')
								->order_by('time', 'ASC')
								->get()
								->result(); 
	 
		$total_sales = 0;

		$points = 26;
		$current_time = date('H') + 1.99;
		if ($date == date('Y-m-d'))
			$points = $current_time;

		$dataset = [];


		for ($y = 0; $y < $points; $y++) {

			$dataset[$y] = 0;
		}

 	
 		$time_slots = [0.0, 0.59, 1.59, 2.59, 3.59, 4.59, 5.59, 6.59, 7.59, 8.59, 9.59, 10.59, 11.59, 12.59, 13.59, 14.59, 15.59, 16.59, 17.59, 18.59, 19.59, 20.59, 21.59, 22.59, 24.59 ];

		foreach ($sales as $row) {
			
 		
			for ($i = 0; $i < count($time_slots); $i++) {



				$time = $row->time;
 
				if ($time >= $time_slots[$i - 1] && $time <= $time_slots[$i] && array_key_exists($i, $dataset)) {

					$dataset[$i] += $row->total_sales;
 					 
				} 
			}   
		}  


		for ($x = 1; $x < count($dataset); $x++) {

			$dataset[$x] = $dataset[$x - 1] + $dataset[$x];
		}
 

		return $dataset;
	}

}