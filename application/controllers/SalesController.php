<?php
class SalesController extends CI_Controller {
	public function __construct() {
		
		parent::__construct();
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}

	public function sales () {
		$data['page'] = 'sales';
		$this->load->view('header',$data);
		$this->load->view('side_menu');
		$this->load->view('sales_report_nav_view');
		$this->load->view('footer');
	}

	public function daily() {
		$this->load->model('item_model');
		$this->load->model('sales_model');
		$this->load->model('PriceModel');

		$data['title'] = 'Today\'s Report';				
		$data['reports'] = $this->sales_model->daily_sales_report();
 		$data['model'] = $this->item_model;
 		$data['price'] = $this->PriceModel;
 		
		$this->load->view('header',$data);
		$this->load->view('side_menu');
		$this->load->view('sales_report_nav_view',$data);
		$this->load->view('footer');
	
	}

	public function weekly() {
		$this->load->model('sales_model');
		$this->load->model('item_model');
		$this->load->model('PriceModel');
		$data['title'] = 'This Week Report';
		$data['price'] = $this->PriceModel;
		$data['model'] = $this->item_model;
		$data['reports'] = $this->sales_model->weekly_sales_report();
		$this->load->view('header',$data);
		$this->load->view('side_menu');
		$this->load->view('sales_report_nav_view',$data);
		$this->load->view('footer');
	}

	public function monthly() {
		$this->load->model('sales_model');
		$this->load->model('item_model');
		$this->load->model('PriceModel');
		$data['title'] = 'This Month Report';
		$data['model'] = $this->item_model;
		$data['price'] = $this->PriceModel;
		$data['reports'] = $this->sales_model->monthly_sales_report();
		$this->load->view('header',$data);
		$this->load->view('side_menu');
		$this->load->view('sales_report_nav_view',$data);
		$this->load->view('footer');
	}

	public function yearly() {
		$this->load->model('PriceModel');
		$this->load->model('sales_model');
		$this->load->model('item_model');
		$data['title'] = 'This Year Report';
		$data['model'] = $this->item_model;
		$data['price'] = $this->PriceModel;
		$data['reports'] = $this->sales_model->yearly_sales_report();
		$this->load->view('header',$data);
		$this->load->view('side_menu');
		$this->load->view('sales_report_nav_view',$data);
		$this->load->view('footer');
	}
}
?>