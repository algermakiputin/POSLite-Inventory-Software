<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Ingredients</h1>
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
             Ingredients List
         </div> 
         <div class="panel-body"> 
            <table class="table table-responsive table-striped table-hover table-bordered" id="" width="100%">
               <thead>
                <tr>
                    <th width="20%">Name</th>
                    <th width="20%">Unit</th>
                    <th width="20%">Stocks</th>
                    <th width="20%">Price</th> 
                    <th width="20%">Action</th>
                 </tr>
         </thead>
         <tbody>
            <?php foreach ($inventory as $row): ?>
                <tr>
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo $row->unit; ?></td>
                    <td><?php echo $row->stocks; ?></td>
                    <td><?php echo $row->price; ?></td>
                    <td><button>Test</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</div>

</div>

</div>

