<?php
$CI = & get_instance(); 
if(count($item_modifier) > 0){  
?>
 <div class="row m-0">
     <div class="text-right">
         <a href="" data-dismiss="modal"><span class="lnr lnr-cross close-modal"></span></a>
         
     </div>
     
                            <div class="col-md-12 mbp-0">
                                <div class="single-product-content" style="border:0px;border-top:1px solid #fff">
                                    <form method="post" id="AddToCartForm" accept-charset="UTF-8" class="shopify-product-form" enctype="multipart/form-data" action="JavaScript:Void(0);">
                                       
                                        <div class="product-details">
                                            <div class="row">
                                                <div class="col-md-9">
                                                       <h1 class="single-product-name-pos text-truncate"><?php echo $item_name ?></h1>
                                                    
                                                </div>
                                                <div class="col-md-3 text-right">
                                                            <div class="single-product-price">
                                                <div class="product-discount"><span class="price" id="ProductPrice"><span class="money"><?= $CI->currency(app_number_format($item_price)); ?></span></span></div>
                                            </div>
                                                    </div>
                                            </div>
                                         
                                    
                                            <div class="">
                                            
                                           <div class="row h-100 row-scrollabel m-0">
                                                
                                                 <?php
                                                 foreach($item_modifier as $modifier_group)
                                                 {
                                                   ?>
                                                   <div class="col-md-2 h-100 horizontal-scroll p-0">
                                                   <h6 class="groupAddonn"><?php echo $modifier_group['modifier_name']; ?></h6>
                                                   <?php
                                                     
                                                     if(count($modifier_group['modifier']) > 0){
                                                 ?>
                                              
                                                    <div class="row m-0 new-addon-all-height">
                                                    <?php
                                                    foreach($modifier_group['modifier'] as  $row_item){
                                                    $modifier_name=getSingleColumnName($row_item['modifier_id'],'id','modifier_name','db_modifier');
                                                    $modifier_price=getSingleColumnName($row_item['modifier_id'],'id','modifier_price','db_modifier');
                                                    $modifier_image=getSingleColumnName($row_item['modifier_id'],'id','modifier_image','db_modifier');
                                                    ?>
                                                    
                                                   <div class="col-md-12 p-0 ">
                                                  
                                                    <div class='inputGroup'> 
                                                    <input type="checkbox"  class=" add_on onValuess113" addon-price="<?php echo $modifier_price ?>" addon-name="<?php echo $modifier_name ?>"  product-id="<?php echo $row_item['item_id'] ?>" addon-id="<?php echo $row_item['modifier_id'] ?>" id="customCheck<?php echo $row_item['modifier_id'] ?>" name="addoncheckbox"  value="<?php echo $row_item['modifier_id']?>">
                                                    <label class="" for="customCheck<?php echo $row_item['modifier_id'] ?>">
                                                   
                                <?php echo ucwords(strtolower($modifier_name)); ?>
                                  <span class="  price-control-modal-pos " for="customCheck<?php echo $row_item['modifier_id'] ?>">
                                                    <?= $CI->currency(app_number_format($modifier_price)); ?>
                                                    </span>
                            </label>
                                                  
                                                    <input type="hidden" class="addon_price<?php echo $row_item['modifier_id'] ?>" value="<?php echo $modifier_price; ?>">
                                                     <?php if($modifier_image!= "0"){ 
                                                         $modifierImage =base_url('uploads/modifiers/'.$modifier_image);
                                                         ?>
                                                     <span class="  price-control-modal " for="customCheck<?php echo $row_item['modifier_id'] ?>">
                                                        
                                                         
                                                  <!--  <img src="<?php echo $modifierImage ?>" class="img-fluid"  height = "40px;" width = "40px;"/>-->
                                                    </span>
                                                   
                                                     <?php } ?>
                                                     </div>

                                                    </div>

                                                   
                                                    <?php
                                                    }
                                                    ?>
                                                    
                                                   </div>
                                                    </div>
                                                    <?php
                                                     }
                                                     
                                                 } 
                                                    ?>
                                                    
                                                 
                                                     </div>
                                                          </div>
                                                          <div class="clearfix"></div>
                                                                <div class="form-group">
                                                                <textarea rows="3" id="txtmod<?php echo $row_item['item_id'] ?>" class="form-control" aria-label="With textarea" placeholder="Add Notes for Chef"></textarea>
                                                                
                                                                </div>
                                                               
                                                                <div class="row m-0 text-right">
                                                                
                                                                
                                                                <button type="button" pids_product="<?php echo $item_products_all; ?>" class="btn bg-green btn-lg addtocartaddon ">
                                                                <span  id="alert1">&nbsp;&nbsp;&nbsp; ADD ITEM <i class="fa  fa-check "></i></span>
                                                                </button>
                                                    </div>
                                                    
                                                </div>
                                                                                                               
                                                                                               
                                        </div></form>
                                     
                                </div>
                            </div>
                        </div>
<?php
}
?>