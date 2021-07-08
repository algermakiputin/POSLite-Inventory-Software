<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Customers </h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-table fa-fw"></i> Customers List
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<?php if ($this->session->flashdata('success')): ?>
					<div class="alert alert-success">
						<p><?php echo $this->session->flashdata('success') ?></p>
					</div>
				<?php endif; ?> 

				<table class="table table-striped table-bordered table-hover table-responsive" id="customer_table">
					<thead>
						<tr>
							<th width="10%">Name</th>
							<th width="10%">Gender</th>
							<th width="10%">Home Address</th>  
							<th width="10%">Contact Number</th>
							<th width="10%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($customers as $customer): ?>
					  
							<tr>

								<td><?php echo $customer->name ?></td>
								<td><?php echo $customer->gender ?></td>
								<td><?php echo $customer->home_address ?></td> 
								<td><?php echo $customer->contact_number ?></td>
								<td> 
									<div class="dropdown">
										<a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
										<ul class="dropdown-menu">
										 
											<li>
												<a title="Edit Info" class="pointer edit" data-toggle="modal" data-target="#customer-edit" data-id="<?php echo $customer->id ?>"> 
													<i class="fa fa-edit"></i> Edit
												</a>
											</li>
											<li>
												<a title="Delete Customer" class="delete-data"  href="<?php echo base_url('customers/delete/' . $customer->id) ?>">
													<i class="fa fa-trash"></i> Delete
												</a>
											</li>
										</ul>
									</div>

								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>

				</table>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">New Customer</h4>
			</div>
			<?php echo form_open('customers/insert', ['method' => 'POST']) ?> 
			<div class="modal-body">
					<input type="hidden" 
						name="<?php echo $this->security->get_csrf_token_name(); ?>"
						value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="form-group">
						<input required="required" type="text" class="form-control" name="name" placeholder="Name">
					</div> 
					<div class="form-group">
						<label>Gender</label><br/>
						<label class="radio-inline"><input type="radio" checked="checked" value="male" name="gender" checked>Male</label>
						<label class="radio-inline"><input type="radio" value="female" name="gender">Female</label> 
					</div>

					<div class="form-group">
						<input type="text" required="required" class="form-control" name="home_address" placeholder="Home Address">
					</div>
					 
					<div class="form-group">
						<input type="text" required="required" class="form-control" name="mobileNumber" placeholder="Contact Number">
					</div> 
				
			</div>
			<div class="modal-footer">
				<button class="btn btn-success" type="submit">Save</button>
				<button class="btn btn-info" type="reset">Clear</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			<?php echo form_close(); ?>
		</div>

	</div>
</div>

<div id="customer-edit" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Update Customer Information</h4>
			</div>
			<div class="modal-body">
				<?php echo form_open('customers/update', ['method' => 'POST']) ?> 
					<input type="hidden" name="customer_id" id="customer_id">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="name" placeholder="Name">
					</div> 
					<div class="form-group">
						<label>Gender</label><br/>
						<label class="radio-inline"><input type="radio" value="male" name="gender" checked>Male</label>
						<label class="radio-inline"><input type="radio" value="female" name="gender">Female</label> 
					</div>

					<div class="form-group">
						<label>Home Address:</label>
						<input type="text" class="form-control" name="home_address" placeholder="Home Address">
					</div> 

					<div class="form-group">
						<label>Contact Number</label>
						<input type="text" class="form-control" name="contact_number" placeholder="Contact Number">
					</div>
					<div class="form-group">
						<button class="btn btn-primary">Save</button>
					</div>
				<?php echo form_close() ?>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
 