<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Delivery</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="<?php echo base_url('deliveries') ?>"><i class="fa fa-undo"></i> Back</a> &nbsp; Delivery Details
			</div>
			<div class="panel-body"> 
				<div class="row">
					<div class="col-md-6">
						<table class="table table-bordered">
							<tr>
								<td colspan="2" style="background-color: #f4f4f5;">Order Information</td>
							</tr>
							<tr >
								<th>Supplier:</th>
								<td> <?php echo $delivery->name ?></td>
							</tr>
							<tr>
								<th>Date:</th>
								<td><?php echo $delivery->date_time ?></td>
							</tr>
							<tr>
								<th>Received By:</th>
								<td><?php echo $delivery->received_by ?></td>
							</tr>
							<tr>
								<th>Due Date:</th>
								<td><?php echo $delivery->due_date ?></td>
							</tr>
							<tr>
								<th>Payment Status:</th>
								<td><?php echo $delivery->payment_status ?></td>
							</tr>
						</table>
					</div>
				</div>


				 <table class="table table-bordered table-hover">
				 	<thead>
				 		<tr>
				 			<td colspan="7" style="background-color: #f4f4f5;">Order Summary</td>
				 		</tr>
				 		<tr>
				 			<th>Product Name</th>
					 		<th>QTY</th>
					 		<th>Price</th>
					 		<th>Expiry Date</th>
					 		<th>Defectives</th>
					 		<th>Remarks</th>
					 		<th>Sub Total</th>
				 		</tr>
				 	</thead>
				 	<?php foreach ($deliveryDetails as $key => $details): ?>
				 		<tr>
				 			<td><?php echo $details->product_name ?></td>
				 			<td><?php echo $details->quantities ?></td>
				 			<td><?php echo $details->price ?></td>
				 			<td><?php echo $details->expiry_date ?></td>
				 			<td><?php echo $details->defectives ?></td>
				 			<td><?php echo $details->remarks ?></td>
				 			<td><?php echo currency() . number_format($details->subTotal,2); $total += $details->subTotal ?></td>
				 		</tr>
				 	<?php endforeach; ?>
				 	<tr>
				 		<td colspan="6" class="text-right"><b>Total:</b></td>
				 		<td><?php echo currency() . number_format($total,2) ?></td>
				 	</tr>
				 </table>
			</div>
		 
		</div>
	 
	</div>
 
</div>   