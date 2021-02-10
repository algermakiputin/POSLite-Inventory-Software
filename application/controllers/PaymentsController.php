<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PaymentsController extends CI_Controller {

	public function pay( $credit_id ) {

		$credit = $this->db->where('id', $credit_id)->get('credits')->row();
 
		$data['credit'] = $credit;
		$data['content'] = "payments/pay";
		$this->load->view('master', $data);
	}

	public function insert() {


		$credit_id = $this->input->post('credit_id');
		$customer_id = $this->input->post('customer_id');
		$customer_name = $this->input->post('customer_name');
		$total = $this->input->post('total');
		$payment = $this->input->post('payment');
		$date = $this->input->post('date');
		$status = $payment >= $total ? 1 : 0;
		$paid = $this->input->post('paid');

		$data = array(
			'customer_id' => $customer_id,
			'customer_name' => $customer_name,
			'date' => $date,
			'payment' => $payment,
			'credit_id' => $credit_id
		);

		$this->db->trans_begin();

		if ( $status ) {

			$this->db->where('id', $credit_id)
						->update('credits', array(
							'status' => 1, 
						));

		}

		$this->db->where('id', $credit_id)
					->update('credits', [
						'paid' => $paid + $payment
					]);

		$this->db->insert('payments', $data);
 

		if ($this->db->trans_status() === FALSE)
		{	

		        $this->db->trans_rollback();


		        showErrorMessage("Opps something went wrong. Please try again latter");
		        return redirect('reports/credits');
		}
		 
		$this->db->trans_commit(); 
		success("Payment Added Successfully");

		return redirect('reports/credits');

	}
}