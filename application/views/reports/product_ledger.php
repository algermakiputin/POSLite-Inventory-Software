<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Products: <?php echo $product->name; ?></h1>
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
                <input autocomplete="off" id="ledger_from" type="text" class="form-control date-range-filter" placeholder="From Date" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d') ?>">
            </div>
            &nbsp;
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input id="ledger_to" autocomplete="off" type="text" class="form-control date-range-filter" placeholder="To Date" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d') ?>">
            </div>
            <div class="form-group">
                <select class="form-control" id="type">
                    <option value="">All Type</option>
                    <option value="sales">Sales</option>
                    <option value="returns">Returns</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" id="staff">
                    <option value="">All Staff</option>
                    <?php foreach ($staffs as $staff): ?>
                        <option value="<?php echo $staff->username ?>"><?php echo $staff->username ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="button" id="ledger-report">Run Report</button>
            </div>
            <input type="hidden" name="product_id" id="ledger_product" value="<?php echo $product->id; ?>">
        </form>
    </div> 

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Product Sales
            </div> 
            <div class="panel-body">  
                <table class="table table-responsive table-striped table-hover table-bordered" id="product_ledger_tbl" width="100%">
                 <thead>
                    <tr>  
                        <th>Date</th> 
                        <th>Type</th>
                        <th>Staff</th>
                        <th>Product</th>
                        <th>Quantity</th> 
                        <th>Price</th>
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

