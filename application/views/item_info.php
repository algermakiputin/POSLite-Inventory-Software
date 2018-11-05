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