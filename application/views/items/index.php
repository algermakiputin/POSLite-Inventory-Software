<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Products
            <!-- <span class="pull-right">Inventory Value: ₱<span id="total"><?php echo $total; ?></span></span> -->
        </h1> 
    </div>
    <div class="col-md-12">
        <?php 
        echo $this->session->flashdata('errorMessage');
        echo $this->session->flashdata('successMessage'); 
        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12" style="padding-bottom: 10px;">
        <div style="background: #eee;padding: 10px;border:solid 1px #ddd;border-radius: 0.5em">
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#filter-options">
                <i class="fa fa-cog"></i> Filter Options
            </button>
            <a class="pull-right btn btn-default" href="<?php echo base_url('items/new') ?>">
                <i class="fa fa-plus"></i>
            Add Product</a>
            <div style="padding: 10px 0 0 0;" id="filter-options" class="collapse">
                <div class="row">
                    <div class="col-md-3">
                        <div>
                            <select name="category" class="form-control filter-items" data-column="2">
                                <option value="">Filter By Category</option>
                                <?php foreach ($categories as $key => $category): ?>
                                    <option value="<?php echo ucwords($category->name) ?>"><?php echo ucwords($category->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <select  name="supplier" class="form-control filter-items" data-column="7">
                                <option value="">Filter By Supplier</option>
                                <?php foreach ($suppliers as $key => $supplier): ?>
                                    <option value="<?php echo $supplier->name; ?>"><?php echo ucwords($supplier->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <select name="price" class="form-control filter-items" data-column="4">
                                <option value="">Filter By Price</option>
                                <option value="DESC">Highest to Lowest</option>
                                <option value="ASC">Lowest to Highest</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <select name="stocks" class="form-control filter-items" data-column="5">
                                <option value="">Filter By Stocks</option>
                                <option value="DESC">Highest to Lowest</option>
                                <option value="ASC">Lowest to Highest</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button style="margin-top: 5px" class="btn btn-info" id="clear-filter">Clear Filter</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-12">
     <div class="panel panel-default">

         <div class="panel-heading">
             Items List

         </div>

         <!-- /.panel-heading -->
         <div class="panel-body">
             <table class="table table-responsive table-hover table-bordered" id="item_tbl">
               <thead>
                <tr>
                    <th width="8%">&nbsp;</th>
                    <th width="20%">Item Name</th>
                    <th width="10%">Category</th> 
                    <th width="11%">Capital Per/Item</th>
                    <th width="11%">Retail Price</th>
                    <th width="10%">Stocks</th>
                    <th width="10%">Total</th>
                    <th width="10%">Supplier</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
             

            </tbody>
        </table>
    </div>
    <!-- /.panel-body -->
</div>
<!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
</div>
