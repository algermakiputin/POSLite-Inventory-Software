<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReportsController extends CI_Controller {


	public function index() {

		$data['content'] = "refunds/index";
		$this->load->view('master', $data);
	}

}