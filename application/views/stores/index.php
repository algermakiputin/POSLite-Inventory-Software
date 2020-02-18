<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Stores</h1>
	</div> 
    <div class="col-md-12">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="row">
  
    <div class="col-lg-12">
     <div class="panel panel-default">
         <div class="panel-heading">
             <i class="fa fa-money fa-fw"></i> Stores List
         </div> 
         <div class="panel-body"> 
            <table class="table table-responsive table-striped table-hover table-bordered datatable"  width="100%">
               <thead>
                    <tr>
                        <th>Store #</th>
                        <th>Name / Branch</th>
                        <th>Location</th>
                        <th>Actions</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stores as $store): ?>
                        <tr>
                            <td><?php echo $store->number ?></td>
                            <td><?php echo $store->branch ?></td>
                            <td><?php echo $store->location ?></td>
                            <td><a href="<?php echo base_url('store/edit/' . $store->id) ?>" class="btn btn-primary btn-sm">Edit</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
         <tbody>
            
        </tbody>
    </table>
</div>

</div>

</div>

</div>

