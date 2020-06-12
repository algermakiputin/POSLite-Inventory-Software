<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AppController extends CI_Controller {

	public function __construct() {
 
      parent::__construct();  

      $this->cashier_restrictions();

    }

    public function cashier_restrictions() {

    	$uri = uri_string();
    	$restricted_page = ['dashboard', 'items','customers', 'sales', 'returns','categories', 'backups'];

    	if ( in_array( $uri , $restricted_page ) && $this->session->userdata('account_type') == "Cashier")
    		die('Sorry, You Are Not Allowed to Access This Page.' . '<a href="'.base_url('pos').'">Return to POS</a>');
  
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
		  
		$data['license'] = get_license();
		$data['limits'] = get_license_values(); 

		$this->load->view('upgrade/index', $data);
	}




}
 