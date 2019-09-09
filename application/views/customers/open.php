<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Customer Membership</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Open Customer Membership
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6 col-md-offset-3">
						<?php if ($this->session->flashdata('success')): ?>
							<div class="alert alert-success">
								<p><?php echo $this->session->flashdata('success') ?></p>
							</div>
						<?php endif; ?> 
						<?php echo form_open("customers/open-membership") ?>
							<div class="form-group">
								<label>Customer ID</label>
								<input type="text"  name="customer_id" readonly="readonly"  value="<?php echo $customer->id ?>" class="form-control" required="required">
							</div>
							<div class="form-group">
								<label>Customer Name</label>
								<input type="text"  name="customer_name" readonly="readonly" value="<?php echo $customer->name ?>" class="form-control" required="required">
							</div>
							<div class="form-group">
								<label>Date Open</label>
								<input type="date"  name="date_open" class="form-control" required="required">
							</div>
 
							<div class="form-group">
								<input type="submit" name="" value="Open Membership" class="btn btn-primary" required="required">					 
							</div>
		 
						<?php echo form_close(); ?>
					</div>
					<!-- /.col-lg-6 (nested) -->
					
					<!-- /.col-lg-6 (nested) -->
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  


 