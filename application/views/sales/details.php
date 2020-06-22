<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Transaction Details</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Full Details  
			</div>
			<div class="panel-body">
				<table>
					<tr>
						<td>Transaction Number:&nbsp;&nbsp;&nbsp;&nbsp; </td>
						<td><?php echo $sale->transaction_number ?></td>
					</tr>
					<tr>
						<td>Sales Person:</td>
						<td><?php echo $sales_person ?></td>
					</tr>
					<tr>
						<td>Customer:</td>
						<td><?php echo $sale->customer_name ?></td>
					</tr>
					<tr>
						<td>Date Time:</td>
						<td><?php echo date('Y-m-d h:i:s a', strtotime($sale->date_time)) ?></td>
					</tr>
				</table> 
			 	<hr>
		 		<table class="table table-striped">
		 			<thead>
		 				<tr>
		 					<th>Description</th>
			 				<th>Price</th>
			 				<th>Quantity</th>
			 				<th>Returned</th>
			 				<th>Discount</th>
			 				<th>Sub Total</th>
		 				</tr>
		 			</thead>
		 			<tbody>
		 				<?php foreach ($orderline as $row): ?>
		 					<tr>
			 					<td><?php echo $row->name ?></td>
			 					<td><?php echo currency() . number_format($row->price, 2) ?></td>
			 					<td><?php echo $row->quantity ?></td>
			 					<td><?php echo $row->returned ?></td>
			 					<td><?php echo $row->discount ?></td>
			 					<td><?php echo currency() . number_format($row->price * $row->quantity - $row->discount, 2) ?></td>

			 					<?php  $total+= $row->price * $row->quantity - $row->discount ?>
			 				</tr>
		 				<?php endforeach; ?>
		 			</tbody>
		 			<tfoot>
		 				<td>
		 					<th colspan="4" class="text-right">TOTAL</th>
		 					<th class=""><?php echo currency() . number_format($total, 2); ?></th>
		 				</td>
		 			</tfoot>
		 		</table>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	 
	<!-- /.col-lg-12 -->
</div>  
