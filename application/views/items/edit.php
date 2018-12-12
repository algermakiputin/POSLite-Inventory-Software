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
				Edit Item
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6 col-md-offset-3">
						<form method="POST" action="<?php echo base_url('items/update') ?>" id="item-form">
							<div class="form-group"> 
								<label>Item Name:</label>
								<input type="text" value="<?php echo $item->name; ?>" name="name" class="form-control" required="required">
								<input type="hidden" name="id" value="<?php echo $item->id ?>">
							</div>
							<div class="form-group"> 
								<label>Category:</label>
								<select name="category" class="form-control" required="required">
									<option value="">Select Category</option>
									<?php foreach ($categories as $cat): ?>
										<option value="<?php echo $cat->id ?>" <?php echo $cat->id == $item->category_id ? "selected" : '' ?>> 
											<?php echo ucwords($cat->name) ?> 
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group"> 
								<label>Price:</label>
								<input value="<?php echo $price->getPrice($item->id); ?>" type="text" name="price" class="form-control" required="required">
							</div>
							<div class="form-group"> 
								<label>Retail Price:</label>
								<input value="<?php echo $item->retail_price; ?>" type="text" name="retail_price" class="form-control" required="required">
							</div>

							<div class="form-group"> 
								<label>Description:</label>
								<textarea required="required" rows="5" class="form-control" name="description"><?php echo $item->description ?></textarea>
							</div>
							<div class="form-group"> 
								<button class="btn btn-primary">Update</button>
							</div>
						</form>
					</div>
					<!-- /.col-lg-6 (nested) -->
					
					<!-- /.col-lg-6 (nested) -->
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  
 