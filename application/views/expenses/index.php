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
             <table class="table table-responsive table-striped table-hover table-bordered" id="expenses_table">
             		<thead>
             			<tr>
             				<th width="50%">Expense Name</th>
             				<th width="25%">Cost</th>
             				<th width="25%">Date</th> 
             			</tr>
             		</thead>
             		<tbody>
             		     <?php foreach ($expenses as $expense): ?>
                            <tr>
                                <td><?php echo $expense->type; ?></td>
                                <td>₱<?php echo $expense->cost; ?></td>
                                <td><?php echo $expense->date; ?></td>
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
 
 