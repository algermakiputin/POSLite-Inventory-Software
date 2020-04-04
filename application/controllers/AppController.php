<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AppController extends CI_Controller {

	public function __construct() {
 
      parent::__construct();  

      if ( $this->trial_days_remaining() >= 14 ) {

      	return redirect('trial/expired');
      }

    }

    public function check_trial() {

    	return $this->db->where('id', 1)->get('settings')->row();

    }

    public function start_trial_view() {
 
    	$this->load->view('trial/index');
    }

    public function trial_days_remaining() {

    	// check how many days trial left

    	return get_trial_days_remaning();
 
    }

    public function start_trial() {

    	$this->db->where('id', 1)
    				->set(['start' => strtotime(date('Y-m-d'))])
    				->update('settings');

    	$this->session->set_flashdata('successMessage', '<div class="alert alert-success">Your 14 days free trial has started! you can now start using and exploring POSLite awesome features.</div>');
    	return redirect('login');
    }

    public function licenseControl() {

      return false;
    	  
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
 