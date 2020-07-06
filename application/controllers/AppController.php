<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AppController extends CI_Controller {

	public function __construct() {
 
      parent::__construct();  

      $this->user_restrictions();

    }

    public function __destruct() {
        
    }

    public function export_products() {

    	$this->load->dbutil();

		// Backup your entire database and assign it to a variable


			$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$prefs = array(    // Array of tables to backup.
					'tables' => array('items','prices', 'ordering_level', 'categories', 'supplier'),
		        'ignore'        => array(),                     // List of tables to omit from the backup
		        'format'        => 'txt',                       // gzip, zip, txt
		        'filename'      => 'mybackup.sql',              // File name - NEEDED ONLY WITH ZIP FILES
		        'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
		        'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
		        'newline'       => "\n"                         // Newline character used in backup file
		);

		$backup = $this->dbutil->backup($prefs);

		echo $backup;

		return;

    }


    public function load_products() {

    	$query;

    	return $this->db->query($query);

    }
 
    public function user_restrictions() {

    	$uri = uri_string();
 
    	$restricted_page_cashier = ['dashboard', 'items','customers', 'sales', 'returns','categories', 'backups'];
    	$restricted_page_receiver = ['dashboard', 'items','customers', 'sales', 'returns','categories', 'backups', 'expenses', 'expenses/new', 'pos'];

    	if ( in_array( $uri , $restricted_page_cashier ) && $this->session->userdata('account_type') == "Cashier")
    		die('<h1>Opps! You Are Not Allowed to Access This Page.</h1><p>' . '<a href="'.base_url('pos').'">Return to POS</a> </p>');


    	if ( in_array( $uri , $restricted_page_receiver ) && $this->session->userdata('account_type') == "Receiver") {
    		die('<h1>Opps! You Are Not Allowed to Access This Page.</h1></p>' . '<a href="'.base_url('deliveries').'">Return to Deliveries</a></p>');
    	}
  
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
 