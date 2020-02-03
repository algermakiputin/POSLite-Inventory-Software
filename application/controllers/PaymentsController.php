<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PaymentsController extends CI_Controller {

	public function index() {

		$data['content'] = "payments/index";
		$this->load->view('master', $data);
	}

	public function add_payment() {
   
		$data['content'] = "payments/new";  
		$this->load->view('master', $data);
	}


	public function insert() {
 		
 		$invoice_number = $this->input->post('invoice_number'); 
		$amount = $this->input->post('total_amount');
		$note = $this->input->post('note');
		$date = date('Y-m-d'); 
		$store_number = get_store_number();

		$this->db->insert('payments', [
				'invoice_number' => $invoice_number,
				'amount' => $amount,
				'note' => $note,
				'date' => $date,
				'store_number' => $store_number,
				'staff' => $this->session->userdata('username')
			]);

	 
		$this->db->where('transaction_number', $invoice_number)->update('sales',['status' => 1, 'payment_status' => 1]);
		 
  		
  		success("Payment added successfully");

  		return redirect('payments/new');

	}

	public function find_invoice() {

		$invoice_number = $this->input->post('invoice_number');
 
		$invoice = $this->db->where('transaction_number', $invoice_number)->get('sales')->row();

		if ($invoice) {

			echo json_encode($invoice);
		}else {

			echo "0";
		}

	}

	public function datatable() {

		$start = $this->input->post('start'); 
		$limit = $this->input->post('limit');
		$draw = $this->input->post('draw');
		$store_number = $this->input->post('columns[0][search][value]') == "" ? get_store_number() : $this->input->post('columns[0][search][value]');
		$fromDate = $this->input->post('columns[1][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[1][search][value]');
		$toDate = $this->input->post('columns[2][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[2][search][value]');
 		

		$refunds = $this->db->where('store_number', $store_number)
								->where('date >=', $fromDate)
								->where('date <=', $toDate)
								->get("payments")
								->result();

		$datasets = [];

		foreach ($refunds as $refund) {

			$datasets[] = [
					$refund->date,
					$refund->invoice_number,
					currency() . number_format($refund->amount, 2),
					$refund->note, 
					'<a class="btn btn-primary btn-sm" href="'.base_url('refunds/details/' . $refund->id).'">View Details</a>'
				];
		} 

		echo json_encode([
			'draw' => $draw,
			'recordsTotal' => count($datasets),
			'recordsFiltered' => count($datasets),
			'data' => $datasets 
		]);
	}

}