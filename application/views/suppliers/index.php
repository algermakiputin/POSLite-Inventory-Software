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
       <i class="fa fa-bar-chart-o fa-fw"></i> Suppliers List
     </div>
     <!-- /.panel-heading -->
     <div class="panel-body">
      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
          <p><?php echo $this->session->flashdata('success') ?></p>
        </div>
      <?php endif; ?> 
      <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>
      <table class="table table-striped table-bordered table-hover table-responsive" id="supplier_table">
        <thead>
          <tr>
            <th width="25%">Name</th>
            <th width="20%">Address</th>
            <th width="20%">Contact</th> 
            <th width="20%">Email Address</th>
            <th width="15%">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($suppliers as $supplier): ?>
            <tr>
             <td><?php echo $supplier->name; ?></td>
             <td><?php echo $supplier->address; ?></td>
             <td><?php echo $supplier->contact; ?></td>
             <td><?php echo $supplier->email; ?></td>
             <td>
               <button class="btn btn-info btn-sm edit" data-toggle="modal" data-target="#edit-supplier" data-id="<?php echo $supplier->id ?>">Edit</button>
               <a class="btn btn-danger btn-sm delete-data" href="<?php echo base_url('suppliers/delete/' . $supplier->id ) ?>">Delete</a>
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
      <?php echo form_open('suppliers/insert', ['method' => 'POST', 'autocomplete' => "OFF"]) ?>
      <div class="modal-body">
         
        	<div class="form-group">
        		<input required="required" type="text" class="form-control" name="name" placeholder="Name">
        	</div>
        	<div class="form-group">
        		<input required="required" type="text" class="form-control" name="address" placeholder="Address">
        	</div>
        	<div class="form-group">
        		<input required="required" type="text" class="form-control" name="contact" placeholder="Contact">
        	</div>
          <div class="form-group">
            <input required="required" type="text" class="form-control" name="email" placeholder="Email Address">
          </div>  
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" type="submit">Save</button>
        <button class="btn btn-info" type="reset">Clear</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      <?php echo form_close(); ?>
    </div>

  </div>
</div>

<div id="edit-supplier" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Supplier</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open('suppliers/update', ['method' => 'POST']) ?>
          <input type="hidden" name="id" id="supplier_id">
          <div class="form-group">
            <input required="required" type="text" class="form-control" name="name" placeholder="Name">
          </div>
          <div class="form-group">
            <input required="required" type="text" class="form-control" name="address" placeholder="Address">
          </div>
          <div class="form-group">
            <input required="required" type="text" class="form-control" name="contact" placeholder="Contact">
          </div>
          <div class="form-group">
            <input required="required" type="text" class="form-control" name="email" placeholder="Email Address">
          </div>
          <div class="form-group">
            <button class="btn btn-success">Save</button>
          </div>
        <?php echo form_close() ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>