<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LicenseController extends CI_Controller {

	public function index() 
	{

		$data['content'] = "license/index";
		$this->load->view('master',$data);;
	}

	public function test() {
		echo "test";
	}

}
?>