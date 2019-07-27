<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Account <span style="float: right;">Total: ₱<?php echo number_format($total,2); ?> </span></h1>
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
             Account Receivables
         </div>

         <!-- /.panel-heading -->
         <div class="panel-body">
            <table class="table table-striped table-bordered table-hover" id="credits-tbl">
                <thead>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Total</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php foreach ($credits as $credit): ?>
                        <tr>
                            <td><?php echo $credit->id; ?></td>
                            <td><?php echo $credit->date; ?></td>
                            <td><?php echo $credit->name; ?></td>
                            <td>₱<?php echo number_format($credit->total,2); ?></td>
                            <td><?php echo $credit->paid == 0 ? 'Unpaid' : 'Paid'; ?></td>
                            <td>
                                <?php echo form_open("CreditsController/update") ?>
                                    <input type="hidden" name="credit_id" value="<?php echo $credit->id ?>">
                                    <input type="hidden" name="sales_id" value="<?php echo $credit->sales_id ?>">
                                    <button type="submit" class="btn btn-primary">Mark as paid</button>
                                <?php echo form_close(); ?>
                            </td> 
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
             
        </div>

    </div>

</div>

</div>

