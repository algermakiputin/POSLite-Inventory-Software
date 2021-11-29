<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Refunds</h1>
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
                <label>Store: &nbsp;</label>
            </div>
            <div class="input-group">
                
                <?php 
                    echo store_selector_component(['form-control', 'filter-left']);
                ?>  
            </div>
            <div class="form-group">
                <label>&nbsp; Filter Reports: &nbsp;</label> 
            </div> 
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input id="refunds_from" type="text" class="form-control date-range-filter" name="date_range" placeholder="From Date" data-date-format="yyyy-mm-dd">
            </div>
            &nbsp;
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input id="refunds_to" type="text" class="form-control date-range-filter" name="date_range" placeholder="To Date" data-date-format="yyyy-mm-dd">
            </div>
        </form>
    </div> 
    <div class="col-lg-12">
     <div class="panel panel-default">
         <div class="panel-heading">
             <i class="fa fa-refresh fa-fw"></i> Refunds List
         </div> 
         <div class="panel-body"> 
            <table class="table table-responsive table-striped table-hover table-bordered" id="refunds_table" width="100%">
               <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice Number</th>
                    <th>Staff</th>
                    <th>Customer Name</th> 
                    <th>Reason</th>
                    <th>Actions</th>
                 </tr>
         </thead>
         <tbody>
            
        </tbody>
    </table>
</div>

</div>

</div>

</div>
