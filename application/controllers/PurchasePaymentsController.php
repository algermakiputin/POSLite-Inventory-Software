<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PurchasePaymentsController extends CI_Controller 
{

	private $purchase_number, $total, $staff, $date, $created_at;

	public function __construct() {
		
		parent::__construct();
		
		$this->load->model('PurchasePaymentsModel');

	}

	public function insert() {

		$data = [
				'purchase_number' => $this->input->post('purchase_number'), 
				'total' => $this->input->post('total'),
				'staff' => $this->session->userdata('username'),
				'date' => $this->input->post('date'), 
			];


		$this->db->trans_begin(); 
		
		$this->PurchasePaymentsModel->store( $data );
		$this->db->where('id', $this->input->post('purchase_id'))
					->update('delivery', ['paid' => 1]);



		if ($this->db->trans_status() === FALSE)
		{
		   errorMessage("Opps somethingw went wrong please try again later");
			return redirect('deliveries');
		}
		 
		$this->db->trans_commit();   
		success("Payment added succesfully");
		return redirect('deliveries');
		  

	}



}