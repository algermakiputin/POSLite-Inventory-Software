<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Returns / Refund</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Refund Summary
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered" style="max-width: 35%"> 
					<tr>
						<td>Date:</td>
						<td><?php echo $refund->date_time ?></td>
					</tr>
					<tr>
						<td>Invoice Number:</td>
						<td><?php echo $refund->invoice_number ?></td>
					</tr>
					<tr>
						<td>Staff:</td>
						<td><?php echo $refund->staff ?></td>
					</tr>
					<tr>
						<td>Customer:</td>
						<td><?php echo $refund->customer_name ?></td>
					</tr>
					<tr>
						<td>Reason:</td>
						<td><?php echo $refund->reason ?></td>
					</tr>
				</table>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  

<div class="row"  id="refund_form">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Order Details
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open('RefundsController/insert', ['method' => 'POST', 'autocomplete' => 'off']) ?> 
						<div class="col-lg-12 ">
						 	 <table class="table table-bordered table-hover table-striped" id="order-description"> 
						 	 	<thead>
						 	 		<tr>
						 	 			<td width="60%">Description</td>
						 	 			<th width="20%">Price</th> 
						 	 			<th width="20%">Refund Qty</th>
						 	 		</tr>
						 	 	</thead>
					 	 		<tbody> 
					 	 			<?php foreach ($details as $row): ?>
					 	 				<tr>
					 	 					<td><?php echo $row->item_name ?></td>
					 	 					<td><?php echo $row->price ?></td>
					 	 					<td><?php echo $row->quantity ?></td>
					 	 				</tr>
					 	 			<?php endforeach; ?>
					 	 		</tbody>
						 	 </table> 
						</div>
					<?php echo form_close(); ?>
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  
