<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LicenseController extends CI_Controller {

	public function index() 
	{

		$data['content'] = "license/index";
		$this->load->view('master',$data);
	}

	public function activate() {
 
		$data['page_name'] = "Activate";
		$data['serial'] =  serial();
		$this->load->view('template/header',$data); 
		$this->load->view('license/activate');
		$this->load->view('template/footer');
	}

	public function activateLicense() {

		$data = $this->input->post('data');
		
		// $profile = profile();
		$serial = serial();
	 	
	 	$activate = base64_encode("serialNumber=".$serial.",Activate=" . 1);

		if (file_put_contents( homeDir() . '/profile.txt', $activate)) {
			$this->session->set_flashdata('successMessage','<div class="alert alert-success">Activated Successfully</div>');
			echo base_url('login');
			return;
		} 

		return "";


	}

}

?>