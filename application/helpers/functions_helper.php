<?php 

	function dd($data) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die();
	}

	function get_date_time() {

		return date('Y-m-d H:i:s');
	}

	function renewal() {

		$renewal_date = new DateTime(date('2050-04-1')); 
		$today_date = new DateTime(date('Y-m-d'));

		$intervalDays = $renewal_date->diff($today_date)->days; 
 
	 	if ($renewal_date > $today_date && $intervalDays > 30) {
	 		return [0];

	 	}else if ($renewal_date > $today_date && $intervalDays < 30) {
	 	 
	 		 return ["renewal_due", $renewal_date->format('Y-m-d')];

	 	}else if ( $today_date >= $renewal_date) {

	 		return ['expired'];
	 	}

	}

	function homeDir()
	{
	    if(isset($_SERVER['HOME'])) {
	        $result = $_SERVER['HOME'];
	    } else {
	        $result = getenv("HOME");
	    }

	    if(empty($result) && function_exists('exec')) {
	        if(strncasecmp(PHP_OS, 'WIN', 3) === 0) {
	            $result = exec("echo %userprofile%");
	        } else {
	            $result = exec("echo ~");
	        }
	    }

	    return $result;
	}

	function currency() {
		return "₱";
	}

	function get_license() {
	 
		return "silver";
	}


	function get_license_values() {

		$data['bronze'] = [
				'items' => 200,
				'users' => 2,
				'customers' => 200,
			];

		$data['silver'] = [
				'items' => 2000,
				'users' => 3,
				'customers' => 2000
			];
			

		$data['gold'] = [
				'items' => 5000000,
				'users' => 200,
				'customers' => 5000000
			];


		return $data;

	 
	}

	function profile() {
		return explode(',', base64_decode(file_get_contents( homeDir() . "/profile.txt")));
	}

	function drush_server_home() {
		// Cannot use $_SERVER superglobal since that's empty during UnitUnishTestCase
		// getenv('HOME') isn't set on Windows and generates a Notice.
		$home = getenv('HOME');
		if (!empty($home)) {
		  // home should never end with a trailing slash.
		  $home = rtrim($home, '/');
		}
		elseif (!empty($_SERVER['HOMEDRIVE']) && !empty($_SERVER['HOMEPATH'])) {
		  // home on windows
		  $home = $_SERVER['HOMEDRIVE'] . $_SERVER['HOMEPATH'];
		  // If HOMEPATH is a root directory the path can end with a slash. Make sure
		  // that doesn't happen.
		  $home = rtrim($home, '\\/');
		}
		return empty($home) ? NULL : $home;
	  }

	function serial() {
		$serial =  shell_exec('c:\Windows\System32\wbem\wmic.exe DISKDRIVE GET SerialNumber 2>&1');


		$serial = trim(str_replace('SerialNumber','', $serial));

		return preg_split ('/\R/', $serial)[0];
	}

	function noStocks() {
		$CI =& get_instance();
		$outOfStocks = $CI->db->select("items.barcode, items.id, items.name,items.description, ordering_level.quantity")
				->from("items")
				->join("ordering_level", "ordering_level.item_id = items.id", "left")
				->where('items.status', 1)
				->where('ordering_level.quantity <=', 0)
				->get()
				->result();

		return ($outOfStocks);
	}

	function low_stocks() {
		$CI =& get_instance();
		$running_outofstock = $CI->db->select("items.id, items.barcode, items.name,items.description, ordering_level.quantity")
				->from("items")
				->join("ordering_level", "ordering_level.item_id = items.id", "left")
				->where('items.status', 1)
				->where('ordering_level.quantity >', 0)
				->where('ordering_level.quantity <=', 15)
				->get()
				->result();

		return $running_outofstock;
	}

	function is_admin() {
		$CI =& get_instance();
		return ($CI->session->userdata('account_type') === "Admin") ? 1 : 0;
	}

	function success($message) {
		$CI =& get_instance();
		$CI->session->set_flashdata('success', $message);
	}

	function error($message) {
		$CI =& get_instance();
		$CI->session->set_flashdata('error', $message);
	}


	function license($table) {
		$CI =& get_instance();
		 

		$license = get_license();

		$count = $CI->db->get($table)->num_rows();

		$data = get_license_values();

	 
		if ($count > $data[$license][$table] ) {
			$CI->session->set_flashdata('errorMessage', "<div class='alert alert-danger'>Your ". $table ." reached the limit, please <a href='https://m.me/poslitesoftware'>contact us</a> to upgrade</div>");
			return redirect('/items');
		}
		 
	}