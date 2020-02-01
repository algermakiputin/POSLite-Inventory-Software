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
				New Cash Denomination
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
						 	<div class="form-group text-center">  
						 		<label>Date</label>
								<p class="lead text-center"><?php echo date('Y-m-d') ?></p>
							</div>
							<div class="form-group text-center">  
						 		<label>Total</label>
								<p class="lead text-center">0.00</p>
							</div>
						 	<table class="table table-bordered table-striped">
						 		<thead>
						 			<tr>
						 				<td width="40%">Denomination</td>
						 				<th width="25%"># of Bills</th>
						 				<th width="35%">Amount</th>
						 			</tr>
						 		</thead>
						 		<tbody>
						 			<tr>
						 				<td>1000</td>
						 				<td><input type="text" name="quantity[]"></td>
						 				<td><span class="amount">0.00</span></td>
						 			</tr>
						 			<tr>
						 				<td>500</td>
						 				<td><input type="text" name="quantity[]"></td>
						 				<td><span class="amount">0.00</span></td>
						 			</tr>
						 			<tr>
						 				<td>100</td>
						 				<td><input type="text" name="quantity[]"></td>
						 				<td><span class="amount">0.00</span></td>
						 			</tr>
						 			<tr>
						 				<td>50</td>
						 				<td><input type="text" name="quantity[]"></td>
						 				<td><span class="amount">0.00</span></td>
						 			</tr>
						 			<tr>
						 				<td>10</td>
						 				<td><input type="text" name="quantity[]"></td>
						 				<td><span class="amount">0.00</span></td>
						 			</tr>
						 			<tr>
						 				<td>5</td>
						 				<td><input type="text" name="quantity[]"></td>
						 				<td><span class="amount">0.00</span></td>
						 			</tr>
						 			<tr>
						 				<td>1</td>
						 				<td><input type="text" name="quantity[]"></td>
						 				<td><span class="amount">0.00</span></td>
						 			</tr>
						 			<tr>
						 				<td>0.50</td>
						 				<td><input type="text" name="quantity[]"></td>
						 				<td><span class="amount">0.00</span></td>
						 			</tr>
						 			<tr>
						 				<td>0.25</td>
						 				<td><input type="text" name="quantity[]"></td>
						 				<td><span class="amount">0.00</span></td>
						 			</tr>
						 			<tr>
						 				<td>0.10</td>
						 				<td><input type="text" name="quantity[]"></td>
						 				<td><span class="amount">0.00</span></td>
						 			</tr>
						 			<tr>
						 				<td>0.05</td>
						 				<td><input type="text" name="quantity[]"></td>
						 				<td><span class="amount">0.00</span></td>
						 			</tr>
						 		</tbody>
						 	</table>
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
