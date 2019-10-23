<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Category: <?php echo $cat->name; ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Edit Category
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open('CategoriesController/update', ['method' => 'POST', 'autocomplete' => 'off']) ?> 
						<input type="hidden" name="id" value="<?php echo $cat->id; ?>">
						<div class="col-lg-6 col-md-offset-3">
						 	<?php if ($this->session->flashdata('success')): ?>
						 		<div class="form-group"> 
						 			<div class="alert alert-success">
						 				<?php echo $this->session->flashdata('success') ?>
						 			</div>
						 		</div>
						 	<?php endif; ?>
						 	<div class="form-group">
						 		<?php echo validation_errors(); ?>
						 	</div> 
							<div class="form-group">  
								<label>Category Name:</label>
								<input type="text" required="required" placeholder="Category Name" name="name" class="form-control" value="<?php echo $cat->name; ?>">
							</div> 
							<div class="form-group">
								<input type="submit" name="" value="Update" class="btn btn-primary"> 
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
