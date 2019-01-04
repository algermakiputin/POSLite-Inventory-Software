<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Expenses</h1>
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
             Expenses List
         </div>

         <!-- /.panel-heading -->
         <div class="panel-body">
            <div id="widgets">
        <div class="col-md-6">
            <div class="sale-widget text-center">
                All Time<br>
                <b><span id="total-sales">₱<?php echo number_format($allTime[0]->cost,2) ?></span></b>
            </div>
        </div>
        <div class="col-md-6">
            <div class="sale-widget text-center">
                This Month<br>
                <b><span id="total-profit">₱<?php echo number_format($thisMonth[0]->cost,2) ?></span></b>
            </div>
        </div>
        
    </div>
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>
             <table class="table table-responsive table-striped table-hover table-bordered" id="expenses_table">
             		<thead>
             			<tr>
             				<th width="25%">Expense Name</th>
             				<th width="25%">Cost</th>
             				<th width="25%">Date</th> 
                            <th width="25%">Action</th>
             			</tr>
             		</thead>
             		<tbody>
             		     <?php foreach ($expenses as $expense): ?>
                            <tr>
                                <td><?php echo $expense->type; ?></td>
                                <td>₱<?php echo number_format($expense->cost,2) ?></td>
                                <td><?php echo $expense->date; ?></td>
                                <td><a href="<?php echo base_url("ExpensesController/destroy/") . $expense->id ?>" class="btn btn-danger btn-sm">Delete</a></td>
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
 
 