<?php
include_once'header.php';
?>
<style>
.card-header h5 button{
        text-transform: uppercase;
    text-decoration: none !important;
    font-weight: 600;
    color: #000 !important;
        padding: 0;
}
.accordion .card-header:after {
display:none;
}
.checkout-page.section-padding{
    padding:3rem;
}
.card-header.new-header {
    background-color: #f6f6f6;
    border-bottom: none;
    font-weight: 600;
    font-size: 1rem;
    text-transform: uppercase;
    color: #000;
}
.form-control {
    border-radius: 0px !important;
    height: 40px;
    font-size: 0.85rem !important;
}
.control-label{
    margin-bottom:0px !important;
}
.btn-secondary {
    color: #fffimportant;
    background-color: #8ec400 !important;
    border-color: #8ec400 !important;
    font-size: 0.9rem;
    border-radius: 0px;
    font-weight: 500;
    text-transform: uppercase;
}
.form-check-label {
    margin-bottom: 0;
    font-size: 13px;
    text-transform: uppercase;
    font-weight: 500;
    color: #333;
}
.qty{
        font-size: 11px;
    font-weight: 600;
    color: #000;

}
</style>
<div id="fb-root"></div>
        <section class="abt-banner p-0">
           
            <div class="container h-100">
                <div class="row m-0 h-100 justify-content-center align-items-center">
                   
                    <div class="col-md-12 text-center">
                       
                        <h2 class="heading-inner-page"> Checkout</h2>
                        
                    </div>
                </div>
            </div> 
        </section>  
        <!-- Begin Umino's Checkout Area -->
   <section class="checkout-page section-padding">
      <div class="container">
            <form method="post" action="<?php echo base_url() ?>Checkout/save_checkout">
                  <div class="row">
                        <div class="col-md-8">
                              <div class="checkout-step card-step-checkout">
                              <div class="accordion" id="accordionExample">
                                    <div class="card checkout-step-two">
                                    <div class="card-header" id="headingTwo">
                                          <h5 class="mb-0">
                                          <button class="btn btn-link " type="button" data-toggle="collapse" data-target="#collapseTw" aria-expanded="false" aria-controls="collapseTwo">
                                          <!-- <span class="number"></span>  -->
                                          <?php
                                           if($this->session->userdata('select_order_type')==2){
                                          ?>
                                            Delivery Address
                                          <?php
                                           }else{
                                                 echo "Customer Information" ;
                                           }
                                          ?>
                                          </button>
                                          </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                          <div class="card-body">
                                          <?php
                                          
                                          if($this->session->userdata('select_order_type')!=2){
                                              $uid = $this->session->userdata('user_login_session_id');
                                              $userData = getIndividualDetails('db_customers','id',$uid);
                                          ?>
                                          <div class="addr12">
                                                <form class="">
                                                      <div class="row">
                                                      <div class="col-sm-6">
                                                            <div class="form-group">
                                                            <label class="control-label">Name <span class="required text-danger">*</span></label>
                                                            <input  required="required" class="form-control border-form-control addr_input first_name" name="first_name" placeholder="Name" type="text" value="<?php echo $this->session->userdata('user_login_session_name'); ?>">
                                                            </div>
                                                      </div>
                                                      
                                                      </div>
                                                      <div class="row">
                                                      <div class="col-sm-6">
                                                            <div class="form-group">
                                                            <label class="control-label">Phone <span class="required text-danger">*</span></label>
                                                            <input required="required"  class="form-control border-form-control addr_input Phone" value="<?php echo $userData['mobile']; ?>" placeholder="Phone" type="number" minlength="10" name="mobile" maxlength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                            </div>
                                                      </div>
                                                     
                                                      </div>
                                                      <div class="row">
                                                      <div class="col-sm-6">
                                                            <div class="form-group">
                                                            <label class="control-label">Email <span class="required text-danger">*</span></label>
                                                            <input required="required"  class="form-control border-form-control addr_input " value="<?php echo $userData['email']; ?>" placeholder="Email" type="text"  name="email" >
                                                            </div>
                                                      </div>
                                                     
                                                      </div>
                                                        <?php
                                                        if($this->session->userdata('select_order_type')==1){
                                                        ?>
                                                      <div class="row">
                                                      <div class="col-sm-6">
                                                            <div class="form-group">
                                                            <label class="control-label">Date Time <span class="required text-danger">*</span></label>
                                                            <input required="required" id="datetimepicker" name="pickup_datetime" class="form-control border-form-control addr_input Phone" value="" placeholder="Date Time" type="datetime-local" >
                                                            
                                                            </div>
                                                      </div>
                                                         </div>
                                                        <?php
                                                        }
                                                        ?>
                                                     
                                                </div>
                                                <?php
                                                }
                        
                                          if($this->session->userdata('select_order_type')==2){
                                          
                                                ?>
                                                <button type="button" class="btn btn-secondary pull-left  back_btn" style="display:none">BACK</button>
                                                <div class="addr1" style="display:none">
                                                <form class="">
                                                      <div class="row">
                                                      <div class="col-sm-6">
                                                            <div class="form-group">
                                                            <label class="control-label">Name <span class="required text-danger">*</span></label>
                                                            <input class="form-control border-form-control addr_input first_name" name="first_name" placeholder="Name" type="text" value="<?php echo $this->session->userdata('user_login_session_name'); ?>">
                                                            </div>
                                                      </div>
                                                      <div class="col-sm-6">
                                                            <div class="form-group">
                                                                  <label class="control-label">Email Address <span class="required text-danger">*</span></label>
                                                                  <input class="form-control border-form-control addr_input email"  name="email" placeholder="Email Address" type="email" value="<?php echo $this->session->userdata('user_login_session_email'); ?>">
                                                            </div>
                                                      </div>
                                                      </div>
                                                      <div class="row">
                                                      <div class="col-sm-6">
                                                            <div class="form-group">
                                                            <label class="control-label">Phone <span class="required text-danger">*</span></label>
                                                            <input class="form-control border-form-control addr_input Phone" value="" placeholder="Phone" type="number" minlength="10" name="mobile" maxlength="10" value="">
                                                            </div>
                                                      </div>
                                                      <div class="col-sm-6">
                                                            <div class="form-group">
                                                            <label class="control-label">Flat/House No <span class="required text-danger">*</span></label>
                                                            <input class="form-control border-form-control addr_input flatno" value="" placeholder="Flat/House No" type="text" name="flatno">
                                                            </div>
                                                      </div>
                                                      </div>
                                                      <div class="row">
                                                      <div class="col-sm-12">
                                                            <div class="form-group">
                                                            <label class="control-label">Landmark <span class="required text-danger">*</span></label>
                                                            <textarea class="form-control border-form-control addr_input landmark"  name="landmark"></textarea>
                                                            <small class="text-danger">
                                                            Please include landmark (e.g : Opposite Bank) as the carrier service may find it easier to locate your address.
                                                            </small>
                                                            </div>
                                                      </div>
                                                      </div>
                                                      <div class="row">
                                                      <div class="col-sm-12">
                                                            <div class="form-group">
                                                            <label class="control-label">Address/Location <span class="required text-danger">*</span></label>
                                                            <textarea class="form-control border-form-control billing_address addr_input" name="location" id="billing_address1"></textarea>
                                                            </div>
                                                      </div>
                                                      </div>
                                                      <input id="latitude1" type="hidden" name="userLat" class="userLat">
                                                      <input id="longitude1" type="hidden" name="userLong" class="userLong">
                                                      <div class="row">
                                                            <div class="col-sm-3">
                                                                  <div class="form-group"><input type="radio" class="saveas"  checked="checked" name="saveas" value="Home" class="saveas" required>Home</div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                  <div class="form-group"><input type="radio" name="saveas" value="Work" class="saveas " required>Work</div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                  <div class="form-group"><input type="radio" name="saveas" value="Others" class="saveas " required>Others</div>
                                                            </div>
                                                      </div>
                                                     <button type="button" class="btn btn-secondary text-left back_btn">BACK</button>
                                                </div>
                                          <?php
                                          }
                                          $user_id = $this->session->userdata('user_login_session_id');
                                          $getAllCustomerAddress = "SELECT * FROM grocery_add_address WHERE user_id = '$user_id' AND lkp_status_id = 0";
                                          $getCustomerAddress = $this->db->query($getAllCustomerAddress);
                                          if($getCustomerAddress->num_rows() == 0) { 
                                              
                                                if($this->session->userdata('select_order_type')==2){
                                          ?>
                                          <div class="row addr3">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-6">
                                                      <center>
                                                      <!--<img src="images/myaddress.png">-->
                                                      <h4>No Addresses found in your account!</h4>
                                                      <p>Add a delivery address.</p>
                                                      <center><button type="button" class="btn btn-secondary text-center add_addr_btn">NEW ADDRESS</button></center>
                                                </div>
                                                <div class="col-sm-3"></div>
                                          </div>
                                          <input type="hidden"  name="address_type" value="0" >
                                          <?php
                                                }
                                    } else {
                                         
                                     if($this->session->userdata('select_order_type')==2){
                                     
                                          ?>
                                          <div class="addr2">
                                                <input type="hidden"  name="address_type" value="1" >
                                                <?php $i=1; foreach ($getCustomerAddress->result_array() as $getCustomerDeatils) { ?>
                                                <div class="text_brdr addr_list">
                                                      <label class="container3">
                                                      <input type="radio" checked="checked" class="make_it_default" name="address_id" value="<?php echo $getCustomerDeatils['id']; ?>">Address <?php echo $i;?>
                                                            <span class="checkmarkR1"></span>
                                                      </label>
                                                      <p><b><?php echo $getCustomerDeatils['first_name']; ?></b>, <span><?php echo $getCustomerDeatils['email']; ?></span>, <span><?php echo $getCustomerDeatils['phone']; ?></span></p>
                                                      <p><?php echo $getCustomerDeatils['flatno']; ?>, <span><?php echo $getCustomerDeatils['location']; ?></span>, <span><?php echo $getCustomerDeatils['landmark']; ?></span></p>
                                                      
                                                </div>
                                                <?php $i++; } ?>
                                                <center><button type="button" class="btn btn-secondary text-center add_addr_btn">NEW ADDRESS</button></center>
                                          </div>
                                          <?php } } ?>
                                          </div>
                                          <input type="hidden"  name="pay_mn" value="4" >
                                    </div>
                                    </div>
                              </div>
                              </div>
                        </div>
                        <?php
                        if($this->session->userdata('CART_TEMP_RANDOM') == "") {
                            $this->session->set_userdata('CART_TEMP_RANDOM',rand(10, 10).time());
                        }
                        $session_cart_id = $this->session->userdata('CART_TEMP_RANDOM');
                         $user_session_id = $this->session->userdata('user_login_session_id');
                        $cartItems1 = "SELECT * FROM grocery_cart WHERE (user_id = '$user_session_id' OR session_cart_id='$session_cart_id') AND product_quantity!='0'";
                        $cartItems = $this->db->query($cartItems1);
                        $cart_count = $cartItems->num_rows(); 
                        ?>
                        <div class="col-md-4">
                              <div class="card sidecard">
                              <h5 class="card-header new-header">My Cart <span class="text-secondary float-right">(<?php echo $cart_count;?> item)</span></h5>
                              <div class="card-body pt-0 pr-0 pl-0 pb-0 cart_body_items" style="padding-left:10px;">
                                    <?php 
                                     $CI = & get_instance();
                                    $cartTotal = 0;
                                    $addonaall=0;
                                    $productlist=$cartItems->result_array();
                                   
                                      $cartTotal = 0;
                                      foreach ($productlist as $getCartItems ) { 
                                      $cartTotal += $getCartItems['product_price']*$getCartItems['product_quantity'];
                                      $getWeight = $getCartItems['product_weight_type'];
                                      $item_ids=$getCartItems['product_id'];
                                      $sql_addon_query=$CI->db->query("select * from db_cart_addon where item_id='$item_ids' AND session_cart_id='$session_cart_id'");
                                      ?>
                                      <div class="cart-list-product">
                                        <div class="row m-0">
                                           <div class="col-6 col-sm-6">
                                               <h6 class="show-ellipsis text-capitalize"><?php echo wordwrap($getCartItems['product_name'],105,"<br>\n"); ?></h6>
                                               <p><strong><?php echo $getWeight; ?>@<?php echo $getCartItems['product_price']; ?></strong> No tax</p>
                                           </div>        
                                            <div class="col-3 col-sm-3">
                                                
                                                <span class="qty">Qty :<?php echo $getCartItems['product_quantity']; ?></span>
                                                
                                            </div>  
                                            <div class="col-3 col-sm-3 text-right">
                                                <p class="price-amount text-right"><strong>$<?php echo number_format(($getCartItems['product_quantity']*$getCartItems['product_price']),2); ?></strong></p>
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
                                     <!--   <div class="row">
                                        
                                        <div class="col-md-6 col-sm-6"><p></span><?php echo $addon_row['addon_name']; ?><p></div>
                                        <div class="col-md-6 col-sm-6"><p><?php echo $addon_row['total_price']; ?></p></div>
                                        
                                        </div>-->
                                               <div class="row cart-addons m-0">
                          
                          <div class="col-md-6 col-sm-6 col-6 "><p class="add-text"></span><?php echo $addon_row['addon_name']; ?><p></div>
                          <div class="col-md-6 col-sm-6 col-6"><p class="add-price"><?php echo $addon_row['total_price']; ?></p></div>
                         
                           </div>
                                        <?php
                                        }
                                        
                                        ?>
                                        
                                        <?php
                                        }
                                        ?>
                                            <input type="hidden" name='category_id[]' value='<?php echo $getCartItems['category_id'];?>'>
                                            <input type="hidden" name='sub_cat_id[]' value='<?php echo $getCartItems['sub_category_id'];?>'>
                                            <input type="hidden" name='product_id[]' value='<?php echo $getCartItems['product_id'];?>'>
                                            <input type="hidden" name='product_weight[]' value='<?php echo $getCartItems['product_weight_type'];?>'>
                                            <input type="hidden" name='product_quantity[]' value='<?php echo $getCartItems['product_quantity'];?>'>
                                            <input type="hidden" name='product_reward_points[]' value='0'>
                                            <input type="hidden" name="product_name" value="<?php echo $getProductName['product_name']; ?>">
                                            <input type="hidden" name="product_price[]" value="<?php echo $getCartItems['product_price']; ?>">
                                            <input type="hidden" id="sub_total" name="sub_total" value="<?php echo $cartTotal+$addonaall; ?>">
                                            <input type="hidden" name="<?php echo $CI->security->get_csrf_token_name(); ?>" value="<?php echo $CI->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                                      </div>
                                      <?php } ?>
                              </div>
                              <div class="cart-sidebar-footer" style="padding: 10px;">
                                    <div class="cart-store-details">
                                          <p>Sub Total <strong class="float-right">$<?php echo number_format($cartTotal+$addonaall,2) ;?></strong></p>
                                          
                                          <?php
                                          $delivery_charges=0;
                                          $service_tax=0;
                                           //$getSiteSettings1 = getAllDataWhere('grocery_site_settings','id','1'); 
            	                          //  $getSiteSettingsData1 = $getSiteSettings1->fetch_assoc();
            	                         //   $getAllPaymentsSettings = getIndividualDetails('grocery_payments_settings','id','1');
                                            
                                            // $service_tax=0; += ($getSiteSettingsData1['service_tax']/100)*$cartTotal;
                                            // if($getAllPaymentsSettings['delivery'] == 1 && $cartTotal < 100 && $this->session->userdata('select_order_type')=="2") {
                                            // $delivery_charges = 20;
                                            // } 
                                            // else if($getAllPaymentsSettings['delivery'] == 1 && $cartTotal < 100  && $cartTotal > 25 && $this->session->userdata('select_order_type')=="2") {
                                            // $delivery_charges =20;
                                            // } 
                                            // else {
                                            // $delivery_charges = 0;
                                            // }
                                            if($this->session->userdata('select_order_type')=="2"){
                                          ?>
                                                 <input type="hidden" id="order_total" name="order_total" value="<?php echo ($cartTotal +$delivery_charges+$service_tax+$addonaall);?>">
                                            <input type="hidden" name="delivery_charges" value="<?php echo $delivery_charges; ?>" id="delivery_charges">
                                            <input type="hidden" name="expdelivery_charge" value="0" id="delivery_chargesexpress">
                                          <p>Delivery Charges <strong class="float-right text-danger devCharge">+ <?php echo number_format($delivery_charges,2); ?></strong></p>
                                          <p style="display:none" id="delivery_chargesexpressText">EXpress Delivery Charges <strong class="float-right text-danger devCharge">+ <?php echo number_format(20,2); ?></strong></p>
                                          <?php
                                            }else{
                                                ?>
                                                    <input type="hidden" id="order_total" name="order_total" value="<?php echo $cartTotal+$addonaall;?>">
                                                <?php
                                            }
                                          ?>
                                          
                                           <?php
                                          $offerid=getSingleColumnName($user_id,'id','offer_id','db_customers');  
	        if($offerid !='' && $offerid !='0'){
	            $offer_percentage=getSingleColumnName($offerid,'id','offer_percentage','db_offers');
	             $offer_name=getSingleColumnName($offerid,'id','offer_name','db_offers');
	            if($offer_percentage > 0){
	            $offer_amount=($cartTotal+$addonaall)*$offer_percentage/100;
	            $discount_to_all_input=$offer_percentage;
	            $discount_to_all_type='in_percentage';
	            $order_total=($cartTotal+$addonaall)-$offer_amount;
	            $tot_discount_to_all_amt=$offer_amount;
	            }else{
	            $offer_amount=0;
	            $discount_to_all_input=0;
	            $discount_to_all_type=0;
	            $order_total=$order_total;
	            $tot_discount_to_all_amt=0;
	            }
	        }else{
	            $offer_amount=0;
	            $discount_to_all_input=0;
	            $discount_to_all_type=0;
	            $order_total=$order_total;
	            $tot_discount_to_all_amt=0;
	        }
	        if($tot_discount_to_all_amt > 0){
                                          ?>
                                          
                                           <p>Discount <strong class="text-danger devCharge">&nbsp;&nbsp;&nbsp;(<?php echo $offer_name; ?>)&nbsp;&nbsp;&nbsp;</strong> <strong class="float-right text-danger devCharge">&nbsp; $ <?php echo number_format($tot_discount_to_all_amt,2); ?></strong></p>
                                      <?php
	        }
                                      ?>
                                          
                                          
                                          
                                          
                                          <h6>Grand Total <strong class="float-right text-danger grandTotal">$<?php echo number_format($cartTotal +$delivery_charges+$service_tax+$addonaall-$tot_discount_to_all_amt,2);?></strong></h6>
                                    </div>
                                       <div class="cart-store-details" id="radioDiv" >
                                        <?php
                                       
                                        date_default_timezone_set('Australia/Sydney');
                                        $currentTime = time() + 3600;
                                        $time1 = date('H:i',$currentTime);
                                        $time2 = '24:00';

                                          if($this->session->userdata('select_order_type')==2){
                                        ?>
                                          <p> <strong>Delivery  Type</strong></p>
                                        <div class="form-check-inline">
                                        <label class="form-check-label">
                                        <input type="radio" class="form-check-input del_type" name="delivery_type" value="1"  checked="checked"> Normal
                                        </label>
                                        </div>
                                        <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <?php
                                            if(checkTime($time1,$time2)){
                                            ?>
                                             <input type="radio"  disabled='disabled' class="form-check-input del_type"  name="delivery_type" value="2">Express
                                            <?php
                                        }else{
                                         ?>
                                          <input type="radio" class="form-check-input del_type"  name="delivery_type" value="2">Express
                                         <?php
                                        }
                                            ?>
                                       
                                        </label>
                                        </div>
                                        <?php
                                          }
                                        ?>
                                        <input type="hidden" class="form-check-input"  name="pay_mn" value="3" >
                                    </div>
                                
                                   
                                     <?php
                                        
                                     if($this->session->userdata('select_order_type')==2){
                                    ?>
                                    <button class="btn btn-secondary btn-lg btn-block text-left checkout_btn" type="submit"  <?php if($getCustomerAddress->num_rows == 0) { ?> disabled="" <?php } else { ?>  <?php } ?> ><span class="float-left"><i class="mdi mdi-cart-outline"></i> Proceed to Checkout </span><span class="float-right"><strong class="grandTotal">$<?php echo number_format($cartTotal +$delivery_charges+$service_tax+$addonaall-$tot_discount_to_all_amt,2);?></strong> <span class="mdi mdi-chevron-right"></span></span></button>
                                    <?php
                                     }else{
                                           ?>
                                    <button class="btn btn-secondary btn-lg btn-block text-left checkout_btn" type="submit"  ><span class="float-left"><i class="mdi mdi-cart-outline"></i> Proceed to Checkout </span><span class="float-right"><strong class="grandTotal">$<?php echo number_format($cartTotal +$delivery_charges+$service_tax+$addonaall-$tot_discount_to_all_amt,2);?></strong> <span class="mdi mdi-chevron-right"></span></span></button>       
                                           <?php
                                     }
                                    ?>
                              </div>
                        </div>
                  </div>
            </form>
      </div>
</section>

       <?php
include_once'footer.php';
?>
<style>
 .show-ellipsis{
    width: 150px!important;
    overflow-wrap: break-word;
    word-wrap: break-word;
    hyphens: auto;
    display: block;
 }   
</style>
  