<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
 <style type="text/css">
    .peso-sign {
      font-family: "DejaVu Sans Mono", monospace;
    }
  </style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div style="padding: 20px; id="print">
            <div class="row"> 
                <div style="width:70%;float:left;">
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
                <div style="width:30%;float:left;" class="text-left">
                    <h1 class="bg-text">INVOICE</h1>
                    <table>
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
                <div style="clear:both">
                    <div class="">
                        <hr style="margin-top: 0;">
                    </div>
                    <div class="">
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
                                <td class="text-right"> <span class="peso-sign">&#x20b1;</span><?php echo number_format($order->price,2); ?></td>
                                <td class="text-right"> <span class="peso-sign">&#x20b1;</span><?php echo number_format($order->quantity * $order->price, 2); ?></td>
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
                        <td class="text-right" style="border: 0"><span class="peso-sign">&#x20b1;</span><?php echo  number_format($total,2) ?></td>
                        
                    </tfoot>
                    
                </table>
                <br/>
                <p><?php echo $invoice->note; ?></p>
            </div>  
        </div>
    </div>
</div>
</div> 

<style type="text/css">
    .table.has-footer {
  border-right-width: 0;
  border-left-width: 0;
  border-bottom-width: 0;
}

.table.has-footer tr td:first-child {
  border-left: solid 1px #ddd;
}

.table.has-footer tr td:last-child {
  border-right: solid 1px #ddd;
}

td.no-border {
  border:0!important;
}

.bg-header {
  background-color: #4f90bb;
  color: #fff;
}

.bg-text {
  color: #4f90bb;
}
</style>
