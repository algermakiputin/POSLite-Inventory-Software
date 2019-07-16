<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php $this->load->view('template/header') ?>  

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><i class="fa fa-cube"></i> POS Sales & Inventory Management System</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               
                <!-- /.dropdown -->
                <?php if ($count = noStocks()->num_rows()) : ?>
                <li>
                    <a href="<?php echo base_url('out-of-stocks') ?>">Out of Stock <span style="margin-top: -10px;" class="badge badge-error"><?php echo $count ?></span></a>
                </li>
                <?php endif; ?>
                <li >
                    <a href="#" onclick="event.preventDefault(); javascript:introJs().start()">Start Demo</a>
                </li>
                <li data-step="10" data-intro="This Link takes you to POS Screen where you can process purchases.">
                    <a href="<?php echo base_url('pos') ?>">Go to POS</a>
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
        <p style="color: #333">Developed By: <a href="https://algermakiputin.com">Alger Makiputin</a></p>
    </footer>

</body>

</html>


<!-- <script type="text/javascript">
    var data = {};
    data['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>'; 
    data['test'] = 'test';
    data['test2'] = 'test3';
    $.ajax({
        type : 'POST',
        url : 'http://localhost/license/index.php/LicenseController/validateLicense',
        data : {
            id : '',
            test : ''
        },
        success : function(data) {
            alert(data);
        }

    }) 
    
</script> -->