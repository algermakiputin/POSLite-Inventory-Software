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

	<div class="main">

		<div class="col-sm-6 col-sm-offset-3">
			<?php echo $this->session->flashdata('errorMessage'); ?>
			<div style="padding: 20px;">
				<h1 class="text-success">Transaction Complete</h1>
				<small class=""><a class="btn btn-warning" href="<?php echo base_url('pos')?>">Return To POS</a></small>
				<br>
				<br>
				<table class="table table-hover">
					<tr>
						<th>Total Ampunt Due:</th>
						<td>₱<?php echo $total;?></td>
					</tr>
					<tr>
						<th>Payment:</th>
						<td>₱<?php echo $payment;?></td>
					</tr>
					<tr>
						<th>Change:</th>
						<td>₱<?php echo $change;?></td>
					</tr>
					 
				</table>
			 
			</div>
		</div>
	</div>
</div>
</body>
</html>
