<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Delivery</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				New Delivery
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<?php if ($this->session->flashdata('success')): ?>
							<div class="alert alert-success">
								<p><?php echo $this->session->flashdata('success') ?></p>
							</div>
						<?php endif; ?> 
						<?php if ($this->session->flashdata('error')): ?>
							<div class="alert alert-danger">
								<p><?php echo $this->session->flashdata('error') ?></p>
							</div>
						<?php endif; ?> 
						<form action="<?php echo base_url('delivery/insert') ?>" method="POST">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label>Select Supplier</label>
										<select class="form-control" name="supplier_id" required="required">
											<option value="">Select Supplier</option>
											<?php foreach ( $suppliers as $supplier ): ?>
												<option value="<?php echo $supplier->id ?>"><?php echo $supplier->name ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="form-group">
										<label>Delivery Date</label>
										<input type="text" required="required" placeholder="Date" name="delivery_date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" autocomplete="off">
									</div>  
								</div>
								<div class="col-md-10">
									<fieldset>
								<legend>Delivery Details</legend>
								<table class="table table-bordered" id="deliveryDetailsTable">
									<thead>
										<tr>
											<th width="15%">Barcode</th>
											<th width="20%">Name</th>
											<th width="10%">Expiry Date</th>
											<th width="10%">Capital/unit</th>
											<th width="10%">Retail Price</th>
											<th width="10%">QTY</th>
											<th width="10%">Defective</th>
											<th width="10%">Remarks</th>
											<th width="5%"></th>
										</tr>
									</thead>
									<tbody>
										<tr id="placeholder">
											<td colspan="9">
												Add row or scan barcode to add products
											</td>
										</tr>
									</tbody>
								</table> 
							</fieldset>
								</div>
							</div> 
							<div class="form-group text-right">
								<button id="add" type="button" class="btn btn-primary">Add Row</button>
								<button type="reset" class="btn btn-info">Clear</button>
								<input type="submit" name="" class="btn btn-success" required="required">
							</div>
		 
						</form>
					</div>
					<!-- /.col-lg-6 (nested) -->
					
					<!-- /.col-lg-6 (nested) -->
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  
<style type="text/css">
	table tr td {
		vertical-align: top!important;
		padding: 15px;
	}
	.remove:hover {
		cursor: pointer;
	}
</style>
<script src="<?php echo base_url('assets/js/jquery-pos.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-autocomplete.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var row = '<td><input readonly type="text" name="barcodes[]" class="form-control product"><input type="hidden" name="product_id[]" ></td><td><input autocomplete="off" type="text" name="names[]" class="form-control"></td><td><input type="date"  name="expiry_date[]" class="form-control" required="required"></td><td><input type="text" name="capitals[]" placeholder="Capital Per Unit" class="form-control" required="required"></td><td><input type="text" name="retails[]" placeholder="Retail Price" class="form-control" required="required"></td><td><input type="text" name="quantity[]" autocomplete="off" placeholder="QTY" class="form-control" required="required"></td><td><input type="text" name="defective[]" autocomplete="off" placeholder="Defectives" class="form-control" required="required"> </td><td> <input type="text" class="form-control" placeholder="Additional Info" name="remarks[]"> </td><td></td>';
		var index = 1;
		var products = <?php echo $products ?>;
		var base_url = $("meta[name='base_url']").attr('content');
		var csrfName = $("meta[name='csrfName']").attr('content');
		var csrfHash = $("meta[name='csrfHash']").attr('content');
		var started = 0;

		$(".product").autocomplete({
			lookup: products,
			onSelect: function(suggestion) {   
				$(this).parents("tr").find("input[name='barcodes[]']").val(suggestion.barcode);
				$(this).parents("tr").find("input[name='retails[]']").val(suggestion.price);
				$(this).parents("tr").find("input[name='capitals[]']").val(suggestion.capital);

				$(this).parents("tr").find("input[name='product_id[]']").val(suggestion.data);
			 

			}
		});

		$("#add").click(function(e) {
			var tbody = $("#deliveryDetailsTable tbody");
			tbody.append("<tr id='row"+index+"'>"+ row +"</tr>");
			var rowIndex =  $("#row" + index);
			
			rowIndex.find(".product").autocomplete({
				lookup: products,
				onSelect: function(suggestion) {
					$(this).parents("tr").find("input[name='barcodes[]']").val(suggestion.barcode);
					$(this).parents("tr").find("input[name='retails[]']").val(suggestion.price);
					$(this).parents("tr").find("input[name='capitals[]']").val(suggestion.capital);
					$(this).parents("tr").find("input[name='product_id[]']").val(suggestion.data);
				}
			})
			rowIndex.find("td:last-child").append("<span class='remove' style='color:red;margin-top:5px;display:block;font-weight:bold;font-size:14px;' title='remove'>X</span>")
			index++;

		});

		/*
			Remove button event handler
			Remove the row when clicked
		*/
		$("body").on("click", ".remove", function() {

			$(this).parents("tr").remove();
		})

		var data = {};
		data[csrfName] = csrfHash;
		

		window.addEventListener('selectstart', function(e){ e.preventDefault(); });
		$(document).pos();
		$(document).on('scan.pos.barcode', function(event){
		 	
		 	if (!started) {

		 		started = 1;
		 		$("#placeholder").remove();
		 	}

			var barcode = event.code;
			data['code'] = barcode;
			$.ajax({
				type: "POST",
				url: base_url + 'ItemController/find',
				data: data,
				success: function(data) {
					console.log(data);			
					var item = JSON.parse(data);
				
					var tbody = $("#deliveryDetailsTable tbody");
					tbody.append("<tr id='row"+index+"'>"+ row +"</tr>");
					var rowIndex =  $("#row" + index);
					rowIndex.find("input[name='capitals[]']").val(item.capital.slice(1));
					rowIndex.find("input[name='names[]']").val(item.name);
					rowIndex.find("input[name='barcodes[]']").val(item.barcode);
					rowIndex.find("input[name='retails[]']").val(item.price.slice(1));
					rowIndex.find("input[name='product_id[]']").val(item.id); 
					rowIndex.find("td:last-child").append("<span class='remove' style='color:red;margin-top:5px;display:block;font-weight:bold;font-size:14px;' title='remove'>X</span>") 
				
					index++; 

				},
				error: function() {
					alert("Error: Opps something went wrong, please check your internet connection and try again");
				}
			});
 
		}); 

		$("input[name='quantity[]']").keyup(function() {
			$(this).focusout();
		})
	})

</script>