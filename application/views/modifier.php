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
	if(!isset($modifier_name)){
      $modifier_code=$modifier_name=$modifier_price=$modifier_image=$modifiergroup_id="";
	}
 ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small>Add/Update Modifier</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>modifier/view">Modifier List</a></li>
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
            <form class="form-horizontal" id="modifier-form" onkeypress="return event.keyCode != 13;">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
              <div class="box-body">
                    <div class="form-group">
                  <label for="modifiergroup_id" class="col-sm-2 control-label">Modifier Group<label class="text-danger">*</label></label>

                  <div class="col-sm-4">
          <select class="form-control select2" id="modifiergroup_id" name="modifiergroup_id"  style="width: 100%;"  >
            <?php
            $query1="select * from db_modifier_group where status=1";
            $q1=$this->db->query($query1);
            if($q1->num_rows($q1)>0)
             {
                 echo '<option value="">-Select-</option>'; 
                 foreach($q1->result() as $res1)
               {
                $selected = ($modifiergroup_id==$res1->id)? 'selected' : '';
                 echo "<option $selected value='".$res1->id."'>".$res1->modifiergroup_name."</option>";
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
			      <label for="modifier_name" class="col-sm-2 control-label">Modifier Name<label class="text-danger">*</label></label>
           <div class="col-sm-4">
             <input type="text" class="form-control input-sm" id="modifier_name" name="modifier_name" placeholder="" onkeyup="shift_cursor(event,'modifier_name')" value="<?php print $modifier_name; ?>" autofocus >
				      <span id="name_msg" style="display:none" class="text-danger"></span>
            </div>
      </div>
      
      	<div class="form-group">
			      <label for="modifier_price" class="col-sm-2 control-label">Price<label class="text-danger">*</label></label>
           <div class="col-sm-4">
             <input type="text" class="form-control input-sm" id="modifier_price" name="modifier_price" placeholder="" onkeyup="shift_cursor(event,'modifier_price')" value="<?php print $modifier_price; ?>" autofocus >
				      <span id="price_msg" style="display:none" class="text-danger"></span>
            </div>
      </div>
      
        <div class="form-group">
                 <label for="modifier_image" class="col-sm-2 control-label"><?= $this->lang->line('select_image'); ?></label>
                  <div class="col-sm-4">
                      <?php
                      if($modifier_image!=""){ ?>
                      
                      <img src="<?php print $base_url . 'uploads/modifiers/'.$modifier_image; ?> "height="100" width="100"/>
                       <?php
                      } ?>
                 <input type="file" name="modifier_image" id="modifier_image">
                 <span id="modifier_image" style="display:block;" class="text-danger">Max Width/Height: 1000px * 1000px & Size: 1MB </span>
                </div>
                </div>


				<!--<div class="form-group">-->
    <!--              <label for="description" class="col-sm-2 control-label"><?= $this->lang->line('description'); ?></label>-->
    <!--              <div class="col-sm-4">-->
    <!--                <textarea type="text" class="form-control" id="description" name="description" placeholder=""><?php print $description; ?></textarea>-->
				<!--	<span id="description_msg" style="display:none" class="text-danger"></span>-->
    <!--              </div>-->
    <!--            </div>-->

              </div>
              <!-- /.box-footer -->
              <div class="box-footer">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                   <!-- <div class="col-sm-4"></div> -->
                   <?php
                      if($modifier_code!=""){
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

<script src="<?php echo $theme_link; ?>js/modifier.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
