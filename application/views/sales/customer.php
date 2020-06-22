<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Customer Sales</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				Options 

			</div>
			<div class="panel-body">
				 <form>
				 	<div class="form-group">
				 		<label>From Date</label>
				 		<input type="text" placeholder="From " class="date-range-filter form-control" name="from" id="customer_from">
				 	</div>
				 	<div class="form-group">
				 		<label>To Date</label>
				 		<input type="text" placeholder="To " class="date-range-filter form-control" data-date-format="yyyy-mm-dd" name="from" id="customer_to">
				 	</div>
				 	<div class="form-group">
				 		<label>Select Customer</label>
				 		<select class="form-control" id="select-customer">
				 			
				 		</select>
				 	</div>
				 	<div class="form-group">
				 		<button class="btn btn-primary btn-sm" id="customer-run-reports" type="button">Run Reports</button>
				 	</div>
				 </form>
		 
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				Sales
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<p>To show customer reports. Select date time period and customer then run the reports. </p>
					</div>
					<div class="col-md-4 text-right">
						<b>Total: <span id="customer-total-sales">0.00</span></b>
					</div>
				</div>
				<table class="table table-bordered table-striped" id="customer_sales_table">
					<thead>
						<tr>
							<th>Order Number</th>
							<th>Date Time</th>
							<th>Sales Person</th>
							<th>Total Amount</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
		 	
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  


<!-- <script type="text/javascript">
	
	$(document).ready(function() {

		$("body").on('click', '.popup', function(e) {

			e.preventDefault();
			var link = $(this).attr('href');

			window.open(''+link+'', 'popup', 'width=700', 'height=700')
		});
	})
</script> -->