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
         	<?php echo $this->session->flashdata('successMessage'); ?>
 			<?php if ($this->session->flashdata('success')): ?>
 				<div class="alert alert-success">
 					<?php echo $this->session->flashdata('success') ?>
 				</div>
 			<?php endif; ?>
             <table class="table table-striped table-bordered table-hover table-responsive" id="deliveries_table">
				<thead>
					<tr>
						<th>Delivery ID</th>
						<th>Delivery Date</th>
						<th>Received By</th>
						<th>Supplier</th> 
						<th>Total Amount</th>
						<th>Defectives</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
				 	<?php foreach($deliveries as $delivery): ?> 
						<tr>
							<td><?php echo $delivery->id ?></td>
							<td><?php echo $delivery->date_time ?></td>
							<td><?php echo $delivery->received_by ?></td>
							<td><?php echo $delivery->name ?></td>
							<td>₱<?php echo number_format($delivery->total) ?></td>
							<td><?php echo $delivery->defectives ?></td>
							<td>
								<div class="dropdown">
		                    	<a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
		                    	<ul class="dropdown-menu">
		                    	
		                        <li>
		                        	<a href="<?php echo base_url("deliveries/details/" . $delivery->id) ?>"><i class="fa fa-eye"></i> View Details</a> 
		                        </li> 
		                        <li>
		                            <a class="delete-data" href="<?php echo base_url('DeliveriesController/destroy/') ?><?php echo $delivery->id ?>">
		                                <i class="fa fa-trash"></i> Delete</a>
		                        </li>
		                    	</ul>
				            </div> 
							</td>
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

 

