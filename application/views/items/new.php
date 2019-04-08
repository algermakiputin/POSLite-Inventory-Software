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
								<input type="text" required="required" placeholder="Capital Per Unit" name="capital" class="form-control" max="500000">
							</div>
							<div class="form-group">  
									<label>Selling Price:</label>
								<input type="text" required="required" placeholder="Price" name="price" class="form-control" max="500000">
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
								<label>Description:</label> 
								<textarea rows="5" maxlength="150" placeholder="Description" class="form-control" name="description" required="required"></textarea>
							</div>
							<div class="form-group"> 
								<button class="btn btn-primary">Register Item</button>
							</div>
							
						</div> 
						<div class="col-lg-4">
							<div class="form-group">
								<div class="productImage" id="imagePreview">
									
								</div>
								<label>Product Image
									<input type="file" name="productImage" id="productImage">
								</label>
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
