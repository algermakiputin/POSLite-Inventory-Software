<?php 

class ExpensesController extends CI_Controller {

	public function index() {
		$data['expenses'] = $this->db->get('expenses')->result();
		$data['content'] = "expenses/index";
		$this->load->view('master', $data);
	}

	public function new() {
		$data['content'] = "expenses/new";
		$this->load->view('master', $data);
	}

	public function insert() {
		$this->db->insert('expenses', [
				'type' => $this->input->post('type'),
				'cost' => $this->input->post('cost'),
				'date' => $this->input->post('date'),

			]);
		$this->session->set_flashdata("success", "Expense added successfully");
		return redirect(base_url("expenses/new"));
	}
}