<!DOCTYPE html>
<html>
<head>
	<title>POS</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/pos_style.css') ?>">
	<script type="text/javascript" src="<?php echo base_url('assets/jquery.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jquery-ui/jquery-ui.js') ?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var total = sessionStorage.getItem('total');
			var cart = sessionStorage.getItem('cart');
			$('#amount_due').val('₱' +total);
			$("#cart").val(cart);
			$("#t").val(total);
			console.log($("#cart").val());
			console.log(total);
			$('#payment').on('change paste keyup propertychange',function() {
				payment = $("#payment").val();
				if (isNaN(payment) || payment === undefined) {
					$("#message").html('<div class="alert alert-danger">Please Enter Numbers Only</div>');
				}
				else if (parseInt(payment) < parseInt(total)) { 
					$("#message").html('<div class="alert alert-danger">Insufficient Amount</div>');
				}else if (parseInt(payment) > parseInt(total)) {
					change = parseInt(payment) - parseInt(total);
					$("#message").html('<div class="alert alert-success">Good</div>');
					$("#c").val(change);
					$("#change").val('₱' + change);
				}
				
			});
		});
		
	</script>
</head>
<body>
<header style="margin-bottom: 40px;color: white;">
<div style="padding-left: 20px; padding-top: 2px;">
		<h2 style="margin: 0">POS Sales and Inventory System</h2>
		<p style="margin: 0;">By: Alger Makiputin</p>
	</div>
</header>
<div class="main">

<div class="col-sm-6 col-sm-offset-3">
<?php echo $this->session->flashdata('errorMessage'); ?>
<?php echo form_open('billing/complete'); ?>
<?php echo form_fieldset('<h1 class="text-info">Payment</h1>'); ?>
<div id="message">
	
</div>
<div class="form-group">
	<label>Total Amount:</label><br>
	<input id="amount_due" type="text" name="" disabled="" class="form-control input-lg">
</div>
<div class="form-group">
	<label>Payment:</label><br>
	<input type="text" id="payment" name="payment" placeholder="Enter Payment" class="form-control input-lg">
</div>
<div class="form-group">
	<label>Change:</label><br>
	<input id="change" type="text" name="" disabled="" class="form-control input-lg">	
</div>
<input type="hidden" name="cart" id="cart">
<input type="hidden" name="change" id="c">
<input type="hidden" name="total" id="t">
<div class="form-group">
	<input type="submit" name="submit" class="form-control btn btn-success input-lg">	
</div>
<?php echo form_close(); ?>

</div>
</div>
</body>
</html>
