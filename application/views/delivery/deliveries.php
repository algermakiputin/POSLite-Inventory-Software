<div class="col-sm-10" id="main">
	<div class="table-wrapper">
		<h1 class="page-title">Deliveries</h1>
		
		<table class="table table-striped table-bordered table-hover table-responsive" id="deliveries_table">
			<thead>
				<tr>
					<th>Supplier Name</th>
					<th>Item Name</th>
					<th>Price</th> 
					<th>Quantity</th>
					<th>Expirty Date</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($dataSet as $data): ?> 
					<tr>
						<td><?php echo $data['supplier_name'] ?></td>
						<td><?php echo $data['item'] ?></td>
						<td><?php echo $data['price'] ?></td>
						<td><?php echo $data['quantity'] ?></td>
						<td><?php echo $data['expiry_date'] ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</div>
<div class="clearfix"></div>

