<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PaymentsController extends CI_Controller {

	public function add_payment($id) {

		$credit = $this->db->where('transaction_number', $id)->get('sales')->row();

		if ( !$credit ) return redirect('/');

		$data['content'] = "payments/index";
		$data['credit'] = $credit;
		$this->load->view('master', $data);
	}


	public function store() {
 
		$id = $this->input->post('id');
		$amount = $this->input->post('payment');
		$note = $this->input->post('note');
		$date = $this->input->post('date');
		

		$this->db->insert('payments', [
				'sales_id' => $id,
				'amount' => $amount,
				'note' => $note,
				'date' => $date
			]);
  		
  		success("Payment added successfully");

  		return redirect('');

	}
}