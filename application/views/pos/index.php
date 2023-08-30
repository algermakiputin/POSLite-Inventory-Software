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
					<span class="navbar-text">Current User:  <span id="user"><?php echo $this->session->userdata['username'] ?></span>
				</span>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#" id="return" ><i class="fa fa-undo"></i> Return (F7)</a></li>
					<li><a href="#" id="open-transactions"><i class="fa fa-exchange"></i> Transactions (F8)</a></li>
					<li>
						<?php if ( !is_admin() ) : ?>
							<a href="<?php echo base_url('expenses/new') ?>"><i class="fa fa-money fa-fw"></i> Expenses</a>
						<?php else: ?>
							<a href="<?php echo base_url('items') ?>"><i class="fa fa-briefcase fa-fw"></i> Go to Inventory</a>
						<?php endif; ?>
					</li>
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
								<td >Item Name</td>
								<td >Description</td> 
								<td>Quantity</td> 
								<td >Price</td>
							</tr>
						</thead>
						<tbody> 
						</tbody>
					</table>
				</div> 
			</div>
			<div class="col-sm-5 box"> 
				<h3 > Order Details
					<!-- <span  class="">Grand Total: <span id="amount-total">00.00</span></span>
					<span  class="pull-right" style="display: none;">Discount: <span id="amount-discount">00.00</span></span> -->
				</h3> 
				<div class="content" style="padding-bottom: 10px">
					<div id="cart-tbl">
						<table class="table" id="cart">
							<thead>
								<tr>			
									<th width="35%">Product Name</th>
									<th width="15%">Quantity</th>
									<th width="15%">Discount</th>
									<th width="15%">Price</th>
									<th width="15%">Sub</th>
									<th width="5%"></th>	
								</tr>
							</thead>
							<tbody > 
							</tbody>
						</table>
					</div>
				</div> 
				<div class="col-md-12" style="border-bottom: solid 1px #ddd;padding: 5px 25px 15px 25px;"> 
					<div class="mb-2">Subtotal:<span id="amount-total" class="pull-right">00.00</span></div> 
					<div class="mb-2">Discounted Sales:<span id="amount-total" class="pull-right">00.00</span></div> 
					<div class="mb-2">Total Sales Tax:<span id="amount-total" class="pull-right">00.00</span></div> 
				</div>
				<div class="col-md-12" style="padding: 15px 25px;">
					<form id="process-form">
						<!-- <div class="form-group">
							<input type="text" class="form-control input-lg" name="" placeholder="Sub Total: 3000" id="payment" autocomplete="off">
						</div>
						<div class="form-group"> 
							<input readonly="readonly" type="text" class="form-control input-lg" name="" placeholder="Total: 5400" id="change" autocomplete="off">
						</div> -->
						<div class="form-group">
							<input type="submit" class="btn btn-primary btn-block btn-lg" name="" value="Process" id="btn" >
						</div>
					</form>
				</div> 
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="modal " id="discount-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<div class="modal" id="discount-modal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md center" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Process Order</h3> 
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Order Total</label>
					<input type="text" disabled class="form-control" />
				</div> 
				<div class="form-group">
					<label>Payment Type</label>
					<select class="form-control">
						<option valuu="cash">Cash</option>
						<option value="credit">Credit</option>
					</select>
				</div>
				<div class="form-group">
					<label>Customer</label>
					<select class="form-control">
						<option>Select Customer</option>
					</select>
				</div>
				<div>
					<label>Discount</label>
					<select class="form-control">
						<option>Select Discount</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
				<button id="discount-enter" type="button" class="btn btn-primary" >Complete Order</button> 
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
							<div>
								<?php if ($settings->logo): ?>
									<img width="80" src="<?php echo base_url('/assets/logo/' . $settings->logo) ?>">
								<?php endif; ?>
							</div>
							<h3><?php echo $settings->business_name ?></h3>
							<div id="business-info" class="text-center">
								<div><?php echo $settings->business_address ?></div> 
								<div><?php echo $settings->contact ?></div>
								<div><?php echo $settings->email ?></div>
							</div>
							<table class="text-left">
								<tr>
									<th colspan="2">RECEIPT</th> 
								</tr>
								<tr>
									<td>Transaction Number: &nbsp;&nbsp;</td>
									<td><div id="r-id">005250</div></td>
								</tr>
								<tr>
									<td>Date: &nbsp;&nbsp;</td>
									<td><div id="r-date"><?php echo date('m/d/Y') ?></div></td>
								</tr>
								<tr>
									<td>Cashier: &nbsp;&nbsp;</td>
									<td><div id="r-cashier">Cashier</div></td>
								</tr>
								<tr>
									<td>Time: &nbsp;&nbsp;</td>
									<td><div id="r-time"><?php echo date('h:i a') ?></div> </td>
								</tr>
							</table> 
							<div class="clearfix"></div>
						</div>
						<div class="r-body">
							<table class="table table-striped" id="r-items-table">
								<thead>
									<tr> 
										<th>Item </th> 
										<th>Price</th>
										<th>Qty</th>
										<th>Sub</th>
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

<div class="modal " id="transactions-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">TRANSACTIONS: <?php echo date('Y/m/d') ?></h4> 
			</div>
			<div class="modal-body">
				<table class="table table-hover table-bordered" id="transaction-history-tbl" width="100%">
					<thead>
						<tr>
							<th>Date Time</th>
							<th>Transaction Number</th> 
							<th>Staff</th>
							<th>Total</th> 
							<th>Receipt</th>
						</tr>
					</thead>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
			</div>
		</div>
	</div>
</div>

<div class="modal " id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Select Customer</h4> 
			</div>
			<div class="modal-body">
			 	<form>
			 		<div class="form-group">
			 			<label>Customer</label>
			 			<select>
			 				
			 			</select>
			 		</div>
			 	</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
			</div>
		</div>
	</div>
</div>

<div class="modal " id="return-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-undo"></i> Return Form</h4> 
			</div>
			<div class="modal-body">
				<form> 
						<div class="form-group">
						<label>Transaction Number:</label>
						<input style="max-width: 300px" type="text" class="form-control" name="transaction_number" id="transaction_number">
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-primary" id="return-btn">Find</button>
					</div>

				</form>

				<div style="display: none;" id="orderline-wrapper"> 
					<table class="table table-bordered table-striped" id="orderline" >
						<thead>
							<tr>
								<th colspan="3">Transaction Number: <span class="pull-right" id="label-transaction-number"></span></th>
								<th colspan="2">Date <span class="pull-right" id="label-date">10/10/1995</span></th>
							</tr>
							<tr> 
								<th>Description</th>
								<th>Quantity</th>
								<th>Condition</th>
								<th>Return Qty</th>
								<th>Reason</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="15%">1005205</td>
								<td width="25%">Test</td>
								<td width="15%">5</td>
								<td width="20%">
									<select class="form-control" name="condition[]">
										<option value="good">Good</option>
										<option value="damaged">Damaged</option>
									</select>
								</td>
								<td width="20%">
									<input type="text" class="form-control" name="return_quantity[]" >
								</td>
							</tr>

							<tr>
								<td width="15%">1005205</td>
								<td width="25%">Test</td>
								<td width="15%">5</td>
								<td width="20%">
									<select class="form-control" name="condition[]">
										<option value="good">Good</option>
										<option value="damaged">Damaged</option>
									</select>
								</td>
								<td width="20%">
									<input type="text" class="form-control" name="return_quantity[]" >
								</td>
							</tr>

							<tr>
								<td width="15%">1005205</td>
								<td width="25%">Test</td>
								<td width="15%">5</td>
								<td width="20%">
									<select class="form-control" name="condition[]">
										<option value="good">Good</option>
										<option value="damaged">Damaged</option>
									</select>
								</td>
								<td width="20%">
									<input type="text" class="form-control" name="return_quantity[]" >
								</td>
							</tr>
						</tbody>
					</table>
					<div class="form-group text-right">
						<button class="btn btn-success" id="submit-return">Submit Return </button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
			</div>
		</div>
	</div>
</div>

<div class="modal" id="advance_pricing_modal" tabindex="-1" role="dialog" aria-labelledby="AdvancePricingModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="product-name"><b>Product Name</b></h3>

			</div>
			<div class="modal-body"> 
				<table class="table table-bordered table-striped table-hover" id="advance_pricing_options">
					<thead>
						<tr>
							<th colspan="3" style="background-color: #f4f4f5;">Pricing Options</th>
						</tr>
						<tr>
							<th>Label</th>
							<th>Price</th>
							<th></th>
						</tr>
					</thead>
					<tbody>  

					</tbody>
				</table>

				<form class="form-inline" id="add-to-cart-form">
					<div class="form-group">
						<input type="hidden" name="item_unit" id="item_unit">
						<input type="hidden" name="capital" id="capital" value="0">
						<input type="hidden" name="item_id" id="item_id">
						<input type="hidden" name="stocks" id="stocks">
						<label for="quantity-enter">Enter Quantity &nbsp;</label>
						<input style="border-radius: 3px;" name="quantity-enter" onfocus="this.value=''" type="number" min="1" value="1" type="number" id="quantity" class="form-control mx-sm-3" aria-describedby="quantity">

					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="add-product">Add Product</button>
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
<script src="<?php echo base_url('assets/js/pos.js') ?>"></script>
</body>
</html>