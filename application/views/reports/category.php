<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Reports</h1>
	</div> 
</div>
<div class="row">  
	<div class="col-lg-12">
		<ul class="nav nav-tabs">
		  <li role="presentation" ><a href="<?php echo base_url('reports') ?>">Description</a></li>
		  <li role="presentation"><a href="<?php echo base_url('reports/products') ?>">Product Sales</a></li>
		  <li role="presentation"><a href="<?php echo base_url('reports/best-seller') ?>">Best Seller</a></li>
		  <li role="presentation" class="active"><a href="#">Category Sales</a></li>
		  <li role="presentation"><a href="<?php echo base_url('reports/summary') ?>">Summary</a></li>
		</ul>  
		<div class="wrapper">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Transaction Number</th>
						<th>Date</th>
						<th>Sales Person</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
				 
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
 
