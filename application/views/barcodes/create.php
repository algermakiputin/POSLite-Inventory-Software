<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Barcodes</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Print Barcode
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open('BarcodesController/generate', ['method' => 'POST', 'autocomplete' => 'off','id'=> "form"]) ?> 
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
						 		<label>Item Name</label>
								<input type="text" class="form-control" name="name" readonly="readonly"  value="<?php echo $barcode->name; ?>">
							</div>
						 	 
							<div class="form-group">
								<label># of Barcodes</label>  
								<input type="number" min="1" required="required" id="number" placeholder="Number" value="1" name="number" class="form-control">
							</div>
							<input type="hidden" name="item_id" value="<?php echo $barcode->id ?>" id="item_id">
						  
							<div class="form-group">
								<input type="submit" name="" value="Print" class="btn btn-primary"> 
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

<script type="text/javascript">
	
	$(document).ready(function(e) {

		$("#form").submit(function(e) {

			e.preventDefault();

			var item_id = $("#item_id").val();
			var number = $("#number").val();
			window.open("<?php echo base_url() ?>" + 'BarcodesController/export/' + item_id + "/" + number );
		})
	})
</script>