<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Sales Report</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">  
	<div class="col-lg-12">
		<div style="background-color: #eee;padding: 10px;margin-bottom: 20px;">
			<label>Select Store:</label>
			<?php 
                echo store_selector_component(['form-control', 'limit'], "sales-store-filter");
            ?>
		</div>
	</div>
	<div class="col-lg-9">

		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="#">Sales</a></li>
		  <li role="presentation"><a href="<?php echo base_url('reports/cash') ?>">Cash</a></li>
		  <li role="presentation"><a href="<?php echo base_url('reports/credit') ?>">Receivables</a></li> 
		</ul>  
		<div class="wrapper">
			<table class="table table-striped table-bordered" id="sales_table">
				<thead>
					<tr>
						<th>Date</th>
						<th>Profit</th>
						<th>Staff</th>
						<th>Item Name</th> 
						<th>Quantity</th>
						<th>Price</th>
						<th>Discount</th>
						<th>Total</th>  
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
	 
				</tbody> 
			</table>
		</div>
	</div>
	<div class="col-md-3">
 		<div style="border:solid 1px #ddd;padding: 20px;">
 			<h4>Filter Report</h4>
 			<div class="form-group">
 				<label>From</label>
 				<input type="text" name="from_date" value="<?php echo date('Y-m-d') ?>" class="form-control date-range-filter" autocomplete="off" id="min-date" data-date-format="yyyy-mm-dd">
 			</div>
 			<div class="form-group">
 				<label>To</label>
 				<input type="text" name="to_date" value="<?php echo date('Y-m-d') ?>" class="form-control date-range-filter" autocomplete="off" id="max-date" data-date-format="yyyy-mm-dd">
 			</div>
 			<div> 
 				<hr>
 				<h3><span class="small">total sales:</span> <span id="total-sales"></span></h3>
 			</div>
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
 

