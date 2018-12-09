<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Items
        <span class="pull-right">Inventory Total: ₱<span id="total"></span></span>
        </h1> 
	</div>
    <div class="col-md-12">
        <?php 
        echo $this->session->flashdata('errorMessage');
        echo $this->session->flashdata('successMessage');
        $total = 0;
        ?>
    </div>
</div>
<div class="row">
 <div class="col-lg-12">
     <div class="panel panel-default">
         <div class="panel-heading">
             Items List
         </div>

         <!-- /.panel-heading -->
         <div class="panel-body">
             <table class="table table-responsive table-striped table-hover table-bordered" id="item_tbl">
             		<thead>
             			<tr>
 
             				<th>Item Name</th>
             				<th>Quantity</th>
             				<th>Category</th>
             				<th>Description</th>
             				<th>Price</th>
             				<th>Status</th>
             				<th>Action</th>
             			</tr>
             		</thead>
             		<tbody>
             			<?php foreach ($items as $key => $item): ?>
             				<?php 
                                $stocks = $orderingLevel->getQuantity($item->id)->quantity; 
                                $item_price = $price->getPrice($item->id);
                                $total += $item_price;
                            ?>
                            <tr>
                 	 
                 				<td><?php echo $item->name ?></td>
                 				<td><?php echo $orderingLevel->getQuantity($item->id)->quantity ? $orderingLevel->getQuantity($item->id)->quantity : 'Out of stock'; ?></td>
                 				<td><?php echo $categoryModel->getName($item->category_id); ?></td>
                 				<td><?php echo $item->description ?></td>
                 				<td><?php echo '₱'. $item_price ?></td>
                 				<td><?php echo $stocks <= 0 ? '<span >Stock Out</span>' : ($stocks <= $item->critical_level ? '<span>Needs restock</span>' : '<span>Available</span>') ?></td>
                 				<td>
                                    <div class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                            <a href='<?php echo base_url("items/stock-in/$item->id") ?>'>
                                            <i class="fa fa-plus"></i> Stock In</a></li>
                                            <li><a href='<?php echo base_url("ItemController/edit/$item->id") ?>'><i class="fa fa-edit"></i> Edit</a> </li>
                                            <li>
                                                <a href='<?php echo base_url("ItemController/delete/$item->id") ?>'>
                                                <i class="fa fa-trash"></i>
                                                Delete</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                 			<?php endforeach; ?>
                            </tr>
             		</tbody>
             </table>
         </div>
         <!-- /.panel-body -->
     </div>
     <!-- /.panel -->
 </div>
 <!-- /.col-lg-12 -->
</div>
 
 <script type="text/javascript">
     document.querySelector("#total").innerText = "<?php echo number_format($total) ?>";
 </script>