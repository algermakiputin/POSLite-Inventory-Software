<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Settings</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Business Details
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6 col-md-offset-3">
						<?php if ($this->session->flashdata('success')): ?>
							<div class="alert alert-success">
								<p><?php echo $this->session->flashdata('success') ?></p>
							</div>
						<?php endif; ?> 
						<?php if ($this->session->flashdata('error')): ?>
							<div class="alert alert-danger">
								<p><?php echo $this->session->flashdata('error') ?></p>
							</div>
						<?php endif; ?> 
						<?php echo form_open_multipart("SettingsController/update") ?>
						<div class="form-group">
								<label>Logo (max 400 * 400)</label>
								<input type="file" name="logo">
							</div>
							<div class="form-group">
								<label>Business Name</label>
								<input type="text" value="<?php echo $settings->business_name ?>" autocomplete="off" name="business_name" class="form-control" id="color">
							</div>
							<div class="form-group">
								<label>Business Address</label>
								<input type="text"value="<?php echo $settings->business_address ?>" autocomplete="off" name="business_address" class="form-control">
							</div>
						 	<div class="form-group">
								<label>Contact</label>
								<input type="text"value="<?php echo $settings->contact ?>" autocomplete="off" name="contact" class="form-control">
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email"value="<?php echo $settings->email ?>" autocomplete="off" name="email" class="form-control">
							</div>
		 					<div class="form-group"> 
								<input type="submit" class="btn btn-primary btn-sm" value="Update">
							</div>
						</form>
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


 