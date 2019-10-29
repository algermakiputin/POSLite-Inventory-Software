<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div style="padding: 20px; id="print">
            <div class="row"> 
                <div style="width:70%;float:left;">
                    <h2>COMPANY NAME</h2>
                    <br/>
                    <div class="company_details">
                        <p>Street Address</p>
                        <p>City Zip</p>
                        <p>EMAIL PHONE</p>
                    </div>
                    <br/>
                    <div class="bill_to">
                        <h4 style="background: #eee;padding: 10px;max-width: 200px;border-radius: 3px;">BILL TO</h4>
                        <p>NAME</p>
                        <p>ADDRESS</p>
                        <p>CITY, ZIP CODE</p>
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
                <br/>
                <p>Invoice payment note</p>
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
