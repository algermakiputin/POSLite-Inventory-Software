<html>
<header>
    <title>Delivery Receipt</title>
</header>
<body>
<div class="container">  
  <table width="100%" style="border-collapse: collapse;">
    <tr>
      <td widdth="50%">
        <strong>IGREYWARE TRADING</strong><br>
        <div style="font-size:13px;line-height:18px">
            <span>#32 Teodora Park Subd. Conception I,<span><br>
            <span>Marikina City, 1807 Philippines<span><br>
            <span>Tel No.: (02) 7940-2794<span><br>
            <span>Mobile No.: (0927)4730700<span><br>
            <span>Email: sales@igreyware.ph<span><br>
            <span>NON VAT TIN: 478-809-256-000<span><br>
        </div>
      </td>
      <td>
        <h1 style="text-align:right">Delivery Receipt</h1>
      </td>
    </tr>
  </table>
  <br><br>
  <table width="100%">
    <tr>
      <td>
        <table style="font-size:14px">
          <tr> 
            <td><strong>Sold To</strong></td>
            <td><?php echo $sales->name ?></td>
          </tr>
          <tr> 
            <td><strong>Address</strong></td>
            <td><?php echo $sales->home_address  ?></td>
          </tr>
          <tr> 
            <td><strong>Contact No:</strong></td>
            <td><?php echo $sales->contact_number ?></td>
          </tr>
        </table>
      </td>
      <td>
        <table style="font-size:14px"> 
            <tr>
                <td><strong>Order No.</strong></td>
                <td><?php echo $sales->transaction_number ?></td>
            </tr>
            <tr>  
                <td><strong>Date</strong></td>
                <td><?php echo date('Y-m-d', strtotime($sales->date_time)) ?> </td>
            </tr>
        </table>
      </td>
    </tr>
  </table>
  <br>  
  <table width="100%" style="border-collapse: collapse;border-bottom:1px solid #eee;">
    <tr>
      <td width="40%" class="column-header">ITEM CODE/PRODUCT NAME</td>
      <td width="20%" class="column-header">QTY.</td>
      <td width="20%" class="column-header">PRICE/UNIT</td>
      <td width="20%" class="column-header">AMOUNT</td>
    </tr> 
    <?php foreach ($orderline as $item): ?>
      <?php 
        $subTotal = $item->price * $item->quantity;
        $total+= $subTotal;
      ?>
      <tr>
        <td class="row"><?php echo $item->name ?></td>
        <td class="row"><?php echo $item->quantity ?></td>
        <td class="row"><?php echo number_format($item->price,2) ?></td>
        <td class="row"><?php echo number_format($subTotal,2) ?></td>
      </tr>  
    <?php endforeach; ?>
    <tr>
      <td class="row" colspan="3" style="text-align:right"><strong>Total</strong></td>
      <td class="row"><?php echo number_format($total,2) ?></td>
    </tr>
  </table> 
  <br>
  <table width="100%">
    <tr>
      <td>
        <table width="300px">
          <tr>
            <td style="text-align:center">
            <br/>
              <hr style="margin-bottom:2px" />
              <span style="font-size:14;position">signature over printed name</span>
               
            </td> 
          </tr> 
          <tr>
            <td style="text-align:center">
            <br/>
              <hr style="margin-bottom:2px" />
              <span style="font-size:14;position">IGreyware Trading - N.I.T.S.</span>
            </td> 
          </tr>
        </table>
        <br/>
      </td>
    </tr>
  </table>
  <div style="border:solid 1px #000">
  <table width="100%" style="margin-bottom:20px;font-size:14px">
    <tr>
      <td style="text-align:center">Prepared by:</td>
      <td style="text-align:center">Checked by:</td>
      <td style="text-align:center">Released by:</td>
    </tr> 
  </table>
  <hr/>
  <p style="padding-left:10px;font-size:12px">*ALWAYS ENCLOSE THE DELIVERY RECEIPT TOGETHER WITH THE UNIT FOR RMA REQUEST UPON RETURN. NO DELIVERY RECEIPT, NO RMA PROCESSING.</p>
  </div> 
  <p style="font-size:11px">By affixing your signature herein confirms and acknoledges the delivery and receipt of good/s and/or item/s in good condition and thereby is/are free from 
    defects. *Item/s shipped through third party logistics are checked to ensure products and its parts are complete prior to shipping. Customer acknowledges that item/s
    which will be shipped through third party logistics may be checked by their authorized representative ONLY UPON item turnover or acceptance for delivery and PROCESSING.
    *Warranty does not apply if the product has been subjected to misuse, abuse negligence, abnormal physical, electromagnetic, electrical stress, including lightning strikes, 
    or accidents. *Limited warranty specifics one(1) year coverage of NORMAL USE and as such excludes defects arising from stipulated conditions found at www.ui.com/support/warranty/ 
    esppecially on conditions at which the company has no control of. *Items found to be defective can be exchanged and return within seven (7) days from purchase. Normal RMA procedures
    shall apply to items beyond the period of (7) days.  
  </p>
  <div style="border:solid 1px #000;padding-left:10px; text-align:center;font-size:12px">
    <p>REFUND POLICY can be imposed if item is FOUND to be defective and is returned/processed within (7) days from the date of purchase and is returned with all accessories and manuals, and is in very good condition.
  </p>
  </div>
</div>
<style>
    body {
        font-family: sans-serif, Arial;
        font-size: 13px;
    } 
    .container {
        max-width: 680px;
        margin: 0 auto;
    } 
    .logotype {
        background: #000;
        color: #fff;
        width: 75px;
        height: 75px;
        line-height: 75px;
        text-align: center;
        font-size: 11px;
    } 
    .column-title {
        background: #333;
        text-transform: uppercase;
        padding: 15px 5px 15px 15px;
        font-size: 11px
    }

    .column-detail {
        border-top: 1px solid #333;
        border-bottom: 1px solid #333;
    }

    .column-header { 
        text-transform: uppercase;
        padding: 15px;
        font-size: 14px;
        border:solid 1px #333;
        font-weight:bold
    }

    .row {
        padding: 7px 14px;
        border-left: 1px solid #333;
        border-right: 1px solid #333;
        border-bottom: 1px solid #333;
        font-size:13px
    } 
    .alert {
        background: #ffd9e8;
        padding: 20px;
        margin: 20px 0;
        line-height: 22px;
        color: #333
    }

    .socialmedia {
        background: #eee;
        padding: 20px;
        display: inline-block
    }
</style>
<!-- container -->
</body>
</html>