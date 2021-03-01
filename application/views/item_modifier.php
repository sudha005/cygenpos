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
	if(!isset($modifier_id)){
      $items_modifier_code=$modifier_id=$modifiergroup_id="";
	}
 ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small>Item Modifier</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>items">Item List</a></li>
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
             <?= form_open('#', array('class' => 'form-horizontal ', 'id' => 'itemmodifier-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
           
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
              <div class="box-body">
                  
                  	<div class="form-group">
			      <label for="modifiergroup_id" class="col-sm-2 control-label">Modifier Group<label class="text-danger">*</label></label>
           <div class="col-sm-4">
             <select class="form-control select2 modifiergroupList" id="modifiergroup_id" name="modifiergroup_id">
                  <?php
                                       $query1="select * from db_modifier_group";
                                       $q1=$this->db->query($query1);
                                       if($q1->num_rows($q1)>0)
                                        {
                                         echo '<option value="">-Select-</option>'; 
                                            foreach($q1->result() as $res1)
                                          {
                                            $selected = ($modifiergroup_id ==$res1->id)? 'selected' : '';
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
				      <span id="order-status_msg" style="display:none" class="text-danger"></span>
            </div>
      </div>
				


			<div class="form-group" style = "display:none;">
			      <label for="modifier_id" class="col-sm-2 control-label">Modifier Name<label class="text-danger">*</label></label>
           <div class="col-sm-4">
             <select class="form-control select2 modifierListSelect" id="modifier_id" name="modifier_id" >
                  <?php
                                       $query1="select * from db_modifier";
                                       $q1=$this->db->query($query1);
                                       if($q1->num_rows($q1)>0)
                                        {
                                         echo '<option value="">-Select-</option>'; 
                                            foreach($q1->result() as $res1)
                                          {
                                            $selected = ($modifier_id ==$res1->id)? 'selected' : '';
                                            echo "<option $selected value='".$res1->id."'>".$res1->modifier_name."</option>";
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
				      <span id="order-status_msg" style="display:none" class="text-danger"></span>
            </div>
      </div>
      
      	<div class="form-group">
			      <label for="modifier_id" class="col-sm-2 control-label">Modifier Name<label class="text-danger">*</label></label>
           <div class="col-sm-4">
               <select class="form-control select2 modifierListSelect" multiple="multiple" name="modifier[]"  style="width: 100%;" >
                               <option value=""></option>
                           
                                  </select>
           
				      <span id="order-status_msg" style="display:none" class="text-danger"></span>
            </div>
      </div>
      
      
              

              </div>
               <!-- /.box-footer -->
              <div class="box-footer">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                   <!-- <div class="col-sm-4"></div> -->
                   <?php
                      if($items_modifier_code!=""){
                           $btn_name="Update";
                           $btn_id="update";
                          ?>
                            <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id;?>"/>
                            <?php
                      }
                                else{
                                    $btn_name="Save";
                                    $btn_id="save";
                                     ?>
                                    
                                    <input type="hidden" name="q_id" id="q_id1" value="<?php echo $q_id;?>"/>
                                    
                               <?php } ?>
                                
                                
                      
                                
                                 
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
            <?= form_close(); ?>
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

<script src="<?php echo $theme_link; ?>js/itemmodifier.js"></script>  
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
 <script>
$(document).ready(function() {
$(document).on('change', '.modifiergroupList', function() {
            var modifiergruoupId=$(this).val();
              $.ajax({
              type:'post',
              url: '<?php echo base_url('itemmodifier/modifierList') ?>',
              data:{
                modifiergruoupId:modifiergruoupId
              },
              success:function(data) {
                  $(".modifierListSelect").html(data);
                  $(".modifierListSelect").select2({
                placeholder: "Select Modifier",
                 });
              }
            });
});
              
             });

</script>
</body>
</html>
