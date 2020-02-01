<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");
class CashDenominationController extends AppController {


	public function new() {

		$started = $this->validate_opening_denomination(); 
		$data['started'] = $started;
		$data['content'] = "denomination/new";
		$this->load->view('master', $data);
	}

	public function denomination() {
 
		$store_number = get_store_number();
		$denomination = $this->db->order_by('id', 'DESC')
										->where('store_number', $store_number)
										->get('denomination')
										->result();
 	 
		$datasets = [];
		$history = [];

		foreach ($denomination as $row) { 
			$datasets[$row->date][] = $row;

		}

		
		foreach ($datasets as $data) {


			if ( count($data) == 2) {
 
				$history[] = [
						'date' => $data[0]->date,
						'staff'	=> $data[0]->staff,
						'Opening Amount'	=> $data[1]->total,
						'Closing Amount'	=> $data[0]->total
					];

			}else if (count($data) == 1) {


				if ($data[0]->type == "closing") {

					$history[] = [
						'date' => $data[0]->date,
						'staff'	=> $data[0]->staff,
						'Opening Amount'	=> "Not set",
						'Closing Amount'	=> $data[0]->total
					];
				}else {

					$history[] = [
						'date' => $data[0]->date,
						'staff'	=> $data[0]->staff,
						'Opening Amount'	=> $data[0]->total,
						'Closing Amount'	=> "Not set"
					];
				}
			} 

		} 

		dd($history);
 
	}

	public function closing() {

		$started = $this->validate_closing_denomination(); 
		$data['started'] = $started;
		$data['content'] = "denomination/closing";
		$this->load->view('master', $data);
	}
	public function insert() {

		$type = $this->input->post('type');

		$info = [
			'date' => date('Y-m-d h:i:s'),
			'type'	=> $type,
			'staff' => $this->session->userdata('username'),
			'total'	=> $this->input->post('total'),
			'store_number' => get_store_number()
		];	

		$id = $this->db->insert_id();

		$data = [
			'1000_' => $this->input->post('1000'),
			'500_' => $this->input->post('500'),
			'100_' => $this->input->post('100'),
			'50_' => $this->input->post('50'),
			'10_' => $this->input->post('10'),
			'5_' => $this->input->post('5'),
			'1_' => $this->input->post('1'),
			'0_50' => $this->input->post('0_50'),
			'0_25' => $this->input->post('0_25'),
			'0_10' => $this->input->post('0_10'),
			'0_05' => $this->input->post('0_05'),
			'denomination_id' => $id
		];


		$this->db->trans_begin(); 

		$this->db->insert('denomination', $info);
		$this->db->insert('cash_denomination', $data);

		if ($this->db->trans_status() === FALSE)
		{
		   $this->db->trans_rollback();
		   errorMessage("Opps something went wrong please try again");
			
			 
		}else { 
			$this->db->trans_commit(); 
			success("Cash Denomination Registered Successfully"); 
		}

	 	
	 	if ($type == "opening")
	 		return redirect('denomination/start');


	 	return redirect('denomination/close');
	}

}