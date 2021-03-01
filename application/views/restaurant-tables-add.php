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
 <?php //echo $q_id;exit;
	if(!isset($id)){
      $table_name=$table_details=$table_capacity="";
    }
 ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small>Add/Update Stores</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>stores/view">Store List</a></li>
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
                <div class="box-tools">
                    <a class="btn btn-block btn-info" href="<?php echo $base_url; ?>RestaurantTables/view">
                    <i class="fa fa-eye">&nbsp;</i>View Restaurant Hr</a>
                </div>
            </div>

            <!-- /.box-header -->
            <?= form_open('#', array('class' => 'form-horizontal ', 'id' => 'resturant-table-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
            <!-- form start -->
            <!-- <form class="form-horizontal" id="openinghr-form" onkeypress="return event.keyCode != 13;" enctype="multipart/form-data"> -->
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                <input type="hidden" id="base_url" value="<?php echo $base_url; ?>">
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                <div class="box-body">
                    
                    
                     <div class="form-group">
                  <label for="area" class="col-sm-2 control-label">Area Name<label class="text-danger">*</label></label>

                  <div class="col-sm-4">
          <select class="form-control select2" id="area" name="area"  style="width: 100%;"  >
            <?php
            $query1="select * from 	db_booking_area where status=1";
            $q1=$this->db->query($query1);
            if($q1->num_rows($q1)>0)
             {
                 echo '<option value="">-Select-</option>'; 
                 foreach($q1->result() as $res1)
               {
                $selected = ($area==$res1->id)? 'selected' : '';
                 echo "<option $selected value='".$res1->id."'>".$res1->area."</option>";
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
          <span id="area_msg" style="display:none" class="text-danger"></span>
                  </div>
                  </div>
				

                    
                    
                    
                    
                    
                    <div class="form-group">        
                        <label for="table_name" class="col-sm-2 control-label">Table Name<label class="text-danger">*</label></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control input-sm" id="table_name" name="table_name" placeholder="" onkeyup="shift_cursor(event,'table_name')" value="<?php print $table_name; ?>" autofocus >
                            <span id="table_name_msg" style="display:none" class="text-danger"></span>
                        </div>
                    </div>      

                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label"><?= $this->lang->line('description'); ?></label>
                        <div class="col-sm-4">
                            <textarea type="text" class="form-control" id="table_details" name="table_details" placeholder=""><?php print $table_details; ?></textarea>
                            <span id="table_details_msg" style="display:none" class="text-danger"></span>
                        </div>
                    </div>       

                    <div class="form-group">
                            <label for="table_capacity" class="col-sm-2 control-label"> Table Capacity<label class="text-danger">*</label></label>
                    <div class="col-sm-4">
                            <input type="number" class="form-control input-sm" id="table_capacity" name="table_capacity" placeholder=""value="<?php print $table_capacity; ?>" autofocus >
                            <span id="table_capacity_msg" style="display:none" class="text-danger"></span>
                        </div>
                    </div>                   
                    <div class="form-group">
                            <label for="table_capacity" class="col-sm-2 control-label"> Seat<label class="text-danger">*</label></label>
                    <div class="col-sm-4">
                            <input type="number" class="form-control input-sm" id="chair" name="chair" placeholder=""value="<?php print $chair; ?>" autofocus >
                            <span id="table_capacity_msg" style="display:none" class="text-danger"></span>
                        </div>
                    </div> 
              </div>
              <!-- /.box-footer -->
              <div class="box-footer">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                   <!-- <div class="col-sm-4"></div> -->
                   <?php
                      if($id!=""){
                           $btn_name="Update";
                           $btn_id="update";
                          ?>
                            <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
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

<script src="<?php echo $theme_link; ?>js/restauranrTable.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
