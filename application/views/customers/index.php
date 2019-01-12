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
					<th width="10%">Name</th>
					<th width="10%">Gender</th>
					<th width="10%">Home Address</th> 
					<th width="10%">Outlet Location</th>
					<th width="10%">Outlet Address</th>
					<th width="10%">Date Open</th> 
					<th width="10%"> Expiration</th>
					<th width="10%">Membership</th>
					<th width="10%">Contact Number</th>
					<th width="10%">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($customers as $customer): ?>
					<?php 
						$renewable = false;
						$membership = "Not Open";

						if ($customer->membership) {

							$membership = "<span class='text-success'>Active</span>";
							if ( Carbon\Carbon::now()->gte(Carbon\Carbon::parse($controller->getExpiration($customer->id) )) ) {
								$membership = "<span class='text-danger'>Expired</span>";
								$renewable = true;
							}
							else if (Carbon\Carbon::parse($controller->getExpiration($customer->id))->gt(Carbon\Carbon::now()) && Carbon\Carbon::parse($controller->getExpiration($customer->id))->lt(Carbon\Carbon::now()->addDays(30)) ) {
								$membership = "<span class='text-warning'>Needs Renewal</span>";
								$renewable = true;
						 
							}  
							
						}
							

					?>
					<tr>

						<td><?php echo $customer->name ?></td>
						<td><?php echo $customer->gender ?></td>
						<td><?php echo $customer->home_address ?></td>
						<td><?php echo $customer->outlet_location ?></td>
						<td><?php echo $customer->outlet_address ?></td>
						<td><?php echo $customer->membership == 0 ? '--' : $controller->getDateOpen($customer->id) ?></td> 
						<td><?php echo $customer->membership == 0 ? '--' : Carbon\Carbon::parse($controller->getExpiration($customer->id))->format('Y-m-d'); ?></td>
						<td><?php echo $membership; ?></td>
						<td><?php echo $customer->contact_number ?></td>
						<td> 
							<div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                   <?php if ($renewable): ?>
										<li>
											<a title="Renew Membership" class="renew"  href="#" data-id="<?php echo $customer->id ?>"><i class="fa fa-user "></i> Renew</a>
										</li>
									<?php endif; ?>
									<?php if ($customer->membership == 0): ?>
										<li>
											<a title="Open Membership" href="<?php echo base_url('customers/open/' . $customer->id) ?>">
												<i class="fa fa-user">Open</i>

											</a>
										</li>
									<?php endif; ?>
										<li>
											<a title="Edit Info" class="pointer edit" data-toggle="modal" data-target="#customer-edit" data-id="<?php echo $customer->id ?>"> 
												<i class="fa fa-edit"> Edit</i>
											</a>
										</li>
										<li>
											<a title="Delete Customer"  href="<?php echo base_url('customers/delete/' . $customer->id) ?>">
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
			<div class="modal-body">
				<form action="<?php echo base_url('customers/insert') ?>" method="POST">
					<div class="form-group">
						<input required="required" type="text" class="form-control" name="name" placeholder="Name">
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
						<input type="text" required="required" class="form-control" name="home_address" placeholder="Home Address">
					</div>
					<div class="form-group">
						<input type="text" required="required" class="form-control" name="outlet_location" placeholder="Outlet Location">
					</div>
					<div class="form-group">
						<input type="text" required="required" class="form-control" name="outlet_address" placeholder="Outlet Address">
					</div> 
					<div class="form-group">
						<input type="text" required="required" class="form-control" name="mobileNumber" placeholder="Contact Number">
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
						<label>Name</label>
						<input type="text" class="form-control" name="name" placeholder="Name">
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
						<label>Home Address:</label>
						<input type="text" class="form-control" name="home_address" placeholder="Home Address">
					</div>
					<div class="form-group">
						<label>Outlet Location</label>
						<input type="text" class="form-control" name="outlet_location" placeholder="Outlet Location">
					</div>
					<div class="form-group">
						<label>Outlet Address</label>
						<input type="text" class="form-control" name="outlet_address" placeholder="Outlet Address">
					</div>
					 
					<div class="form-group">
						<label>Contact Number</label>
						<input type="text" class="form-control" name="contact_number" placeholder="Contact Number">
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

<div class="modal" tabindex="-1" role="dialog" id="renew-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      	<form method="POST" action="<?php echo base_url('CustomersController/renewMembership') ?>">
      		<div class="modal-header">
	        <h4 class="modal-title">Renew Membership</h4> 
	      </div>
	      <div class="modal-body">
	      	<input type="hidden" name="customer_id" id="customer-id">
	        <p>Date Open: <b><span id="date-open"></span></b></p>
	        <p>Renew Date: <b><span id="renew-date"></span></b></p>
	        <p>New Expiration Date: <b><span id="new-expiration"></span></b></p>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary">Confirm</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
      	</form>
    </div>
  </div>
</div>