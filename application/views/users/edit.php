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
									<option <?php echo $user->account_type == "Receiver" ? "selected" : '' ?>>Receiver</option>
								</select>
							</div>
							<div class="form-group">
								<label><input type="checkbox" id="change_password_tickbox" class="" name="change_password"> Change Password</label>
							</div>
							<div id="change_password_field" style="display: none;">
								<div class="form-group">
									<label>New Password</label>
									<input type="password" data-parsley-minlength="8" id="new-password" name="new_password" class="form-control">
								</div>
								<div class="form-group">
									<label>Confirm New Password</label>
									<input type="password" data-parsley-minlength="8" id="confirm-password" data-parsley-equalto-message="This value must be the same with your password" name="confirm_new_password" class="form-control">
								</div>
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

<script type="text/javascript">
	
	$(document).ready(function() {
		var new_password_field = $("#new-password");
		var confirm_password_field = $("#confirm-password");
		$("#change_password_tickbox").change(function() {

			if ( $(this).is(":checked") ) {
				
				new_password_field.attr("required",'required');
				confirm_password_field.attr("required", 'required')
											.attr("data-parsley-equalto", "#new-password");

				return $("#change_password_field").show();
			}

			new_password_field.removeAttr("required");
			confirm_password_field.removeAttr("required");
			return $("#change_password_field").hide();
		})
	})
</script>



