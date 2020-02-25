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

		$data['content'] = "denomination/index";
		$this->load->view('master', $data);
	}

	public function denomination_datatable() {
 
		$store_number = $this->input->post('columns[0][search][value]') == "" ? get_store_number() : $this->input->post('columns[0][search][value]');
		$fromDate = $this->input->post('columns[1][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[1][search][value]');
		$toDate = $this->input->post('columns[2][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[2][search][value]');

		$denomination = $this->db->order_by('id', 'DESC')
										->where('date <=', $toDate)
										->where('date >=', $fromDate)
										->where('store_number', $store_number)
										->get('denomination')
										->result();

		$recordsTotal = $this->db->group_by('DATE_FORMAT(date,"%Y-%m-%d")')
										->where('date >=', $toDate)
										->where('date <=', $fromDate)
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
 				
 				$edit_opening = '<li>
                         <a href="' . base_url("CashDenominationController/edit/" . $data[1]->id) .'">
                             <i class="fa fa-edit"></i> Edit Opening</a>
                     </li>';

            $edit_closing = '<li>
                         <a href="' . base_url("CashDenominationController/edit/" . $data[0]->id) .'">
                             <i class="fa fa-edit"></i> Edit Closing</a>
                     </li>';


				$history[] = [
						$data[0]->date,
						$data[0]->staff,
						currency() .number_format($data[1]->total,2),
						currency() . number_format($data[0]->total,2),
						'<div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    		'.$edit_opening.'
                    		'.$edit_closing.'
                         
                    </ul>
                </div>'
					];

			}else if (count($data) == 1) {

				$col3 = "Not set";
				$col4 = currency() . number_format($data[0]->total,2);

				$edit = '<li>
                         <a href="' . base_url("CashDenominationController/edit/" . $data[0]->id) .'">
                             <i class="fa fa-edit"></i> Edit Closing</a>
                     </li>';

				if ($data[0]->type != "closing") {

					$col3 = currency() . number_format($data[0]->total,2);
					$col4 = "Not Set";

					$edit = '<li>
                         <a href="' . base_url("CashDenominationController/edit/" . $data[0]->id) .'">
                             <i class="fa fa-edit"></i> Edit Opening</a>
                     </li>';
				} 
 

				$history[] = [
						$data[0]->date,
						$data[0]->staff,
						$col3,
						$col4,
						'<div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                   		'.$edit.'
                         
                    </ul>
                </div>'
					];
			}  
		}  
		
		echo json_encode([
			'draw' => $this->input->post('draw'),
			'recordsTotal' => count($datasets),
			'recordsFiltered' => $recordsTotal,
			'data' => $history
		]);
 
	}

	public function edit($id) {

		$denomination = $this->db->where('id', $id)->get('denomination')->row();
		$cash = $this->db->where('denomination_id', $denomination->id)->get('cash_denomination')->row_array();
 
		$data['denomination'] = $denomination;
		$data['cash'] = $cash;
		$data['content'] = "denomination/edit";
		$this->load->view('master', $data);
	}

	public function update() {

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
			
		]; 

		$total = $this->input->post('total');

		$denomination_id = $this->input->post('denomination_id');

		$this->db->where('id', $denomination_id)
					->update('denomination', ['total' => $total]);
		$update = $this->db->where('denomination_id', $denomination_id)
					->update('cash_denomination', $data);

		if ($update)  success("Updated Successfully"); 
		else errorMessage("Opps something went wrong please try agian later");
		 
		return redirect('denomination');


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
			
		];


		$this->db->trans_begin(); 

		$this->db->insert('denomination', $info);
		$id = $this->db->insert_id();

		$data['denomination_id'] = $id;

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