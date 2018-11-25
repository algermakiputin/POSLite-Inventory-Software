<div class="row">
  <div class="col-lg-12">
  <h1 class="page-header">Suppliers </h1>
  </div>
  <!-- /.col-lg-12 -->
</div>
<div class="row">
 <div class="col-lg-12">
   <div class="panel panel-default">
     <div class="panel-heading">
       Suppliers List
     </div>
     <!-- /.panel-heading -->
     <div class="panel-body">
      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
          <p><?php echo $this->session->flashdata('success') ?></p>
        </div>
      <?php endif; ?> 
      <table class="table table-striped table-bordered table-hover table-responsive" id="supplier_table">
        <thead>
          <tr>
            <th width="25%">Name</th>
            <th width="30%">Address</th>
            <th width="25%">Contact</th> 
            <th width="20%">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($suppliers as $supplier): ?>
            <tr>
             <td><?php echo $supplier->name; ?></td>
             <td><?php echo $supplier->address; ?></td>
             <td><?php echo $supplier->contact; ?></td>
             <td>
               <button class="btn btn-info btn-sm edit" data-toggle="modal" data-target="#edit-supplier" data-id="<?php echo $supplier->id ?>">Edit</button>
               <a class="btn btn-danger btn-sm" href="<?php echo base_url('suppliers/delete/' . $supplier->id ) ?>">Delete</a>
             </td>
           </tr>
         <?php endforeach; ?>
       </tbody>
     </table>
   </div>
   <!-- /.panel-body -->
 </div>
 <!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
</div>



<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Supplier</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo base_url('suppliers/insert') ?>">
        	<div class="form-group">
        		<input type="text" class="form-control" name="name" placeholder="Name">
        	</div>
        	<div class="form-group">
        		<input type="text" class="form-control" name="address" placeholder="Address">
        	</div>
        	<div class="form-group">
        		<input type="text" class="form-control" name="contact" placeholder="Contact">
        	</div>
        	<div class="form-group">
        		<button class="btn btn-success">Save</button>
        	</div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="edit-supplier" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Supplier</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo base_url('suppliers/update') ?>" id="edit-supplier-form">
          <input type="hidden" name="id" id="supplier_id">
          <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Name">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="address" placeholder="Address">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="contact" placeholder="Contact">
          </div>
          <div class="form-group">
            <button class="btn btn-success">Save</button>
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>