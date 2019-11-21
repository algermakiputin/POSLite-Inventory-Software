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
		max-width: 420px;
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

	.col2 {
		float: left;
		width: 50%;
		height: 100%;
		position: relative;

	}

	.col1 {
		background-image: url('https://images.pexels.com/photos/1227520/pexels-photo-1227520.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260');
		background-position: center;
		height: 100%;
		width: 40%;
		float: left;
		position: relative;
	}

	.col1 .quote-wrapper {
		position: absolute;
		top: 50%;
		transform: translate(0, -50%);
	}

	.col2 .form-signin {
		position: absolute;
		top: 50%;
		transform: translate(0, -50%);
		margin-left: 20px;
	}

	blockquote{
  font-size: 1.8em;
  width:60%;
  margin:50px auto;
  font-family:Open Sans;
  font-style:italic;
  color: #fff; 
  padding:1.2em 30px 1.2em 75px;
  border-left:8px solid #204d74 ;
  line-height:1.6;
  position: relative;
  /*background:#EDEDED;*/
}

blockquote::before{
  font-family:Arial;
  content: "\201C";
  color:#204d74;
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
}

</style>
<div class="col1">
	<div class="quote-wrapper"> 
   
		<blockquote>
  Creativity is just connecting things. When you ask creative people how they did something, they feel a little guilty because they didn't really do it, they just saw something. It seemed obvious to them after a while. That's because they were able to connect experiences they've had and synthesize new things.
  <span>Steve Jobs</span>
</blockquote>
   
	</div>
</div>
<div class="col2">
	<?php
	$attributes = array( 
	'class' => 'form-signin'
	);
	?>

	<?php echo form_open('AuthController/login_validation',$attributes )?> 

	<h2 class="text-center">Sign In</h2>
	<br>
	<?php if($this->session->flashdata('errorMessage')): ?>
	<div class="form-group">
		<?php echo ($this->session->flashdata('errorMessage'))?>
	</div>
	<?php endif; ?>
	<?php if($this->session->flashdata('successMessage')): ?>
	<div class="form-group">
		<?php echo ($this->session->flashdata('successMessage'))?>
	</div>
	<?php endif; ?>
	<div class="form-group">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-user " aria-hidden="true"></i></span>
			<input autocomplete="off" id="username" type="text" class="form-control input-md" name="username" placeholder="Username" required="required" data-parsley-errors-container="#username-error">
			<div class="clearfix"></div>

		</div>
		<span id="username-error"></span>
	</div>
	<div class="form-group">
		<div class="input-group ">
			<span class="input-group-addon"><i class="fa fa-key " aria-hidden="true"></i></span>
			<input autocomplete="off" id="password" type="password" class="form-control input-md" name="password" placeholder="Password" required="required" data-parsley-errors-container="#password-error">
		</div>      
		<span id="password-error"></span>
	</div>
	<div></div>
	
	
	<div class="form-group">
		<button class="btn btn-md btn-primary btn-block" type="submit" style="border-radius: 1em;">Login</button>  
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
</div> 
	

<?php $this->load->view('template/footer'); ?>
</body>
</html>