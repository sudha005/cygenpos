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
	if(!isset($coupon)){
      $coupon=$q_id="";
  }
 ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Coupon
        <small>Add/Update Coupon</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>coupon">Coupon List</a></li>
        <li class="active">Coupon</li>
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
            <form class="form-horizontal" id="coupon-form" onkeypress="return event.keyCode != 13;">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
              <div class="box-body">
                 
                  
                  
                  
		         	<div class="form-group">
			      <label for="category" class="col-sm-2 control-label">Coupon Name<label class="text-danger">*</label></label>
           <div class="col-sm-4">
             <input type="text" class="form-control input-sm" id="coupon" name="coupon" placeholder=""  value="<?php print $coupon_name; ?>" autofocus >
				      <span id="coupon" style="display:none" class="text-danger"></span>
            </div>
      </div>
				<div class="form-group">
				  <label for="country_name" class="col-sm-2 control-label">Coupon<label class="text-danger">*</label></label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control input-sm" id="coupon_name" name="coupon_name" placeholder="" value="<?php print $coupon; ?>" autofocus >
					<span id="coupon_name_msg" style="display:none" class="text-danger"></span>
                  </div>
                </div>
                
                <div class="form-group">
			      <label for="category" class="col-sm-2 control-label">Coupon Offer(%)<label class="text-danger">*</label></label>
           <div class="col-sm-4">
             <input type="number" class="form-control input-sm" id="coupon_offertext" name="coupon_offertext" placeholder="10"  value="<?php print $coupon_offertext; ?>" autofocus >
				      <span id="coupon_offertext" style="display:none" class="text-danger"></span>
            </div>
      </div>
			    

                                <div class="form-group">
                                <label for="created_date" class="col-sm-2 control-label">Start Date</label>
                                <div class="col-sm-4">
                                <div class="input-group date">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right datepicker" id="start_date" name="start_date" value="<?= $start_date;?>">
                                </div>
                                <span id="created_date_msg" style="display:none" class="text-danger"></span>
                                </div>
                                </div>
                              
                                <div class="form-group">
                                 <label for="end_date" class="col-sm-2 control-label">End Date</label>
                                   <div class="col-sm-4">
                                 <div class="input-group date">
                                  <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right datepicker" id="end_date" name="end_date" value="<?= $end_date;?>">
                                </div>
                                 <span id="end_date_msg" style="display:none" class="text-danger"></span>
                              </div>
                               </div>
                                   <div class="form-group">
                 <label for="banner_image" class="col-sm-2 control-label"><?= $this->lang->line('select_image'); ?></label>
                  <div class="col-sm-4">
                      <?php
                      if($coupon_image!=""){ ?>
                      
                      <img src="<?php print $base_url . 'uploads/coupon/'.$coupon_image; ?> "height="100" width="100"/>
                       <?php
                      } ?>
                 <input type="file" name="coupon_image" id="coupon_image">
                 <span id="coupon_image" style="display:block;" class="text-danger">Max Width/Height: 1000px * 1000px & Size: 1MB </span>
                </div>
                </div>



              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                   <!-- <div class="col-sm-4"></div> -->
                   <?php
                      if($coupon!=""){
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

<script src="<?php echo $theme_link; ?>js/coupon.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>

</body>
</html>
