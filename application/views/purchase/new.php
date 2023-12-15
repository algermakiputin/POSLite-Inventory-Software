<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Purchase Order</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				New Purchase Order
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
						<form action="<?php echo base_url('PurchaseOrderController/store') ?>" method="POST">
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
													<option value="<?php echo $supplier->id ?>" <?php echo $supplier->id === $supplier_id ? 'selected' : '' ?>><?php echo $supplier->name ?></option>
												<?php endforeach; ?>
											</select>
										</div> 
										<div class="form-group">
											<label>ETA</label>
											<input type="text" autocomplete="off" required autocomplete="off" placeholder="ETA(Estimated Time Arrival)" name="eta" class="form-control date-range-filter" id="eta" autocomplete="off" data-date-format="yyyy-mm-dd">
										</div> 
										<div class="form-group">
											<label>Status</label>
											<select name="status" required class="form-control">
												<option value="Pending">Pending</option>
												<option value="Open Order">Open Order</option>
                                                <option value="Received">Received</option>
                                                <option value="Completed">Completed</option>
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
											<th>Price/unit</th> 
											<th>QTY</th> 
											<th>Remarks</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
                                        <?php foreach($itemsToReOrder as $index=>$item): ?>
                                            <tr>
                                                <td width="35%"> 
                                                    <input type="text" required name="product[]" value="<?php echo $item->name ?>" class="form-control product" placeholder="Type Product Name">
                                                    <input type="hidden" name="product_id[]" value="<?php echo $item->id ?>" >
                                                </td>  
                                                <td >
                                                    <input type="text" autocomplete="off" name="price[]" value="<?php echo $item->capital ?>" placeholder="Price Per Unit" class="form-control">
                                                </td>
                                                
                                                <td >
                                                    <input type="hidden" name="stocks[]"  value="" />
                                                    <input type="number" name="quantity[]" autocomplete="off" min="0" value="" placeholder="QTY" class="form-control" required="required">
                                                </td> 
                                                <td width="16%"> 
                                                    <input type="text" autocomplete="off" class="form-control" placeholder="Additional Info" name="remarks[]"> 
                                                </td>
                                                <td><span class='remove' style='color:red;margin-top:5px;display:block;font-weight:bold;font-size:14px;' title='remove'>X</span></td>
                                            </tr>
                                        <?php endforeach; ?>
									</tbody>
								</table> 
							</fieldset>
								</div>
							</div> 
							<div class="form-group text-right"> 
								<input type="submit" name="" value="Save Purchase Order" class="btn btn-primary" required="required">
							</div> 
						</form>
					</div> 
				</div> 
			</div> 
		</div> 
	</div> 
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
		var products = '<?php echo $products ?>'; 
		$(".product").autocomplete({
			lookup: products,
			onSelect: function(suggestion) {   
				$(this).parents("tr").find("input[name='price[]']").val(suggestion.capital)
				$(this).parents("td").find("input[name='product_id[]']").val(suggestion.data);  
				$(this).parents("tr").find("input[name='stocks[]']").val(suggestion.quantity);
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
					$(this).parents("tr").find("input[name='stocks[]']").val(suggestion.quantity);
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
		});

		
	})

</script>