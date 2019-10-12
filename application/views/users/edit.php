<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Users</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Edit User: <?php echo $user->username; ?>
			</div>
			<div class="panel-body">
				<div class="row">
					<?php if($this->session->flashdata('errorMessage')): ?>
					<div class="col-lg-12">
						<?php echo $this->session->flashdata('errorMessage');?> 
					</div>
					<?php endif; ?>
					<div class="col-lg-4 mx-auto"> 
						<?php echo form_open('UsersController/update'); ?> 
							<input type="hidden" name="id" value="<?php echo $user->id; ?>"> 
							<div class="form-group">
								<label for='Username'>Full Name</label>
								<input required="required" value="<?php echo $user->name ?>" type="text" name="fullname" class="form-control">
							</div>
							<div class="form-group">
								<label for='Username'>Username</label>
								<input required="required" value="<?php echo $user->username ?>" type="text" name="username" class="form-control">
							</div> 
							<div class="form-group">
								<label for='account_type'>Account Type</label>
								<select required="required" name="account_type" class="form-control">
									<option value="">Select Account Type</option>
									<option <?php echo $user->account_type == "Admin" ? "selected" : '' ?> >Admin</option>
									<option <?php echo $user->account_type == "Cashier" ? "selected" : '' ?>>Cashier</option>
									<option <?php echo $user->account_type == "Clerk" ? "selected" : '' ?>>Clerk</option>
								</select>
							</div>
							<div class="form-group">
								<input type="submit" name="update" class="btn btn-success" value="Update"> 
							</div> 
						<?php echo form_close(); ?>
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



