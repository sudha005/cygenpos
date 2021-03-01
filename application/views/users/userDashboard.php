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
                                          $getAllCustomerAddress = "SELECT * FROM db_sales WHERE customer_id = '$user_id' order by id desc ";
                                          $getCustomerAddress = $this->db->query($getAllCustomerAddress);
                                          if($getCustomerAddress->num_rows() > 0) { 
                                              $i=1; foreach ($getCustomerAddress->result_array() as $getCustomerDeatils) { 
                                                  $order_status = getSingleColumnName($getCustomerDeatils['order_status'],'id','order_status','db_order_status');
                                                  $user_name = getSingleColumnName($getCustomerDeatils['customer_id'],'id','customer_name','db_customers');
                                                   $user_mobile = getSingleColumnName($getCustomerDeatils['customer_id'],'id','mobile','db_customers');
                                                  $location = getSingleColumnName($getCustomerDeatils['sales_code'],'order_id','location','grocery_del_addr');
                                                  $deliveryDate= date("d-F-Y", strtotime($getCustomerDeatils['delivery_slot_date']));
                                          ?>
                                <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne<?php echo $getCustomerDeatils['id'];?>">
                                    <a class="card-title">
                                        <span>Order Number</span> <strong><?php echo $getCustomerDeatils['sales_code']; ?></strong>
<?php
$sales_code=$getCustomerDeatils['sales_code'];
$sql_tbl=$this->db->query("select table_number from grocery_pickup_detail where order_id='$sales_code' order by id desc");
if($sql_tbl->num_rows() > 0){
$resultrow=$sql_tbl->row_array(); 
$sales_table=$resultrow['table_number'];
}else{
$sales_table=0;
}
if($sales_table!='0'){
?>                                     
                                      
                                        <span class="status-delivered">T-<?php echo $sales_table ?>  Ordered</span>
<?php
}else{
    ?>
     <span class="status-delivered">Ordered</span>
    <?php
}
?>
                                        
                                        
                                      
                                       
                                    </a>
                                </div>
                                <div id="collapseOne<?php echo $getCustomerDeatils['id'];?>" class=" collapse" data-parent="#accordion">
                                    <div class="p-2">
                                        <div class="row m-0 separator">
                                            <div class="col-md-4 col-sm-3 col-3">
                                                <label>Order Number: <?php echo $getCustomerDeatils['sales_code']; ?></label>    
                                            </div>
                                            <div class="col-md-8 col-sm-9 col-9 text-right">
                                                <label>Date <?php echo $getCustomerDeatils['created_date'].'&nbsp;'.$getCustomerDeatils['created_time']; ?></label>    
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table ordertable">
                                                	<thead>
					<tr style="border-top-style: dashed;border-bottom-style: dashed;border-width: 0.1px;">
						<th>#</th>
						<th>Description</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Total</th>
					</tr>
					</thead>
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
                                                        <td><?php echo $i;?></td>
                                                        <td><?php echo $product_name;?></td>
                                                        <td><?php echo $getitemdetails['sales_qty'] ?></td>
                                                        <td><?php echo $getitemdetails['price_per_unit'] ?></td>
                                                        <td><?php echo $getitemdetails['sales_qty']*$getitemdetails['price_per_unit'] ?></td>
                                                    </tr>
                                                    <?php
                                                    $item_idd=$getitemdetails['item_id'];
                                                    $sales_id=$getCustomerDeatils['id'];
                                                      $sql_addon_query=$this->db->query("select * from db_sales_addon_detail where sales_id='$sales_id'  AND item_id=$item_idd");
                            if($sql_addon_query->num_rows() > 0){
                            
                            $sql_addon=$sql_addon_query->result_array();
                            foreach($sql_addon as $addon_row){
                            $adon_id=$addon_row['addon_id'];
                             $addonaall=$addonaall+$addon_row['total_price'];
                            $price=$addon_row['price'];
                            $qty=$addon_row['qty'];
                            $total_price=$addon_row['total_price'];
                            $note=$addon_row['note']==''?'for kitchen':$addon_row['note'];
                            $addon_name=getSingleColumnName($adon_id,'id','modifier_name','db_modifier'); 
                            echo "<tr>";  
                            echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                            echo "<td>".ucwords(strtolower($addon_name))."</td>";
                            echo "<td>".$qty."</td>";
                            echo "<td>".number_format(($price),2,'.','')."</td>";
                            echo "<td>".number_format(($total_price),2,'.','')."</td>";
                            echo "</tr>"; 
                            
                            if($note!='0' && $note!=''){
                            echo "<tr>";      
                            echo "<td>Note:</td>";
                            echo "<td  colspan='4'>".$note."</td>";
                             echo "</tr>";    
                            }
                                 
                            
                            }
                            
                            }  
                          ?>                          
                                                    
                                                    
                                                    
                                                    <?php $i++; } } else { ?>
                                <tr><td colspan="15">No Products Found</td></tr>
                            <?php } ?>
                                                   
                                                    <tr class="amount-trs">
                                                        <td colspan="3" class="text-right">Sub Total</td>
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
                                                        <td colspan="3" class="text-right">Grand Total </td>
                                                        <td class="text-right"><strong>$ <?php echo $getCustomerDeatils['grand_total'];?></strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                      
                                    </div>
                                </div>
                                
                                <?php  } } else { ?>
                                                            <tr><td colspan="15">
                                                                <div class="no-orders">
                                                                No  Orders Found
                                                                </div>
                                                                </td></tr>
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