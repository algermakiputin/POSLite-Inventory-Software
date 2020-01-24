<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Credit Sales Report</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">  
	<div class="col-lg-12">
		<div style="background-color: #eee;padding: 10px;margin-bottom: 20px;">
			<label>Select Store:</label>
			<?php 
                echo store_selector_component(['form-control', 'limit'], "cash-store-filter");
            ?>
		</div>
	</div>
	<div class="col-lg-9">
		<ul class="nav nav-tabs">
		  <li role="presentation" ><a href="<?php echo base_url('reports/cash') ?>">Cash</a></li>
		  <li role="presentation" class="active"><a href="">Credits</a></li> 
		</ul>  
		<div class="wrapper">
			<table class="table table-striped table-bordered" id="credits-tbl">
				<thead>
					<tr>
						<th>Invoice Number</th>
						<th>Customer</th>
						<th>Total Amount</th>
						<th>Note</th>
						<th>Status</th>
						<th>Actions</th>
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
 				<input type="date" name="from" class="form-control" id="from">
 			</div>
 			<div class="form-group">
 				<label>To</label>
 				<input type="date" name="from" class="form-control" id="to">
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
 

