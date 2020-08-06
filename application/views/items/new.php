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
				 
						<div class="col-lg-6 col-md-offset-2 ">
							<h3>Product Information</h3>
							<div class="row"> 
								<div class="col-md-2">
									*Product ID
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<input autocomplete="off" value="<?php echo $barcode ?>" readonly type="text" placeholder="Parent Serial" required="required" class="form-control" name="barcode" value="">
									</div>
								</div>

								<div class="col-md-2">
									*Product
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<input autocomplete="off" required="required" type="text" placeholder="Product" name="product" class="form-control">
									</div>
								</div>

								<div class="col-md-2">
									*Category
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<select name="category" class="form-control" required="required">
											<option value="">Select Category</option>
											<?php foreach ($category as $cat): ?>
												<option value="<?php echo $cat->id ?>"> <?php echo ucwords($cat->name) ?> </option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>

								<div class="col-md-2">
									*Supplier
								</div>
								<div class="col-md-10">
									<div class="form-group">   
										<select name="supplier" class="form-control" required="required"> 
											<option value="">Select Supplier</option>
											<?php foreach ($suppliers as $supplier): ?>
												<option value="<?php echo $supplier->id ?>">
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
										<input autocomplete="off" type="text" required="required" placeholder="Capital Price" name="capital" class="form-control" max="500000" id="selling-price">
									</div>
								</div>

								<div class="col-md-2">
									*Retail Price
								</div>
								<div class="col-md-10">
									<div class="form-group">   
										<input type="text" autocomplete="off" required="required" placeholder="Retail Price" name="price" class="form-control" max="500000" id="selling-price">
									</div> 
								</div>
								<div class="col-md-2">
									*Condition
								</div>
								<div class="col-md-10">
									<div class="form-group">   
										<select class="form-control" name="condition">
											<option>Brand New</option>
											<option>Used</option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									*Warranty Information
								</div>
								<div class="col-md-10">
									<div class="form-group">   
										<select class="form-control" name="warranty">
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

										</div>
										<label>Product Image
											<input type="file" name="productImage" id="productImage" class="form-control">
										</label>
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
										<button class="form-control btn btn-default" type="button" data-toggle="collapse" data-target="#advance-pricing-field"> Product Variation</button>
									</div>
									
								</div>

								
							</div> 
							
						</div> 
						<div class="col-md-7 col-md-offset-3">
							<fieldset style="background-color: #fafafa;" id="advance-pricing-field" class="collapse in">
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
										<tr>
											<td><input required type="text" autocomplete="off" placeholder="Serial" class="form-control" name="variation_serial[]"></td>
											<td><input required type="text" autocomplete="off" placeholder="Name" class="form-control" name="variation_name[]"></td>
											<td><input required type="text" autocomplete="off" placeholder="Price" class="form-control" name="variation_price[]"></td>
											<td><input required type="text" autocomplete="off" placeholder="Stocks" class="form-control" name="variation_stocks[]"></td>
											<td width="30px"><i class="fa fa-trash remove-row"></i></td>
										</tr>
									</tbody>
								</table>
								<div class="text-right">
									<button class="btn btn-default btn-sm" type="button" id="add-price">ADD VARIATION</button>
								</div>
							</fieldset>
						</div>

					 
						<div class="col-md-6 col-md-offset-2">
							<div class="row">
								<div class="col-md-2">
									Description
								</div>
								<div class="col-md-10">
									<div class="form-group">  
										<textarea rows="5" required="required" autocomplete="off" maxlength="150" placeholder="Description" class="form-control" name="description"></textarea>
									</div>
								</div>
							</div>
						</div>
					 
						<div class="row">  
							<div class="form-group col-md-6 col-md-offset-2 text-right"> 
								<button class="btn btn-primary">Register Item</button>
								<button class="btn btn-info" type="reset">Clear</button>
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
				'<td><input type="text" autocomplete="off" placeholder="Serial" class="form-control" name="variation_serial[]"></td>' +
				'<td><input type="text" autocomplete="off" placeholder="Name" class="form-control" name="variation_name[]"></td>' + 
				'<td><input type="text" autocomplete="off" placeholder="Price" class="form-control" name="variation_price[]"></td>' + 
				'<td><input type="text" autocomplete="off" placeholder="Stocks" class="form-control" name="variation_stocks[]"></td>' + 
				'<td width="30px"><i class="fa fa-trash remove-row"></i></td>' +
				"</tr>");
		});

		$("body").on('click','.remove-row', function(e) {

			var row_count = $("#advance-pricing-tbl tbody tr").length;

			if (row_count > 1) {
				$(this).parents('tr').remove();
			}else {
				alert('at least 1 Price is required');
			}
			
		});

	})


</script>