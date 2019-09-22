<style type="text/css">
	@import "bourbon";
	
	.wrapper {	
		margin-top: 80px;
		margin-bottom: 80px;
	}

	.form-signin {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%,-50%);
		max-width: 400px;
		padding: 15px 35px 45px;
	 
		background-color: #fff;
		

		.form-signin-heading,
		.checkbox {
			margin-bottom: 30px;
		}

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

</style>
<div class="wrapper">
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
	<p class="text-center" style="color: #777">&copy; <?php echo date('Y-m-d') ?> All Rights Reserved <br> Developed by: <a href="https://algermakiputin.com">Alger Makiputin</a></p>
	<?php echo form_close() ?>
</div>
	

