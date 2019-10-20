<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Product: <?php echo $item->name; ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Edit Product Form
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open_multipart('items/update', array('method' => 'post', 'id' => 'item-form')) ?>

					<div class="col-lg-6 col-md-offset-2">
						<div class="form-group"> 
							<label>Barcode:</label>
							<input type="text"  value="<?php echo $item->barcode; ?>" name="barcode" class="form-control" required="required"> 
						</div>
						<div class="form-group"> 
							<label>Item Name:</label>
							<input type="text" value="<?php echo $item->name; ?>" name="name" class="form-control" required="required">
							<input type="hidden" name="id" value="<?php echo $item->id ?>">
						</div>
						<?php if ($item->inventory == "individual"): ?>
						<div class="form-group"> 
							<label>Stocks:</label>
							<input type="text" value="<?php echo $stocks->quantity; ?>" name="stocks" class="form-control" required="required">
							<input type="hidden" name="id" value="<?php echo $item->id ?>">
						</div>
						<?php endif; ?>
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
							<label>Capital/Unit:</label>
							<input value="<?php echo $price->getCapital($item->id); ?>" max="500000" type="text" name="capital" class="form-control" required="required" id="capital">
						</div> 
						<div class="form-group"> 
							<label>Price:</label>
							<input value="<?php echo $price->getPrice($item->id); ?>" max="500000" type="text" name="price" class="form-control" required="required" id="selling-price" data-parsley-gte="#capital">
						</div>  
						<div class="form-group">
							<label>Supplier:</label>
							<select name="supplier" class="form-control">
								<?php foreach ($suppliers as $supplier): ?>
									<option value="<?php echo $supplier->id; ?>" <?php echo $item->id == $supplier->id ? 'Selected' : '' ?>>
										<?php echo $supplier->name ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>  
						<div class="form-group"> 
							<label>Inventory Type</label>
							<select class="form-control" name="inventory" id="inventory-type">
								<option value="individual" <?php echo $item->inventory == "individual" ? "selected" : ""; ?>>Individual</option>
								<option value="assembled" <?php echo $item->inventory == "assembled" ? "selected" : ""; ?>>Assembled Food</option>
							</select>
						</div> 
						<div class="form-group"> 
							<label>Description:</label>
							<textarea required="required" rows="5" class="form-control" name="description"><?php echo $item->description ?></textarea>
						</div>
						<div class="form-group"> 
							<button class="btn btn-primary">Update</button>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<div class="productImage" id="imagePreview">
								<?php if ($item->image && file_exists('./uploads/' . $item->image)): ?>
									<img style="width: inherit;height: inherit;border:solid 1px #ddd;object-fit: cover;" src="<?php echo base_url('uploads/' . $item->image) ?>">
								<?php endif; ?>
							</div>
							<br/>
							<label>Change Image
								<input type="file" name="productImage" id="productImage" class="form-control">
							</label>
						</div>
						<fieldset class="ingredients-add" <?php echo $item->inventory == "individual" ? "style='display:none'" : ""; ?>>
							<legend>Add Ingredient</legend>
							<div class="form-group">
								<input type="hidden" id="inventory-id" name="inventory-id" >
								<input type="hidden" id="unit" name="">
								<div class="form-group">
									<label>Ingredient</label>
									<input type="text" id="ingredient-name" placeholder="Type ingredient name.." class="form-control ingredients" name="">
								</div>
							</div>
							<div class="form-group">
								<div class="form-group">
									<label>Qty Cost</label>
									<input type="number" class="form-control" name="" id="ingredient-cost">
								</div>
							</div>
							<div class="form-group">
								<div class="form-group"> 
									<buttontype="button" id="add-ingredient" class="btn btn-default"><i class="fa fa-plus"></i> Add</button>
								</div>
							</div> 
						</fieldset>
						<div class="form-group" <?php echo $item->inventory == "individual" ? "style='display:none'" : ""; ?> id="ingredients-tbl-wrapper">
							<h4>Ingredients</h4>
							<table class="table table-bordered" id="ingredients-tbl">
								
								<thead>
									<tr>
										<td>Name</td>
										<td>Unit</td>
										<td>Cost</td>
										<td></td>
									</tr>
								</thead>
								<tbody> 
									<?php foreach ($production as $row): ?>
										<tr>
											<input type='hidden' name='inventory-id[]' value="<?php echo $row->inventory_id; ?>"> 
											<input type='hidden' name='inventory-name[]' value="<?php echo $row->name; ?>"> 
											<input type='hidden' name='inventory-cost[]' value="<?php echo $row->cost; ?>"> 
											<input type='hidden' name='inventory-unit[]' value="<?php echo $row->unit; ?>"> 
											<td><?php echo $row->name; ?></td>
											<td><?php echo $row->unit; ?></td>
											<td><?php echo $row->cost; ?></td>
											<td><i class="fa fa-trash remove-row"></i></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div> 
					</div>
					<?php echo form_close(); ?>
					
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

<script src="<?php echo base_url('assets/js/jquery-autocomplete.js') ?>"></script>

<script>
	
	$(document).ready(function() {
		var ingredients = <?php echo json_encode($ingredients); ?>;

		$(".ingredients").autocomplete({
			lookup: ingredients,
			onSelect: function(suggestion) { 
				$("#inventory-id").val(suggestion.data);
				$("#unit").val(suggestion.unit);
			}
		});
	})
</script>