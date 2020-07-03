<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Expiry Date</h1>
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
               Products Expiry Date Records
           </div> 
           <div class="panel-body"> 
                <table id="expiry_date_table" class="table table-bordered table-striped"  width="100%">
                    <thead>
                        <th>Delivery Date</th>
                        <th>Expiry Date</th>
                        <th>Days Remaining</th>
                        <th>Product Name</th>
                        <th>Quantity To Expire</th>
                        <th>Current Stocks</th>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>

        </div> 
    </div> 
</div>

