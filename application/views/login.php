
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Template</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <style>
    body {
     background-color: #f4f4f4;
    }
    /* .card {
      max-width: 980px;
      margin: auto;
    } */
    .logo {
      margin-bottom: 20px;
    }
    .login-card form {
      max-width: 326px;
    }
    .login-card .form-control {
      border: 1px solid #d5dae2;
    padding: 15px 25px;
    margin-bottom: 20px;
    min-height: 45px;
    font-size: 13px;
    line-height: 15;
    font-weight: normal;
    }
    #login {
      padding: 13px 20px 12px;
      background-color: #000;
      border-radius: 4px;
      font-size: 17px;
      font-weight: bold;
      line-height: 20px;
      color: #fff;
      }
      .login-card-description {
        font-size: 25px;
        color: #000;
        font-weight: normal;
        margin-bottom: 23px;
      }
      .login-card-footer-nav  {
        font-size: 14px;
        color: #919aa3;
          }

          .login-card-footer-nav a  {
            text-decoration:underline;
            color: #919aa3;
          }
          .login-card .card-body {
              padding: 80px 60px 60px;
          }
          .login-card-img  {
          border-radius: 0;
          position: absolute;
          width: 100%;
          height: 100%;
          -o-object-fit: cover;
          object-fit: cover;
        }

      @media only screen and (max-width:800px) {

        
      }

      @media only screen and (max-width:500px) {
        .col-md-5 {
          display: none;
        }
      }
  </style>
</head>
<body>
  <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-5">
            <img  src="<?php echo base_url('assets/images/login-bg.jpg') ?>" alt="login" class="login-card-img">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <div class="brand-wrapper">
                <img height="35px" src="<?php echo base_url('assets/logo/logo.png') ?>" alt="logo" class="logo">
              </div>
              <p class="login-card-description">Sign in</p>
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
              <?php echo form_open('AuthController/login_validation' )?> 
                  <div class="form-group">
                    <label for="username" class="sr-only">Username</label>
                    <input type="text" name="username" class="form-control" required placeholder="Username">
                  </div>
                  <div class="form-group mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required placeholder="***********">
                  </div>
                  <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="Login">
              <?php echo form_close(); ?>
                <nav class="login-card-footer-nav">
                  <a href="https://www.poslitesoftware.com/terms-conditions">Terms of use.</a>
                  &copy;2021 Developed By:<a href="https://algermakiputin.dev"> Alger Makiputin</a>
                </nav>
            </div>
          </div>
        </div>
      </div> 
    </div>
  </main> 
 
</body>
</html>
