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

	<div style=" ">
	<div class="">
	 
		<div class="col-md-12" style="padding: 0">
			<nav class="navbar">
			<span class="navbar-text">Current User:  <span id="user"><?php echo $this->session->userdata['username'] ?></span>
			</span>
					<ul class="nav navbar-nav navbar-right">
						<?php if ($this->session->userdata('account_type') !== "Cashier" ): ?> 
							<li><a href="<?php echo base_url('items') ?>">Go to Inventory</a></li>
						<?php endif; ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url('logout') ?>">Sign Out</a></li> 
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
		
		<div class="">
			<div class="">
				<div class=" header">
					<div class="col-sm-7 box rightnone">
					 
						<h3>List of Items</h3>
						 
						<div class="content">
							<label>Select Item</label>
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

					</div>
					<div class="col-sm-5 box">
					 
							<h3>Order Details</h3>
					 
						<div class="content">
							<div id="cart-tbl">
								<table class="table" id="cart">
									<thead>
										<tr>			
											<th width="50%">Product Name</th>
											<th width="15%">Quantity</th>
											<th width="15%">Discount</th>
											<th width="15%">Price</th>
											<th width="5%"></th>	
										</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
					 
						<div class="col-md-12" style="border-bottom: solid 1px #ddd;padding: 15px 25px;">
							<div>Total Discount: <span id="amount-discount" class="pull-right">00.00</span></div> 
							<div style="">Grand Total:<span id="amount-total" class="pull-right">00.00</span></div>
							
						</div>
						<div class="col-md-12" style="padding: 15px 25px;">
							<form id="process-form">
								<div class="form-group">
									<input type="text" class="form-control" name="" placeholder="Enter Payment" id="payment" autocomplete="off" max="500000" maxlength="6">
								</div>
								<div class="form-group">
									 
									<input readonly="readonly" type="text" class="form-control" name="" placeholder="Change:" id="change" autocomplete="off">
									 
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-primary form-control" name="" value="Process" id="btn" >
								</div>
							</form>
						</div>
						 

					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="modal fade" id="discount-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-sm" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h3 class="modal-title" id="exampleModalLabel">Discount</h3> 
		      </div>
		      <div class="modal-body">
		     	<div class="form-group">
		     		<input type="text" class="form-control" name="discount" placeholder="Enter Discount Amount">
		     	</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
		        <button id="discount-enter" type="button" class="btn btn-primary" >Enter Discount</button> 
		      </div>
		    </div>
		  </div>
		</div>
		<div class="modal" tabindex="-1" role="dialog" id="payment-modal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Transaction Complete</h5>
					</div>
					<div class="modal-body">
						<div class="col-md-7">
							<div id="receipt">
								<div class="r-header text-center">
									<h3>Receipt</h3>
									<div class="row">
										<div class="col-md-4 text-left">
											<div>ID:</div>
											<div>Date: <span></span></div>
											<div>Cashier:</div>
											<div>Time:</div>

										</div>
										<div class="col-md-8 text-left">
											<div id="r-id">005250</div>
											<div id="r-date">10/10/1995</div>
											<div id="r-cashier">Cashier</div>
											<div id="r-time">14:50 PM</div> 
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="r-body">
									<table class="table table-striped" id="r-items-table">
										<thead>
											<th>ID</th>
											<th>Item Name</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Sub Total</th>
										</thead>
										<tbody>

										</tbody>
									</table>
									<hr>
									<div class="text-right"> 
										<div>Discount: <span id="r-discount"></span></div>
										<div>Grand Total <span id="r-total-amount"></span></div>
										<div>Payment: <span id="r-payment"></span></div>
										<div>Change: <span id="r-change"></span></div>
									</div>
								</div>
								<div class="r-footer">
									<p>Thank you for shopping at our store</p>
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<h4 class="">Transaction Summary</h3> 
								<table class="table"> 
									<tr>
										<td>Discount Amount:</td>
										<td id="summary-discount"></td>
									</tr>
									<tr>
										<td>Grand Amount:</td>
										<td id="summary-total"></td>
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
								<button class="btn btn-default btn-sm" id="print">Print Receipt</button>
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
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script> -->
		<script type="text/javascript" src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/vendor/datatables/js/jquery.dataTables.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/vendor/datatables-plugins/dataTables.bootstrap.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/vendor/datatables-responsive/dataTables.responsive.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery-pos.js') ?>"></script>

		<script src="<?php echo base_url('assets/js/pos.js') ?>"></script>
	</body>
	</html>
