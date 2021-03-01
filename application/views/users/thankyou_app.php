<!doctype html>
<html class="no-js" lang="zxx">
<head>
       
        <meta charset="utf-8">
        <meta name="theme-color" content="#32801b" />
       <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
         

        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css"><head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
         <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/animate.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/owl.theme.default.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/icon-font.min.css">
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
    
    height: 60px;
 
}

.navbar-nav .nav-link {
    color: #000;
    font-weight: 500;
    font-size: 0.95rem;
}
.navbar-fixed-header .navbar-brand img {
top: 5px;
    height: 50px;
    left: 7px;
    position: static;
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
    background: #32801b;
}
.navbar-fixed-header .navbar-toggler {

    margin-right: 0rem;
}
}
        </style>
        </head>
        <div id="fb-root"></div>
      
        <!-- Umino's Breadcrumb Area End Here -->
        <!-- Begin Umino's Checkout Area -->
   <section class="checkout-page section-padding" >
        <?php
     $CI =& get_instance(); 
           echo $order_id = $order_id;

         	$wherearray=array('sales_code'=>$order_id);
         echo	$price=$this->items->getSingleColumnNameMultiple('grand_total','db_sales',$wherearray);
         	$user_id = $this->items->getSingleColumnNameMultiple('customer_id','db_sales',$wherearray);
            $customer_id=$this->items->getSingleColumnNameMultiple('customer_id','db_sales',$wherearray);
  $getWalletAmount = getIndividualDetails('db_sales','sales_code',$order_id);
	$getUserDetails = getIndividualDetails('db_customers','id',$user_id);
	$getOrderAddress = getIndividualDetails('grocery_del_addr','order_id',$order_id);
	$delivery_type =$getWalletAmount['delivery_type'];
	$deliveryDate= date("d-F-Y", strtotime($getWalletAmount['delivery_slot_date']));
echo	$sales_id = $getWalletAmount['id'];
    ?>
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="checkout-step">
                     <div class="accordion" id="accordionExample">
                        <div class="card1">
                           
                           <div id="collapsefour" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionExample">
                              <div class="card-body1">
                                 <div class="text-center">
                                    <div class="col-lg-10 col-md-10 mx-auto order-done">
                                       <i class="mdi mdi-check-circle-outline text-secondary"></i>
                                       <h4 class="text-success">Congrats!</h4>
                                       <h5 class="order-success">Your Order has been Accepted..</h5>
                                       <h6 class="order-no" >Order Number - <span><?php echo $order_id; ?></span></h6>
                                      
                                    </div>
                                   
                                 </div>
                                 <div class="table-responsive">
                              <table class="table table-striped records_table table-bordered">
            <thead class="bg-gray-active">
            <tr>
              <th>#</th>
              <th>Item Name</th>
              <th>Quantity</th>
              <th>Unit Price</th>
              
              <th>Total Amount</th>
            </tr>
            </thead>
            <tbody>

              <?php
              $i=0;
              $tot_qty=0;
              $tot_sales_price=0;
              $tot_tax_amt=0;
              $tot_discount_amt=0;
              $tot_total_cost=0;
              $CI =& get_instance(); 
              $q2=$CI->db->query("SELECT a.description, c.item_name, a.sales_qty,a.tax_type,
                                  a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
                                  a.unit_discount_per,a.discount_amt, a.unit_total_cost,
                                  a.total_cost 
                                  FROM 
                                  db_salesitems AS a,db_tax AS b,db_items AS c 
                                  WHERE 
                                  c.id=a.item_id AND b.id=a.tax_id AND a.sales_id='$sales_id'");
                                  
                                  
              foreach ($q2->result() as $res2) {
                  
                 
                  $str = ($res2->tax_type=='Inclusive')? 'Inc.' : 'Exc.';
                  $discount = (empty($res2->unit_discount_per)||$res2->unit_discount_per==0)? '0':$res2->unit_discount_per."%";
                  $discount_amt = (empty($res2->discount_amt)||$res2->unit_discount_per==0)? '0':$res2->discount_amt."";
                  echo "<tr>";  
                  echo "<td>".++$i."</td>";
                  echo "<td>";
                    echo $res2->item_name;
                    echo (!empty($res2->description)) ? "<br><i>[".nl2br($res2->description)."]</i>" : '';
                  echo "</td>";
                   echo "<td>".$res2->sales_qty."</td>";
                  echo "<td class='text-right'>".$CI->currency(number_format($res2->price_per_unit,2,'.',''))."</td>";
                 
                  
                  echo "<td class='text-right'>".$CI->currency(number_format($res2->total_cost,2,'.',''))."</td>";
                  echo "</tr>";  
                  
                        //   $item_idd=$res2->item_id;  
                        //     $sql_addon_query=$this->db->query("select * from db_sales_addon_detail where sales_id='$sales_id' AND item_id=$item_idd");
                        //     if($sql_addon_query->num_rows() > 0){
                            
                        //     $sql_addon=$sql_addon_query->result_array();
                        //     foreach($sql_addon as $addon_row){
                        //     $adon_id=$addon_row['addon_id'];
                        //      $addonaall=$addonaall+$addon_row['total_price'];
                        //     $price=$addon_row['price'];
                        //     $qty=$addon_row['qty'];
                        //     $total_price=$addon_row['total_price'];
                        //     $note=$addon_row['note']==''?'for kitchen':$addon_row['note'];
                        //     $addon_name=getSingleColumnName($adon_id,'id','modifier_name','db_modifier'); 
                        //     echo "<tr>";  
                        //     echo "<td style='padding-left: 2px; padding-right: 2px;' valign='top'></td>";
                        //     echo "<td style='padding-left: 2px; padding-right: 8px;'>&nbsp;&nbsp;&nbsp;&nbsp;".ucwords(strtolower($addon_name))."</td>";
                        //     echo "<td style='text-align: center;padding-left: 2px; padding-right: 2px;'>".$qty."</td>";
                        //     echo "<td style='text-align: right;padding-left: 2px; padding-right: 2px;'>".number_format(($price),2,'.','')."</td>";
                        //     echo "<td style='text-align: right;padding-left: 2px; padding-right: 2px;' >".number_format(($total_price),2,'.','')."</td>";
                        //     echo "</tr>"; 
                        //     echo "<tr>";  
                        //     if($note!='0' && $note!=''){
                        //     echo "<td style='padding-left: 2px; padding-right: 2px;' valign='top'>Note:</td>";
                        //     echo "<td class='text-center' solspan='4' style='padding-left: 2px; padding-right: 8px;'>".$note."</td>";
                        //     }
                        //     echo "</tr>";          
                            
                        //     }
                            
                        //     }  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  $tot_qty +=$res2->sales_qty;
                  $tot_sales_price +=$res2->price_per_unit;
                  $tot_tax_amt +=$res2->tax_amt;
                  $tot_discount_amt +=$res2->discount_amt;
                  $tot_total_cost +=$res2->total_cost;
              }
              ?>
         
      
            </tbody>
            <tfoot class="text-right text-bold bg-gray">
              <tr>
                <td colspan="2" class="text-center">Total</td>
                <td class="text-left"><?=$tot_qty;?></td>
                <td><?= $CI->currency(number_format($tot_sales_price,2,'.',''));?></td>
                
                
                
                <td><?= $CI->currency(number_format($tot_total_cost,2,'.','')) ;?></td>
              </tr>
            </tfoot>
          </table>
          </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
 <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
         <script src="<?php echo base_url() ?>assets/js/owl.carousel.js"></script>
<style>
 .show-ellipsis{
    width: 150px!important;
    overflow-wrap: break-word;
    word-wrap: break-word;
    hyphens: auto;
    display: block;
    text-transform
 }
 .checkout-page.section-padding{
    padding:3rem 0;
}
.table-bordered th {
      border: none;
    padding: 0.5rem;
    font-size: 0.85rem;
    text-transform: capitalize;
    font-weight: 500;
    background: #555;
    color: #fff;
}
.table td {
    padding: .5rem 0.25rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: capitalize;
}
.btn-secondary {
    color: #fffimportant;
    background-color: #8ec400 !important;
    border-color: #8ec400 !important;
    font-size: 0.85rem;
    text-transform: uppercase;
    font-weight: 600;
}
.order-success{
        font-size: 1rem;
    color: #000;
}
.order-no{
    font-size: 0.85rem;
    margin-bottom: 1rem;
    font-weight: 400;

}
.order-no span{
    background: #444;
    padding: 3px 8px;
    font-size: 0.8rem;
    color: #fff;
    font-weight: 600;
}
</style>
  