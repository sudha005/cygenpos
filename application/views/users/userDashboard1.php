<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once'header.php';?>
    </head>
    <body>
       
        <div id="fb-root"></div>
        <section class="abt-banner p-0">
           
            <div class="container h-100">
                <div class="row m-0 h-100 justify-content-center align-items-center">
                    <div class="col-md-12 text-center">
                        <h3>My Orders</h3>
                    </div>
                </div>
            </div> 
        </section>
        <section class="user-dashboard">
            <div class="container">
                <div class="row m-0">
                    <div class="col-md-3">
                        <div class="dashboard-box"> 
                            <ul>
                                         <li><a href="<?php echo base_url(); ?>userDashboardOrders" class="active"><span class="lnr lnr-cart"></span> My Orders</a></li>
                                <li><a href="<?php echo base_url(); ?>Userdashboard"><span class="lnr lnr-user"></span>My Profile</a></li>
                                <li><a href="<?php echo base_url(); ?>MyAddress" ><span class="lnr lnr-map-marker"></span>My Address</a></li>
                                <li><a href="<?php echo base_url(); ?>ChangePassword" ><span class="lnr lnr-lock"></span>Change Password</a></li>
                                <li><a href="<?php echo base_url(); ?>logout"><span class="lnr lnr-exit"></span>Logout</a></li>
                            </ul>
                        </div>

                    </div>
                   
                    <div class="col-md-9">
                        <div id="accordion" class="accordion">
                            <div class="card ">
                                 <?php
                                          $user_id = $this->session->userdata('user_login_session_id');
                                          $getAllCustomerAddress = "SELECT * FROM db_sales WHERE customer_id = '$user_id' AND status = 1";
                                          $getCustomerAddress = $this->db->query($getAllCustomerAddress);
                                          if($getCustomerAddress->num_rows() > 0) { 
                                              $i=1; foreach ($getCustomerAddress->result_array() as $getCustomerDeatils) { 
                                                  $order_status = getSingleColumnName($getCustomerDeatils['order_status'],'id','order_status','db_order_status');
                                                  $user_name = getSingleColumnName($getCustomerDeatils['customer_id'],'id','customer_name','db_customers');
                                                  $deliveryDate= date("d-F-Y", strtotime($getCustomerDeatils['delivery_slot_date']));
                                          ?>
                                <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne<?php echo $getCustomerDeatils['id'];?>">
                                    <a class="card-title">
                                        <span>Sales Status</span> <strong><?php echo $getCustomerDeatils['sales_status']; ?></strong>
                                        <span class="status-delivered"><?php echo $order_status; ?></span>
                                        <span>Payment Status</span> <strong class="status-delivered"><?php echo $getCustomerDeatils['payment_status']; ?></strong>
                                    </a>
                                </div>
                                <div id="collapseOne<?php echo $getCustomerDeatils['id'];?>" class=" collapse" data-parent="#accordion">
                                    <div class="p-2">
                                        <div class="row m-0 separator">
                                            <div class="col-md-4 col-sm-3 col-3">
                                                <label>Customer Name: <?php echo $user_name; ?></label>    
                                            </div>
                                            <div class="col-md-8 col-sm-9 col-9 text-right">
                                                <label>Delivered on <?php echo $deliveryDate; ?></label>    
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table ordertable">
                                                <tbody> 
                                                <?php 
                                                $i = 1;
                                                $itemsalesid = $getCustomerDeatils['id'];
                                                 $getitem = "SELECT * FROM db_salesitems WHERE sales_id = '$itemsalesid'";
                                          $query1 = $this->db->query($getitem);
                                                if($query1->num_rows() > 0) {
                                                    foreach ($query1->result_array() as $getitemdetails) {
                                                   $product_name = getSingleColumnName($getitemdetails['item_id'],'id','item_name','db_items');
                                                ?>
                                                    <tr>
                                                        <td class="text-right"><?php echo $product_name;?></td>
                                                         <td class="text-right"><?php echo $getitemdetails['sales_qty'] ?></td>
                                                        <td class="text-right"><?php echo $getitemdetails['price_per_unit'] ?></td>
                                                    </tr>
                                                    <?php $i++; } } else { ?>
                                <tr><td colspan="15">No Products Found</td></tr>
                            <?php } ?>
                                                   
                                                    <tr class="amount-trs">
                                                        <td colspan="2" class="text-right">Sub Total</td>
                                                        <td class="text-right"><strong>$ <?php echo $getCustomerDeatils['subtotal'];?></strong></td>
                                                    </tr>
                                                    <!--<tr class="amount-trs">-->
                                                    <!--    <td colspan="2" class="text-right">Delivery Charges</td>-->
                                                    <!--    <td class="text-right"><strong>$ 45</strong></td>-->
                                                    <!--</tr>-->
                                                    <!--<tr class="amount-trs">-->
                                                    <!--    <td colspan="2" class="text-right">Taxes</td>-->
                                                    <!--    <td class="text-right"><strong>$ 45</strong></td>-->
                                                    <!--</tr>-->
                                                    <tr class="amount-trs total-bill">
                                                        <td colspan="2" class="text-right">Grand Total </td>
                                                        <td class="text-right"><strong>$ <?php echo $getCustomerDeatils['grand_total'];?></strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row m-0 h-100 align-items-center">
                                            <div class="col-md-6 col-sm-12 col-12">
                                                <p class="deliveredadd">326/336 Great Western Hwy, Wentworthville NSW 2145</p>
                                                <span class="deliveredaddspan">Delivered To</span>    
                                            </div>
                                            <!--<div class="col-md-6 col-sm-12 col-12 text-right">-->
                                            <!--    <p class="deliveredadd text-right">Mukund Kumar</p>-->
                                            <!--    <span class="deliveredaddspan">Delivered By</span>    -->
                                            <!--</div>-->
                                   
                                        </div>
                                    </div>
                                </div>
                                
                                <?php  } } else { ?>
                                                            <tr><td colspan="15">No  Orders Found</td></tr>
                                                        <?php } ?>
                              
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include_once'footer.php';?>
    </body>
</html>