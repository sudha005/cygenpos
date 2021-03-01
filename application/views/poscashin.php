<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/iCheck/square/blue.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

  <style type="text/css">
     .main-footer{
         display:none;
     }
    .select2-container--default .select2-selection--single{
      border-radius: 0px;
    }
    .row-flex {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
        -ms-flex-pack: center;
            justify-content: center;

}
.savecash_in{
        font-family: 'Montserrat', sans-serif;
    text-transform: uppercase;
    font-size: 13px;
    font-weight: 600;
    display: inline-block;
    padding: 6px 20px;
    border-radius: 20px;
}
    /*LEFT SIDE: ITEMS TABLE*/
    .table-striped > tbody > tr:nth-of-type(2n+1) {
      background-color: #ede3e3;
    }
    .table-striped > tbody > tr {
      background-color: #ddc8c8;
    }
    .cash-in-control{
            background: #f5f6f7;
    border-color: #f5f6f7;
    border-radius: 20px;
    }
    .label-cash-in{
            font-family: 'Montserrat', sans-serif;
    font-weight: 500;
    text-align: center;
    display: block;
    font-size: 13px;
           font-family: 'Montserrat', sans-serif; 
    }
.cash-in-modal{
        background: #337ab7;
    padding: 10px;
    font-family: 'Montserrat', sans-serif;
    text-align: center;
    text-transform: uppercase;
    font-weight: 600;
    color: #fff;
}
    /*SET TOTAL FONT*/
    .tot_qty, .tot_amt, .tot_disc, .tot_grand {
      font-size: 19px;
      color: #023763 ;
    }
    /*CURSOR POINTER CLASS*/
    .pointer{
      cursor:pointer;
    }
    .navbar-nav > .user-menu > .dropdown-width-lg{
      width: 350px;
    }
    .header-custom{
      background-image: -webkit-gradient(linear, left top, right top, from(#20b9ae), to(#006fd6)); color: white;
    }
    .pointer {
    font-size: 12px!important;
}
    .border-custom-bottom{
      border-bottom: 1px solid;
      padding-top: 10px;
      padding-bottom: 5px;
    }
    .custom-font-size{
      font-size: 22px;
    }
    .search_item{
      text-transform: uppercase;
      font-size: 10px;
      color: #000000;
      text-align: center;
      text-overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
    }
    .item_image{
      min-width: 70px;
      min-height:  70px;
      max-width: 70px;
      max-height:  70px;
    }
    .item_box{
      border-top:none;
    }
  </style>
</head>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
  <script type="text/javascript">
    if(theme_skin!='skin-blue'){
      $("body").addClass(theme_skin);
      $("body").removeClass('skin-blue');
    }
    if(sidebar_collapse=='true'){
      $("body").addClass('sidebar-collapse');
    }
  </script> 
  <?php $CI =& get_instance(); ?>
<div class="wrapper">
  
  
  <header class="main-header" style = display:none;>
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="<?php echo $base_url; ?>dashboard" class="navbar-brand" title="Go to Dashboard!"><b class="hidden-xs"><?php  echo $SITE_TITLE;?></b><b class="hidden-lg">POS</b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <?php if($CI->permissions('sales_view')) { ?>
            <li class=""><a href="<?php echo $base_url; ?>sales" title="View Sales List!"><i class="fa fa-list text-yellow" ></i> <span><?= $this->lang->line('sales_list'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('sales_add')) { ?>
            <li class=""><a href="<?php echo $base_url; ?>pos" title="Create New POS Invoice"><i class="fa fa-calculator text-yellow " ></i> <span><?= $this->lang->line('new_invoice'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('items_view')) { ?>
            <li class=""><a href="<?php echo $base_url; ?>items/" title="View Items List"><i class="fa  fa-cubes text-yellow " ></i> <span><?= $this->lang->line('items_list'); ?></span></a></li>
            <?php } ?>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Click To View Hold Invoices">
             
              <span class=""><?= $this->lang->line('hold_list'); ?></span>
              <span class="label label-danger hold_invoice_list_count"><?=$tot_count?></span>
            </a>

            <ul class="dropdown-menu dropdown-width-lg">
              
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-12 text-center " style="max-height:300px;overflow-y: scroll;">
                    <table class="table table-bordered" width="100%">
                      <thead>
                      <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Ref.ID</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody id="hold_invoice_list" >
                       <?=$result?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.row -->
              <!--</li>-->
            </ul>
          </li>

            <!-- Messages: style can be found in dropdown.less-->
            <li class="hidden-xs" id="fullscreen"><a title="Fullscreen On/Off"><i class="fa fa-tv text-white" ></i> </a></li>
            <li class="text-center" id="">
            <a title="Dashboard" href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard text-yellow" ></i><b class="hidden-xs"><?= $this->lang->line('dashboard'); ?></b></a>
          </li>

            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo get_profile_picture(); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php print ucfirst($this->session->userdata('inv_username')); ?></span>
            </a>

            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo get_profile_picture(); ?>" class="img-circle" alt="User Image">

                <p>
                 <?php print ucfirst($this->session->userdata('inv_username')); ?>
                  <small>Year <?=date("Y");?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo $base_url; ?>users/edit/<?= $this->session->userdata('inv_userid'); ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo $base_url; ?>logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>

  <?php $css = ($this->session->userdata('language')=='Arabic' || $this->session->userdata('language')=='Urdu') ? 'margin-right: 0 !important;': '';?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="<?=$css;?>">
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
    <section class="content">
        <?php $user_id11 = $this->session->userdata('inv_userid'); ?>
         
      
            <!-- form start -->
            <form class="form-horizontal" id="pos-form" >
         
            
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" value='0' id="hidden_rowcount" name="hidden_rowcount">
              <input type="hidden" value='' id="hidden_invoice_id" name="hidden_invoice_id">
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">

              <input type="hidden" value='' id="temp_customer_id" name="temp_customer_id">
              
              <!-- **********************MODALS***************** -->
             <?php include"modals_pos_payment/modal_payments_multi.php"; ?>
              <!-- **********************MODALS END***************** -->
              <!-- **********************MODALS***************** -->
              
              <div class="modal fade" id="cashin-modal">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header cash-in-modal">
                    Cash In
                    </div>
                    <div class="modal-body">
                      
                        <div class="row row-flex">
                          <div class="col-md-8">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="total_amount" class="label-cash-in">Enter the Amount in cash drawer</label>
                                <input type="text" class="form-control cash-in-control" id="amount" name="amount" placeholder="">
                                <input type="hidden" id="user_id11" name="user_id11" value="<?php echo $user_id11; ?>">
                              </div>
                            </div>
                             <div class="form-group text-center">
                                <button type="button" class="btn btn-primary savecash_in">Save</button>
                                </div>
                          </div>
                        </div>
                     
                    </div>

                      
                  
                 
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            </form>
        
    

</div>
<!-- ./wrapper -->

<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- GENERAL CODE -->
<?php include"comman/code_js_form.php"; ?>

<!-- iCheck -->
<script src="<?php echo $theme_link; ?>plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo $theme_link; ?>js/fullscreen.js"></script>
<script src="<?php echo $theme_link; ?>js/modals.js"></script>
<script src="<?php echo $theme_link; ?>js/pos.js?v=164"></script>
<script src="<?php echo $theme_link; ?>js/mousetrap.min.js"></script>
<!-- DROP DOWN -->
<script src="<?php echo $theme_link; ?>dist/js/bootstrap3-typeahead.min.js"></script>  
<!-- DROP DOWN END-->


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

//LEFT SIDE: ON CLICK ITEM ADD TO INVOICE LIST
function addrow(id){
     //addon_modal
    //CHECK SAME ITEM ALREADY EXIST IN ITEMS TABLE 
    var item_check=check_same_item($('#div_'+id).attr('data-item-id'));
    if(!item_check){return false;}
    var rowcount        =$("#hidden_rowcount").val();//0,1,2...
    var item_id         =$('#div_'+id).attr('data-item-id');
    var item_name       =$('#div_'+id).attr('data-item-name');
    var stock   =$('#div_'+id).attr('data-item-available-qty');
    var tax_type   =$('#div_'+id).attr('data-item-tax-type');
    var tax_id   =$('#div_'+id).attr('data-item-tax-id');
    var tax_value   =$('#div_'+id).attr('data-item-tax-value');
    var tax_name   =$('#div_'+id).attr('data-item-tax-name');
    var tax_amt   =$('#div_'+id).attr('data-item-tax-amt');
    //var gst_per         =$('#div_'+id).attr('data-item-tax-per');
    //var gst_amt         =$('#div_'+id).attr('data-item-gst-amt');
    var item_cost     =$('#div_'+id).attr('data-item-cost');
    var sales_price     =$('#div_'+id).attr('data-item-sales-price');
    var sales_price_temp=sales_price;
        sales_price     =(parseFloat(sales_price)).toFixed(2);

    var quantity        ='<div class="input-group input-group-sm"><span class="input-group-btn"><button onclick="decrement_qty('+item_id+','+rowcount+')" type="button" class="btn btn-default btn-flat"><i class="fa fa-minus text-danger"></i></button></span>';
        quantity       +='<input typ="text" value="1" class="form-control no-padding text-center" onkeyup="item_qty_input('+item_id+','+rowcount+')" id="item_qty_'+item_id+'" name="item_qty_'+item_id+'">';
        quantity       +='<span class="input-group-btn"><button onclick="increment_qty('+item_id+','+rowcount+')" type="button" class="btn btn-default btn-flat"><i class="fa fa-plus text-success"></i></button></span></div>';
    var sub_total       =(parseFloat(1)*parseFloat(sales_price)).toFixed(2);//Initial
    var remove_btn      ='<a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="removerow('+rowcount+')" title="Delete Item?"></a>';

    var str=' <tr class="car_'+item_id+'" id="row_'+rowcount+'" data-row="0" data-item-id='+item_id+'>';/*item id*/
        str+='<td class="caritemname_'+item_id+'" id="td_'+rowcount+'_0"><a data-toggle="tooltip" title="Click to Change Tax" class="pointer" id="td_data_'+rowcount+'_0" onclick="show_sales_item_modal('+rowcount+')">'+ item_name     +'</a> <i onclick="show_sales_item_modal('+rowcount+')" class="fa fa-edit pointer"></i></td>';/* td_0_0 item name*/ 
         str+='<td style="display:none" id="td_'+rowcount+'_1">'+ stock +'</td>';/* td_0_1 item available qty*/
        str+='<td id="td_'+rowcount+'_2">'+ quantity      +'</td>';/* td_0_2 item available qty*/
            info='<input id="sales_price_'+rowcount+'" onblur="set_to_original('+rowcount+','+item_cost+')" onkeyup="update_price('+rowcount+','+item_cost+')" name="sales_price_'+rowcount+'" type="text" class="form-control no-padding " value="'+sales_price+'">';
        str+='<td id="td_'+rowcount+'_3" class="text-right">'+ info   +'</td>';/* td_0_3 item sales price*/
        /*Tax amt*/
        str+='<td id="td_'+rowcount+'_11"><input data-toggle="tooltip" title="Click to Change" id="td_data_'+rowcount+'_11" onclick="show_sales_item_modal('+rowcount+')" name="td_data_'+rowcount+'_11" type="text" class="form-control no-padding pointer" readonly value="'+tax_amt+'"></td>';

        str+='<td id="td_'+rowcount+'_4" class="text-right caritemprice_'+item_id+'"><input data-toggle="tooltip" title="Total" id="td_data_'+rowcount+'_4" name="td_data_'+rowcount+'_4" type="text" class="form-control no-padding pointer" readonly value="'+sub_total+'"></td>';/* td_0_4 item sub_total */
        str+='<td id="td_'+rowcount+'_5">'+ remove_btn    +'</td>';/* td_0_5 item gst_amt */

        str+='<input type="hidden" name="tr_item_id_'+rowcount+'" id="tr_item_id_'+rowcount+'" value="'+item_id+'">';
       // str+='<input type="hidden" id="tr_item_per_'+rowcount+'" name="tr_item_per_'+rowcount+'" value="'+gst_per+'">';
        str+='<input type="hidden" id="tr_sales_price_temp_'+rowcount+'" name="tr_sales_price_temp_'+rowcount+'" value="'+sales_price_temp+'">';
        str+='<input type="hidden" id="tr_tax_type_'+rowcount+'" name="tr_tax_type_'+rowcount+'" value="'+tax_type+'">';
        str+='<input type="hidden" id="tr_tax_id_'+rowcount+'" name="tr_tax_id_'+rowcount+'" value="'+tax_id+'">';
        str+='<input type="hidden" id="tr_tax_value_'+rowcount+'" name="tr_tax_value_'+rowcount+'" value="'+tax_value+'">';
        str+='<input type="hidden" id="description_'+rowcount+'" name="description_'+rowcount+'" value="">';

        str+='</tr>';   

    //LEFT SIDE: ADD OR APPEND TO SALES INVOICE TERMINAL
    $('#pos-form-tbody').append(str);

    //LEFT SIDE: INCREMANT ROW COUNT
    $("#hidden_rowcount").val(parseFloat($("#hidden_rowcount").val())+1);
    failed.currentTime = 0;
    failed.play();
    //CALCULATE FINAL TOTAL AND OTHER OPERATIONS
    //final_total();

    make_subtotal(item_id,rowcount);

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
  var item_qty=$("#item_qty_"+item_id).val();
  var stock=$("#td_"+rowcount+"_1").html();
  if(parseFloat(item_qty)<parseFloat(stock)){
    item_qty=parseFloat(item_qty)+1;
    $("#item_qty_"+item_id).val(item_qty);
  }
  make_subtotal(item_id,rowcount);
}
//DECREMENT ITEM
function decrement_qty(item_id,rowcount){
  var item_qty=$("#item_qty_"+item_id).val();
  if(item_qty<=1){
    $("#item_qty_"+item_id).val(1);
    return;
  }
  $("#item_qty_"+item_id).val(parseFloat(item_qty)-1);
  make_subtotal(item_id,rowcount);
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
  $(".tot_qty   ").html(tot_qty);
  $(".tot_amt   ").html((round_off(tot_amt).toFixed(2)));
  $(".tot_disc  ").html((round_off(tot_disc).toFixed(2)));
  $(".tot_grand ").html((round_off(tot_grand)).toFixed(2));
  $(".total_tax").html(((total_tax)).toFixed(2));
}

//LEFT SIDE: FINAL TOTAL
function adjust_payments(){
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
  var balance = total-discount_amt-paid_amount;
  if(balance < 0){
    //console.log("Negative");
    change_return = Math.abs(parseFloat(balance));
    balance = 0;
  }
  
  balance =round_off(balance);
  $(".sales_div_tot_qty  ").html(item_qty);
  $(".sales_div_tot_amt  ").html((round_off(total)).toFixed(2));
  $(".sales_div_tot_discount ").html((parseFloat(round_off(discount_amt))).toFixed(2)); 
  $(".sales_div_tot_payble ").html((parseFloat(round_off(total-discount_amt))).toFixed(2)); 
  $(".sales_div_tot_paid ").html((round_off(paid_amount)).toFixed(2));
  $(".sales_div_tot_balance ").html((parseFloat(round_off(balance))).toFixed(2)); 
  
  /**/
  $(".sales_div_change_return ").html((change_return).toFixed(2)); 
  
}

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
  });

  //DISCOUNT UPDATE
  $(".discount_update").click(function () {
      final_total();
      $('#discount-modal').modal('toggle');    
  });

  //RIGHT SIDE: CLEAR SEARCH BOX
  $(".show_all").click(function(){
    $("#search_it").val('').trigger("keyup");
    $("#category_id").val('').trigger("change");
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
    $("#item_search").autocomplete('search');
} );

$("#item_search").autocomplete({

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
              //console.log(res);
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
                        return {
                            label: el.item_code +'--[Qty:'+el.stock+'] --'+ el.label,
                            value: '',
                            id: el.id,
                            item_name: el.value,
                            stock: el.stock,
                           // mobile: el.mobile,
                            //customer_dob: el.customer_dob,
                            //address: el.address,

                        };

                    });
                }
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
              return;
            }
            addrow(item_id);
            $("#item_search").val('');
            
            
        },   
        //loader end
});


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
  });cate
</script>
<script language = javascript>


body onLoad="if (window.resizeTo) {window.resizeTo(screen.availWidth,screen.availHeight);
window.moveTo(0,0)}"

</script>
<script type="text/javascript">
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
});
function postransaction(){
  
    var tot_grand =$(".tot_grand").text();
    
    if(tot_grand!=''){
        // alert(tot_grand);
    $.post("<?php echo $base_url; ?>pos/token_eftpos",{amount:tot_grand},function(result){
      alert((result));
      console.log(result);
    // $(".search_div").html('');
    // $(".search_div").html(result);
    // $(".overlay").remove();
    });
    }
  
}
function posrefundtransaction(){
  
    var tot_grand =$(".tot_grand").text();
    
    if(tot_grand!=''){
        // alert(tot_grand);
    $.post("<?php echo $base_url; ?>pos/token_eftpos_refund",{amount:tot_grand},function(result){
      alert((result));
      console.log(result);
    // $(".search_div").html('');
    // $(".search_div").html(result);
    // $(".overlay").remove();
    });
    }
  
}




</script>
<script type="text/javascript">
    $(window).on('load',function(){
         $('#cashin-modal').modal({
           backdrop: 'static',
           keyboard: false
    });
    });
   
</script>


</body>
</html>
