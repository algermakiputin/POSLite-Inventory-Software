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
				Manage Users
			</div>
			<div class="panel-body">
				<div class="row">
					 <div class="col-md-12">
					        <?php 
					        echo $this->session->flashdata('errorMessage');
					        echo $this->session->flashdata('successMessage'); 
					        ?>
					    </div>
					</div>
					<div class="col-lg-4"> 
						<?php echo form_open('UsersController/register_account'); ?> 
						<fieldset style="padding-top:10px" <?php echo SITE_LIVE ? 'disabled' : '' ?>>
							<div class="form-group">
								<label for='Username'>Full Name</label>
								<input required="required" type="text" name="full_name" class="form-control">
							</div>
							<div class="form-group">
								<label for='Username'>Username</label>
								<input required="required" type="text" name="Username" class="form-control">
							</div>
							<div class="form-group">
								<label for='Password'>Password</label>
								<input required="required" type="password" name="Password" class="form-control">
							</div>
							<div class="form-group">
								<label for='repeat_password'>Repeat Password</label>
								<input required="required" type="password" name="repeat_password" class="form-control">
							</div>
							<div class="form-group">
								<label for='account_type'>Account Type</label>
								<select required="required" name="account_type" class="form-control">
									<option value="">Select Account Type</option>
									<option>Admin</option>
									<option>Receiver</option> 
									<option>Cashier</option> 
								</select>
							</div>
							<div class="form-group">
								<input type="submit" name="submit_account" class="btn btn-success" value="Register">
								<button class="btn btn-info" type="reset">Reset</button>
							</div>
						</fieldset>
						<?php echo form_close(); ?>
					</div>
					<div class="col-lg-8"> 
						<table class="table table-striped table-hover table-bordered" id="users_table">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Username</th>
									<th>Account Type</th>
									<th>Date/Time Created</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$count = 1; 
								?>
								<?php foreach($accountsList as $account) :?>
									<tr>
										<?php
										$id = $account->id;
										?>
										<td><?php echo $id; ?></td>
										<td><?php echo $account->name; ?></td>
										<td><?php echo $account->username ?></td>
										<td><?php echo $account->account_type ?></td>
										<td><?php echo $account->date_created ?></td>
										<td>
											<div class="dropdown">
												<a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
												<ul class="dropdown-menu">
													<?php if ($this->session->userdata('account_type') == "Admin"): ?>
														<li>
															<a href="<?php echo base_url("user/edit/$id") ?>">
																<i class="fa fa-edit"></i> Edit
															</a>
														</li>
													<?php endif; ?>
													<li>
														<a href="<?php echo base_url("UsersController/delete/$id"); ?>" class="delete-data" <?php echo SITE_LIVE ? 'disabled onclick="return false;"' : '' ?>><i class="fa fa-trash"></i> Delete</a></td>
													</li>
													 
												</ul>
											</div>
											
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>
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



