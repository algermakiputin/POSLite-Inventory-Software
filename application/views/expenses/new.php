<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Expenses</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				New Expenses
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open('expenses/insert', ['method' => 'POST', 'autocomplete' => 'off']) ?> 
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
						 		<label>Date</label>
								<input type="text" required="required" placeholder="Date" name="date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd">
							</div>
						 	<div class="form-group">  
						 		<label>Type</label>
								<select name="type" class="form-control">
									<option value="">Select Type</option>
									<option value="Operating">Operating</option>
									<option value="Non-operating">Non-operating</option>
									<option value="Fixed">Fixed</option>
									<option value="Variable">Variable</option>
								</select>
							</div>
							<div class="form-group">  
								<label>Expenses Name</label>
								<input type="text" required="required" placeholder="Expense Name" name="name" class="form-control">
							</div>
						 
							<div class="form-group">
								<label>Cost</label>  
								<input type="number" required="required" placeholder="Cost" name="cost" class="form-control">
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
