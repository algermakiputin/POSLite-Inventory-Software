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
		  <li role="presentation"><a href="<?php echo base_url('reports/category') ?>">Category Sales</a></li>
		  <li role="presentation" class="active"><a href="#">Summary</a></li>
		</ul>  
		<div class="wrapper">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Transaction Number</th>
						<th>Date</th>
						<th>Sales Person</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($descriptions as $description): ?>
						<tr>
							<td><?php echo $description->transaction_number ?></td>
							<td><?php echo date('Y-m-d', strtotime($description->date_time)) ?></td>
							<td><?php echo $description->username ?></td>
							<td><?php echo currency() . number_format($description->total,2) ?></td>
							<?php 
								$total_sales += $description->total;
							?>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<legend>Total: <?php echo currency() . number_format($total_sales,2); ?></legend>
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
 

