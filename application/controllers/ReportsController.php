<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReportsController extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->library("DataTable"); 
	}

	public function index() {

		$data['content'] = "reports/index";
		$data['total_sales'] = 0;
		$this->load->view('master', $data);
	}

	public function details($id) { 

		$sales = $this->db->where('id', $id)->get('sales')->row();
 
		if (!$sales)
			return redirect('/');

		$orderline = $this->db->Where('sales_id', $sales->id)->get('sales_description')->result();

		$data['content'] = "reports/details";
		$data['sales'] = $sales;
		$data['orderline'] = $orderline;
		$data['total'] = 0;

		$this->load->view('master', $data);

	}

	public function description_datatable() {
		$draw = $this->input->post('draw');
		
		$start = $this->input->post('start');
		$limit = $this->input->post('length');

		$description = $this->get_sales($start, $limit, null, null);

		$columns = [
			'transaction_number' => "Transaction Number",
			'date_time' => "Date",
			'username' => "Username",
			'total' => 'Total',
		];

		$data_count = $this->db->where('type !=', 'invoice')->get('sales')->num_rows(); 

		echo $this->datatable->format($draw, $description, $columns, $data_count);

	}

	public function product_sales_datatable() {
		$draw = $this->input->post('draw');
		
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$from = $this->input->post('[columns][0][search][value]');
		$to = $this->input->post('[columns][1][search][value]');

		$product_sales = $this->get_product_sales($from, $to);
		$total = 0;
		foreach ($product_sales as $product) {
			$total += $product->total;
			$product->total = currency() . number_format($product->total,2);
			$product->price = currency() . number_format($product->price,2);
			
		}
		$columns = [
			'item_id' => "Item ID",
			'name' => "Product Name",
			'sold' => "Qty Sold",
			'price' => 'Unit Cost',
			'total' => "Total"
		];

		$data_count = $this->db->where('type !=', 'invoice')->get('sales')->num_rows(); 

		echo $this->datatable->format($draw, $product_sales, $columns, $data_count, ['total' => currency() . number_format($total,2)]); 
	}

	public function best_seller_datatable() {
		$draw = $this->input->post('draw');
		
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$from = $this->input->post('[columns][0][search][value]');
		$to = $this->input->post('[columns][1][search][value]');

		$product_sales = $this->get_best_seller_products($from, $to);
		$total = 0;
		foreach ($product_sales as $product) {
			$total += $product->total;
			$product->total = currency() . number_format($product->total,2);
			$product->price = currency() . number_format($product->price,2);
			
		}
		$columns = [
			'item_id' => "Item ID",
			'name' => "Product Name",
			'sold' => "Qty Sold",
			'price' => 'Unit Cost',
			'total' => "Total"
		];

		$data_count = $this->db->where('type !=', 'invoice')->get('sales')->num_rows(); 

		echo $this->datatable->format($draw, $product_sales, $columns, $data_count, ['total' => currency() . number_format($total,2)]); 
	}
 

	public function cash_reports() { 

		$data['content'] = "reports/cash";
		$this->load->view('master', $data);
	}

	public function cash_datatable() {
		$draw = $this->input->post('draw');
		
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$from = $this->input->post('[columns][0][search][value]');
		$to = $this->input->post('[columns][1][search][value]');
		$filter_store = $this->input->post('[columns][2][search][value]');

		$store_number = $filter_store == "" ? get_store_number() : $filter_store;
 
		$cash = $this->db->where('payment_type', 'cash')
								->where('store_number', $store_number)	
								->where('DATE_FORMAT(date_time, "%Y-%m-%d") >=', $from)
								->where('DATE_FORMAT(date_time, "%Y-%m-%d") <=', $to)
								->order_by('id', 'DESC')
								->get('sales', $start, $limit)
								->result();
		$total = 0;


		foreach ($cash as $order) {

			$order->actions = '
					<div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    	<li>
                            <a href="' . base_url("sales/details/$order->id") .'">
                                <i class="fa fa-eye"></i> View Details</a>
                        </li> 
                    </ul>
               </div>
				';

			$total += $order->total;

			$order->total = currency() . number_format($order->total,2);
		}
	 
		$columns = [
			'transaction_number' => "Item ID",
			'customer_name' => "Product Name",
			'total' => "Qty Sold",
			'note' => 'Unit Cost',
			'actions' => "Total"
		];

		$data_count = $this->db->where('payment_type', 'cash')
										->where('store_number', $store_number)	
										->where('DATE_FORMAT(date_time, "%Y-%m-%d") >=', $from)
										->where('DATE_FORMAT(date_time, "%Y-%m-%d") <=', $to)
										->get('sales')
										->num_rows(); 

		echo $this->datatable->format($draw, $cash, $columns, $data_count, ['total' => currency() . number_format($total,2)]); 
	}

	public function credits_report() {

		$data['content'] = "reports/credit";
		$this->load->view('master', $data);
	}

	public function credits_datatable() {
		$draw = $this->input->post('draw');
		
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$from = $this->input->post('[columns][0][search][value]');
		$to = $this->input->post('[columns][1][search][value]');
		$filter_store = $this->input->post('[columns][2][search][value]');
		
		$store_number = $filter_store == "" ? get_store_number() : $filter_store;

		$cash = $this->db->where('payment_type', 'credit')
										->where('store_number', $store_number)	
										->where('DATE_FORMAT(date_time, "%Y-%m-%d") >=', $from)
										->where('DATE_FORMAT(date_time, "%Y-%m-%d") <=', $to)
										->order_by('id', 'DESC')
										->order_by('id', 'DESC')
										->get('sales', $start, $limit)
										->result();
		$total = 0;

		foreach ($cash as $order) {

			$order->actions = '
					<div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    	<li>
                            <a href="' . base_url("sales/details/$order->id") .'">
                                <i class="fa fa-eye"></i> View Details</a>
                        </li> 
                    </ul>
               </div>
				';

				$order->payment_status = $order->payment_status == 0 ? "Pending Balance" : "Paid";

			$total += $order->total;
		}
	 
		$columns = [
			'transaction_number' => "Item ID",
			'customer_name' => "Product Name",
			'total' => "Qty Sold",
			'note' => 'Unit Cost',
			'payment_status' => 'Status',
 			'actions' => "Total"
		];

		$data_count = $this->db->where('type !=', 'invoice')->get('sales')->num_rows(); 

		echo $this->datatable->format($draw, $cash, $columns, $data_count, ['total' => currency() . number_format($total,2)]); 
	}

	public function products() {
		$data['content'] = "reports/products";
		$data['total_sales'] = 0;
		$data['products'] = $this->get_product_sales();
		$this->load->view('master', $data);
	}

	public function category() {
		$data['content'] = "reports/category";
		$data['total_sales'] = 0;
		$data['products'] = $this->get_category_sales();
		$this->load->view('master', $data);
	}

	public function best_seller() {
		$data['content'] = "reports/best_seller";
		$data['best_seller'] = $this->get_best_seller_products();
		$data['total_sales'] = 0;  
		$this->load->view('master', $data);
	}



	public function summary() {

	}

	private function get_best_seller_products($from = NULL, $to = NULL) {
		$from = $from == "" ? date('Y-m-d') : $from;
		$to = $to == "" ? date('Y-m-d') : $to;

		$best_seller = $this->db->select("SUM(quantity) as sold, name, price, item_id, SUM(quantity * price - discount) as total")
								->from('sales_description')
								->where('DATE_FORMAT(created_at,"%Y-%m-%d") >=', $from)
								->where('DATE_FORMAT(created_at,"%Y-%m-%d") <=', $to)
								->group_by('item_id')
								->limit(10, 0)
								->order_by('sold', 'DESC')
								->get()
								->result();
		return $best_seller;

	}

	private function get_product_sales($from = NULL, $to = NULL) {
		$from = $from == "" ? date('Y-m-d') : $from;
		$to = $to == "" ? date('Y-m-d') : $to;

		$product_sales = $this->db->select("SUM(quantity) as sold, name, price, item_id, SUM(quantity * price - discount) as total")
								->from('sales_description')
								->where('DATE_FORMAT(created_at, "%Y-%m-%d") >=', $from)
								->where('DATE_FORMAT(created_at, "%Y-%m-%d") <=', $to)
								->group_by('item_id')
								->order_by('item_id','DESC')
								->get()
								->result();
		return $product_sales;
	}


	private function get_sales($start, $limit, $from = NULL, $to = NULL) {
		$from = $from ? date('Y-m-d') : $from;
		$to = $to ? date('Y-m-d') : $to;


		return $this->db->select("sales.*, SUM(sales_description.price * sales_description.quantity - sales_description.discount) as total, users.username")

						->from('sales')
						->join('sales_description', 'sales_description.sales_id = sales.id')
						->join('users','users.id = sales.user_id')
						->where('sales.type !=', 'invoice')
						->group_by('sales.id')
						->order_by('sales.id','DESC')
						->limit($limit, $start)
						->get()
						->result();
 

	}

	

	private function get_category_sales($from = NULL, $to = NULL) {

		$from = $from == NULL ? date('Y-m-d') : $from;
		$to = $from == NULL ? date('Y-m-d') : $from;


	}
}