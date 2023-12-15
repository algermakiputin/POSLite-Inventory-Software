<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Purchase Orders</h1>
	</div>
<!-- /.col-lg-12 -->
</div>
<div class="row">
 <div class="col-lg-12">
     <div class="panel panel-default">
         <div class="panel-heading">
             Purchase List
         </div>
         <!-- /.panel-heading -->
         <div class="panel-body">	
         	<?php echo $this->session->flashdata('successMessage'); ?>
 			<?php if ($this->session->flashdata('success')): ?>
 				<div class="alert alert-success">
 					<?php echo $this->session->flashdata('success') ?>
 				</div>
 			<?php endif; ?>
 			<?php if ($this->session->flashdata('error')): ?>
 				<div class="alert alert-danger">
 					<?php echo $this->session->flashdata('error') ?>
 				</div>
 			<?php endif; ?>
             <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="purchases_table">
				<thead>
					<tr> 
						<th>PO Number</th>
						<th>Date</th>
						<th>Supplier</th>
						<th>ETA</th>
						<th>Total</th>  
                        <th>Status</th>
						<th>Action</th>
					</tr>
				</thead> 
				<tbody> 
				</tbody>
			</table>
			
		</table>
         </div> 
     </div> 
 </div> 
</div> 