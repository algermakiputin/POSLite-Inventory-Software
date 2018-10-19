<div class="col-sm-10" id="main">
	<?php
		echo '<div class="table-wrapper">';
		 
		echo '<div id="content_category">';
		echo "<div class='row'>";
		echo '<div class="col-sm-3" >';
		echo $this->session->flashdata('errorMessage');
		echo $this->session->flashdata('successMessage');
		$formAttr = array(
			'id' => 'category_form'
			);
		echo '<div id="new_category">';
		echo form_open('category',$formAttr);
		echo ('<h1  class="page-title">New Category</h1>');
		echo '<div class="form-group">';
		echo form_label('Category Name');
		echo form_input(array('class' => 'form-control','name' => 'category','placeholder' => 'Enter Category Name Here'));
		echo '</div>';
		echo '<div class="form-group">';
		echo form_input(array('name' => 'submit','type' => 'submit', 'value' => 'Save', 'class' => 'btn btn-primary btn-md'));
		echo '</div>';
		echo form_fieldset_close();
		echo form_close();
		echo '</div>';
		echo '</div>';
		echo '<div class="col-sm-9">';
		if (empty($categoryList)) {
			echo '<div class="page-header"><h3 class="text-info">Category Is Empty</h3></div>';
		}else {
			echo '<div>';
			echo '<h1 class="page-title">Category List</h1>';
			$template = array(
				'table_open' => '<table class="table table-responsive table-striped table-hover table-bordered">',

				);
			$category_tbl = $this->table->set_template($template);
			$category_tbl = $this->table->set_heading('ID', 'DATE/TIME ADDED', 'NAME', 'CREATED BY','ACTION');
			$num = 0;
			foreach ($categoryList as $category) {
				$num += 1;
				$category_tbl = $this->table->add_row($num, $category->date_time, $category->category, $category->creator,'<a href="'. base_url('delete/category/'.$category->id.'').'"><button class="btn btn-danger btn-sm">Delete </button>');
			}
			echo '<div id="category_tbl">';
			echo $category_tbl->generate();
			echo '</div>';
			echo '</div>';
		}
		echo "</div>";
		echo '</div>';
		echo '</div>';
	 	?>
</div>
<div class="clearfix"></div>