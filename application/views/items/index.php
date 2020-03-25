<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Products
            <span class="pull-right" style="font-size: 22px;margin-top: 10px;">Inventory Value: ₱<span id="total"><?php echo $total; ?></span></span>
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
             <span class="fa fa-inbox fa-fw"></span> Items List

         </div>

         <!-- /.panel-heading -->
         <div class="panel-body">
             <table class="table table-responsive table-hover table-bordered" id="item_tbl" width="100%">
               <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Item Name</th>
                    <th>Category</th>  
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
