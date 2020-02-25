<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Cash Denomination</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Edit Cash Denomination
			</div>
			<div class="panel-body"> 
				<div class="row">
					<div class="col-md-12">
						<?php if ($this->session->flashdata('success')): ?>
					 		<div class="form-group"> 
					 			<div class="alert alert-success">
					 				<?php echo $this->session->flashdata('success') ?>
					 			</div>
					 		</div>
					 	<?php endif; ?>

					 	<?php if ($this->session->flashdata('error')): ?>
					 		<div class="form-group"> 
					 			<div class="alert alert-danger">
					 				<?php echo $this->session->flashdata('error') ?>
					 			</div>
					 		</div>
					 	<?php endif; ?>
					</div>
					<?php echo form_open('CashDenominationController/update', ['method' => 'POST', 'autocomplete' => 'off']) ?> 
						<div class="col-lg-6 col-md-offset-3">
						 	
						 	<div class="form-group">
						 		<?php echo validation_errors(); ?>
						 	</div>
						 	<div class="form-group text-center">  
						 		<label>Date</label>
								<p class="lead text-center"><?php echo $denomination->date ?></p>
								<input type="hidden" name="type" value="opening">
								<input type="hidden" name="total" value="<?php echo $denomination->total ?>" id="total_input">
								<input type="hidden" name="denomination_id" value="<?php echo $denomination->id ?>">
							</div>
							<div class="form-group text-center">  
						 		<label>Total</label>
								<p class="lead text-center"><span id="total">0</span></p>
							</div>
						 	<table class="table table-bordered table-striped">
						 		<thead>
						 			<tr>
						 				<th width="40%">Denomination</th>
						 				<th width="25%"># of Bills</th>
						 				<th width="35%">Amount</th>
						 			</tr>
						 		</thead>
						 		<tbody>
						 			<tr>
						 				<td>1000</td>
						 				<td><input data-value="1000" type="number" min="0" name="1000" value="<?php echo $cash['1000_'] ?>" class="form-control quantity"></td>
						 				<td><span class="amount"><?php echo number_format($cash['1000_'] * 1000) ?></span></td>
						 			</tr>
						 			<tr>
						 				<td>500</td>
						 				<td><input data-value="500" type="number" min="0" name="500" value="<?php echo $cash['500_'] ?>" class="form-control quantity"></td>
						 				<td><span class="amount"><?php echo number_format($cash['500_'] * 500) ?></span></td>
						 			</tr>
						 			<tr>
						 				<td>100</td>
						 				<td><input data-value="100" type="number" min="0" name="100" value="<?php echo $cash['100_'] ?>" class="form-control quantity"></td>
						 				<td><span class="amount"><?php echo number_format($cash['100_'] * 100) ?></span></td>
						 			</tr>
						 			<tr>
						 				<td>50</td>
						 				<td><input data-value="50" type="number" min="0" name="50" value="<?php echo $cash['50_'] ?>" class="form-control quantity"></td>
						 				<td><span class="amount"><?php echo number_format($cash['50_'] * 50) ?></span></td>
						 			</tr>
						 			<tr>
						 				<td>10</td>
						 				<td><input data-value="10" type="number" min="0" name="10" value="<?php echo $cash['10_'] ?>" class="form-control quantity"></td>
						 				<td><span class="amount"><?php echo number_format($cash['10_'] * 10) ?></span></td>
						 			</tr>
						 			<tr>
						 				<td>5</td>
						 				<td><input data-value="5" type="number" min="0" name="5" value="<?php echo $cash['5_'] ?>" class="form-control quantity"></td>
						 				<td><span class="amount"><?php echo number_format($cash['5_'] * 5) ?></span></td>
						 			</tr>
						 			<tr>
						 				<td>1</td>
						 				<td><input type="number" min="0" name="1" class="form-control quantity" value="<?php echo $cash['1_'] ?>" data-value="1"></td>
						 				<td><span class="amount"><?php echo number_format($cash['1_'] * 1) ?></span></td>
						 			</tr>
						 			<tr>
						 				<td>0.50</td>
						 				<td><input type="number" min="0" name="0_50" class="form-control quantity" value="<?php echo $cash['0_50'] ?>" data-value="0.50"></td>
						 				<td><span class="amount"><?php echo number_format($cash['0_50'] * 0.50) ?></span></td>
						 			</tr>
						 			<tr>
						 				<td>0.25</td>
						 				<td><input type="number" min="0" name="0_25" class="form-control quantity" value="<?php echo $cash['0_25'] ?>" data-value="0.25"></td>
						 				<td><span class="amount"><?php echo number_format($cash['0_25'] * 0.25) ?></span></td>
						 			</tr>
						 			<tr>
						 				<td>0.10</td>
						 				<td><input type="number" min="0" name="0_10" class="form-control quantity" data-value="0.10" value="<?php echo $cash['0_10'] ?>"></td>
						 				<td><span class="amount"><?php echo number_format($cash['0_10'] * 0.10) ?></span></td>
						 			</tr>
						 			<tr>
						 				<td>0.05</td>
						 				<td><input type="number" min="0" name="0_05" value="<?php echo $cash['0_05'] ?>" class="form-control quantity" data-value="0.05"></td>
						 				<td><span class="amount"><?php echo number_format($cash['0_05'] * 0.05) ?></span></td>
						 			</tr>
						 		</tbody>
						 	</table>
							<div class="form-group">
								<input type="submit" name="" value="Update" class="btn btn-primary"> 
							</div>
						</div>
					<?php echo form_close(); ?>
				</div> 
			</div> 
		</div> 
	</div> 
</div>  


<script type="text/javascript">
	
	$(document).ready(function() {

		var total = 0;

		$("#reset").click(function(e) {

			calculate_cash();
		})


		$(".quantity").keyup(function(e) {
		 
			calculate_cash(); 
		})
 

		function calculate_cash() {

			var denomination = $(".quantity");
			var grand_total = 0;

			denomination.each(function(e) {
				
				var value = $(this).data('value');
				var qty = $(this).val();	
				var row = $(this).parents('tr');
				var sub_total = value * qty;
				var sub = row.find('td').eq(2).text(number_format(sub_total));

				grand_total += sub_total;

			});

			$("#total").text(number_format(grand_total));
			$("#total_input").val(grand_total);
			total = number_format(grand_total);
		}

		
		function number_format(number, decimals, dec_point, thousands_point) {

		    if (number == null || !isFinite(number)) {
		        throw new TypeError("number is not valid");
		    }

		    if (!decimals) {
		        var len = number.toString().split('.').length;
		        decimals = len > 1 ? len : 0;
		    }

		    if (!dec_point) {
		        dec_point = '.';
		    }

		    if (!thousands_point) {
		        thousands_point = ',';
		    }

		    number = parseFloat(number).toFixed(decimals);

		    number = number.replace(".", dec_point);

		    var splitNum = number.split(dec_point);
		    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
		    number = splitNum.join(dec_point);

		    return number;
		}
	})
</script>
