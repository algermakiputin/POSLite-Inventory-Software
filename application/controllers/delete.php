<?php

class Delete extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}
	public function category ($id) {
		if(empty($id)) {
			redirect(base_url('categories'));
		}else {
			$this->load->model('categories_model');
			$del = $this->categories_model->deleteCategory($id);
			if ($del) {
				$this->session->set_flashdata('successMessage','<br><div class="alert alert-success">Category Deleted</div>');
				redirect(base_url('categories'));
			}else {

				$this->session->set_flashdata('errorMessage', '<br><div class="alert alert-danger">Opps Something Went Wrong Please Try Again</div>');
			}
		}
	}
}