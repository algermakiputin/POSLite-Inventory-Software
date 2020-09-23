<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Products
            
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
    <div class="col-md-8">
        <div class="form-inline" autocomplete="off" style="margin-bottom: 12px;">
             <form method="GET" action="<?php echo base_url('VariationsController/export_variations') ?>">
            <div class="form-group">
                <select class="form-control filter-items " data-column="7" name="test">
                    <option value="">Filter By Supplier</option>
                    <?php foreach ($suppliers as $supplier): ?>
                        <option value="<?php echo $supplier->name ?>"><?php echo $supplier->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>  
            <div class="form-group">
                <select class="form-control filter-items" data-column="2" name="category" id="category">
                    <option value="">Filter By Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" data-column="8" name="condition" id="condition">
                    <option value="">Filter By Condition</option>
                    <option value="0">Brand New</option>
                    <option value="1">Used</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default" type="button" id="export_variations"><i class="fa fa-file-excel-o"></i> Export Variations</button> 
            </div>
            </form>
        </div>
    </div> 
    <div class="col-md-4">
        <span class="pull-right" style="font-size: 22px;">Inventory Value: ₱<span id="total"><?php echo $inventory_value; ?></span></span>
    </div>
</div>
<div class="row">  

     
    <div class="col-lg-12">
     <div class="panel panel-default">

         <div class="panel-heading">
             <span class="fa fa-inbox fa-fw"></span> Items List

         </div>

         <!-- /.panel-heading -->
         <div class="panel-body">
             <table class="table table-responsive table-hover table-bordered" id="item_tbl" width="100%">
               <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Condition</th>
                    <th>Supplier</th>
                    <th>Category</th>  
                    <th>Capital</th> 
                    <th>Price</th>
                    <th>Stocks</th>
                    <th>Total</th> 
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
        </div>

    <!-- /.col-lg-12 -->
    </div>
    </div> 
</div>
