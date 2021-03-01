<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<?php include"comman/code_css_form.php"; ?>
<!-- iCheck -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/iCheck/pos.css">
<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>
.radio-toolbar input[type="radio"] {
  opacity: 0;
  position: fixed;
  width: 0;
}
.group-icon-btn-img-dual{
   height: 25px;
    display: block;
    margin: 0px auto 0px; 
}
.radio-toolbar {
  margin: 10px 0;
      display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.radio-toolbar input[type="radio"] {
  opacity: 0;
  position: fixed;
  width: 0;
}

.radio-toolbar label {
    display: inline-block;
    background-color: #fff;
    padding: 10px 1vw;
    margin: 5px;
    font-size: 1.1vw;
    border: 1px solid #0479d0;
    border-radius: 4px;
    color: #057ad1;
    font-weight: 500;
}

.radio-toolbar label:hover {
     background-color: #067dce;
    color: #fff;
}

.radio-toolbar input[type="radio"]:focus + label {
    border: 2px dashed #444;
}

.radio-toolbar input[type="radio"]:checked + label {
    background-color: #bfb;
    border-color: #4c4;
}   
.trash-icon{
        font-size: 1.5vw;
    color: #f42f2c;
    font-weight: 600;
}
 .borderclass{
border:1px solid #000!important;
 } 
 
 
.come-from-modal.left .modal-dialog,
.come-from-modal.right .modal-dialog {
    position: fixed;
    margin: auto;
   width:60%;
   
    -webkit-transform: translate3d(0%, 0, 0);
    -ms-transform: translate3d(0%, 0, 0);
    -o-transform: translate3d(0%, 0, 0);
    transform: translate3d(0%, 0, 0);
}

.come-from-modal.left .modal-content,
.come-from-modal.right .modal-content {
    height: 100%;
    overflow-y: auto;
    border-radius: 0px;
}




.come-from-modal.right.fade.in .modal-dialog {
    right: 0;
} 
 
 
 
 
 
 
 
 
 
</style>
</head>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body id="" >


  <?php $CI =& get_instance(); ?>
    <?php
    if($this->session->userdata('store_login')!="" && $this->session->userdata('store_login')!=""){
    $store_login=$this->session->userdata('store_login');
    }else{
    $store_login='';
    }
    if($store_login){
        
    $SITE_TITLE  = getSingleColumnName($store_login,'id','store_name','db_store');
    
    }else{
        
    $SITE_TITLE=$SITE_TITLE;
    
    }
    ?>
  
<div class="" id="">
  <?php $css = ($this->session->userdata('language')=='Arabic' || $this->session->userdata('language')=='Urdu') ? 'margin-right: 0 !important;': '';?>

  <!-- Content Wrapper. Contains page content -->
  <div class="" style="<?=$css;?>">
    <!-- Content Header (Page header) -->
   <!--  <section class="content-header">
      <h1>
        General Form Elements
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
      </ol>
    </section> -->

    <!-- **********************MODALS***************** -->
    <?php include"modals/modal_customer.php"; ?>
    <?php include"modals/modal_sales_item.php"; ?>
    <!-- **********************MODALS END***************** -->
    <!-- Main content -->
    <section class=" new-padding-content">
      <div class="row new-margin">
                  <div class="row-same top-btn-row">
                                          <div class="col dropdown" >
                      
                      <button type="button" name="" class="group-icon-btn" title="Table Top Order" data-toggle="dropdown">
                       <i class="las la-concierge-bell"></i>
                      Table Top Order
                    </button>
                    <span  class="circle pulse  pushval3 instore_count">0</span>
                    <div class="dropdown-menu" role="menu" aria-labelledby="menu1">
 <table class="table table-hover">
    <thead>
      <tr>
        <th>Ord ID</th>
        <th>Ord Date</th>
        <th>Amount</th>
        <th>Bill</th>
      </tr>
    </thead>
    <tbody id="instore_order_ajax_body">
        
         

    </tbody>
  </table>
    </div>
                    </div>  
                   
                    <div class="col dropdown" >
                        
                      <button type="button"  name="" class="group-icon-btn" title="Take Away" data-toggle="dropdown">
                      <i class="las la-shopping-bag"></i>
                     Take Away
                    </button>
                    <span  class="circle pulse  pushval3 storepickup_count">0</span>
                                        <div class="dropdown-menu" role="menu" aria-labelledby="menu1">
 <table class="table table-hover">
    <thead>
      <tr>
        <th>Ord ID</th>
        <th>Ord Date</th>
        <th>Amount</th>
        <th>Bill</th>
         <th>KOT</th>
      </tr>
    </thead>
    <tbody id="storepickup_tbody">
      
    </tbody>
  </table>
    </div>
                    </div>
                   
                    <div class="col dropdown">
                   <button  type="button"   class="group-icon-btn" title="Discount" data-toggle="dropdown">
              <i class="las la-motorcycle"></i>Delivery</button>
              <span  class="circle pulse pushval3 online_count">0</span>
                <div class="dropdown-menu" role="menu" aria-labelledby="menu1">
 <table class="table table-hover">
    <thead>
      <tr>
        <th>Ord ID</th>
        <th>Ord Date</th>
        <th>Amount</th>
        <th>Bill</th>
      </tr>
    </thead>
    <tbody id="online_order_ajax_tbody">
     
    </tbody>
  </table>
    </div>
              
              
                        </div>
                    <div class="col">
                      <button type="button" id="" name="" class="group-icon-btn" title="Reservation">
                         <i class="las la-chair"></i>
                             Reservation
                          </button>
                          
                    </div>
                    
             <!--       <div class="col" >
                        <?php if(isset($sales_id)){ $btn_id='update';$btn_name="Cash"; ?>
                    <input type="hidden" name="sales_id" id="sales_id" value="<?php echo $sales_id;?>"/>
                  <?php } else{ $btn_id='save';$btn_name="Cash";} ?>
                      <button  type="button" id="<?php echo "show_cash_modal";?>" name="" class="group-icon-btn ctrl_c" title="By Cash & Save [Ctrl+C]">
                           <span class="fa fa-money" aria-hidden="true"></span>
                             <?php echo $btn_name;?>
                          </button>
                    </div>-->
                     <div class="col dropdown">
                        
                      <button type="button"   class="group-icon-btn" title="Catering" data-toggle="dropdown">
                <i class="las la-utensils"></i>
                       Catering
                    </button>
                                                         <div class="dropdown-menu" role="menu" aria-labelledby="menu1">
 <table class="table table-hover">
    <thead>
      <tr>
        <th>Ord ID</th>
        <th>Ord Date</th>
        <th>Amount</th>
        <th>Bill</th>
      </tr>
    </thead>
    <tbody>
     
    </tbody>
  </table>
    </div>
             
                    </div>
                    <div class="col">
                      <a style="cursor:pointer"   class="group-icon-btn quick_id_clk third_party_order" title="Uber Eats " id='6'>
<i class="lab la-uber"></i>
                       Uber Eats 
                    </a>
                                                        
             
                    </div>  
                   
          <!--          <div class="col" >
                      <button type="button"  name="" class="group-icon-btn " title="Hold" data-toggle="modal" data-target="#holdmodal">
                      <span class="lnr lnr-question-circle"></span>
                       <?= $this->lang->line('hold_list'); ?>
                       <em class=" hold_invoice_list_count"><?=$tot_count?></em>
                    </button>
                    </div>-->
                   
                   
                   <div class="col" >
                      <a style="cursor:pointer"  name="" class="group-icon-btn third_party_order" id='7'>
                          <span class="fa fa-money" aria-hidden="true"></span>
                    Menulog
                    </a>
                    </div>
                         <div class="col" >
                      <a style="cursor:pointer"  name="" class="group-icon-btn third_party_order" id='8'>
                          <span class="fa fa-money" aria-hidden="true"></span>
                      Doordash
                    </a>
                    </div>
                     <div class="col d-none" >
                      <button type="button"  name="" class="group-icon-btn " title="Staff">
                         <i class="las la-user-friends"></i>
                    Staff
                    </button>
                    </div> 
                 
                 
                 
                 
               <div class="col dropdown">
                   <button  type="button"   class="group-icon-btn" title="Coupons" data-toggle="dropdown">
              <i class="las la-tags"></i>Coupons</button>
              
                <div class="dropdown-menu" role="menu" aria-labelledby="menu1" style="margin-left:-70px;">
 <table class="table table-hover">
    <thead>
      <tr>
        <th>Name</th>
        <th>Code</th>
        <th>Offer</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="coupon_order_ajax_tbody">
     <?php
$str = '';
$q2 = $this
    ->db
    ->query("select id,coupon,coupon_name,coupon_offertext   from db_coupon  where status=1  order by id desc limit 0,15");
if ($q2->num_rows() > 0)
{
    foreach ($q2->result() as $res2)
    {
        
        $bill = base_url() . 'pos?orderId=' . $res2->id;

        $str = $str . "<tr>";
        $str = $str . "<td>" . $res2->coupon_name . "</td>";
        $str = $str . "<td>" . $res2->coupon . "</td>";
        $str = $str . "<td>" . $res2->coupon_offertext . "%</td>";

        $str = $str . "<td>";
        $str = $str . '<a  coupon_percent="'.$res2->coupon_offertext.'" coupon_id="' . $res2->id . '" class="coupon_btn btn btn-primary btn-xs" style="cursor: pointer;font-size: 20px;"  title="apply coupon?">Apply</a>';
        $str = $str . "</td>";
        
        $str = $str . "</tr>";

    } //for end
    
} //if num_rows() end
else
{

    $str = $str . "<tr>";
    $str = $str . '<td colspan="4" class="text-danger text-center">No Records Found</td>';
    $str = $str . '</tr>';

}
echo $str;
?>

    </tbody>
  </table>
    </div>
              
              
                        </div>  
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
<!--                   <div class="col" >
                     <a href="" name=""  class="group-icon-btn" title="refund">
                      <?php print ucfirst($this->session->userdata('inv_username')); ?>
                   </a>
                    </div>-->
                           <div class="col" >
                       <a onclick="print_dashboard();" style="cursor:pointer"  class="group-icon-btn"><i class="las la-object-group"></i>Dashboard</a>
                    </div>
                     <div class="col" >
                        
                       <a style="cursor:pointer" class="group-icon-btn signout"><i class="las la-sign-out-alt">
                           
                       </i>Sign out</a>
                       
                    </div>
                     
               <!--         <div class="col">
                       
                       
                        <img src="https://chickycharchar.com.au/assets/images/logo-loader.png" class="img-responsive client-logo">
                 
                    </div>-->
        
                
                          
                  </div>
        <!-- left column -->
        <div class="col-md-5 col-sm-12 col-sx-12  pl-0 pr-5 pos-left">
<!--         <div class="order-table-grid">
             
             <div class="order-table-layout">
                 
                 <div class="order-box-grid-pos position-relative">
                     <p class="order-p-pos">Ord <span>1234567890</span></p>
                        <p class="table-p-pos mb-0">Table <span>12</span></p>
                        <div class="overlay-div">
                            
                            <h1>mukund kumar</h1>
                        </div>
                 </div>
                 
                 
                       <div class="order-box-grid-pos">
                     <p class="order-p-pos">Ord <span>1234567890</span></p>
                        <p class="table-p-pos mb-0">Table <span>12</span></p>
                 </div>
                 
             </div>
             
         </div>-->
          <!-- general form elements -->
          <div class="">
            <!-- form start -->
            <form class="form-horizontal" id="pos-form" >
            <div class="" >
              <div class="row new-margin" >
                <div class="col-md-12" >
              
                  <!-- <div class="col-md-4 pull-right" >
                  <div class="form-group">
                     <select class="form-control select2" id="warehouse_id" name="warehouse_id"  style="width: 100%;" onkeyup="shift_cursor(event,'mobile')">
                          <?php
                             $query1="select * from db_warehouse where status=1";
                             $q1=$this->db->query($query1);
                             if($q1->num_rows($q1)>0)
                                { 
                                  
                                  foreach($q1->result() as $res1)
                                {
                                  $selected=($warehouse_id==$res1->id) ? 'selected' : '';
                                  echo "<option $selected  value='".$res1->id."'>".$res1->warehouse_name ."</option>";
                                }
                              }
                              else
                              {
                                 ?>
                          <option value="">No Records Found</option>
                          <?php
                             }
                             ?>
                       </select>
                    <span id="warehouse_id_msg" style="display:none" class="text-danger"></span>
                  </div>
                </div> -->
                <?php if(isset($sales_id)): ?>
                  <?php if($CI->permissions('sales_add')) { ?>
                  <div class="col-md-4 pull-right">
                    <a href='<?= $base_url;?>pos' class="btn btn-primary pull-right">New Invoice</a>
                  </div>
                  <?php } ?>
                <?php endif; ?>
                
              </div>
              </div>
          </div>
            <!-- /.box-header -->
            
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" value='0' id="hidden_rowcount" name="hidden_rowcount">
              <input type="hidden" value='' id="hidden_invoice_id" name="hidden_invoice_id">
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">

               <input type="hidden" value='' id="temp_customer_id" name="temp_customer_id">
               <input type="hidden" value='0' id="hidden_lastitem" name="hidden_lastitem">
               <input type="hidden" value='0' id="hidden_lastprice" name="hidden_lastprice">
               <input type="hidden" value='0' id="hidden_refund_item" name="hidden_refund_item">
               <input type="hidden" value='0' id="hidden_refund_type" name="hidden_refund_type">
                <input type="hidden"  id="hidden_order_id" name="hidden_order_id" value="<?php echo $orderId!=''?$orderId:'0'; ?>">
                <input type="hidden"  id="order_payment_status" name="order_payment_status" value="0">
                <input type="hidden"  id="print_bill_id" name="print_bill_id" value="0">
              <!-- **********************MODALS***************** -->
             <?php include"modals_pos_payment/modal_payments_multi.php"; ?>
              <!-- **********************MODALS END***************** -->
              <!-- **********************MODALS***************** -->
              <div class="modal fade" id="discount-modal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Set Discount</h4>
                    </div>
                    <div class="modal-body">
                      
                        <div class="row">
                          <div class="col-md-6">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="discount_input">Discount</label>
                                <input type="text" class="form-control" id="discount_input" name="discount_input" placeholder="" value="0">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="discount_type">Discount Type</label>
                                <select class="form-control" id='discount_type' name="discount_type">
                                  <option value='in_percentage'>Per%</option>
                                  <option value='in_fixed'>Fixed</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                     
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary discount_update">Update</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
              <!-- **********************MODALS END***************** -->

                <div class="separator-box-new cal-height-left">
                    <?php 
                    
                        if($orderId=="" || $orderId=='0'){
                        $cashier_id=$this->session->userdata('inv_userid');
                        $zerorow=$this->db->query("select count(*) as total_qty ,sum(total_price) as total_amount,total_discount as all_discount from db_poscart_all WHERE cashier_id='$cashier_id' ");
                        $newd=$zerorow->num_rows();
                        $row_data=$zerorow->row_array();
                        $qty_card = $row_data['total_qty'];
                        $discount_all=$row_data['all_discount'];
                        $zerorow2=$this->db->query("select count(*) as total_qty2 ,sum(total_price) as total_amount2 from db_pos_cart_addon  where cashier_id='$cashier_id'");
                        $newd2=$zerorow2->num_rows();
                        $row_data2=$zerorow2->row_array();
                        $all_amount = ($row_data['total_amount']+$row_data2['total_amount2'])-$discount_all;
                        
                        
                        }else{
                          $cashier_id=$this->session->userdata('inv_userid');
                        $zerorow=$this->db->query("select sum(grand_total) as total_amount from db_sales WHERE id='$orderId' ");
                        $newd=$zerorow->num_rows();
                        $row_data=$zerorow->row_array();
                        
                        $zerorow2=$this->db->query("select sum(total_price) as total_amount2 from db_sales_addon_detail  where 	sales_id='$orderId'");
                        $newd2=$zerorow2->num_rows();
                        $row_data2=$zerorow2->row_array();
                        $all_amount = $row_data['total_amount'];  
                        
                         $zerorow3=$this->db->query("select sum(sales_qty) as total_qty from db_salesitems  where 	sales_id='$orderId'");
                        $newd3=$zerorow3->num_rows();
                        $row_data3=$zerorow3->row_array();
                        $qty_card = $row_data3['total_qty'];  
                        
                        
                        }
                    ?>



                              <div class="row counter-footer m-0" id="amount_count_sub">
                  <div class="col-md-1 text-center p-0">
                      <div class=conter-box>
                          <label> <?= ('QTY'); ?>:</label>
                          <span class="text-bold tot_qty"><?php echo $qty_card!=""?$qty_card:'0' ?></span>
                          </div>
                  </div>
                  <div class="col-md-11 pl-1 pr-0">
                  <div class="row-same mb-0">
                  <div class="col pr-1 pl-1">
                      <div class=conter-box>
                          <label><?= ('Amount'); ?>:</label>
                          <?= $CI->currency('<span  class="tot_amt text-bold">'.($all_amount+$discount_all).'</span>');?>
                          </div>
                  </div>
                  <div class="col pr-1 pl-1">
                      <div class=conter-box>
                          <label><?= (' Discount'); ?></label>
                          <?= $CI->currency('<span  class="tot_discount_amt text-bold">'.($discount_all).'</span>');?>
                          </div>
                  </div>
                   <div class="col pr-1 pl-1">
                       <div class=conter-box>
                          <label> <?= ('Tax'); ?>:</label>
                          
                          <?= $CI->currency('<span  class="total_tax text-bold">0.00</span>');?>
                          </div>
                  </div>
                  <div class="col pr-1 pl-1">
                      <div class=conter-box>
                          <label><?= $this->lang->line('total'); ?>:</label>
                          <?= $CI->currency('<span  class="tot_grand text-bold">'.($all_amount).'</span>');?>
                          </div>
                  </div>
                  </div>
                  </div>
                </div>
                    <div class="clearfix"></div>
          <!--    <div class="row m-0 mt-5">
  
                <div class="col-md-7 btm-5 ">
                  <div class="input-group autosearitem">
                    <span class="input-group-addon" title="Select Items"><i class="fa fa-barcode"></i></span>
                     <input type="text" class="form-control" placeholder="Item name/Barcode/Itemcode" id="item_search">
                  </div>
                </div>  
                
              </div>--><!-- row end -->

              <div class="row new-margin">
                <div class="col-md-12 p-0">
                  <div class="">
                    <div class="col-sm-12 position-relative p-0">
               <!--         <ul class="plus-minus-icon">
                        <li><a onclick="scrolldown()"><span class="lnr lnr-chevron-up-circle"></span></a></li>
                        <li><a onclick="scrollup()"><span class="lnr lnr-chevron-down-circle"></span></a></li>
                        </ul>-->
                      <table class="table  table-responsive items_table" style="">
                        <thead class="bg-primary">
                         <!-- <th width="5%">#</th>-->
                          <th width="50%">Item Name</th>
                          <!--<th width="10%"><?= $this->lang->line('stock'); ?></th>-->
                          <th width="10%">&nbsp;</th>
                          <th width="15%" class="text-center"> Price</th>
                          <th width="15%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Qty</th>
                          
                          <th width="15%" class="text-center">Amount</th>
                          <th width="15%" class="text-center">delete</th>
                          
                          
                        </thead>
                        <tbody id="pos-form-tbody" style="overflow-y:scroll;">
                          <!-- body code -->
                      <?php
                      if($orderId=="" || $orderId=='0'){
                         
                         $zerorow=$this->db->query("select * from db_poscart_all WHERE cashier_id='$cashier_id'  order by id desc ");
                         $newd=$zerorow->num_rows();
                         $row_data=$zerorow->result_array();
                         $o=0;
                          foreach($row_data as $row){
                            ?>
                           <tr class="car_<?php echo $row['item_id']; ?>" id="row_0" data-row="0" data-item-id="<?php echo $row['item_id']; ?>">
   <!--<td class="srl_number"><?php echo $newd-$o; ?></td>-->
   <td style="width:50%" class="caritemname_<?php echo $row['item_id']; ?>" id="td_0_0"><a class="pointer item-name-pos text-truncate" id="td_data_0_0"><?php echo substr($row['item_name'],0,35).'...'; ?></a> <span id="spandesc<?php echo $row['item_id']; ?>"></span><i rowcnt="0" id="<?php echo $row['item_id']; ?>" class="edit-icon short_desc fa fa-pencil-square-o" aria-hidden="true&quot;"></i></td>
   <td style="display:none" id="td_0_1">1500000.00</td>
   
   <td id="td_0_3" class="text-right"><input id="sales_price_0" onblur="set_to_original(0,<?php echo $row['price']; ?>)" onclick="show_discount_item_modal(0)" onkeyup="update_price(0,<?php echo $row['total_price']; ?>)" name="sales_price_0" type="text" class="form-control no-padding " value="<?php echo $row['price']; ?>"></td>
  <td id="td_0_2">
      <div class="input-group input-group-sm"><span class="input-group-btn"><button id="dr0" onclick="decrement_qty(<?php echo $row['item_id']; ?>,0)" type="button" class="counter-increment"><i class="lnr lnr-circle-minus"></i></button></span><input readonly="readonly" typ="text" value="<?php echo $row['qty']; ?>" class="form-control no-padding text-center qty-incr-control" id="item_qty_<?php echo $row['item_id']; ?>" name="item_qty_<?php echo $row['item_id']; ?>"><span class="input-group-btn"><button id="in0" onclick="increment_qty(<?php echo $row['item_id']; ?>,0)" type="button" class="counter-increment"><i class="lnr lnr-plus-circle"></i></button></span></div>
   </td>
   <td style="display:none" id="td_0_11"><input data-toggle="tooltip" title="Click to Change" id="td_data_0_11" onclick="show_sales_item_modal(0)" name="td_data_0_11" type="text" class="form-control no-padding pointer" readonly="" value="0.00"></td>
   <td id="td_0_4" class="text-right caritemprice_<?php echo $row['item_id']; ?>"><input data-toggle="tooltip" title="Total" id="td_data_0_4" name="td_data_0_4" type="text" class="form-control no-padding pointer" readonly="" value="<?php echo $row['total_price']; ?>"></td>
   <td style="display:none" id="td_0_8" class="text-right"><input type="text" name="td_data_0_8" id="td_data_0_8" class="form-control text-right no-padding only_currency text-center item_discount " value="0"></td>
   <td style="display:none" id="td_0_5"><a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="removerow(0)" title="Delete Item?"></a></td>
   <input type="hidden" name="tr_item_id_0" id="tr_item_id_0" value="<?php echo $row['item_id']; ?>">
   <input type="hidden" id="tr_sales_price_temp_0" name="tr_sales_price_temp_0" value="<?php echo $row['total_price']; ?>">
   <input type="hidden" id="tr_sales_price_temp2_0" name="tr_sales_price_temp2_0" value="<?php echo $row['total_price']; ?>">
   <input type="hidden" id="tr_tax_type_0" name="tr_tax_type_0" value="Exclusive">
   <input type="hidden" id="tr_tax_id_0" name="tr_tax_id_0" value="4">
   <input type="hidden" id="tr_tax_value_0" name="tr_tax_value_0" value="0.00"><input type="hidden" id="description_0" name="description_0" value=""><input type="hidden" id="refund_id_0" name="refund_id_0" value="0">
   <input type="hidden" id="refund_type_0" name="refund_type_0" value="0">
   <td width="10%" class="text-center "><span style="cursor:pointer;"  onclick="remove_item(<?php echo $row['id']; ?>)" class="lnr lnr-trash trash-icon"></span></td>
</tr>
<?php
	$addonaall=0;
	$item_ids=$row['item_id'];
	 $sql_addon_query=$this->db->query("select * from db_pos_cart_addon where item_id='$item_ids'");
	 $sql_addon=$sql_addon_query->result_array();

	 foreach($sql_addon as $addon_row){
		 $addonaall=$addonaall+$addon_row['total_price'];
   ?>
	<tr>
	
	<td><span style="color:#337ab7;margin-left:10px"><?php echo $addon_row['addon_name']; ?></span></td>

	<td><span class="text-center" style="color:#337ab7"><center><?php echo $addon_row['total_price']; ?></center></span></td>
    	<td><div class="input-group input-group-sm"><span class="input-group-btn"><button id="dr0" onclick="decrement_qty_addon(<?php echo $addon_row['id']; ?>,0)" type="button" class="counter-increment"><i class="lnr lnr-circle-minus"></i></button></span><input readonly="readonly" typ="text" value="<?php echo $addon_row['qty']; ?>" class="form-control no-padding text-center qty-incr-control" id="item_qty_addon<?php echo $addon_row['id']; ?>" name="item_qty_<?php echo $addon_row['id']; ?>"><span class="input-group-btn"><button id="in0" onclick="increment_qty_addon(<?php echo $addon_row['id']; ?>,0)" type="button" class="counter-increment"><i class="lnr lnr-plus-circle"></i></button></span></div></td>
	<td><span class="text-center" style="color:#337ab7"><center><?php echo $addon_row['total_price']; ?></center></span></td>
	<td width="10%" class="text-center "><span style="cursor:pointer;"  onclick="remove_item_addon(<?php echo $addon_row['id']; ?>)" class="lnr lnr-trash trash-icon"></span></td>
	</tr>
	<?php
	 }
                           
                            
                            $o++;
                          }
                          ?>
                          
    <?php
                      }else{
    ?>
    <?php
    $zerorow_sale=$this->db->query("select * from db_salesitems WHERE sales_id='$orderId'  order by id desc ");
$newd_sale=$zerorow_sale->num_rows();
$row_ord_data_sale=$zerorow_sale->result_array();
$o=0;
foreach($row_ord_data_sale as $row_ord){
$item_name = getSingleColumnName($row_ord['item_id'],'id','item_name','db_items');
?>
<tr class="car_<?php echo $row_ord['item_id']; ?>"  data-row="0" data-item-id="<?php echo $row_ord['item_id']; ?>">
<!--<td class="srl_number"><?php echo $newd_sale-$o; ?></td>-->
<td style="width:50%" class="caritemname_<?php echo $row_ord['item_id']; ?>"><a class="pointer item-name-pos text-truncate" id="td_data_0_0"><?php echo substr($item_name,0,35).'...'; ?></a> <span id="spandesc<?php echo $row_ord['item_id']; ?>"></span><i rowcnt="0" id="<?php echo $row_ord['item_id']; ?>" class="edit-icon short_desc fa fa-pencil-square-o" aria-hidden="true&quot;"></i></td>
<td style="display:none" >1500000.00</td>
 <td id="td_0_3" class="text-right"><input id="sales_price_0"  name="sales_price_0" type="text" class="form-control no-padding " value="<?php echo $row_ord['price_per_unit']; ?>"></td>
  <td id="td_0_2">
      <div class="input-group input-group-sm"><span class="input-group-btn"><button id="dr0<?php echo $row_ord['item_id']; ?>"  type="button" class="counter-increment"><i class="lnr lnr-circle-minus"></i></button></span><input readonly="readonly" typ="text" value="<?php echo $row_ord['sales_qty']; ?>" class="form-control no-padding text-center qty-incr-control" id="item_qty_<?php echo $row['item_id']; ?>" name="item_qty_<?php echo $row['item_id']; ?>"><span class="input-group-btn"><button id="in0"  type="button" class="counter-increment"><i class="lnr lnr-plus-circle"></i></button></span></div>
   </td>

<td style="display:none" ><input data-toggle="tooltip" title="Click to Change" id="td_data_0_11<?php echo $row_ord['item_id']; ?>" onclick="show_sales_item_modal(0)" name="td_data_0_11" type="text" class="form-control no-padding pointer" readonly="" value="0.00"></td>
<td id="td_0_4" class="text-right caritemprice_<?php echo $row_ord['item_id']; ?>"><input data-toggle="tooltip" title="Total" id="td_data_0_4" name="td_data_0_4" type="text" class="form-control no-padding pointer" readonly="" value="<?php echo $row_ord['total_cost']; ?>"></td>
<td style="display:none"  class="text-right"><input type="text" name="td_data_0_8" id="td_data_0_8<?php echo $row_ord['item_id']; ?>" class="form-control text-right no-padding only_currency text-center item_discount " value="0"></td>
<td style="display:none"><a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="removerow(0)" title="Delete Item?"></a></td>
<input type="hidden" name="tr_item_id_<?php echo $row_ord['item_id']; ?>" id="tr_item_id_<?php echo $row_ord['item_id']; ?>" value="<?php echo $row_ord['item_id']; ?>">
<input type="hidden" id="tr_sales_price_temp_<?php echo $row_ord['item_id']; ?>" name="tr_sales_price_temp_0" value="<?php echo $row_ord['total_cost']; ?>">
<input type="hidden" id="tr_sales_price_temp2_<?php echo $row_ord['item_id']; ?>" name="tr_sales_price_temp2_0" value="<?php echo $row_ord['total_cost']; ?>">
<input type="hidden" id="tr_tax_type_<?php echo $row_ord['item_id']; ?>" name="tr_tax_type_<?php echo $row_ord['item_id']; ?>" value="Exclusive">
<input type="hidden" id="tr_tax_id_<?php echo $row_ord['item_id']; ?>" name="tr_tax_id_<?php echo $row_ord['item_id']; ?>" value="4">
<input type="hidden" id="tr_tax_value_<?php echo $row_ord['item_id']; ?>" name="tr_tax_value_<?php echo $row_ord['item_id']; ?>" value="0.00"><input type="hidden" id="description_<?php echo $row_ord['item_id']; ?>" name="description_0" value=""><input type="hidden" id="refund_id_0" name="refund_id_0" value="0">
<input type="hidden" id="refund_type_<?php echo $row_ord['item_id']; ?>" name="refund_type_<?php echo $row_ord['item_id']; ?>" value="0">
<td width="10%" class="text-center "><span style="cursor:pointer;"   class="lnr lnr-trash trash-icon"></span></td>
</tr>
<?php
$addonaall=0;
$item_ids=$row_ord['item_id'];
$sales_id_ord =$row_ord['sales_id'];
$sql_addon_query=$this->db->query("select * from db_sales_addon_detail where item_id='$item_ids'  AND  sales_id='$sales_id_ord'");
$sql_addon=$sql_addon_query->result_array();

foreach($sql_addon as $addon_row){
$addonaall=$addonaall+$addon_row['total_price'];
$addon_name =getSingleColumnName($addon_row['addon_id'],'id','modifier_name','db_modifier'); 
?>
<tr>

<td><span style="color:#337ab7;margin-left:10px"><?php echo $addon_name; ?></span></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><span class="text-center" style="color:#337ab7"><center><?php echo $addon_row['total_price']; ?></center></span></td>
<td><span class="text-center" style="color:#337ab7"><center><?php echo $addon_row['total_price']; ?></center></span></td>
<td width="10%" class="text-center "><span style="cursor:pointer;"   class="lnr lnr-trash trash-icon"></span></td>
</tr>
<?php
}
$o++;
}
 ?>
    
    
    
    
    <?php
                      }
    ?>
                          
                        </tbody>        
                        <tfoot>
                          <!-- footer code -->
                        </tfoot>              
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              </div>

              <div class="row">
                 <!-- SMS Sender while saving -->
                      <?php 
                         //Change Return
                          $send_sms_checkbox='disabled';
                          if($CI->is_sms_enabled()){
                            if(!isset($sales_id)){
                              $send_sms_checkbox='checked';  
                            }else{
                              $send_sms_checkbox='';
                            }
                          }

                    ?>
                   
                   
                </div>
           
              </div>
              <!-- /.box-body -->

              <div class="">

               
                <div class="row-same img-row">
                
   <div class="col" >
                       
                      <button type="button" id="void_invoice" name="" class="group-icon-btn-big void_invoice" title="Void Invoice">
          <i class="las la-ban"></i>
                       Void 
                    </button>
                    </div>  
                    <div class="col" >
                        <button type="button"  onclick="print_bill();"  name="" class="group-icon-btn-big " title="print">
                       <i class="las la-cash-register"></i>
                     Print
                    </button>
                    </div>
                    <div class="col" >
                        <button type="button"  name="" class="group-icon-btn-big place_new_order" title="Place Order" >
                       <i class="las la-cash-register"></i>
                     Place Order
                    </button>
                    </div>
                       <div class="col">
                      <button type="button" id="" name="" data-toggle="modal" data-target="#card_modal" class="group-icon-btn-big " title="Multiple Payments [Ctrl+M]">
                         <i class="las la-credit-card"></i>
                             Card
                          </button>
                    </div>
                    <div class="col">
                        
                         <?php
                if($this->session->userdata('session_price_id')=='' || $this->session->userdata('session_price_id')=='0')
                {
                ?>
                   <button  type="button"  data-toggle="modal"  class="group-icon-btn-big show_payments_modal" title="Cash">
                        <i class="las la-money-bill-alt"></i>Cash</button>
                        
                <?php
                }else{
                    ?>
                    <button  type="button"   class="group-icon-btn-big" title="Cash">
                        <i class="las la-money-bill-alt"></i>Cash</button>
                    <?php
                }
                ?>
                        
                        </div>
                 
                  
   <!--                 <div class="col" >
                       
                      <button type="button" id="void_invoice" name="" class="group-icon-btn" title="Void Invoice">
                       <span class="lnr lnr-circle-minus"></span>
                       Void 
                    </button>
                    </div>  
                   
                    <div class="col" >
                      <button type="button" id="hold_invoice" name="" class="group-icon-btn" title="Hold Invoice [Ctrl+H]">
                      <span class="lnr lnr-question-circle"></span>
                       Hold
                    </button>
                    </div>
                    <div class="col">
                   <button  type="button"  data-toggle="modal" data-target="#discount-modal" class="group-icon-btn" title="Discount">
                        <span class="fa fa-percent" aria-hidden="true"></span>Discount</button>
                        </div>
                    <div class="col">
                      <button type="button" id="" name="" class="group-icon-btn show_payments_modal" title="Multiple Payments [Ctrl+M]">
                           <span class="fa fa-credit-card" aria-hidden="true"></span>
                             Card
                          </button>
                    </div>
                    
                    <div class="col" >
                        <?php if(isset($sales_id)){ $btn_id='update';$btn_name="Cash"; ?>
                    <input type="hidden" name="sales_id" id="sales_id" value="<?php echo $sales_id;?>"/>
                  <?php } else{ $btn_id='save';$btn_name="Cash";} ?>
                      <button  type="button" id="<?php echo "show_cash_modal";?>" name="" class="group-icon-btn ctrl_c" title="By Cash & Save [Ctrl+C]">
                           <span class="fa fa-money" aria-hidden="true"></span>
                             <?php echo $btn_name;?>
                          </button>
                    </div>
                     <div class="col">
                        
                      <button type="button"  name="" onclick="location.href='<?php echo $last_invoice_link; ?>';" class="group-icon-btn" title="Last Invoice">
                     <span class="fa fa-file-text-o" aria-hidden="true"></span>
                        Last Inv
                    </button>
                    </div>  -->

                          
                 
                   <div class="col-xs-12 d-none">
                           <div class="checkbox icheck mpt-0">
                            <label class="sms-label">
                              <input type="checkbox" <?=$send_sms_checkbox;?> class="form-control" id="send_sms" name="send_sms" > <label for="sales_discount" class=" control-label"><?= $this->lang->line('send_sms_to_customer'); ?>
                                <i class="hover-q " data-container="body" data-toggle="popover" data-placement="top" data-content="If checkbox is Disabled! You need to enable it from SMS -> SMS API <br><b>Note:<i>Walk-in Customer will not receive SMS!</i></b>" data-html="true" data-trigger="hover" data-original-title="" title="Do you wants to send SMS ?">
                                  <i class="fa fa-info-circle text-maroon text-black hover-q"></i>
                                </i>
                              </label>
                            </label>
                          </div>
                            
                             <!-- /.box-body -->
                         
                       <!-- /.box -->
                    </div>
                </div>
                                  <?php if(isset($sales_id)){ $btn_id='update';$btn_name="Cash"; ?>
                    <input type="hidden" name="sales_id" id="sales_id" value="<?php echo $sales_id;?>"/>
                  <?php } else{ $btn_id='save';$btn_name="Cash";} ?>
                  <div class="row-same row-new-divider">
                                <div class="col d-none" >
                      <button type="button" id="hold_invoice_later" name="" class="group-icon-btn" title="Hold Invoice [Ctrl+H]">
                   <i class="las la-pause"></i>
                       Hold
                    </button>
                    </div>
             <!--                             <div class="col" >
                       
                      <button type="button" id="void_invoice" name="" class="group-icon-btn" title="Void Invoice">
                       <span class="lnr lnr-circle-minus"></span>
                       Void 
                    </button>
                    </div>  -->
                   
          
                    <div class="col">
                   <button  type="button"  id="discount_all_btn" class="group-icon-btn" title="Discount">
                           <i class="las la-percentage"></i>Discount</button>
                        </div>
                                             <div class="col">
                        
                      <button type="button"  name="" onclick="print_lastinvoice(<?php echo $last_invoice_link ?>);" class="group-icon-btn" title="Last Invoice">
                <i class="las la-receipt"></i>
                        Last Inv
                    </button>
                    </div>
                    <div class="col d-none">
                      <button type="button" name="" onclick="refund_amount()" class="group-icon-btn quick_id_clk" title="refund">
<i class="las la-piggy-bank"></i>
 Refund
                    </button>
                    </div>  
                              <div class="col" >
                       <a style="cursor:pointer" class="group-icon-btn running_ord_btn"><i class="las la-glass-cheers"></i>  Running Orders</a>
                    </div>
                 <div class="col">
                      <button type="button" id="" name="" class="group-icon-btn addkotbtn" title="Multiple Payments [Ctrl+M]">
                    <i class="las la-blender"></i>
                            Add KOT
                          </button>
                    </div>
                            <div class="col">
                      <button type="button" id="" name="" class="group-icon-btn " title="Multiple Payments [Ctrl+M]">
                                             <i class="las la-comment-slash"></i>
                                                        
                           
                            Cancel KOT
                          </button>
                    </div>
                              <div class="col" >
                        <button type="button" class="group-icon-btn"  data-toggle="modal" data-target="#myModal">   <i class="las la-icons"></i>Table Layout</button>
                    </div> 
<!--                    <div class="col" >
                        <?php if(isset($sales_id)){ $btn_id='update';$btn_name="Cash"; ?>
                    <input type="hidden" name="sales_id" id="sales_id" value="<?php echo $sales_id;?>"/>
                  <?php } else{ $btn_id='save';$btn_name="Cash";} ?>
                      <button  type="button" id="<?php echo "show_cash_modal";?>" name="" class="group-icon-btn ctrl_c" title="By Cash & Save [Ctrl+C]">
                           <span class="fa fa-money" aria-hidden="true"></span>
                             <?php echo $btn_name;?>
                          </button>
                    </div>-->

                   
      <!--              <div class="col" >
                      <button type="button"  name="" class="group-icon-btn " title="Hold" data-toggle="modal" data-target="#holdmodal">
                      <span class="lnr lnr-question-circle"></span>
                       <?= $this->lang->line('hold_list'); ?>
                       <em class=" hold_invoice_list_count"><?=$tot_count?></em>
                    </button>
                    </div>
                   -->
                   
                   <div class="col" >
                      <button type="button"  name="" class="group-icon-btn " data-toggle="modal" data-target="#cashinoutmodal" title=" Cash In/Out">
                         <i class="las la-donate"></i>
                    Cash In/Out
                    </button>
                    </div>
                         <div class="col" >
                      <button type="button"  name="" class="group-icon-btn " title=" Cash in/out"  data-toggle="modal" data-target="#shiftinoutmodal"  data-toggle="modal" data-target="">
                    <i class="las la-stopwatch"></i>
                      Shift In/Out
                    </button>
                    </div>
            <!--         <div class="col" >
                      <button type="button"  name="" class="group-icon-btn " title="Place Order" data-toggle="modal" data-target="#placeorder_modal">
                           <i class="las la-mortar-pestle"></i>
                     New Sale
                    </button>
                    </div> -->
                 <div class="col">
                      <a style="cursor:pointer"  name=""  class="group-icon-btn" title="Day End"  onclick="print_dayend();">
                     <i class="las la-business-time"></i>
                       Day End
                    </a>
                    </div>  
                 
<!--                   <div class="col" >
                     <a href="" name=""  class="group-icon-btn" title="refund">
                      <?php print ucfirst($this->session->userdata('inv_username')); ?>
                   </a>
                    </div>-->
                    
                     <div class="col" >
                       <a style="cursor:pointer" class="group-icon-btn newsaleord"><i class="las la-file-medical"></i>New Sale</a>
                    </div>
                 
                
                 
                        <div class="col">
                       
                        <small class="powered-by">Powered By</small>
                        <img src="https://cygen.com.au/img/Cygen.png" class="img-responsive">
                 
                    </div>
        
                
                          
                  </div>
                  <div class="row-same d-none">
                    <div class="col">
                      <button type="button" name="" onclick="refund_amount()" class="group-icon-btn quick_id_clk" title="refund">
                      <span class="material-icons">
request_quote
</span>
                       Refund 
                    </button>
                    </div>  
                   
                    <div class="col" >
                      <button type="button"  name="" class="group-icon-btn " title="Hold" data-toggle="modal" data-target="#holdmodal">
                      <span class="lnr lnr-question-circle"></span>
                       <?= $this->lang->line('hold_list'); ?>
                       <em class=" hold_invoice_list_count"><?=$tot_count?></em>
                    </button>
                    </div>
                   
                   
                   <div class="col" >
                      <button type="button"  name="" class="group-icon-btn " title=" Cash in/out" data-toggle="modal" data-target="#cashinoutmodal">
                          <span class="fa fa-money" aria-hidden="true"></span>
                      Cash in/out
                    </button>
                    </div>
                    
                    
                     <div class="col" >
                      <button type="button"  name="" class="group-icon-btn " title="Place Order" data-toggle="modal" data-target="#placeorder_modal">
                          <span class="fa fa-cart-plus" aria-hidden="true"></span>
                      Place Order
                    </button>
                    </div> 
                 <div class="col">
                      <a href="<?php echo base_url(); ?>pos" name=""  class="group-icon-btn" title="refund">
                      <span class="fa fa-tags" aria-hidden="true"></span>
Running order
                    </a>
                    </div>  
                 
<!--                   <div class="col" >
                     <a href="" name=""  class="group-icon-btn" title="refund">
                      <?php print ucfirst($this->session->userdata('inv_username')); ?>
                   </a>
                    </div>-->
                    
                     <div class="col" >
                       <a href="<?php echo $base_url; ?>logout" class="group-icon-btn"><span class="fa fa-sign-out" aria-hidden="true"></span>Sign out</a>
                    </div> 
               <!--     <div class="col" >
                       <a href="<?php echo $base_url; ?>dashboard" class="group-icon-btn"><span class="fa fa-tachometer" aria-hidden="true"></span>Dashboard</a>
                    </div> 
                    <div class="col">
                       
                        <small class="powered-by">Powered By</small>
                        <img src="https://cygen.com.au/img/Cygen.png" class="img-responsive">
                 
                    </div>-->
                          
                  </div>
              </div>
            </form>
          </div>
          <!-- /.box -->
        
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-7 col-sm-12 col-sx-12 p-0 pos-right">
          <!-- Horizontal Form -->
          <div class="">
            <!-- form start -->
             
              <div class="col-md-12 p-0" >
                <div class="clearfix"></div>
              <div class="row m-0  top-box">
 <div class="col-md-3 p-0">
                  <div class="input-group col-md-12">
                    
                     <select class="form-control select2" id="category_id" name="category_id"  style="width: 100%;"  >
                        <?php
                        $query1="select * from db_category where status=1";
                        $q1=$this->db->query($query1);
                        echo '<option value="">All Categories</option>';
                        if($q1->num_rows($q1)>0)
                         {   
                             foreach($q1->result() as $res1)
                           {
                             echo "<option value='".$res1->id."'>".$res1->category_name."</option>";
                           }
                         }
                         else
                         {
                            ?>
                            <option value="">No Records Found</option>
                            <?php
                         }
                        ?>
                              </select>
                    
                  </div>
                </div>
                              <div class="col-md-4 ">
                  <div class="input-group">
                    <span class="input-group-addon" title="Customer"><i class="fa fa-user"></i></span>
                     <select class="form-control select2" id="customer_id" name="customer_id"  style="width: 100%;" onkeyup="shift_cursor(event,'expense_for')" >
                        <?php
                        $query1="select * from db_customers where status=1";
                        $q1=$this->db->query($query1);
                        
                        if($q1->num_rows($q1)>0)
                         {   
                             foreach($q1->result() as $res1)
                           {
                             if($res1->mobile=='') { 
                             echo "<option  value='".$res1->id."'>".$res1->customer_name."</option>";
                             }else{
                               echo "<option  value='".$res1->id."'>".$res1->customer_name.'&nbsp;('.$res1->mobile.'-'.$res1->cust_barcode.")</option>";  
                             }
                           }
                         }
                         else
                         {
                            ?>
                            <option value="">No Records Found</option>
                            <?php
                         }
                        ?>
                              </select>
                    <span class="input-group-addon pointer" data-toggle="modal" data-target="#customer-modal" title="New Customer?"><i class="fa fa-user-plus text-primary fa-lg"></i></span>
                  </div>
                    <span class="customer_points text-success" style="display: none;"></span>
                  
                  
                </div>
                <div class="col-md-6">
                   <div class="input-group input-group-md col-md-12">
                      <input type="text" id="search_it_all" class="form-control" placeholder="Search Items" autocomplete="off">
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-info btn-flat show_all"><i class="fa fa-search" aria-hidden="true"></i></button>
                          </span>
                    </div>
                </div>                
              </div><!-- row end -->
                </div>  
                <!--<div class="col-md-2 client-div p-0">
                   <img src=" https://chickycharchar.com.au/assets/images/logo-loader.png" class="img-responsive client-logo">
                    
                </div>-->
            <div class="clearfix"></div>
             
            <div class="row m-0">
               <div class="col-12 col-2 col-md-3 col-sm-4 pl-0 pr-1 w-20">
<!--                                  <div class="col-md-12 p-0">
                  <div class="input-group col-md-12">
                    
                     <select class="form-control select2" id="category_id" name="category_id"  style="width: 100%;"  >
                        <?php
                        $query1="select * from db_category where status=1";
                        $q1=$this->db->query($query1);
                        echo '<option value="">All Categories</option>';
                        if($q1->num_rows($q1)>0)
                         {   
                             foreach($q1->result() as $res1)
                           {
                             echo "<option value='".$res1->id."'>".$res1->category_name."</option>";
                           }
                         }
                         else
                         {
                            ?>
                            <option value="">No Records Found</option>
                            <?php
                         }
                        ?>
                              </select>
                    
                  </div>
                </div>--> 
                <div class="clearfix"></div>
                   <div id="demo">
			<div class="">
			     <?php
			            $bgimgcat=getSingleColumnName(1,'id','catbgimg_pos','db_sitesettings');
                        $query1="select * from db_category where status=1 and pos_category=1";
                        $q1=$this->db->query($query1);
                       
                        if($q1->num_rows($q1)>0)
                         {   
                             foreach($q1->result() as $res1)
                           {
                               
                               if($res1->catbgimg_pos==1){
                                   $img=base_url().'uploads/category/'.$res1->cat_image;
                               }else{
                                   $bgimgcatLogo=getSingleColumnName(1,'id','logo','db_sitesettings');
                                   $img=base_url().'uploads/'.$bgimgcatLogo;
                               }
                               ?>
                              
                               
				<a href="javascript:void(0)" style="    background-image: url('<?php echo $img; ?>') !important;" class="category_id_clk menu-cat-pos-new"  catid="<?php echo $res1->id; ?>">
				    <span class="catSpan" id="categoryspan_<?php echo $res1->id ?>">
				    <?php echo $res1->category_name; ?></span></a>
				  <?php
				  
				  
                           }
                         }           
				  ?>
				
			</div>
		</div>
               </div>
               <div class="col-12 col-10 col-md-9 col-sm-8 p-0 w-80">
                  
                   
                      <!-- <div class="form-group"> -->
                       <!--  <div class="col-sm-12"> -->
                          <!-- <style type="text/css">
                            
                          </style> -->
                         
                                 <section class="" >
                                  <div class=" search_div" style="overflow-y: scroll;min-height: 10vh;height:calc(100vh - 180px);">
                                  <?php 
                                    echo $CI->get_details();
                                    ?>
                                    
                                  </div>
                                  <h3 class='text-danger text-center error_div' style="display: none;">Sorry! No Records Found</h3>
                                </section>
                          
                             
                        <!-- </div> -->
                      <!-- </div> -->
                    
                
               </div>
               
                 <div class="col-md-12" >
                     <div class="grid subcatlist">
                    <?php 
                    $CI = & get_instance();
                    $CI->load->model('subcategory_model','subcategory');
                    
                    $subcatList =$CI->subcategory->subcat_pos();
                    if($subcatList) { 
                    foreach($subcatList  as $value){  
                    ?>  
                    <div style="cursor:pointer" class="item subcategory_id_clk" id="<?php echo $value->id; ?>">
                        <a><?php echo $value->subcategory_name; ?></a>
                    </div>
                    
                    <?php
                    }
                    }
                    ?>
   
                     </div>
                     
                 </div>
     <div class="clearfix"></div>
               <div class="col-md-3 p-0 d-none">
  <div class="calc-body">
    <div class="calc-screen">
     
      <div class="calc-typed">2955<span class="blink-me">_</span></div>
    </div>
    <div class="calc-button-row">
      <div class="button c">C</div>
      <div class="button l">≠</div>
      <div class="button l">%</div>
      <div class="button l">/</div>
    </div>
    <div class="calc-button-row">
      <div class="button">7</div>
      <div class="button">8</div>
      <div class="button">9</div>
      <div class="button l">x</div>
    </div>
    <div class="calc-button-row">
      <div class="button">4</div>
      <div class="button">5</div>
      <div class="button">6</div>
      <div class="button l">−</div>
    </div>
    <div class="calc-button-row">
      <div class="button">1</div>
      <div class="button">2</div>
      <div class="button">3</div>
      <div class="button l">+</div>
    </div>
    <div class="calc-button-row">
      <div class="button">.</div>
      <div class="button">0</div>
      <div class="button">
        <</div>
          <div class="button l">=</div>
      </div>
    </div>
  </div>
               
               
               
               
               
            </div>
 
              </div>
              <!-- /.box-body -->
        
                

                    
               
        
              
           
          </div>
          <!-- /.box -->
          
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include"footer.php";?>
</div>
<!-- ./wrapper -->
<div id="addon_modal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="right:10;float: right;">

    <!-- Modal content-->
    <div class="modal-content">
      <!--<div class="modal-header">-->
      <!--  <button type="button" class="close" data-dismiss="modal">&times;</button>-->
      <!--  <h4 class="modal-title header-custom">Add Extra Toppings</h4>-->
      <!--</div>-->
      <div class="modal-header header-custom">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title text-center">Add Extra Toppings</h4>
      </div>
      <div class="modal-body">
        <div class="row"><div class="productaddon"></div></div>
      </div>
      
    </div>

  </div>
</div>
<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- GENERAL CODE -->
<?php include"comman/code_js_form_pos.php"; ?>

<!-- iCheck -->
<script src="<?php echo $theme_link; ?>plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo $theme_link; ?>js/fullscreen.js"></script>
<script src="<?php echo $theme_link; ?>js/modals.js"></script>
<script src="<?php echo $theme_link; ?>js/pos.js?v=164"></script>
<script src="<?php echo $theme_link; ?>js/mousetrap.min.js"></script>
<!-- DROP DOWN -->
<script src="<?php echo $theme_link; ?>dist/js/bootstrap3-typeahead.min.js"></script>  
<!-- DROP DOWN END-->
<script type="text/javascript">
	swal({ buttons: false,showConfirmButton:false,closeOnClickOutside:false,backdrop:true,llowOutsideClick: false,title: "Are you sure to do POS operation?",icon: "warning",buttons: true,dangerMode: true,allowOutsideClick: false,onOpen: function () {
   $(".swal-button--cancel").attr('disabled', 'disabled');
  }}).then((sure) => {
			  if(sure) {
			      
			     var el = document.documentElement
        , rfs = // for newer Webkit and Firefox
               el.requestFullScreen
            || el.webkitRequestFullScreen
            || el.mozRequestFullScreen
            || el.msRequestFullScreen
    ;
    if (typeof rfs != "undefined" && rfs) {
        rfs.call(el);
    } else if (typeof window.ActiveXObject != "undefined") {
        // for Internet Explorer
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript != null) {
            wscript.SendKeys("{F11}");
        }
    }
			      }
	    
	});
     $(function(){
         
    $("body").on("click",".display_fullscreen",function(){
            var el = document.documentElement
        , rfs = // for newer Webkit and Firefox
               el.requestFullScreen
            || el.webkitRequestFullScreen
            || el.mozRequestFullScreen
            || el.msRequestFullScreen
    ;
    if (typeof rfs != "undefined" && rfs) {
        rfs.call(el);
    } else if (typeof window.ActiveXObject != "undefined") {
        // for Internet Explorer
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript != null) {
            wscript.SendKeys("{F11}");
        }
    }
   $('#fullscreen-modal').modal('hide');
    });
    });
   
</script>

<script>

  //RIGHT SIT DIV:-> FILTER ITEM INTO THE ITEMS LIST
  function search_it(){
  
  var input = $("#search_it").val().trim();
  var item_count=$(".search_div .search_item").length;
  var error_count=item_count;
  for(i=0; i<item_count; i++){
    
    if($("#item_"+i).html().toUpperCase().indexOf(input.toUpperCase())>-1){
    
      $("#item_"+i).show();
      $("#item_parent_"+i).show();
    }
    else{
    
     $("#item_"+i).hide();
     $("#item_parent_"+i).hide();
     error_count--;
    }
    if(error_count==0){
      $(".error_div").show();
    }
    else{
      $(".error_div").hide();
    }
    
  }
  }


//REMOTELY FETCH THE ALL ITEMS OR CATEGORY WISE ITEMS.
function get_details(){
  $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
  $.post("<?php echo $base_url; ?>pos/get_details",{id:$("#category_id").val()},function(result){
    $(".search_div").html('');
    $(".search_div").html(result);
    $(".overlay").remove();
  });
}
function get_details_cat20(catId){
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.post("<?php echo $base_url; ?>pos/get_details",{id:catId},function(result){
    $(".search_div").html('');
    $(".search_div").html(result);
    $(".overlay").remove();
    
              $.ajax({
              type:'post',
              url: '<?php echo base_url('pos/subcatList') ?>',
              data:{
                catId:catId
              },
              success:function(data) {
                  $(".subcatlist").html(data);
                 }
            });
    
    
    
    
  });
}

function get_details_subcat20(subcatId){
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.post("<?php echo $base_url; ?>pos/getsubcat_details",{subcatid:subcatId},function(result){
        console.log(result);
    $(".search_div").html('');
    $(".search_div").html(result);
    $(".overlay").remove();

  });
}

// function add_product_cart(id,sales_price,qtye){
  
   
// }






function get_addon_details(id){
  //  $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
  //  $.post("<?php echo $base_url; ?>pos/get_details",{id:catId},function(result){
  //  $(".search_div").html('');
   // $(".search_div").html(result);
  //  $(".overlay").remove();
 // });
    $.post("<?php echo $base_url; ?>pos/get_adddon_details",{id:id},function(result){
        //alert(result);
        console.log(result);
         $(".productaddon").html(result)
         $("#addon_modal").modal('show');
    // $(".search_div").html('');
    // $(".search_div").html(result);
    // $(".overlay").remove();
    });
   // $("#addon_modal").modal('show');
 
}
function get_addon_add(id,name,price,item_code){
    var caritemname  ="caritemname_"+item_code;
    var caritemprice ="caritemprice_"+item_code;
    //caritemprice
    var addon_name="<p style='font-size:10px;color:#dd4b39;padding:0px;'>"+name+"</p>";
    var price_name="<p  style='display:block;font-size:10px;color:#dd4b39;padding:0px;'>"+price+"</p>";
    
  //  alert(price_name);
     $("."+caritemname).append(addon_name);
     $("."+caritemprice).append(price_name);
    //caritemprice_
    //alert(id);
    // alert(name);
     // alert(price);
//   //  $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
//   //  $.post("<?php echo $base_url; ?>pos/get_details",{id:catId},function(result){
//   //  $(".search_div").html('');
//   // $(".search_div").html(result);
//   //  $(".overlay").remove();
//  // });
//     $.post("<?php echo $base_url; ?>pos/get_adddon_details",{id:id},function(result){
//         //alert(result);
//         console.log(result);
//          $(".productaddon").html(result)
//          $("#addon_modal").modal('show');
//     // $(".search_div").html('');
//     // $(".search_div").html(result);
//     // $(".overlay").remove();
//     });
//   // $("#addon_modal").modal('show');
 
}
//LEFT SIDE: ON CLICK ITEM ADD TO INVOICE LIST
function addrow(id){
    var hidden_order_id=$("#hidden_order_id").val();
    if(hidden_order_id!=0){
        toastr["warning"]("You have selected running order's");
        return;
    }
    var rowcount        =$("#hidden_rowcount").val();//0,1,2...
    var item_id         =$('#div_'+id).attr('data-item-id');
    var item_name       =$('#div_'+id).attr('data-item-name');
    var stock   =$('#div_'+id).attr('data-item-available-qty');
    var tax_type   =$('#div_'+id).attr('data-item-tax-type');
    var tax_id   =$('#div_'+id).attr('data-item-tax-id');
    var tax_value   =$('#div_'+id).attr('data-item-tax-value');
    var tax_name   =$('#div_'+id).attr('data-item-tax-name');
    var tax_amt   =$('#div_'+id).attr('data-item-tax-amt');
    var item_cost     =$('#div_'+id).attr('data-item-cost');
     var sales_price     =$('#div_'+id).attr('data-item-sales-price');
    var sales_price_temp=sales_price;
    sales_price     =(parseFloat(sales_price)).toFixed(2);
    var refund_item_id=$("#hidden_refund_item").val();
    $("#hidden_lastitem").val(id);
    $("#hidden_lastprice").val(sales_price);     
        
    $.post("<?php echo $base_url; ?>pos/product_modifier",{id:item_id},function(responsemod){

      $(".productDetailModal").html(responsemod);     
      $("#myModalmodifier").modal('show'); 
        var qtye=1;
        var addcart=0;
        // $.post("<?php echo $base_url; ?>pos/add_product_cart",{id:id,sales_price:sales_price,qtye:qtye},function(result_data){
        // if(result_data) {
        //   $.post("<?php echo $base_url; ?>pos/cart_detail",{id:id,sales_price:sales_price,qtye:qtye},function(result_data_response){
        //     $("#pos-form-tbody").html(result_data_response);
        //     $.post("<?php echo $base_url; ?>pos/cart_summery",{id:id,sales_price:sales_price,qtye:qtye},function(result_data_response_summery){
        //       var cart_summery=result_data_response_summery.split('~')
        //     $(".tot_qty").text(cart_summery['0']) ;
        //     $(".tot_amt").text(cart_summery['1']) ;
        //     $(".tot_grand").text(cart_summery['1']) ;
        //     var net_amount = cart_summery['1'];
        //     $(".sales_div_tot_payble").html(net_amount); 
        //     $("#card_amount_detail").val(net_amount);
        //     });

        //   });


        // }

        //  });
         
         
     //   addrow_offer();

      });      





        
  }














function update_price(row_id,item_cost){

  //Input
  /*var sales_price=$("#sales_price_"+row_id).val().trim();
  if(sales_price!='' || sales_price==0) {sales_price = parseFloat(sales_price); }

  //Default set from item master
  var item_price=parseFloat($("#tr_sales_price_temp_"+row_id).val().trim());

  if(sales_price<item_cost){
    //toastr["warning"]("Minimum Sales Price is "+item_cost);
    $("#sales_price_"+row_id).parent().addClass('has-error');
  }else{
    $("#sales_price_"+row_id).parent().removeClass('has-error');
  }*/

  make_subtotal($("#tr_item_id_"+row_id).val(),row_id);
}

function set_to_original(row_id,item_cost) {
  return true;
  /*Input*/
  var sales_price=$("#sales_price_"+row_id).val().trim();
  if(sales_price!='' || sales_price==0) {sales_price = parseFloat(sales_price); }

  /*Default set from item master*/
  var item_price=parseFloat($("#tr_sales_price_temp_"+row_id).val().trim());

  if(sales_price<item_cost){
    toastr["success"]("Default Price Set "+item_price);
    $("#sales_price_"+row_id).parent().removeClass('has-error');
    $("#sales_price_"+row_id).val(item_price);
  }
  make_subtotal($("#tr_item_id_"+row_id).val(),row_id);
}


//INCREMENT ITEM
function increment_qty(item_id,rowcount){
  $.post("<?php echo $base_url; ?>pos/updateQty",{id:item_id,updatetype:1},function(result_data_response){
id=0;
$.post("<?php echo $base_url; ?>pos/cart_detail",{id:id},function(result_data_response){
	$("#pos-form-tbody").html(result_data_response);
	$.post("<?php echo $base_url; ?>pos/cart_summery",{id:id},function(result_data_response_summery){
		var cart_summery=result_data_response_summery.split('~')
		$(".tot_qty").text(cart_summery['0']) ;
		$(".tot_amt").text(cart_summery['2']) ;
		$(".tot_grand").text(cart_summery['1']) ;
		net_amount = cart_summery['1'];
          // $(".sales_div_tot_payble").html('100'); 
           $("#card_amount_detail").val(net_amount);
	});
}); 
});
  }
 
 function increment_qty_addon(item_id,rowcount){
  $.post("<?php echo $base_url; ?>pos/updateQty_addon",{id:item_id,updatetype:1},function(result_data_response){
id=0;
$.post("<?php echo $base_url; ?>pos/cart_detail",{id:id},function(result_data_response){
	$("#pos-form-tbody").html(result_data_response);
	$.post("<?php echo $base_url; ?>pos/cart_summery",{id:id},function(result_data_response_summery){
		var cart_summery=result_data_response_summery.split('~')
		$(".tot_qty").text(cart_summery['0']) ;
		$(".tot_amt").text(cart_summery['2']) ;
		$(".tot_grand").text(cart_summery['1']) ;
		var	net_amount = cart_summery['1'];
        $(".sales_div_tot_payble ").html((parseFloat(round_off(net_amount))).toFixed(2));
        $("#card_amount_detail").val(net_amount);
	});
}); 
});
  }
 
 
 
 function decrement_qty_addon(item_id,rowcount){
  var item_qty=$("#item_qty_addon"+item_id).val();
 if(item_qty<=1) {
     var message="Are you sure you wanna delete the item?";
 }else{
      var message="Are you Sure?";
 }
  swal({
title: message,
icon: "warning",
buttons: [
'Cancel',
'OK'
],
dangerMode: true,
}).then(function(isConfirm) {
if (isConfirm) {
    var item_qty=$("#item_qty_addon"+item_id).val();
    $.post("<?php echo $base_url; ?>pos/updateQty_addon",{id:item_id,updatetype:'0'},function(result_data_response){
   // alert(result_data_response);
      id=0;
$.post("<?php echo $base_url; ?>pos/cart_detail",{id:id},function(result_data_response){
	$("#pos-form-tbody").html(result_data_response);
	$.post("<?php echo $base_url; ?>pos/cart_summery",{id:id},function(result_data_response_summery){
		var cart_summery=result_data_response_summery.split('~')
		$(".tot_qty").text(cart_summery['0']) ;
		$(".tot_amt").text(cart_summery['2']) ;
		$(".tot_grand").text(cart_summery['1']) ;
	    var net_amount = cart_summery['1'];
        $(".sales_div_tot_payble").html('100'); 
        $("#card_amount_detail").val(net_amount);
	});
}); 
});
swal.close(); 
} 
});
  
}
 
//DECREMENT ITEM
function decrement_qty(item_id,rowcount){
  var item_qty=$("#item_qty_"+item_id).val();
 if(item_qty<=1) {
     var message="Are you sure you wanna delete the item?";
 }else{
      var message="Are you Sure?";
 }
  swal({
title: message,
icon: "warning",
buttons: [
'Cancel',
'OK'
],
dangerMode: true,
}).then(function(isConfirm) {
if (isConfirm) {
    var item_qty=$("#item_qty_"+item_id).val();
    $.post("<?php echo $base_url; ?>pos/updateQty",{id:item_id,updatetype:'0'},function(result_data_response){
   // alert(result_data_response);
      id=0;
$.post("<?php echo $base_url; ?>pos/cart_detail",{id:id},function(result_data_response){
	$("#pos-form-tbody").html(result_data_response);
	$.post("<?php echo $base_url; ?>pos/cart_summery",{id:id},function(result_data_response_summery){
		var cart_summery=result_data_response_summery.split('~')
		$(".tot_qty").text(cart_summery['0']) ;
		$(".tot_amt").text(cart_summery['2']) ;
		$(".tot_grand").text(cart_summery['1']) ;
        var	net_amount = cart_summery['1'];
       //$(".sales_div_tot_payble").html('100'); 
       $("#card_amount_detail").val(net_amount);
	});
}); 
});
swal.close(); 
} 
});
  


}
//LEFT SIDE: IF ITEM QTY CHANGED MANUALLY
function item_qty_input(item_id,rowcount){
  var item_qty=$("#item_qty_"+item_id).val();
  var stock=$("#td_"+rowcount+"_1").html();
  if(stock==0){
    toastr["warning"]("item Not Available in stock!");
    //return;  
  }
  if(parseFloat(item_qty)>parseFloat(stock)){
    $("#item_qty_"+item_id).val(stock);
    toastr["warning"]("Oops! You have only "+stock+" items in Stock");
   // return;
  }
  if(item_qty==0){
    $("#item_qty_"+item_id).val(1);
    toastr["warning"]("You must have atlease one Quantity");
    //return; 
  }
  /*else{
    $("#item_qty_"+item_id).val(1);
    toastr["warning"]("You must have atlease one Quantity");
    return; 
  }*/
  make_subtotal(item_id,rowcount);
}

function zero_stock(){
  toastr["error"]("Out of Stock!");
  return;
}
//LEFT SIDE: REMOVE ROW 
function removerow(id){//id=Rowid  
    $("#row_"+id).remove();
    failed.currentTime = 0;
    failed.play();
    final_total();
}

//MAKE SUBTOTAL
function make_subtotal(item_id,rowcount){
  set_tax_value(rowcount);

   //Find the Tax type and Tax amount
   var tax_type = $("#tr_tax_type_"+rowcount).val();
   var tax_amount = $("#td_data_"+rowcount+"_11").val();

  var sales_price     =$("#sales_price_"+rowcount).val();
  //var gst_per         =$("#tr_item_per_"+rowcount).val();
  var item_qty        =$("#item_qty_"+item_id).val();

  var tot_sales_price =parseFloat(item_qty)*parseFloat(sales_price);
  //var gst_amt=(tot_sales_price * gst_per)/100;

  var subtotal        =parseFloat(tot_sales_price);

  console.log("tax_type="+tax_type);
  console.log("subtotal="+subtotal);
  console.log("tax_amount="+tax_amount);
  subtotal = (tax_type=='Inclusive') ? subtotal : parseFloat(subtotal) + parseFloat(tax_amount);

  $("#td_data_"+rowcount+"_4").val(parseFloat(subtotal).toFixed(2));
  final_total();
}
function calulate_discount(discount_input,discount_type,total){
  if(discount_type=='in_percentage'){
    return parseFloat((total*discount_input)/100);
  }
  else{//in_fixed
    return parseFloat(discount_input);
  }
}
//LEFT SIDE: FINAL TOTAL
function final_total(){
  var total=0;
  var item_qty=0;
  var rowcount=$("#hidden_rowcount").val();
  var discount_input=$("#discount_input").val();
  var discount_type=$("#discount_type").val();
  var total_tax=0;
  if($(".items_table tr").length>1){
    for(i=0;i<rowcount;i++){
      if(document.getElementById('tr_item_id_'+i)){
       // set_tax_value(i);
      var tax_amt = parseFloat($("#td_data_"+i+"_11").val());
      item_id=$("#tr_item_id_"+i).val();
      
      total=parseFloat(total)+ + +parseFloat($("#td_data_"+i+"_4").val()).toFixed(2);
      //console.log("==>total="+total);
      //console.log("==>tax_amt="+tax_amt);
     // total+=tax_amt;
     total_tax=parseFloat(total_tax)+parseFloat(tax_amt);
      //console.log("==>total="+total);
      item_qty=parseFloat(item_qty)+ + +parseFloat($("#item_qty_"+item_id).val()).toFixed(2);
      }
    }//for end
  }//items_table
  
  total =round_off(total);
  
  var discount_amt=0;
  if(total>0){
    var discount_amt=calulate_discount(discount_input,discount_type,total);//return value 
  }


  set_total(item_qty,total,discount_amt,total-discount_amt,total_tax);
}
function set_total(tot_qty=0, tot_amt=0, tot_disc=0, tot_grand=0,total_tax=0){
  // $(".tot_qty   ").html(tot_qty);
  // $(".tot_amt   ").html((round_off(tot_amt).toFixed(2)));
  // $(".tot_disc  ").html((round_off(tot_disc).toFixed(2)));
  // $(".tot_grand ").html((round_off(tot_grand)).toFixed(2));
  // $(".total_tax").html(((total_tax)).toFixed(2));
}

//LEFT SIDE: FINAL TOTAL
function adjust_payments(){
  var total=0;
  var item_qty=0;
  var rowcount=$("#hidden_rowcount").val();
  var discount_input=$("#discount_input").val();
  var discount_type=$("#discount_type").val();
  //var discount_amt = parseFloat($(".tot_disc").html());
  var tot_grand = parseFloat($(".tot_grand").text());
   total=tot_grand;
  if($(".items_table tr").length>1){
    for(i=0;i<rowcount;i++){
      if(document.getElementById('tr_item_id_'+i)){
      total=parseFloat(total)+ + +parseFloat($("#td_data_"+i+"_4").val()).toFixed(2);
      item_id=$("#tr_item_id_"+i).val();
      item_qty=parseFloat(item_qty)+ + +parseFloat($("#item_qty_"+item_id).val()).toFixed(2);
      }
    }//for end
  }//items_table
  total =round_off(total);
  //Find customers payment

  var payments_row =get_id_value("payment_row_count");
  console.log("payments_row="+payments_row);
  var paid_amount =parseFloat(0);
  for (var i = 1; i <=payments_row; i++) {
    if(document.getElementById("amount_"+i)){
      var amount = parseFloat(get_id_value("amount_"+i));
          amount = isNaN(amount) ? 0 : amount;
          console.log("amount_"+i+"="+amount);
      paid_amount += amount;
    }
  }
  
  //RIGHT SIDE DIV
  var discount_amt=calulate_discount(discount_input,discount_type,total);//return value


  var change_return = 0;
  var balance = total-discount_amt-paid_amount;
  if(balance < 0){
    //console.log("Negative");
    change_return = Math.abs(parseFloat(balance));
    balance = 0;
  }
  
  balance =round_off(balance);
  var item_qty = $(".tot_qty").text() ;
  $(".sales_div_tot_qty  ").html(item_qty);
  $(".sales_div_tot_amt  ").html((round_off(total)).toFixed(2));
  $(".sales_div_tot_discount ").html((parseFloat(round_off(discount_amt))).toFixed(2)); 
  $(".sales_div_tot_payble ").html((parseFloat(round_off((total-discount_amt)))).toFixed(2)); 
  
  
  $(".sales_div_tot_paid ").html((round_off(paid_amount)).toFixed(2));
  $(".sales_div_tot_balance ").html((parseFloat(round_off(balance))).toFixed(2)); 
  
  /**/
  $(".sales_div_change_return ").html((change_return).toFixed(2)); 
   $("#card_amount_detail").val((parseFloat(round_off((total-discount_amt)))).toFixed(2)); 
}


// adjust payment for cash

function adjust_payments_cash(){
  var total=0;
  var item_qty=0;
  var rowcount=$("#hidden_rowcount").val();
  var discount_input=$("#discount_input").val();
  var discount_type=$("#discount_type").val();
  //var discount_amt = parseFloat($(".tot_disc").html());

  if($(".items_table tr").length>1){
    for(i=0;i<rowcount;i++){
      if(document.getElementById('tr_item_id_'+i)){
      total=parseFloat(total)+ + +parseFloat($("#td_data_"+i+"_4").val()).toFixed(2);
      item_id=$("#tr_item_id_"+i).val();
      item_qty=parseFloat(item_qty)+ + +parseFloat($("#item_qty_"+item_id).val()).toFixed(2);
      }
    }//for end
  }//items_table
  total =round_off(total);
  //Find customers payment

  var payments_row =get_id_value("payment_row_count");
  console.log("payments_row="+payments_row);
  var paid_amount =parseFloat(0);
  for (var i = 1; i <=payments_row; i++) {
    if(document.getElementById("amount_"+i)){
      var amount = parseFloat(get_id_value("amount_"+i));
          amount = isNaN(amount) ? 0 : amount;
          console.log("amount_"+i+"="+amount);
      paid_amount += amount;
    }
  }
  
  //RIGHT SIDE DIV
  var discount_amt=calulate_discount(discount_input,discount_type,total);//return value


  var change_return = 0;
  var balance = Math.ceil(total-discount_amt-paid_amount);
  if(balance < 0){
    //console.log("Negative");
    change_return = Math.abs(parseFloat(balance));
    balance = 0;
  }
  
  balance =round_off(balance);
  $(".sales_div_tot_qty  ").html(item_qty);
  $(".sales_div_tot_amt  ").html((round_off(Math.ceil(total))).toFixed(2));
  $(".sales_div_tot_discount ").html((parseFloat(round_off(discount_amt))).toFixed(2)); 
  $(".sales_div_tot_payble ").html((parseFloat(round_off(Math.ceil(total-discount_amt)))).toFixed(2)); 
  
  
  $(".sales_div_tot_paid ").html((round_off(paid_amount)).toFixed(2));
  $(".sales_div_tot_balance ").html((parseFloat(round_off(balance))).toFixed(2)); 
  
  /**/
  $(".sales_div_change_return ").html((change_return).toFixed(2)); 
  
}


 function set_all_discount_info(){
    var order_payment_status=$("#order_payment_status").val();
    if(order_payment_status!=0){
        toastr["warning"]("Only print Operation");
        return;
    }
     if($(".items_table tr").length==1){
    	toastr["warning"]("Empty Sales List!!");
		return;
    }
    var discount_type=$("#popup_discount_id2").val();  
    var discount_amt_all =$("#discount_amt_all").val();
    var tot_grand=$(".tot_grand").text();
    if(discount_amt_all==''){
        alert("amount should not be empty");
        return false;
    }
    else if(discount_type==1 && discount_amt_all>100 ){
        alert("amount should be less than 100");
        return false;
    }else if(discount_type==2 && discount_amt_all>tot_grand ){
         alert("Amount should be less than sales amount");
        return false;
    }else{
    $.post("<?php echo $base_url; ?>pos/cart_discount",{discount_type:discount_type,amount:discount_amt_all},function(result_data_response){
        $("#sales_total_discount_item").modal('hide');
        
    var id=10;
    $.post("<?php echo $base_url; ?>pos/cart_detail",{id:id},function(result_data_response){
    $("#pos-form-tbody").html(result_data_response);
    $.post("<?php echo $base_url; ?>pos/cart_summery",{id:id},function(result_data_response_summery){
    var cart_summery=result_data_response_summery.split('~')
    $(".tot_qty").text(cart_summery['0']) ;
    $(".tot_amt").text(cart_summery['2']) ;
    $(".tot_grand").text(cart_summery['1']) ;
    $(".tot_discount_amt").text((parseFloat(cart_summery['2'])-parseFloat(cart_summery['1'])).toFixed(2)) ;
    
    var	net_amount = cart_summery['1'];
    $(".sales_div_tot_payble ").html((parseFloat(round_off(net_amount))).toFixed(2));
    $("#card_amount_detail").val(net_amount);
    });
    }); 
    });
    
    }
  }
  

// for coupon
  $("body").on("click",".coupon_btn",function(){
    var order_payment_status=$("#order_payment_status").val();
    if(order_payment_status!=0){
        toastr["warning"]("Only print Operation");
        return;
    }
     if($(".items_table tr").length==1){
    	toastr["warning"]("Empty Sales List!!");
		return;
    }
    var discount_type=1;  
    var discount_amt_all =$(this).attr('coupon_percent');
    var coupon_id =$(this).attr('coupon_id');
    var tot_grand=$(".tot_grand").text();
    if(discount_amt_all==''){
        alert("amount should not be empty");
        return false;
    }
    else if(discount_type==1 && discount_amt_all>100 ){
        alert("amount should be less than 100");
        return false;
    }else{
    $.post("<?php echo $base_url; ?>pos/cart_discount",{discount_type:discount_type,amount:discount_amt_all},function(result_data_response){
    var id=10;
    $.post("<?php echo $base_url; ?>pos/cart_detail",{id:id},function(result_data_response){
    $("#pos-form-tbody").html(result_data_response);
    $.post("<?php echo $base_url; ?>pos/cart_summery",{id:id},function(result_data_response_summery){
    var cart_summery=result_data_response_summery.split('~')
    $(".tot_qty").text(cart_summery['0']) ;
    $(".tot_amt").text(cart_summery['2']) ;
    $(".tot_grand").text(cart_summery['1']) ;
    $(".tot_discount_amt").text((parseFloat(cart_summery['2'])-parseFloat(cart_summery['1'])).toFixed(2)) ;
    
    var	net_amount = cart_summery['1'];
    $(".sales_div_tot_payble ").html((parseFloat(round_off(net_amount))).toFixed(2));
    $("#card_amount_detail").val(net_amount);
    });
    }); 
    });
    
    }
  });
  











function check_same_item(item_id){

  if($(".items_table tr").length>1){
    var rowcount=$("#hidden_rowcount").val();
    for(i=0;i<=rowcount;i++){
            if($("#tr_item_id_"+i).val()==item_id){
              increment_qty(item_id,i);
              failed.currentTime = 0;
              failed.play();
              return false;
            }
      }//end for
  }
  return true;
}

$(document).ready(function(){
    
    $("body").on("click","#discount_all_btn",function(){
         var hidden_order_id=$("#hidden_order_id").val();
        if(hidden_order_id!=0){
        toastr["warning"]("You have selected running order's");
        return;
        }
        if($(".items_table tr").length==1){
        toastr["warning"]("Empty Sales List!!");
        return;
        }else{
           $("#sales_total_discount_item").modal('show'); 
        }
    });
    
  //FIRST TIME: LOAD
  //get_details();
  //alert($("section").height());//600+
  //alert($(".items_table").height());//29.76
  //alert($(".content-wrapper").height());//629

  var first_div= parseFloat($(".content-wrapper").height());
  var second_div= parseFloat($("section").height());
  var items_table= parseFloat($(".items_table").height());
 // $(".items_table").parent().css("height",(first_div-second_div)+items_table+250);/**/
  //$(".search_div").parent().css("height",(second_div-items_table));/**/


  //FIRST TIME: SET TOTAL ZERO
  set_total();

  //RIGHT DIV: FILTER INPUT BOX
  $("#search_it").on("keyup",function(){
    search_it();
  });

  //CATEGORY WISE ITEM FETCH FROM SERVER
  $("#category_id").change(function () {
      get_details();
      return false;
  });
  $(".category_id_clk").click(function () {
      var catId=$(this).attr('catId');
      $(".catSpan").removeClass('spanactive');
      var spanId='categoryspan_'+catId;
      $("#"+spanId).addClass('spanactive');
      get_details_cat20(catId);
      return false;
  });
  
  $("body").on('click','.subcategory_id_clk',function () {
      var subcatId=$(this).attr('id');
      get_details_subcat20(subcatId);
      return false;
  });
  //DISCOUNT UPDATE
  $(".discount_update").click(function () {
      final_total();
      $('#discount-modal').modal('toggle');    
  });

  //RIGHT SIDE: CLEAR SEARCH BOX
  $("#search_it_all").keyup(function(){
       var str = $(this).val();
        if (str.length >= 3) {
     $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.post("<?php echo $base_url; ?>pos/get_search_details",{srch_text:$("#search_it_all").val()},function(result){
    $(".search_div").html('');
    $(".search_div").html(result);
    $(".overlay").remove();
    $("#search_it_all").val('');
  });
        }
  });
  $(".cashoutbtn").click(function(){
      var amount_cashout =$("#amount_cashout").val();
      var cashout_desc   =$("#cashout_desc").val(); 
      var cash_type=$("#cash_type").val(); 
    $.post("<?php echo $base_url; ?>pos/cashout",{amount_cashout:amount_cashout,cashout_desc:cashout_desc,cash_type:cash_type},function(result){
        
       // alert(result);
       if(result==0){
        toastr["warning"]("Enter Correct Amount!");
       }else{
            toastr["success"]("success!");
           $("#cashinoutmodal").modal('hide');
         //  window.location.href = "<?php echo $base_url; ?>Logout";
       }
  });
       
  });
  
  $(".shiftbtn").click(function(){
      var amount_cashout =$("#amount_cashout_shift").val();
      var cashout_desc   =$("#cashout_desc_shift").val(); 
      var cash_type=2; 
    $.post("<?php echo $base_url; ?>pos/shiftout",{amount_cashout:amount_cashout,cashout_desc:cashout_desc,cash_type:cash_type},function(result){
        
      // alert(result);
       if(result==0){
        toastr["warning"]("Enter Correct Amount!");
       }else{
            toastr["success"]("success!");
           $("#shiftinoutmodal").modal('hide');
           window.location.href = "<?php echo $base_url; ?>Logout";
       }
  });
       
  });
  
  
  
  
  
  
  //UPDATE PROCESS START
 <?php if(isset($sales_id) && !empty($sales_id)){ ?>

    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.get("<?php echo $base_url ?>pos/fetch_sales/<?php echo $sales_id ?>",{},function(result){
      //console.log(result);
      result=result.split("<<<###>>>");
      $('#pos-form-tbody').append(result[0]);
      $('#discount_input').val(result[1]);
      $('#discount_type').val(result[2]);
      $('#customer_id').val(result[3]).select2();
      $('#temp_customer_id').val(result[3]);
      $("#hidden_rowcount").val(parseFloat($(".items_table tr").length)-1);
      adjust_payments();
      final_total();
      $(".overlay").remove();
      $("#customer_id").trigger("change");
      if(result[5]==1){
        $( "#binvoice" ).prop( "checked", true );
        $('#binvoice').parent('div').addClass('checked');
      }
    });
      //DISABLE THE HOLD BUTTON
      $("#hold_invoice,#show_cash_modal").attr('disabled',true).removeAttr('id');

 <?php } ?>
  //UPDATE PROCESS END

 // hold_invoice_list();
});//ready() end



$("#item_search").bind("paste", function(e){
     $("#item_search").val('');
    $("#item_search").autocomplete('search');
} );

$("#item_search").autocomplete({
    minLength:3,
    source: function(data, cb){
        $.ajax({
          autoFocus:true,
            url: $("#base_url").val()+'items/get_json_items_details',
            method: 'GET',
            dataType: 'json',

            showHintOnFocus: true,
            autoSelect: true, 
            selectInitial :true,
      
            data: {
                name: data.term,
                /*warehouse_id:$("#warehouse_id").val().trim(),*/
            },
            success: function(res){
           //   console.log(res);
                var result;
                result = [
                    {
                        //label: 'No Records Found '+data.term,
                        label: 'No Records Found ',
                        value: ''
                    }
                ];

                if (res.length) {
                  
                    result = $.map(res, function(el){
                        srrr=el.label;
                        str2=srrr.replace("&amp;", "&");
                        return {
                            label:str2,
                            value: '',
                            id: el.id,
                            item_name: el.value,
                            stock: el.stock,
                           // mobile: el.mobile,
                            //customer_dob: el.customer_dob,
                            //address: el.address,

                        };

                    });
                }else{
                    // toastr["warning"]("Oops! No Item Founds");
                    swal({
  title: "Oops! No Item Founds",
  icon: "warning",
  button: "Ok",
  dangerMode: true,
});
                    //swal("Oops! No Item Founds",);
                     failed.currentTime = 0;
                     failed.play();
                }
                
                $("#item_search").removeClass('ui-autocomplete-loading');
                cb(result);
            }
        });
    },

        response:function(e,ui){
          if(ui.content.length==1){
            $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
            $(this).autocomplete("close");
          }
          //console.log(ui.content[0].id);
        },
        //loader start
        search: function (e, ui) {
          
        },
        select: function (e, ui) { 
         // console.log('inside select');
            //$("#mobile").val(ui.item.mobile)
            //$("#item_search").val(ui.item.value);
            //$("#customer_dob").val(ui.item.customer_dob)
            //$("#address").val(ui.item.address)

            //console.log("stock="+$(this).val()); //Input box value

            if(typeof ui.content!='undefined'){
              console.log("Autoselected first");
              if(isNaN(ui.content[0].id)){
                return;
              }
              var stock=ui.content[0].stock;
              var item_id=ui.content[0].id;

            }
            else{
              console.log("manual Selected");
              var stock=ui.item.stock;
              var item_id=ui.item.id;
            }
            
            if(parseFloat(stock)==0){
              toastr["error"]("Out of Stock!");
              $("#item_search").val('');
              $(".overlay").remove();
              return;
            }
           // addrow(item_id);
            $("#item_search").val('');
            $(".overlay").remove();
           return_row_with_data(item_id);
           
            
            
        },   
        //loader end
});

//sudhakarnayak
function return_row_with_data(item_id){
    $("#item_search").val('');
var alreadyidexist=0;   
if($(".items_table tr").length>1){
    var rowcount=$("#hidden_rowcount").val();
    for(i=0;i<=rowcount;i++){
            if($("#tr_item_id_"+i).val()==item_id){
            alreadyidexist=1;    
             increment_qty(item_id,i);
              failed.currentTime = 0;
              failed.play();
              return false;
            }
    }        
   
	}

	if(alreadyidexist==0){
	var base_url=$("#base_url").val().trim();
	var rowcount=$("#hidden_rowcount").val();
 	$.post(base_url+"pos/return_row_with_data/"+rowcount+"/"+item_id,{},function(result){
      var  res = result.split("~");
    if(res['0']!='' && res['0']!='0'){
    $("#item_search").addClass('ui-autocomplete-loader-center');
    var rowcount        =$("#hidden_rowcount").val();
    var item_id         =res['0'];
    var item_name       =res['1'];
    var stock   =res[3];
    var tax_type   =res['9'];
    var tax_id   =res['7'];
    var tax_value   =res['8'];
    var tax_name   =res['5'];
    var tax_amt   =res['9'];
    //var gst_per         =$('#div_'+id).attr('data-item-tax-per');
    //var gst_amt         =$('#div_'+id).attr('data-item-gst-amt');
    var item_cost     =res['11'];
    var sales_price     =res['4'];
    var sales_price_temp=sales_price;
    sales_price     =(parseFloat(sales_price)).toFixed(2);

        var newcountval=parseInt(rowcount)+1;
         
         var extra_row  =' <span  id="spandesc'+item_id+'"></span><i  rowcnt="'+rowcount+'" id="'+item_id+'" class=" edit-icon short_desc fa fa-pencil-square-o" aria-hidden=true"></i>';
    var quantity        ='<div class="input-group input-group-sm"><span class="input-group-btn"><button id="dr'+rowcount+'" onclick="decrement_qty('+item_id+','+rowcount+')" type="button" class="counter-increment"><i class="lnr lnr-plus-circle"></i></button></span>';
        quantity       +='<input readonly="readonly" typ="text" value="1" class="form-control no-padding text-center"  id="item_qty_'+item_id+'" name="item_qty_'+item_id+'">';
        quantity       +='<span class="input-group-btn"><button id="in'+rowcount+'" onclick="increment_qty('+item_id+','+rowcount+')" type="button" class="counter-increment"><i class="lnr lnr-plus-circle"></i></button></span></div>';
    var sub_total       =(parseFloat(1)*parseFloat(sales_price)).toFixed(2);//Initial
    var remove_btn      ='<a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="removerow('+rowcount+')" title="Delete Item?"></a>';

    var str=' <tr class="car_'+item_id+'" id="row_'+rowcount+'" data-row="0" data-item-id='+item_id+'>';/*item id*/
       str+='<td class="srl_number">'+ newcountval     +'</td>';/* td_0_2 item available qty*/
        str+='<td style="width:50%" class="caritemname_'+item_id+'" id="td_'+rowcount+'_0"><a  class="pointer item-name-pos" id="td_data_'+rowcount+'_0">'+ item_name     +'</a>'+extra_row+'</td>';/* td_0_0 item name*/ 
         str+='<td style="display:none" id="td_'+rowcount+'_1">'+ stock +'</td>';/* td_0_1 item available qty*/
        str+='<td id="td_'+rowcount+'_2">'+ quantity      +'</td>';/* td_0_2 item available qty*/
            info='<input id="sales_price_'+rowcount+'" onblur="set_to_original('+rowcount+','+item_cost+')" onclick="show_discount_item_modal('+rowcount+')"   onkeyup="update_price('+rowcount+','+item_cost+')" name="sales_price_'+rowcount+'" type="text" class="form-control no-padding " value="'+sales_price+'">';
        str+='<td id="td_'+rowcount+'_3" class="text-right">'+ info   +'</td>';/* td_0_3 item sales price*/
        /*Tax amt*/
        str+='<td style="display:none"  id="td_'+rowcount+'_11"><input data-toggle="tooltip" title="Click to Change" id="td_data_'+rowcount+'_11" onclick="show_sales_item_modal('+rowcount+')" name="td_data_'+rowcount+'_11" type="text" class="form-control no-padding pointer" readonly value="'+tax_amt+'"></td>';

        str+='<td id="td_'+rowcount+'_4" class="text-right caritemprice_'+item_id+'"><input data-toggle="tooltip" title="Total" id="td_data_'+rowcount+'_4" name="td_data_'+rowcount+'_4" type="text" class="form-control no-padding pointer" readonly  value="'+sub_total+'"></td>';/* td_0_4 item sub_total */
        str+='<td style="display:none" id="td_'+rowcount+'_8" class="text-right">';
        str+='<input type="text" name="td_data_'+rowcount+'_8" id="td_data_'+rowcount+'_8" class="form-control text-right no-padding only_currency text-center item_discount " value="0" >';
        str+='</td>';/* td_0_6 item doscount price*/
        str+='<td style="display:none" id="td_'+rowcount+'_5">'+ remove_btn    +'</td>';/* td_0_5 item gst_amt */

        str+='<input type="hidden" name="tr_item_id_'+rowcount+'" id="tr_item_id_'+rowcount+'" value="'+item_id+'">';
       // str+='<input type="hidden" id="tr_item_per_'+rowcount+'" name="tr_item_per_'+rowcount+'" value="'+gst_per+'">';
        str+='<input type="hidden" id="tr_sales_price_temp_'+rowcount+'" name="tr_sales_price_temp_'+rowcount+'" value="'+sales_price_temp+'">';
         str+='<input type="hidden" id="tr_sales_price_temp2_'+rowcount+'" name="tr_sales_price_temp2_'+rowcount+'" value="'+sales_price_temp+'">';
        str+='<input type="hidden" id="tr_tax_type_'+rowcount+'" name="tr_tax_type_'+rowcount+'" value="'+tax_type+'">';
        str+='<input type="hidden" id="tr_tax_id_'+rowcount+'" name="tr_tax_id_'+rowcount+'" value="'+tax_id+'">';
        str+='<input type="hidden" id="tr_tax_value_'+rowcount+'" name="tr_tax_value_'+rowcount+'" value="'+tax_value+'">';
        str+='<input type="hidden" id="description_'+rowcount+'" name="description_'+rowcount+'" value="">';
        str+='<input type="hidden" id="refund_id_'+rowcount+'" name="refund_id_'+rowcount+'" value="0">';
        str+='<input type="hidden" id="refund_type_'+rowcount+'" name="refund_type_'+rowcount+'" value="0">';
        str+='</tr>';    
  
    //LEFT SIDE: ADD OR APPEND TO SALES INVOICE TERMINAL
    $('#pos-form-tbody').prepend(str);
    //LEFT SIDE: INCREMANT ROW COUNT
    $("#hidden_rowcount").val(parseFloat($("#hidden_rowcount").val())+1);
    failed.currentTime = 0;
    failed.play();
    //CALCULATE FINAL TOTAL AND OTHER OPERATIONS
    //final_total();
    make_subtotal(item_id,rowcount); 
    $(".overlay").remove();
     $("#item_search").removeClass('ui-autocomplete-loader-center');
       }else{
          // alert();
          $(".overlay").remove();
       }
        
        
    var rowCountnew = $('.items_table tr').length;
    var rowCountnew2=rowCountnew-1;
    $('.items_table tr .srl_number').each(function() {
    var srl_number =$(this).text(rowCountnew2);
    var srl_number2 =$(this).text();
    rowCountnew2--;
    });    
        
        
        
        
    }); 
    
    
    
    }  
    
    
}

//DATEPICKER INITIALIZATION
$('#order_date,#delivery_date,#cheque_date').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      todayHighlight: true
    });
    $('#customer_dob,#birthday_person_dob').datepicker({
      calendarWeeks: true,
      todayHighlight: true,
      autoclose: true,
      format: 'dd-mm-yyyy',
      startView: 2
    });
    
    //Datemask dd-mm-yyyy
    //$("#customer_dob,#birthday_person_dob").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});

    //Timepicker
    /*$('.timepicker').timepicker({
      showInputs: false,
    });*/

    //Sale Items Modal Operations Start
    function show_sales_item_modal(row_id){
      $('#sales_item').modal('toggle');
      //$("#popup_tax_id").select2();

      //Find the item details
      var item_name = $("#td_data_"+row_id+"_0").html();
      var tax_type = $("#tr_tax_type_"+row_id).val();
      var tax_id = $("#tr_tax_id_"+row_id).val();
      var description = $("#description_"+row_id).val();

      //Set to Popup
      $("#popup_item_name").html(item_name);
      $("#popup_tax_type").val(tax_type).select2();
      $("#popup_tax_id").val(tax_id).select2();
      $("#popup_row_id").val(row_id);
      $("#popup_description").val(description);
    }

    function set_info(){
      var row_id = $("#popup_row_id").val();
      var tax_type = $("#popup_tax_type").val();
      var tax_id = $("#popup_tax_id").val();
      var description = $("#popup_description").val();
      var tax_name = ($('option:selected', "#popup_tax_id").attr('data-tax-value'));
      var tax = parseFloat($('option:selected', "#popup_tax_id").attr('data-tax'));

      //Set it into row 
      $("#tr_tax_type_"+row_id).val(tax_type);
      $("#tr_tax_id_"+row_id).val(tax_id);
      $("#description_"+row_id).val(description);
      $("#tr_tax_value_"+row_id).val(tax);//%
      //$("#td_data_"+row_id+"_12").html(tax_type+" "+tax_name);
      
      var item_id=$("#tr_item_id_"+row_id).val();
      make_subtotal(item_id,row_id);
      //calculate_tax(row_id);
      $('#sales_item').modal('toggle');
    }
    function set_tax_value(row_id){
      //get the sales price of the item
      var tax_type = $("#tr_tax_type_"+row_id).val();
      var tax = $("#tr_tax_value_"+row_id).val(); //%
      var item_id=$("#tr_item_id_"+row_id).val();
      var qty=($("#item_qty_"+item_id).val());
          qty = (isNaN(qty)) ? 0 :qty;

      var sales_price = parseFloat($("#sales_price_"+row_id).val());
          sales_price = (isNaN(sales_price)) ? 0 :sales_price;
          sales_price = sales_price * qty;
          
      var tax_amount = (tax_type=='Inclusive') ? calculate_inclusive(sales_price,tax) : calculate_exclusive(sales_price,tax);
      console.log("tax_amount="+tax_amount);
      $("#td_data_"+row_id+"_11").val(tax_amount);
    }
    //Sale Items Modal Operations End


</script>
	<script type="text/javascript">
			
			$(document).ready(function(){
			       
                    $("#item_search").mouseleave(function(){
                    
                    $("#item_search").val('');
                    });
			    
				
				});
		</script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<script type="text/javascript">
  Mousetrap.bind('ctrl+m', function(e) {
    e.preventDefault();
    $(".show_payments_modal").trigger('click');
  });
  Mousetrap.bind('ctrl+h', function(e) {
    e.preventDefault();
    $("#hold_invoice").trigger('click');
  });
  Mousetrap.bind('ctrl+c', function(e) {
    e.preventDefault();
    $(".ctrl_c").trigger('click');
  });
</script>

<script>
 /**
 * carousel vertical
 * @version 1.0
 * @author Simone Iannacone
 * @todo follow the owl carousel direction
 */
;(function($){
'use strict';
	
	var defaults_options = {
			items:8,
			margin:2,
			nav: false,
			navText: ['prev', 'next'],
		};
	
	$.fn.extend({
		carouselVertical: function(argumentss){
			
			var carouselVerticalClass = function(element, options){
				
				var _options = {},
					$this = null,
					$stage = null,
					$items = null,
					_this = null,
					_height = 0,
					_stage_height = 0,
					_items_height = 0,
					_items_outer_height = 0,
					_items_count = 0,
					_current_item = 1,
					_current_item_pos = 1,
					_last_item = 1,
					_last_item_pos = 1;
				
				function init(el, opts){
					_this = el;
					$this = $(_this);
					if($this.hasClass('cv-loaded'))
						return false;
					_options = opts;
					$items = $this.find('.item');
					_items_count = $items.length;
					if(_items_count == 0)
						return false;
					_height = $this.height();
					if(_items_count < _options.items) _options.items = _items_count;
					$this.wrapInner('<div class="cv-stage-outer"><div class="cv-stage"></div></div>');
					// drag and drop (for touchscreens) always active
					$this.addClass('cv-drag');
					// explicit height for position relative
					$this.height(_height);
					$items.wrap('<div class="cv-item"></div>');
					$items = $this.find('.cv-item');
					$items.slice(0, _options.items).addClass('active');
					_items_height = parseInt((_height - _options.margin * _options.items) / _options.items);
					$items.css({
						'height': _items_height + 'px',
						'margin-bottom': _options.margin + 'px'
					});
					_items_outer_height = _items_height + _options.margin;
					_stage_height = _items_outer_height * _items_count;
					_last_item = _items_count - _options.items;
					_last_item_pos = -_last_item * _items_outer_height;
					$stage = $this.find('.cv-stage');
					$items = $this.find('.cv-item');
					$this.addClass('cv-loaded');
					_this.addEventListener('touchstart', touchHandler, true);
					_this.addEventListener('MSPointerDown', touchHandler, true);
					_this.addEventListener('touchmove', touchHandler, true);
					_this.addEventListener('MSPointerMove', touchHandler, true);
					_this.addEventListener('touchend', touchHandler, true);
					_this.addEventListener('MSPointerUp', touchHandler, true);
					_this.addEventListener('touchcancel', touchHandler, true);
					_this.addEventListener('mousedown', mouseHandler, false);
					_this.addEventListener('mousemove', mouseHandler, false);
					_this.addEventListener('mouseup', mouseHandler, false);
					if(_options.nav){
						$this.prepend('<div class="cv-nav"><div class="cv-prev">' + _options.navText[0] + '</div><div class="cv-next">' + _options.navText[1] + '</div></div>');
						var prev_btn = $this.find('.cv-prev')[0],
							next_btn = $this.find('.cv-next')[0];
						prev_btn.addEventListener('touchend', touchHandler, true);
						prev_btn.addEventListener('MSPointerUp', touchHandler, true);
						prev_btn.addEventListener('click', prevClick, false);
						next_btn.addEventListener('touchend', touchHandler, true);
						next_btn.addEventListener('MSPointerUp', touchHandler, true);
						next_btn.addEventListener('click', nextClick, false);
					}
					$this.on('goTo', goTo);
					moveTo(0);
					return true;
				}
				
				if(!init(element, options))
					return false;
				
				var is_mousedown = false;
				function mouseHandler(e){
					var diff = e.clientY - _current_item_pos;
					switch(e.type){
						case 'mousedown':
							is_mousedown = true;
							_current_item_pos = diff;
						break;
						case 'mousemove':
							if(is_mousedown)
								moveByMouse(diff);
							break;
						case 'mouseup':
						default:
							if(is_mousedown) {
								if(diff > 0) diff = 0;
								moveFinal(diff);
								is_mousedown = false;
							}
					}
				}
				var clickms = 100,
					lastTouchDown = -1;
				function touchHandler(e){
					// https://stackoverflow.com/questions/5186441/javascript-drag-and-drop-for-touch-devices#6362527
					var touch = e.changedTouches[0],
						simulatedEvent = document.createEvent('MouseEvent'),
						d = new Date(),
						type = null;
					switch(e.type){
						case 'touchstart':
							type = 'mousedown';
							lastTouchDown = d.getTime();
							break;
						case 'touchmove':
							type = 'mousemove';
							lastTouchDown = -1;
							break;        
						case 'touchend':
							if(lastTouchDown > -1 && (d.getTime() - lastTouchDown) < clickms){
								lastTouchDown = -1;
								type = 'click';
								break;
							}
							type = 'mouseup';
							break;
						case 'touchcancel':
						default:
							return;
					}
					simulatedEvent.initMouseEvent(type, true, true, window, 1, touch.screenX, touch.screenY, touch.clientX, touch.clientY, false, false, false, false, 0, null);
					touch.target.dispatchEvent(simulatedEvent);
					e.preventDefault();
				}
				function moveByMouse(pos){
					if(pos > 0) pos /= 5;
					if(pos < _last_item_pos) pos = _last_item_pos + (pos - _last_item_pos) / 5;
					$stage.css('transition', 'none');
					$this.addClass('cv-grab');
					move(pos);
				}
				function moveFinal(pos){
					$stage.css('transition', 'all 0.25s ease');
					$this.removeClass('cv-grab');
					moveTo(Math.round(-pos / _items_outer_height));
				}
				function move(pos){
					$stage.css('transform', 'translateY(' + pos + 'px)');
				}
				// 1: first element
				function goTo(e, n){
					if(typeof n != 'undefined' && $.isNumeric(n) && Math.floor(n) == n)
						moveTo(n - 1);
				}
				// 0: first element
				function moveTo(n){
					if(n < 0) n = 0;
					if(n > _last_item) n = _last_item;
					_current_item = n;
					$items.removeClass('active');
					$items.slice(n, (_options.items + n)).addClass('active');
					_current_item_pos = -_items_outer_height * n;
					move(_current_item_pos);
				}
				/*
				replaced by css transition
				function slideTop(pos){
					var mem = pos,
						interval = setInterval(function(){
							mem -= 10;
							if(mem < 0){
								mem = 0;
								clearInterval(interval);
							}
							move(mem);
						}, 1);
				}
				*/
				function prevClick(){
					moveTo(_current_item - 1);
				}
				function nextClick(){
					moveTo(_current_item + 1);
				}
			};
			
			function init(el, args){
				if(typeof args == 'object' || typeof args == 'undefined'){
					var options = $.extend({}, defaults_options, args);
					carouselVerticalClass(el, options);
				}
			}
			var length = this.length;
			if(length < 1) return this;
			if(typeof argumentss == 'undefined') argumentss = defaults_options;
			if(length > 1)
				for(var c = 0; c < length; c++)
					init(this[c], argumentss);
			else
				init(this[0], argumentss);
			return this;
		}
	});

})(jQuery);   
    
    
</script>
		<script type="text/javascript">
			$(document).ready(function(){
					$('.cv-carousel').carouselVertical({
						nav: false
					});
					// for moving programmatically the carousel
					// you can do that
					$('.cv-carousel').trigger('goTo', [5]);
					// or that
					$('.cv-carousel').carouselVertical().trigger('goTo', [5]);
				});
		</script>

<script type="text/javascript">



function scrolldown() {
    document.getElementById('pos-form-tbody').scrollTop -= 30;
}
function scrollup() {
    document.getElementById('pos-form-tbody').scrollTop += 30;
}
        function dis(val) 
         { 
             document.getElementById("amount_1").value+=val 
         } 
           
         //function that evaluates the digit and return result 
         function solve() 
         { 
             let x = document.getElementById("amount_1").value 
             let y = eval(x) 
             document.getElementById("amount_1").value = y ;
             calculate_payments();
         } 
           
         //function that clear the display 
         function clr() 
         { 
             document.getElementById("amount_1").value = ""
              calculate_payments();
         } 
$(document).ready(function(){
   //function that display value 
        
    //short_desc    
    $("body").on("click",".short_desc", function(){   
        var thisid=$(this).attr('id');
        var rowcnt=$(this).attr('rowcnt');
        $("#current_item_id").val(thisid);
         $("#rowcnt_desc").val(rowcnt);
        $("#extradescmodal").modal('show');
    });    
    
    $("body").on("click",".short_desc_btn", function(){ 
        var extradesc_text ="("+$("#short_desc").val()+")";
        var current_item_id =  $("#current_item_id").val();
        var rowcnt_desc     = $("#rowcnt_desc").val();
        var newname = $('#td_data_'+rowcnt_desc+'_0').text();
        $("#spandesc"+current_item_id).text(extradesc_text);
       // var latest_desc=newname+' '+extradesc_text;
       // $('#td_data_'+rowcnt_desc+'_0').text(extradesc_text);
        $("#description_"+rowcnt_desc).val(extradesc_text);
        $("#extradescmodal").modal('hide');
        
        $("#short_desc").val('');
    }); 
    
    
    
    $("body").on("click",".donamnt", function(){
        var donamnt=$(this).attr('don');
           //alert(donamnt);
           if(donamnt=='c' || donamnt==='c'){
               $('#amount_1').val('');
           }
           
           else{
           var amountpayment=$('#amount_1').val();
           if(amountpayment === undefined || amountpayment === null || amountpayment === ''){
               amountpayment=0;
             }
           newval=parseFloat(amountpayment)+parseFloat(donamnt);
           $('#amount_1').val(newval);
           }
           calculate_payments();
});

 $("body").on("click",".donamnt_cash", function(){
        var donamnt=$(this).attr('don');
           //alert(donamnt);
           if(donamnt=='c' || donamnt==='c'){
               $('#amount_1').val('');
           }
           
           else{
           var amountpayment=$('#amount_1').val();
           if(amountpayment === undefined || amountpayment === null || amountpayment === ''){
               amountpayment=0;
             }
           newval=parseFloat(amountpayment)+parseFloat(donamnt);
           $('#amount_1').val(newval);
           }
           calculate_payments_cash();
});




});

 function calculate_tax(i,disacount,distype){ //i=Row
           // set_tax_value(i);
           var item_id=$("#tr_item_id_"+i).val(); 
          // alert(item_id);
           //Find the Tax type and Tax amount
           var tax_type = $("#tr_tax_type_"+i).val();
           var tax_amount = $("#td_data_"+i+"_11").val();
         //  alert(tax_amount)
           var qty=$("#item_qty_"+item_id).val();
         //  alert(qty) tr_sales_price_temp2_0;
          var sales_price=parseFloat($("#tr_sales_price_temp2_"+i).val());
          $("#td_data_"+i+"_8").val(disacount); 
          var discount=disacount;
          var distype=distype;
          //Discount on All
          var discount_input = (isNaN(parseFloat($("#tot_disc").text()))) ? 0 : parseFloat($("#tot_disc").text());
          if(discount_input>0){
              discount=0;
          }

          discount   =(isNaN(parseFloat(discount)))    ? 0 : parseFloat(discount);

          var amt=parseFloat(qty) * sales_price;//Taxable
          if(distype==1){
          var discount_amt=((amt) * discount)/100;
          }else
          {
          var discount_amt=discount;    
          }
          
          var total_amt=amt-discount_amt;
          total_amt = (tax_type=='Inclusive') ? total_amt : parseFloat(total_amt) + parseFloat(tax_amount);
         //   alert("sales_price----------------->"+sales_price);
          //Set Unit cost
          var per_unit_discount = (sales_price)*discount/100;
         // alert("per_unit_discount----------------->"+per_unit_discount);
          var per_unit_total    = sales_price - discount_amt;
           $("#sales_price_"+i+"").val('').val(per_unit_total.toFixed(2));
           $("#td_data_"+i+"_4").val('').val(total_amt.toFixed(2));
           $("#tr_sales_price_temp_"+i).val(total_amt.toFixed(2))
          //alert("calculate_tax() end");
          final_total();
           
         }
         
    function show_discount_item_modal(row_id){
       $('#discount_id').val(''); 
       $('#popup_discount_id').val('1');
      $('#popup_row_id_dis').val(row_id)    
      $('#sales_discount_item').modal('show');
      //$("#popup_tax_id").select2();
    }
    function set_discount_info(){
      var rowId = $('#popup_row_id_dis').val(); 
      var disacount = $('#discount_id').val(); 
      var distype = $('#popup_discount_id').val(); 
      if(rowId!=''){
         
          calculate_tax(rowId,disacount,distype); 
      }
      $('#sales_discount_item').modal('hide');
      //$("#popup_tax_id").select2();
    }
    
    function refund_amount(){
         if($(".items_table tr").length==1){
    	toastr["warning"]("Empty Sales List!!");
		
    }else{
         $('#refundmodal').modal('show');
    }
 //  update_price(rowcount,newprive);
    //  alert(ds);
}

function remove_item_addon(cart_id){
        id = cart_id;
     $.post("<?php echo $base_url; ?>pos/cartaddon_item_delete",{id:cart_id},function(result_data){
         // alert(result_data);
        if(result_data) {
          $.post("<?php echo $base_url; ?>pos/cart_detail",{id:id},function(result_data_response){
            $("#pos-form-tbody").html(result_data_response);
            $.post("<?php echo $base_url; ?>pos/cart_summery",{id:id},function(result_data_response_summery){
              var cart_summery=result_data_response_summery.split('~')
            $(".tot_qty").text(cart_summery['0']) ;
            $(".tot_amt").text(cart_summery['2']) ;
            $(".tot_grand").text(cart_summery['1']) ;
             var	net_amount = cart_summery['1'];
             $(".sales_div_tot_payble ").html((parseFloat(round_off(net_amount))).toFixed(2));
             $("#card_amount_detail").val(net_amount);
            
            });

          });


        }

         });
}


function remove_item(cart_id){
    id = cart_id;
     $.post("<?php echo $base_url; ?>pos/cart_item_delete",{id:cart_id},function(result_data){
         // alert(result_data);
        if(result_data) {
          $.post("<?php echo $base_url; ?>pos/cart_detail",{id:id},function(result_data_response){
            $("#pos-form-tbody").html(result_data_response);
            $.post("<?php echo $base_url; ?>pos/cart_summery",{id:id},function(result_data_response_summery){
              var cart_summery=result_data_response_summery.split('~')
            $(".tot_qty").text(cart_summery['0']) ;
            $(".tot_amt").text(cart_summery['2']) ;
            $(".tot_grand").text(cart_summery['1']) ;
            var	net_amount = cart_summery['1'];
             $(".sales_div_tot_payble ").html((parseFloat(round_off(net_amount))).toFixed(2));
             $("#card_amount_detail").val(net_amount);
            
            });

          });


        }

         });
    
   
}


//for save card orders
function save(print=false){
//$('.make_sale').click(function (e) {
	
	var base_url=$("#base_url").val().trim();
    
    if($(".items_table tr").length==1){
    	toastr["warning"]("Empty Sales List!!");
		return;
    }

     var sales_div_change_return=$(".sales_div_change_return:first").text();
	//RETRIVE ALL DYNAMIC HTML VALUES
	var hidden_order_id =$("#hidden_order_id").val();

    var tot_qty=$(".tot_qty").text();
    var tot_amt=$(".tot_amt").text();
    var tot_disc=$(".tot_disc").text();
    var tot_grand=$(".tot_grand").text();
    var paid_amt=$(".sales_div_tot_paid:first").text();
   //  var paid_amt=$(".sales_div_tot_paid").text();
    var balance=parseFloat($(".sales_div_tot_balance:first").text());
     var customer_id=$("#customer_id").val();
    var change_return = $(".sales_div_change_return").text(); 
    var newtext = "Total bill amount : "+tot_amt+' \n Paid amount : '+paid_amt+' \n  Change return : '+sales_div_change_return;
    if($("#customer_id").val().trim()==1 && balance!=0){
    	toastr["warning"]("Walk-in Customer Should Pay Complete Amount!!");
		return;
    }
    if(document.getElementById("sales_id")){
    	var command = 'update';
    }
    else{
    	var command = 'save';
    }
    var this_btn='make_sale';
	var command = 'save';
	swal({ title: "Like to proceed ?",icon: "warning",buttons: true,text: newtext,dangerMode: true,}).then((sure) => {
			  if(sure) {//confirmation start

		
		$("#"+this_btn).attr('disabled',true);  //Enable Save or Update button
		//e.preventDefault();
		var data = new Array(2);
		data= new FormData($('#pos-form')[0]);//form name
		/*Check XSS Code*/
		if(!xss_validation(data)){ return false; }
		
		$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
		$.ajax({
			type: 'POST',
			url: base_url+'pos/pos_save_order?command='+command+'&tot_qty='+tot_qty+'&tot_amt='+tot_amt+'&tot_disc='+tot_disc+'&tot_grand='+tot_grand+"&paid_amt="+paid_amt+'&balance='+balance+"&customer_id="+customer_id+'&change_return='+change_return+'&hidden_order_id='+hidden_order_id,
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(result){
			//	console.log(result);return;
				result=result.trim().split("~");
				console.log("result[0]"+result[0]);
				//return;
				if(result[0]=1){
					
					if(result[0]=1)
					{
        					    
        			$.post("<?php echo $base_url; ?>pos/cart_summery",{productId:result[1]},function(result_data_response_summery){
                      var cart_summery=result_data_response_summery.split('~')
                    $(".tot_qty").text(cart_summery['0']) ;
                    $(".tot_amt").text(cart_summery['2']) ;
                    $(".tot_grand").text(cart_summery['1']) ;
                    var	net_amount = cart_summery['1'];
                     $(".sales_div_tot_payble ").html((parseFloat(round_off(net_amount))).toFixed(2));
                     $("#card_amount_detail").val(net_amount);
                    
                    });
						var print_done=true;
						if(print){
							var print_done =window.open(base_url+"pos/print_invoice_pos/"+result[1], "_blank", "scrollbars=1,resizable=1,height=300,width=450");
						}
						if(print_done){
							if(command=='update'){
								console.log("inside update");
							//	window.location=base_url+"sales";		
							}
							else{
								console.log("inside else");
								success.currentTime = 0;
								success.play();
								toastr['success']("Invoice Saved Successfully!");
								  var id=1;
								  $.post("<?php echo $base_url; ?>pos/cart_detail",{id:id},function(result_data_response){
                                    $("#pos-form-tbody").html(result_data_response);
                                    $.post("<?php echo $base_url; ?>pos/cart_summery",{id:id},function(result_data_response_summery){
                                      var cart_summery=result_data_response_summery.split('~')
                                    $(".tot_qty").text(cart_summery['0']) ;
                                    $(".tot_amt").text(cart_summery['2']) ;
                                    $(".tot_grand").text(cart_summery['1']) ;
                                    var	net_amount = cart_summery['1'];
                                     $(".sales_div_tot_payble ").html((parseFloat(round_off(net_amount))).toFixed(2));
                                     $("#card_amount_detail").val(net_amount);
                                    
                                    });
                        
                                  });
								  $("#hidden_order_id").val(0);
								  $("#order_payment_status").val(0);
                                  $("#print_bill_id").val(0);   
								
								//window.location=base_url+"pos";		
							//	$(".items_table > tbody").empty();
								$(".discount_input").val(0);
								
								$('#multiple-payments-modal').modal('hide');
								$('#multiple-payments-modal-single').modal('hide');
								var rc=$("#payment_row_count").val();
								while(rc>1){
									remove_row(rc);
									rc--;
								}
								console.log('inside form');
								$("#pos-form")[0].reset();
                                $(".items_table > tbody").empty();
								$("#customer_id").val(1).select2();

							//	final_total();
								//get_details();
								//hold_invoice_list();
								//window.location=base_url+"pos";

							}
							
						}
					//	window.location="<?php echo $base_url; ?>pos";
					    	$("#hidden_order_id").val(0);	
					}
					else if(result[0]=2)
					{
					   toastr['error']("Sorry! Failed to save Record.Try again");
					}
					else
					{
						//alert(result);
					}
				} // data.result end
				
				if(result[0]=3){
				//	$(".search_div").html('');
   				//	$(".search_div").html(result[2]);	
				}
				if(result[0]=4){
    			//	$("#hold_invoice_list").html('').html(result[3]);
    			//	$(".hold_invoice_list_count").html('').html(result[4]);
				}
				

			//	$("."+this_btn).attr('disabled',false);  //Enable Save or Update button
				$(".overlay").remove();
		   }
	   });
	} //confirmation sure
		}); //confirmation end

//e.preventDefault


//});
}//Save End



function save_card(print=false){
//$('.make_sale').click(function (e) {
	var card_amount_detail =$("#card_amount_detail").val();
	var hidden_order_id =$("#hidden_order_id").val();
	var card_mobile =$("#card_mobile").val();
	var card_number =$("#card_number").val();
	var card_name =$("#card_name").val();
	var base_url=$("#base_url").val().trim();
    var price_id=$(".price_id").val();
    if($(".items_table tr").length==1){
    	toastr["warning"]("Empty Sales List!!");
		return;
    }

     var sales_div_change_return=0;
	//RETRIVE ALL DYNAMIC HTML VALUES
    var tot_qty=$(".tot_qty").text();
    var tot_amt=$(".tot_amt").text();
    var tot_disc=$(".tot_disc").text();
    var tot_grand=$(".tot_grand").text();
    var paid_amt=card_amount_detail;
   //  var paid_amt=$(".sales_div_tot_paid").text();
    var balance=0;
     var customer_id=$("#customer_id").val();
    var newtext = "Total bill amount : "+tot_amt+' \n Paid amount : '+paid_amt;
    if($("#customer_id").val().trim()==1 && balance!=0){
    	toastr["warning"]("Walk-in Customer Should Pay Complete Amount!!");
		return;
    }
    if(document.getElementById("sales_id")){
    	var command = 'update';
    }
    else{
    	var command = 'save';
    }
    var this_btn='make_sale';
	var command = 'save';
	swal({ title: "Like to proceed ?",icon: "warning",buttons: true,text: newtext,dangerMode: true,}).then((sure) => {
			  if(sure) {//confirmation start

		
		$("#"+this_btn).attr('disabled',true);  //Enable Save or Update button
		//e.preventDefault();
		var data = new Array(2);
		data= new FormData($('#pos-form')[0]);//form name
		/*Check XSS Code*/
		if(!xss_validation(data)){ return false; }
		
		$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
		$.ajax({
			type: 'POST',
			url: base_url+'pos/pos_save_order_card?command='+command+'&tot_qty='+tot_qty+'&tot_amt='+tot_amt+'&tot_disc='+tot_disc+'&tot_grand='+tot_grand+"&paid_amt="+paid_amt+'&balance='+balance+"&customer_id="+customer_id+'&card_mobile='+card_mobile+'&card_name='+card_name+'&card_number='+card_number+'&hidden_order_id='+hidden_order_id+'&price_id='+price_id,
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(result){
				//console.log(result);return;
				result=result.trim().split("~");
				console.log("result[0]"+result[0]);
				//return;
				if(result[0]=1){
					
					if(result[0]=1)
					{
        			$.post("<?php echo $base_url; ?>pos/cart_summery",{productId:result[1]},function(result_data_response_summery){
                      var cart_summery=result_data_response_summery.split('~')
                    $(".tot_qty").text(cart_summery['0']) ;
                    $(".tot_amt").text(cart_summery['2']) ;
                    $(".tot_grand").text(cart_summery['1']) ;
                    var	net_amount = cart_summery['1'];
                     $(".sales_div_tot_payble ").html((parseFloat(round_off(net_amount))).toFixed(2));
                     $("#card_amount_detail").val(net_amount);
                    
                    });
						var print_done=true;
						if(print){
						    if(price_id=='' || price_id=='0'){
							var print_done =window.open(base_url+"pos/print_invoice_pos/"+result[1], "_blank", "scrollbars=1,resizable=1,height=300,width=450");
						    }else{
						       	var print_done =window.open(base_url+"pos/print_kot_pos/"+result[1], "_blank", "scrollbars=1,resizable=1,height=300,width=450"); 
						    }
						}
						if(print_done){
							if(command=='update'){
								console.log("inside update");
								window.location=base_url+"sales";		
							}
							else{
							    $("#hidden_order_id").val(0);
							    $("#hidden_order_id").val(0);
								$("#order_payment_status").val(0);
                                $("#print_bill_id").val(0);  
								console.log("inside else");
								success.currentTime = 0;
								success.play();
								toastr['success']("Invoice Saved Successfully!");
								
								//window.location=base_url+"pos";		
							//	$(".items_table > tbody").empty();
								$(".discount_input").val(0);
								
								$('#card_modal').modal('hide');
							
								var rc=$("#payment_row_count").val();
								while(rc>1){
									remove_row(rc);
									rc--;
								}
								console.log('inside form');
								$("#pos-form")[0].reset();
                                $(".items_table > tbody").empty();
								$("#customer_id").val(1).select2();

							//	final_total();
								//get_details();
								//hold_invoice_list();
								//window.location=base_url+"pos";

							}
						   	      var id=1;
								  $.post("<?php echo $base_url; ?>pos/cart_detail",{id:id},function(result_data_response){
                                    $("#pos-form-tbody").html(result_data_response);
                                    $.post("<?php echo $base_url; ?>pos/cart_summery",{id:id},function(result_data_response_summery){
                                      var cart_summery=result_data_response_summery.split('~')
                                    $(".tot_qty").text(cart_summery['0']) ;
                                    $(".tot_amt").text(cart_summery['2']) ;
                                    $(".tot_grand").text(cart_summery['1']) ;
                                    var	net_amount = cart_summery['1'];
                                     $(".sales_div_tot_payble ").html((parseFloat(round_off(net_amount))).toFixed(2));
                                     $("#card_amount_detail").val(net_amount);
                                    
                                    });
                        
                                  });	
						}
					//	window.location="<?php echo $base_url; ?>pos";
					}
					else if(result[0]=2)
					{
					   toastr['error']("Sorry! Failed to save Record.Try again");
					}
					else
					{
						alert(result);
					}
				} // data.result end
				
				if(result[0]=3){
				//	$(".search_div").html('');
   				//	$(".search_div").html(result[2]);	
				}
				if(result[0]=4){
    			//	$("#hold_invoice_list").html('').html(result[3]);
    			//	$(".hold_invoice_list_count").html('').html(result[4]);
				}
				

			//	$("."+this_btn).attr('disabled',false);  //Enable Save or Update button
				$(".overlay").remove();
		   }
	   });
	} //confirmation sure
		}); //confirmation end

//e.preventDefault


//});
}//Save End

function print_lastinvoice(saleid){
   window.open("<?= base_url();?>pos/print_last_invoice_pos/", "_blank", "scrollbars=1,resizable=1,height=500,width=500"); 
}
function print_dayend(){
   window.open("<?= base_url();?>pos/dayEnd/", "_blank", "scrollbars=1,resizable=1,height=500,width=500"); 
}
function print_dashboard(){
   window.open("<?= base_url();?>/dashboard", "_blank", "scrollbars=1,resizable=1,height=500,width=500"); 
}

 $('body').on("click",'.save_refund',function(){
     var rowcount  = $("#hidden_rowcount").val();
    var rowcount=parseInt(rowcount)-1;
    var refund_type =$("#refund_type").val();
  // $("#dr"+rowcount).prop('disabled', true);
     $("#in"+rowcount).prop('disabled', true);
    var lastitem  = $("#tr_item_id_"+rowcount).val();
    $("#hidden_refund_item").val(lastitem);
    var lastprice = $("#tr_sales_price_temp_"+rowcount).val();
     $("#refund_type_"+rowcount).val(refund_type);
     $("#refund_id_"+rowcount).val(1);
  // var newincrementro="td_"+rowcount+'_2';
  var newprive ="-"+(lastprice);
  // var ds=$("#"+newincrementro+" .qtydata").val();
  var sales_price_id ="sales_price_"+rowcount; 
  $("#"+sales_price_id).val(newprive);
  $("#"+sales_price_id).prop('disabled', true);
  make_subtotal(lastitem,rowcount);
  
  
  
    $('#refundmodal').modal('hide');
 });
 $(document).ready(function(){
 $('body').on('click','label.btn',function() {
            //Find the child check box.
            var $input = $(this).find('input');

            $(this).toggleClass('bg-purple bg-aqua');
            //Remove the attribute if the button is "disabled"
            if ($(this).hasClass('bg-purple')) {
                $input.removeAttr('checked');
            } else {
                $input.attr('checked', '');
            }

            return false; //Click event is triggered twice and this prevents re-toggling of classes
        });

        $('body').on("click",'.addtocartaddon',function(){
     var addonadded=0; 
     var ProductId =''
     var pids_product=$(this).attr('pids_product');
     var et=0;
     var sList = "";
     var sme=0;
     var yourArray = [];
     $("input:checkbox[name=addoncheckbox]:checked").each(function(){
    yourArray.push($(this).val());
});
     $("input:checkbox[name=addoncheckbox]:checked").each(function(index, item){
    
    var sThisVal = (this.checked ? "1" : "0");
    sList = (sList=="" ? sThisVal : parseInt(sList)+1);
     var  addon_id   = $(this).val();
     var  ProductId = $(this).attr('product-id');
     var  addon_price = $(this).attr('addon-price');
     var addon_name = $(this).attr('addon-name');
     var note=$('#txtmod'+ProductId).val();
     var  qty=1;
     
     
     //for addto cart
     var id =$(this).attr('product-id');
     var rowcount        =$("#hidden_rowcount").val();//0,1,2...
    var item_id         =$('#div_'+id).attr('data-item-id');
    var item_name       =$('#div_'+id).attr('data-item-name');
    var stock   =$('#div_'+id).attr('data-item-available-qty');
    var tax_type   =$('#div_'+id).attr('data-item-tax-type');
    var tax_id   =$('#div_'+id).attr('data-item-tax-id');
    var tax_value   =$('#div_'+id).attr('data-item-tax-value');
    var tax_name   =$('#div_'+id).attr('data-item-tax-name');
    var tax_amt   =$('#div_'+id).attr('data-item-tax-amt');
    var item_cost     =$('#div_'+id).attr('data-item-cost');
     var sales_price     =$('#div_'+id).attr('data-item-sales-price');
    var sales_price_temp=sales_price;
    sales_price     =(parseFloat(sales_price)).toFixed(2);
    var refund_item_id=$("#hidden_refund_item").val();
    $("#hidden_lastitem").val(id);
    $("#hidden_lastprice").val(sales_price);  
     
    var  et =0;
     
     
     
     
     
     // for add to cart end
     
     
     var sd=yourArray[yourArray.length - 1];
    //  alert(sd);
    
   //  alert('curr----'+addon_id+'last value--'+sd);
     if(sd==addon_id){
          $.post("<?php echo $base_url; ?>pos/add_product_cart",{id:id,sales_price:sales_price,qtye:1,yourArray:yourArray},function(result_data){
        if(result_data) {
		//alert(result_data);
		//console.log(result_data);
		}
		});
         
     }
     
     
     $.post("<?php echo $base_url; ?>pos/addonsave_cart",{productId:ProductId,addon_id:addon_id,addon_price:addon_price,addon_name:addon_name,qty:qty,note:note},function(result){
     
     
     sme++;
    
     //var is_last_item = (index == (arr.length - 1));
     
     
    
     
     
      $.post("<?php echo $base_url; ?>pos/cart_detail",{productId:ProductId},function(result_data_response){
          
           
          
            $("#pos-form-tbody").html(result_data_response);
            $.post("<?php echo $base_url; ?>pos/cart_summery",{productId:ProductId},function(result_data_response_summery){
              var cart_summery=result_data_response_summery.split('~')
            $(".tot_qty").text(cart_summery['0']) ;
            $(".tot_amt").text(cart_summery['2']) ;
            $(".tot_grand").text(cart_summery['1']) ;
            var	net_amount = cart_summery['1'];
             $(".sales_div_tot_payble ").html((parseFloat(round_off(net_amount))).toFixed(2));
             $("#card_amount_detail").val(net_amount);
            
            });

          });




      $('#myModalmodifier').modal('hide');
          
       
            
       });  
       
       
       
       
     if(et==1){
     //    alert();
     /// show_cartaddon(ProductId,0);
    }
    
    
   // yourArray.push($(this).val());
    });
    
   
   // console.log("---------------------------dudu----------"+sme);
  //  alert(sList);
    
  // show_cartaddon(pids_product,0);
  //  $('#myModalmodifier').modal('hide'); 
   
  });



 














      });
      
      $('body').on('click','.save_place_order',function (e) {
// $('.save_place_order').click(function (e) {
	var base_url=$("#base_url").val().trim();
    var table_number=$(".table_number").val();
  var order_type=$("#order_type").val();
  var order_number=$("#order_number").val();
  
	var data = new Array(2);
		data= new FormData($('#pos-form')[0]);//form name
	swal({ title: "Are you sure?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
			  if(sure) {//confirmation start

	
        var  ProductId =1;
		$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
		$.post("<?php echo $base_url; ?>pos/pos_place_order",{table_number:table_number,order_type:order_type,order_number:order_number},function(result){
      //alert(result);//return;
      console.log(result);
      var sales_id=result;
      var print_done =window.open(base_url+"pos/print_kot_pos/"+sales_id, "_blank", "scrollbars=1,resizable=1,height=300,width=450");
      $.post("<?php echo $base_url; ?>pos/cart_detail",{productId:ProductId},function(result_data_response){
            $("#pos-form-tbody").html(result_data_response);
            $.post("<?php echo $base_url; ?>pos/cart_summery",{productId:ProductId},function(result_data_response_summery){
              var cart_summery=result_data_response_summery.split('~')
            $(".tot_qty").text(cart_summery['0']) ;
            $(".tot_amt").text(cart_summery['2']) ;
            $(".tot_grand").text(cart_summery['1']) ;
            var	net_amount = cart_summery['1'];
             $(".sales_div_tot_payble ").html((parseFloat(round_off(net_amount))).toFixed(2));
             $("#card_amount_detail").val(net_amount);
            });
            	$("#hidden_order_id").val(0);
           // window.location="<?php echo $base_url; ?>pos";
          });
      $(".overlay").remove();
      $("#placeorder_modal").modal('hide');

    });
	} //confirmation sure
		}); //confirmation end

//e.preventDefault


});

//order_type
$('body').on('click','.order_type',function (e) {
  var currentid=$(this).attr('order_value');
  $('.order_type').removeClass("btn-danger");
  $('.order_type').addClass("btn-primary");
  $(this).addClass("btn-danger");
  $(this).removeClass("btn-primary");
  $("#order_type").val(currentid);
  if(currentid==2){
    $("#orderdiv").show();
    //$("#full_table").show();
    $("#empty_table").hide();
    
  }else{
    $("#orderdiv").hide();
    $("#full_table").hide();
    $("#empty_table").show();
  }

});
//order_number
$('body').on('click','.orderClk',function (e) {
  var currentid=$(this).attr('orderNumberid');
  var tableId  =$(this).attr('tableId');
  var tbldiv="tbldivkot"+tableId;
  $(".table-number").removeClass('active');
   $("#"+tbldiv).addClass('active');
//   $("#"+tbldiv).addClass('active');
//   $.post("<?php echo $base_url; ?>pos/table_number",{currentid:currentid},function(result_table){
//   $("#order_number").val(currentid);   
//   var orddiv="ordernum"+currentid;
//   $(".ord-number").removeClass('active');
//   $("#"+orddiv).addClass('active');
//   $("#table_number").val(result_table);
  
//   var tbldiv="tbldiv"+result_table;
//   $(".table-number").removeClass('active');
//   $("#"+tbldiv).addClass('active');
  
  
//   });

});

//allTbl

  $('body').on('click','.allTbl',function (e) {
  var currentid_tbl=$(this).attr('table_id');
  alert(currentid_tbl);
  var tbldiv="tbldiv"+currentid_tbl;
  $(".table-number").removeClass('active');
  $("#"+tbldiv).addClass('active');
  $("#table_number").val(currentid_tbl);
  var base_url=$("#base_url").val().trim();
  var table_number=currentid_tbl;
  var order_type=$("#order_type").val();
  if(order_type==2){
  var order_number=$(this).attr('orderNumberid');
  }else{
     var order_number=$("#order_number").val(); 
  }
	var data = new Array(2);
	alert(order_number);
		data= new FormData($('#pos-form')[0]);//form name
	swal({ title: "Are you sure?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
			  if(sure) {//confirmation start
        var  ProductId =1;
		$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
		$.post("<?php echo $base_url; ?>pos/pos_place_order",{table_number:table_number,order_type:order_type,order_number:order_number},function(result){
      //alert(result);//return;
      console.log(result);
      var sales_id=result;
     // var print_done =window.open(base_url+"pos/print_kot_pos/"+sales_id, "_blank", "scrollbars=1,resizable=1,height=300,width=450");
      $.post("<?php echo $base_url; ?>pos/printer_kot_pos/"+sales_id,{productId:ProductId},function(result_pos){
        //alert();
        console.log(result_pos);
      });
      $.post("<?php echo $base_url; ?>pos/cart_detail",{productId:ProductId},function(result_data_response){
            $("#pos-form-tbody").html(result_data_response);
            $.post("<?php echo $base_url; ?>pos/cart_summery",{productId:ProductId},function(result_data_response_summery){
              var cart_summery=result_data_response_summery.split('~')
            $(".tot_qty").text(cart_summery['0']) ;
            $(".tot_amt").text(cart_summery['2']) ;
            $(".tot_grand").text(cart_summery['1']) ;
            var	net_amount = cart_summery['1'];
             $(".sales_div_tot_payble ").html((parseFloat(round_off(net_amount))).toFixed(2));
             $("#card_amount_detail").val(net_amount);
            });
            	$("#hidden_order_id").val(0);
            //window.location="<?php echo $base_url; ?>pos";
          });
      $(".overlay").remove();
      $("#placeorder_modal").modal('hide');

    });
	} //confirmation sure
		}); //confirmation end

//e.preventDefault
});



$('body').on('click','.running_ord_btn',function (e) {
    
    var id =1;
        var base_url=$("#base_url").val().trim();
        $.post(base_url+"pos/running_order_ajax",{id:id},function(result_data){
        if(result_data) {
        $("#latest_running_orders_ajax").html(result_data);
        $("#runningmodal").modal('show');
        }	
        
        });
    
    
    
  

});
//addkotbtn
$('body').on('click','.addkotbtn',function (e) {
    
     if($(".items_table tr").length==1){
    	toastr["warning"]("Empty Sales List!!");
		return;
    }else{
     var id =1;
        var base_url=$("#base_url").val().trim();
        $.post(base_url+"pos/running_table",{id:id},function(result_data){
        if(result_data) {
        $("#running_table_list").html(result_data);
        $("#order_type").val('2');    
        $("#running_table").show();    
        $("#empty_table").hide();
        $("#placeorder_modal").modal('show');
        }	
        
        });  
    }
});
$('body').on('click','.place_new_order',function (e) {
     var hidden_order_id=$("#hidden_order_id").val();
    if(hidden_order_id!=0){
        toastr["warning"]("You have selected running order's");
        return;
    }
     if($(".items_table tr").length==1){
    	toastr["warning"]("Empty Sales List!!");
		return;
    }else{
        var id =1;
        var base_url=$("#base_url").val().trim();
        $.post(base_url+"pos/running_table",{id:id},function(result_data){
        if(result_data) {
        $("#running_table_list").html(result_data);
        // $("#empty_table").show();
        // $("#running_table").hide();
        $("#order_type").val('1');    
        $("#running_table").hide();    
        $("#empty_table").show();
        $("#placeorder_modal").modal('show');
        }	
        
        });    

    }
});

//third_party_order
$('body').on('click','.third_party_order',function (e) {
     var current_id =$(this).attr('id');
  	swal({ title: "Are you sure ?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
			  if(sure) {//confirmation start
			   
			    $.post("<?php echo $base_url; ?>pos/price_third_party",{current_id:current_id},function(result_third){
              // alert(result_third);
                window.location="<?php echo $base_url; ?>pos";
  });
			  
			  
			  
			  }
  	});

});


	

$('body').on('click','.newsaleord',function (e) {
     var current_id =0;
       $("#order_payment_status").val(0);
    $("#order_payment_status").val(0);
     $("#print_bill_id").val(0);   
  	swal({ title: "Are you sure ?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
			  if(sure) {//confirmation start
			   $("#order_payment_status").val(0);
    $("#order_payment_status").val(0);
     $("#print_bill_id").val(0);  
			    	var id =1;
		var base_url=$("#base_url").val().trim();
		$.post(base_url+"pos/voidCart",{id:id},function(result_data){
			if(result_data) {
			  $.post(base_url+"pos/cart_detail",{id:id},function(result_data_response){
				$("#pos-form-tbody").html(result_data_response);
				$.post(base_url+"pos/cart_summery",{id:id},function(result_data_response_summery){
				  var cart_summery=result_data_response_summery.split('~')
				$(".tot_qty").text(0) ;
				$(".tot_amt").text(0) ;
				$(".tot_grand").text(0) ;
				
				});
	
			  });
	
	
			}	

		});
			  
			  
			  }
  	});

});
$('body').on('click','.signout',function (e) {
     var current_id =0;
  	swal({ title: "Are you sure ?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
			  if(sure) {//confirmation start
			  
                window.location="<?php echo $base_url; ?>logout";

			  
			  }
  	});

});

$('body').on('click','.running_orderbill',function (e) {
              var order_id=$(this).attr('order_id_running');
             var payment_status=$(this).attr('payment_status');
                
             $("#order_payment_status").val(payment_status);
             if(payment_status==1){
             $("#print_bill_id").val(order_id);
             }else{
               $("#print_bill_id").val(0);  
             }
             $("#hidden_order_id").val(order_id);
	         var data = new Array(2);
		    data= new FormData($('#pos-form')[0]);//form name
            var  ProductId =1;
            $.post("<?php echo $base_url; ?>pos/running_orderlist_detail",{order_id:order_id},function(result_data_response){
              $("#pos-form-tbody").html(result_data_response);
              $.post("<?php echo $base_url; ?>pos/running_order_detail",{order_id:order_id},function(result_data_response_summery){
              var cart_summery=result_data_response_summery.split('~')
              $(".tot_qty").text(cart_summery['0']) ;
              $(".tot_amt").text(cart_summery['2']) ;
              $(".tot_grand").text(cart_summery['1']) ;
              var	net_amount = cart_summery['1'];
              $(".sales_div_tot_payble ").html((parseFloat(round_off(net_amount))).toFixed(2));
              $("#card_amount_detail").val(net_amount);
              $("#hidden_order_id").val(order_id);
            });
          });
      $("#runningmodal").modal('hide');
});

function print_bill(){
    var print_bill_id =$("#print_bill_id").val();
   if(print_bill_id > 0){
     window.open("<?= base_url();?>pos/print_invoice_pos/"+print_bill_id, "_blank", "scrollbars=1,resizable=1,height=500,width=500"); 
      var id =1;
		var base_url=$("#base_url").val().trim();
		$.post(base_url+"pos/voidCart",{id:id},function(result_data){
			if(result_data) {
			  $.post(base_url+"pos/cart_detail",{id:id},function(result_data_response){
				$("#pos-form-tbody").html(result_data_response);
				$.post(base_url+"pos/cart_summery",{id:id},function(result_data_response_summery){
				  var cart_summery=result_data_response_summery.split('~')
				$(".tot_qty").text(0) ;
				$(".tot_amt").text(0) ;
				$(".tot_grand").text(0) ;
				  $("#order_payment_status").val(0);
                  $("#order_payment_status").val(0);
                  $("#print_bill_id").val(0);   
				});
	
			  });
	
	
			}	

		});
	  $("#order_payment_status").val(0);
     $("#order_payment_status").val(0);
     $("#hidden_order_id").val(0);
      $("#print_bill_id").val(0);
   }
   
   		
   
}
 $(document).ready(function(){
    setInterval(function(){ 
         var id =1;
        var base_url=$("#base_url").val().trim();
        $.post(base_url+"pos/store_pickup_order_ajax",{id:id},function(result_data){
        if(result_data) {
         $("#storepickup_tbody").html(result_data);
         var pickup_count =$('#storepickup_tbody span:last').text();
         $(".storepickup_count").text(pickup_count);
        
        }	
        });
        $.post(base_url+"pos/online_order_ajax",{id:id},function(result_data){
            if(result_data) {
             $("#online_order_ajax_tbody").html(result_data);
             var pickup_count =$('#online_order_ajax_tbody span:last').text();
             $(".online_count").text(pickup_count);
            }	
        });
        
        $.post(base_url+"pos/instore_order_ajax",{id:id},function(result_data){
            if(result_data) {
             $("#instore_order_ajax_body").html(result_data);
             var pickup_count =$('#instore_order_ajax_body span:last').text();
             $(".instore_count").text(pickup_count);
            }	
        });
        
    }, 2000);
    
    
    
    
    
    });

function print_kot_pos(id){
  window.open("<?= base_url();?>pos/print_kot_pos/"+id, "_blank", "scrollbars=1,resizable=1,height=500,width=500");
}



</script>

<?php
$CI=&get_instance();
?>
<input type="hidden"  id="csrf_hash"  value="<?php echo $CI->security->get_csrf_hash(); ?>"/>
<input type="hidden"  id="token_name"  value="<?php echo $CI->security->get_csrf_token_name(); ?>"/>


  
</div>



 <div class="modal fade" id="fullscreen-modal">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    
                    <div class="modal-body">
                      
                        <div class="row row-flex">
                          <div class="col-md-12">
                        
                             <div class="form-group text-center">
                                <button type="button" class="btn btn-primary  btn-lg display_fullscreen">Save</button>
                                </div>
                          </div>
                        </div>
                     
                    </div>

                      
                  
                 
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>











</body>
</html>

   
    <script language="javascript">
    $('.dropdown').hover(function(){ 
  $('.dropdown-toggle', this).trigger('click'); 
});


    </script>
    		<script>
// function launchFullscreen(element) {
//   if(element.requestFullscreen) {
//     element.requestFullscreen();
//   } else if(element.mozRequestFullScreen) {
//     element.mozRequestFullScreen();
//   } else if(element.webkitRequestFullscreen) {
//     element.webkitRequestFullscreen();
//   } else if(element.msRequestFullscreen) {
//     element.msRequestFullscreen();
//   }
// }
/*		if (document.fullscreenEnabled) {
			
			var btn = document.getElementById("toggle");
			
			btn.addEventListener("load", function (event) {
				
				if (!document.fullscreenElement) {
					document.documentElement.requestFullscreen();
				} else {
					document.exitFullscreen();
				}
				
			}, false);
			
			
			document.addEventListener("fullscreenchange", function (event) {
				
				console.log(event);
				
				if (!document.fullscreenElement) {
					btn.innerText = "Activate fullscreen";
				} else {
					btn.innerText = "Exit fullscreen";
				}
			});
			
			document.addEventListener("fullscreenerror", function (event) {
				
				console.log(event);
				
			});
		}*/
/*$("#fullscreen").on("load", function() 
{
//console.log("fullscreen class called");
document.fullScreenElement && null !== document.fullScreenElement || !document.mozFullScreen && !document.webkitIsFullScreen ? document.documentElement.requestFullScreen ? document.documentElement.requestFullScreen() : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen() : document.documentElement.webkitRequestFullScreen && document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT) : document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen && document.webkitCancelFullScreen()
});	

document.getElementById("fullscreen").onload = function() {myFunction()
   document.fullScreenElement && null !== document.fullScreenElement || !document.mozFullScreen && !document.webkitIsFullScreen ? document.documentElement.requestFullScreen ? document.documentElement.requestFullScreen() : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen() : document.documentElement.webkitRequestFullScreen && document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT) : document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen && document.webkitCancelFullScreen() document.fullScreenElement && null !== document.fullScreenElement || !document.mozFullScreen && !document.webkitIsFullScreen ? document.documentElement.requestFullScreen ? document.documentElement.requestFullScreen() : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen() : document.documentElement.webkitRequestFullScreen && document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT) : document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen && document.webkitCancelFullScreen()
}

;*/
		</script>