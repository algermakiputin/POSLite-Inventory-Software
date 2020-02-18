<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Stores</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Edit Store
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open('StoresController/update', ['method' => 'POST', 'autocomplete' => 'off']) ?> 
						<div class="col-lg-6 col-md-offset-3">
						 	<?php if ($this->session->flashdata('success')): ?>
						 		<div class="form-group"> 
						 			<div class="alert alert-success">
						 				<?php echo $this->session->flashdata('success') ?>
						 			</div>
						 		</div>
						 	<?php endif; ?>  
						 	<div class="form-group"> 
						 		<input type="hidden" name="id" <?php echo $store->id ?>>
								<label>Store Number</label> 
								<input type="text" required="required" value="<?php echo $store->number ?>" name="number" readonly class="form-control">
							</div>
							<div class="form-group"> 
								<label>Store Name</label> 
								<input type="text" required="required" value="<?php echo $store->branch ?>" name="name" class="form-control">
							</div>
							<div class="form-group"> 
								<label>Location</label> 
								<input type="text" required="required" value="<?php echo $store->location ?>" name="location" class="form-control">
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
