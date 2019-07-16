<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LicenseController extends CI_Controller {

	public function index() 
	{

		$data['content'] = "license/index";
		$this->load->view('master',$data);;
	}

	public function activate() {
		$data['page_name'] = "Activate";
		$this->load->view('template/header',$data); 
		$this->load->view('license/activate');
		$this->load->view('template/footer');
	}

	public function activateLicense() {
		$data = $this->input->post('data');
		
		$profile = profile();
		$serial = serial();
	 
		if (file_put_contents('./profile.txt', "serialNumber=".$serial."\nActivate=" . 1)) {
			return redirect('/');
		}
	}

}

?>