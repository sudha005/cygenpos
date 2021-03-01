<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<title><?= $page_title;?></title>
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?php echo $theme_link; ?>bootstrap/css/bootstrap.min.css">
<style type="text/css">
	body{
		font-family: arial;
		font-size: 16px;
		font-weight: bold;
		padding-top:15px;
		break-after:page;
	}
	@media print {
        .no-print { display: none; }
        .new-page{
  page-break-before: always;
  
}
    }
</style>
</head>
<body><!--   -->
	<?php
	$CI =& get_instance();
	
    $q1=$this->db->query("select * from db_company where id=1 and status=1");
    $res1=$q1->row();
    $company_logo=$res1->company_logo;
    $company_name		=$res1->company_name;
    $company_mobile		=$res1->mobile;
    $company_phone		=$res1->phone;
    $company_email		=$res1->email;
    $company_country	=$res1->country;
    $company_state		=$res1->state;
    $company_city		=$res1->city;
    $company_address	=$res1->address;
    $company_postcode	=$res1->postcode;
    $company_gst_no		=$res1->gst_no;//Goods and Service Tax Number (issued by govt.)
    $company_vat_number		=$res1->vat_no;//Goods and Service Tax Number (issued by govt.)
    $website            =$res1->website; 
  	$q3=$this->db->query("SELECT b.order_number,b.table_number,a.customer_name,a.customer_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,
                           a.opening_balance,a.country_id,a.state_id,
                           a.postcode,a.address,b.sales_date,b.created_time,b.reference_no,
                           b.sales_code,b.sales_note,
                           coalesce(b.grand_total,0) as grand_total,
                           coalesce(b.subtotal,0) as subtotal,
                           coalesce(b.paid_amount,0) as paid_amount,
                           coalesce(b.other_charges_input,0) as other_charges_input,
                           other_charges_tax_id,
                           coalesce(b.other_charges_amt,0) as other_charges_amt,
                           discount_to_all_input,
                           b.discount_to_all_type,
                           coalesce(b.tot_discount_to_all_amt,0) as tot_discount_to_all_amt,
                           coalesce(b.round_off,0) as round_off,
                           b.payment_status

                           FROM db_customers a,
                           db_sales b 
                           WHERE 
                           a.`id`=b.`customer_id` AND 
                           b.`id`='$sales_id' 
                           ");
                           /*GROUP BY 
                           b.`customer_code`*/
    
    $res3=$q3->row();
    $customer_name=$res3->customer_name;
    $customer_mobile=$res3->mobile;
    $customer_phone=$res3->phone;
    $customer_email=$res3->email;
    $customer_country=$res3->country_id;
    $customer_state=$res3->state_id;
    $customer_address=$res3->address;
    $customer_postcode=$res3->postcode;
    $customer_gst_no=$res3->gstin;
    $customer_tax_number=$res3->tax_number;
    $customer_opening_balance=$res3->opening_balance;
    $sales_date=show_date($res3->sales_date);
    $reference_no=$res3->reference_no;
    $created_time=($res3->created_time);
    $sales_code=$res3->sales_code;
    $sales_note=$res3->sales_note;
    $table_number=$res3->table_number;
    $kotNumber =getSingleColumnNameorder($sales_id,'sales_id','kot_number','db_salesitems'); 
    $price_id =getSingleColumnNameorder($sales_id,'sales_id','price_id','db_salespayments');
    if($price_id=='0'){
        $thrd_price='0';
    }elseif($price_id==6){
        $thrd_price='Uber Eats';
    }elseif($price_id==7){
       $thrd_price='Menulog';  
    }elseif($price_id==8){
        $thrd_price='Doordash';  
    }else{
       $thrd_price='0';  
    }
    $subtotal=$res3->subtotal;
    $grand_total=$res3->grand_total;
    $other_charges_input=$res3->other_charges_input;
    $other_charges_tax_id=$res3->other_charges_tax_id;
    $other_charges_amt=$res3->other_charges_amt;
    $paid_amount=$res3->paid_amount;
    $discount_to_all_input=$res3->discount_to_all_input;
    $discount_to_all_type=$res3->discount_to_all_type;
    //$discount_to_all_type = ($discount_to_all_type=='in_percentage') ? '%' : 'Fixed';
    $tot_discount_to_all_amt=$res3->tot_discount_to_all_amt;
    $round_off=$res3->round_off;
    $payment_status=$res3->payment_status;
    $order_number=$res3->order_number;
    
    if($discount_to_all_input>0){
    	$str="($discount_to_all_input%)";
    }else{
    	$str="(Fixed)";
    }

    if(!empty($customer_country)){
      $customer_country = $this->db->query("select country from db_country where id='$customer_country'")->row()->country;  
    }
    if(!empty($customer_state)){
      $customer_state = $this->db->query("select state from db_states where id='$customer_state'")->row()->state;  
    }

    
    ?>
    
	<table class="new-page" width="98%" align="center" style="break-after:page;'>
		
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td width="40%">KOT</td>
						<td><b><?= $kotNumber; ?></b></td>
					</tr>
					<?php
					if($order_number!='0'){
					?>
					<tr>
						<td width="40%">Table</td>
						<td><b><?= $table_number; ?></b></td>
					</tr>
					<?php
					}
					if($thrd_price!='0'){
					?>
						<tr>
						<td width="40%">Order From </td>
						<td><b><?=$thrd_price; ?></b></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td><?= $this->lang->line('name'); ?></td>
						<td><?= $customer_name; ?></td>
					</tr>
					<tr>
						<td>Time;</td>
						<td><?php echo $created_time; ?></td>
					</tr>
				</table>
				
			</td>
		</tr>
		<tr>
			<td>

				<table width="100%" cellpadding="0" cellspacing="0"  >
					<thead>
					<tr style="border-top-style: dashed;border-bottom-style: dashed;border-width: 0.1px;">
						<th style="font-size: 16px; text-align: center;padding-left: 2px; padding-right: 2px;">Qty</th>
						<th style="font-size: 16px; text-align: left;padding-left: 2px; padding-right: 2px;"><?= $this->lang->line('description'); ?></th>
						
						
						
					</tr>
					</thead>
					<tbody style="border-bottom-style: dashed;border-width: 0.1px;">
						<?php
			              $i=0;
			              $tot_qty=0;
			              $subtotal=0;
			              $tax_amt=0;
			              $CAID=implode(",",$kot_cat);
			              $q2=$this->db->query("select a.item_id,b.item_name,a.sales_qty,a.unit_total_cost,a.price_per_unit,a.tax_amt,c.tax,a.total_cost from db_salesitems a,db_items b,db_tax c where c.id=a.tax_id and b.id=a.item_id and a.sales_id='$sales_id' AND a.cat_id IN($CAID) AND 	kot_print=0 ");
			              foreach ($q2->result() as $res2) {
			                  echo "<tr>";  
			                 
			                  echo "<td style='text-align: center;padding-left: 2px; padding-right: 2px;'>".(int)$res2->sales_qty."&nbsp;&nbsp;&nbsp;&nbsp;X&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			                  
			                  echo "<td style='padding-left: 2px; padding-right: 2px;'>".$res2->item_name."</td>";
			                  
			                  echo"</tr>";
			                  
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
                            
                            echo "<td style='text-align: center;padding-left: 2px; padding-right: 2px;'>&nbsp;&nbsp;<span style='font-size:18px'>+</span>&nbsp;&nbsp;".(int)$qty."&nbsp;&nbsp;&nbsp;&nbsp;X&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                            echo "<td style='padding-left: 2px; padding-right: 8px;'>&nbsp;&nbsp;&nbsp;&nbsp;".ucwords(strtolower($addon_name))."</td>";
                            
                           
                            echo "</tr>"; 
                            echo "<tr>";  
                            if($note!='0' && $note!=''){
                            echo "<td style='padding-left: 2px; padding-right: 2px;' valign='top'>Note:</td>";
                            echo "<td class='text-center' solspan='4' style='padding-left: 2px; padding-right: 8px;'>".$note."</td>";
                            }
                            echo "</tr>";          
                            
                            }
                            
                            }
			                  
			                  
			                  
			                  
			                  
			                  
			                  //$tot_qty+=$res2->sales_qty;
			                  $subtotal+=($res2->total_cost);
			                  $tax_amt+=$res2->tax_amt;
			              }
			              
			              
			              
			              
			              
			              
			              
			              $before_tax = $subtotal-$tax_amt;
			              ?>
					
				   </tbody>
				

					</tfoot>
				</table>
			</td>
		</tr>
	</table>
	<center >
  <div class="row no-print">
  <div class="col-md-12">
  <div class="col-md-2 col-md-offset-5 col-xs-4 col-xs-offset-4 form-group">
    <button type="button" id="" class="btn btn-block btn-success btn-xs" onclick="window.print();" title="Print">Print</button>
    <?php if(isset($_GET['redirect'])){ ?>
		<a href="<?= base_url().$_GET['redirect'];?>"><button type="button" class="btn btn-block btn-danger btn-xs" title="Back">Back</button></a>
	<?php } ?>
   </div>
   </div>
   </div>

</center>
<script>
$(document).ready(function(){
    printContent(){
        $('body').show();
        window.print();
    };
setTimeout(function() { printContent; }, 100);
});
</script>
</body>
</html>