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
                <div class="row">
                    <div class="col-md-6">
                        <select class="form-control" style="max-width: 230px;font-size: 14px;display: inline-block;" id="filter_expiry">
                            <option value="1">Expiring in 1 Month</option>
                            <option value="2">Expiring in 3 Month</option>
                            <option value="3">Expiring in 6 Month</option>
                            <option value="4">Expiring in 1 Year</option>
                            <option value="5">Expired (Past 3 Months)</option>
                        </select> &nbsp;&nbsp;
                        <input type="text" class="form-control" placeholder="Search by Product Name" id="search_expiry" style="max-width: 230px;display: inline-block;font-size: 14px;" name="">
                    </div>
                    <div class="col-md-6 text-right">
                        
                    </div>
                </div>
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

