<div class="col-sm-10" id="main">
	<div class="table-wrapper">
		<h1 class="page-title">Suppliers</h1>
		<button class="btn btn-default" data-toggle="modal" data-target="#myModal">Add Supplier</button>
		<hr>
		<table class="table table-striped table-bordered table-hover table-responsive">
			<tr>
				<th width="25%">Name</th>
				<th width="30%">Address</th>
				<th width="25%">Contact</th> 
				<th width="20%">Actions</th>
			</tr>
			<tr>
				<td>John Doe</td>
				<td>Manila Philippines</td>
				<td>8700</td>
				<td>
					<button class="btn btn-primary btn-sm">Edit</button>
					<button class="btn btn-info btn-sm ">Update</button>
					<button class="btn btn-danger btn-sm">Delete</button>
				</td>
			</tr>
			<tr>
				<td>M Doe</td>
				<td>Manila Philippines</td>
				<td>8700</td>
				<td>
					<button class="btn btn-primary btn-sm">Edit</button>
					<button class="btn btn-info btn-sm ">Update</button>
					<button class="btn btn-danger btn-sm">Delete</button>
				</td>
			</tr>
			<tr>
				<td>D Doe</td>
				<td>Manila Philippines</td>
				<td>8700</td>
				<td>
					<button class="btn btn-primary btn-sm">Edit</button>
					<button class="btn btn-info btn-sm ">Update</button>
					<button class="btn btn-danger btn-sm">Delete</button>
				</td>
			</tr>
			<tr>
				<td>E Doe</td>
				<td>Manila Philippines</td>
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
        		<input type="text" class="form-control" name="address" placeholder="Address">
        	</div>
        	<div class="form-group">
        		<input type="text" class="form-control" name="contact" placeholder="Contact">
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