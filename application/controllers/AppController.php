<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AppController extends CI_Controller {

	public function __construct() {
       parent::__construct();
    }

    public function userAccess($page) {

		$data = [
			'new' => ['Admin', 'Cashier'],
			'edit' => ['Admin', 'Cashier', 'Clerk'],
			'view' => ['Admin', 'Cashier', 'Clerk'],
			'customers' => ['Admin', 'Cashier', 'Clerk'],
			'expenses' => ['Admin','Cashier'],
			'user' => ['Admin'],
			'user_register' => ['Admin'],
			'new_delivery' => ['Admin'],
			'delivery' => ['Admin'],
			'expenses_new' => ['Admin']
		];

		if (!in_array($this->session->userdata('account_type'), $data[$page])) {
			return redirect('/');
		}

	}

}
 