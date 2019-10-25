<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class TransactionsController extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->library("DataTable"); 
	}
 
	public function index() {

		$data['content'] = "transactions/index";
		$this->load->view('master', $data);
	}

	public function credits_datatable() {
		$draw = $this->input->post('draw');
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]');

		$transactions = $this->db->select("sales.*, SUM(sales_description.price * sales_description.quantity) as total, users.name as username")
					->from('sales')
					->join('sales_description', 'sales_description.sales_id = sales.id', 'BOTH')
					->join('users', 'users.id = sales.user_id')
					->like('sales.customer_name', $search, 'BOTH')
					->or_like('sales.transaction_number', $search, 'BOTH')
					->group_by('sales.transaction_number')
					->where('sales.type', 'credit')
					->limit($limit, $start)
					->order_by('id', 'DESC')
					->get()
					->result();
	  
		$data_count = $this->db->where('type', 'credit')->get('sales')->num_rows();

		$columns = [ 
			'date_time' => "Date",
			'transaction_number' => "Transaction Number",
			'username' => "Sales Person",
			'customer_name' => "Customer", 
			'status' => "Status"
		];  
	
		echo $this->datatable->format($draw,$transactions, $columns, $data_count);
		 
	}
}