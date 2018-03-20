<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($page_name)) {echo $page_name .' - Sales And Inventory System';} else echo "Dashboard - POS SALES AND INVENTORY SYSTEM" ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/font-awesome-4.7.0/css/font-awesome.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css')?>">
</head>
<body>
<header style="height: 60px; background: #2d2626; color: white;" class="">
	<?php
		$cur_date = date('l, F Y');
		if ($this->session->userdata('log_in')) {
			?>
			<p class="lead" style="float: right; padding-right: 15px; margin-top: 11px;"><?php echo $cur_date ?> | <?php echo $this->session->userdata('username') ?></p>
			<?php
		}
	?>
	
	<div style="padding-left: 20px; padding-top: 2px;">
		<h2 style="margin: 0">POS Sales and Inventory System</h2>
		<p style="margin: 0;">By: Alger Makiputin</p>
	</div>
</header>
<div class="row" style="margin-bottom: -10px;">
<div class="container-fluid main-content" >

