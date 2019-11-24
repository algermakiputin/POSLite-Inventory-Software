<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AppController extends CI_Controller {

	public function __construct() {
 
      parent::__construct();  
    }

    public function licenseControl () {
    	  
    	if (!SITE_LIVE) {
    		if (!file_exists(homeDir() . '/profile.txt')) {
	    		return redirect('activate');
	    	}

	    	$content = profile(); 

	    	$serial = (str_replace('serialNumber=', '', $content[0]));
	    	 
	    	if (trim($serial) != trim(serial())) {

	    		return redirect('activate');
	    	}
    	}
    	
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

	public function upgrade() {
		 

		$license = get_license();
		 
		$data['license'] = $license;
		$this->load->view('upgrade/index', $license);
	}

}
 