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
		$data['categoryList'] = $this->db->order_by('id','DESC')
									->where('active',1)
									->get('categories')
									->result();
		$data['page'] = 'categories';
		$data['content'] = "categories/index";
		$this->load->view('master',$data);
		 
	}

	public function get() {
		$categories = $this->db->get('categories')->result();

		echo json_encode($categories);
	}

	public function insert() {
		$category = $this->input->post('category');
		$this->load->model('HistoryModel');
		if (empty($category)) {
			$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Category Is Empty!</div>');
			redirect(base_url('categories'));
		}else if (strlen($category) > 50) {
			$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Category Must Not More Than 50 Characters!</div>');
			redirect(base_url('categories'));
		}else { 
			$this->load->model('database');
			$this->HistoryModel->insert('Register Category: '. $category);
			$this->database->insertCategory($category);

		}
	}

	public function destroy($id) {
		if(empty($id)) {
			redirect(base_url('categories'));
		}else {
			$this->load->model('categories_model');
			$this->load->model('HistoryModel');
			$categoryName = $this->categories_model->getName($id);
			$del = $this->categories_model->deleteCategory($id);
			 
			if ($del) {
				$this->HistoryModel->insert('Deleted Category: ' . $categoryName);
				$this->session->set_flashdata('successMessage','<br><div class="alert alert-success">Category Deleted</div>');
				redirect(base_url('categories'));
			}else {

				$this->session->set_flashdata('errorMessage', '<br><div class="alert alert-danger">Opps Something Went Wrong Please Try Again</div>');
			}
		}
	}
}
?>