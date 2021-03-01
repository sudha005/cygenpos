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
	<div id="myModalCart" class="modal fade" role="dialog">
  <div class="modal-dialog m-0">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body " style="padding:0px">
            <ul class="minicart-body mb-0">
                                            <li>
                                                <div class="cart_ajax_val">
                                     
	    	    <div class="min-cart-sidebar-top">
                      
        <div class="mini-header-top">
          <h5 >
              My Cart <span class="text-success">(<?php echo $cart_count; ?> item)</span> <a data-dismiss="modal"  style="margin-right: 13px; "class="float-right" href="javascript:void(0)" ><i class="fa fa-times-circle" aria-hidden="true"></i>
              </a>
          </h5>
        </div>
        <?php if($cart_count > 0) { ?>
        <div class="min-cart-sidebar-body-top">
          <?php 
          $addonaall = 0;
          $cartTotal = 0;
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
                <div class="col-3 col-sm-3 p-0">
                    <div class="row">
                    <div class='col-md-1 col-2'>
                    <a class="cart_inc" style="cursor:pointer;font-size:18px;" onclick="remove_cart_item1(<?php echo $getCartItems['id']; ?>,<?php echo $getCartItems['product_id']; ?>)"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                    
                    </div>
                    <div class='col-sm-1 col-2 p-0 '>
                    <span class="text-center" style="font-size:18px;margin-left:10px"><?php echo $getCartItems['product_quantity']; ?></span>
                    </div>
                    <div class='col-sm-1 col-1 '>
                    
                    <a class="cart_dec" style="cursor:pointer;font-size:18px;" onclick="add_cart_item1(<?php echo $getCartItems['id']; ?>,<?php echo $getCartItems['product_id']; ?>)"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                    </div>
                    </div> 
                </div>  
                <div class="col-2 col-sm-2 p-0">
                    <p><strong>$<?php echo number_format(($getCartItems['product_quantity']*$getCartItems['product_price']),2); ?></strong></p>
                </div>
                <div class="col-2 col-sm-2 pr-0 text-center">
                   <a class="remove-cart" style="cursor:pointer;font-size:22px;" class="delete" onclick="deleteCartItem(<?php echo $getCartItems['id']; ?>,<?php echo $getCartItems['product_id']; ?>);" ><i class="fa fa-trash" ></i></a>
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
            <a style="width:100%" href="javascript:void(0)" login-id="1" class="loginbtn"><button style="height:55px;" class="btn btn-secondary  btn-block text-left" type="button"><span class="float-left"><i class="mdi mdi-cart-outline"></i>  Checkout </span><span class="float-right"><strong>$<?php echo number_format($cartTotal+$addonaall,2);?></strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
          <?php } else { ?>
            <a  style="width:100%"  href="<?php echo base_url(); ?>checkout"><button style="height:55px;" class="btn btn-secondary  btn-block text-left" type="button"><span class="float-left" style="font-size:20;font-weight:bold"><i class="mdi mdi-cart-outline"></i>  Checkout </span>&nbsp;&nbsp;<span style="font-size:20;font-weight:bold" class="float-right"><strong>$<?php echo number_format($cartTotal+$addonaall,2);?></strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
          <?php } ?>
        </div>
        <?php } else { ?>
        <div class="no-cart-items">
            <h3 style="text-align:center">Sorry..!! No Items Found.</h3>
            <p style="text-align:center;margin:15px">Please click on the Continue Shopping button below for items</p>
            <center><a href="<?php echo base_url();?>productListpage"><button type="submit" class="btn btn-secondary home-hide" style="background-color:#FE6003">Continue Shopping</button></a></center>
        </div>
        <?php } ?>
        </div>  
                                                    
                                                    
                                                </div>
                                            </li>
                                        </ul>
      </div>
     
    </div>

  </div>
</div>
      <div id="myModalMenu" class="modal fade" role="dialog">
  <div class="modal-dialog ">  
<div class="modal-content bg-tra">
      <div class="modal-header menu-shop-title default-modal-header border-0">
    
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body p-0 bg-fff">
          
          <div class="umino-sidebar-catagories_area">
                         
                            <div class="umino-sidebar_categories category-module ">
                                <div class="umino-categories_title">
                                    <h5>CATEGORIES</h5>
                                </div>
                                <div class="sidebar-categories_menu">
                                    <ul class="mobile-cat-filters">
                                        <?php
                                        foreach($category_menu as $category_menu_row ){
                                        ?>
                                        <li class="dropdown-submenu">
                                            <a href="javascript:void(0)" class="spicy_cat" catId="<?php echo $category_menu_row['id']; ?>"><?php echo $category_menu_row['category_name']; ?></a>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                          
                            
                           
                            
                        </div>






      </div>
     
    </div>
    </div>
    </div>
      
       <div class="floatingDiv d-block d-md-none">
    
                    <div class="mobile-footer d-block d-md-none">
                        
            <?php
            
                $productpage=$this->router->fetch_class();
            ?>
                        
            <ul class="row m-0 no-gutters">
                <?php
                if($productpage==='productListpage'){
                ?>
                <li class="col">
                   <a  class="filterIcon-menu">  <span class="lnr lnr-menu"></span></a>
                    <p>categories</p>
                </li> 
                <?php
                }else{
                ?>
                 <li class="col">
                    <?php if($this->session->userdata('user_login_session_id') == "") { ?>
                      <span class="lnr lnr-user" data-target="#bd-example-modal" data-toggle="modal"></span>
<p data-target="#bd-example-modal" data-toggle="modal"> Login</a>
<?php } else { ?>
<span class="lnr lnr-user"></span>
<a style='color:#fff'  href="<?php echo base_url() ?>Userdashboard"> My Account</a>
<?php } ?>
                </li>
                <?php
                }
                ?>
                        <li class="col">
                 <a href="<?php echo base_url() ?>ProductListpage" class=""> <span class="lnr lnr-store"></span>
                    <p>Shop</p>
                     </a>
                </li>
                <li class="col">
                 <a href="#" class="" data-toggle="modal" data-target="#searchModal"> <span class="lnr lnr-magnifier"></span>
                    <p>Search</p>
                     </a>
                </li> 
        
                <li class="col">
                       <a  class="filterIcon-cart">   <span class="lnr lnr-cart"></span></a>
                    <p>cart </p>(<span class="cart-count_footer item-count header_cart"><?php echo $cart_count; ?></span>)
                </li> 
            </ul>
           
        </div>
<!--    <div class="row align-items-center m-0">
      <div class="col-md-6 col-sm-6 col-xs-6    col-6">
        <a  class="filterIcon-menu">&nbsp;  <i class="fa fa-bars" aria-hidden="true"></i>
        Category
        </a>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6   col-6 text-right">
      
      
      <a  class="filterIcon-cart" style="color:#fff">  <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart (<span style="color:#fff" class="header_cart"><?php echo $cart_count; ?></span> item)</a>
      
    
   
     
      </div>
    </div>-->
  </div>
  <?php
  //$orType=$this->session->userdata('select_order_type')!=""?$this->session->userdata('select_order_type'):'';
  $orType=$this->session->userdata('select_order_type')!=""?$this->session->userdata('select_order_type'):'1';
  ?>
  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
   <input type="hidden"  id="select_order_type" value="<?php echo $orType ; ?>">
    </div>

<div id="myModalselect_delivery" class="modal fade" role="dialog">
       
  <div class="modal-dialog modal-lg modal-dialog-centered">
 
    <!-- Modal content-->
    <div class="modal-content" style="width:100%;background:none;border:none">
     
      <div class="modal-body p-0">
          
       <div 
	<div class="container p-0">
		
		<div class="row">
			<div class="col-xs-12 col-12 ">
			
				<div class="tab-content " id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
					    <div class="row justify-content-center col-md-12">
                            
					        <div class="col-sm-6 col-md-4 col-6"><div class="text-center visa "><a class="orderType" id="1" href="#"><img width="50%" class="img-fluid" src="<?php echo base_url() ?>assets/images/icon/storepickup.png"><div class="order_heading menu-shop-title"> Store Pickup </div></a></div></div> 
					         <div class="col-sm-6 col-md-4  col-6"><div class="text-center visa ">
                  <a class="" id="2" href="https://www.ubereats.com/au/sydney/food-delivery/chicky-char-char/NAAzakwfSzW1JNkBnQS0fQ" target= _blank>
                  <img width="50%" class="img-fluid" src="<?php echo base_url() ?>assets/images/icon/homedelivery.png">
                  <div class="order_heading menu-shop-title"> Home delivery </div>
                  </a>
                </div>
              </div> 
			
					    </div>     
                        
					</div>
					
				
				</div>
			
			</div>
		</div>
	</div>
</div>
      </div>
     
    </div>

  </div>
</div>
   
  
  
  
  
   <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
         <script src="<?php echo base_url() ?>assets/js/owl.carousel.js"></script>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v7.0" nonce="VefdnunD"></script>
  <section class="footer">
       
            <div class="container h-100">
                <div class="row m-0  h-100 justify-content-center ">

                                              <div class="col-md-3 text-center">
                        <h4 class="footertimings">Store Timing</h4>
                        <ul class="timings-ul-chicky">
                            <li>Monday<span>7:00 AM - 8:00 PM</span></li>
                            <li>Tuesday<span>7:00 AM - 8:30 PM</span></li>
                            <li>Wednesday<span>7:00 AM - 1:30 AM</span></li>          
                            <li>Thursday - Saturday <span>7:00 AM - 11:00 PM</span></li>
                            <li>Sunday <span>7:00 AM - 8:00 PM</span></li>
                        </ul>
                    </div>
      
                               <div class="col-md-3 col-7 col-sm-7 ">
                        <div class="adrs-box">
                            <h4>Contact Us</h4>
                            <p>Shop 1/145 McEvoy St, Alexandria NSW 2015, Australia</p>
                            <p>info@chickycharchar.com.au</p>
                            <p>0293182000</p>
                        </div>
                    </div> 
        
                                                                            <div class="col-md-3 col-5 col-sm-5 ">
                                     <h4 class="footertimings">Quick Links</h4>
                        <ul class="footer-links">  
                            <li><a href="<?php echo base_url() ?>exploremenu">Explore our Menu</a></li> 
                            
                            <li><a href="<?php echo base_url() ?>ProductListpage">Order Online</a></li> 
                            <li><a href="<?php echo base_url() ?>Aboutus">About Us </a></li>  
                            <li><a href="<?php echo base_url() ?>#contactUs">Contact Us</a></li>            
                        </ul>
                    </div>
           
          
 
                             <div class="col-md-3 text-center ">
                             <?php
                              if($this->session->userdata('select_order_type')==3){
                              ?>
                        <div class="form-group ">
                            <a href="<?php echo base_url() ?>ProductListpage" class="footerbtn">Order Online</a>            
                        </div>
                        <?php
                              }
                        ?>
                        <h4 class="follow-us-on">Follow Us On</h4>
                        <div class="footer--social-icons">
                            <a href="https://www.facebook.com/chickycharchar/" target="_blank"><i class="fa fa-facebook"></i></a>
                           
                            <a href="https://instagram.com/chickycharchar?igshid=c5b6o1veymgs" target="_blank"><i class="fa fa-instagram"></i></a>
                          
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <p class="footer-p">© 2020 - All Rights with CYGEN RESTAURANT </p>
        <p class="made-with-love">
            <label class="mb-0"><i class="fa fa-heart" aria-hidden="true"></i><i class="fa fa-heart" aria-hidden="true"></i><span>Made with Love</span><i class="fa fa-heart" aria-hidden="true"></i><i class="fa fa-heart" aria-hidden="true"></i></label>
            <span>Designed &amp; Developed by <a href="https://cygen.com.au" target="_blank">Cygen.</a></span>
        </p>
        <?php 
$CI = & get_instance();
?> 
        
         <!--<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false">-->
         <!--       <div class="modal-dialog modal-dialog-centered">-->
         <!--           <div class="modal-content login-modal">-->

                        <!-- Modal Header -->
         <!--               <div class="modal-header">-->
         <!--                   <button type="button" class="close" data-dismiss="modal">&times;</button>-->
         <!--               </div>-->

                        <!-- Modal body -->
         <!--               <div class="modal-body p-0">-->
         <!--                   <ul class="nav nav-tabs signin-signup" id="myTab" role="tablist">-->
         <!--                       <li class="nav-item">-->
         <!--                           <a class="nav-link active" id="home-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="home" aria-selected="true">Sign In</a>-->
         <!--                       </li>-->
         <!--                       <li class="nav-item">-->
         <!--                           <a class="nav-link" id="profile-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="profile" aria-selected="false">Sign Up</a>-->
         <!--                       </li>-->
         <!--                   </ul>-->
         <!--                   <div class="tab-content form-group" id="myTabContent">-->
         <!--                       <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="home-tab">-->
         <!--                           <div class="row m-0 justify-content-center">-->
         <!--                               <div class="col-md-10">-->
         <!--                                   <div class="form-group col-md-12">&nbsp;</div>-->
         <!--                                   <div class="form-group">-->
         <!--                                       <label>Mobile Number</label>-->
         <!--                                       <input type="text" placeholder="Enter Mobile Number"  class="form-control" />-->
         <!--                                   </div>-->
         <!--                                   <div class="form-group">-->
         <!--                                       <label>Password</label>-->
         <!--                                       <input type="text" placeholder="Enter Mobile Number" class="form-control" />-->
         <!--                                       <div class="text-right mt-2">-->
         <!--                                           <a href="" class="frgt-pwd">Forgot Password ?</a>-->
         <!--                                       </div>-->
         <!--                                   </div>-->
         <!--                                   <div class="form-group text-center">-->
         <!--                                       <button class="login-btn"> Sign In</button>-->
         <!--                                   </div>-->
         <!--                               </div>-->
         <!--                           </div>-->
         <!--                       </div>-->
         <!--                       <div class="tab-pane fade show " id="signup" role="tabpanel" aria-labelledby="home-tab">-->
         <!--                           <div class="row m-0 justify-content-center">-->
         <!--                               <div class="col-md-10">-->
         <!--                                   <div class="form-group">-->
         <!--                                       <label>Name</label>-->
         <!--                                       <input type="text" placeholder="Enter Number"  class="form-control" />-->
         <!--                                   </div>-->
         <!--                                   <div class="form-group">-->
         <!--                                       <label>Email</label>-->
         <!--                                       <input type="text" placeholder="Enter Email"  class="form-control" />-->
         <!--                                   </div>-->
         <!--                                   <div class="form-group">-->
         <!--                                       <label>Mobile Number</label>-->
         <!--                                       <input type="text" placeholder="Enter Mobile Number"  class="form-control" />-->
         <!--                                   </div>-->
         <!--                                   <div class="form-group">-->
         <!--                                       <label>Password</label>-->
         <!--                                       <input type="password" placeholder="Enter Password" class="form-control" />-->
         <!--                                   </div>-->
         <!--                                   <div class="form-group text-center">-->
         <!--                                       <button class="login-btn"> Sign Up</button>-->
         <!--                                   </div>-->
         <!--                               </div>-->
         <!--                           </div>-->
         <!--                       </div>-->
         <!--                   </div>-->
         <!--               </div>-->

         <!--           </div>-->
         <!--       </div>-->

         <!--   </div>-->
         
             
     <div class="modal fade login-modal-main" id="bd-example-modal">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content over-flow-hidden">
               <div class="modal-body ">
                  <div class="login-modal">
                     <div class="row">
                        
                        <div class="col-lg-12 pad-left-0">
                           <button type="button" class="close close-top-right" data-dismiss="modal" aria-label="Close">
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                           <span class="sr-only">Close</span>
                           </button>
                           <form class="loginForm" method="POST" autocomplete="off">
                              <div class="login-modal-right">
                                 <!-- Tab panes -->
                                 <div class="tab-content ">
                                    <div class="tab-pane active" id="login" role="tabpanel">
                                        <h5 class="heading-design-h5">Login</h5>
                                        <span id = "return_msg"></span>
                                        <div class="row m-0 justify-content-center">
                                            <div class="col-md-8">
                                                
                                   
                                        <fieldset class="form-group">
                                            <label>Enter Email/Mobile number</label>
                                            <input type="text" class="form-control username" name="user_email" placeholder="">
                                        </fieldset>
                                        <fieldset class="form-group">
                                            <label>Enter Password</label>
                                            <input type="password"  name="user_password" class="form-control userpassword mb-2" placeholder="">
                                            <div class="text-right form-group">
                                            <a style="cursor:pointer" class="forgot_btn" title="">Forgot your password?</a>
                                            </div>
                                        </fieldset>
                                        <fieldset class="form-group text-center">
                                            <button type="button" class="userlogin  login-btn">Login</button>
                                        </fieldset>
                        
                                <!--        <div class="login-with-sites text-center" style="display:none">
                                            <p>or Login with your social profile:</p>
                                            <button class="btn-facebook login-icons btn-lg"><i class="mdi mdi-facebook"></i> Facebook</button>
                                            <button class="btn-google login-icons btn-lg"><i class="mdi mdi-google"></i> Google</button>
                                            <button class="btn-twitter login-icons btn-lg"><i class="mdi mdi-twitter"></i> Twitter</button>
                                        </div>-->
                                                 </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane active forgot_div" role="tabpanel" style="display:none">
                                        <h5 class="heading-design-h5">Lost your password</h5>
                                        <span class= "forgot_msg"></span>
                                            <div class="row m-0 justify-content-center">
                                            <div class="col-md-8">
                                        <fieldset class="form-group">
                                            <label>Enter Email</label>
                                            <input type="email" class="form-control forgot_email" name="forgot_email" placeholder="">
                                        </fieldset>
                                        <fieldset class="form-group text-center">
                                            <button type="button" class="login-btn forgotPassBtn">Submit</button>
                                        </fieldset>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="register" role="tabpanel">
                                        <h5 class="heading-design-h5">Register Now!</h5>
                                        <span class = "reg_msg"></span>
                                                <div class="row m-0 justify-content-center">
                                            <div class="col-md-8">
                                        <fieldset class="form-group">
                                            <label>Enter Name</label>
                                            <input type="text" name="user_name" class="form-control username1" placeholder="">
                                        </fieldset>
                                        <fieldset class="form-group">
                                            <span class = "reg_msg_email"></span>
                                            <label>Enter Email</label>
                                            <input type="email" name="user_email" class="form-control useremail" placeholder="" onkeyup="checkEmail();">
                                        </fieldset>
                                        <fieldset class="form-group">
                                            <span class = "reg_msg_mobile"></span>
                                            <label>Enter Mobile</label>
                                            <input type="text" name="user_mobile"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  minlength="10" maxlength="11"  class="form-control usermobile1" placeholder="" onkeyup="checkMobile();">
                                        </fieldset>
                                        <fieldset class="form-group">
                                            <span class = "reg_msg_pwd"></span>
                                            <label>Enter Password</label>
                                            <input type="password" name="user_password" id="user_password" class="form-control user_password1" placeholder="">
                                        </fieldset>
                                        <fieldset class="form-group">
                                            <span class = "reg_msg_cnfm_pwd"></span>
                                            <label>Enter Confirm Password </label>
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control user_confirm_password" placeholder="" onChange="checkPasswordMatch();">
                                            <div id="divCheckPasswordMatch" style="color:red"></div>
                                            <div id="pass-info" class="clearfix"></div>
                                        </fieldset>
                                        <fieldset class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" onclick="return false" checked class="custom-control-input" id="customCheck2" required>
                                                <label class="custom-control-label" for="customCheck2">I Agree with <a target="_blank" href="terms_conditions.php">Term and Conditions</a></label>
                                            </div>
                                        </fieldset>
                                        <fieldset class="form-group text-center">
                                            <button type="button" class="login-btn user_reg">Get Started</button>
                                        </fieldset>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane active" id="otp" role="tabpanel" style="display:none">
                                        <h5 class="heading-design-h5">OTP</h5>
                                        <span class = "otp_msg"></span>
                                             <div class="row m-0 justify-content-center">
                                            <div class="col-md-8">
                                        <fieldset class="form-group">
                                            <label>Enter OTP</label>
                                            <input type="text" name="user_otp" class="form-control userotp" placeholder="">
                                        </fieldset>
                                        <fieldset class="form-group text-center">
                                            <button type="button" class="login-btn otp_btn">Verify OTP</button>
                                        </fieldset>
                                        <p class="otp-text">OTP : 1234</p>
                                        </div>
                                        </div>
                                    </div>
                                 </div>
                         
                                 <div class="clearfix"></div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
                       <div class="clearfix"></div>
                                 <div class="text-center login-footer-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                       <li class="nav-item">
                                          <a class="nav-link active login_tab login-btn" data-toggle="tab" href="#login" role="tab"><i class="mdi mdi-lock"></i> LOGIN</a>
                                       </li>
                                       <li class="nav-item">
                                          <a class="nav-link reg_tab login-btn" data-toggle="tab" href="#register" role="tab"><i class="mdi mdi-pencil"></i> REGISTER</a>
                                       </li>
                                    </ul>
                                 </div>
            </div>
         </div>
      </div>
        <div class="transparentbg-search"></div>
              <div class="search-div">
            <div class="form-group text-right">
            <a href="#" class="close-search"><span class="lnr lnr-cross"></span></a>
            </div>

        </div>
        
          <!-- The Modal -->
  <div class="modal fade" id="searchModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content search-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
    
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body p-0">
           <form>
         <input type="text" class="form-control search-control search" placeholder="What are you looking for?"  />   
         <div id="display" class="display_search"></div>  
        </form>
        </div>
        

        
      </div>
    </div>
  </div>
      <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
            <script>
                $(window).scroll(
                    function() {
                        var scroll = $(window).scrollTop();

                        if (scroll >= 80) {
                            $(".navbar-header").addClass("navbar-fixed-header");

                        } else {
                            $(".navbar-header").removeClass("navbar-fixed-header");
                        }
                    });
                $('.owl-carousel').owlCarousel({
                    items: 1,
                    loop:true,
                    dots:false,
                    nav:false,
                    mouseDrag:true,
                    autoplay:true,
                    smartSpeed: 1000,
                    autoplayTimeout:4000,
                    autoplayHoverPause:true,
                    responsive:{
                        0:{
                            items:1
                        },
                        600:{
                            items:1
                        },
                        1000:{
                            items:1
                        }
                    }
                });

                jQuery(document).ready(function($) {
                    $(".scroll").click(function(event){     
                        event.preventDefault();
                        $('html,body').animate({scrollTop:$(this.hash).offset().top}, 500);
                    });
                });
                $(document).ready(function(){
                         $("body").on('click','.popup',function(e){
                        $(".cart-list-pop-up").show(600);
                        e.stopPropagation();
                    });
                });
                $(document).ready(function(){
                    $("body").on('click','.close-cart',function(e){
                        $("#myModalCart").modal('hide');
                        $(".cart-list-pop-up").hide(600);
                        e.stopPropagation();
                    });
                });

                window.onload = function(){ document.getElementById("loader").style.display = "none" }
            </script>
             <script>
       $(document).on('keyup','.qtyBox',function(){
            var da=$(this).val();
            var myAttr=$(this).attr("qtyId");
            $("."+myAttr).val(da);
            if(da > 20) {
                $('.quan_msg').show();
                setTimeout(function(){ $('.quan_msg').hide(); }, 3000);
                return false;
            }
        });
      
           function show_cart(ProductId,optype) {
          // $("#myModal").modal('show');
          // return false;
            var catId = $('.cat_id_'+ProductId).val();
            var subCatId = $('.sub_cat_id_'+ProductId).val();
            var productName = $('.pro_name_'+ProductId).val();
            var product = $('.get_pr_price_'+ProductId).val();
            var split = product.split(",");
            var productWeightType = split[0];
            var productPrice = split[1];
            var product_quantity = $('.product_quantity_'+ProductId).val();
           // alert(product_quantity);
            var qtyVal = product_quantity;
            var optype=optype;
            if(optype==0){
                var newqQty=parseInt(qtyVal)+1;
                product_quantity=1;
            }else{
                if(parseInt(qtyVal) > 1){
                var newqQty=parseInt(qtyVal)-1;
                }else{
                    var newqQty=0;
                }
                
            }
             
            if(product_quantity == '') {
              $('.quan_msg').show();
              setTimeout(function(){ $('.quan_msg').hide(); }, 3000);
              return false;
            }
            
            
             $.ajax({
              type:'post',
              url :$("#base_url").val()+"ProductListpage/product_modifier",
              data:{		        
                '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',productId:ProductId
              },
              success:function(responsemod) {
              //  console.log(responsemod);
               if(responsemod==1){

            
            $.ajax({
              type:'post',
              url :$("#base_url").val()+"save_cart",
              data:{		        
                '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',productId:ProductId,catId:catId,subCatId:subCatId,product_name:productName,productPrice:productPrice,productWeightType:productWeightType,product_quantity:product_quantity,optype:optype
              },
              success:function(response) {
                
                if(newqQty > 0){
              $(".buttonAdd_"+ProductId).hide();  
              $(".buttonCart_"+ProductId).show();
              $('.product_quantity_'+ProductId).val(newqQty);
         }else{
              $(".buttonAdd_"+ProductId).show();  
              $(".buttonCart_"+ProductId).hide();
              $('.product_quantity_'+ProductId).val(newqQty);
         }  
                $('#itemName').text(productName);
                $('.succ_cart_msg').show();
                setTimeout(function(){ $('.succ_cart_msg').hide(); }, 3000);
                
                $.ajax({
              type:'post',
              url :$("#base_url").val()+"header_cart_count",
              data:{
                  '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',cart_id:ProductId,
              },
              success:function(response_data) {
                //  alert(response_data);
               $('.header_cart').html(response_data);
              }
            });
            
            $.ajax({
              type:'post',
              url :$("#base_url").val()+"cartitem",
              data:{'<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>'},
              success:function(response_cart) {
                $('.cart_ajax_val').html(response_cart);
              }
            });
            
           // $(".mine-cart-box").load(" .mine-cart-box > *");
           // $(".min-cart-sidebar").load(" .min-cart-sidebar > *");
                
                
                
                
              }
            });
            
            
            
            
               }else{
                   
                   
               $(".productDetailModal").html(responsemod);     
               $("#myModalmodifier").modal('show');    
                   
                   
               }
              }
             });
            
            
            
            
            
            
            
            
        }
        
       function show_cart_option(ProductId,optype) {
            
            var catId = $('.cat_id_'+ProductId).val();
            var subCatId = $('.sub_cat_id_'+ProductId).val();
            var productName = $('.pro_name_'+ProductId).val();
            var product = $('.get_pr_price_'+ProductId).val();
            var split = product.split(",");
            var productWeightType = split[0];
            var productPrice = split[1];
            var product_quantity = $('.product_quantity_'+ProductId).val();
           // alert(product_quantity);
            var qtyVal = product_quantity;
            var optype=optype;
            if(optype==0){
                var newqQty=parseInt(qtyVal)+1;
                product_quantity=1;
            }else{
                if(parseInt(qtyVal) > 1){
                var newqQty=parseInt(qtyVal)-1;
                }else{
                    var newqQty=0;
                }
                
            }
            if(product_quantity == '') {
              $('.quan_msg').show();
              setTimeout(function(){ $('.quan_msg').hide(); }, 3000);
              return false;
            }
            $.ajax({
              type:'post',
              url :$("#base_url").val()+"save_cart",
              data:{		        
                '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',productId:ProductId,catId:catId,subCatId:subCatId,product_name:productName,productPrice:productPrice,productWeightType:productWeightType,product_quantity:product_quantity,optype:optype
              },
              success:function(response) {
                
                if(newqQty > 0){
              $(".buttonAdd_"+ProductId).hide();  
              $(".buttonCart_"+ProductId).show();
              $('.product_quantity_'+ProductId).val(newqQty);
         }else{
              $(".buttonAdd_"+ProductId).show();  
              $(".buttonCart_"+ProductId).hide();
              $('.product_quantity_'+ProductId).val(newqQty);
         }  
               // $('#itemName').text(productName);
               // $('.succ_cart_msg').show();
              //  setTimeout(function(){ $('.succ_cart_msg').hide(); }, 3000);
                
                $.ajax({
              type:'post',
              url :$("#base_url").val()+"header_cart_count",
              data:{
                  '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',cart_id:ProductId,
              },
              success:function(response_data) {
                //  alert(response_data);
               $('.header_cart').html(response_data);
              }
            });
            
            $.ajax({
              type:'post',
              url :$("#base_url").val()+"cartitem",
              data:{'<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>'},
              success:function(response_cart) {
                $('.cart_ajax_val').html(response_cart);
              }
            });
            
           // $(".mine-cart-box").load(" .mine-cart-box > *");
           // $(".min-cart-sidebar").load(" .min-cart-sidebar > *");
                
                
                
                
              }
            });
            
        }  
      function remove_cart_item1(cartId,ProductId) {
            $.ajax({
              type:'post',
              url :$("#base_url").val()+"Home/cart_page_dec",
              data:{
                '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',cart_id:cartId,  
              },
              success:function(cart_res) {
                 $('.header_cart').text(cart_res);  
                $.ajax({
                type:'post',
                url :$("#base_url").val()+"cartitem",
                data:{'<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>'},
                success:function(response_cart) {
                $('.cart_ajax_val').html(response_cart);
                }
                });
              
              //  $(".mini-cart-count").text(data);
                
                       var product_quantity = $('.product_quantity_'+ProductId).val();
                        var qtyVal = product_quantity;
                         var newqQty=parseInt(qtyVal)-1;
                              if(newqQty > 0){
                              $(".buttonAdd_"+ProductId).hide();  
                              $(".buttonCart_"+ProductId).show();
                              $('.product_quantity_'+ProductId).val(newqQty);
                         }else{
                              $(".buttonAdd_"+ProductId).show();  
                              $(".buttonCart_"+ProductId).hide();
                              $('.product_quantity_'+ProductId).val(newqQty);
                         }
              }
            });
        }
        function add_cart_item1(cartId,ProductId) {
            $.ajax({
              type:'post',
              url :$("#base_url").val()+"Home/cart_page_inc",
              data:{
                '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',cart_id:cartId,  
              },
               success:function(data) {
                    if(data == 0) {
                        $('.quan_msg').show();
                        $('.add_quan_msg').text("You cannot add more than 20 quantities of this product");
                        setTimeout(function(){ $('.quan_msg').hide(); }, 3000);
                        return false;
                    } else {
                        $('.header_cart').text(data);
                        $.ajax({
                        type:'post',
                        url :$("#base_url").val()+"cartitem",
                        data:{'<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>'},
                        success:function(response_cart) {
                        $('.cart_ajax_val').html(response_cart);
                        }
                        });
                       
                  }
                  
                        var product_quantity = $('.product_quantity_'+ProductId).val();
                        var qtyVal = product_quantity;
                         var newqQty=parseInt(qtyVal)+1;
                         $('.product_quantity_'+ProductId).val(newqQty); 
                
              }
            });
        }
        function deleteCartItem(cartId,ProductId) {
                $.ajax({
                  type:'post',
                  url :$("#base_url").val()+"Home/delete_cart_item",
                  data:{
                    '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',cartId:cartId,  
                  },
                  success:function(response) {  
                       $('.header_cart').text(response);
                     // alert(response);
                       $.ajax({
                        type:'post',
                        url :$("#base_url").val()+"cartitem",
                        data:{'<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>'},
                        success:function(response_cart) {
                        $('.cart_ajax_val').html(response_cart);
                        }
                        });
                   // $(".cart-sidebar").load(" .cart-sidebar > *");
                  //  $(".cart-body").load(" .cart-body > *");
                  //  $(".cart-count").text(response);
                   
                    $(".buttonAdd_"+ProductId).show();  
                    $(".buttonCart_"+ProductId).hide();
                    $('.product_quantity_'+ProductId).val('0');
                        
                    
                  }
                });
            
        }
        function get_price(product_id) {
            var split = product_id.split(",");
            var productId = split[2];	
            var productWeightType = split[0];				
            $.ajax({
              type:'post',
              url:'get_price.php',
              data:{
                product_id:productWeightType,       
              },
              success:function(data) {
                $('.price_'+productId).html(data);
                
              }
            });
        }
        function get_price1(product_id) {
            var split = product_id.split(",");
            var productId = split[2];	
            var productWeightType = split[0];	
            $.ajax({
              type:'post',
              url:'get_price1.php',
              data:{
                single_product_id:productWeightType,       
              },
              success:function(data) {
                $('.price_'+productId).html(data);
               
              }
            });
        }
        
        // For filters
        $('.item_filter').on('click change',function(event) {
            categories = multiple_values('categories');
            subcategories = multiple_values('subcategories');
            brand  = multiple_values('brand');
            price  = multiple_values('price');
            category_id = $(".category_id").val();
            sub_category_id = $("#sub_category_id").val();
            mastercat_id = $(".mastercat_id").val();
            searchKey = $(".searchKey").val();
            offer_id = $("#offer_id").val();
            banner_id = $("#banner_id").val();
            brand_id = $(".brand_id").val();
            tagId = $(".tagId").val();
            sorting = $("#sort").val();
            $.ajax({
              url:"filter_products.php",
              type:'post',
              data:{searchKey:searchKey,categories:categories,subcategories:subcategories,brand:brand,category_id:category_id,sub_category_id:sub_category_id,offer_id:offer_id,banner_id:banner_id,price:price,sorting:sorting,brand_id:brand_id,tagId:tagId,mastercat_id:mastercat_id},
              success:function(result){
                
                $('.all_rows').html(result);
                $("#myModalMenu").modal('hide');
              }
            });
        });
        
        function multiple_values(inputclass){
            var val = new Array();
            $("."+inputclass+":checked").each(function() {
                val.push($(this).val());
            });
        return val;
        }
        
        var loginFunction = function() {
            
            var username = $('.username').val();
            var userpassword = $('.userpassword').val();
            if(username =='') {
              $("#return_msg").css("display", "block");
              $("#return_msg").html("<span style='color:red;'>Please enter Email/Mobile number!</span>");
              return false;
            }
            if(userpassword =='') {
              $("#return_msg").css("display", "block");
              $("#return_msg").html("<span style='color:red;'>Please enter Password!</span>");
              return false;
            }
            $.ajax({
              type:"post",
              url :$("#base_url").val()+"Home/login_ajax",
              data:{
                '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',username:username,userpassword:userpassword  
              },
              success:function(result){
                if(result == 0) {
                  $("#return_msg").css("display", "block");
                  $("#return_msg").html("<span style='color:red;'>Please enter valid Credentials!</span>");
                } else if(result == 1) {
                  //alert("Login successful");
                  var header_cart =parseInt($(".header_cart").text());
                  if(header_cart !="" && header_cart > 0 ){
                     window.location.replace($("#base_url").val()+'checkout');
                  }else{
                      location.reload();
                  }
                  $("#return_msg").html("<span style='color:green;'>Login Successfully.</span>");
                  
                }
              }
            });
        }
        
        $(".loginForm").keypress(function() {
            if (event.which == 13) {
                loginFunction();
            }
        });
        $('.userlogin').click(function(){
             var username = $('.username').val();
            var userpassword = $('.userpassword').val();
            if(username =='') {
              $("#return_msg").css("display", "block");
              $("#return_msg").html("<span style='color:red;'>Please enter Email/Mobile number!</span>");
              return false;
            }
            if(userpassword =='') {
              $("#return_msg").css("display", "block");
              $("#return_msg").html("<span style='color:red;'>Please enter Password!</span>");
              return false;
            }
            $.ajax({
              type:"post",
              url :$("#base_url").val()+"Home/login_ajax",
              data:{
               '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',username:username,userpassword:userpassword 
              },
              success:function(result){
              
                if(result == 0) {
                  $("#return_msg").css("display", "block");
                  $("#return_msg").html("<span style='color:red;'>Please enter valid Credentials!</span>");
                } else if(result == 1) {
                  //alert("Login successful");
                     var header_cart =parseInt($(".header_cart").text());
                   
                  if(header_cart !="" && header_cart > 0 ){
                      window.location.replace($("#base_url").val()+'Checkout');
                  }else{
                      location.reload();
                  }
                  $("#return_msg").html("<span style='color:green;'>Login Successfully.</span>");
                  
                }
              }
            });
        });
       // $('.userlogin').click(loginFunction());
        
        $('.forgot_btn').on('click', function () {
            $(".forgot_div").show();
            $("#otp,#register,#login,.login_tab,.reg_tab").hide();
        });
        
        $('.forgotPassBtn').on('click', function () {
            var forgot_email = $('.forgot_email').val();
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if(forgot_email =='') {
              $(".forgot_msg").css("display", "block");
              $(".forgot_msg").html("<span style='color:red;'>Please enter Email!</span>");
              return false;
            }
            if(!emailReg.test(forgot_email)) {
              $(".forgot_msg").css("display", "block");
              $(".forgot_msg").html("<span style='color:red;'>Please enter valid Email Format!</span>");
              return false;
            }
            $.ajax({
              type: "POST",
              
               url :$("#base_url").val()+"Home/forgot_password",
              data:{
               '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',forgot_email:forgot_email 
              },
              success: function (result) {
                if (result > 0){
                  $(".forgot_msg").css("display", "block");
                  $(".forgot_msg").html("<span style='color:red;'>Email not Exist</span>");
                  $('.forgot_email').val('');
                } else {
                  $(".forgot_msg").html("<span style='color:green;'>Email sent Successfully.</span>");
                  setTimeout(function(){ location.reload(); }, 2000);
                }       
              }
            }); 
        });
        
        $('.login_btn,.login_tab').on('click', function () {
            $(".reg_msg,.otp_msg").hide();
            $("#return_msg,.forgot_div").hide();
            $("#login").show();
            $("#register").hide();
            $("input[type=text]").val("");
            $("input[type=email]").val("");
            $("input[type=number]").val("");
            $("input[type=password]").val("");
        });
        
        $('.reg_tab').on('click', function () {
            $(".reg_msg,.otp_msg").hide();
            $("#return_msg,.forgot_div").hide();
            $("#login").hide();
            $("#register").show();
            $("input[type=text]").val("");
            $("input[type=email]").val("");
            $("input[type=number]").val("");
            $("input[type=password]").val("");
        });
        
        $(window).scroll(function () {
            if($(document).height() <= $(window).scrollTop() + $(window).height()) {
                loadmore();
            }
        });
        
        function loadmore() {
            var val = document.getElementById("row_no").value;
            categories = multiple_values('categories');
            subcategories = multiple_values('subcategories');
            brand  = multiple_values('brand');
            price  = multiple_values('price');
            category_id = $(".category_id").val();
            sub_category_id = $("#sub_category_id").val();
            mastercat_id = $(".mastercat_id").val();
            searchKey = $(".searchKey").val();
            offer_id = $("#offer_id").val();
            banner_id = $("#banner_id").val();
            brand_id = $(".brand_id").val();
            tagId = $(".tagId").val();
            sorting = $("#sort").val();
            $.ajax({
              type: 'post',
              url: 'filter_products.php',
              data: {
              getresult:val,searchKey:searchKey,categories:categories,subcategories:subcategories,brand:brand,category_id:category_id,sub_category_id:sub_category_id,offer_id:offer_id,banner_id:banner_id,price:price,sorting:sorting,brand_id:brand_id,tagId:tagId,mastercat_id:mastercat_id
              },
              success: function (response) {
                var content = document.getElementsByClassName("all_rows");
                content[0].innerHTML = content[0].innerHTML+response;
                //$(".all_rows").append(response);
                document.getElementById("row_no").value = Number(val)+18;
              }
            });
        }
        
        $('.user_reg').on('click', function () {
            var username1 = $('.username1').val();
            var useremail = $('.useremail').val();
            var usermobile1 = $('.usermobile1').val();
            var user_password1 = $('.user_password1').val();
            var user_confirm_password = $('.user_confirm_password').val();
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var mobileReg = /^([0-9]{11})$/;
            if(username1 =='') {
              $(".reg_msg").css("display", "block");
              $(".reg_msg").html("<span style='color:red;'>Please enter Name!</span>");
              return false;
            }else {
                    $('.reg_msg').html("");
                  }  
            if(useremail =='') {
              $(".reg_msg_email").css("display", "block");
              $(".reg_msg_email").html("<span style='color:red;'>Please enter Email!</span>");
              return false;
            }
            else {
                    $('.reg_msg_email').html("");
                  } 
            if(!emailReg.test(useremail)) {
              $(".reg_msg_email").css("display", "block");
              $(".reg_msg_email").html("<span style='color:red;'>Please enter valid Email Format!</span>");
              return false;
            }
            else {
                    $('.reg_msg_email').html("");
                  } 
            if(usermobile1 =='') {
              $(".reg_msg_mobile").css("display", "block");
              $(".reg_msg_mobile").html("<span style='color:red;'>Please enter Mobile number!</span>");
              return false;
            }
            else {
                    $('.reg_msg_mobile').html("");
                  } 
          
            if(user_password1 =='') {
              $(".reg_msg_pwd").css("display", "block");
              $(".reg_msg_pwd").html("<span style='color:red;'>Please enter Password!</span>");
              return false;
            }
            else {
                    $('.reg_msg_pwd').html("");
                  } 
            if(user_confirm_password =='') {
              $(".reg_msg_cnfm_pwd").css("display", "block");
              $(".reg_msg_cnfm_pwd").html("<span style='color:red;'>Please enter Confirm Password!</span>");
              return false;
            }
            else {
                    $('.reg_msg_cnfm_pwd').html("");
                  } 
            setTimeout(function(){ $('.reg_msg').hide(); }, 3000);
            $.ajax({
              type:"post",
               url :$("#base_url").val()+"Home/mobile_otp_ajax",
              data:{
                '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',username1:username1,useremail:useremail,usermobile1:usermobile1,user_password1:user_password1
              },
              success:function(result){
                if(result == 0) {
                  $(".reg_msg").css("display", "block");
                  $(".reg_msg").html("<span style='color:red;'>Please enter valid Credentials!</span>");
                } else {
                  $(".reg_msg").html("<span style='color:green;'>OTP sent to your mobile.</span>");
                  $("#otp").show();
                  $("#register").hide();
                 
                }
              }
            });
        });
        
        $('.otp_btn').on('click', function () {
            var username1 = $('.username1').val();
            var useremail = $('.useremail').val();
            var usermobile1 = $('.usermobile1').val();
            var user_password1 = $('.user_password1').val();
            var userotp = $('.userotp').val();
            if(username1 =='') {
              $(".otp_msg").css("display", "block");
              $(".otp_msg").html("<span style='color:red;'>Please enter OTP!</span>");
              $('.userotp').val('');
              return false;
            }
            setTimeout(function(){ $('.otp_msg').hide(); }, 3000);
            $.ajax({
              type:"post",
             url :$("#base_url").val()+"Home/check_otp",
              data:{
                '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',user_name:username1,user_email:useremail,user_mobile:usermobile1,user_password:user_password1,mobile_otp:userotp 
              },
              success:function(result){
                 
                  console.log(result);
                if(result == 0) {
                  $(".otp_msg").css("display", "block");
                  $(".otp_msg").html("<span style='color:red;'>Please enter valid OTP!</span>");
                } else {
                  $(".otp_msg").css("display", "block");
                 //  $(".otp_msg").html("<span style='color:green;'>Registered Successfully.</span>");
                   var header_cart =parseInt($(".header_cart").text());
                   if(header_cart !="" && header_cart > 0 ){
                      window.location.replace($("#base_url").val()+'checkout');
                    }else{
                      setTimeout(function(){ location.reload(); }, 2000);
                    }
                 
                }
              }
            });
        });
        
        $('.search_btn').on('click', function () {
            var val = $("#searchbox").val();
            if(val == '') {
                return false;
            }
        });
        
        function checkPasswordMatch() {
            var password = $("#user_password").val();
            var confirmPassword = $("#confirm_password").val();
            if (confirmPassword != password) {
              $("#divCheckPasswordMatch").html("Passwords do not match!");
              setTimeout(function(){ $('#divCheckPasswordMatch').hide(); }, 5000);
              $("#confirm_password").val("");
              $("#user_password").val("");
            } else {
              $("#divCheckPasswordMatch").html("");
            }
        }
        
        function checkEmail() {
            var user_email = $('.useremail').val();
            if (user_email){
              $.ajax({
                type: "POST",
                 url :$("#base_url").val()+"Home/user_avail_check",
                data:{
                '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',user_email:user_email  
                },
                success: function (result) {	          	
                  if (result > 0){
                    $(".reg_msg_email").html("<span style='color:red;'>Email Already Exist</span>");
                    $('.useremail').val('');
                  } else {
                    $('.reg_msg_email').html("");
                  }     
                }
              });          
            }
        }
        function checkMobile() {
            var user_mobile = $('.usermobile1').val();
            if (user_mobile){
              $.ajax({
                type: "POST",
                url :$("#base_url").val()+"Home/user_avail_check",
                data: {
                  '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',user_mobile:user_mobile     
                },
                success: function (result) {
                  if (result > 0){
                    $(".reg_msg_mobile").html("<span style='color:red;'>Mobile Already Exist</span>");
                    $('.usermobile1').val('');
                  } else {
                    $('.reg_msg_mobile').html("");
                  }       
                }
              });          
            }
        }
        
        function resend_otp(phone) {
            $.ajax({
              type:'post',
              url:'resend_otp.php',
              data:{		        
                phone:phone
              },
              success:function(response) {
              }
            });
        }
      </script>
     
<script>

        $('body').on('click', '.add_addr_btn', function() {
			$(".addr1").show();
			$(".addr2").hide();
            $(".addr3").hide();
            $('.checkout_btn').prop('disabled',false);
            $('.first_name,.email,.Phone,.flatno,.landmark,.billing_address').attr('required',true);
        });
        
        $('body').on('click', '.back_btn', function() {
          $(".addr1").hide();
		    $(".addr2").show();
          $(".addr3").hide();
        });
        
    </script>
    <script type="text/javascript">
  $(document).ready(function(){
        $('body').on('click','.close-cart',function(){
            //$(".cart-list-pop-up").toggle('slow');
        });
        $(".orderType").click(function(){
            var orderId=$(this).attr('id');
             $(".orderType").parent().removeClass('method');
            $(this).parent().addClass('method');
         $.ajax({
            type: "POST",
            url :$("#base_url").val()+"Home/ordertype_ajax",
              data:{
                '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',orderId: orderId 
              },
            success: function (result) {
                var baseurl= $("#base_url").val();
                var baseurl2= $("#base_url").val()+"#";
                 var baseurFinal= $("#base_url").val()+"ProductListpage";
                if(orderId==1){
                    $(".deliveryAddrs").text("Store Pickup");
                    $('#myModalselect_delivery').modal("hide");
                    var pageURL = $(location).attr("href");
                    if(pageURL==baseurl || pageURL==baseurl2){
                        window.location.replace(baseurFinal);
                    }else{
                        // location.reload(true);
                         window.location.replace(baseurFinal);
                    }
                    
                }
                else if(orderId==2){
                    $(".deliveryAddrs").text("Home delivery")
                    $('#myModalselect_delivery').modal("hide");
                     var pageURL = $(location).attr("href");
                     if(pageURL==baseurl || pageURL==baseurl2){
                        window.location.replace(baseurFinal);
                    }else{
                       // location.reload(true);
                        window.location.replace(baseurFinal);
                    }
                }
                else if(orderId==3){
                  var startPos;
 
//  navigator.geolocation.getCurrentPosition(function(position) {
//   startPos = position;
//   // document.getElementById('startLat').value = startPos.coords.latitude;
//   // document.getElementById('startLon').value = startPos.coords.longitude;
//   var GEOCODING = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDSdFyqMQAugBUP5eCa2P-reL66yTf_vmA&latlng=' + position.coords.latitude + '%2C' + position.coords.longitude + '&language=en';
// $.getJSON(GEOCODING).done(function(location) {
//  var place = location.results[0];
//  console.log(JSON.stringify(place.formatted_address));
//  alert(JSON.stringify(place.formatted_address));
//  setTimeout(function () {
//   var  lat =   position.coords.latitude;
//   var  lng =  position.coords.longitude;
//   var Addrs = place.formatted_address;
//   if(lat!="" && lng!=""){
//          $.ajax({
//             type: "POST",
//             url: "current_distance_ajax.php",
//             data: {
//               user_lat: lat,user_long:lng,Addrs:Addrs
//             },
//             success: function (result) {
//                   if(result > 1){
//                     alert(result);
//                   // $('#myModalselect_delivery').modal("show");sh
//                   $('#myModalselect_delivery').modal("hide");
//                   }else{
//                     $('#myModalselect_delivery').modal("hide");
                    
//                     location.reload(true);
//                   }
//             }
//          });
//       }
//  },400);
// });
//  },
// function errorCallback(error) {
    
//             $(".locationError").show();
//              setTimeout(function(){ $(".locationError").hide(); }, 3000);
//       },
//       {
//           enableHighAccuracy: true,maximumAge:0,timeout:5000
//       }
//  );
//  navigator.geolocation.watchPosition(function(position) {
//   document.getElementById('currentLat').value = position.coords.latitude;
//   document.getElementById('currentLon').value = position.coords.longitude;
// });
                      $(".deliveryAddrs").text("Table Top Ordering");
                     $('#myModalselect_delivery').modal("hide");
                      var pageURL = $(location).attr("href");
                     if(pageURL==baseurl || pageURL==baseurl2){
                        window.location.replace(baseurFinal);
                    }else{
                      //  location.reload(true);
                      window.location.replace(baseurFinal);
                    }
                 
                   





                }
                else{
                    $(".deliveryAddrs").text("Order Now")
                }
                
             
            }
            
         });
         
       
  });
  var select_order_type = $("#select_order_type").val();
  //alert(select_order_type);
if(select_order_type!=''){
    if(select_order_type==1){
         $(".deliveryAddrs").text("Order Now");
    }else if(select_order_type==2){
      $(".deliveryAddrs").text("Home delivery");
    }else if(select_order_type==3){
      $(".deliveryAddrs").text("Table Top Ordering");
    }
    else{
         $('#myModalselect_delivery').modal("hide");
         $(".deliveryAddrs").text("Order Now");
    }
    $('#myModalselect_delivery').modal("hide");
   
}else{
 //$(".deliveryAddrs").text("Order Now")
}   
$(".deliveryAddrs").on("click", function() {
    $('#myModalselect_delivery').modal("show");
    $("#mobileMenu").removeClass('open');
  });
  });

</script>
<script>
$(document).ready(function(){
      var catid =$("#catid").val();
      if (catid === undefined || catid === null ||  catid === '') {
          $(".price_sec").hide();
      }else{
           $(".price_sec").show();
      }
      $('body').on('click', '.tglCart', function() {
      $(".cart-sidebar").load(" .cart-sidebar > *");
      $('body').toggleClass('toggled');
  });
  
  $(".cart-sidebar").on("mouseleave", function(){
      $('body').toggleClass('toggled');
  });
    $(window).scroll(function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 500) {
        $(".header-bottom").addClass("affix");
    } else {
        $(".header-bottom").removeClass("affix");
    }
});
  $("#myDIVAyers").click(function(){
      $(".box-searchmobile").toggle();
  });
  $("#filterSort").click(function(){
            $(".filterHideFooter").hide();
           if ($('.filterGrid').css('display') == 'none') {
            $(".filterGrid").show();
            $(".filterGrid").addClass('shadow');
            $(".filterHideFooter").hide();
            $(".resultDataGrid").hide();
        }else{
            $(".filterGrid").hide();
            $(".resultDataGrid").show();
        }
  });
  $("#filterSorting").click(function(){
         $(".filterHideFooter").show();
         $(".filterGrid").hide();
         $(".resultDataGrid").show();
  });
   //myModalCart   bd-example-modal
   $("body").on("click",".loginbtn",function(){
        $('#bd-example-modal').modal('show');
        $('#myModalCart').modal('hide');
     });
     $("body").on("click",".filterIcon-cart",function(){
        $('#bd-example-modal').modal('hide');
        $('#myModalCart').modal('show');
       
     });
     $("body").on("click",".filterIcon-menu",function(){
         $('#myModalMenu').modal('show');
         $('#bd-example-modal').modal('hide');
        $('#myModalCart').modal('hide');
     });
     $("body").on("click",".suburb",function(){
         $('#myModalPostcode').modal('show');
         
     });
      $("body").on("click",".product_item_grid_view",function(){
            var product_id=$(this).attr("id");
          	var formData ={'<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>','product_id':product_id }; //Array 
        $.ajax({
        url :$("#base_url").val()+"Onlineorder/item_modal",
        type: "POST",
        data:formData ,
        success: function(data)
        {
            $(".product_detail").html(data);
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          //  alert();
        }
        });
         $('#exampleModalCenter').modal('show');
         //product_detail
         
     });
     //
});

</script>
<script>
 $(document).ready(function(){
  
  $('body').on("click",'.addtocartaddon',function(){
     var addonadded=0; 
     var ProductId =''
     var pids_product=$(this).attr('pids_product');
     var et=0;
     $("input:checkbox[name=addoncheckbox]:checked").each(function(){
        
     var  addon_id   = $(this).val();
     var  ProductId = $(this).attr('product-id');
     var  addon_price = $(this).attr('addon-price');
     var addon_name = $(this).attr('addon-name');
     var note=$('#txtmod'+ProductId).val();
     var  qty=1;
       $.ajax({
              type:'post',
              url :$("#base_url").val()+"ProductListpage/addonsave_cart",
              data:{		        
                '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',productId:ProductId,addon_id:addon_id,addon_price:addon_price,addon_name:addon_name,qty:qty,note:note
              },
              success:function(response_add) {
                 
                    
                 // alert(response_add);
                
               
                  $('#myModalmodifier').modal('hide');
              }
       });    
     if(et==0){
     /// show_cartaddon(ProductId,0);
    }
     et++;
     
   // yourArray.push($(this).val());
    });
   show_cartaddon(pids_product,0);
    $('#myModalmodifier').modal('hide'); 
  });
  
  
  
     
  $(".spicy_cat").click(function(){
      $(".spicy_cat").removeClass('active_cat');
      $(this).addClass('active_cat');
       $('#myModalMenu').modal('hide');
             $(".product-lader").show();   
           var catid=$(this).attr('catId');
	      $(".allcategory_products").html('');
	    var BASE_URL = '<?php echo base_url(); ?>';
    	var formData ={'<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>','catid':catid}; //Array 
        $.ajax({
        url :$("#base_url").val()+"ProductListpage/item_list",
        type: "POST",
        data:formData ,
        success: function(data)
        {
           $(".allcategory_products").html(data);
           $(".product-lader").hide(); 
          
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          //  alert();
        }
        }); 
        });
        
        
    }); 

 function show_cartaddon(ProductId,optype) {
           
            var catId = $('.cat_id_'+ProductId).val();
            var subCatId = $('.sub_cat_id_'+ProductId).val();
            var productName = $('.pro_name_'+ProductId).val();
            var product = $('.get_pr_price_'+ProductId).val();
            var split = product.split(",");
            var productWeightType = split[0];
            var productPrice = split[1];
            var product_quantity = $('.product_quantity_'+ProductId).val();
           // alert(product_quantity);
            var qtyVal = product_quantity;
            var optype=optype;
            if(optype==0){
                var newqQty=parseInt(qtyVal)+1;
                product_quantity=1;
            }else{
                if(parseInt(qtyVal) > 1){
                var newqQty=parseInt(qtyVal)-1;
                }else{
                    var newqQty=0;
                }
                
            }
            if(product_quantity == '') {
              $('.quan_msg').show();
              setTimeout(function(){ $('.quan_msg').hide(); }, 3000);
              return false;
            }
            $.ajax({
              type:'post',
              url :$("#base_url").val()+"save_cart",
              data:{		        
                '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',productId:ProductId,catId:catId,subCatId:subCatId,product_name:productName,productPrice:productPrice,productWeightType:productWeightType,product_quantity:product_quantity,optype:optype
              },
              success:function(response) {
               
                if(newqQty > 0){
              $(".buttonAdd_"+ProductId).hide();  
              $(".buttonCart_"+ProductId).show();
              $('.product_quantity_'+ProductId).val(newqQty);
         }else{
              $(".buttonAdd_"+ProductId).show();  
              $(".buttonCart_"+ProductId).hide();
              $('.product_quantity_'+ProductId).val(newqQty);
         }  
                $('#itemName').text(productName);
                $('.succ_cart_msg').show();
                setTimeout(function(){ $('.succ_cart_msg').hide(); }, 3000);
                
                $.ajax({
              type:'post',
              url :$("#base_url").val()+"header_cart_count",
              data:{
                  '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',cart_id:ProductId,
              },
              success:function(response_data) {
                //  alert(response_data);
               $('.header_cart').html(response_data);
              }
            });
            
            $.ajax({
              type:'post',
              url :$("#base_url").val()+"cartitem",
              data:{'<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>'},
              success:function(response_cart) {
                $('.cart_ajax_val').html(response_cart);
              }
            });
            
           // $(".mine-cart-box").load(" .mine-cart-box > *");
           // $(".min-cart-sidebar").load(" .min-cart-sidebar > *");
                
                
                
                
              }
            });
            
        }
</script>
<script>
 $(".transparentbg-search").hide();
/*    $(document).mouseup(function(e){
    var container = $(".search-div");
    var container2 = $(".search-icon-click");
    // If the target of the click isn't the container
    if(!container.is(e.target) && container.has(e.target).length === 0  && !container2.is(e.target) && container2.has(e.target).length === 0){
       $(".search-div").removeClass("rightclass");
    }
});
        $("body").on('mouseleave','.search-div',function(){
            $(".search-div").removeClass("rightclass");
        }); */
        
        $(".search-icon-click").click(function(){
             $(".transparentbg-search").show();
  $(".search-div").addClass("rightclass");
});
                    $(".transparentbg-search").click(function(){
             $(".transparentbg-search").hide();
  $(".search-div").removeClass("rightclass");
});
                    $(".close-search").click(function(){
  $(".search-div").removeClass("rightclass");
});

</script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/js/jquery.watermarkinput.js"></script>
      <script type="text/javascript">
        $(document).ready(function(){
 
        $(".search").keyup(function() 
        {
        var searchbox = $(this).val();
        var searchboxLength = $(this).val().length;
        var dataString = 'searchword='+ searchbox;
        
        if(searchbox=='' && searchboxLength<=2)
        {
         $("#display").html('').hide();   
        }
        else
        {
        $.ajax({
        type: "POST",
         url :$("#base_url").val()+"Home/search",
              data:{
                '<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>',searchword:searchbox,  
              },
        cache: false,
        success: function(html)
        {
            // alert(html);
             if(searchbox!='' && searchboxLength>1)
        {
        $("#display").html(html).show();
        }else{
            $("#display").html('').hide();
        }
        }
        });
        }return false;    
        });
        
         $(".hm-form_area").mouseleave(function(){
          $("#display").html('').hide();
        });
        });
        jQuery(function($){
        	$("#searchbox").Watermark("");
        });
    
       
        
</script>

	
	<div class="navbar-top  pt-2 pb-2 succ_cart_msg cart-sucess" style="display:none;">
           
                <div class="row" style="width:100%">
                <div class="col-lg-12 col-sm-12 col-12 text-center">
                    <a href="javascript:void(0)" class="mb-0 text-white">
                     <strong><i class="fa fa-check" aria-hidden="true"></i> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="" id="itemName"></span> </strong> added to the cart  
                    </a>
                </div>
                </div>
            
        </div>
        <div class="navbar-top  pt-2 pb-2 quan_msg cart-failure" style="display:none;">
            <div class="container-fluid">
                <div class="row">
                <div class="col-lg-12 text-center">
                    <a href="javascript:void(0)" class="mb-0 ">Product Quantity must be greater than 0</a>
                </div>
                </div>
            </div>
        </div>
        
            <div class="modal fade" id="scanModal">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content scanmodal">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <img src="assets/images/scan.png" class="img-fluid modal-scan-img" alt="icon">
            <h3 class="scan-text">Scan QR to Order with our State of Art Contactless Ordering Experience.</h3>
        </div>
      </div>
    </div>
  </div>