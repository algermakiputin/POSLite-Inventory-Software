<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">PREFERENCE</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Preference Settings
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open('SettingsController/update_preference', ['method' => 'POST', 'autocomplete' => 'off']) ?> 
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
						 	<fieldset>
						 		<legend>Company Details</legend>
						 		<div class="form-group"> 
						 			<label>Company Name:</label> 
									<input type="text" required="required"  name="name" class="form-control" value="<?php echo $preference['name']; ?>">
								</div>

								<div class="form-group">
									<label>Region</label>  
									<input type="text" required="required" name="region" class="form-control" value="<?php echo $preference['region']; ?>">
								</div>

								<div class="form-group">
									<label>City</label>  
									<input type="text" required="required" name="city" class="form-control" value="<?php echo $preference['city']; ?>">
								</div>


								<div class="form-group">
									<label>State</label>  
									<input type="text" required="required" name="state" class="form-control" value="<?php echo $preference['state']; ?>">
								</div>

								<div class="form-group">
									<label>Country</label>  
									<input type="text" required="required" name="country" class="form-control" value="<?php echo $preference['country']; ?>">
								</div>

								<div class="form-group">
									<label>Zip</label>  
									<input type="text" required="required" value="<?php echo $preference['zip']; ?>" name="zip" class="form-control">
								</div>

								<div class="form-group">
									<label>Phone</label>  
									<input type="text" value="<?php echo $preference['phone']; ?>" required="required" name="phone" class="form-control">
								</div> 
							 
								<div class="form-group">
									<label>Address</label>  
									<textarea class="form-control" name="address" rows="4"><?php echo $preference['address']; ?></textarea>
								</div>
 
						 	</fieldset>
							
							<div class="form-group">
								<input type="submit" name="" value="Save / Update" class="btn btn-primary">
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
