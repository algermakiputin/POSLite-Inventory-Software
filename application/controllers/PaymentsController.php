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
}