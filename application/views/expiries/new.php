<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Expiry</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				New Expired Product
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open('expenses/insert', ['method' => 'POST', 'autocomplete' => 'off']) ?> 
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
						 	<p>Scan barcode to enter product.</p>
						 	<div class="form-group">  
						 		<input type="hidden" name="item_id" value="">
						 		<label>Expiry Date</label>
								<input type="text" required="required" name="expiry_date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d') ?>">
							</div> 
							<div class="form-group">  
								<label>Barcode</label>
								<input type="text" required="required" readonly="readonly" name="barcode" class="form-control">
							</div>
							<div class="form-group">  
								<label>Product Name</label>
								<input type="text" required="required" readonly="readonly"  name="name" class="form-control">
							</div> 
							<div class="form-group">  
								<label>Capital</label>
								<input type="text" required="required" readonly="readonly" name="capital" class="form-control">
							</div>
							<div class="form-group">  
								<label>Retail Price</label>
								<input type="text" required="required" readonly="readonly" name="retail" class="form-control">
							</div>
							<div class="form-group">  
								<label>Quantities</label>
								<input type="text" required="required" name="quantities" class="form-control">
							</div>
						  
							<div class="form-group">
								<input type="submit" name="" value="Save" class="btn btn-primary"> 
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
		var csrfName = $("meta[name='csrfName']").attr('content');
		var csrfHash = $("meta[name='csrfHash']").attr("content");
		var base_url = $("meta[name='base_url']").attr('content'); 
		var data = {};
		data[csrfName] = csrfHash; 
		
		window.addEventListener('selectstart', function(e){ e.preventDefault(); });
		$(document).pos(); 
		
		$(document).on('scan.pos.barcode', function(event){   
 
			$.ajax({
				type: "POST",
				url: base_url + 'ItemController/find',
				data: data, 
				success: function() {
					alert(0)
				},
				error: function() {
					
				}
			}); 

		});


	});

	function successCallBack(data) {
		console.log(data)
	}

</script>