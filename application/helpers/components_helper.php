<?php 


function store_selector_component($classes) {
	
	$CI =& get_instance();

	$stores = $CI->db->get('stores')->result();
	$options = "";
	$user_store_number = $CI->session->userdata('store_number');

	foreach ($stores as $store) {
		$selected = "";

		if ($store->number == $user_store_number)
			$selected = "selected";

		$options .= "<option $selected value='$store->id'>$store->branch</option>";
	}

	$selector = "<select id='store-selector' name='store-selector' class='".join(' ',$classes)."'>" .
			 $options.
			"</select>";

	return $selector;

}