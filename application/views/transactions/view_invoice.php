<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Invoice: <?php echo $invoice->transaction_number ?></h1>
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
                TRANSACTION INVOICE
           </div> 
           <div class="panel-body"> 
                <div class="row">
                    <div class="col-md-8">
                        <h2>COMPANY NAME</h2>
                        <br/>
                        <div class="company_details">
                            <p>Street Address</p>
                            <p>City Zip</p>
                            <p>EMAIL PHONE</p>
                        </div>
                        <br/>
                        <div class="bill_to">
                            <h4>BILL TO</h4>
                            <p>NAME</p>
                            <p>ADDRESS</p>
                            <p>CITY, ZIP CODE</p>
                        </div>
                        <br/>                           
                    </div>
                    <div class="col-md-4">
                        <h1>INVOICE</h1>
                        <table style="display: block;margin: auto;">
                            <tr>
                                <td>DATE: &nbsp;</td>
                                <td>10/10/1995</td> 
                            </tr>
                            <tr>
                                <td>INVOICE #: &nbsp;</td>
                                <td>10/10/1995</td> 
                            </tr>
                            <tr>
                                <td>CUSTOMER ID: &nbsp;</td>
                                <td>10/10/1995</td> 
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered has-footer">
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
                     
                            <tr>
                            <td colspan="2" style="border: 0"></td>
                            <td colspan="1" class="text-right" style="border: 0"><b>TOTAL DUE</b></td>
                            <td class="text-right" style="border: 0"><?php echo currency() . number_format($total,2) ?></td>
                             
                            </tfoot>
                           
                        </table>
                    </div> 
                </div>
            </div> 
        </div> 
    </div>

</div>

