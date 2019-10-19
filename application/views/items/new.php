<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Items</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-md-12">
		<?php 
		echo $this->session->flashdata('errorMessage');
		echo $this->session->flashdata('successMessage');

		?>
	</div>
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Register Item
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open_multipart('items/insert', array('data-parsley-validate' => 'true', 'id' => 'item-form', 'method' => 'POST')) ?>
					<form method="POST" action="<?php echo base_url('items/insert') ?>" data-parsley-validate id="item-form">
						<div class="col-lg-6 col-md-offset-2 ">
							<div class="form-group">
								<label>Barcode:</label>
								<input type="text" placeholder="Item Barcode" required="required" class="form-control" name="barcode" value="">
							</div>
							<div class="form-group"> 
								<label>Item Name:</label>					 
								<input required="required" type="text" placeholder="Item Name" name="name" class="form-control">
								
							</div>
							<div class="form-group"> 
								<label>Category:</label> 
								<select name="category" class="form-control" required="required">
									<option value="">Select Category</option>
									<?php foreach ($category as $cat): ?>
										<option value="<?php echo $cat->id ?>"> <?php echo ucwords($cat->name) ?> </option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">  
								<label>Capital/Unit:</label>
								<input type="text" required="required" placeholder="Capital Per Unit" name="capital" class="form-control" max="500000" id="capital">
							</div>
							<div class="form-group">  
								<label>Retail Price:</label>
								<input type="text" required="required" placeholder="Price" name="price" class="form-control" data-parsley-gte-message="Retail Price Must be greather or equal to capital" max="500000" id="selling-price" data-parsley-gte="#capital">
							</div>  
							<div class="form-group">  
								<label>Supplier:</label>
								<select name="supplier" class="form-control" required="required"> 
									<option value="">Select Supplier</option>
									<?php foreach ($suppliers as $supplier): ?>
										<option value="<?php echo $supplier->id ?>">
											<?php echo ucwords($supplier->name) ?>
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
								<textarea rows="5" maxlength="150" placeholder="Description" class="form-control" name="description" required="required"></textarea>
							</div>
							<div class="form-group"> 
								<button class="btn btn-primary">Register Item</button>
								<button class="btn btn-info" type="reset">Clear</button>
							</div>
							
						</div> 
						<div class="col-lg-4">
							<div class="form-group">
								<div class="productImage" id="imagePreview">
									
								</div>
								<label>Product Image
									<input type="file" name="productImage" id="productImage" class="form-control">
								</label>
							</div>
							<fieldset class="ingredients-add" style="display: none;">
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
							<div class="form-group" id="ingredients-tbl-wrapper" style="display: none;">
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
												<input type='hidden' name='inventory-id[]' value="<?php echo $row->id; ?>"> 
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
				console.log(suggestion)
				$("#inventory-id").val(suggestion.data);
				$("#unit").val(suggestion.unit);
			}
		});
	})
</script>