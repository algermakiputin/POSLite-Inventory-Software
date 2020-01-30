<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Payments</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				New Payment
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open('PaymentsController/insert', ['method' => 'POST', 'id' => 'payment_form', 'autocomplete' => 'off']) ?> 
						<div class="col-lg-6 col-md-offset-3">
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
								<input type="text" required="required" name="invoice_number" id="invoice_number" class="form-control">
							</div> 
							<div id="payment-area" style="display: none;">
								<div class="form-group">
									<label>Customer Name</label>
									<input type="hidden" name="customer_id" id="customer_id" value="">
									<input type="text" class="form-control" name="customer_name" id="customer_name" readonly="readonly">
								</div>
								<div class="form-group">
									<label>Total Amount</label>
									<input type="text" class="form-control" name="total_amount" id="total_amount" readonly="readonly">
								</div>
								<div class="form-group">
									<label>Payment</label>
									<input type="hidden" name="valid" id="valid" value="0">
									<input type="text" class="form-control" name="payment" id="payment">
								</div>
								<div class="form-group">
									<label>Change</label>
									<input type="text" class="form-control" name="change" id="change" readonly="readonly">
								</div>
								<div class="form-group">
									<label>Note</label>
									<textarea class="form-control" rows="4" name="note"></textarea>
								</div>
								<div class="form-group">
									<button type="button" class="btn btn-success" id="enter-payment">Enter Payment</button>
									<button type="button" class="btn btn-info">Cancel</button>
								</div>
							</div>
							<div class="form-group" id="find-button">
								<button type="button" class="btn btn-primary" id="find-invoice">Enter</button>
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
