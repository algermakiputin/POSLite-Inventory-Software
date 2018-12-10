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
             Customers List
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
					<th width="15%">Name</th>
					<th>Email</th>
					<th>Gender</th> 
					<th>Address</th>
					<th>City</th>
					<th>State</th> 
					<th>Mobile</th>
					<th width="10%">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($customers as $customer): ?>
					<tr>
						<td><?php echo $customer->name ?></td>
						<td><?php echo $customer->email ?></td>
						<td><?php echo $customer->gender ?></td>
						<td><?php echo $customer->address ?></td>
						<td><?php echo $customer->city ?></td>
						<td><?php echo $customer->state ?></td> 
						<td><?php echo $customer->mobileNumber ?></td>
						<td> 
							<button class="fa fa-edit btn-primary btn edit btn-sm" data-toggle="modal" data-target="#customer-edit" data-id="<?php echo $customer->id ?>"></button>
							<a class="btn btn-danger fa fa-trash btn-sm" href="<?php echo base_url('customers/delete/' . $customer->id) ?>"></a>
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
			<div class="modal-body">
				<form action="<?php echo base_url('customers/insert') ?>" method="POST">
					<div class="form-group">
						<input required="required" type="text" class="form-control" name="name" placeholder="Name">
					</div>
					<div class="form-group">
						<input type="email" required="required" class="form-control" name="email" placeholder="Email">
					</div>
					<div class="form-group">
						<label>Gender</label>
						<div class="radio">
							<label><input type="radio" name="gender" checked value="male">Male</label>
						</div>
						<div class="radio">
							<label><input type="radio" name="gender" value="female">Female</label>
						</div>
					</div>

					<div class="form-group">
						<input type="text" required="required" class="form-control" name="address" placeholder="Address">
					</div>
					<div class="form-group">
						<input type="text" required="required" class="form-control" name="city" placeholder="City">
					</div>
					<div class="form-group">
						<input type="text" required="required" class="form-control" name="state" placeholder="State">
					</div>
					<div class="form-group">
						<input type="text" required="required" class="form-control" name="zipcode" placeholder="Zip Code">
					</div>
					<div class="form-group">
						<input type="text" required="required" class="form-control" name="mobileNumber" placeholder="Mobile Number">
					</div>
					<div class="form-group">
						<button class="btn btn-success">Save</button>
					</div>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<div id="customer-edit" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">New Customer</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('customers/update') ?>" method="POST">
					<input type="hidden" name="customer_id" id="customer_id">
					<div class="form-group">
						<input type="text" class="form-control" name="name" placeholder="Name">
					</div>
					<div class="form-group">
						<input type="email" class="form-control" name="email" placeholder="Email">
					</div>
					<div class="form-group">
						<label>Gender</label>
						<div class="radio">
							<label><input type="radio" name="gender" checked value="male">Male</label>
						</div>
						<div class="radio">
							<label><input type="radio" name="gender" value="female">Female</label>
						</div>
					</div>

					<div class="form-group">
						<input type="text" class="form-control" name="address" placeholder="Address">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="city" placeholder="City">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="state" placeholder="State">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="zipcode" placeholder="Zip Code">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="mobileNumber" placeholder="Mobile Number">
					</div>
					<div class="form-group">
						<button class="btn btn-success">Save</button>
					</div>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>