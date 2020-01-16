<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");
class Pos_con extends AppController {

	public function __construct() {
		parent::__construct();
		$this->licenseControl();
 
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}
	public function pos(){
		 
		$this->load->model('ItemModel'); 
		$this->load->model('PriceModel');
		$this->load->model('OrderingLevelModel');
		$this->load->model('categories_model');
 
		$data['price'] = $this->PriceModel;
		$data['categoryModel'] = $this->categories_model;
		$data['orderingLevel'] = $this->OrderingLevelModel;  
 		$data['customers'] = $this->db->get('customers')->result();
 		$data['suppliers'] = $this->db->get('supplier')->result();

		$this->load->view('pos/index',$data);
	}
}