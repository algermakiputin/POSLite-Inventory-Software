<div class="col-sm-10" id="main" style="padding-top: 20px;">
<div class='col-sm-6'>
<?php 
$attribute = array(
	'class' => ''
	);
echo form_open('item/add_stocks',$attribute); 
echo form_fieldset('<h3 class="text-primary">Add Stock/s </h3>');
echo $this->session->flashdata('errorMessage');
echo $this->session->flashdata('successMessage');
?>
 
<div class="form-group">
<label>Stock In</label>
	<input type="text" name="stocks" class="form-control" placeholder="Enter Stocks To Add">
	<input type="hidden" name="item_name" value="<?php echo $item_name; ?>">
</div>
<div class="form-group">
	<input type="submit" class="btn btn-primary" name="submit_stocks" value="Add">
</div>
<?php echo form_close(); ?>
</div>


