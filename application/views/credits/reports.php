<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Credits</h1>
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
    <div class="col-md-12" style="margin-bottom: 10px;">
        <form class="form-inline" autocomplete="off">
            <div class="form-group">
                <label>Filter Customer: &nbsp;</label> 
            </div> 
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                <select id="customer-select" type="text" class="form-control " name="customer-select" style="min-width: 180px">
                    <option value="">Search...</option>
                </select>
            </div>
             &nbsp;
            <div class="form-group">
                <label>Filter Date: &nbsp;</label> 
            </div> 
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input id="expenses_from" type="text" class="form-control date-range-filter" name="email" placeholder="From Date" data-date-format="yyyy-mm-dd">
            </div>
            &nbsp;
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input id="expenses_to" type="text" class="form-control date-range-filter" name="email" placeholder="To Date" data-date-format="yyyy-mm-dd">
            </div>
        </form>
    </div>
  
    <div class="col-lg-12">
       <div class="panel panel-default">
           <div class="panel-heading">
               Customers Credits
           </div> 
           <div class="panel-body"> 
            <table class="table table-responsive table-striped table-hover table-bordered" id="credits_datatable" width="100%">
             <thead>
                <tr>
                    <th width="20%">Date</th>
                    <th width="20%">Customer</th>
                    <th width="20%">Invoice#</th>
                    <th width="20%">Due Date</th> 
                    <th width="20%">Action</th>
                </tr>
            </thead>
                <tbody>

                </tbody>
            </table>
            </div>

        </div> 
    </div> 
</div>

