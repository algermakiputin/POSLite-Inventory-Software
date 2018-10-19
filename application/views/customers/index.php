<div class="col-sm-10" id="main">
	<div class="table-wrapper">
		<h1 class="page-title">Customers</h1>
		<button class="btn btn-default" data-toggle="modal" data-target="#myModal">Add Customer</button>
		<hr>
		<table class="table table-striped table-bordered table-hover table-responsive">
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Gender</th> 
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>Zip Code</th>
				<th>Mobile Number</th>
				<th>Action</th>
			</tr>


			<tr>
				<td>T Doe</td>
				<td>johndoe@gmail.com</td>
				<td>Male</td>
				<td>Manila Philippines</td>
				<td>Manila</td>
				<td>Rizal</td>
				<td>8000</td>
				<td>8700</td>
				<td>
					<button class="btn btn-primary btn-sm">Edit</button>
					<button class="btn btn-info btn-sm ">Update</button>
					<button class="btn btn-danger btn-sm">Delete</button>
				</td>
			</tr>

			<tr>
				<td>John Doe</td>
				<td>johndoe@gmail.com</td>
				<td>Male</td>
				<td>Manila Philippines</td>
				<td>Manila</td>
				<td>Rizal</td>
				<td>8000</td>
				<td>8700</td>
				<td>
					<button class="btn btn-primary btn-sm">Edit</button>
					<button class="btn btn-info btn-sm ">Update</button>
					<button class="btn btn-danger btn-sm">Delete</button>
				</td>
			</tr>

			<tr>
				<td>F Doe</td>
				<td>johndoe@gmail.com</td>
				<td>Male</td>
				<td>Manila Philippines</td>
				<td>Manila</td>
				<td>Rizal</td>
				<td>8000</td>
				<td>8700</td>
				<td>
					<button class="btn btn-primary btn-sm">Edit</button>
					<button class="btn btn-info btn-sm ">Update</button>
					<button class="btn btn-danger btn-sm">Delete</button>
				</td>
			</tr>
		</table>
	</div>

</div>
<div class="clearfix"></div>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">New Supplier</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<input type="text" class="form-control" name="name" placeholder="Name">
					</div>
					<div class="form-group">
						<input type="email" class="form-control" name="email" placeholder="Email">
					</div>
					<div class="form-group">
						<label>Gender</label>
						<div class="radio">
							<label><input type="radio" name="optradio" checked>Male</label>
						</div>
						<div class="radio">
							<label><input type="radio" name="optradio">Female</label>
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
						<input type="text" class="form-control" name="mobile" placeholder="Mobile Number">
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