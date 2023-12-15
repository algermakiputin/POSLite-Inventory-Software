<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body onload="">
<link rel="stylesheet" href="<?php echo base_url('assets/css/purchase-order.css') ?>">
<table style="width: 100%; ">
  <thead>
    <tr>
        <td>
            <div class="header"> 
                <div class="col col-6"> 
                    <h1>[Company Name]</h1>  
                    <p>[Street Address]</p>
                    <p>[Street Address]</p>
                    <p>[Street Address]</p>
                    <p>[Street Address]</p>
                </div>
                <div class="col col-6 text-right">
                    <h1 class="text-right">Purchase Order</h1> 
                    <p>Date: <?php echo substr($purchase->created_date, 0, 10) ?></p>
                    <p>PO Number: <?php echo $purchase->po_number ?></p>
                </div>   
            </div> 
        </td> 
    </tr>
    <tr>
        <td>
            <div class="header">
                <div class="col col-6">
                    <h1 class="with-bg">VENDOR</h1> 
                    <p>Supplier Name</p>
                    <p>Street address </p> 
                </div>
                <div class="col col-6">
                    <h1 class="with-bg">SHIP TO</h1> 
                    <p>Business Owner Name</p> 
                    <p>Street Address</p>
                </div>
            </div>
        </td>
    </tr>
  </thead>
  <tbody>
    <tr><td>
      <div class="content">
        <table width="100%" id="content"> 
          <thead>
            <tr class="head">
            <th width="15%" style="border-right: solid 1px #fff;text-align: center;padding: 5px">Qty</th> 
            <th width="30%" style="border-right: solid 1px #fff;text-align: center;padding: 5px">Description</th>
            <th width="20%" style="border-right: solid 1px #fff;text-align: center;padding: 5px">Unit Price</th>
            <th width="20%" style="text-align: center;padding: 5px">Amount</th>
            <th width="15%" style="text-align: center;padding: 5px">Sub Total</th>
          </tr>
          </thead>
          <tbody>
            <?php foreach ($orderline as $row): ?>
            <tr>
              <td style="text-align: center;padding: 5px;"><?php echo $row->quantity ?></td>
              <td style="text-align: center;padding: 5px;"><?php echo $row->item_name ?></td> 
              <td style="text-align: center;padding: 5px;"><?php echo $row->price ?></td>
              <td style="text-align: center;padding: 5px;"><?php echo $row->quantity ?></td>  
              <td style="text-align: center;padding: 5px;"><?php echo $row->quantity ?></td> 
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
    <tr>
        <td>
            <hr/>
            <div class="footer">  
                <div class="text-right" id="total">
                    Total Amount: <b>154</b>
                </div>
            </div>
        </td>
    </tr>
  </tfoot>
</table>


<script type="text/javascript">
  
 
</script>
</body>
</html>