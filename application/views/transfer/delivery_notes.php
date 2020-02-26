<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Delivery Notes</h1>
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
                    echo store_selector_component(['form-control', 'limit'], "delivery-notes-store-filter");
                ?>
            </div>
  
            <table class="table table-responsive table-striped table-hover table-bordered" id="delivery-notes-tbl" width="100%">
               <thead>
                <tr>
                    <th >Date</th>
                    <th>DM #</th>
                    <th >P.O. #</th>
                    <th>Plate Number</th>
                    <th>Driver</th>
                    <th>Status</th>
                    <th >Note</th>  
                 </tr>
         </thead>
         <tbody>
            
        </tbody>
    </table>
</div>

</div>

</div>

</div>
