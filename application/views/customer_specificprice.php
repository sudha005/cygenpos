<!DOCTYPE html>
<html>

<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- </copy> -->  
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

 <?php include"sidebar.php"; ?>
 <?php
	if(!isset($customer_id)){
      $specificprice_code=$customer_id=$item_id=$new_price=$old_price="";
	}
 ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small>Add/Update Specific Price</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>customerspecificprice/view"> Customer Specific Price List</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info ">
            <div class="box-header with-border">
              <h3 class="box-title">Please Enter Valid Data</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" id="customerspecificprice-form" onkeypress="return event.keyCode != 13;">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
              <div class="box-body">
				


			       <div class="form-group">
                  <label for="customer_id" class="col-sm-2 control-label">Customer Name<label class="text-danger">*</label></label>

                  <div class="col-sm-4">
          <select class="form-control select2" id="customer_id" name="customer_id"  style="width: 100%;"  >
            <?php
            $query1="select * from db_customers where status=1";
            $q1=$this->db->query($query1);
            if($q1->num_rows($q1)>0)
             {
                 echo '<option value="">-Select-</option>'; 
                 foreach($q1->result() as $res1)
               {
                $selected = ($customer_id==$res1->id)? 'selected' : '';
                 echo "<option $selected value='".$res1->id."'>".$res1->customer_name."</option>";
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
          <span id="customer_msg" style="display:none" class="text-danger"></span>
                  </div>
                  </div>
				
				   <div class="form-group">
                  <label for="item_id" class="col-sm-2 control-label">Product Name<label class="text-danger">*</label></label>

                  <div class="col-sm-4">
          <select class="form-control select2 productListSelect" id="item_id" name="item_id"  style="width: 100%;"  >
            <?php
            $query1="select * from db_items where status=1";
            $q1=$this->db->query($query1);
            if($q1->num_rows($q1)>0)
             {
                 echo '<option value="">-Select-</option>'; 
                 foreach($q1->result() as $res1)
               {
                $selected = ($item_id==$res1->id)? 'selected' : '';
                 echo "<option $selected value='".$res1->id."'>".$res1->item_name."</option>";
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
          <span id="item_msg" style="display:none" class="text-danger"></span>
                  </div>
                  </div>


				<!--<div class="form-group">-->
    <!--              <label for="description" class="col-sm-2 control-label"><?= $this->lang->line('description'); ?></label>-->
    <!--              <div class="col-sm-4">-->
    <!--                <textarea type="text" class="form-control" id="description" name="description" placeholder=""><?php print $description; ?></textarea>-->
				<!--	<span id="description_msg" style="display:none" class="text-danger"></span>-->
    <!--              </div>-->
    <!--            </div>-->
                
                <div class="form-group">
			      <label for="old_price" class="col-sm-2 control-label">Product Price<label class="text-danger">*</label></label>
           <div class="col-sm-4">
             <input type="text" class="form-control input-sm" id="product_price" name="old_price" Readonly placeholder="" onkeyup="shift_cursor(event,'old_price')" value="<?php print $old_price; ?>" autofocus >
				      <span id="category_msg" style="display:none" class="text-danger"></span>
            </div>
      </div>
      <div class="form-group">
			      <label for="new_price" class="col-sm-2 control-label">Product New Price<label class="text-danger">*</label></label>
           <div class="col-sm-4">
             <input type="text" class="form-control input-sm" id="new_price" name="new_price" placeholder="" onkeyup="shift_cursor(event,'new_price')" value="<?php print $new_price; ?>" autofocus >
				      <span id="price_msg" style="display:none" class="text-danger"></span>
            </div>
      </div>


              </div>
              <!-- /.box-footer -->
              <div class="box-footer">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                   <!-- <div class="col-sm-4"></div> -->
                   <?php
                      if($specificprice_code!=""){
                           $btn_name="Update";
                           $btn_id="update";
                          ?>
                            <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id;?>"/>
                            <?php
                      }
                                else{
                                    $btn_name="Save";
                                    $btn_id="save";
                                }
                      
                                ?>
                                 
                   <div class="col-md-3 col-md-offset-3">
                      <button type="button" id="<?php echo $btn_id;?>" class=" btn btn-block btn-success" title="Save Data"><?php echo $btn_name;?></button>
                   </div>
                   <div class="col-sm-3">
                    <a href="<?=base_url('dashboard');?>">
                      <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                    </a>
                   </div>
                </div>
             </div>
             <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php include"footer.php"; ?>


  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- TABLES CODE -->
<?php include"comman/code_js_form.php"; ?>

<script src="<?php echo $theme_link; ?>js/customerspecificprice.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
<script>
$(document).ready(function() {
$(document).on('change', '.productListSelect', function() {
            var productId=$(this).val();
               $.ajax({
              type:'post',
              url: '<?php echo site_url('customerspecificprice/get_product_Price')?>',
              data:{
                productId:productId,
              },
              success:function(dataCategory) {
                  
                 if(dataCategory!=""){
                  $("#product_price").val(dataCategory);
                 }
              }
            });
});
              
            });

</script>
</body>
</html>
