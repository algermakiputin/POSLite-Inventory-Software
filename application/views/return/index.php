<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Product Return</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Return Form
			</div>
			<div class="panel-body">
				<div class="row">
					<?php echo form_open('ReturnsController/insert', ['method' => 'POST', 'autocomplete' => 'off', 'id' => "form"]) ?> 
						<div class="col-lg-10 col-md-offset-1">
							<p>Scan product barcode to enter return product</p>
						 	<?php if ($this->session->flashdata('success')): ?>
						 		<div class="form-group"> 
						 			<div class="alert alert-success">
						 				<?php echo $this->session->flashdata('success') ?>
						 			</div>
						 		</div>
						 	<?php endif; ?>
						 	<?php if ($this->session->flashdata('error')): ?>
						 		<div class="form-group"> 
						 			<div class="alert alert-success">
						 				<?php echo $this->session->flashdata('error') ?>
						 			</div>
						 		</div>
						 	<?php endif; ?>
						 	<div class="form-group">
						 		<?php echo validation_errors(); ?>
						 	</div>
						 	<div id="list">
						 		<table class="table table-bordered table-hover" width="100%" id="return_tbl">
						 			<thead>
						 				<th>Barcode</th>
						 				<th>Name</th>
						 				<th>Qty</th>
						 				<th>Reason</th>
						 				<th>&nbsp;</th>
						 			</thead>
						 			<tbody>
						 				<tr class="free-row">
						 					<td><input type="text" required="required" name="barcodes[]" class="form-control" readonly="readonly"></td>
						 					<td><input type="text" required="required" name="names[]" class="form-control" readonly="readonly"></td>
						 					<td><input type="number" required="required" name="quantities[]" class="form-control"></td>
						 					<td><input type="text" name="reasons[]" class="form-control"></td>
						 					<td><i class="remove fa fa-close"></i></td>
						 					<input type="hidden" name="prices[]">
						 					<input type="hidden" name="ids[]">
						 				</tr>
						 			</tbody>
						 		</table>
						 	</div> 
						  
							<div class="form-group">
								<button type="button" class="btn btn-primary" id="add">Add Row</button>
								<button type="submit" class="btn btn-success">Confirm</button>
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

<script>

	$(document).ready(function() {
		var base_url = $("meta[name='base_url']").attr('content'); 
		var csrfName = $("meta[name='csrfName']").attr('content');
		var csrfHash = $("meta[name='csrfHash']").attr("content"); 
		var row = $(".free-row").first().html();

		window.addEventListener('selectstart', function(e){ e.preventDefault(); });
		$(document).pos();
		$(document).on('scan.pos.barcode', function(event){
	 
			if (event.code.length > 5) {
				data = {};
				data[csrfName] = csrfHash;
				data['code'] = event.code;
			
				$.ajax({
					type : 'POST',
					url : base_url + 'items/find',
					data : data,
					success : function(data) {

						if (data) {

							var result = JSON.parse(data);
							
							$(".free-row").first().find("input[name='barcodes[]']").val(result.barcode);
							$(".free-row").first().find("input[name='names[]']").val(result.name); 
							$(".free-row").first().find("input[name='ids[]']").val(result.id); 
							$(".free-row").first().find("input[name='quantities[]']").focus();
							$(".free-row").first().find("input[name='prices[]']").val(result.price.slice(1));
							$(".free-row").first().removeClass("free-row");

						}else {
							alert("Error: Not item found");
						}
					}
				})
			}
			   
		});

		$("#add").click(function(e) {

			$("#return_tbl tbody").append( '<tr class="free-row">' + row + '</tr>');

			$(this).focusout();
		});



		$("body").on("click", '.remove', function(e) {

			$(this).parents('tr').remove();
		});

		$("#form").submit(function(e) {

			var confirm = window.confirm("Confirm?");

			if (!confirm)
				return false;
		})

	})
 
</script>

<style type="text/css">
	
	.remove:hover {
		cursor: pointer;
	}
</style>