<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/logo/poslite.png') ?>" />
	<title>Login - POSLite Inventory Mangement Software</title>

	<?php $this->load->view('template/header'); ?>
</head>
<body >

<style type="text/css">

	body, html {
		height: 100%;
		width: 100%;
	} 
	.wrapper {
		padding-top: 75%;
	}
	.form-signin { 
	 	padding: 15px 35px 45px;
		background-color: #fff;  			

	 

		.checkbox {
			font-weight: normal;
		}

		.form-control {
			position: relative;
			font-size: 16px;
			height: auto;
			padding: 10px;
			@include box-sizing(border-box);

			&:focus {
				z-index: 2;
			}
		}

		input[type="text"] {
			margin-bottom: -1px;
			border-bottom-left-radius: 0;
			border-bottom-right-radius: 0;
		}

		input[type="password"] {
			margin-bottom: 20px;
			border-top-left-radius: 0;
			border-top-right-radius: 0;
		}

		.form-signin-heading {
			margin-bottom: 30px !important;
		}
	}
 

 

	 .form-signin {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		margin-left: 20px;
		width: 410px;
	}

	blockquote{
  font-size: 2.1em;
  width:80%;
  margin:50px auto;
  font-family:Open Sans;
  font-style:italic;
  color: #fff; 
  padding:1.2em 30px 1.2em 75px;
  border-left:8px solid #204d74 ;
  line-height:1.6;
  position: relative;
  /*background:#EDEDED;*/
  text-shadow: 0 0 15px rgba(0,0,0,0.2);
}

blockquote::before{
  font-family:Arial;
  content: "\201C";
  color:#333;
  font-size:4em;
  position: absolute;
  left: 10px;
  top:-10px;
}

blockquote::after{
  content: '';
}

blockquote span{
  display:block;
  color:#fff;
  font-style: normal;
  font-weight: bold;
  margin-top:1em;
  text-shadow: 0 0 15px rgba(0,0,0,0.2);
}

</style> 
 	
	<?php
	$attributes = array( 
	'class' => 'form-signin'
	);
	?>

	<?php echo form_open('AppController/start_trial',$attributes )?> 

	 
	
	 
	<h2>Start your free 14 days trial today!</h2>
	<br>
	<div class="form-group">
		<button class="btn btn-primary btn-block" type="submit" >Let's get started</button>  
	</div> 
	<?php if (SITE_LIVE): ?> 
		<div class="">
			<h4 class="text-center">Login Credentials </h4>
			<ul>
				<li><b>Username:</b> admin <b>Password:</b> admin123</li>
				<li><b>Username:</b> cashier <b>Password:</b> cashier123</li>
			</ul>
		</div> 
	 	<h5></h5>
	<?php endif; ?>
	<p class="text-center" style="color: #777">&copy; <?php echo date('Y-m-d') ?> All Rights Reserved <br> Developed by: <a href="https://algermakiputin.github.io/portfolio">Alger Makiputin</a></p>
	<?php echo form_close() ?>
  
<?php $this->load->view('template/footer'); ?>
</body>
</html>