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
				Edit Product
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open_multipart('items/update', array('method' => 'post', 'id' => 'item-form')) ?>
						<div class="col-lg-6 col-md-offset-2">
							<div class="form-group"> 
								<label>Barcode: <i title="You can use barcode scanner to automatically insert the barcode number below" class="fa fa-info-circle"></i></label>
								<input type="text"  value="<?php echo $item->barcode; ?>" id="barcode" name="barcode" class="form-control" required="required"> 
							</div>
							<div class="form-group"> 
								<label>Item Name:</label>
								<input type="text" value="<?php echo $item->name; ?>" name="name" class="form-control" required="required">
								<input type="hidden" name="id" value="<?php echo $item->id ?>">
							</div>
							<div class="form-group"> 
								<label>Stocks:</label>
								<input type="text" value="<?php echo $stocks->quantity; ?>" name="stocks" class="form-control" required="required">
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
								<label>Capital Price:</label>
								<input value="<?php echo $item->capital ?>" type="text" name="capital" class="form-control" required="required" id="capital-price">
							</div> 
							<div class="form-group"> 
								<label>Retail Price:</label>
								<input value="<?php echo $item->price ?>" type="text" name="price" class="form-control" required="required" id="selling-price">
							</div>  

						 	<?php if (!$advance_pricing): ?>
							<div class="form-group" style="padding: 10px;border:solid 1px #ddd;background-color: #f4f4f5">
								<button class="form-control btn btn-default" type="button" data-toggle="collapse" data-target="#advance-pricing-field">Enable Advance Pricing</button>
							</div>
						 	<?php endif; ?>

							
							<fieldset style="background-color: #f4f4f5;" id="advance-pricing-field" class="<?php echo $class ?>">
								<legend>Advance Pricing</legend>
								<table class="table table-bordered table-striped" id="advance-pricing-tbl">
									<thead>
										<tr>
											<th>Label</th>
											<th>Price</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!$advance_pricing): ?>
											<tr>
												<td><input type="text" value="<?php echo $price->label ?>" placeholder="Price Label" class="form-control" name="price_label[]"></td>
												<td><input type="text" value="<?php echo $price->price ?>" placeholder="Price" class="form-control" name="advance_price[]"></td>
												<td width="30px"><i class="fa fa-trash remove-row"></i></td>
											</tr>
										<?php endif; ?>
										<?php foreach ($advance_pricing as $price): ?>
											<tr>
												<td><input type="text" value="<?php echo $price->label ?>" placeholder="Price Label" class="form-control" name="price_label[]"></td>
												<td><input type="text" value="<?php echo $price->price ?>" placeholder="Price" class="form-control" name="advance_price[]"></td>
												<td width="30px"><i class="fa fa-trash remove-row"></i></td>
											</tr>
										<?php endforeach; ?>
										
									</tbody>
								</table>
								<div class="text-right">
									<button class="btn btn-default btn-sm" type="button" id="add-price">ADD PRICE</button>
								</div>
							</fieldset> 
							<div class="form-group">
								<label>Supplier:</label>
								<select name="supplier" class="form-control">
									<?php foreach ($suppliers as $supplier): ?>
										<option value="<?php echo $supplier->id; ?>" <?php echo $item->supplier_id == $supplier->id ? 'Selected' : '' ?>>
											<?php echo $supplier->name ?>
										</option>
									<?php endforeach; ?>
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
										<img style="width: inherit;height: inherit;" src="<?php echo base_url('uploads/' . $item->image) ?>">
									<?php endif; ?>
								</div>
								<br/>
								<label>Change Image
									<input type="file" name="productImage" id="productImage" class="form-control">
								</label>
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

<script src="<?php echo base_url('assets/js/jquery-pos.js') ?>"></script>
<script type="text/javascript">
	
	$(document).ready(function(e) {

		$(document).pos();

		$(document).on('scan.pos.barcode', function(event){
		  
				if (event.code.length > 6) { 
					 
					 $("#barcode").val(event.code);
				}
		}); 


		$("#add-price").click(function(e) {

			$("#advance-pricing-tbl tbody").append("<tr>" + 
					'<td><input type="text" placeholder="Price Label" class="form-control" name="price_label[]"></td>' +
					'<td><input type="number" placeholder="Price" class="form-control" name="advance_price[]"></td>' + 
					'<td width="30px"><i class="fa fa-trash remove-row"></i></td>' +
				"</tr>");
		});

		$("body").on('click','.remove-row', function(e) {

			var row_count = $("#advance-pricing-tbl tbody tr").length;
 
			$(this).parents('tr').remove();
			 
			
		});
			
	})


</script>
 