<!DOCTYPE html>
<html>
<head>
	<title>Receipt</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css'); ?>">
</head>
<body>
	<style type="text/css">
		#receipt {
			width: 480px;
			padding: 10px;
		}

	</style>
	<div id="receipt">
		<div class="r-header text-center">
			<h3>Receipt</h3>
			<br>
			<table class="text-left">
				<tr>
					<td>Transaction Number: &nbsp;&nbsp;</td>
					<td><div id="r-id"><?php echo $sale->transaction_number ?></div></td>
				</tr>
				<tr>
					<td>Date: &nbsp;&nbsp;</td>
					<td><div id="r-date"><?php echo date("Y-m-d", strtotime($sale->date_time)) ?></div></td>
				</tr>
				<tr>
					<td>Cashier: &nbsp;&nbsp;</td>
					<td><div id="r-cashier"><?php echo $sales_person ?></div></td>
				</tr>
				<tr>
					<td>Time: &nbsp;&nbsp;</td>
					<td><div id="r-time"><?php echo date('h:i a', strtotime($sale->date_time)) ?></div> </td>
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
					<?php foreach ($orderline as $row): ?>
						<tr>
							<td><?php echo $row->name; ?></td>
							<td><?php echo currency() . number_format($row->price, 2); ?></td>
							<td><?php echo $row->quantity; ?></td>
							<td><?php echo currency() . number_format($row->price * $row->quantity, 2); ?></td>
						</tr>
						<?php 
							$total+= $row->price * $row->quantity; 
							$discount += $row->discount;
						?>
					<?php endforeach; ?>
				</tbody>
			</table>
			<hr>
			<div class="text-right">  
				<div>Sub Total:  <span id="r-total-amount"><?php echo currency() . number_format( $total, 2 ) ?> </span></div> 
				<div>Discount:  <span id="r-total-amount"><?php echo currency() . number_format( $discount, 2 ) ?> </span></div> 
				<div>Grand Total:  <span id="r-total-amount"><?php echo currency() . number_format( $total - $discount, 2 ) ?> </span></div> 
			</div>

			<div class="r-footer text-center">
				<br><br>
				<p>Thank you for shopping at our store</p>
			</div>
		</div>
 	</div>

 	<button id="print" class="btn btn-default">Print</button>
	<script type="text/javascript" src="<?php echo base_url('assets/jquery.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/print.js') ?>"></script>
	<script type="text/javascript">

		var base_url = "<?php echo base_url ?>";

		$(document).ready(function() {

			$("#print").click(function(){
				$("#receipt").print({
			        	globalStyles: true,
			        	mediaPrint: false,
			        	stylesheet: base_url + 'assets/receipt.css',
			        	noPrintSelector: ".no-print",
			        	iframe: true,
			        	append: null,
			        	prepend: null,
			        	manuallyCopyFormValues: true,
			        	deferred: $.Deferred(),
			        	timeout: 400,
			        	title: 'Receipt',
			        	doctype: '<!doctype html>'
				});
			})	

		})
	</script>
</body>
</html> 