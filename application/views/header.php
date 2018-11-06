<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($page_name)) {echo $page_name .' - Sales And Inventory System';} else echo "Dashboard - POS SALES AND INVENTORY SYSTEM" ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/font-awesome-4.7.0/css/font-awesome.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/css/dataTable.bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css')?>">
	<meta name="base_url" content="<?php echo base_url() ?>">
</head>
<body>
<?php if ( $this->uri->segment(1) !== "login"): ?>
	<header id="main-header">
		<div class="row">
			<div class="col-lg-10">
				<h2>POS Sales And Inventory Management System</h2>
			</div>
			<div class="col-lg-2 text-right">
				<p>
					<?php echo date('M d, Y') ?>
				</p>
			</div>
		
	</header>
<?php endif; ?>


<div class="row" style="margin-bottom: -10px;">
<div class="container-fluid main-content" >

