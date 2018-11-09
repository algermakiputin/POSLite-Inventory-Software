<?php
class CategoriesController Extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}

	public function categories() {
		$this->load->model('categories_model');
		$data['categoryList'] = $this->db->get('categories')->result();
		$data['page'] = 'categories';
		$data['content'] = "categories/index";
		$this->load->view('master',$data);
		 
	}

	public function insert() {
		$category = $this->input->post('category');
		if (empty($category)) {
			$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Category Is Empty!</div>');
			redirect(base_url('categories'));
		}else if (strlen($category) > 50) {
			$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Category Must Not More Than 50 Characters!</div>');
			redirect(base_url('categories'));
		}else { 
			$this->load->model('database');
			$this->database->insertCategory($category);
		}
	}
}
?>