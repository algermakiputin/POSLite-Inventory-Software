<div class="col-sm-10" id="main" style="padding-top: 20px;">
	<div class='col-sm-6'>
		<?php 
		$attribute = array(
			'class' => ''
			);
		echo form_open('ItemController/add_stocks',$attribute); 
		echo form_fieldset('<h3 class="text-primary">Add Stock/s </h3>');
		echo $this->session->flashdata('errorMessage');
		echo $this->session->flashdata('successMessage');
		?>

		<div class="form-group">
			<label>Stock In</label>
			<input type="text" name="stocks" class="form-control" placeholder="Enter Stocks To Add">
			<input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" name="submit_stocks" value="Add">
		</div>
		<?php echo form_close(); ?>
	</div>
	<div class="col-sm-6 ">
	<?php echo form_fieldset('<h3 class="text-primary">Item Information </h3>');?>
	<div id="item_info">
		<table class="table table-striped">
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
				<td><?php echo $item_info->category; ?></td>
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
		</div>
		 
	</table>
</div>
</div>
</div>

