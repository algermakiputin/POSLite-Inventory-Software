<?php 


function store_selector_compoent($classes) {
	
	$CI =& get_instance();

	$stores = $CI->db->get('stores')->result();
	$options = "";

	foreach ($stores as $store) {

		$options .= "<option value='$store->id'>$store->branch</option>";
	}

	$selector = "<select id='store-selector' class='".join(' ',$classes)."'>" .
			 $options.
			"</select>";

	return $selector;

}