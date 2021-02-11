<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Payments</h1>
	</div> 
    <div class="col-md-12">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="row">

    <div class="col-md-12" style="margin-bottom: 10px;">
        <form class="form-inline" autocomplete="off">
            <div class="form-group">
                <label>Filter Customer: &nbsp;</label> 
            </div> 
            <div class="input-group" id="select-wrapper">
                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                <select id="customer-select-payments" type="text" class="form-control " name="customer-select" style="min-width: 180px">
                    <option value="">Search...</option>
                </select>
            </div>
             &nbsp;
            <div class="form-group">
                <label>Filter Date: &nbsp;</label> 
            </div> 
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input id="payments_from" autocomplete="off" type="text" class="form-control date-range-filter" name="credit_from" placeholder="From Date" data-date-format="yyyy-mm-dd">
            </div>
            &nbsp;
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input id="payments_to" autocomplete="off" type="text" class="form-control date-range-filter" name="credit_to" placeholder="To Date" data-date-format="yyyy-mm-dd">
            </div>
        </form>
    </div>
  
    <div class="col-lg-12">
       <div class="panel panel-default">
           <div class="panel-heading">
               Customers Credits
           </div> 
           <div class="panel-body"> 
            <table class="table table-responsive table-striped table-hover table-bordered" id="payments_datatable" width="100%">
             <thead>
                <tr>
                    <th>Date</th> 
                    <th>Invoice#</th>
                    <th>Customer</th> 
                    <th>Total</th> 
                    <th>Amount Paid</th> 
                    <th>Action</th>
                </tr>
            </thead>
                <tbody>

                </tbody>
            </table>
            </div>

        </div> 
    </div> 
</div>

