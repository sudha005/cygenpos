<?php
include_once'header.php';
?>
        <div id="fb-root"></div>
        <section class="abt-banner p-0">
           
            <div class="container h-100">
                <div class="row m-0 h-100 justify-content-center align-items-center">
                    <div class="col-md-12 text-center">
                        <h3>Thank you</h3>
                    </div>
                </div>
            </div> 
        </section> 
        <!-- Umino's Breadcrumb Area End Here -->
        <!-- Begin Umino's Checkout Area -->
   <section class="checkout-page section-padding" >
        <?php
     $CI =& get_instance(); 
    $order_id = $CI->session->userdata('order_last_session_id');
	$user_id = $CI->session->userdata('user_login_session_id');
    $getWalletAmount = getIndividualDetails('db_sales','sales_code',$CI->session->userdata('order_last_session_id'));
	$getUserDetails = getIndividualDetails('db_customers','id',$user_id);
	$getOrderAddress = getIndividualDetails('grocery_del_addr','order_id',$CI->session->userdata('order_last_session_id'));
	$delivery_type =$getWalletAmount['delivery_type'];
	$deliveryDate= date("d-F-Y", strtotime($getWalletAmount['delivery_slot_date']));
	$sales_id = $getWalletAmount['id'];
	$totalall_discount=$getWalletAmount['tot_discount_to_all_amt'];
	$totalall_netamount=$getWalletAmount['grand_total'];
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
                                       <a style="display:block;" class="order-no" href="<?php echo base_url() ?>Userdashboard"> View  Your Order </a>
                                    </div>
                                    <div class="text-center">
                                       <a href="<?php echo base_url();?>productListpage"><button type="submit" class="btn btn-secondary mb-2 btn-lg">Continue to store</button></a>
                                    </div>
                                 </div>
                                 <div class="table-responsive">
                              <table class="table table-striped records_table table-bordered">
            <thead class="bg-gray-active">
            <tr>
              <th>#</th>
              <th>Item Name</th>
              <th>Unit Price</th>
              <th>Quantity</th>
              <th>Net Cost</th>
              
              <th>Tax Amount</th>
              <th>Discount</th>
              <th>Discount Amount</th>
              <th>Unit Cost</th>
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
              $q2=$CI->db->query("SELECT a.item_id,a.description, c.item_name, a.sales_qty,a.tax_type,
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
                  echo "<td class='text-right'>".$CI->currency(number_format($res2->price_per_unit,2,'.',''))."</td>";
                  echo "<td>".(int)$res2->sales_qty."</td>";
                  echo "<td class='text-right'>".$CI->currency(number_format(($res2->price_per_unit * $res2->sales_qty),2,'.',''))."</td>";
                  echo "<td class='text-right'>".$CI->currency($res2->tax_amt)."</td>";
                  echo "<td class='text-right'>".$discount."</td>";
                  echo "<td class='text-right'>".$CI->currency($discount_amt)."</td>";
                  echo "<td class='text-right'>".$CI->currency(number_format($res2->unit_total_cost,2,'.',''))."</td>";
                  echo "<td class='text-right'>".$CI->currency(number_format($res2->total_cost,2,'.',''))."</td>";
                  echo "</tr>";  
                  
                             $item_idd=$res2->item_id;  
                            $sql_addon_query=$this->db->query("select * from db_sales_addon_detail where sales_id='$sales_id' AND item_id=$item_idd");
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
                            echo "<td style='padding-left: 2px; padding-right: 2px;' valign='top'></td>";
                            echo "<td style='padding-left: 2px; padding-right: 8px;'>&nbsp;&nbsp;&nbsp;&nbsp;".ucwords(strtolower($addon_name))."</td>";
                             echo "<td style='padding-left: 2px; padding-right: 2px;' valign='top'></td>";
                            echo "<td style='padding-left: 2px; padding-right: 2px;'>".(int)$qty."</td>";
                             echo "<td style='padding-left: 2px; padding-right: 2px;' valign='top'></td>";
                              echo "<td style='padding-left: 2px; padding-right: 2px;' valign='top'></td>";
                               echo "<td style='padding-left: 2px; padding-right: 2px;' valign='top'></td>";
                                echo "<td style='padding-left: 2px; padding-right: 2px;' valign='top'></td>";
                            echo "<td style='text-align: right;padding-left: 2px; padding-right: 2px;'>$".number_format(($price),2,'.','')."</td>";
                            echo "<td style='text-align: right;padding-left: 2px; padding-right: 2px;' >$".number_format(($total_price),2,'.','')."</td>";
                            echo "</tr>"; 
                            echo "<tr>";  
                            if($note!='0' && $note!=''){
                            echo "<td style='padding-left: 2px; padding-right: 2px;' valign='top'>Note:</td>";
                            echo "<td class='text-center' solspan='4' style='padding-left: 2px; padding-right: 8px;'>".$note."</td>";
                            }
                            echo "</tr>";          
                            
                            }
                            
                            }  
                  
                  
                  
                  
                  
                  
                  
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
                <td><?= $CI->currency(number_format($tot_sales_price,2,'.',''));?></td>
                <td class="text-left"><?=$tot_qty;?></td>
                <td>-</td>
                
                <td><?= $CI->currency(number_format($tot_tax_amt,2,'.',''));?></td>
                <td>-</td>
                <td><?= $CI->currency(number_format($tot_discount_amt,2,'.','')) ;?></td>
                <td>-</td>
                <td><?= $CI->currency(number_format($tot_total_cost+$addonaall,2,'.','')) ;?></td>
              </tr>
              <tr>
                <td colspan="2" class="text-center"></td>
                <td></td>
                <td class="text-left"></td>
                <td></td>
                <td></td>
                <td>Over all Discount </td>
                <td><?= $CI->currency(number_format($totalall_discount,2,'.','')) ;?></td>
                <td>-</td>
                <td><?= $CI->currency(number_format($totalall_netamount,2,'.','')) ;?></td>
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
    <?php
        	$user_id = $this->session->userdata('user_login_session_id');
    	$session_cart_id = $this->session->userdata('CART_TEMP_RANDOM');
        $delCart =$CI->db->query("DELETE FROM grocery_cart WHERE user_id = '$user_id' OR session_cart_id='$session_cart_id' ");
        $delCart2 =$CI->db->query("DELETE FROM db_cart_addon WHERE user_id = '$user_id' OR session_cart_id='$session_cart_id' ");
    ?>
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
  