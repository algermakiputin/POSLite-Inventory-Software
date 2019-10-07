<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReportsController extends CI_Controller {

	public function index() {

		$data['content'] = "reports/index";
		$data['descriptions'] = $this->get_sales();
		$data['total_sales'] = 0;
		$this->load->view('master', $data);
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
		$data['products'] = $this->get_best_seller_products();
		$this->load->view('master', $data);
	}



	public function summary() {

	}

	private function get_best_seller_products($from = NULL, $to = NULL) {
		$from = $from == NULL ? date('Y-m-d') : $from;
		$to = $from == NULL ? date('Y-m-d') : $from;

		$best_seller = $this->db->select("SUM(quantity) as sold, name, SUM(quantity * price - discount) as total")
								->from('sales_description')
								->group_by('item_id')
								->limit(10, 0)
								->order_by('sold', 'DESC')
								->get()
								->result();
		return $best_seller;

	}


	private function get_sales($from = NULL, $to = NULL) {
		$from = $from == NULL ? date('Y-m-d') : $from;
		$to = $from == NULL ? date('Y-m-d') : $from;

		$sales = $this->db->select("sales.*, SUM(sales_description.price * sales_description.quantity - sales_description.discount) as total, users.username")
						->from('sales')
						->join('sales_description', 'sales_description.sales_id = sales.id')
						->join('users','users.id = sales.user_id')
						->where('DATE_FORMAT(sales.date_time, "%Y-%m-%d") >=', $from)
						->where('DATE_FORMAT(sales.date_time, "%Y-%m-%d") <=', $to)
						->group_by('sales.id')
						->order_by('sales.id','DESC')
						->get()
						->result();
		return $sales;
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