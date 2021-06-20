<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Transactions</h1>
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
                <label>Filters: &nbsp;</label> 
            </div> 
            <div class="input-group" id="select-wrapper">
                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                <select id="staff-select" type="text" class="form-control " name="customer-select" style="min-width: 180px">
                    <option value="">Select Staff...</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user->id ?>"><?php echo $user->name ?></option>
                    <?php endforeach; ?>

                </select>
            </div>
             &nbsp; 
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input id="transactions_from" value="<?php echo date('Y-m-1') ?>" autocomplete="off" type="text" class="form-control date-range-filter" name="" placeholder="From Date" data-date-format="yyyy-mm-dd">
            </div>
            &nbsp;
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input id="transactions_to" value="<?php echo date('Y-m-t') ?>" autocomplete="off" type="text" class="form-control date-range-filter" name="" placeholder="To Date" data-date-format="yyyy-mm-dd">
            </div>
        </form>
    </div>
  
    <div class="col-lg-12">
       <div class="panel panel-default">
           <div class="panel-heading">
               Transactions Report
           </div> 
           <div class="panel-body"> 
            <table class="table table-responsive table-striped table-hover table-bordered" id="transactions_datatable" width="100%">
             <thead>
                <tr>
                    <th>Date</th> 
                    <th>Invoice#</th>
                    <th>Staff</th>
                    <th>Customer</th> 
                    <th>Payment</th>
                    <th>Discount</th>
                    <th>Total</th> 
                    <th>Note</th> 
                </tr>
            </thead>
                <tbody>

                </tbody>
            </table>
            </div>

        </div> 
    </div> 
</div>

