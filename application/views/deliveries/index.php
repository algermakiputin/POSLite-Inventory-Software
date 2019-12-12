<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Deliveries</h1>
	</div>
<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-md-12" style="margin-bottom: 10px;">
        <form class="form-inline" autocomplete="off">
            <div class="form-group">
                <label>Filter Reports: &nbsp;</label> 
            </div> 
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input id="deliveries_from" type="text" class="form-control date-range-filter" name="email" placeholder="From Date" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d') ?>">
            </div>
            &nbsp;
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input id="deliveries_to" type="text" class="form-control date-range-filter" name="email" placeholder="To Date" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d') ?>">
            </div>
        </form>
    </div>
 <div class="col-lg-12">
     <div class="panel panel-default">
         <div class="panel-heading">
             Deliveries List
         </div>
         <!-- /.panel-heading -->
         <div class="panel-body">	
 			<?php if ($this->session->flashdata('success')): ?>
 				<div class="alert alert-success">
 					<?php echo $this->session->flashdata('success') ?>
 				</div>
 			<?php endif; ?>
             <table class="table table-striped table-bordered table-hover table-responsive" id="deliveries_table">
				<thead>
					<tr>
						<th>Date</th>
						<th>Name</th>
                        <th>Capital</th>
                        <th>Retail Price</th>
						<th>Quantity</th>
						<th>Received By</th>
						<th>Supplier</th> 
						<th>Total Amount</th>
						<th>Defectives</th> 
						<th>Remarks</th>
					</tr>
				</thead>

				<tbody>  
				</tbody>
			</table>
			
		</table>
         </div>
         <!-- /.panel-body -->
     </div>
     <!-- /.panel -->
 </div>
 <!-- /.col-lg-12 -->
</div>

 

