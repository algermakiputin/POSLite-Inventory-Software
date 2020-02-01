<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");
class CashDenominationController extends AppController {


	public function new() {

		$data['content'] = "denomination/new";
		$this->load->view('master', $data);
	}

}