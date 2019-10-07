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
		  <li role="presentation"><a href="<?php echo base_url('reports/products') ?>">Product Sales</a></li>
		  <li role="presentation" class="active"><a href="#">Best Seller</a></li>
		  <li role="presentation"><a href="<?php echo base_url('reports/category') ?>">Category Sales</a></li>
		  <li role="presentation"><a href="<?php echo base_url('reports/summary') ?>">Summary</a></li>
		</ul>  
		<div class="wrapper">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Rank</th>
						<th>Product Name</th>
						<th>Sold</th>
						<th>Sales</th>
					</tr>
				</thead>
				<tbody>
					<?php $rank = 1; ?>
				 	<?php foreach ($products as $product): ?>

				 		<tr>
				 			<td><?php echo $rank ?></td>
				 			<td><?php echo $product->name ?></td>
				 			<td><?php echo $product->sold ?></td>
				 			<td><?php echo currency() . number_format($product->total,2) ?></td>
				 		</tr>
				 		<?php $rank++; ?>
				 	<?php endforeach; ?> 
				</tbody> 
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
 

