<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Inventory Report</h1>
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
    <div class="col-md-12" style="margin-bottom: 10px;">
        <form class="form-inline" autocomplete="off">
            <div class="form-group">
                <label>Filter Reports: &nbsp;</label> 
            </div> 
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input id="inventory_from" type="text" class="form-control date-range-filter" value="<?php echo date('Y-m-01') ?>" name="date_from" placeholder="From Date" data-date-format="yyyy-mm-dd">
            </div>
            &nbsp;
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input id="inventory_to" type="text" class="form-control date-range-filter" value="<?php echo date('Y-m-t') ?>" name="date_to" placeholder="To Date" data-date-format="yyyy-mm-dd">
            </div>
            &nbsp;
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                <input id="inventory_search" type="text" class="form-control" name="search_product" placeholder="Search Product...">
            </div>
        </form>
    </div>  
    <div class="col-lg-12">
       <div class="panel panel-default">
           <div class="panel-heading">
               Inventory Report
           </div> 
           <div class="panel-body"> 
            <table class="table table-responsive table-striped table-hover table-bordered" id="inventory_reports_table" width="100%">
             <thead>
                <tr>
                    <th>Barcode</th>
                    <th width="23%">Description</th> 
                    <th width="22%">Category</th>
                    <th>Beginning Inventory </th>
                    <th>Purchases</th> 
                    <th>Sales</th> 
                    <th>Breakage</th>
                    <th>Ending Inventory</th> 
                </tr>
            </thead>
                <tbody>

                </tbody>
            </table>
            </div>

        </div> 
    </div> 
</div>
