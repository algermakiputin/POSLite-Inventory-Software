<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body onload="window.print()">
<link rel="stylesheet" href="<?php echo base_url('assets/css/receipt-invoice.css') ?>">
<table style="width: 100%;max-width: 593px;">
  <thead>
    <tr><td>
      <div class="header">
        <h3 class="text-center">#80 Katuparan St. Brgy. Commonwealth Quezon City <br/>
        		Tel. 430-9095 / 431-0035 </br>
        		Cell.: 0943-342-2576 / 0925-311-5902
        </h3> 
        <div class="col col-6"> 
            <h1>Order Slip:</h1>  
        </div>
        <div class="col col-6">
          <h1 class="text-right">No. &nbsp;&nbsp;&nbsp; 77979</h1> 
        </div> 
        <table width="100%" style="margin-bottom: 20px;">
        		<tr>
        			<td width="20%">Customer: </td>
      			<td width="80%" style="border-bottom: solid 1px #333; padding:3px;">
                <?php echo $invoice->customer_name; ?>   
              </td>
        		</tr>
        		<tr>
        			<td width="20%">Address: </td>
        			<td width="80%" style="border-bottom: solid 1px #333; padding:3px;">
                <?php echo $invoice->address; ?>    
              </td>
        		</tr>
        </table>
      </div>
    </td></tr>
  </thead>
  <tbody>
    <tr><td>
      <div class="content">
        <table width="100%" id="items_table"> 
          <thead>
            <tr class="head">
            <th width="15%" style="border-right: solid 1px #fff;text-align: center;padding: 5px">Qty</th> 
            <th width="45%" style="border-right: solid 1px #fff;text-align: center;padding: 5px">Description</th>
            <th width="20%" style="border-right: solid 1px #fff;text-align: center;padding: 5px">Unit Price</th>
            <th width="20%" style="text-align: center;padding: 5px">Amount</th>
          </tr>
          </thead>
          <tbody>
            <?php foreach ($orderline as $row): ?>
            <tr>
              <td style="text-align: center;padding: 5px;"><?php echo $row->quantity ?></td>
              <td style="text-align: center;padding: 5px;"><?php echo $row->name ?></td> 
              <td style="text-align: center;padding: 5px;"><?php echo $row->price ?></td>
              <td style="text-align: center;padding: 5px;"><?php echo currency() . $row->price * $row->quantity ?></td>  
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
    <tr><td>
      <div class="footer">
        
        <div class="col col-6"> 
        	&nbsp;
        </div>
        <div class="col col-6">  
           Received the above in good orders and condition
            </br>
            <table style="width: 100%;margin-top: 20px;">
            	<tr>
            		<td width="10%">By: &nbsp;</td>
            		<td style="border-bottom: solid 1px #000"></td>
            	</tr>
            </table>
        </div>
      </div>
    </td></tr>
  </tfoot>
</table>


<script type="text/javascript">
  
 
</script>
</body>
</html>