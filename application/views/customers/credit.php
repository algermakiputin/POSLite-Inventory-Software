<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Credit</h1>
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
                Transaction Credit
           </div> 
           <div class="panel-body"> 
                <div class="row">
                    <div class="col-md-6">
                        <h4>CREDIT DETAILS</h4>
                        <table width="100%" style="margin-bottom: 10px;">
                            <tr>
                                <td width="20%">Credit No:</td>
                                <td style="padding: 5px 0;"><input type="text" class="form-control" style="max-width: 250px" name="" readonly="readonly" value="<?php echo $credit->transaction_number; ?>"></td>
                            </tr> 
                            <tr>
                                <td width="20%">Date:</td>
                                <td style="padding: 5px 0;"><input type="text" class="form-control" style="max-width: 250px" name="" readonly="readonly" value="<?php echo date('Y-m-d', strtotime($credit->date_time)); ?>"></td>
                            </tr>
                            <tr>
                                <td width="20%">Customer:</td>
                                <td style="padding: 5px 0;"><input type="text" class="form-control" style="max-width: 250px" name="" readonly="readonly" value="<?php echo $credit->customer_name; ?>"></td>
                            </tr>
                        </table> 
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td width="10%">Qty</td>
                                    <td width="60%">Description</td>
                                    <td width="15%" class="text-right">Unit Price</td>
                                    <td width="15%" class="text-right">Amount</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderline as $order): ?>
                                    <tr>
                                        <td><?php echo $order->quantity; ?></td>
                                        <td><?php echo $order->name; ?></td>
                                        <td class="text-right"><?php echo currency() . number_format($order->price,2); ?></td>
                                        <td class="text-right"><?php echo currency() . number_format($order->quantity * $order->price, 2); ?></td>
                                    </tr>
                                    <?php $total+= $order->quantity * $order->price; ?>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot style="background-color: #f4f4f5;">
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="1" class="text-right"><b>Amount Paid</b></td>
                                    <td class="text-right"><?php echo currency() . number_format($paid,2) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="1" class="text-right"><b>Total</b></td>
                                    <td class="text-right"><?php echo currency() . number_format($total,2) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="1" class="text-right"><b>Balance</b></td>
                                    <td class="text-right"><?php echo currency() . number_format($total,2) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <a href="<?php echo base_url('payments/new/' . $credit->transaction_number) ?>" class="btn btn-default"><i class="fa fa-money"></i> Add Payment</a>
                    </div>

                </div>
            </div> 
        </div> 
    </div>

</div>

