<!DOCTYPE html>
<html>
<head>
	<title>POS - Sales And Inventory Management System</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/logo/poslite.png') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/pos_style.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/jquery-ui/jquery-ui.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/font-awesome/css/font-awesome.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables-plugins/dataTables.bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables-responsive/dataTables.responsive.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/selectize.css') ?>"> 
	<meta name="license" content="<?php echo get_license(); ?>">
	<meta name="base_url" content="<?php echo base_url() ?>">
	<meta name="csrfName" content="<?php echo $this->security->get_csrf_token_name(); ?>">
    <meta name="csrfHash" content="<?php echo $this->security->get_csrf_hash(); ?>">
</head>
<body>

	<div style=" ">
	<div class="">
	 
		<div class="col-md-12" style="padding: 0">
			<nav class="navbar">
			<span class="navbar-text" style="font-size: 18px;">Store Branch:  <span id="user"><?php echo $this->session->userdata['store_name'] ?></span>
			</span>
					<ul class="nav navbar-nav navbar-right">
						<li ><a  style="font-size: 18px" href="<?php echo base_url('denomination/close') ?>">Closing Cash</a></li>
						<li ><a  style="font-size: 18px" href="<?php echo base_url('items') ?>">Go to Inventory</a></li>
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
						<h3>List of Products</h3> 
						<div class="content"> 
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
						<div class="content" style="padding-bottom: 0;">  
							 
							<div id="cart-tbl">
								<table class="table" id="cart">
									<thead> 
										<tr>			
											<th width="46%">Product</th>
											<th width="15%">Quantity</th>
											<th width="17%" class="text-right">Price</th> 
											<th width="17%" class="text-right">Amount</th>
											<th width="5%"></th>	
										</tr>
									</thead>
									<tbody>

									</tbody>
									 
									</tfoot>
								</table>

							</div>
						</div>
						<div class="col-md-12" style="padding: 20px 20px 0 20px;">
							<div id="transaction-total">
								<div>Total Discount: <span id="amount-discount" class="pull-right">00.00</span></div> 
							<div style="">Grand Total:<span id="amount-total" class="pull-right">00.00</span></div> 
								
							</div>
							<hr style="margin-bottom: 0;border-color: #ddd;">
						</div>  
					 
						<div class="col-md-12" style="padding: 15px 20px;">
								<form id="process-transaction">
									<div class="form-group" style="margin: 0;">
										<input type="submit" class="btn btn-primary form-control" name="" value="Process order" id="btn" style="font-size: 16.5px;height: 39px;">
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
									<h3>Order Details</h3>
									<div class="row">
										<div class="col-md-4 text-left">
											<div>ID:</div>
											<div>Date: <span></span></div>
											<div>Cashier:</div>
											<div>Time:</div> 
											<div>Transaction:</div>
										</div>
										<div class="col-md-8 text-left">
											<div id="r-id">005250</div>
											<div id="r-date"><?php echo date('m/d/Y') ?></div>
											<div id="r-cashier">Cashier</div>
											<div id="r-time"><?php echo date('h:i a') ?></div> 
											<div id="r-transaction"></div>
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="r-body">
									<table class="table table-striped" id="r-items-table">
										<thead>
											<tr> 
												<th>Item Name</th>
												<th>Price</th>
												<th>Quantity</th>
												<th>Sub Total</th>
											</tr>
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

									<div class="r-footer">
										<p>Thank you for shopping at our store</p>
									</div>
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

		<div class="modal" tabindex="-1" role="dialog" id="confirm-transaction-modal">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-exchange"></i> Grand Total: <span id="grand_total"></span> </span>
							<!-- <span class="pull-right"> -->
						</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<input type="hidden" name="customer_id" id="customer_id" value="0">
								<input type="hidden" name="supplier_id" id="supplier_id" value="0">

								<div class="form-group">
								 	<label>Enter Invoice Number:</label>
								 	<input type="text" name="invoice_number" value="" class="form-control" id="invoice_number">
								 	<input type="hidden" id="valid_invoice" value="0" name="valid_invoice">    
								</div>

								<div class="form-group">
								 	<label>Transaction type:</label>
								 	<select name="type" class="form-control" id="transaction-type">  
								 		<option value="cash">Cash</option>
								 		<option value="cod">COD</option> 
								 		<option value="receivable">Receivable</option> 
								 	</select>
								</div>
								
								<div class="form-group" id="select-customer-fields">
								 	<label>Customer:</label>
								 	<select id="customer-select" placeholder="Select Customer" class="form-control" name="customer">   
								 		<option value="Walk-in Customer">Walk-in Customer</option>
								 		<?php foreach ($customers as $customer): ?>
								 			<option value="<?php echo $customer->name ?>" data-id="<?php echo $customer->id ?>"><?php echo $customer->name ?></option>
								 		<?php endforeach; ?> 
								 	</select>
								</div>   
							</div>  
							<div class="col-md-12" id="cash-fields">
								<div class="form-group">
									<label>Enter payment amount:</label>
									<input type="text" class="form-control" name="" placeholder="Enter Payment" id="payment" autocomplete="off" max="500000" maxlength="6">
								</div>
								<div class="form-group">
									 <label>Change:</label>
									<input readonly="readonly" type="text" class="form-control" id="change" name="" placeholder="Change:"  autocomplete="off"> 
								</div>
								
							</div>  
							<div class="col-md-12">
								<div class="form-group">
									<label>Transaction note:</label>
									<textarea name="note" id="note" class="form-control" rows="3"></textarea>
								</div>
							</div> 
						</div>  
					</div>
					<div class="modal-footer"> 
						<button type="button" class="btn btn-primary" id="complete-transaction">Submit</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
	        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
	        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
	    </script>
		<script type="text/javascript" src="<?php echo base_url('assets/jquery.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/jquery-ui/jquery-ui.js') ?>"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script> -->
		<script type="text/javascript" src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/vendor/datatables/js/jquery.dataTables.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/vendor/datatables-plugins/dataTables.bootstrap.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/vendor/datatables-responsive/dataTables.responsive.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery-pos.js') ?>"></script>
		<script src="<?php echo base_url('assets/js/print.js') ?>"></script>
		<script src="<?php echo base_url('assets/js/selectize.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/js/pos.js') ?>"></script>
	</body>
	</html>
