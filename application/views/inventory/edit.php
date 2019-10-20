<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Edit: <?php echo $inventory->name; ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Edit Ingredient
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open('InventoryController/update', ['method' => 'POST', 'autocomplete' => 'off']) ?> 
						<div class="col-lg-6 col-md-offset-3">
						 	<?php if ($this->session->flashdata('success')): ?>
						 		<div class="form-group"> 
						 			<div class="alert alert-success">
						 				<?php echo $this->session->flashdata('success') ?>
						 			</div>
						 		</div>
						 	<?php endif; ?>
						  	<input type="hidden" name="id" value="<?php echo $inventory->id; ?>">
						 	<div class="form-group"> 
						 		<label>Name</label> 
								<input type="text" name="name" class="form-control" value="<?php echo $inventory->name; ?>">
							</div> 
							<div class="form-group">  
								<label>Unit</label>
								<input type="text" required="required" name="unit" class="form-control" value="<?php echo $inventory->unit; ?>">
							</div> 
							<div class="form-group">
								<label>Stocks</label>  
								<input type="number" required="required" name="stocks" class="form-control" value="<?php echo $inventory->stocks; ?>">
							</div>
							<div class="form-group">
								<label>Price</label>  
								<input type="number" required="required" name="price" class="form-control"value="<?php echo $inventory->price; ?>">
							</div>
							<div class="form-group">
								<input type="submit" name="" value="Save" class="btn btn-primary">
								<button type="reset" class="btn btn-info">Reset</button>
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
