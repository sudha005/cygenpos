<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <?php
     $CI =& get_instance(); 
    $order_id = $CI->session->userdata('order_last_session_id');
	$user_id = $CI->session->userdata('user_login_session_id');
    $getWalletAmount = getIndividualDetails('db_sales','sales_code',$CI->session->userdata('order_last_session_id'));
	$getUserDetails = getIndividualDetails('db_customers','id',$user_id);
	$getOrderAddress = getIndividualDetails('grocery_del_addr','order_id',$CI->session->userdata('order_last_session_id'));
	$delivery_type =$getWalletAmount['delivery_type'];
	$deliveryDate= date("d-F-Y", strtotime($getWalletAmount['delivery_slot_date']));
    ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" > 
        <tr>
            <td style="padding:10px;" >
                <table  align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border: 1px solid #cccccc;background-color:#f52f2c;padding:10px;">
                    <tr bgcolor="#fff">
                        <td align="center"  style="color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <img src="http://cygenpos.com.au/dev/cygenpos/assets/images/logo.png" width="90px" alt="Cygen"  style="display: block;" />
                        </td>
                    </tr>
                    <tr style="min-height:500px;" bgcolor="#f52f2c">
                        
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size:16px;padding:10px;">
                                        Dear <?=$getUserDetails['customer_name']; ?>,</br>
                                        <b>Thank you for your express order at Cygen</b>

                                    </td>
                   </tr>

                                <tr style="background-color: #fff;margin-bottom:2px;">
                                    <td style="font-family: Arial, sans-serif; font-size:14px;padding:10px;">
                                       <table width="100%" cellpadding="5px">
                                           <tr >
                                               <td width="15%">
                                                Order No
                                               </td>
                                               <td width="40%">
                                                <span style="color:blue;font-weight:bold;"><?=$order_id;?></span>
                                               </td>
                                               <td width="45%" >
                                               Address Detail
                                               </td>
                                           </tr>
                                           <?php
                                           if($CI->session->userdata('select_order_type')=="2"){
                                           ?>
                                        <tr>
                                            <td width="15%">
                                                Delivery slot
                                            </td>
                                            <td width="40%">
                                                <?=$delType;?><br/>
                                                <?=$deliveryDate?> between 07:00 PM and 10:00 PM
                                            </td>
                                            <td width="45%">
                                               <span> <?=$getOrderAddress['first_name'];?>,<br/>
                                                <?=$getOrderAddress['flatno'];?>,<br/>
                                                <?=$getOrderAddress['location'];?><br/>
                                                Phone Numbers : <?=$getOrderAddress['mobile'];?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php
                                           }
                                          
                                           if($CI->session->userdata('select_order_type')=="2"){
                                          
											$groceryOrders11 =$CI->db->query("SELECT * FROM grocery_pickup_detail  WHERE  order_id = '$order_id'"); 
							                $OrderDetails2 =$groceryOrders11->row_array();
										
                                        ?>
                                        
                                        <tr>
                                            <td>
                                                 <h3>Pickup Information</h3><br>
                                             </td>
                                            <td> 
                                         
											
											<p>Name         : <?php echo $OrderDetails2['name']; ?></p>
										    <p>Email        : <?php echo $OrderDetails2['email']; ?></p>
										    <p>Phone       : <?php echo $OrderDetails2['phone']; ?></p>
										     <p>Pickup Date      : <?php echo $OrderDetails2['pickup_datetime']; ?></p>
										     </td>
                                       </tr>
                                        
                                        <?php
                                           }
                                        ?>
                                        
                                        
                                        
                                       </table> 

                                    </td>
                                </tr>
                                <tr style="background-color:#ededed;margin-bottom:1px;">
                                    <td colspan="3">&nbsp;&nbsp;
                                     </td> 
                                </tr>
                                <tr style="background-color: #fff;">
                                    <td style="font-family: Arial, sans-serif; font-size:12px;padding:10px;">
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
                  echo "<td class='text-right'>".$CI->currency(number_format($res2->price_per_unit,2,'.',''))."</td>";
                  echo "<td>".$res2->sales_qty."</td>";
                  echo "<td class='text-right'>".$CI->currency(number_format(($res2->price_per_unit * $res2->sales_qty),2,'.',''))."</td>";
                  echo "<td class='text-right'>".$CI->currency($res2->tax_amt)."</td>";
                  echo "<td class='text-right'>".$discount."</td>";
                  echo "<td class='text-right'>".$CI->currency($discount_amt)."</td>";
                  echo "<td class='text-right'>".$CI->currency(number_format($res2->unit_total_cost,2,'.',''))."</td>";
                  echo "<td class='text-right'>".$CI->currency(number_format($res2->total_cost,2,'.',''))."</td>";
                  echo "</tr>";  
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
                <td><?= $CI->currency(number_format($tot_total_cost,2,'.','')) ;?></td>
              </tr>
            </tfoot>
          </table>
                                    </td>
                                </tr>                       
                                <tr style="background-color:#ededed;">
                                    <td colspan="3">
                                     <span style="margin-top:30px;display:block;padding:10px;"> 
                                        <b>  Happy shopping!<br/>
                                        Team Cygen</b> 
                                    </span>
                                     </td> 
                                </tr>
                                <tr>
                                    <td bgcolor="#764c28" style="padding: 30px 30px 30px 30px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="90%">
                                                    In case you need any assistance please do not hesitate to call our customer service on +61 2 8883 5966 10:00 am to 6:00 pm on all days or email us at customerservice@Cygen.com.au 
                                                    All calls to our customer support number will be recorded for internal training and quality purposes.
                                                </td>
                                                <td align="right" width="10%">
                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                                <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                                    <img src="http://cygenpos.com.au/dev/Cygen/assets/images/fb.png" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                                                                </a>
                                                            </td>
                                                            <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                                            <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                                <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                                    <img src="http://cygenpos.com.au/dev/Cygen/assets/images/tw.png" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>