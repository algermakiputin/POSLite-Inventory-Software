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
		$this->form_validation->set_rules("type",'Name' , "required|max_length[100]");
		$this->form_validation->set_rules("cost", 'Cost' ,"required|max_length[50000]");
		$this->form_validation->set_rules("date", 'Date' ,"required|max_length[100]");

		if ($this->form_validation->run()) {
			$this->db->insert('expenses', [
				'type' => $this->input->post('type'),
				'cost' => $this->input->post('cost'),
				'date' => $this->input->post('date'),

			]);
			$this->session->set_flashdata("success", "Expense added successfully");
		}

	 
		return redirect(base_url("expenses/new"));
	}
}