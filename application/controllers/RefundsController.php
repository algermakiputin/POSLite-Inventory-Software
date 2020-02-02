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
		$customer_name = $this->input->post('customer_name');
		$invoice_number = $this->input->post('invoice_number');

		$sales_description_id = $this->input->post('sales_description_id[]');
		$quantities = $this->input->post('quantities[]');
		$product_names = $this->input->post('product_names[]');
		$prices = $this->input->post('prices[]');

		$this->db->trans_begin(); 

		$this->db->insert('returns', [
					'reason' => $reason,
					'staff' => $staff,
					'date_time' => $datetime,
					'customer_name' => $customer_name,
					'invoice_number' => $invoice_number,
					'store_number' => get_store_number()
				]);

		$refunds_id = $this->db->insert_id();

		foreach ($sales_description_id as $key => $item_id) {

			$product = $product_names[$key];
			$qty = $quantities[$key];
			$price = $prices[$key];

			$this->db->insert('refunds_details', [
						'item_name' => $product,
						'quantity'	=>$qty,
						'refund_id'	=> $refunds_id,
						'price' => $price,

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

	public function datatable() {

		$start = $this->input->post('start'); 
		$limit = $this->input->post('limit');
		$draw = $this->input->post('draw');
		$store_number = $this->input->post('columns[0][search][value]') == "" ? get_store_number() : $this->input->post('columns[0][search][value]');
		$fromDate = $this->input->post('columns[1][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[1][search][value]');
		$toDate = $this->input->post('columns[2][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[2][search][value]');
 
		$refunds = $this->db->where('store_number', $store_number)
								->where('DATE_FORMAT(date_time, "%Y-%m-%d") >=', $fromDate)
								->where('DATE_FORMAT(date_time, "%Y-%m-%d") <=', $toDate)
								->get("returns")
								->result();

		$datasets = [];

		foreach ($refunds as $refund) {

			$datasets[] = [
					$refund->date_time,
					$refund->invoice_number,
					$refund->staff,
					$refund->customer_name,
					$refund->reason,
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

	public function details($id) {

		$refund = $this->db->where('id', $id)->get('returns')->row();

		if (!$refund) 
			return redirect('/');

		$refund_details = $this->db->where('refund_id', $refund->id)->get('refunds_details')->result();


		$data['refund'] = $refund;
		$data['details'] = $refund_details;
		$data['content'] = 'refunds/details';
		$this->load->view('master', $data);
	}

}