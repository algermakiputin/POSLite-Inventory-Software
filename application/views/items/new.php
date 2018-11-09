<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Items</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Register Item
			</div>
			<div class="panel-body">
				<div class="row">
					<form method="POST" action="<?php echo base_url('items/insert') ?>">
						<div class="col-lg-8">
							<div class="form-group"> 					 
								<input type="text" placeholder="Item Name" name="name" class="form-control">
								<input type="hidden" name="barcode" value="<?php echo $barcode ?>">
							</div>
							<div class="form-group">  
								<select name="category" class="form-control">
									<option value="">Select Category</option>
									<?php foreach ($category as $cat): ?>
										<option value="<?php echo $cat->id ?>"> <?php echo $cat->name ?> </option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">  
								<input type="text" placeholder="Price" name="price" class="form-control">
							</div>
							<div class="form-group">  
								<select name="supplier" class="form-control">
									<option value="">Select Supplier</option>
									<?php foreach ($suppliers as $supplier): ?>
										<option value="<?php echo $supplier->id ?>">
											<?php echo $supplier->name ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">  
								<textarea rows="5" placeholder="Description" class="form-control" name="description"></textarea>
							</div>
							<div class="form-group"> 
								<button class="btn btn-primary">Register Item</button>
							</div>
							
						</div>
						<div class="col-md-4">
							<div class="form-group ">
								<label>Bar Code</label>
								<div>
									<?php 
									echo $code;
									?>
								</div>

							</div>
							<div class="form-group">
								<button class="btn btn-default">Print</button>
								<button class="btn btn-default">PNG</button>
							</div>
						</div>
					</form>
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  
