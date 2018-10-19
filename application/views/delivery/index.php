<div class="col-sm-10" id="main">
	<div class="table-wrapper">
		<h1 class="page-title">New Delivery</h1>
		<div class="row">
			<div class="col-md-6">
				<legend>Delivery Details</legend> 
				<form>
					<div class="form-group">
						<label>Select Customer</label>
						<select name="customer" class="form-control">
							<option value="">Select Customer</option>
							<option value="1">John Doe</option>
						</select>
					</div>

					<div class="form-group">
						<label>Select Item</label>
						<select name="customer" class="form-control">
							<option value="">Select Item</option>
							<option value="1">Milo</option>
						</select>
					</div>

					<div class="form-group">
						<button class="btn btn-success">Process</button>
						<button class="btn btn-primary">Add Item</button>
					</div>
 
				</form>
			</div>
			<div class="col-md-6">
				<legend>Items</legend>
				<table class="table table-hover table-striped">
					<tr>
						<th>Name</th>
						<th>Price</th>
						<th>Quantity</th>
					</tr>
					<tr>
						<td>Milo</td>
						<td>5</td>
						<td>10</td>
					</tr>
					<tr>
						 <td colspan="2" class="text-right">Total Amount:</td>
						<td>50</td>
					</tr>
				</table>
			</div>
		</div> 
	</div>
	 
</div>
<div class="clearfix"></div>
 