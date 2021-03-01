<!doctype html>
<html class="no-js" lang="zxx">
<head>
       <title>CYGEN RESTAURANT</title>
        <meta charset="utf-8">
        <meta name="theme-color" content="#3076b9" />
       <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
          <link rel='shortcut icon' href='<?php echo base_url() ?>assets/images/fav.jpg' />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css"><head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
         <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/animate.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/owl.theme.default.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/icon-font.min.css">
      <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <script>
                        $(".search-icon-click").click(function(){
                alert();
  $(".search-div").addClass("rightclass");
});
                    $(".close-search").click(function(){
  $(".search-div").removeClass("rightclass");
});
            
        </script>
        <style>
            .heading-inner-page-sub{
     color: #fff !important;   
}
.mapi{
   font-size: 18px;
    color: #fff;
    padding-right: 5px; 
}
.otp-text{
        font-weight: 600;
    color: #000;
    text-align: center;
    margin-top: 10px;
    display: block;
}
.header-pickup {
    position: absolute;
    left: 50%;
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    transform: translateX(-50%);
    font-size: 16px;
    z-index: 9;
    font-weight: 600;
    color: #fff;
    top: 30px;
}
  @media only screen and (max-device-width: 760px) and (min-device-width: 320px)
  {
.navbar-brand img {
    top: 4px;
    height: 80px;
    position: absolute;
    left: 10px;
}

.navbar-nav .nav-link {
    color: #000;
    font-weight: 500;
    font-size: 0.95rem;
}
.navbar-fixed-header .navbar-brand img {
 top: 2px;
    height: 70px;
    left: 5px;
    position: absolute;
}
.navbar-header {
padding: 1rem;
    position: fixed;
    top: 0;
       background: transparent;
}
.navbar-bg{
    background:#fff;
}
.navbar-toggler {

    margin-right: 0;
}
.navbar-header.navbar-fixed-header {
padding: 1rem;
    background: #fff;
}
.navbar-fixed-header .navbar-toggler {

    margin-right: 0rem;
}
}
        </style>
        </head>
        <body>
        <div id="loader">
            <div class="loading-inside">
                            <div class="loading-div">
                <img src="assets/images/logo.png" class="img-fluid gray loader-img" />
                <h4 class="loader-text">Cygen contactless ordering Demo....</h4>

            </div>
      
            </div>
        </div>
         <?php
    if($this->session->userdata('select_order_type')!=""){
    if($this->session->userdata('select_order_type')==1){
        $ordertypeText="Take Away";
    }else if($this->session->userdata('select_order_type')==2){
        $ordertypeText="Home delivery";
    }else if($this->session->userdata('select_order_type')==3){
        $ordertypeText="Table Top Ordering";
    }else{

    }
    }else{
        $ordertypeText="Take Away";
        $this->session->set_userdata('select_order_type','1');
    }
    ?>
    <!--     <li class="nav-item none-small">  <a href="#" class="search-icon-click nav-link header-search">
                                        <i class="fa fa-search"></i>
                                    </a></li>-->
       <nav class="navbar navbar-expand-md navbar-header">
                <div class="container">
                    <a class="navbar-brand" href="<?php echo base_url(); ?>Home">
                        <img src="assets/images/logo.png" class="img-fluid" />
                    </a>
                    <span class="d-block d-md-none header-pickup">
                            <?php
                              if($this->session->userdata('select_order_type')==3){
                              ?>
                            <a class="" href="<?php echo base_url(); ?>productListpage" class=" pickup-online" ><i class="fa fa-shopping-bag mapi" aria-hidden="true"></i> <span class="deliveryAddrs_table"><?php echo $ordertypeText ?></a>
                              <?php
                              }else{
                              ?>
                              <a class=" "   id="deliveryAddrs2" ><i class="fa fa-shopping-bag mapi" aria-hidden="true"></i> <span class="deliveryAddrs" ><?php echo $ordertypeText ?></span></a></li>
                              <?php
                              }
                              ?>
                              
                    </span>
                   
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <i class="fa fa-navicon" style="color:#fff; font-size:28px;"></i></span>
                    </button>
                    <div class="collapse navbar-collapse navbar-bg" id="navbarCollapse">
                        <ul class="navbar-nav ml-auto">
                            
                              <?php
                              if($this->session->userdata('select_order_type')==3){
                              ?>
                             <li class="nav-item none-small"><a class="nav-link" href="<?php echo base_url(); ?>productListpage" class="nav-link pickup-online" ><i class="fa fa-shopping-bag mapi" aria-hidden="true"></i> <span style="color:#f7a201;font-weight:bold;cursor:pointer class="deliveryAddrs_table"><?php echo $ordertypeText ?></a></li>
                              <?php
                              }else{
                              ?>
                               <li  class="nav-item none-small "><a class="nav-link "   id="deliveryAddrs2" ><i class="fa fa-shopping-bag mapi" aria-hidden="true"></i> </span><span class="deliveryAddrs" style="color:#f7a201;font-weight:bold;cursor:pointer"><?php echo $ordertypeText ?></a></li>
                              <?php
                              }
                              ?>
                              
                              
                              
                              
                              
                              
                              
                             
                            <li class="nav-item">
                                 <a class="nav-link" href="<?php echo base_url(); ?>Aboutus">About Us <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?>#contactUs">Contact Us </a>
                            </li>
                             

                            <li class="nav-item position-relative none-small ">
                                    <?php 
                                    if($this->session->userdata('CART_TEMP_RANDOM') == "") {
                                    $this->session->set_userdata('CART_TEMP_RANDOM',rand(10, 10).time());
                                    }
                                    if($this->session->userdata('user_login_session_id') == "") {
                                    $user_id = 0;
                                    } else {
                                    $user_id = $this->session->userdata('user_login_session_id');
                                    }
                                    
                                    $session_cart_id = $this->session->userdata('CART_TEMP_RANDOM');
                                    
                                    $CI = & get_instance();
                                    if($this->session->userdata('user_login_session_id')!='') {
                                    $user_session_id = $this->session->userdata('user_login_session_id');
                                    $cartItems1 = "SELECT * FROM grocery_cart WHERE (user_id = '$user_session_id' OR session_cart_id='$session_cart_id') AND product_quantity!='0'";
                                    $cartItems =$CI->db->query($cartItems1);
                                    } else {
                                    $cartItems1 = "SELECT * FROM grocery_cart WHERE  product_quantity!='0' AND session_cart_id='$session_cart_id' ";
                                    $cartItems =$CI->db->query($cartItems1);
                                    }
                                    $cart_count = $cartItems->num_rows();
                                    $productlist=$cartItems->result_array();
                                    ?> 
                                <span class="nav-link cart-link " ><span class="lnr lnr-cart popup"></span><span class="cart-count item-count header_cart"><?php echo $cart_count; ?></span></span>
                                <div class="cart-list-pop-up">
                                   
                                   
                                  <div class="cart_ajax_val">
                                     
	    	    <div class="min-cart-sidebar-top">
                      
        <div class="mini-header-top">
          <h5 >
              My Cart <span class="text-success">(<?php echo $cart_count; ?> item)</span> <a  class="float-right close-cart" href="javascript:void(0)" ><i class="fa fa-times-circle" aria-hidden="true"></i>
              </a>
          </h5>
        </div>
        <?php if($cart_count > 0) { ?>
        <div class="min-cart-sidebar-body-top">
          <?php 
          $cartTotal = 0;
           $addonaall=0;
          foreach ($productlist as $getCartItems ) { 
          $cartTotal += $getCartItems['product_price']*$getCartItems['product_quantity'];
          $getWeight = $getCartItems['product_weight_type'];
          $item_ids=$getCartItems['product_id'];
          $sql_addon_query=$CI->db->query("select * from db_cart_addon where item_id='$item_ids' AND session_cart_id='$session_cart_id'");
          ?>
          <div class="cart-list-product">
            <div class="row">
               <div class="col-5 col-sm-5">
                   <h6 class="show-ellipsis"><?php echo wordwrap($getCartItems['product_name'],105,"<br>\n"); ?></h6>
                   <p><strong><?php echo $getWeight; ?>@<?php echo $getCartItems['product_price']; ?></strong> No tax</p>
                   
               </div>        
                <div class="col-3 col-sm-3">
                    <div class="row">
                    <div class='col-md-1 col-2'>
                    <a class="cart_inc" style="cursor:pointer;font-size:18px;" onclick="remove_cart_item1(<?php echo $getCartItems['id']; ?>,<?php echo $getCartItems['product_id']; ?>)"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                    
                    </div>
                    <div class='col-md-1 col-2'>
                    <span style="font-size:15px;"><?php echo $getCartItems['product_quantity']; ?></span>
                    </div>
                    <div class='col-md-1 col-2'>
                    
                    <a class="cart_dec" style="cursor:pointer;font-size:18px;" onclick="add_cart_item1(<?php echo $getCartItems['id']; ?>,<?php echo $getCartItems['product_id']; ?>)"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                    </div>
                    </div> 
                </div>  
                <div class="col-2 col-sm-2">
                    <p><strong>$<?php echo number_format(($getCartItems['product_quantity']*$getCartItems['product_price']),2); ?></strong></p>
                </div>
                <div class="col-2 col-sm-2">
                   <a class="remove-cart" style="cursor:pointer;" class="delete" onclick="deleteCartItem(<?php echo $getCartItems['id']; ?>,<?php echo $getCartItems['product_id']; ?>);" ><i class="fa fa-trash" ></i></a>
                </div>        
             </div>   
            <?php
                 
                   if($sql_addon_query->num_rows() > 0){
            ?>
                  
                      <?php
                      $sql_addon=$sql_addon_query->result_array();
                      foreach($sql_addon as $addon_row){
                          $addonaall=$addonaall+$addon_row['total_price'];
                          ?>
                           <div class="row">
                          
                          <div class="col-md-6 col-sm-6"><p></span><?php echo $addon_row['addon_name']; ?><p></div>
                          <div class="col-md-6 col-sm-6"><p><?php echo $addon_row['total_price']; ?></p></div>
                         
                           </div>
                          <?php
                      }
                      
                      ?>
                  
                   <?php
                   }
                   ?>
          </div>
          <?php } ?>
        </div>
        <div class="min-cart-sidebar-footer-top total">
          <div class="cart-store-details">
                <?php
                $select_order_type = $this->session->userdata('select_order_type');
                // $getSiteSettings1 = getAllDataWhere('grocery_site_settings','id','1'); 
                // $getSiteSettingsData1 = $getSiteSettings1->fetch_assoc();
                // $getAllPaymentsSettings = getIndividualDetails('grocery_payments_settings','id','1');
                // $service_tax += ($getSiteSettingsData1['service_tax']/100)*$cartTotal;
                // if($getAllPaymentsSettings['delivery'] == 1 && $cartTotal < 100 && $select_order_type==2)  {
                //     $delivery_charges = 20;
                // } 
                // else if($getAllPaymentsSettings['delivery'] == 1 && $cartTotal < 100  && $cartTotal > 99 && $select_order_type==2) {
                //     $delivery_charges = 20;
                // } 
                // else {
                //     $delivery_charges = 0;
                // }
              ?>
            <p>Sub Total  <strong class="float-right">$<?php echo number_format($cartTotal+$addonaall,2) ;?></strong></p>
            
            <h6>Grand Total <strong class="float-right text-danger">$<?php echo number_format($cartTotal+$addonaall,2);?></strong></h6>
          </div>
          <?php if($this->session->userdata('user_login_session_id')=="") { ?>
            <a style="width:100%" href="javascript:void(0)" login-id="1" class="loginbtn"><button class="btn btn-secondary  btn-block text-left" type="button"><span class="float-left"><i class="mdi mdi-cart-outline"></i> View Cart & Checkout </span><span class="float-right"><strong>$<?php echo number_format($cartTotal+$addonaall,2);?></strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
          <?php } else { ?>
            <a  style="width:100%"  href="<?php echo base_url(); ?>checkout"><button class="btn btn-secondary  btn-block text-left" type="button"><span class="float-left"><i class="mdi mdi-cart-outline"></i> View Cart & Checkout </span>&nbsp;&nbsp;<span class="float-right"><strong>$<?php echo number_format($cartTotal+$addonaall,2);?></strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
          <?php } ?>
        </div>
        <?php } else { ?>
        <div class="no-cart-items">
            <h3 style="text-align:center">Sorry..!! No Items Found.</h3>
            <p style="text-align:center;margin:15px">Please click on the Continue Shopping button below for items</p>
            <center><a href="<?php echo base_url();?>productListpage"><button type="submit" class="btn btn-secondary" style="background-color:#FE6003">Continue Shopping</button></a></center>
        </div>
        <?php } ?>
        </div>  
                                                    
                                                    
                                                </div>
                                </div>
                            </li>
                            
                       
                            
                            
                            
                            <li class="nav-item ">
                                <?php if($this->session->userdata('user_login_session_id') == "") { ?>
                                <a class="nav-link cart-link mbpl-0" href="javascript:void(0)" data-target="#bd-example-modal" data-toggle="modal"><span class="lnr lnr-user"></span>Login/Register</a>
                                 <?php } else { ?>
                                 <a class="nav-link cart-link mbpl-0" href="<?php echo base_url(); ?>Userdashboard"><span class="lnr lnr-user"></span>My Account</a>
                            <?php } ?>
                            </li>
     <li class="nav-item none-small home-hide">  <a href="#" class="search-icon-click nav-link header-search">
                                        <i class="fa fa-search"></i>
                                    </a></li>
                        </ul>

                    </div>
                </div>
            </nav>