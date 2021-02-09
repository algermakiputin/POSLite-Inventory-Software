<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CreditsController extends CI_Controller {

	public function reports() {

		$data['content'] = "credits/reports";
		$dat['title'] = "Credits";
		$this->load->view('master', $data);

	}

	public function credits_datatable() {

		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]');
		$customer_id = $this->input->post('columns[0][search][value]');     

		$credits = $this->db->where('customer_id', $customer_id)
									->get('credits')
									->result();

		$dataset = [];

		foreach ( $credits as $credit ) {

			$dataset[] = [
				$credit->date,
				$credit->name,
				$credit->transaction_number,
				$credit->due_date,
				""
			];
		}

		echo json_encode([
			'draw' => $this->input->post('draw'),
			'recordsTotal' => count($credits),
			'recordsFiltered' => count($credits),
			'data' => $dataset, 
		]);
	}
}