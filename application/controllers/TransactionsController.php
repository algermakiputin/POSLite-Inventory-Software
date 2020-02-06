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

	public function po() {

		$data['content'] = "transactions/po";
		$this->load->view('master', $data);
	}

	public function update_note() {

		$id = $this->input->post('id');
		$note = $this->input->post('note');

		$this->db->where('id', $id)->update('sales', ['note' => $note]);

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
			$transaction->status = $transaction->status ? "<span class='badge badge-success'>Complete</span>" : "<span class='badge badge-warning'>Pending</span>";
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
		$this->db->where('sales_id', $id)->delete('sales_description');
		success("Credit Deleted Successfully");

		return redirect('transactions');
	}
 
	public function view_credit($id) {
		$credit = $this->db->where('transaction_number', $id)->get('sales')->row();
		if (!$credit) return redirect('/');

		$payments = $this->db->where('sales_id', $credit->id)->get('payments')->result();
		$total_amount = $this->db->select("SUM(amount) as total")->from("payments")->where('sales_id', $credit->id)->get()->row(); 

		$orderline = $this->db->where('sales_id', $credit->id)
									->get('sales_description')
									->result();

		$data['content'] = 'customers/credit'; 
		$data['orderline'] = $orderline;
		$data['credit'] = $credit;
		$data['total'] = 0;
		$data['paid'] = $total_amount->total;
		$data['payments_history'] = $payments;
 

		
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
	  
		$data_count = $this->db->where('type', 'invoice')->get('sales')->num_rows();

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
		$data['customer'] = $this->db->where('id', $invoice->customer_id)->get('customers')->row();
		$data['preference'] = get_preferences();

		$data['orderline'] = $orderline;
		$data['invoice'] = $invoice;
		$data['total'] = 0;
		$data['paid'] = 0;
		$data['defaultRow'] = 7 - count($orderline);
		
		$this->load->view('master', $data);
	}

	public function standby_order() {

		$data['content'] = "transactions/standby";
		$this->load->view('master', $data);
	}

	public function standby_order_datatable() {
		$draw = $this->input->post('draw');
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]');

		$transactions = $this->db->select("sales.*, SUM(sales_description.price * sales_description.quantity) as total, users.name as username")
					->from('sales')
					->join('sales_description', 'sales_description.sales_id = sales.id', 'BOTH')
					->join('users', 'users.id = sales.user_id')
					->where('sales.type', 'standby')
					->like('sales.customer_name', $search, 'BOTH')  
					->or_where('sales.type', 'standby')
					->like('sales.transaction_number', $search, 'BOTH') 
					->group_by('sales.transaction_number') 
					->limit($limit, $start)
					->order_by('id', 'DESC')
					->get()
					->result();

		foreach ($transactions as $transaction) {

			$transaction->total = currency() . number_format($transaction->total,2);
			$transaction->status = $transaction->status ? "<span class='badge badge-success'>Complete</span>" : "<span class='badge badge-warning'>Pending</span>";
			$transaction->date_time = date('Y-m-d', strtotime($transaction->date_time));

			$transaction->id = '<div class="dropdown">
              <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
              <ul class="dropdown-menu">
              		<li>
                      <a href="'.base_url('standby-order/view/' . $transaction->transaction_number).'"> <i class="fa fa-eye"></i> View Details</a>
                  </li>
                  <li>
                      <a href="'.base_url('standby-order/destroy/' . $transaction->id).'" class="delete-data"> <i class="fa fa-trash"></i> Delete</a>
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
			'status' => "Status",
			'id' => 'Actions'
		];   
		echo $this->datatable->format($draw,$transactions, $columns, $data_count); 
	}

	public function destroy_standby_order($id) {

		$this->db->where('id', $id)->delete('sales');
		$this->db->where('sales_id', $id)->delete();
		success("Invoice Deleted Successfully");

		return redirect('invoice');
	}
 
	public function view_standby_order($id) {

		$transaction = $this->db->where('transaction_number', $id)->get('sales')->row();

		if (!$transaction) return redirect('/');

		$orderline = $this->db->where('sales_id', $transaction->id)
									->get('sales_description')
									->result();
 
		$data['content'] = 'transactions/standby_view'; 
		$data['orderline'] = $orderline;
		$data['products'] = json_encode($this->get_products());
		$data['transaction'] = $transaction;
		$data['total'] = 0;
		$data['paid'] = 0;
		
		$this->load->view('master', $data);
	}

	private function get_products() {
		$products = $this->db->select('items.id as data, items.name as value, prices.capital')->join('prices', 'prices.item_id = items.id')->get('items')->result();
		foreach ($products as $product) {
			$product->value = str_replace('"', '”', $product->value);
		}
		return $products;
	}

	public function update_standby_order() {
		$product_id = $this->input->post('product_id[]');
		$name = $this->input->post('product[]');
		$quantity = $this->input->post('quantity[]');
		$price = $this->input->post('price[]'); 

		$sales_id = $this->input->post('sales_id');

		$this->db->trans_begin(); 

		//Delete sales description then add it back

		$data = [];

		$this->db->where('sales_id', $sales_id)->delete('sales_description');

		foreach ($product_id as $key => $id) {

			$transactionProfit = $this->db->where('item_id', $sale['id'])->get('prices')->row()->capital;

			$data[] = [ 
				'item_id' => $id,
				'quantity' => $quantity[$key],
				'sales_id' => $sales_id, 
				'price' => $price[$key],
				'name' => $name[$key],
				'discount' => 0,
				'profit' => $transactionProfit,
				'user_id' => $this->session->userdata('id')
			];
			
			$this->db->set('quantity', "quantity - $quantity[$key]" , false);
			$this->db->where('item_id', $id);
			$this->db->update('ordering_level');
		}

		$this->db->insert_batch('sales_description', $data);

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		         $this->db->_error_message();
		        return false;
		}
		 
		$this->db->trans_commit(); 
		
		return redirect('standby-orders');



	}

	public function complete() {
		
		$this->db->where('id', $this->input->post('sales_id'))->update('sales', ['status' => 1]);
		success("Transaction completed Successfully");

		return redirect('standby-orders');
	}

	public function pdf_invoice($id = NULL) {

		$dompdf = new Dompdf\Dompdf;
		$invoice = $this->db->where('transaction_number', $id)->get('sales')->row(); 

		if (!$invoice || !$id) return  redirect('/');

		$orderline = $this->db->where('sales_id', $invoice->id)
									->get('sales_description')
									->result();


		$data['content'] = 'transactions/view_invoice'; 
		$data['orderline'] = $orderline;
		$data['invoice'] = $invoice;
		$data['total'] = 0;
		$data['paid'] = 0;
		$data['preference'] = get_preferences();
		$data['defaultRow'] = 5 - count($orderline);
		
		$html = $this->load->view('pdf/invoice', $data, TRUE);
	 	
		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portraite');
		$dompdf->render();
		$dompdf->stream();
	}

	
}