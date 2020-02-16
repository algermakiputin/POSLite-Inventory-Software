<?php 


function store_selector_component($classes, $id = "store-selector") {
	
	$CI =& get_instance();

	$stores = $CI->db->get('stores')->result();
	$options = "";
	$user_store_number = $CI->session->userdata('store_number');
	$user_type = $CI->session->userdata('account_type');

	foreach ($stores as $store) {
		$selected = "";

		if ($user_type == "Cashier" && $store->number != $user_store_number)
			continue;

		if ($store->number == $user_store_number)
			$selected = "selected";

		$options .= "<option $selected value='$store->id'>$store->branch</option>";
	}

	$selector = "<select id='$id' name='store-selector' class='".join(' ',$classes)."'>" .
			 $options.
			"</select>";

	return $selector;

	

}