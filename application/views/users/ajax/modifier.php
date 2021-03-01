<?php
$CI = & get_instance(); 
if(count($item_modifier) > 0){  
?>
 <div class="row mbm-0">
                            <div class="col-md-12 mbp-0">
                                <div class="d-block d-md-none"><a class="" data-dismiss="modal"><span class="lnr lnr-arrow-left back-arrow pl-0"></span></a></div>
                                <div class="single-product-content" style="border:0px;border-top:1px solid #fff">
                                    <form method="post" id="AddToCartForm" accept-charset="UTF-8" class="shopify-product-form" enctype="multipart/form-data" action="JavaScript:Void(0);">
                                       
                                        <div class="product-details">
                                             <div class=" ">
                                            <h1 class="single-product-name"><?php echo $item_name ?></h1>
                                            </div>
                                            <div class="single-product-price">
                                                <div class="product-discount"><span class="price" id="ProductPrice"><span class="money"><?= $CI->currency(app_number_format($item_price)); ?></span></span></div>
                                            </div>
                                                 <?php
                                                 foreach($item_modifier as $modifier_group)
                                                 {
                                                   ?>
                                                   <h6 class="groupAddonn"><?php echo $modifier_group['modifier_name']; ?></h6>
                                                   <?php
                                                     
                                                     if(count($modifier_group['modifier']) > 0){
                                                 ?>
                                             
                                                <div class="new-addon-height">
                                                    <?php
                                                    foreach($modifier_group['modifier'] as  $row_item){
                                                    $modifier_name=getSingleColumnName($row_item['modifier_id'],'id','modifier_name','db_modifier');
                                                    $modifier_price=getSingleColumnName($row_item['modifier_id'],'id','modifier_price','db_modifier');
                                                    $modifier_image=getSingleColumnName($row_item['modifier_id'],'id','modifier_image','db_modifier');
                                                    ?>
                                                    <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"  class="custom-control-input add_on onValuess113" addon-price="<?php echo $modifier_price ?>" addon-name="<?php echo $modifier_name ?>"  product-id="<?php echo $row_item['item_id'] ?>" addon-id="<?php echo $row_item['modifier_id'] ?>" id="customCheck<?php echo $row_item['modifier_id'] ?>" name="addoncheckbox"  value="<?php echo $row_item['modifier_id']?>">
                                                    <label class="custom-control-label" for="customCheck<?php echo $row_item['modifier_id'] ?>">
                                                    <?php echo ucwords(strtolower($modifier_name)); ?>
                                                    </label>
                                                    <span class=" float-right price-control-modal pull-right" for="customCheck<?php echo $row_item['modifier_id'] ?>">
                                                    <?= $CI->currency(app_number_format($modifier_price)); ?>
                                                    </span>
                                                    <input type="hidden" class="addon_price<?php echo $row_item['modifier_id'] ?>" value="<?php echo $modifier_price; ?>">
                                                     <?php if($modifier_image!= "0"){ 
                                                         $modifierImage =base_url('uploads/modifiers/'.$modifier_image);
                                                         ?>
                                                     <span class=" float-right price-control-modal pull-right" for="customCheck<?php echo $row_item['modifier_id'] ?>">
                                                        
                                                         
                                                    <img src="<?php echo $modifierImage ?>" class="img-fluid"  height = "40px;" width = "40px;"/>
                                                    </span>
                                                     <?php } ?>
                                                    </div> 
                                                    
                                                    <?php
                                                    }
                                                    ?>
                                                    </div>
                                                    <?php
                                                     }
                                                 }
                                                    ?>
                                                                <div class="form-group">
                                                                <textarea rows="3" id="txtmod<?php echo $row_item['item_id'] ?>" class="form-control" aria-label="With textarea" placeholder="Add Notes for Chef"></textarea>
                                                                
                                                                </div>
                                                               
                                                                <div class="row m-0">
                                                                
                                                                
                                                                <button type="button" pids_product="<?php echo $item_products_all; ?>" class="addtocart addtocartaddon">
                                                                <span class=" btn-alert" id="alert1">&nbsp;&nbsp;&nbsp; ADD ITEM &nbsp; &nbsp;&nbsp;</span>
                                                                </button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                    
                                                </div>
                                                                                                               
                                                                                               
                                        </div></form>
                                     
                                </div>
                            </div>
                        </div>
<?php
}
?>