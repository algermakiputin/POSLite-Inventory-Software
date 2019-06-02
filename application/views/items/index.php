<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Products
            <span class="pull-right">Inventory Value: ₱<span id="total"><?php echo $total; ?></span></span>
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
