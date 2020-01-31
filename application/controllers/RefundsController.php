<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RefundsController extends CI_Controller {


	public function index() {

		$data['content'] = "refunds/index";
		$this->load->view('master', $data);
	}

	public function new() {

		$data['content'] = "refunds/new";
		$this->load->View('master', $data);
	}

	public function insert() {

		$reason = $this->input->post('reason');
		$staff = $this->session->userdata('username');
		$datetime = Date('Y-m-d h:i:s');

		$sales_description_id = $this->input->post('sales_description_id[]');
		$quantities = $this->input->post('quantities[]');
		$product_names = $this->input->post('product_names[]');

		$this->db->trans_begin(); 

		$this->db->insert('returns', [
					'reason' => $reason,
					'staff' => $staff,
					'date_time' => $datetime
				]);

		$refunds_id = $this->db->insert_id();

		foreach ($sales_description_id as $key => $item_id) {

			$product = $product_names[$key];
			$qty = $quantities[$key];

			$this->db->insert('refunds_details', [
						'item_name' => $product,
						'quantity'	=>$qty,
						'refund_id'	=> $refunds_id
					]);

			$this->db->where('id', $item_id)->update('sales_description', [
						'refunded'	=> $qty
					]);
		}

		if ($this->db->trans_status() === FALSE)
		{
		   $this->db->trans_rollback();
		   errorMessage("Opps Something Went Wrong Please Try Again Later");
			return redirect('returns/new');
		}
		 
		$this->db->trans_commit();  
		success("Refund Successfully");

		return redirect('returns/new');



	}

	

}