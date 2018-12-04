<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Items</h1>
	</div>
    <div class="col-md-12">
        <?php 
        echo $this->session->flashdata('errorMessage');
        echo $this->session->flashdata('successMessage');
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
             				<?php $stocks = $orderingLevel->getQuantity($item->id)->quantity; ?>
                            <tr>
                 	 
                 				<td><?php echo $item->name ?></td>
                 				<td><?php echo $orderingLevel->getQuantity($item->id)->quantity ? $orderingLevel->getQuantity($item->id)->quantity : 'Out of stock'; ?></td>
                 				<td><?php echo $categoryModel->getName($item->category_id); ?></td>
                 				<td><?php echo $item->description ?></td>
                 				<td><?php echo '₱'. $price->getPrice($item->id) ?></td>
                 				<td><?php echo $stocks <= 0 ? '<span >Stock Out</span>' : ($stocks <= $item->critical_level ? '<span>Needs restock</span>' : '<span>Available</span>') ?></td>
                 				<td>
                                    <a href='<?php echo base_url("items/stock-in/$item->id") ?>'><button title='Stock In' class='btn btn-primary btn-sm'>Stock In</button></a> 
    				                <a href='<?php echo base_url("ItemController/edit/$item->id") ?>'><button title='Edit' class='btn btn-info btn-sm'>Edit</button></a> 
    				                <a href='<?php echo base_url("ItemController/delete/$item->id") ?>'><button title='Delete' class='btn btn-info btn-warning btn-sm'>Delete</button></a>
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
 
 