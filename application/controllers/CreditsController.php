<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CreditsController extends CI_Controller { 

	public function index() {
		$data['content'] = 'credits/receivables';

		$data['credits'] = $this->db
							->select('credits.*, customers.name, SUM(sales_description.price * 	sales_description.quantity) as total')
							->from('credits')
							->join('customers', 'customers.id=credits.customer_id', 'BOTH')
							->join('sales_description', 'sales_description.sales_id=credits.sales_id', 'BOTH')
							->where('credits.paid',0)
							->group_by('credits.sales_id')
							->get()
							->result(); 
		//Get Total 
		$data['total'] = $this->db
							->select('SUM(sales_description.price * 	sales_description.quantity) as total')
							->from('credits') 
							->join('sales_description', 'sales_description.sales_id=credits.sales_id', 'BOTH')
							->where('credits.paid', 0) 
							->get()
							->row(); 
		$data['total'] = $data['total']->total;
		 
		$this->load->view('master', $data);
	}

	public function update() {

		$sales_id = $this->input->post('sales_id');
		$id = $this->input->post('credit_id');
		$this->db->where('id', $id)
				->update('credits', [
					'paid' => 1
				]);

		$this->db->where('id', $sales_id)
				->update('sales', [
					'paid' => 1
				]);

		$this->session->set_flashdata('success','Marked as paid successfully');
		return redirect('account/receivables');
	}
}


?>