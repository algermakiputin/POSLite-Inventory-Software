<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Product: <?php echo $item_info->name ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Stock In
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<?php 
						echo form_open('ItemController/add_stocks');  
						echo $this->session->flashdata('errorMessage');
						echo $this->session->flashdata('successMessage');
						?>
						<div class="form-group"> 
							<label>Add Stocks:</label>
							<input type="hidden" name="item_name" value="<?php echo $item_info->name; ?>">
							<input type="number" autocomplete="off" <?php if(SITE_LIVE) echo 'max="500"'; ?> name="stocks" class="form-control" placeholder="Enter Stocks To Add">
							<input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
							<input type="hidden" name="current_stocks" value="<?php echo $orderingLevel->getQuantity($item_info->id)->quantity ?>" />
						</div>
						 
						<div class="form-group"> 
							<button class="btn btn-primary">Stock In</button>
						</div>
						<?php echo form_close(); ?>
					</div>
					<div class="col-lg-6">
						<table class="table table-striped">
							<legend>Item Information</legend>
							<tr>
								<td width="35%">ID:</td>
								<td><?php echo $item_info->id; ?></td>
							</tr>
							<tr>
								<td>Item Name:</td>
								<td><?php echo $item_info->name; ?></td>
							</tr>
							<tr>
								<td>Category:</td>
								<td><?php echo $categoryModel->getName($item_info->category_id); ?></td>
							</tr>
							<tr>
								<td>Quantities:</td>
								<td><?php echo $orderingLevel->getQuantity($item_info->id)->quantity ?></td>

							</tr>
							<tr>
								<td>Description:</td>
								<td><?php echo $item_info->description; ?></td>
							</tr>

							<tr>
								<td>Price:</td>
								<td><?php echo $price->getPrice($item_info->id) ?></td>
							</tr>
						</table>
						</div>
					</div>
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  


 


