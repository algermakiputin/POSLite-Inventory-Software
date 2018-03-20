<div class="col-sm-10" id="main" style="padding-top: 20px;">
<div class="col-sm-4">
<?php echo $this->session->flashdata('errorMessage');?>
<?php echo $this->session->flashdata('successMessage');?>
<?php echo form_open('accounts_con/register_account'); ?>
<?php echo form_fieldset('<h1 class="text-danger">Register Account</h1>'); ?>
<div class="form-group">
	<label for='Username'>Username</label>
	<input type="text" name="Username" class="form-control">
</div>
<div class="form-group">
	<label for='Password'>Password</label>
	<input type="password" name="Password" class="form-control">
</div>
<div class="form-group">
	<label for='repeat_password'>Repeat Password</label>
	<input type="password" name="repeat_password" class="form-control">
</div>
<div class="form-group">
	<label for='account_type'>Account Type</label>
	<select name="account_type" class="form-control">
		<option>Admin</option>
		<option>Cashier</option>
		<option>Clerk</option>
	</select>
</div>
<div class="form-group">
	<input type="submit" name="submit_account" class="btn btn-success" value="Register">
</div>
<?php echo form_close(); ?>
</div>
<div class="col-sm-8">

	<?php echo form_fieldset('<h1 class="text-danger">Registed Accounts</h1>'); ?>
	<table class="table table-striped table-hover table-responsive">
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>Account Type</th>
			<th>Date/Time Created</th>
			<th>Action</th>
		</tr>
		<?php
		$count = 1; 
		?>
		<?php foreach($accountsList as $account) :?>
		<tr>
			<?php
			$id = $account->id;
			?>
			<td><?php echo $count++; ?></td>
			<td><?php echo $account->username ?></td>
			<td><?php echo $account->account_type ?></td>
			<td><?php echo $account->date_created ?></td>
			<td><a href="<?php echo base_url("accounts_con/delete/$id"); ?>" class="btn btn-danger">Delete</a></td>
		</tr>
	<?php endforeach;?>
	</table>
</div>
</div>

