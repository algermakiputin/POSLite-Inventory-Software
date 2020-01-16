<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Reports</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- <div class="row">
				<div class="col-md-8">
					<form class="form-inline" autocomplete="off" novalidate="" style="width: ">
						<div class="form-group">
							<label>Filter Reports: &nbsp;</label> 
						</div> 
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							<input id="expenses_from" type="text" class="form-control date-range-filter" name="email" placeholder="From Date" data-date-format="yyyy-mm-dd">
						</div>
						&nbsp;
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							<input id="expenses_to" type="text" class="form-control date-range-filter" name="email" placeholder="To Date" data-date-format="yyyy-mm-dd">
						</div>
					</form>
				</div>
				<div class="col-md-6 text-right">
					<span>Today's Report <?php echo date('Y-m-d') ?></span>
				</div>
			</div>
			<br/> -->
<div class="row">  

	<div class="col-lg-12">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="#">Description</a></li>
			<li role="presentation"><a href="<?php echo base_url('reports/products') ?>">Product Sales</a></li>
			<li role="presentation"><a href="<?php echo base_url('reports/best-seller') ?>">Best Seller</a></li>
			<li role="presentation"><a href="<?php echo base_url('reports/category') ?>">Category Sales</a></li>
			<li role="presentation"><a href="<?php echo base_url('reports/summary') ?>">Summary</a></li>
		</ul>  

		<div class="wrapper">

			<table class="table table-striped table-bordered" id="sales-description-tbl">
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
legend {
	margin-bottom: 10px;
	padding: 0;
}
</style>


