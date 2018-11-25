<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Categories</h1>
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
	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				New Category
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<?php 
						echo form_open('categories/insert');  
						
						?>
						<div class="form-group"> 
							<label>Category Name:</label>
							<input type="text" name="category" class="form-control" placeholder="Category">
							 
						</div>
						<div class="form-group"> 
							<button class="btn btn-primary">Submit</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				 
				</div>
			</div>
				<!-- /.row (nested) -->
		</div>
			<!-- /.panel-body -->
	</div>
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				Categories List
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						 <table class="table table-responsive table-striped table-hover table-bordered" id="categories_table">
						 	<thead>
						 		<tr>
						 			<th width="20%">ID</th>
						 			<th width="60%">Name</th>
						 			<th width="20%">Action</th> 
						 		</tr>
						 	</thead>
						 	<tbody>
						 		<?php foreach ($categoryList as $category): ?>
						 			<tr>
						 				<td><?php echo $category->id ?></td>
						 				<td><?php echo $category->name ?></td>
						 				<td>
						 					<a class="btn btn-danger btn-sm" href="<?php echo base_url('CategoriesController/destroy/'.$category->id.'') ?>">Delete</a>
						 				</td>
						 			</tr>
						 		<?php endforeach; ?>
						 		 
						 	</tbody>
						 </table>
					</div>
				</div>
			</div>
				<!-- /.row (nested) -->
		</div>
			<!-- /.panel-body -->
	</div>
		<!-- /.panel -->
</div>
 