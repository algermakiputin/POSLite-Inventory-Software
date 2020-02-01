<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Returns / Refund</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				New Returns / Refund
			</div>
			<div class="panel-body">
				<div class="row">
					 
					<div class="col-lg-4 ">
					 	<?php if ($this->session->flashdata('success')): ?>
					 		<div class="form-group"> 
					 			<div class="alert alert-success">
					 				<?php echo $this->session->flashdata('success') ?>
					 			</div>
					 		</div>
					 	<?php endif; ?>
					 	<div class="form-group">
					 		<?php echo validation_errors(); ?>
					 	</div>
					 	<div class="form-group">  
					 		<label>Invoice Number</label>
							<input type="text" required="required" autocomplete="off" id="invoice_number" name="invoice_number" class="form-control">
						</div> 
						<div class="form-group">
							<input type="submit" name="" value="Submit" id="return-invoice" class="btn btn-default">
							<button type="reset" class="btn btn-secondary">Reset</button>
						</div>
					</div>
				 
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  

<div class="row" style="display: none;"  id="refund_form">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Order Details
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open('RefundsController/insert', ['method' => 'POST', 'autocomplete' => 'off']) ?> 
						<div class="col-lg-12 ">
						 	 <table class="table table-bordered table-hover table-striped" id="order-description"> 
						 	 	<thead>
						 	 		<tr>
						 	 			<td width="40%">Description</td>
						 	 			<th width="20%">Price</th>
						 	 			<th width="20%">Qty</th>
						 	 			<th width="20">Refund Qty</th>
						 	 		</tr>
						 	 		</thead>
						 	 		<tbody> 
						 	 		</tbody>
						 	 </table>
						 	  <div class="form-group">
						 	 	<label>Customer Name:</label>
						 	 	<input type="hidden" name="invoice_number" id="invoice">
						 	 	<input type="text" class="form-control" id="customer_name" name="customer_name" style="max-width:330px;">
						 	 </div> 
						 	 <div class="form-group">
						 	 	<label>Reason:</label>
						 	 	<input type="text" class="form-control" name="reason" style="max-width:330px;">
						 	 </div>
						 	 <div class="form-group">
						 	 	<button type="submit" class="btn btn-primary">Submit</button>
						 	 </div>
						</div>
					<?php echo form_close(); ?>
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  
