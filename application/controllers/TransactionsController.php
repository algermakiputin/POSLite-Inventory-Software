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
					->where('sales.type', 'credit')
					->like('sales.customer_name', $search, 'BOTH') 

					->or_where('sales.type', 'credit')
					->like('sales.transaction_number', $search, 'BOTH') 
					->group_by('sales.transaction_number')
					
					->limit($limit, $start)
					->order_by('id', 'DESC')
					->get()
					->result();

		foreach ($transactions as $transaction) {

			$transaction->total = currency() . number_format($transaction->total,2);
			$transaction->status = $transaction->status ? "Complete" : "Pending";
			$transaction->date_time = date('Y-m-d', strtotime($transaction->date_time));
			
			$transaction->id = '<div class="dropdown">
              <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
              <ul class="dropdown-menu">
              		<li>
                      <a href="'.base_url('credit/view/' . $transaction->transaction_number).'"> <i class="fa fa-eye"></i> View Details</a>
                  </li>
                  <li>
                      <a href="'.base_url('credit/destroy/' . $transaction->id).'" class="delete-data"> <i class="fa fa-trash"></i> Delete</a>
                  </li>

              </ul>
          </div>';
		}
	  
		$data_count = $this->db->where('type', 'credit')->get('sales')->num_rows();

		$columns = [  
			'transaction_number' => "Transaction Number",
			'date_time' => "Date",
			'username' => "Sales Person",
			'customer_name' => "Customer",
			'total' => "Amount", 
			'status' => "Status",
			'note' => "Note",
			'id' => 'Actions'
		];  
	
		echo $this->datatable->format($draw,$transactions, $columns, $data_count);
		 
	}

	public function destroy_credit($id) {

		$this->db->where('id', $id)->delete('sales');
		$this->db->where('sales_id', $id)->delete();
		success("Credit Deleted Successfully");

		return redirect('transactions');
	}
 
	public function view_credit($id) {
		$credit = $this->db->where('transaction_number', $id)->get('sales')->row();

		if (!$credit) return redirect('/');

		$orderline = $this->db->where('sales_id', $credit->id)
									->get('sales_description')
									->result();

		$data['content'] = 'customers/credit'; 
		$data['orderline'] = $orderline;
		$data['credit'] = $credit;
		$data['total'] = 0;
		$data['paid'] = 0;
		
		$this->load->view('master', $data);
	}

	public function invoice() {

		$data['content'] = "transactions/invoice";
		$this->load->view('master', $data);
	}

	public function invoice_datatable() {
		$draw = $this->input->post('draw');
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]');

		$transactions = $this->db->select("sales.*, SUM(sales_description.price * sales_description.quantity) as total, users.name as username")
					->from('sales')
					->join('sales_description', 'sales_description.sales_id = sales.id', 'BOTH')
					->join('users', 'users.id = sales.user_id')
					->where('sales.type', 'invoice')
					->like('sales.customer_name', $search, 'BOTH')  
					->or_where('sales.type', 'invoice')
					->like('sales.transaction_number', $search, 'BOTH') 
					->group_by('sales.transaction_number')
					
					->limit($limit, $start)
					->order_by('id', 'DESC')
					->get()
					->result();

		foreach ($transactions as $transaction) {

			$transaction->total = currency() . number_format($transaction->total,2);
			$transaction->status = $transaction->status ? "Complete" : "Pending";
			$transaction->date_time = date('Y-m-d', strtotime($transaction->date_time));

			$transaction->id = '<div class="dropdown">
              <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
              <ul class="dropdown-menu">
              		<li>
                      <a href="'.base_url('invoice/view/' . $transaction->transaction_number).'"> <i class="fa fa-eye"></i> View Details</a>
                  </li>
                  <li>
                      <a href="'.base_url('invoice/destroy/' . $transaction->id).'" class="delete-data"> <i class="fa fa-trash"></i> Delete</a>
                  </li>

              </ul>
          </div>';
		}
	  
		$data_count = $this->db->where('type', 'credit')->get('sales')->num_rows();

		$columns = [  
			'transaction_number' => "Invoice No",
			'date_time' => "Date", 
			'customer_name' => "Customer",
			'total' => "Amount",  
			'note' => "Note",
			'id' => 'Actions'
		];   
		echo $this->datatable->format($draw,$transactions, $columns, $data_count); 
	}

	public function destroy_invoice($id) {

		$this->db->where('id', $id)->delete('sales');
		$this->db->where('sales_id', $id)->delete();
		success("Invoice Deleted Successfully");

		return redirect('invoice');
	}
 
	public function view_invoice($id) {
		$invoice = $this->db->where('transaction_number', $id)->get('sales')->row();

		if (!$invoice) return redirect('/');

		$orderline = $this->db->where('sales_id', $invoice->id)
									->get('sales_description')
									->result();

		$data['content'] = 'transactions/view_invoice'; 
		$data['orderline'] = $orderline;
		$data['invoice'] = $invoice;
		$data['total'] = 0;
		$data['paid'] = 0;
		
		$this->load->view('master', $data);
	}

	
}