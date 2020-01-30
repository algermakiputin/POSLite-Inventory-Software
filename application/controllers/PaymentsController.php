<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PaymentsController extends CI_Controller {

	public function add_payment() {
   
		$data['content'] = "payments/new";  
		$this->load->view('master', $data);
	}


	public function insert() {
 		
 		$invoice_number = $this->input->post('invoice_number'); 
		$amount = $this->input->post('total_amount');
		$note = $this->input->post('note');
		$date = date('Y-m-d'); 

		$this->db->insert('payments', [
				'invoice_number' => $invoice_number,
				'amount' => $amount,
				'note' => $note,
				'date' => $date
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

}