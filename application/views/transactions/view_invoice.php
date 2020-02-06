<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">INVOICE NO. <?php echo $invoice->transaction_number ?></h1>
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
    <div class="col-md-8">
        <div style="padding: 20px;border:solid 1px #ddd;" id="print">
            <div class="row"> 
            <div class="col-md-8">
                <h2><?php echo $preference['name'] ?></h2>
                <br/>
                <div class="company_details">
                    <p><?php echo $preference['address']; ?></p>
                    <p><?php echo $preference['city']; ?>, <?php echo $preference['zip']; ?></p>
                    <p><?php echo $preference['phone']; ?></p>
                </div>
                <br/>
                <div class="bill_to">
                    <h4 style="background: #eee;padding: 10px;max-width: 200px;border-radius: 3px;">BILL TO</h4>
                    <p><?php echo $invoice->customer_name; ?></p>
                    <p><?php echo $invoice->address; ?></p>
                    <p><?php echo $invoice->city; ?> <?php if ($invoice->city && $invoice->zipcode) : echo ","; endif; ?> <?php echo $invoice->zipcode; ?></p>
                </div>
                <br/>                           
            </div>
            <div class="col-md-4">
                <h1 class="bg-text">INVOICE</h1>
                <table style="display: block;margin: auto;">
                    <tr>
                        <td>DATE: &nbsp;</td>
                        <td><?php echo date('m/d/Y', strtotime($invoice->date_time)) ?></td> 
                    </tr>
                    <tr>
                        <td>INVOICE #: &nbsp;</td>
                        <td><?php echo $invoice->transaction_number ?></td> 
                    </tr>
                    <tr>
                        <td>CUSTOMER ID: &nbsp;</td>
                        <td><?php echo $invoice->customer_id; ?></td> 
                    </tr>
                </table>
            </div>
            <div class="col-md-12">
                <hr style="margin-top: 0;">
            </div>
            <div class="col-md-12"> 
                <table class="table table-bordered has-footer">
                    <thead>
                        <tr>
                            <td width="10%" class="bg-header">Qty</td>
                            <td width="60%" class="bg-header">Description</td>
                            <td width="15%" class="text-right bg-header">Unit Price</td>
                            <td width="15%" class="text-right bg-header">Amount</td>
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

                        <?php if ($defaultRow): ?>

                            <?php 
                                for ($i = 0; $i < $defaultRow; $i++) {
                                    ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <?php

                                }
                            ?>
                        <?php endif; ?>
                    </tbody> 
                    <tr>
                        <td colspan="2" style="border: 0"></td>
                        <td colspan="1" class="text-right" style="border: 0"><b>TOTAL DUE</b></td>
                        <td class="text-right" style="border: 0"><?php echo currency() . number_format($total,2) ?></td>
                    </tr>
                    </tfoot>
                    
                </table>
            </div> 
            <div class="col-md-12">
                <a class="btn btn-default" href="<?php echo base_url('TransactionsController/pdf_invoice/' . $invoice->transaction_number) ?>" id="pdf"><i class="fa fa-file-pdf-o"></i> PDF</a>

                <a class="btn btn-default delete-data" href="<?php echo base_url('TransactionsController/destroy_invoice/' . $invoice->id) ?>" id="pdf"><i class="fa fa-trash"></i> DELETE</a>
            </div> 
        </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/js/invoice.js') ?>"></script>

 
