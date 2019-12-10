<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Product Returns Report</h1>
	</div> 
    <div class="col-md-12">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    
    <div class="col-lg-12">
     <div class="panel panel-default">
         <div class="panel-heading">
             <i class="fa fa-refresh fa-fw"></i> Product Returns
         </div> 
         <div class="panel-body"> 
            <div class="row">
                <div class="col-md-8" style="margin-bottom: 10px;">
                    <form class="form-inline" autocomplete="off">
                        <div class="form-group">
                            <label>Filter Reports: &nbsp;</label> 
                        </div> 
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <input id="return_from" type="text" class="form-control date-range-filter" name="email" placeholder="From Date" data-date-format="yyyy-mm-dd">
                        </div>
                        &nbsp;
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <input id="return_to" type="text" class="form-control date-range-filter" name="email" placeholder="To Date" data-date-format="yyyy-mm-dd">
                        </div>
                    </form>
                </div>
                <div class="col-md-4 text-right">
                    <div style="padding:10px;font-size: 16px;">
                        <b>Total Refund:</b> <span id="total"></span>
                    </div>
                </div>
            </div>
            <table class="table table-responsive table-striped table-hover table-bordered" id="returns_table" width="100%">
               <thead>
                <tr>
                    <th>Date</th>
                    <th>Staff</th>
                    <th>Barcode</th>
                    <th>Name</th>
                    <th>Quantity</th> 
                    <th>Price</th>
                    <th>Reason</th>
                 </tr>
         </thead>
         <tbody>
            
        </tbody>
    </table>
</div>

</div>

</div>

</div>

