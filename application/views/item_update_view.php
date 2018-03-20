<div class="col-sm-10" id="main" style="padding: 20px;">
	<?php echo form_open("item/item_update/$item->id");?>
	<?php echo form_fieldset('<h3 class="text-info">Update Item</h3>');	?>
	<input type="hidden" name="current_name" value="<?php echo $item->name ?>">
	<input type="hidden" name="current_category" value="<?php echo $item->category ?>" >
	<input type="hidden" name="current_description" value="<?php echo $item->description ?>">
	<input type="hidden" name="current_price" value="<?php echo $item->price ?>">
	<div class="form-group">
		<label>Item Name</label>
		<input type="text" name="update_name" placeholder="Item Name" class="form-control" value="<?php echo $item->name; ?>">
	</div>
	<div class="form-group">
		<label>Category</label>
		<select class="form-control" name="update_category">
		<?php
		foreach ($category as $cat) {
				?>
				<option value="<?php echo $cat->category; ?>" <?php if($cat->category == $item->category) {echo "selected = 'selected'";} ?>><?php echo $cat->category; ?>
				</option>
				<?php
		}
		?>
		</select>
	</div>
	<div class="form-group">
		<label>Price</label>
		<input type="text" name="update_price" placeholder="Item Name" class="form-control" value="<?php echo $item->price; ?>">
	</div>
	<div class="form-group">
		<label>Description</label>
		<textarea name="update_description" class="form-control" rows="5"><?php echo $item->description ?></textarea>
	</div>
	<div class="form-group">
		<input type="submit" name="submit" value="Update" class="btn btn-primary">
	</div>
	<?php echo form_close();?>
</div>