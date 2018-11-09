<!DOCTYPE html>
<html>
<head>
	<title>POS - Sales And Inventory Management System</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/pos_style.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/font-awesome/css/font-awesome.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables-plugins/dataTables.bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables-responsive/dataTables.responsive.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/jquery-ui/jquery-ui.css') ?>">
	<meta name="base_url" content="<?php echo base_url() ?>">
</head>
<body>
	<div style="background-color: #333;padding: 0 20px;">
		<nav class="navbar" style="margin: 0;color: #fff ">
			<p class="navbar-text" style="color: #ddd;">Current User:  <?php echo $this->session->userdata['username'] ?>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="<?php echo base_url('items') ?>">Go to Inventory</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url('logout') ?>">Sign Out</a></li> 
						</ul>
					</li>
				</ul>
			</nav>
		</div>
		<div class="main">
			<div style="padding: 0 0px;">
				<div class="col-sm-6">
					<h3 style="float: left;">Customer Cart</h3>
				</div>
				<div class="col-sm-6">
					<?php $total_amount = ""; ?>
					<h3 id="total_amount">Total Amount Due <span id="amount-due"></span> </h3>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="cart">
				<div id="cart-tbl">
					<table class="table table-hover table-striped" id="cart">
						<thead style="background: #f5f5f5;">
							<tr>
								<th>Item ID</th>
								<th>Item Name</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Sub Total</th>	
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="input">
				<div class="col-sm-6" id="left" >
					<form method="POST">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Choose Item</label>
								<input id="item" autocomplete="off" type="text" name="item" placeholder="Click to choose item" class="form-control">
							</div>
						</div>
						<div class="col-sm-8">
							<div class="form-group">
								<label>Quantity</label>
								<input id="quantity" autocomplete="off" type="text" name="quantity" placeholder="Enter Quantity" class="form-control">
							</div>
						</div>
						<div class="col-sm-4" style="padding-top: 0px;">
							<input style="width: 100%; margin-bottom: 5px;" id="add-cart" type="button" name="enter" class=" btn btn-info input-lg" value="ADD TO CART">
							<input style="width: 100%;" id="process" type="button" name="process" class=" btn btn-success input-lg" value="PROCESS">
						</div>
					</form>

				</div>
				<div class="col-sm-6" id="right">
					<div id="item-details">
						<table class="table table-striped" >
							<tr>

								<td>Item Name:</td>
								<td><span id="item-name"></span></td>
								<input type="hidden" name="item_id" id="item-id">
								<input type="hidden" name="price_id" id="price-id">
							</tr>
							<tr>
								<td>Price:</td>
								<td><span id="price"></span></td>
							</tr>
							<tr>
								<td>Description:</td>
								<td><span id="description"></span></td>
							</tr> 
						</table>
					</div>
				</div>
			</div>
		</div>
	<div class="modal" tabindex="-1" role="dialog" id="modal">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Select Item</h5>

				</div>
				<div class="modal-body">
					<table style="width: 100%" class="table table-bordered table-hover table-striped" id="item-table">
						<thead>
							<tr>
								<td>Item ID</td>
								<td>Item Name</td>
								<td>Description</td>
								<td>Stocks</td>
								<td>Price</td>
							</tr>
						</thead>
						<tbody> 
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" tabindex="-1" role="dialog" id="payment">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div id="panel1">
					<div id="loader">
						<i class="fa fa-spinner fa-spin"></i>
					</div>
					<form>
					<div class="modal-header">
						<h5 class="modal-title">Payment</h5>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Select Customer:</label>
							<select required="required" name="customer" class="form-control" id="customer-id">
								<option value="">Select Customer</option>
								<?php foreach($customers as $customer): ?>
									<option value="<?php echo $customer->id ?>">
										<?php echo $customer->name ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label>Total Amount:</label>
							<input required="required" id="total-amount-due" autocomplete="off" type="text" name="" disabled="" class="form-control">
						</div>
						<div class="form-group">
							<label>Payment:</label>
							<input required="required" type="text" autocomplete="off" id="amount-pay" name="payment" placeholder="Enter Payment" class="form-control">
						</div>
						<div class="form-group">
							<label>Change:</label>
							<input required="required" id="change" autocomplete="off" type="text" name="" disabled="" class="form-control">	
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" disabled="disabled" id="complete-transaction">Complete Transaction</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
					</form>
				</div>
				<div id="panel2">
					<div class="modal-header">
						<h5 class="modal-title">Transaction Complete</h5>
					</div>
					<div class="modal-body">
						<div class="col-md-6 col-md-offset-3">
							<h4 class="">Transaction Summary</h3> 
							<table class="table table-condensed ">
								<tr>
									<td>Total Amount:</td>
									<td id="summary-due"></td>
								</tr>
								<tr>
									<td>Payment:</td>
									<td id="summary-payment"></td>
								</tr>
								<tr>
									<td>Change:</td>
									<td id="summary-change"></td>
								</tr>
							</table>
							<button class="btn btn-default btn-sm">Print Receipt</button>
						</div>
							 
						<div class="clearfix"></div>

					</div>
					<div class="modal-footer"> 
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
					 
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="<?php echo base_url('assets/jquery.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jquery-ui/jquery-ui.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/vendor/datatables/js/jquery.dataTables.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/vendor/datatables-plugins/dataTables.bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/vendor/datatables-responsive/dataTables.responsive.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/pos.js') ?>"></script>
</body>
</html>
