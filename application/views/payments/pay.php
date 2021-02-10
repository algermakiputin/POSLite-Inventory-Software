<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"> Payment</h1>
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
					<?php echo form_open('PaymentsController/insert', ['method' => 'POST', 'autocomplete' => 'off']) ?> 
						<div class="col-lg-6 col-md-offset-3">
					 
						 	<div class="form-group">  
						 		<label>Date</label>
								<input type="text" required="required" value="<?php echo date('Y-m-d') ?>" placeholder="Date" name="date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd">
							</div>
					 		
							<div class="form-group">  
								<label>Customer Name</label>
								<input type="hidden"  name="credit_id" value="<?php echo $credit->id ?>">
								<input type="hidden" name="customer_id" value="<?php echo $credit->customer_id ?>">
								<input type="text" required="required" readonly value="<?php echo $credit->name ?>" name="customer_name" class="form-control">

							</div> 
							<div class="form-group">
								<label>Balance</label>  
								<input type="hidden" name="paid" value="<?php echo $credit->paid ?>">
								<input type="number" readonly required="required" id="total" value="<?php echo $credit->total - $credit->paid ?>"  name="total" class="form-control">
							</div>

							<div class="form-group">
								<label>Payment</label>  
								<input type="number" data-parsley-lte-message="Payment must not be greather than the balance" data-parsley-lte="#total" id="payment" required="required"  name="payment" class="form-control">
							</div>

							<div class="form-group">
								<input type="submit" name="" value="Submit" class="btn btn-primary"> 
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
