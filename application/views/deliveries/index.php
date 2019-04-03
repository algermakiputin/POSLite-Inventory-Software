<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Deliveries</h1>
	</div>
<!-- /.col-lg-12 -->
</div>
<div class="row">
 <div class="col-lg-12">
     <div class="panel panel-default">
         <div class="panel-heading">
             Deliveries List
         </div>
         <!-- /.panel-heading -->
         <div class="panel-body">	
 			<?php if ($this->session->flashdata('success')): ?>
 				<div class="alert alert-success">
 					<?php echo $this->session->flashdata('success') ?>
 				</div>
 			<?php endif; ?>
             <table class="table table-striped table-bordered table-hover table-responsive" id="deliveries_table">
				<thead>
					<tr>
						<th>Supplier Name</th>
						<th>Item Name</th>
						<th>Price</th> 
						<th>Quantity</th>
						<th>Expirty Date</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($dataSet as $data): ?> 
						<tr>
							<td><?php echo $data['supplier_name'] ?></td>
							<td><?php echo $data['item'] ?></td>
							<td>₱<?php echo number_format($data['price']) ?></td>
							<td><?php echo $data['quantity'] ?></td>
							<td><?php echo $data['expiry_date'] ?></td>
							<td><a href="<?php echo base_url('DeliveriesController/destroy/') ?><?php echo $data['id'] ?>" class="btn btn-danger btn-sm">Delete</a></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			
		</table>
         </div>
         <!-- /.panel-body -->
     </div>
     <!-- /.panel -->
 </div>
 <!-- /.col-lg-12 -->
</div>

 

