<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php print $SITE_TITLE; ?> | Log in</title>
  <link rel='shortcut icon' href='<?php echo $theme_link; ?>images/favicon.ico' />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $theme_link; ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $theme_link; ?>dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/iCheck/square/blue.css">
<style>
    .login-box-body{
           font-family: 'Montserrat', sans-serif !important;
              background: #111418 !important;
    }
html, body {
    height: 100%;
    background:#343a40!important;
   
}
body{
    padding:90px 0;
}
    .chicky-logo{
            background: #f52f2c;
    object-fit: contain;
    padding: 5px;
    height: 90px;
    margin: 0 auto 20px;
    display: block;
    }
    .form-group {
    margin-bottom: 20px;
}
    .has-feedback .form-control {
    padding-right: 42.5px;
    background: #232a31;
    border-color: #232a31;
    font-size: 12px;
    border-radius: 0px;
    height: 40px;
      color:#dee3e4 !important  
    }
    .login-box-body{
        padding:0;
    width: 80%;
    margin: 0 auto;

    }
    .forgot-pwd{
            font-size: 12px;
    color: #305af9;
    font-weight: 500;
    }
    .login-box-body .form-control-feedback, .register-box-body .form-control-feedback {
    color: #305af9;
}
.login-btn{
     background: #305af9;
    color: #fff;
    text-transform: uppercase;
    font-weight: 500;
    border-radius: 4px;
    padding: 10px 40px;
    -webkit-box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    width: 100%;
}
.login-btn:hover{
   background: #f52f2c;
   outline:none;
    color: #fff;
}
  .forgot-pwd:hover{
            font-size: 12px;
    color: #f52f2c;
    font-weight: 500;
    }
.glad{
    text-align: center;
    font-size: 12px;
    color: #dee3e4 !important;
    font-weight: 500;
    margin-bottom: 15px;

}
.login-box {
width: 100%; 
  
}
.login-h3{
        text-align: center;
    text-transform: uppercase;
    color: #305af9;
    font-family: 'Montserrat', sans-serif !important;
    font-weight: 700;
    margin-bottom: 15px;
}
.v-flex {
display: -webkit-box;
display: -ms-flexbox;
display: flex;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
                overflow: hidden;
                width:90%;
}
.h-100
{
    height:100% !important;
}
.p-0{
    padding:0px !important;
}
.bg-new-dark{
        background: #111418;
}
.logo-cygen{
        height: 60px;
    margin: 0 auto 10px;
}
.img-text-overlay {
    position: absolute;
    height: 100%;
    background: #305af9cf;
    width: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;

    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    padding: 20px;
    z-index: 1;
    color: #fff;
    font-family: 'Montserrat', sans-serif !important;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;
}
.img-text-overlay p{
    font-size: 1.25vw;
    text-align: justify;
    font-weight: 500;
}
.d-flex{
       display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
       -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
.banner-img-login{
    height:100%;
    object-fit:cover;
}
.cygen{
        font-family: 'Montserrat', sans-serif !important;
    font-weight: 700;
    font-size: 4vw;
}
.wel-back{
    
    font-family: 'Montserrat', sans-serif !important;
    font-size: 2vw;
    margin-top: 4vh;
    margin-bottom: 4vh;

}
.label-form{
    color: #dee3e4 !important;
    font-family: 'Montserrat', sans-serif !important;
    font-weight: 500;
    font-size: 0.9vw;
    margin-bottom: 6px;
}
</style>
</head>
<body class="hold-transition login-page" style="height:100%;background-repeat: no-repeat;background: url('<?= base_url('uploads/bg/pos-background.jpeg') ?>') no-repeat center center fixed">
  <?php 
  //Find Logo Path
    $logo=$this->db->query("select logo from db_sitesettings")->row()->logo;
  ?>
  <div class="container h-100 d-flex">
      <div class="row v-flex h-100">
          <div class="col-md-7 p-0 h-100">
              <div class="position-relative h-100" >
                  <div class="img-text-overlay">
                      <h2 class="cygen">CYGEN</h2>
                      <h4 class="wel-back">Welcome back!</h4>
                      <p>The Smartest Thing To Do With Your Retail Business.Australia’s POS Solution for your path towards success.</p>
                      </div>
             <img src="<?= base_url('uploads/bg/pos-background.jpeg') ?>" class="img-responsive banner-img-login">
             </div>
               </div>
          <div class="col-md-5 p-0 bg-new-dark h-100">    

<div class="login-box d-flex">
 <!-- <div class="login-logo">
    <a href="#"><b>
      <img src="<?php echo $base_url; ?>uploads/<?= $logo;?>" width="100px" height="70px">
    </b></a>
  </div-->
  <!-- /.login-logo -->
  <div class="login-box-body">
     <img src="https://cygen.com.au/img/Cygen.png" class="img-responsive logo-cygen">
       <!--   <img src="<?php echo $base_url; ?>uploads/<?= $logo;?>" class="chicky-logo">-->
          <p class="glad">We are glad to see you again!</p>
   <!-- <h3 class="login-heading"><span>Login</span> </h3>-->
     <div class="text-danger tex-center"><?php echo $this->session->flashdata('failed'); ?></div>
	   <div class="text-success tex-center"><?php echo $this->session->flashdata('success'); ?></div>
         
    
    <form action="<?php echo $base_url; ?>login/verify" method="post">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
      <div class="form-group has-feedback">
          <label class="label-form">User Name</label>
        <input type="text" class="form-control" placeholder="Enter Username" id="username" name="username" autofocus><span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <label class="label-form">Password</label>
        <input type="password" class="form-control" placeholder="Enter Password" id="pass" name="pass">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group text-right">
           <a href="login/forgot_password" class="forgot-pwd"> Forgot Password</a>
      </div>
      <div class="row">
   <!--     <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>-->
        <!-- /.col -->
        <div class="col-xs-12 text-center form-group">
          <button type="submit" class="btn login-btn">Login</button>
        </div>
        <!-- /.col -->
      </div>
       
	  
    </form>
   
    <div class="row">
      
    </div>
  </div>
  <!-- /.login-box-body -->
 
            </div>
          
      </div>
</div>
</div>
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo $theme_link; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $theme_link; ?>bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo $theme_link; ?>plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<script type="text/javascript" >
$(function($) { // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({ data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }  }); });
</script>

</body>
</html>
