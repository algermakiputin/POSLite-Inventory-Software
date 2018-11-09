<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Sales Report</h1>
	</div>
<!-- /.col-lg-12 -->
</div>
<div class="row">
 <div class="col-lg-12">
     <div class="panel panel-default">
        	 
         <!-- /.panel-heading -->
         <div class="panel-body">
         		<div class="col-md-6 col-md-offset-3">
			 
			    <div class="input-group input-daterange">

			      <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

			      <div class="input-group-addon">to</div>

			      <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

			    </div>
			</div>
			<div class="col-lg-12">
				<h5><span id="range">Today Sales Report </span><span class="pull-right">Total Sales: <span id="total-sales"></span></span></h5>
				<table class="table table-bordered table-stripped" id="sales_table">
					<thead>
						<tr>
							<th>Date</th>
							<th>Item ID</th>
							<th>Item Name</th>
							<th>Quantity</th>
							<th>Sub Total</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
         </div>
         <!-- /.panel-body -->
     </div>
     <!-- /.panel -->
 </div>
 <!-- /.col-lg-12 -->
</div>

 
 

