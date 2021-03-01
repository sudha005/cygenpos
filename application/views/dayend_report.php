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
		font-size: 12px;
		/*font-weight: bold;*/
		padding-top:15px;
	}
 	@media print {
        .no-print { display: none; }
    }
</style>
</head>
<body onload="window.print();"><!--   -->
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
    $currentdate=date('Y-m-d');
    //echo "select SUM(a.tot_discount_to_all_amt) as total_discount,SUM(a.other_charges_amt) as other_charges_amt,SUM(b.sales_qty) as total_items,SUM(a.grand_total) as total_sale,AVG(a.grand_total) as avg_sale,Count(a.customer_id) as total_customer,count(a.id) as total_order from db_sales a INNER JOIN db_salesitems b ON  a.id=b.sales_id WHERE a.payment_status='Paid' AND DATE(a.sales_date)='$currentdate'";
     $sql_sale_summery=$CI->db->query("select SUM(a.tot_discount_to_all_amt) as total_discount,SUM(a.other_charges_amt) as other_charges_amt,SUM(a.grand_total) as total_sale,AVG(a.grand_total) as avg_sale,Count(a.customer_id) as total_customer,count(a.id) as total_order from db_sales a  WHERE a.payment_status='Paid' AND DATE(a.sales_date)='$currentdate' ");
     $row_data_summery=$sql_sale_summery->row_array();
     $total_sale = $row_data_summery['total_sale'];
     $total_customer = $row_data_summery['total_customer'];
     $total_order = $row_data_summery['total_order'];
     
     $total_discount =$row_data_summery['total_discount']!=''?$row_data_summery['total_discount']:'0.0';
     $other_charges_amt =$row_data_summery['other_charges_amt']!=''?$row_data_summery['other_charges_amt']:'0.0';
     $avg_sale =number_format($row_data_summery['avg_sale'],2);
     
      $sql_sale_summery11=$CI->db->query("select SUM(a.tot_discount_to_all_amt) as total_discount,SUM(a.other_charges_amt) as other_charges_amt,SUM(b.sales_qty) as total_items,SUM(a.grand_total) as total_sale,AVG(a.grand_total) as avg_sale,Count(a.customer_id) as total_customer,count(a.id) as total_order from db_sales a INNER JOIN db_salesitems b ON  a.id=b.sales_id WHERE a.payment_status='Paid' AND DATE(a.sales_date)='$currentdate' ");
     $row_data_summery11=$sql_sale_summery11->row_array();
     $total_item_qty = $row_data_summery11['total_items'];
    
     
    
     
    ?>
	<table width="98%" align="center">
        <tr>
            <td align="center">
            
            <h1><?php echo $company_name;?> </h1>
            </span>
            </td>
        </tr>
        <tr>
            <td align="center">
                <h3>Sales Summary</h3>
            </td>
        </tr>
        <tr>
            <td>
               Order AVG 
            </td>
            <td>
               <?php echo $total_order; ?>  
            </td>
        </tr>
        <tr>
            <td>
               Customer AVG
            </td>
            <td>
               <?php echo $total_customer; ?>  
            </td>
        </tr>
        <tr>
            <td>
               Total sales 
            </td>
            <td>
               <?php echo $total_sale ; ?>  
            </td>
        </tr>
          <tr>
            <td>
              Number's Of Items
            </td>
            <td>
               <?php echo (int)$total_item_qty ; ?>  
            </td>
        </tr>
        <tr>
            <td>
             Total Discount
            </td>
            <td>
               <?php echo $total_discount ; ?>  
            </td>
        </tr>
        <tr>
            <td>
              Total Other Charges 
            </td>
            <td>
               <?php echo $other_charges_amt ; ?>  
            </td>
        </tr>
        <tr>
            <td>
              Order Average
            </td>
            <td>
               <?php echo $avg_sale ; ?>  
            </td>
        </tr>
        <tr>
            <td align="center">
                <h3>Hourly Sales</h3>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
                <table width='100%'>
                    <tr><td>Hour</td><td>Customer AVG</td><td>Order Average</td><td>Total sales</td></tr>
                <?php
                $sql_sale_summery2=$CI->db->query("select HOUR(TIME(a.created_time)) AS Hour,SUM(a.tot_discount_to_all_amt) as total_discount,SUM(a.other_charges_amt) as other_charges_amt,SUM(a.grand_total) as total_sale,AVG(a.grand_total) as avg_sale,Count(a.customer_id) as total_customer,count(a.id) as total_order from db_sales a where  a.payment_status='Paid' AND DATE(a.sales_date)='$currentdate' GROUP BY Hour ");
                $row_data_summery22=$sql_sale_summery2->result_array();
                
                foreach($row_data_summery22 as $row_data_summery2){
                $total_sale2 = $row_data_summery2['total_sale'];
                $total_customer2 = $row_data_summery2['total_customer'];
                $total_order2 = $row_data_summery2['total_order'];
                $total_discount2 =$row_data_summery2['total_discount'];
                $other_charges_amt2 =$row_data_summery2['other_charges_amt'];
                $avg_sale2 =$row_data_summery2['avg_sale'];
                $avg_hr =$row_data_summery2['Hour'];
                ?>
                 <tr><td><?php echo $avg_hr; ?></td><td><?php echo $total_customer2; ?></td><td><?php echo $total_order2; ?></td><td><?php echo $total_sale2; ?></td></tr>
                <?php
                }
                ?>
                </table>
            </td>
        </tr>
        
        <tr>
            <td align="center">
                <h3>Category  Sales</h3>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
                <table width='100%'>
                    <tr><td>Category</td><td>Qty</td><td>Total sales</td></tr>
                <?php
                $sql_sale_summery33=$CI->db->query("select b.cat_id as category,SUM(b.sales_qty) as total_qty,SUM(b.total_cost) as total_cost from db_sales a,db_salesitems b where a.id=b.sales_id AND a.payment_status='Paid' AND DATE(a.sales_date)='$currentdate' AND b.cat_id!='0' GROUP BY b.cat_id ");
                $row_data_summery222=$sql_sale_summery33->result_array();
                
                foreach($row_data_summery222 as $row_data_summery2222){
                
                $total_cost =$row_data_summery2222['total_cost'];
                $total_qty =$row_data_summery2222['total_qty'];
                $category =$row_data_summery2222['category'];
                $cat=getSingleColumnName($category,'id','category_name','db_category')
                ?>
                 <tr><td><?php echo $cat; ?></td><td><?php echo (int)$total_qty; ?></td><td><?php echo $total_cost; ?></td></tr>
                <?php
                }
                ?>
                </table>
            </td>
        </tr>
         <tr>
            <td align="center">
                <h3>Payment  Sales</h3>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
                <table width='100%'>
                    <tr><td>Payment</td><td>Amount</td></tr>
                <?php
                $sql_sale_summery33=$CI->db->query("select b.payment_type as payment_type,SUM(b.payment) as payment from db_sales a,db_salespayments b where a.id=b.sales_id AND a.payment_status='Paid' AND DATE(a.sales_date)='$currentdate'  GROUP BY b.payment_type ");
                $row_data_summery222=$sql_sale_summery33->result_array();
                
                foreach($row_data_summery222 as $row_data_summery2222){
                
                $payment_type =$row_data_summery2222['payment_type'];
                $payment =$row_data_summery2222['payment'];
               
                ?>
                 <tr><td><?php echo $payment_type; ?></td><td><?php echo $payment; ?></td></tr>
                <?php
                }
                ?>
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
</body>
</html>