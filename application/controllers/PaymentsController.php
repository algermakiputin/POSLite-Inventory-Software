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


	public function datatable() {

		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]');
		$customer_id = $this->input->post('columns[0][search][value]');     
		$from = $this->input->post('columns[1][search][value]');  
		$to = $this->input->post('columns[2][search][value]');  

		$from = $from == "" ? date('Y-m-1') : $from;
		$to = $to == "" ? date('Y-m-t') : $to;

 		
 		$payments = $this->datatable_query($customer_id, $from, $to, $limit, $start)->result();
 		$recordsTotal = $this->datatable_query($customer_id, $from, $to, $limit, $start)->num_rows();

 		$dataset = [];

 		foreach ($payments as $payment) {

 			$dataset[] = [
 				$payment->date,
 				"<a target='__blank' href='".base_url('SalesController/customer_receipt/' . $payment->transaction_number)."'>$payment->transaction_number</a>",
 				$payment->customer_name, 
 				currency() . number_format($payment->total,2),
 				currency() . number_format($payment->payment,2),
 				'<a target="__blank" href="'. base_url('/PaymentsController/destroy/' . $payment->id). '" class="btn btn-danger delete-data btn-sm">Delete</a>'
 			];
 		}

		echo json_encode([
			'draw' => $this->input->post('draw'),
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsTotal,
			'data' => $dataset, 
		]);
	}

	public function datatable_query($customer_id, $from, $to, $limit, $start) {

		return $this->db->select('payments.*, credits.total, credits.transaction_number')
 									->from('payments') 
 									->like('payments.customer_id', $customer_id, 'BOTH')
 									->where('payments.date >=', $from)
 									->where('payments.date <=', $to)
 									->join('credits', 'credits.id = payments.credit_id')
 									->order_by('date', 'DESC')
 									->limit($limit, $start)
 									->get();
	}

	public function destroy($id) {

		$payment = $this->db->where('id', $id)->get('payments')->row();

		$this->db->set('paid', "paid - $payment->payment")->where('id', $payment->credit_id)->update('credits');
		$this->db->where('id', $id)->delete('payments');

		showErrorMessage("Payment deleted successfully");
		return redirect('reports/payments');

	}

	public function reports() {

		$data['content'] = "payments/reports";
		$this->load->view('master', $data);
	}
}