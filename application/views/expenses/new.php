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
					<form method="POST" action="<?php echo base_url('expenses/insert') ?>" data-parsley-validate>
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
								<input type="text" required="required" placeholder="Expense Name" name="type" class="form-control">
							</div>
						 
							<div class="form-group">  
								<input type="number" required="required" placeholder="Cost" name="cost" class="form-control">
							</div>

							<div class="form-group">  
								<input type="date" required="required" placeholder="Date" name="date" class="form-control">
							</div>
							<div class="form-group">
								<input type="submit" name="" value="Save" class="btn btn-primary">
							</div>
						</div>
						 
					</form>
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  
