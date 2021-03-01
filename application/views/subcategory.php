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
	if(!isset($subcategory_name)){
      $show_small_image=$show_big_image=$subcategory_code=$subcategory_name=$description=$subcat_image=$cat_id="";
	}
 ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small>Add/Update Sub Category</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>subcategory/view">Sub Category List</a></li>
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
            <form class="form-horizontal" id="subcategory-form" onkeypress="return event.keyCode != 13;" enctype="multipart/form-data" mathod = "POST">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
              <div class="box-body">
                  
                   <div class="form-group">
                  <label for="cat_id" class="col-sm-2 control-label">Category Name<label class="text-danger">*</label></label>

                  <div class="col-sm-4">
          <select class="form-control select2" id="cat_id" name="cat_id"  style="width: 100%;"  >
            <?php
            $query1="select * from db_category where status=1";
            $q1=$this->db->query($query1);
            if($q1->num_rows($q1)>0)
             {
                 echo '<option value="">-Select-</option>'; 
                 foreach($q1->result() as $res1)
               {
                $selected = ($cat_id==$res1->id)? 'selected' : '';
                 echo "<option $selected value='".$res1->id."'>".$res1->category_name."</option>";
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
          <span id="country_msg" style="display:none" class="text-danger"></span>
                  </div>
                  </div>
				


			<div class="form-group">
			      <label for="subcategory_name" class="col-sm-2 control-label">Sub Category Name<label class="text-danger">*</label></label>
           <div class="col-sm-4">
             <input type="text" class="form-control input-sm" id="subcategory_name" name="subcategory_name" placeholder="" onkeyup="shift_cursor(event,'subcategory_name')" value="<?php print $subcategory_name; ?>" autofocus >
				      <span id="category_msg" style="display:none" class="text-danger"></span>
            </div>
      </div>


				<div class="form-group">
                  <label for="description" class="col-sm-2 control-label"><?= $this->lang->line('description'); ?></label>
                  <div class="col-sm-4">
                    <textarea type="text" class="form-control" id="description" name="description" placeholder=""><?php print $description; ?></textarea>
					<span id="description_msg" style="display:none" class="text-danger"></span>
                  </div>
                </div>
                
                <div class="form-group">
                 <label for="subcat_image" class="col-sm-2 control-label"><?= $this->lang->line('select_image'); ?></label>
                  <div class="col-sm-4">
                      <?php
                      if($subcat_image!=""){ ?>
                      
                      <img src="<?php print $base_url . 'uploads/subcategory/'.$subcat_image; ?> "height="100" width="100"/>
                       <?php
                      } ?>
                 <input type="file" name="subcat_image" id="subcat_image">
                 <span id="subcat_image" style="display:block;" class="text-danger">Max Width/Height: 1000px * 1000px & Size: 1MB </span>
                </div>
                </div>
                
                 <?php 
                                               $show_big_image_checkbox ='';
                                               if($show_big_image==1){
                                                $show_big_image_checkbox='checked';
                                               }
                                               ?>
                                                <div class="form-group">
                                                    <label for="show_big_image" class="col-sm-2 control-label">Show Big Image</label>
                                                   <div class="col-sm-4">
                                                      <input type="checkbox" <?=$show_big_image_checkbox;?> class="form-control" id="show_big_image" name="show_big_image" >
                                                      <span id="round_off_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                
                <?php 
                                               $show_small_image_checkbox ='';
                                               if($show_small_image==1){
                                                $show_small_image_checkbox='checked';
                                               }
                                               ?>
                                                <div class="form-group">
                                                    <label for="show_small_image" class="col-sm-2 control-label">Show Small Image</label>
                                                   <div class="col-sm-4">
                                                      <input type="checkbox" <?=$show_small_image_checkbox;?> class="form-control" id="show_small_image" name="show_small_image" >
                                                      <span id="show_small_image" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                

              </div>
              <!-- /.box-footer -->
              <div class="box-footer">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                   <!-- <div class="col-sm-4"></div> -->
                   <?php
                      if($subcategory_code!=""){
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

<script src="<?php echo $theme_link; ?>js/subcategory.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
