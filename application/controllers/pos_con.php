<?php

class Pos_con extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}
	public function pos(){
		$this->load->model('item_model');
		$data['names'] = $this->item_model->get_all_item();
		$this->load->view('pos_view',$data);
	}
}