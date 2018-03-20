<?php
class Category Extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}
	public function index() {
		$category = $this->input->post('category');
		if (empty($category)) {
			$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Category Is Empty!</div>');
			redirect(base_url('categories'));
		}else if (strlen($category) > 50) {
			$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Category Must Not More Than 50 Characters!</div>');
			redirect(base_url('categories'));
		}else {
			$creator = 'admin';
			$this->load->model('database');
			$this->database->insertCategory($category, $creator);
		}
	}
}
?>