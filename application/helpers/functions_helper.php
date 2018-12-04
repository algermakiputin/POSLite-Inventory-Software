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