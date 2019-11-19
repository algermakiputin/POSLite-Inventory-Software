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

	private function get_product_sales($from = NULL, $to = NULL) {
		$from = $from == NULL ? date('Y-m-d') : $from;
		$to = $from == NULL ? date('Y-m-d') : $from;

		$product_sales = $this->db->select("SUM(quantity) as quantity, SUM(quantity * price - discount) as total, item_id, name, price")
								->from('sales_description')
								->where('DATE_FORMAT(created_at, "%Y-%m-%d") >=', $from)
								->where('DATE_FORMAT(created_at, "%Y-%m-%d") <=', $to)
								->group_by('item_id')
								->order_by('item_id','DESC')
								->get()
								->result();
		return $product_sales;
	}

	private function get_category_sales($from = NULL, $to = NULL) {

		$from = $from == NULL ? date('Y-m-d') : $from;
		$to = $from == NULL ? date('Y-m-d') : $from;


	}
}