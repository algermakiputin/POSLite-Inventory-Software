<?php 

	function dd($data) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die();
	}

	function noStocks() {
		$CI =& get_instance();
		$outOfStocks = $CI->db->select("items.id, items.name, ordering_level.quantity")
				->from("items")
				->join("ordering_level", "ordering_level.item_id = items.id", "left")
				->where('items.status', 1)
				->where('ordering_level.quantity <=', 0)
				->get();

		return $outOfStocks;
	}

	function success($message) {
		$CI =& get_instance();
		$CI->session->set_flashdata('success', $message);
	}

	function license($table) {
		$CI =& get_instance();
		
		$data['basic'] = [
				'items' => 500,
				'users' => 3,
				'customers' => 500
			];

		$data['bronze'] = [
				'items' => 1500,
				'users' => 5,
				'customers' => 3000
			];

		$license = $CI->config->item('license');
		$count = $CI->db->get($table)->num_rows();
		 
		if ($count > $data[$license][$table] ) {
			$CI->session->set_flashdata('errorMessage', "<div class='alert alert-danger'>Your ". $table ." reached the limit, please contact us to upgrade</div>");
			return redirect('/items');
		}
		 
	}