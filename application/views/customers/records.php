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

      .widget {
        margin-bottom: 20px;

      }

      .widget b {
        display: block;
        border-bottom: solid 1px #ddd;
        margin-bottom:5px;

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
    <h4>Credit Records</h4>
    <br/>
     

    <form class="form-inline no-print" autocomplete="off">
        <div class="form-group">
            <label>Filter Date: &nbsp;</label> 
        </div> 
        <div class="form-group">
            <select class="form-control" style="max-width: 200px;" id="filter-date">
              <option value="0" <?php  echo $past_days == 90 ? "selected" : "" ?> >Past 3 Months</option>
              <option value="1" <?php  echo $past_days == 180 ? "selected" : "" ?>>Past 6 Months</option>
              <option value="2" <?php  echo $past_days == 365 ? "selected" : "" ?>>Past 12 Months</option> 
            </select>
        </div>
        &nbsp;
        <div class="form-group">
          <button type="button" id="printPageButton" onClick="printDiv()"  class="btn btn-primary">
      PRINT ME!
    </button>
        </div>
    </form>
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

                <div class="widget">
                  <b>Date:</b>
                  <?php echo date('Y-m-d') ?>
                </div>
            
                <div class="widget">
                  <b>Customer:</b>
                  <?php echo $customer->name ?>
                </div>

                <div class="widget">
                  <b>Records:</b>
                  <?php 
                    if ( $past_days == 90) {

                      echo "Past 3 Months";
                    }else if ( $past_days == 180) {

                      echo "Past 6 months";
                    }else if ( $past_days == 365) {

                      echo "Past 1 Year";
                    }
                   ?>
                </div> 
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
                            <?php 
                              $sub = $credit->total - $credit->paid;  
                              $total += $sub;
                            ?>
                            <tr>
                                <td><?php echo $credit->transaction_number ?></td>
                                <td><?php echo date('Y-m-d', strtotime($credit->date)) ?></td>
                                <td><?php echo date('Y-m-d', strtotime($credit->due_date)) ?></td> 
                                <td><?php echo currency() . number_format($credit->total,2) ?></td> 
                                <td><?php echo currency() . number_format( $sub ,2) ?></td> 
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
      <div class="page-footer-space">
        <div class="row">
          <div class="col-md-4">
            &nbsp;
          </div>
          <div class="col-md-8">
            <table width="100%" class="table">
              <tr>
                <th>Subtotal</th>
                <td class="text-right"><?php echo currency() . number_format($total, 2) ?></td>
              </tr>
 

              <tr>
                <th>Total Due</th>
                <td class="text-right"><?php echo currency() . number_format($total, 2) ?></td>
              </tr>

            </table>
          </div>
        </div>
      </div>
  </td>
</tr>
</tfoot>

</table>

</body>
<script type="text/javascript" src="<?php echo base_url('assets/jquery.js') ?>"></script>
<script src="<?php echo base_url('assets/js/print.js') ?>"></script>

<script type="text/javascript">
      
      $(document).ready(function() {

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
        });


        console.log(window.location.href);
        $("#filter-date").change(function(e) {

          window.location.href = "<?php echo $url ?>" + '?q=' + $(this).val();
        })
      })
</script>

</html>