<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class StoresController extends CI_Controller {


	public function index() {

		$data['stores'] = $this->db->get('stores')->result();
		$data['content'] = "stores/index";
		$this->load->view('master', $data);

	}
}