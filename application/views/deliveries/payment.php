<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Payment</h1>
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
					<?php echo form_open('PurchasePaymentsController/insert', ['method' => 'POST', 'autocomplete' => 'off']) ?> 
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
						 	<input type="hidden" name="purchase_id" value="<?php echo $purchase->id ?>">
						 	<div class="form-group">
						 		<label>Purchase Number</label>
						 		<input type="text" class="form-control" name="purchase_number" value="<?php echo $purchase->purchase_number ?>">
						 	</div>
						 	<div class="form-group">  
						 		<label>Date</label>
								<input type="text" required="required" placeholder="Date" name="date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d') ?>">
							</div> 
							<div class="form-group"> 
								<label>Total</label> 
								<input type="text" id="total" value="<?php echo $total ?>" required="required" name="total" id="total" class="form-control">
							</div>
						 
							<div class="form-group">  
								<label>Payment</label>
								<input type="number"  required="required" name="payment" id="purchase-payment" class="form-control">
							</div>

							<div class="form-group">  
								<label>Change</label>
								<input type="text"  required="required" name="change" id="purchase-change" class="form-control">
							</div>
							<div class="form-group">
								<input type="submit" name="" value="Save" class="btn btn-primary">
								<button type="reset" class="btn btn-info">Reset</button>
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


<script type="text/javascript">
	
	$(document).ready(function(e) {

		$("#purchase-payment").keyup(function(e) {

			 
			var payment = parseFloat( $(this).val());
			var total = parseFloat($("#total").val());
			var change = parseFloat(payment - total) ?? 0;


			if (payment >= total) { 

			}
 

	 		$("#purchase-change").val(change);
 			


		})
	})
</script>