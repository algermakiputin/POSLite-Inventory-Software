<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Reports</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">  
	<div class="col-lg-12">
		<ul class="nav nav-tabs">
		  <li role="presentation"><a href="<?php echo base_url('reports') ?>">Description</a></li>
		  <li role="presentation" class="active"><a href="#">Product Sales</a></li>
		  <li role="presentation"><a href="<?php echo base_url('reports/best-seller') ?>">Best Seller</a></li>
		  <li role="presentation"><a href="<?php echo base_url('reports/category') ?>">Category Sales</a></li>
		  <li role="presentation"><a href="<?php echo base_url('reports/summary') ?>">Summary</a></li>
		</ul>  
		<div class="wrapper">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Item ID</th>
						<th>Product Name</th>
						<th>Qty Sold</th>
						<th>Unit Cost</th>
						<th>Total Sales</th>
					</tr>
				</thead> 
				<tbody>
					<?php foreach ($products as $product): ?>
						<tr>
							<td><?php echo $product->item_id ?></td>
							<td><?php echo $product->name ?></td>
							<td><?php echo $product->quantity ?> units</td>
							<td><?php echo currency() . number_format($product->price,2) ?></td>
							<td><?php echo currency() . number_format($product->total,2) ?></td>
						</tr>
						<?php
							$total_sales += $product->total;
						?>
					<?php endforeach; ?>
				</tbody>
				<legend>Total Sales: <?php echo currency() . number_format($total_sales,2) ?></legend>
			</table>
		</div>
	</div>
 
</div>

<style type="text/css">
	.wrapper {
		border-right: solid 1px #ddd;
		border-left: solid 1px #ddd;
		border-bottom: solid 1px #ddd;
		padding: 20px 10px 10px 10px;
	}
</style>
 

