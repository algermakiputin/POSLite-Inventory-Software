<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body onload="window.print()">
<link rel="stylesheet" href="<?php echo base_url('assets/css/invoice.css') ?>">
<table style="width: 100%;max-width: 820px;">
  <thead>
    <tr><td>
      <div class="header">
        <h3>RANCE AARON REPUBLICAN HARDWARE COMPANY INC. <span style="float: right;">Sales Invoice</span></h3> 
        <div class="col col-6">
          <div class="section-input">
            <h4>Purpose:</h4>
             ______________________________
          </div>
          <div class="section-input">
            <h4>Invoice Details:</h4>
             <table>
               <tr>
                 <td>SI#</td>
                 <td style="border-bottom: solid 1px #000;padding: 3px;min-width: 185px;">&nbsp;</td>
               </tr>
               <tr>
                 <td>Customer Name&nbsp;&nbsp;</td>
                 <td style="border-bottom: solid 1px #000;padding: 3px;">test</td>
               </tr>
               <tr>
                 <td>Address &nbsp;&nbsp;&nbsp;</td>
                 <td style="border-bottom: solid 1px #000;padding: 3px;">&nbsp;       </td>
               </tr>
               <tr>
                 <td colspan="2" style="border-bottom: solid 1px;padding-top: 18px;"></td>
               </tr>
             </table>
          </div>
        </div>
        <div class="col col-6">
          <div class="text-right">
            <table style="float: right;border-collapse: collapse;">
              <tr>
                <td>Date &nbsp;</td>
                <td style="border:solid 1px #000; width: 170px;padding: 3px 5px;">
                  <?php echo date('Y-m-d', strtotime($invoice->date_time)) ?>
                </td>
              </tr>
              <tr>
                <td>Invoice Number # &nbsp;&nbsp;</td>
                <td style="border:solid 1px #000; width: 170px;padding: 3px 5px;">
                  <?php echo $invoice->transaction_number ?>
                </td>
              </tr>
              <tr>
                <td>Store &nbsp;</td>
                <td style="border:solid 1px #000; width: 170px;padding: 3px 5px;">
                  <?php echo $this->session->userdata('store_name') ?>
                </td>
              </tr>
            </table>
          </div>
        </div> 
      </div>
    </td></tr>
  </thead>
  <tbody>
    <tr><td>
      <div class="content">
        <table width="100%" id="items_table"> 
          <thead>
            <tr class="head">
            <th width="60%" style="border-right: solid 1px #fff;">Description</th>
            <th width="10%" style="border-right: solid 1px #fff;">QTY</th>
            <th width="15%" style="border-right: solid 1px #fff;">Unit Price</th>
            <th width="15%">Total</th>
          </tr>
          </thead>
          <tbody>
            <?php foreach ($orderline as $row): ?>
            <tr>
              <td><?php echo $row->name ?></td>
              <td><?php echo $row->quantity ?></td>
              <td><?php echo currency() . number_format($row->price,2) ?></td>
              <td><?php echo currency() . number_format($row->quantity * $row->price,2) ?></td>
            </tr>
            <?php endforeach; ?>

            <?php if ($defaultRow): ?>
              <?php 
                for ($i = 0; $i < $defaultRow; $i++) {
                  ?>
                  <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <?php 
                }
              ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
       
    </td>
    </tr> 

  </tbody>
  <tfoot>
    <tr><td>
      <div class="footer">
        
        <div class="col col-6">
          <div class="signature">
            ___________________________________
          <div class="text-center" style="padding-top: 5px;">
            Store Representative Signature
          </div>
          </div>
        </div>
        <div class="col col-6">
          <div class="signature" style="margin-left: auto;">
            ___________________________________
          <div class="text-center" style="padding-top: 5px;">
            Warehouse Representative Signature
          </div>
          </div>
        </div>
      </div>
    </td></tr>
  </tfoot>
</table>


<script type="text/javascript">
  
 
</script>
</body>
</html>