<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ExpensesController extends CI_Controller {

	public function index() {
	 	$data['content'] = 'expenses/index';
		$this->load->view('master', $data);
	}

	public function reports() {

		$start = $this->input->post('start'); 
		$fromDate = $this->input->post('columns[0][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[0][search][value]');
		$toDate = $this->input->post('columns[1][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[1][search][value]');

		$total = $this->db->select_sum('cost')
							->from('expenses')
 							->where('date >=',  $fromDate)
							->where('date <=', $toDate)
 							->get()->row();
		$expenses = $this->db->where('date >=',  $fromDate)
							->where('date <=', $toDate)
							->get("expenses")
							->result();

		$datasets = [];

		foreach ($expenses as $expense) {

			$datasets[] = [
					$expense->type,
					$expense->name,
					currency() . number_format($expense->cost,2),
					$expense->date,
					'<a href="'.base_url("ExpensesController/destroy/") . $expense->id.'" class="btn btn-danger btn-sm">Delete</a>'
				];
		} 

		echo json_encode([
			'draw' => $this->input->post('draw'),
			'recordsTotal' => count($datasets),
			'recordsFiltered' => count($datasets),
			'data' => $datasets,
			'total' => currency() . number_format($total->cost,2)
		]);


	}

	public function new() {
		$data['content'] = "expenses/new";
		$this->load->view('master', $data);
	}

	public function insert() {
		$this->form_validation->set_rules("type",'Name' , "required|max_length[100]");
		$this->form_validation->set_rules("cost", 'Cost' ,"required|max_length[50000]");
		$this->form_validation->set_rules("date", 'Date' ,"required|max_length[100]");

		if ($this->form_validation->run()) {
			$data = $this->security->xss_clean([
				'type' => $this->input->post('type'),
				'cost' => $this->input->post('cost'),
				'date' => $this->input->post('date'),
				'name' => $this->input->post('name')

			]);
			$this->db->insert('expenses', $data);
			$this->session->set_flashdata("success", "Expense added successfully");
		}
		return redirect(base_url("expenses/new"));
	}

	public function destroy($id) {
		$id = $this->security->xss_clean($id);
		$this->db->where('id', $id)->delete('expenses');
		$this->session->set_flashdata('success', 'Deleted successfully');
		return redirect('expenses');
	}
} 