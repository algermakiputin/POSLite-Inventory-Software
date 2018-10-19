<div class="col-sm-10" id="main">
	<?php
		echo '<div class="table-wrapper">';
		if ($page === 'inventory') {
			if (empty($items) ) {
				echo '<div style="padding:20px;">';
				echo '<legend class="text-primary"><h3>Currently 0 Item</h3></legend> <br>' ;
				echo '<a href='. base_url('new_item') .' class="btn btn-warning">Register Item Now.</a>';
				echo '</div>';
			}else {
				echo '<div id="content">';
				echo $this->session->flashdata('successMessage');
				echo $this->session->flashdata('errorMessage');
				echo '<h1 class="page-title">Items</h1>';
				$tableAttr = array(
					'table_open' => '<table class="table table-responsive table-striped table-hover table-bordered" id="item_tbl">',
					);
				$item_table = $this->table->set_heading('No.','Name','Category','Description', 'Price','Status','Action');
				$item_table = $this->table->set_template($tableAttr);
				$num = 0;
			
				foreach ($items as $item) {
					$itemName = urlencode($item->name);
					$num++;
				 	$stocks = $orderingLevel->getQuantity($item->id)->quantity;
					$item_table = $this->table->add_row(
						$num, 
						$item->name, 
						$item->category, 
						$item->description, 
						'₱'. $price->getPrice($item->id),
						 
						$stocks <= 0 ? '<span class="label label-danger">Stock Out</span>' : ($stocks <= 5 ? '<span class="label label-warning ">Needs restock</span>' : '<span class="label label-success ">Available</span>'),
					 
						"<a href='".base_url("item/stock_in/$item->id")."'><button title='Stock In' class='btn btn-primary btn-sm'>Stock In</button></a> 
						<a href='".base_url("item/update/$item->id")."'><button title='Edit' class='btn btn-info btn-sm'>Edit</button></a> 
						<a href='".base_url("item/delete/$item->id")."'><button title='Delete' class='btn btn-info btn-warning btn-sm'>Delete</button></a>");
				}
				echo $this->table->generate($item_table);
				echo '</div>';
				$inventory = 'active';
			}
	
		} 
	?>
</div>
<div class="clearfix"></div>