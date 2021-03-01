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
	    	    <div class="min-cart-sidebar-top">
                      
        <div class="mini-header-top">
          <h5 >
              My Cart <span class="text-success ">(<?php echo $cart_count; ?> item)</span> <a style="margin-right:20px;font-size:18px "  class="float-right close-cart" href="javascript:void(0)" ><i class="fa fa-times-circle" aria-hidden="true"></i>
              </a>
          </h5>
        </div>
        <?php if($cart_count > 0) { ?>
        <div class="min-cart-sidebar-body-top">
          <?php 
           $addonaall=0;
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
                <div class="col-3 col-sm-3">
                    <div class="row">
                    <div class='col-md-1 col-2'>
                    <a class="cart_inc" style="cursor:pointer;font-size:25px;" onclick="remove_cart_item1(<?php echo $getCartItems['id']; ?>,<?php echo $getCartItems['product_id']; ?>)"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                    
                    </div>
                    <div class='col-md-1 col-2'>
                    <span style="font-size:15px;"><?php echo $getCartItems['product_quantity']; ?></span>
                    </div>
                    <div class='col-md-1 col-2'>
                    
                    <a class="cart_dec" style="cursor:pointer;font-size:25px;" onclick="add_cart_item1(<?php echo $getCartItems['id']; ?>,<?php echo $getCartItems['product_id']; ?>)"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                    </div>
                    </div> 
                </div>  
                <div class="col-2 col-sm-2">
                    <p><strong>$<?php echo number_format(($getCartItems['product_quantity']*$getCartItems['product_price']),2); ?></strong></p>
                </div>
                <div class="col-2 col-sm-2">
                   <a class="remove-cart" style="cursor:pointer;font-size:25px;" class="delete" onclick="deleteCartItem(<?php echo $getCartItems['id']; ?>,<?php echo $getCartItems['product_id']; ?>);" ><i class="fa fa-trash" ></i></a>
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
          <?php if($this->session->userdata('user_login_session_id')!="") { ?>
            <a style="width:100%" href="<?php echo base_url() ?>/checkout" ><button  style="height:55px;" class="btn btn-secondary  btn-block text-left" type="button"><span class="float-left"><i class="mdi mdi-cart-outline"></i> Checkout </span><span class="float-right"><strong>$<?php echo number_format($cartTotal+$addonaall,2);?></strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
          <?php } else { ?>
             <a style="width:100%" href="javascript:void(0)" login-id="1" class="loginbtn"><button style="height:55px;"  class="btn btn-secondary  btn-block text-left" type="button"><span class="float-left"><i class="mdi mdi-cart-outline"></i> Checkout </span><span class="float-right"><strong>$<?php echo number_format($cartTotal+$addonaall,2);?></strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
          <?php } ?>
        </div>
        <?php } else { ?>
        <div class="">
            <h3 style="text-align:center">Sorry..!! No Items Found.</h3>
            <p style="text-align:center;margin:15px">Please click on the Continue Shopping button below for items</p>
            <center><a href="<?php echo base_url();?>productListpage"><button type="submit" class="btn btn-secondary" style="background-color:#FE6003">Continue Shopping</button></a></center>
        </div>
        <?php } ?>
        </div>