<div class="col-sm-10" id="main">
	<div class="table-wrapper">
		<h1 class="page-title">Deliveries</h1>
		
		<table class="table table-striped table-bordered table-hover table-responsive">
			<tr>
				<th>Supplier Name</th>
				<th>Item Name</th>
				<th>Price</th> 
				<th>Quantity</th> 
			</tr>
		 
			 <?php foreach($dataSet as $data): ?> 
			 	<tr>
			 		<td><?php echo $data['supplier_name'] ?></td>
			 		<td><?php echo $data['item'] ?></td>
			 		<td><?php echo $data['price'] ?></td>
			 		<td><?php echo $data['quantity'] ?></td>
			 	</tr>
			 <?php endforeach; ?>
		</table>
	</div>

</div>
<div class="clearfix"></div>

 