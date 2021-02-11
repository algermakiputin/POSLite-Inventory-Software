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
		$from = $this->input->post('columns[1][search][value]');  
		$to = $this->input->post('columns[2][search][value]');  

		$from = $from == "" ? date('Y-m-1') : $from;
		$to = $to == "" ? date('Y-m-t') : $to;


		$credits = $this->db->where('customer_id', $customer_id)
									->where('date >=', $from)
									->where('date <=', $to)
									->order_by('id', 'DESC')
									->get('credits')
									->result();

		$dataset = [];

		foreach ( $credits as $credit ) {

			$actions = '<div class="dropdown">
                    		<a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                    		<ul class="dropdown-menu">
                    		<li>
                            <a href="' . base_url("PaymentsController/pay/$credit->id") .'">
                                <i class="fa fa-plus"></i> Add Payment </a>
                        </li>
                         
                    		</ul>
                		</div>'; 

         $status = "<span class='label label-pill label-warning'>Unpaid</span>";

         if ( $credit->status == 1) {

         	$status = "<span class='label label-pill label-success'>Paid</span>";
      	
      	}else  if ( $credit->status == 0 && strtotime(date("Y-m-d")) > strtotime($credit->due_date)) {

      		$status = "<span class='label label-pill label-danger'>Payment Due</span>";
      	}

			$dataset[] = [
				date('Y-m-d', strtotime($credit->date)),
				$credit->name,
				"<a target='__blank' href=". base_url("SalesController/customer_receipt/" . $credit->transaction_number) .">$credit->transaction_number</a>",
				$credit->due_date,
				currency() .number_format($credit->total,2),
				currency() . number_format($credit->total - $credit->paid,2),
				$status,
				$actions
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