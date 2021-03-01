<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php print $SITE_TITLE; ?> | Forgot Password</title>
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
    .login-page, .register-page {
    background: #e1e5e8;
     font-family: 'Montserrat', sans-serif !important;
}
.fwd{
    font-family: 'Montserrat', sans-serif !important;
    font-size: 1.5vw;
    font-weight: 500;
    color: #333;
        text-align: center;
}
.img-forgot{
        height: 150px;
    object-fit: contain;
    margin: 0 auto;
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
     font-family: 'Montserrat', sans-serif !important;
}
.login-btn:hover{
   background: #f52f2c;
   outline:none;
    color: #fff;
}
.itsokay{
        text-align: center;
    font-size: 0.9vw;
    color: #7f868c;
    margin-bottom: 2vh;
    margin-top: 2vh;
}
.back{
        font-weight: 500;
    font-size: 0.9vw;
    margin-top: 1vh;
}
.back a{
    font-size: 1vw;
    color:#305af9;
    font-weight:600;
}
.login-box{
        -webkit-box-shadow: 0 2px 25px 0 rgba(0, 0, 0, 0.06) !important;
    box-shadow: 0 2px 25px 0 rgba(0, 0, 0, 0.06) !important;
}
</style>
</head>
<body class="hold-transition login-page" style="height:0;">
  <?php 
  //Find Logo Path
    $logo=$this->db->query("select logo from db_sitesettings")->row()->logo;
  ?>
<div class="login-box">
<!--  <div class="login-logo">
    <a href="index.php"><b>
      <img src="<?php echo $base_url; ?>uploads/<?= $logo;?>" width="60%" height="70px">
    </b></a>
  </div>-->
  <!-- /.login-logo -->
  <div class="login-box-body">
      <img src="http://stampready.net/dashboard/editor/user_uploads/zip_uploads/2018/11/23/5aXQYeDOR6ydb2JtSG0p3uvz/zip-for-upload/images/template1-icon.png" class="img-forgot img-responsive" />
    <h3 class="fwd">Forgot Your Password?</h3>
    <p class="itsokay">It's okay, it happens! Please enter your Email.</p>
	   <div class="text-danger tex-center"><?php echo $this->session->flashdata('failed'); ?></div>
         
    
    <form action="<?php echo $base_url; ?>login/send_otp" method="post" id="password-form">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Email" id="email" name="email" autofocus><span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="row text-center">
        <!-- /.col -->
        <div class="col-md-12 form-group">
          <button type="submit" class="btn login-btn">Reset your password</button>
        </div>
        <!-- /.col -->
      </div>
       
	  
    </form>
    <div class="text-center">
    Back to <a class="back" href="../<?php $base_url;?>">Home</a>.
    </div>

  </div>
  <!-- /.login-box-body -->
  
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
