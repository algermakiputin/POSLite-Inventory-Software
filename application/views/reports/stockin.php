<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Stockin Report</h1>
	</div> 
   
</div>
<div class="row">
   
    <div class="col-lg-12">
     <div class="panel panel-default">
         <div class="panel-heading">
              Reports
         </div> 
         <div class="panel-body"> 
            <div class="row">
                <div class="col-md-6" style="margin-bottom: 10px;">
                    <form class="form-inline" autocomplete="off">
                        <div class="form-group">
                            <label>Filter Reports: &nbsp;</label> 
                        </div> 
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <input id="stockin_from" type="text" class="form-control date-range-filter" name="email" placeholder="From Date" data-date-format="yyyy-mm-dd">
                        </div>
                        &nbsp;
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <input id="stockin_to" type="text" class="form-control date-range-filter" name="email" placeholder="To Date" data-date-format="yyyy-mm-dd">
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    <div style="padding:10px;font-size: 16px;">
                        <b>Total:</b> <span id="total"></span>
                    </div>
                </div>
            </div>
            <table class="table table-responsive table-striped table-hover table-bordered" id="stockin_tbl" width="100%">
               <thead>
                <tr> 
                    <th>Date</th> 
                    <th>Item ID</th>
                    <th>Name</th>
                    <th>Received By</th>
                    <th>Qty</th> 
                    <th>Price</th>
                    <th>Defectives</th>
                    <th>Total</th>
                 </tr>
         </thead>
         <tbody>
            
        </tbody>
    </table>
</div>

</div>

</div>

</div>

