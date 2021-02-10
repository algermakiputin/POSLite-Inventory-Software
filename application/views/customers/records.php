<!DOCTYPE html>
<html>

<head>
    <style type="text/css">
        .header, .header-space,
        .footer, .footer-space {
          height: 100px;
      }
      .header {
          position: fixed;
          top: 0;
      }

      body {
        padding: 0 20px;
      }
      .footer {
          position: fixed;
          bottom: 0;
      }
      @page {
          margin: 4mm
      }

      @media print {
        #printPageButton {
            display: none;
        }

        .col-md-4 {
          width: 30%;
          float: left;
        }
        .col-md-8 {
          width: 70%;
          float: left;
        }
 
    }
</style> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
</head>

<body id="main_div">

  <div class="page-header" style="text-align: center">
    Credit Records
    <br/>
    <button type="button" id="printPageButton" onClick="printDiv()" style="background: pink">
      PRINT ME!
  </button>
</div>

<div class="page-footer">
 
</div>

<table width="100%">

    <thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
      </td>
  </tr>
</thead>

<tbody>
  <tr>
    <td>
      <div class="row">
            <div class="col-md-4">
            
                10/10/2022
            </div>
         
            <div class="col-md-8">
                <table class="table table-bordered table-stripped" width="100%">
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Date</th>
                            <th>Due Date</th> 
                            <th>Amount</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php foreach ($credits as $credit): ?>
                            <tr>
                                <td><?php echo $credit->transaction_number ?></td>
                                <td><?php echo $credit->date ?></td>
                                <td><?php echo $credit->due_date ?></td> 
                                <td><?php echo currency() . number_format($credit->total,2) ?></td> 
                                <td><?php echo currency() . number_format($credit->total - $credit->paid,2) ?></td> 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
</td>
</tr>
</tbody>

<tfoot>
  <tr>
    <td>
      <!--place holder for the fixed-position footer-->
      <div class="page-footer-space"></div>
  </td>
</tr>
</tfoot>

</table>

</body>
<script type="text/javascript" src="<?php echo base_url('assets/jquery.js') ?>"></script>
<script src="<?php echo base_url('assets/js/print.js') ?>"></script>

<script type="text/javascript">
      $("#printPageButton").click(function(){
    $("body").print({
            globalStyles: true,
            mediaPrint: false,
            stylesheet: "<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>",
            noPrintSelector: ".no-print",
            iframe: true,
            append: null,
            prepend: null,
            manuallyCopyFormValues: true,
            deferred: $.Deferred(),
            timeout: 400,
            title: 'Receipt',
            doctype: '<!doctype html>'
    });
  })
</script>

</html>