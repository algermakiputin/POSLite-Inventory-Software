<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Expenses</h1>
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
    <div class="col-md-8" style="margin-bottom: 10px;">
        <form class="form-inline" autocomplete="off">
            <div class="form-group">
                <label>Filter Reports: &nbsp;</label> 
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
    <div class="col-md-4 text-right">
        <div style="padding:10px;font-size: 16px;">
            <b>Total Expenses:</b> <span id="total"></span>
        </div>
    </div>
    <div class="col-lg-12">
       <div class="panel panel-default">
           <div class="panel-heading">
               <i class="fa fa-money fa-fw"></i> Expenses List
           </div> 
           <div class="panel-body"> 
            <table class="table table-responsive table-striped table-hover table-bordered" id="expenses_table" width="100%">
             <thead>
                <tr>
                    <th width="20%">Type</th>
                    <th width="20%">Expense Name</th>
                    <th width="20%">Cost</th>
                    <th width="20%">Date</th> 
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

