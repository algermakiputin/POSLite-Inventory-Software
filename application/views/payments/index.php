<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Payments</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div style="border:solid 1px #ddd;padding: 20px;border-radius: 5px;">
			<div class="row">
				<div class="col-md-3">
					<h3>Credit Details</h3>
					<table class="table table-bordered">
						<tr>
							<td>Credit NO.</td>
							<td><?php echo $credit->transaction_number; ?></td>
						</tr>
						<tr>
							<td>Customer Name:</td>
							<td><?php echo $credit->customer_name; ?></td>
						</tr>
						<tr>
							<td>Date:</td>
							<td><?php echo date('m/d/Y', strtotime($credit->date_time)); ?></td>
						</tr>
						<tr>
							<td>Note:</td>
							<td><?php echo $credit->note; ?></td>
						</tr>
					</table>
				</div> 
				<?php echo form_open('PaymentsController/store', ['method' => 'POST', 'autocomplete' => 'off']) ?> 
					<div class="col-lg-6">
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
						<input type="hidden" name="id" value="<?php echo $credit->id; ?>">
						<input type="hidden" name="amount" value="0" id="amount">
						<input type="hidden" name="status" value="0" id="status">
						<fieldset>
							<legend>Payment Form</legend>
							<div class="form-group">  
								<label>Paid</label>
								<input type="text" required="required" name="paid" class="form-control" readonly="readonly" value="<?php echo $paid; ?>">
							</div>
							<div class="form-group">  
								<label>Balance</label>
								<input type="text" required="required" name="balance" id="balance" class="form-control" readonly="readonly" value="<?php echo $grand_total - $paid; ?>">
							</div>
							<div class="form-group">  
								<label>Payment Date</label>
								<input type="text" required="required" name="date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd">
							</div>

							<div class="form-group">  
								<label>Enter Payment</label>
								<input type="number" required="required" name="payment" id="payment" class="form-control">
							</div>

							<div class="form-group">  
								<label>Change</label>
								<input type="number" readonly="readonly" required="required" name="change" id="change" class="form-control">
							</div>

							<div class="form-group">
								<label>Payment Note</label>
								<textarea name="note" rows="3" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<input type="submit" name="" value="Save" class="btn btn-primary">
								<button type="reset" class="btn btn-info">Reset</button>
							</div>
						</fieldset>
					</div>
				<?php echo form_close(); ?>
			</div>
			<!-- /.row (nested) --> 
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  

<script type="text/javascript">
	
	$(document).ready(function() {
 
		var balance = '<?= $grand_total - $paid ?>';

		$("#payment").keyup(function(e) {

			var amount = parseFloat($(this).val()) || 0;

			if (amount >= balance) {
				$("#change").val( amount - balance );
				$("#amount").val( balance )
				$("#status").val(1);

			} else {
				$("#amount").val(0);
				$("#change").val(0);
				$("#status").val(0);
			}
		});
	});
</script>
