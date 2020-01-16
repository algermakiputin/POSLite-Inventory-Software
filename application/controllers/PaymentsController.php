<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PaymentsController extends CI_Controller {

	public function add_payment($id) {

		$credit = $this->db->where('transaction_number', $id)->get('sales')->row(); 
		if ( !$credit ) return redirect('/');

		$paid = $this->db->select("SUM(amount) as total")->from("payments")->where('sales_id', $credit->id)->get()->row();
 

		$data['content'] = "payments/index";
		$data['credit'] = $credit;
		$data['paid'] = $paid->total ? $paid->total : 0;
		$data['grand_total'] = $credit->total ? $credit->total : 0;


		$this->load->view('master', $data);
	}


	public function store() {
 
		$id = $this->input->post('id');
		$amount = $this->input->post('amount');
		$note = $this->input->post('note');
		$date = $this->input->post('date');
		$status = $this->input->post('status');

		$this->db->insert('payments', [
				'sales_id' => $id,
				'amount' => $amount,
				'note' => $note,
				'date' => $date
			]);

		if ($status == 1) {
			$this->db->where('id', $id)->update('sales',['status' => 1]);
		}
  		
  		success("Payment added successfully");

  		return redirect('credits');

	}
}