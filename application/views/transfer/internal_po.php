<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Internal Purchase Orders</h1>
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
         
            <div style="background-color: #eee;padding: 10px;border:solid 1px #ddd;margin-bottom: 20px;">
                <label>Select Store:</label>
                <?php 
                    echo store_selector_component(['form-control', 'limit'], "transfer-purchase-order-filter");
                ?>
            </div>
  
            <table class="table table-responsive table-striped table-hover table-bordered" id="transfer-purchase-order-tbl" width="100%">
               <thead>
                <tr>
                    <th >P.O. Date</th>
                    <th >P.O. No.</th>
                    <th>Branch / Store</th>
                    <th >Requested To</th> 
                    <th>Status</th>
                    <th >Memo</th>
                    <th >Actions</th>
                 </tr>
         </thead>
         <tbody>
            
        </tbody>
    </table>
</div>

</div>

</div>

</div>
