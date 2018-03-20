<?php 

if(validation_errors()) {
	$errorMsg = '';
	if ($this->session->flashdata('errorMessage')) {
		$errorMsg = $this->session->flashdata('errorMessage') . '<br>';
	}
	echo "<div class='alert alert-danger'> ". $errorMsg . validation_errors() .  "</div> ";	
} 
?>