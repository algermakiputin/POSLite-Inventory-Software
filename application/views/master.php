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
                <a class="navbar-brand" href="#">POSLite Inventory v2.0</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <?php if ( get_license() != "gold"): ?>
                    <li> 
                        <a href="<?php echo base_url('upgrade') ?>" class=" btn-primary">Upgrade License</a>
                    </li> 
                <?php endif; ?>
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
            <?php 
                 
                if ($renewal = renewal()[0] === "renewal_due"){
                    echo ("<div class='alert alert-info' style='margin-top:10px;margin-bottom:0'>
                        <p><i class='fa fa-info-circle'></i> <span class='text-danger'>Renewal due date: ". renewal()[1] . " </span>. To renew your subscription please message us at our facebook page: <a target='__blank' href='https://facebook.com/poslitesoftware'>https://facebook.com/poslitesoftware</a></p>
                    </div>");
                }
            ?>
            <?php $this->load->view($content) ?>

        </div>
         
        <!-- /#page-wrapper -->
       
    </div>
 
    <?php $this->load->view('template/footer') ?> 
    <footer style="text-align: right;padding: 3px 10px;font-size: 12px;">
        <p style="color: #333">Developed By: <a href="https://algermakiputin.dev" target="__blank">Alger Makiputin</a></p>
    </footer>

    
</body>
 

</html>

 