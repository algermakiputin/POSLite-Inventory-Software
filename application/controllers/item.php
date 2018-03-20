<?php
class Item extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}
	public function item_con() {
		if ($this->input->post('submit_item')) {
				date_default_timezone_set('Asia/Manila');
				$datestring = '%Y-%m-%d %h:%i:%s %a';
				$time = time();
				$date_time = mdate($datestring, $time);
				$name = $this->input->post('item_name');
				$category = $this->input->post('category');
				$description = $this->input->post('description');
				$creator = 'admin';
				$quantity = 0;
				$price = $this->input->post('price');
				$this->form_validation->set_rules('item_name', 'Item Name', 'required|min_length[3]');
				$this->form_validation->set_rules('description', 'Description', 'required|max_length[100]');
				$this->form_validation->set_rules('price', 'Price', 'required|integer');
				if($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">'.validation_errors() . '</div>');
					redirect('new_item');
				}else if ($category === 'Select Any') {
					$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Please Select A Category </div>');
					redirect(base_url('new_item'));
				}else {
					$this->load->model('item_model');
					$this->item_model->insertItem($name, $category, $description, $date_time, $creator, $quantity, $price);
				}
			}else {
				redirect(base_url('new_item'));
			}
		 
	}

	public function delete($id){
		$this->load->model('item_model');
		$del_item = $this->item_model->deleteItem($id);
		if ($del_item) {
			$this->session->set_flashdata('successMessage', '<div class="alert alert-success">Item Deleted</div>');
			redirect(base_url('inventory'));
		}else {
			$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opps Something Went Wrong</div>');
			redirect(base_url('inventory'));
		}
	}

	public function stock_in($item_name) {
		$data['item_name'] = $item_name;
		$this->load->model('item_model');
		$data['item_info'] = $this->item_model->item_info(urldecode($item_name));
		$this->load->view('header');
		$this->load->view('side_menu');
		$this->load->view('stock_in_view',$data);
		$this->load->view('item_info',$data);
		$this->load->view('footer');
	}

	public function add_stocks() {
		if ($this->input->post('submit_stocks')) {
			if ($this->input->post('item_name')) { 
				$itemName = $this->input->post('item_name');
				$stocks = $this->input->post('stocks');
				$this->form_validation->set_rules('stocks','Stocks','required|integer');
				if($this->form_validation->run() === FALSE) {
					$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">' .validation_errors() . '</div>');
					redirect(base_url("item/stock_in/$itemName"));
				}else {
					$name = urldecode($itemName);
					$this->load->model('item_model');
					$update = $this->item_model->add_stocks($name,$stocks);
					if ($update) {
						$this->session->set_flashdata('successMessage', '<div class="alert alert-info">Stocks Added</div> ');
						redirect(base_url('inventory'));
						
					}else {
						$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opps Something Went Wrong Please Try Again</div> ');
						redirect(base_url('inventory'));
					}
				}
			}
		}else {
			redirect(base_url('inventory'));
		}
	}

	public function update($name) {
		$this->load->model('categories_model');
		$data['category'] = $this->categories_model->getCategoriesName();
		$this->load->model('item_model');
		$data['item'] = $this->item_model->item_info($name);
		$this->load->view('header');
		$this->load->view('side_menu');
		$this->load->view('item_update_view.php',$data);
		$this->load->view('footer');
	}

	public function item_update($id) {
		$this->load->model('item_model');
		$this->form_validation->set_rules('update_name', 'Item Name', 'required');
		$this->form_validation->set_rules('update_name', 'Item Name', 'required');
		$this->form_validation->set_rules('update_name', 'Item Name', 'required');
		$this->form_validation->set_rules('update_name', 'Item Name', 'required');

		$current_name = $this->input->post('current_name');
		$current_category = $this->input->post('current_category');
		$current_description = strtolower($this->input->post('current_description'));
		$current_price = $this->input->post('current_price');

		$updated_name = $this->input->post('update_name');
		$updated_category = $this->input->post('update_category');
		$updated_desc = strtolower($this->input->post('update_description'));
		$updated_price = $this->input->post('update_price');

		if ($current_name === $updated_name && $current_category === $updated_category && $current_price === $updated_price && $current_description === $updated_desc) {
			$this->session->set_flashdata('successMessage', '<div class="alert alert-info">No Changes</div>');
					redirect(base_url('inventory'));
		}else {
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opss Something Went Wrong Updating The Item. Please Try Again.</div>');
					redirect(base_url('inventory'));
			}else {
				$this->load->model('item_model');
				$update = $this->item_model->update_item($id,$updated_name,$updated_category,$updated_desc,$updated_price);
				if ($update) {
					$this->session->set_flashdata('successMessage', '<div class="alert alert-success">Item Updated</div>');
					redirect(base_url('inventory'));
				}
			}
		}		
	}

}