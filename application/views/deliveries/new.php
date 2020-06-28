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
								<div class="col-md-3">
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
										<input type="text" autocomplete="delivery_date" autocomplete="off" placeholder="YYYY-mm-dd" name="delivery_date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd">
									</div> 
								</div>
								<div class="col-md-9">
									<fieldset>
								<legend>Delivery Details</legend>
								<table class="table table-bordered" id="deliveryDetailsTable">
									<thead>
										<tr>
											<th>Enter Product</th> 
											<th>Price/unit</th>
											<th>QTY</th>
											<th>Defective</th>
											<th>Remarks</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td width="35%"> 
												<input type="text" name="product[]" class="form-control product" placeholder="Type Product Name">
												<input type="hidden" name="product_id[]" >
											</td> 
											
											<td width="15%">
												<input type="text" name="price[]" placeholder="Price Per Unit" class="form-control" required="required">
											</td>
											<td width="15%">
											 	<input type="text" name="quantity[]" placeholder="QTY" class="form-control" required="required">
											</td>
											<td width="15%">
												<input type="text" name="defective[]" placeholder="Defectives" class="form-control" required="required"> 
											</td>
											<td width="18%"> 
												<input type="text" class="form-control" placeholder="Additional Info" name="remarks[]"> 
											</td>
											<td></td>
										</tr>
									</tbody>
								</table>
								<div class="text-right">
									<button id="add" class="btn btn-default" type="button">Add</button>
								</div>
							</fieldset>
								</div>
							</div>
							
							<div class="form-group text-right">
									 
								<button type="reset" class="btn btn-info">Clear</button>
								<input type="submit" name="" class="btn btn-primary" required="required">
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

<script src="<?php echo base_url('assets/js/jquery-autocomplete.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var row = $("#deliveryDetailsTable tbody tr:first-child").html();
		var index = 1;
		var products = <?php echo $products ?>;
		$(".product").autocomplete({
			lookup: products,
			onSelect: function(suggestion) { 
				$(this).parents("tr").find("input[name='price[]']").val(suggestion.capital)
				$(this).parents("td").find("input[name='product_id[]']").val(suggestion.data);
			}
		});

		$("#add").click(function(e) {
			var tbody = $("#deliveryDetailsTable tbody");
			tbody.append("<tr id='row"+index+"'>"+ row +"</tr>");
			var rowIndex =  $("#row" + index);
			
			rowIndex.find(".product").autocomplete({
				lookup: products,
				onSelect: function(suggestion) {
					$(this).parents("tr").find("input[name='price[]']").val(suggestion.capital)
					$(this).parents("td").find("input[name='product_id[]']").val(suggestion.data);
				}
			})
			rowIndex.find("td:last-child").append("<span class='remove' style='color:red;margin-top:5px;display:block;font-weight:bold;font-size:14px;' title='remove'>X</span>")
			index++;

			$('.date-range-filter').datepicker({
					useCurrent : false,
					todayHighlight: true,
    				toggleActive: true,
    				autoclose: true,
				});

		});

		/*
			Remove button event handler
			Remove the row when clicked
		*/
		$("body").on("click", ".remove", function() {

			$(this).parents("tr").remove();
		})
	})

</script>