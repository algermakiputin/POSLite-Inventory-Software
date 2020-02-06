<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Purchase Orders</h1>
	</div> 
    <div class="col-md-12">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
        <div class="form-group"> 
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="row">  
    <div class="col-lg-12">
    
    
     <div class="panel panel-default">
         <div class="panel-heading">
             Purchase Orders
         </div> 
         <div class="panel-body"> 
            <table class="table table-responsive table-striped table-hover table-bordered" id="purchase-order-tbl" width="100%">
               <thead>
                <tr>
                    <th width="20%">P.O. Date</th>
                    <th width="20%">P.O. No.</th>
                    <th width="20%">Supplier</th>
                    <th width="20%">Memo</th> 
                    <th width="20%">Actions</th>
                 </tr>
         </thead>
         <tbody>
            
        </tbody>
    </table>
</div>

</div>

</div>

</div>