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
						<form action="<?php echo base_url('DeliveriesController/update') ?>" method="POST">
							<input type="hidden" name="delivery_id" value="<?php echo $delivery->id ?>">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="row">
								<div class="col-md-3">
									<fieldset>
										<legend>Delivery Details</legend>
										<div class="form-group">
											<label>Select Supplier</label>
											<select class="form-control" name="supplier_id" required="required">
												<option value="">Select Supplier</option>
												<?php foreach ( $suppliers as $supplier ): ?>
													<option value="<?php echo $supplier->id ?>" <?php if ($delivery->supplier_id == $supplier->id) echo "selected" ?>><?php echo $supplier->name ?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<div class="form-group">
											<label>Delivery Date</label>
											<input type="text" value="<?php echo date('Y-m-d', strtotime($delivery->date_time)) ?>" autocomplete="off" autocomplete="off" required placeholder="Delivery Date" name="delivery_date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd">
										</div> 
										<div class="form-group">
											<label>Due Date</label>
											<input type="text" required autocomplete="off" autocomplete="off" placeholder="Due Date" name="due_date" class="form-control date-range-filter" id="due_date" value="<?php echo $delivery->due_date ?>" autocomplete="off" data-date-format="yyyy-mm-dd">
										</div> 
										<div class="form-group">
											<label>Payment Status</label>
											<select name="payment_status" class="form-control" required>
												<option value="Pending" <?php echo $delivery->payment_status == 0 ? "selected" : "" ?> >Pending</option>
												<option value="Paid" <?php echo  $delivery->payment_status == 1 ? "selected" : "" ?>>Paid</option>
											</select>
										</div>
									</fieldset>
								</div>
								<div class="col-md-9">
									<fieldset>
								<legend>Order Details</legend>
								<table class="table table-bordered" id="deliveryDetailsTable">
									<thead>
										<tr>
											<th>Enter Product</th> 
											<th>Expiry Date</th>
											<th>Price/unit</th>
											<th>QTY</th>
											<th>Defective</th>
											<th>Remarks</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($details as $order): ?>
										<tr>
											<td width="35%"> 
												<input type="text" name="product[]" autocomplete="off" value="<?php echo $order->name ?>" class="form-control product" placeholder="Type Product Name">
												<input type="hidden" autocomplete="off" value="<?php echo $order->item_id ?>" name="product_id[]">
											</td> 
											<td width="15%">
											 	<input type="text" name="expiry_date[]" data-date-format="yyyy-mm-dd" value="<?php echo $order->expiry_date ?>" autocomplete="off" placeholder="Expiry Date" class="form-control date-range-filter" required="required">
											</td>
											<td width="12%">
												<input type="text" name="price[]" autocomplete="off" value="<?php echo $order->price ?>" readonly placeholder="Price Per Unit" class="form-control" required="required">
											</td>
											<td width="15%">
											 	<input type="text" name="quantity[]" autocomplete="off" value="<?php echo $order->quantities ?>" placeholder="QTY" class="form-control" required="required">
											</td>
											<td width="15%">
												<input type="text" name="defective[]" autocomplete="off" value="<?php echo $order->defectives ?>" placeholder="Defectives" class="form-control" required="required"> 
											</td>
											<td width="16%"> 
												<input type="text" class="form-control" autocomplete="off" value="<?php echo $order->remarks ?>" placeholder="Additional Info" name="remarks[]"> 
											</td>
											<td></td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
								<div class="text-right">
									<button id="add" class="btn btn-default" type="button">Add</button>
								</div>
							</fieldset>
								</div>
							</div>
							
							<div class="form-group text-right">
									  
								<input type="submit" value="Update" name="" class="btn btn-primary" required="required">
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

			rowIndex.find(".product").val('');
			rowIndex.find("input[name='price']").val('');
			rowIndex.find("input[name='product_id']").val('');
			rowIndex.find("input[name='remarks']").val('');
			rowIndex.find("input[name='defective']").val('');
			rowIndex.find("input[name='quantity[]']").val('');
			rowIndex.find("input[name='expiry_date[]']").val('');
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