 
<meta name="site_live" content="<?php echo SITE_LIVE ? 1 : 0 ?>">
<meta name="csrfName" content="<?php echo $this->security->get_csrf_token_name(); ?>">
<meta name="csrfHash" content="<?php echo $this->security->get_csrf_hash(); ?>">
<meta name="api_key" content="<?php echo $this->config->config['api_key'] ?>">
<meta name="admin" content="<?php echo is_admin(); ?>">
<?php header('Access-Control-Allow-Origin: *'); ?>
<title><?php if(isset($page_name)) {echo $page_name .' - Sales And Inventory System';} else echo "Dashboard - POS SALES AND INVENTORY SYSTEM" ?></title>
<meta name="base_url" content="<?php echo base_url() ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/metisMenu/metisMenu.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables-plugins/dataTables.bootstrap.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery-confirm.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables-responsive/dataTables.responsive.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/dist/css/sb-admin-2.css") ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css") ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/morrisjs/morris.css") ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/introjs.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css')?>">
<script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery-autocomplete.css')?>">



