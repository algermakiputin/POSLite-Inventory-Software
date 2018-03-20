<!DOCTYPE html>
<html>
<head>
	<title>POS</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/pos_style.css') ?>">
	<script type="text/javascript" src="<?php echo base_url('assets/jquery.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jquery-ui/jquery-ui.js') ?>"></script>
</head>
<body>
<header style="margin-bottom: 40px; color: white">
<div style="padding-left: 20px; padding-top: 2px;">
		<h2 style="margin: 0">POS Sales and Inventory System</h2>
		<p style="margin: 0;">By: Alger Makiputin</p>
	</div>
</header>
<div class="main">

<div class="col-sm-6 col-sm-offset-3">
<?php echo $this->session->flashdata('errorMessage'); ?>
<div style="padding: 20px;" class="bg-info">
<h1 class="text-success">Transaction Complete</h1>
<small class=""><a class="btn btn-warning" href="<?php echo base_url('pos')?>">Return To POS</a></small>
<br>
<br>
<div class="row">
<div class="col-sm-5" class="">
<p class="lead">Total Amount Due: <span style="float: right;">:</span></p>
</div>
<div class="col-sm-7">
	<p class="lead">₱<?php echo $total;?></p>
</div>
<div class="col-sm-5">
	<p class="lead">Payment<span style="float: right;">:</span> </p>
</div>
<div class="col-sm-7">
	<p class="lead">₱<?php echo $payment;?></p>
</div>
<div class="col-sm-5">
	<p class="lead">Change<span style="float: right;">:</span> </p>
</div>
<div class="col-sm-7">
	<p class="lead">₱<?php echo $change;?></p>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>
