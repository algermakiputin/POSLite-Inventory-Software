<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Products: <span id="product-name"><?php echo $product->name; ?></span></h1>
	</div> 

</div>
<div class="row">

    <div class="col-md-12" style="margin-bottom: 10px;">
        <p>History from <?php echo $period; ?></p>
        <!-- <form class="form-inline" autocomplete="off">
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
            </div> -->
          <!--   <div class="form-group">
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
            </div> -->
        <!--     <div class="form-group">
                <button class="btn btn-primary" type="button" id="ledger-report">Run Report</button>
            </div>
            <input type="hidden" name="product_id" id="ledger_product" value="<?php echo $product->id; ?>">
        </form> -->
    </div> 

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Product Sales
            </div> 
            <div class="panel-body">  
                <table class="table table-responsive table-striped table-hover table-bordered" id="product_history" width="100%">
                 <thead>
                    <tr>  
                        <th>Date</th> 
                        <th>Type</th>
                        <th>Staff</th>
                        <th>Product</th>
                        <th>Quantity</th> 
                        <th>Price</th>
                        <th>Total</th> 
                        <th>Running Balance</th>  
                        <th>Stocks</th>
                        <th>Inventory</th>       
                    </tr>
                </thead>
                    <tbody>
                        <?php foreach ($history as $h): ?>
                            <tr>
                                <td><?php echo $h[0] ?></td>
                                <td><?php echo $h[1] ?></td>
                                <td><?php echo $h[2] ?></td>
                                <td><?php echo $h[3] ?></td>
                                <td><?php echo $h[4] ?></td>
                                <td><?php echo $h[5] ?></td>
                                <td><?php echo $h[6] ?></td>
                                <td><?php echo $h[7] ?></td>
                                <td><?php echo $h[8] ?></td>
                                <td><?php echo $h[9] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

        </div> 
    </div> 
</div>

