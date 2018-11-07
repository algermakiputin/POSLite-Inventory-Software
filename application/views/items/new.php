<div class="col-sm-10" id="main">
	<h1 class="page-title">Register Item</h1> 
	
		<div class="table-wrapper">
	 
		<div>
	<?php
		$nameAttr = array(
			'class' => 'form-control',
			'type' => 'text',
			'placeholder' => 'Item Name',
			'name' => 'item_name'
			);
		$categoryAttr = array(
			'class' => 'form-control input-lg',
			'name' => 'category'
			);
		$priceAttr = array(
			'class' => 'form-control',
			'name' => 'price',
			'placeholder' => 'Item Price'
			);
		$submitAttr = array(
			'class' => 'btn btn-primary',
			'name' => 'submit_item',
			'type' => 'submit',
			'value' => 'Register Item'
			);

		echo $this->session->flashdata('errorMessage');
		echo $this->session->flashdata('successMessage');
		echo form_open('items/insert');
		
		echo '<div class="row">';
		echo '<div class="col-lg-6">';
		echo '<div class="form-group">';
		echo form_label('Item Name');
		echo form_input($nameAttr);
		echo '</div>';
		echo '<div class="form-group">';
		echo form_label('Supplier');
		echo "<select class='form-control' name='category'>";
		echo '<option value="" name="supplier" selected="selected">Select Supplier</option>';
		foreach ($suppliers as $supplier) {
			?>
			<option value="<?php echo $supplier->id; ?>"><?php echo $supplier->name; ?></option>
			<?php
		}
		echo "</select>";
		echo '</div>';
		echo '<div class="form-group">';
		echo form_label('Category');
		echo "<select class='form-control' name='category'>";
		echo '<option value="" selected="selected">Select Any</option>';
		foreach ($category as $cat) {
			?>
			<option value="<?php echo $cat->category; ?>"><?php echo $cat->category; ?></option>
			<?php
		}
		echo "</select>";
		echo '</div>';
		echo '<div class="form-group">';
		echo form_label('Price');
		echo form_input($priceAttr);
		echo '</div>';
	
		echo '<div class="form-group">';
		echo form_label('Description');
		echo '<textarea name="description" class="form-control" rows="5" placeholder="Item Description"></textarea>';
		echo '</div>';
		echo '<div class="form-group">';
		echo form_input($submitAttr);
		echo '</div>';
		echo "</div>";
		echo "</div>";
		echo '</div>';
		echo form_close();
		echo '</div>';
		 
	?>
</div>
<div class="clearfix"></div>