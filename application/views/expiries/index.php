<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Expiries</h1>
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
             <i class="fa fa-hourglass-end fa-fw"></i> Expired Products List
         </div> 
         <div class="panel-body"> 
            <table class="table table-responsive table-striped table-hover table-bordered" id="expiry_table" width="100%">
               <thead>
                <tr>
                    <th>Date</th>
                    <th>Barcode</th>
                    <th>Name</th>
                    <th>Quantities</th>
                    <th>Price</th> 
                    <th>Capital</th>
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

