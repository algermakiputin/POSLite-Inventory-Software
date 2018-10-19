<?php
class Pages extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}
	public function inventory () {
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

	public function new_item() {
		$this->load->model('categories_model');
		$data['category'] = $this->categories_model->getCategoriesName();
		$data['page'] = 'new_item';
		$this->load->view('header',$data);
		$this->load->view('side_menu');
		$this->load->view('items/new',$data);
		$this->load->view('footer');
	}

	public function sales () {
		$data['page'] = 'sales';
		$this->load->view('header',$data);
		$this->load->view('side_menu');
		$this->load->view('sales_report_nav_view');
		$this->load->view('footer');
	}

	public function categories() {
		$this->load->model('categories_model');
		$data['categoryList'] = $this->categories_model->getCategories();
		$data['page'] = 'categories';
		$this->load->view('header',$data);
		$this->load->view('side_menu');
		$this->load->view('categories/index',$data);
		$this->load->view('footer');
	}

	public function accounts () {
		$data['page'] = 'accounts';
		$this->load->model('accounts_model');
		$data['accountsList'] = $this->accounts_model->display_accounts();
		$this->load->view('header',$data);
		$this->load->view('side_menu');
		$this->load->view('accounts_view',$data);
		$this->load->view('footer');
	}

	public function lagout () {
		echo 'lagout';
	}
}

?>