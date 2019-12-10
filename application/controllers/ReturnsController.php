<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");

class ReturnsController extends AppController {

	public function return() {

		$data['content'] = "return/index";
		$this->load->view('master', $data);
	}

	public function insert() {

		$barcodes = $this->input->post('barcodes');
		$names = $this->input->post('names');
		$quantities = $this->input->post('quantities');
		$reasons = $this->input->post('reasons');
		$prices = $this->input->post('prices');
		$ids = $this->input->post('ids');

		$this->db->trans_begin();

 		
 		foreach ($barcodes as $key => $barcode) {

 			$this->db->insert('returns', [
 					'barcode' => $barcodes[$key],
 					'name' => $names[$key],
 					'quantity' => $quantities[$key],
 					'staff' => $this->session->userdata('username'),
 					'reason' => $reasons[$key],
 					'date_time' => date('Y-m-d h:i:s'),
 					'price' => $prices[$key],
 					'item_id' => $ids[$key]
 				]);

 		}

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		        $this->session->set_flashdata('error', "Opps something went wrong please try agian later");
		        return redirect('return');
		}

		$this->session->set_flashdata('success', "Return saved successfully");
		 
		$this->db->trans_commit(); 
		return redirect('return');
 
	}

	public function report() {

		$data['content'] = 'return/report';
		$this->load->view('master', $data);
	}

	public function report_datatable() {

		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]'); 
		$count = $this->db->get('returns')->num_rows();
		$datasets = [];
		$total = 0;
		$from = $this->input->post('columns[0][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[0][search][value]');
		$to = $this->input->post('columns[1][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[1][search][value]');
 		 
		$returns = $this->db->where('DATE_FORMAT(date_time, "%Y-%m-%d") >=', $from)
							->where('DATE_FORMAT(date_time, "%Y-%m-%d") <=', $to) 
							->limit($limit, $start)
							->get('returns')
							->result();

		foreach ($returns as $return) {
		 
			$datasets[] = [
				date('Y-m-d', strtotime($return->date_time)),
				$return->staff,
				$return->barcode,
				$return->name,
				$return->quantity,
				currency() . number_format($return->price), 
				$return->reason, 
			]; 

			$total += $return->price * $return->quantity;
		}

		echo json_encode([
			'draw' => $this->input->post('draw'),
			'recordsTotal' => count($datasets),
			'recordsFiltered' => $count,
			'data' => $datasets,
			'total' => currency() . number_format($total,2),
		]); 
	}
}