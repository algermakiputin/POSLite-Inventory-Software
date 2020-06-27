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
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control filter-items " data-column="7" name="test">
                <option value="">Filter By Supplier</option>
                <?php foreach ($suppliers as $supplier): ?>
                    <option value="<?php echo $supplier->name ?>"><?php echo $supplier->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control filter-items" data-column="2" name="test">
                <option value="">Filter By Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->name ?>"><?php echo $category->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div> 
    <div class="col-md-6">
        <span class="pull-right" style="font-size: 22px;">Inventory Value: ₱<span id="total"><?php echo $total; ?></span></span>
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
                    <th>Barcode</th>
                    <th>Item Name</th>
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
