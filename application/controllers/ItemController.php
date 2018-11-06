<?php
class ItemController extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	
	}

	public function items () {
		$this->load->model('database');
		$this->load->model('PriceModel');
		$this->load->model('OrderingLevelModel');
		$data['items'] = $this->database->itemList();
		$data['page'] = 'inventory';
		$data['price'] = $this->PriceModel;
		$data['orderingLevel'] = $this->OrderingLevelModel;
		$this->load->view('header',$data);
		$this->load->view('side_menu');
		$this->load->view('items/items_view',$data);
		$this->load->view('footer');
	}

	public function new() {
		$this->load->database();
		$this->load->model('categories_model');
		$data['category'] = $this->categories_model->getCategoriesName();
		$data['suppliers'] = $this->db->get('supplier')->result();
		$data['page'] = 'new_item';
		$this->load->view('header',$data);
		$this->load->view('side_menu');
		$this->load->view('items/new',$data);
		$this->load->view('footer');
	}

	public function insert() {

		if ($this->input->post('submit_item')) {
			$this->load->model('PriceModel');
			$name = $this->input->post('item_name');
			$category = $this->input->post('category');
			$description = $this->input->post('description');
			$supplier_id = $this->input->post('supplier_id');
			$quantity = 0;
			$price = $this->input->post('price');
			
			if( $this->new_item_validation() == FALSE) {

				$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">'.validation_errors() . '</div>');
				redirect('items/new');

			}else if ($category === '') {
				$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Please Select A Category </div>');
				redirect(base_url('items/new'));
			}else {
				$this->load->model('item_model');
				$this->load->model('OrderingLevelModel');
				$item_id = $this->item_model->insertItem($name, $category, $description,$supplier_id);
				$this->PriceModel->insert($price, $item_id);
				$this->OrderingLevelModel->insert($item_id);
				$this->session->set_flashdata('successMessage', '<div class="alert alert-success">New Item Has Been Added</div>');
				$this->session->set_flashdata('successMessage', '<div class="alert alert-success">New Item Has Been Added Successfully </div>');
				redirect(base_url('items'));
			}

		}else {
			redirect(base_url('items/new'));
		}
		 
	}

	public function new_item_validation() {
		$this->form_validation->set_rules('item_name', 'Item Name', 'required|min_length[3]');
		$this->form_validation->set_rules('description', 'Description', 'required|max_length[100]');
		$this->form_validation->set_rules('category', 'Category', 'required|max_length[100]');
		$this->form_validation->set_rules('price', 'Price', 'required');
		return $this->form_validation->run();
	}

	public function delete($id){

		$this->load->model('item_model');
		$del_item = $this->item_model->deleteItem($id);
		if ($del_item) {
			$this->session->set_flashdata('successMessage', '<div class="alert alert-success">Item Deleted</div>');
			redirect(base_url('items'));
		}else {
			$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opps Something Went Wrong</div>');
			redirect(base_url('items'));
		}
	}

	public function stock_in($id) {
		
		$this->load->model('item_model');
		$this->load->model('PriceModel');
		$this->load->model('OrderingLevelModel');

		$data['item_info'] = $this->item_model->item_info(urldecode($id));
		$data['item_id'] = $id;
		$data['price'] = $this->PriceModel;
		$data['orderingLevel'] = $this->OrderingLevelModel;

		$this->load->view('header');
		$this->load->view('side_menu');
		$this->load->view('stock_in_view',$data);
		$this->load->view('footer');
	}

	public function add_stocks() {
		$itemID = $this->input->post('item_id');
		 
		$stocks = $this->input->post('stocks');
		$this->form_validation->set_rules('stocks','Stocks','required|integer');

		if($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">' .validation_errors() . '</div>');
			redirect(base_url("items/stock-in/$itemID"));
		}else {
			 
			$this->load->model('OrderingLevelModel');
			$update = $this->OrderingLevelModel->addStocks($itemID,$stocks);

			if ($update) {
				$this->session->set_flashdata('successMessage', '<div class="alert alert-info">Stocks Added</div> ');
				redirect(base_url('items'));
				
			}else {
				$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opps Something Went Wrong Please Try Again</div> ');
				redirect(base_url('items'));
			}
		}
	}

	public function update($name) {

		$this->load->model('categories_model');
		$this->load->model('PriceModel');
		$this->load->model('item_model');
		$data['category'] = $this->categories_model->getCategoriesName();
		$data['item'] = $this->item_model->item_info($name);
		$data['price'] = $this->PriceModel;
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
					redirect(base_url('items'));
		}else {
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opss Something Went Wrong Updating The Item. Please Try Again.</div>');
					redirect(base_url('items'));
			}else {
				$this->load->model('item_model');
				$this->load->model('PriceModel');
		 
				
				$this->PriceModel->update($updated_price, $id);
				
				$update = $this->item_model->update_item($id,$updated_name,$updated_category,$updated_desc,$price_id);

				if ($update) {
					$this->session->set_flashdata('successMessage', '<div class="alert alert-success">Item Updated</div>');
					redirect(base_url('items'));
				}
			}
		}		
	}

}