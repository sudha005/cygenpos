<!DOCTYPE html>
<html lang="en">
<head>
       <title>Cygen Restaurant</title>
        <meta charset="utf-8">
        <meta name="theme-color" content="#3076b9" />
          <meta name="viewport" content="width=device-width, initial-scale=1">
	 <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">
         <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/animate.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/owl.theme.default.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/icon-font.min.css">

	</head>
<body>

<div class="container">
	
	<div id="tabletop" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="bg-sep"> <h3>Compliance Form - Contactless Ordering...</h3> <p class="basic-info">Please fill the form to enjoy Cygen contactless ordering...</p></div>
         <div class="bg-sep" > <img src="https://www.cygen.com.au/cloudpos/images/Cygen.png" class="img-fluid table-modal-logo" /></div>
      <div class="modal-body p-0" >
          <div class="bg-sep p-4">
             <form action="#" method="post" class="  loginForm" >
                <div class="row justify-content-center">
                    <div class="col-md-11">
                        
             
                 <div class="login-modal-right">
                             <?php
                             if($suss==1){
                             ?>
                             <div class="alert alert-success alert-dismissible fade show" id="succss22">
                                 Thank you , For Giving your information.
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                            <?php
                             }
                            ?>
                            
              <div class="form-group">
                <input type="text" class="form-control " name="cust_name" required="required"  id="cust_name" placeholder="Your Name">
              </div>
               <div class="form-group">
                <input type="text" class="form-control " maxlength="12" placeholder="Mobile" name="cust_mobile" id="cust_mobile" required="required" onkeypress="return isNumberKey(event)">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" required="required" name="cust_email" id="cust_email" placeholder="Your Email">
              </div>
             
              <div class="form-group text-center">
                  <input type='hidden' name="table_number" value="<?php echo $tablenumber; ?>" id="cust_table">
                  <input type='hidden' id="autocomplete2" name="address">
                  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                <button type="button" class="cust_btn  login-btn">submit</button>
              </div>
              </div>
                     </div>
                    
                </div>
            </form>
           </div>
      </div>
     
    </div>

  </div>
</div>
</div>
            <?php 
            $CI = & get_instance();
            ?> 
        <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
        <script>
            function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
            $(document).ready(function(){
                $("#tabletop").modal({
            backdrop: 'static',
            keyboard: false
        });
        
        
         $('body').on("click",".cust_btn",function(){
            var cust_name = $('#cust_name').val();
            var cust_email = $('#cust_email').val();
            var cust_mobile = $('#cust_mobile').val();
            var cust_table = $('#cust_table').val();
             var cust_addr = $('#autocomplete2').val();
             if(cust_name!='' && cust_email!='' && cust_mobile!='' ){
                $.ajax({
              type:'post',
              url :$("#base_url").val()+"Tabletoporder/save_information",
              data:{
                  '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',cust_name:cust_name,cust_email:cust_email,cust_mobile:cust_mobile,cust_table:cust_table,address:cust_addr
              },
              success:function(response_data) {
                 //alert(response_data);
                  window.location.replace($("#base_url").val()+'ProductListpage');
              }
            });
             }
            
          
         });
        
        
        
        
        
        
        
        
        
        
            });
        </script>
        <script>

    window.onload = function() {
	
  var startPos;
  navigator.geolocation.getCurrentPosition(function(position) {
    startPos = position;
    var GEOCODING = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDSdFyqMQAugBUP5eCa2P-reL66yTf_vmA&latlng=' + position.coords.latitude + '%2C' + position.coords.longitude + '&language=en';

$.getJSON(GEOCODING).done(function(location) {
    
    var place = location.results[0];
    console.log(JSON.stringify(place.formatted_address));
    document.getElementById('autocomplete2').value = place.formatted_address;
})

  },
  function errorCallback(error) {
           $.getJSON('https://ipinfo.io/geo', function(response) { 
            var loc = response.loc.split(',');
            
            
     var GEOCODING = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDSdFyqMQAugBUP5eCa2P-reL66yTf_vmA&latlng=' +  loc[0] + '%2C' + loc[1] + '&language=en';
    $.getJSON(GEOCODING).done(function(location) {
     var place = location.results[0];
     console.log(JSON.stringify(place.formatted_address));
     document.getElementById('autocomplete2').value = place.formatted_address;
       
      
    });        
           });    
            
       },
       {
          enableHighAccuracy: true,maximumAge:0,timeout:5000
       }
);
  

};
    </script>
    <style>

.login-btn{
    background:#2b74bb;
    border-color:#2b74bb;
}
.form-control, .widget .form-control {
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #f6f6f6;
    background-clip: padding-box;
    border: 1px solid #f6f6f6;
    border-radius: 20px;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.login-modal-right .form-control{
box-shadow: none;
    border-radius: 0px;
    background: #f5f6f7;
    border: 2px solid #f5f6f7;
    height: 44px;
    font-size: 12px;
}
.login-modal-right  label{
    margin-bottom: 0;
    font-family: 'Montserrat', sans-serif;
}
.bg-sep{
    background: #fff;
    padding: 5px;
    text-align: center;
        margin-bottom: 10px;
        border-left: 3px solid #2b74bb;
    border-right: 3px solid #2b74bb;
}
.modal-content{
     padding: 0 0.75rem;
    background: transparent;
    border: none;
    
}
    
.loginbutton{
  background:#f7a201;
  color:#fff;
  border:none;
  position:relative;
  height:40px;
  font-size:1rem;
  padding:0 2em;
  cursor:pointer;
  transition:800ms ease all;
  outline:none;
      font-family: 'Montserrat', sans-serif;
}
.loginbutton:hover{
  background:#fff;
  color:#f7a201;
}
.loginbutton:before,.loginbutton:after{
  content:'';
  position:absolute;
  top:0;
  right:0;
  height:2px;
  width:0;
  background: #f7a201;
  transition:400ms ease all;
}
.loginbutton:after{
  right:inherit;
  top:inherit;
  left:0;
  bottom:0;
}
.loginbutton:hover:before,.loginbutton:hover:after{
  width:100%;
  transition:800ms ease all;
}
.bg-sep h3{
font-size: 1.15rem;
    color: #000;
    font-weight: 600;
    margin-top: 1rem;
}
.heading-design-h5 {
    margin-bottom: 30px;
}
.heading-design-h5 {
    color: #222 !important;
    border-bottom: 1px solid #333 !important;
    font-size: 16px;
    padding-bottom: 5px;
    /* font-family: 'Montserrat', sans-serif; */
    FONT-WEIGHT: 400;
}
.table-modal-logo {
    margin: 10px auto 0px;
    display: block;
    height: 70px;
}
.basic-info {
       font-weight: 500;
    font-size: 0.85rem;
    text-align: center;
    line-height: 20px;
    margin-bottom: 0;
}

@media only screen and (min-device-width: 320px) and (max-device-width: 760px) {
    .table-modal-logo {

    height: 60px;
}
.table-modal-logo {
    margin: 10px auto 0px;
    display: block;
    height: 60px;
}
.login-modal-right .form-control {
    box-shadow: none;
    border-radius: 0px;
    background: #fff;
    border: 2px solid #f5f6f7;
    height: 40px;
    font-size: 12px;
}
.basic-info {
    text-align: center;
    font-weight: 500;
    color: #000;
    font-size: 0.9rem;
    margin-bottom: 0;
}
}
    </style>
</body>        
</html>