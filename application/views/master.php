<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/logo/poslite.png') ?>" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php $this->load->view('template/header') ?>  

</head>

<body>

        <div class="spinner-wrapper">
            <div class="loader"></div>
        </div>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">POSLite Inventory v1.0</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               
                <!-- /.dropdown --> 
                 <li >
                    <a href="#" onclick="event.preventDefault(); javascript:introJs().start()">Start Tour</a>
                </li>
                <li data-step="10" data-intro="This Link takes you to POS Screen where you can process purchases.">
                    <a href="<?php echo base_url('pos') ?>" title="Go to POS">Go To POS</a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        
                        <li><a href="<?php echo base_url('logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                
                <?php if (!SITE_LIVE) : ?>
                    <?php if ( $this->config->item('license') == "bronze" || $this->config->item('license') == "silver" ): ?>
                       <li>
                        <a style="padding-top: 0;padding-bottom: 0;min-height: 0" href="<?php echo base_url('upgrade'); ?>"><button class="btn btn-primary"><i class="fa fa-level-up"></i> Upgrade License</button></a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <?php $this->load->view('template/sidebar') ?>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            
            <?php $this->load->view($content) ?>

        </div>
         
        <!-- /#page-wrapper -->
       
    </div>
 
    <?php $this->load->view('template/footer') ?> 
    <footer style="text-align: right;padding: 3px 10px;font-size: 12px;">
        <p style="color: #333">Developed By: <a href="https://algermakiputin.github.io/portfolio">Alger Makiputin</a></p>
    </footer>

    
</body>

 
<script type="text/javascript">
    var no_stocks = <?= json_encode(noStocks()); ?>;
    var low_stocks = <?= json_encode(low_stocks()); ?>;

    $(document).ready(function() {

        var disable_stockout_notification = getCookie("disable_stockout_popup");
        var disable_lowstock_notification = getCookie("disable_lowstock_popup");
      
        if (Object.keys(no_stocks).length && disable_stockout_notification != "1") { 
            setTimeout(out_of_stock_popup, 10000);
        }

        if (Object.keys(low_stocks).length && disable_lowstock_notification != "1") { 
            setTimeout(low_stock_popup, 20000);
        }

        //alert(getCookie("disablepopup"));
        function set_disable_notification_cookie(name) {
            var now = new Date();
            now.setTime(now.getTime() + 1 * 3600 * 3000);
            document.cookie = name+"=1; expires=" + now.toUTCString() + "; path=/";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
              c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
              return c.substring(name.length, c.length);
            }
          }
          return "";
        }

        function out_of_stock_popup() {
            var tbody = "";
            $.each(no_stocks, function(key, value) {

                tbody += "<tr>"+
                    "<td>"+value.name+"</td>" + 
                    "<td>"+value.description+"</td>" + 
                    "<td>stock out</td>" + 
                "</tr>";
            });

            $.confirm({
                icon: 'fa fa-warning text-danger',
                title: 'Run out of stocks',
                content: "<table class='table table-bordered table-striped'><thead><tr><td>Product</td><td>Description</td><td>Out of Stocks</td></tr></thead><tbody>"+tbody+"</tbody></table>",
                columnClass: 'col-md-6 col-md-offset-3',
                type: 'red',
                buttons: {
                    ok: {
                        text: "OK",
                        btnClass: "btn-default",
                        action: function() {},
                    },

                    disable: {
                        text: "Do now show this for 3HR",
                        btnClass: "btn-danger",
                        action: function() {
                            set_disable_notification_cookie("disable_stockout_popup");
                            alert("Stock out notification will be disabled for 3 hours.")
                        }
                    }
                }
            });
        }

        function low_stock_popup() {
            var tbody = "";
            $.each(low_stocks, function(key, value) {

                tbody += "<tr>"+
                    "<td>"+value.name+"</td>" + 
                    "<td>"+value.description+"</td>" + 
                    "<td>"+value.quantity+" remaining</td>" + 
                "</tr>";
            });

            $.confirm({
                icon: 'fa fa-warning text-warning',
                title: 'Low stocks',
                content: "<table class='table table-bordered table-striped'><thead><tr><td>Product</td><td>Description</td><td>Low Stock</td></tr></thead><tbody>"+tbody+"</tbody></table>",
                columnClass: 'col-md-6 col-md-offset-3',
                type: 'orange',
                buttons: {
                    ok: {
                        text: "OK",
                        btnClass: "btn-default",
                        action: function() {},
                    },

                    disable: {
                        text: "Do now show this for 3HR",
                        btnClass: "btn-warning",
                        action: function() {
                            set_disable_notification_cookie("disable_lowstock_popup");
                            alert("Low stock notification will be disabled for 3 hours.")
                        }
                    }
                }
            });
        }
    });
</script>

</html>

 