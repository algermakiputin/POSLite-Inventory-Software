<?php 

	function dd($data) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die();
	}


	function get_preferences() {
		$path = './preference.txt';
 
        
     $file = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

     $preference = [];
     foreach ($file as $f) {
         $setting = explode('=', $f);
         $preference[$setting[0]] = $setting[1];
     }

     return $preference;

  	}

	function get_date_time() {

		return date('Y-m-d H:i:s');

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
		$CI =& get_instance();
		$CI->load->config('license');
		return $CI->config->item('license');
	}

	function profile() {
		return explode(',', base64_decode(file_get_contents( homeDir() . "/profile.txt")));
	}

	function serial() {
		$serial =  shell_exec('c:\Windows\System32\wbem\wmic.exe DISKDRIVE GET SerialNumber 2>&1');


		$serial = trim(str_replace('SerialNumber','', $serial));

		return preg_split ('/\R/', $serial)[0];
	}

	function db_transaction($func) {

		$CI =& get_instance();

		$this->db->trans_begin();

		$func();
	}

	function noStocks() {
		$CI =& get_instance();
		$outOfStocks = $CI->db->select("items.id, items.name,items.description, ordering_level.quantity")
				->from("items")
				->join("ordering_level", "ordering_level.item_id = items.id", "left")
				->where('items.status', 1)
				->where('ordering_level.quantity <=', 0)
				->limit(25)
				->get()
				->result();

		return ($outOfStocks);
	}

	function low_stocks() {
		$CI =& get_instance();
		$running_outofstock = $CI->db->select("items.id, items.name,items.description, ordering_level.quantity")
				->from("items")
				->join("ordering_level", "ordering_level.item_id = items.id", "left")
				->where('items.status', 1)
				->where('ordering_level.quantity >', 0)
				->where('ordering_level.quantity <=', 50)
				->limit(25)
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

	function errorMessage($message) {
		$CI =& get_instance();
		$CI->session->set_flashdata('error', $message);
	}

	function license($table) {
		$CI =& get_instance();
		 

		$data['bronze'] = [
				'items' => 200,
				'users' => 2,
				'customers' => 200,
			];

		$data['silver'] = [
				'items' => 2000,
				'users' => 2,
				'customers' => 2000
			];
			

		$data['gold'] = [
				'items' => 5000000,
				'users' => 200,
				'customers' => 5000000
			];

		$license = $CI->config->item('license');

		$count = $CI->db->get($table)->num_rows();

	 
		if ($count > $data[$license][$table] ) {
			$CI->session->set_flashdata('errorMessage', "<div class='alert alert-danger'>Your ". $table ." reached the limit, please <a href='https://m.me/poslitesoftware'>contact us</a> to upgrade</div>");
			return redirect('/items');
		}
		 
	}