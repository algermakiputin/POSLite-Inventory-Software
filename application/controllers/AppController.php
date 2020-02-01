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

	public function validate_opening_denomination() {

		$date = date('Y-m-d');

		$validate = $this->db->where('DATE_FORMAT(date, "%Y-%m-%d") =', $date)
									->where('type', 'opening')
									->get('denomination')
									->num_rows();

		return $validate;
	}

	public function validate_closing_denomination() {

		$date = date('Y-m-d');

		$validate = $this->db->where('DATE_FORMAT(date, "%Y-%m-%d") =', $date)
									->where('type', 'closing')
									->get('denomination')
									->num_rows();

		return $validate;
	}

}
 