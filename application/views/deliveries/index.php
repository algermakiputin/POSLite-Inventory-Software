<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Deliveries</h1>
	</div>
<!-- /.col-lg-12 -->
</div>
<div class="row">
 <div class="col-lg-12">
     <div class="panel panel-default">
         <div class="panel-heading">
             Deliveries List
         </div>
         <!-- /.panel-heading -->
         <div class="panel-body">	
         	<?php echo $this->session->flashdata('successMessage'); ?>
 			<?php if ($this->session->flashdata('success')): ?>
 				<div class="alert alert-success">
 					<?php echo $this->session->flashdata('success') ?>
 				</div>
 			<?php endif; ?>
 				<div class="toolbar">
 					<div class="row">
 						<div class="col-md-3">
 							<div class="form-group">
 								<select class="form-control" id="delivery_filter_supplier">
 									<option value="">Filter by Supplier</option>
 									<?php foreach ($supplier as $row): ?>
 										<option value="<?php echo $row->id ?>"><?php echo $row->name ?> </option>
 									<?php endforeach; ?>
 								</select>
 							</div>
 						</div>
 						<div class="col-md-3">
 							<div class="form-group has-feedback">
 								<input type="text" name="dates" class="form-control" placeholder="Date Period">
 								 <i class="fa fa-calendar form-control-feedback"></i>
 							</div>
 						</div>
 						 
 					</div>
 				</div>
             <table class="table table-striped table-bordered table-hover table-responsive" id="deliveries_table">
				<thead>
					<tr>
						<th>Delivery ID</th>
						<th>Delivery Date</th>
						<th>Received By</th>
						<th>Supplier</th> 
						<th>Total Amount</th>
						<th>Defectives</th>
						<th>Action</th>
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

 

