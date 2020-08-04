<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Products</h1>
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
				Product Details
			</div>
			<div class="panel-body">

				<div class="row">
					<?php echo form_open_multipart('items/update', array('data-parsley-validate' => 'true', 'id' => 'item-form', 'method' => 'POST')) ?>
				 
						<div class="col-lg-6 col-md-offset-2 ">
							<h3>Product Information</h3>
							<div class="row">
								<div class="col-md-2">
									*Product ID
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<input autocomplete="off" readonly value="<?php echo $item->barcode ?>" type="text" placeholder="Serial" required="required" class="form-control" name="barcode" value="">
									</div>
								</div>
								<input type="hidden" name="id" value="<?php echo $item->id ?>">
								<div class="col-md-2">
									*Product
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<input autocomplete="off" readonly value="<?php echo $item->name ?>" required="required" type="text" placeholder="Product" name="product" class="form-control">
									</div>
								</div>

								<div class="col-md-2">
									*Category
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<select name="category" class="form-control" required="required" readonly>
											<option value="">Select Category</option>
											<?php foreach ($category as $cat): ?>
												<option <?php echo $item->category_id == $cat->id ? "selected" : "" ?> value="<?php echo $cat->id ?>"> <?php echo ucwords($cat->name) ?> </option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>

								<div class="col-md-2">
									*Supplier
								</div>
								<div class="col-md-10">
									<div class="form-group">   
										<select name="supplier" class="form-control" required="required" readonly> 
											<option value="">Select Supplier</option>
											<?php foreach ($suppliers as $supplier): ?>
												<option <?php echo $item->supplier_id == $supplier->id ? "selected" : "" ?> value="<?php echo $supplier->id ?>">
													<?php echo ucwords($supplier->name) ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>

								<div class="col-md-2">
									*Capital Price
								</div>
								<div class="col-md-10">
									<div class="form-group">   
										<input autocomplete="off" readonly="readonly" type="text" required="required" placeholder="Capital Price" name="capital" class="form-control" max="500000" value="<?php echo $item->capital ?>" id="selling-price">
									</div>
								</div>

								<div class="col-md-2">
									*Retail Price
								</div>
								<div class="col-md-10">
									<div class="form-group">   
										<input type="text" autocomplete="off" readonly required="required" placeholder="Retail Price" name="price" class="form-control" max="500000" id="selling-price" value="<?php echo $item->price ?>">
									</div> 
								</div>
								<div class="col-md-2">
									*Condition
								</div>
								<div class="col-md-10">
									<div class="form-group">   
										<select class="form-control" name="condition" readonly>
											<option>Brand New</option>
											<option>Used</option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									*Warranty Information
								</div>
								<div class="col-md-10">
									<div class="form-group" readonly>   
										<select class="form-control" name="warranty" readonly>
											<option>7 Days Warranty</option>
											<option>1 Year Warranty</option>
											<option>No Warranty</option>
										</select>
									</div>
								</div>
							</div>
							<table width="100%">   
							</table>
						 
						</div> 
						<div class="col-lg-4">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group" style="margin-top: 30px;">
										<div class="productImage" id="imagePreview">
											<?php if ($item->image && file_exists('./uploads/' . $item->image)): ?>
												<img style="width: inherit;height: inherit;" src="<?php echo base_url('uploads/' . $item->image) ?>">
											<?php endif; ?>
										</div> 
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-offset-2 ">
							<div class="row">
								<div class="col-md-2">
									Product Variations
								</div>
								<div class="col-md-10">
									<div class="form-group advance-pricing-wrapper">
										<button class="form-control btn btn-default" type="button" data-toggle="collapse" data-target="#advance-pricing-field">
											<?php if ( $variations): ?>
												Variations
											<?php else: ?>
												Enable Product Variation
											<?php endif; ?>
										</button>
									</div>
									
								</div>

								
							</div> 
							
						</div> 
						<div class="col-md-7 col-md-offset-3">
							<fieldset style="background-color: #fafafa;" id="advance-pricing-field" class="<?php if ( !$variations) echo "collapse" ?>">
								<legend>Variation List</legend>
								<p>Enables you to set different prices for a product. Ex wholeslage price or different prices for every group of customers</p>
								<table class="table table-bordered table-striped" id="advance-pricing-tbl">
									<thead>
										<tr>
											<th width="35%">Serial</th> 
											<th width="35%">Name</th>
											<th width="15%">Price</th>
											<th width="15%">Stocks</th> 
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php if ( !$variations ): ?>
										<tr>
											<td><input type="hidden" name="variation_id[]" value="0"><input type="hidden" name="variation_new[]" value="1"> <input type="text" autocomplete="off" placeholder="Serial" class="form-control" name="variation_serial[]"></td>
											<td><input type="text" autocomplete="off" placeholder="Name" class="form-control" name="variation_name[]"></td>
											<td><input type="text" autocomplete="off" placeholder="Price" class="form-control" name="variation_price[]"></td>
											<td><input type="text" autocomplete="off" placeholder="Stocks" class="form-control" name="variation_stocks[]"></td>
									 
										</tr>
										<?php else: ?>
											<?php foreach ( $variations as $variation ): ?>
												<tr>
													<td><input type="hidden" name="variation_id[]" value="<?php echo $variation->id ?>"><input type="hidden" name="variation_new[]" value="0"><input value="<?php echo $variation->serial ?>" type="text" autocomplete="off" placeholder="Serial" class="form-control" name="variation_serial[]"></td>
													<td><input value="<?php echo $variation->name ?>" type="text" autocomplete="off" placeholder="Name" class="form-control" name="variation_name[]"></td>
													<td><input value="<?php echo $variation->price ?>" type="text" autocomplete="off" placeholder="Price" class="form-control" name="variation_price[]"></td>
													<td><input value="<?php echo $variation->stocks ?>" type="text" autocomplete="off" placeholder="Stocks" class="form-control" name="variation_stocks[]"></td>
													 
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
								</table> 
							</fieldset>
						</div>
					 
						<div class="col-md-6 col-md-offset-2">
							<div class="row">
								<div class="col-md-2">
									Description
								</div>
								<div class="col-md-10">
									<div class="form-group">  
										<textarea rows="5" readonly autocomplete="off" maxlength="150" placeholder="Description" class="form-control" name="description"><?php echo $item->description ?></textarea>
									</div>
								</div>
							</div>
						</div>
					  	<div class="row">  
							<div class="form-group col-md-6 col-md-offset-2 text-right"> 
								<a href="<?php echo base_url('items/edit/' . $item->id) ?>" class="btn btn-primary" type="submit">Edit</a> 
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
				'<td><input type="hidden" name="variation_id[]" value="0"><input type="hidden" name="variation_new[]" value="1"><input type="text" autocomplete="off" placeholder="Serial" class="form-control" name="variation_serial[]"></td>' +
				'<td><input type="text" autocomplete="off" placeholder="Name" class="form-control" name="variation_name[]"></td>' + 
				'<td><input type="text" autocomplete="off" placeholder="Price" class="form-control" name="variation_price[]"></td>' + 
				'<td><input type="text" autocomplete="off" placeholder="Stocks" class="form-control" name="variation_stocks[]"></td>' + 
				'<td width="30px"><i class="fa fa-trash remove-row"></i></td>' +
				"</tr>");
		});

	})


</script>