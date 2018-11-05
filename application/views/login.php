<style type="text/css">
	@import "bourbon";
 
.wrapper {	
	margin-top: 80px;
  margin-bottom: 80px;
}

.form-signin {
  max-width: 400px;
  padding: 15px 35px 45px;
  margin: 0 auto;
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
      <legend class=" text-center">Member login<br></legend>
      <br>
      <div class="input-group form-group">
		<span class="input-group-addon"><i class="fa fa-user " aria-hidden="true"></i></span>
		<input id="username" type="text" class="form-control input-md" name="username" placeholder="Username">
	</div>
	<div class="input-group form-group">
		<span class="input-group-addon"><i class="fa fa-key " aria-hidden="true"></i></span>
		<input id="password" type="password" class="form-control input-md" name="password" placeholder="Password">
	</div>      
     
     <div class="form-group">
     	 <button class="btn btn-md btn-primary btn-block" type="submit">Login</button>  
     </div> 
     <p class="text-center" style="color: #777">POS Sales and Inventory Management System<br> &copy; 2018 All Rights Reserved</p>
    <?php echo form_close() ?>
  </div>
<!-- <div style="min-height: 525px;">
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4" style="padding-top: 150px;">

			

				<div class="page-header text-center">
					<h4>Member Login</h4>
				</div>
				<div class="input-group form-group">
					<span class="input-group-addon"><i class="fa fa-user " aria-hidden="true"></i></span>
					<input id="username" type="text" class="form-control input-lg" name="username" placeholder="Username">
				</div>
				<div class="input-group form-group">
					<span class="input-group-addon"><i class="fa fa-key " aria-hidden="true"></i></span>
					<input id="password" type="password" class="form-control input-lg" name="password" placeholder="Password">
				</div>
				<div class="form-group">
					<input type="submit" name="login" class="btn btn-primary input-lg form-control" value="Login">
				</div>
				
			</div>
			
		</div>
	</div>	
</div> -->

