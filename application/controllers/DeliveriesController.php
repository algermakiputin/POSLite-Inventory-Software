<?php 

class DeliveriesController extends CI_Controller 

{

	public function index() {
		$data['page'] = "Delivery";

		$this->load->view('header',$data);
		$this->load->view('side_menu');
		$this->load->view('delivery/index',$data);
		$this->load->view('footer');
	}


}