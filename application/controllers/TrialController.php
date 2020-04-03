<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TrialController extends CI_Controller {

	public function trial_ended() {

		$this->load->view('trial/expired');

   }

}