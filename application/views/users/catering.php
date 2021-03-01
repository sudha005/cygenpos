<!DOCTYPE html>
<html lang="en">
    <head>
         <?php
include_once'header.php';
?>
   <style>
       .cart-sucess, .cart-failure{
    z-index: 100789;
    position: fixed;
    top: 0px;
    color: #fff;
    width: 40% !important;
    background: #fff !important;
    top: 50% !important;
    left: 50% !important;
    -webkit-transform: translate(-50%,-50%) !important;
    -ms-transform: translate(-50%,-50%) !important;
    transform: translate(-50%,-50%) !important;
    padding: 10px;
       }
       @media only screen and (max-device-width: 760px) and (min-device-width: 320px){
           .mobile-align-bottom{
               align-items: flex-end !important;
           }
           .mneu-list-product,.back-arrow{
               padding-left:10px;
           }
           a:hover{
               text-decoration:none;
           }
           .custom-control-label {

    font-size: 0.85rem;
  
}
           .product-box {
    padding: 0;
    margin-bottom: 0.5rem;
}
           .cart-sucess, .cart-failure{
                 width: 90% !important;  
           }
           .cat-heading{
               display:none;
           }
           .product-title {

    text-align: left;
}
           .price-user {
    font-size: 0.9rem;
    text-align: left;
}
.mneu-list-product>li a, .dashboard-box ul>li a {
    font-size: 0.85rem;
    padding: 4px 8px;
    display: inline-block;
    border: 1px solid #eee;
    margin-bottom: 10px;
}
       }
       @media (min-width: 768px){
           .col-md-3.new-cygen-restaurant-layout {
    -ms-flex: 0 0 25%;
    flex: 0 0 25%;
    max-width: 25%;
}
       }
@media only screen and (max-device-width: 760px) and (min-device-width: 320px){
           .mobile-align-bottom{
               align-items: flex-end !important;
           }
           .mb-start{
               margin-bottom: 2px;
                   -webkit-box-pack: start !important;
     -ms-flex-pack: start !important;
         justify-content: start !important;
           }
           .cart-sucess, .cart-failure{
                 width: 90% !important;  
           }
           .product-img.new-cygenrestaurant  {
    height: 80px!important;
    margin-bottom: 0;
}
.product-img img {
    max-width: 100%;
    width: 100%;
    height: 100% !important;
    object-fit: contain;
    object-position: center;
    display: block;
    margin: 0;
    border: 1px solid #eee;
}
.product-box{
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
    box-shadow: 0 1px 1px rgba(0, 0, 0, .05);

}
.abt-banner,.navbar-header,.footer{
    display:none !important;
}
.modal-body {
    background:#fff;
    height: 100%;
    overflow: auto;
}
.modal-content {
    height: 100%;
    border: none;
    border-radius: 0;
    
}
body, html {

    padding-top: 35px !important;
}
.modal-dialog {
   
    margin: 0;
    pointer-events: none;
    height: 100%;
}
.menu-category-box {
    background: #fff;
    padding: 0.15rem 0.75rem;
    margin-bottom: 0.5rem;
    position: fixed;
    z-index: 99;
    top: 0;
    left: 0;
    width:100%;
    -webkit-box-shadow: 0px -6px 10px 4px rgba(0, 0, 0, 0.2);
    box-shadow: 0px -6px 10px 4px rgba(0, 0, 0, 0.2);
}
.back-arrow{
    font-size: 1.5rem;
    color: #000;
    font-weight: 600;
}
.price-user {
    font-size: 1rem;
    
}
.new-addon-height {
    max-height: initial !important;

}


#product-list-grid, .user-dashboard {
    background: #fff;
    padding: 0.5rem 0.15rem !important;
}
.groupAddonn {
    color: #000!important;
    border-bottom: none!important;
    background: #f6f6f6;
    text-transform: capitalize;
    padding: 10px;
    font-weight: 600;
    font-size: 0.95rem;;
}
.btn-danger {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
    padding: 0.25rem 0.5rem;
    border-radius: 0px;
    margin-left: 1rem;
    font-size: 0.7rem;
    text-transform: uppercase;
}
textarea.form-control {
    height: auto;
    border-radius: 0px;
}
       }
       #product-list-grid, .user-dashboard {
    background: #fff;
    padding: 0.25rem 0;
}
       @media (min-width: 1200px){
.container {
    max-width: 96%;
}}
   </style>   
    </head>
    <body>
      
        <div id="fb-root"></div>
        <section class="abt-banner p-0">
          
            <div class="container h-100">
                <div class="row m-0 h-100  mobile-align-bottom align-items-center">
                    <div class="col-md-12 text-center">
                       
                        <h2 class="heading-inner-page"> Explore Menu</h2>
                        <h6 class="heading-inner-page-sub"> Choose our Menu option to order</h6>
                    </div>
                </div>
            </div> 
        </section>
                      <div class="menu-category-box p-0">
                           
                            <div class="d-block d-md-none"><a class="" href="<?php echo base_url(); ?>Home"><span class="lnr lnr-arrow-left back-arrow"></span></a></div>
                            <ul class="mneu-list-product">
                                <?php
                                                                foreach($category_menu as $category_menu_row ){
                                                                ?>
                                <li><a href="javascript:void(0)" class="spicy_cat" catId="<?php echo $category_menu_row['id']; ?>"><?php echo $category_menu_row['category_name']; ?></a></li>
                                <?php
                                                                }
                                                                ?>
                            </ul>
                        </div>
        <section id="product-list-grid">
            <div class="container">
                <div class="row ">
                    <div class="col-md-12 p-0 ">
          
                        <!--    <div class="menu-category-box">
<h4 class="cat-heading mb-4">Price</h4>

</div>-->
                    </div>
                    <div class="col-md-12 mbp-0">
                        <div class="product-lader" style="display:none"><div class="loader-inside"><div class="item">
                                <div class="spinner1"></div>
                                <h5>Loading<span class="dot">.</span></h5>
                                </div>
                                <h6>Please Wait.products  are loading</h6>
                                </div>
                            </div>
                        <div class="row mbm-0 allcategory_products" style="min-height:500px;">
                            
                            
                             <?php
                                $CI = & get_instance(); 
                                $CI->load->model('items_model','items');
                                $item=$CI->items->item_list_rand1(); 
                                $i=0;
                                foreach($item as  $row_item){
                                $i++;  
                                 if($row_item->item_image=='' || $row_item->item_image=='null' || $row_item->item_image=='NULL'){
                                    $imgsrc='uploads/items/noimage.png';
                                }else{
                                     $imgsrc=$row_item->item_image;
                                }
                                 $itemimage =base_url().$imgsrc;
								 
								 $cartId = $this->session->userdata('CART_TEMP_RANDOM')!=""?$this->session->userdata('CART_TEMP_RANDOM'):'';
                                 $cardProductId = $row_item->id;
                                 $dataCart=(" * FROM grocery_cart WHERE product_id='$cardProductId'  AND session_cart_id='$cartId'");
                                 $CI->db->select($dataCart);
                                $query = $CI->db->get();
                                if($query->num_rows() > 0){
                                $cardRow=$query->result_array();
                                $selectBoxDisplay="";
                                $cardHide="cardHide";
                                $product_quantity = $cardRow[0]['product_quantity'];
                                
                                }else{
                                $selectBoxDisplay="hideSelect ";
                                $cardHide="";
                                $product_quantity=0;
                                
                                }
                                if($this->session->userdata('select_order_type')!=""){
                                if($this->session->userdata('select_order_type')==1){
                                $saleprice=$row_item->price3;
                                }else if($this->session->userdata('select_order_type')==2){
                                $saleprice=$row_item->price4;
                                }else if($this->session->userdata('select_order_type')==3){
                                $saleprice=$row_item->price2;
                                }else{
                                $saleprice=$row_item->price3;
                                }
                                }else{
                                $saleprice=$row_item->price3;
                                }
                                


                                ?> 
                            
                            
                            
                            
                            
                            
                            <div class="col-md-3 mb5 new-cygen-restaurant-layout pl-2 pr-0 mbp-0" >
                                  <input type="hidden" class="cat_id_<?php echo $row_item->id; ?>" value="<?php echo $row_item->category_id; ?>">
                                     <input type="hidden" class="sub_cat_id_<?php echo $row_item->id; ?>" value="<?php echo $row_item->category_id; ?>">
                                     <input type="hidden" class="pro_name_<?php echo $row_item->id; ?>" value="<?php echo $row_item->item_name; ?>">
    							     <input type="hidden" class="get_pr_price_<?php echo $row_item->id; ?>" value="<?php echo $row_item->unit_name; ?>,<?php echo $saleprice; ?>,<?php echo $row_item->id; ?>">
                                <div class="product-box">
                                    <div class="product_sale d-none">
                                        <p>On Sale</p>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-4 col-4 col-xs-4 pr-0">
                                    <div class="product-img new-cygenrestaurant">
                                        <span class="product-offer-discount d-none">30%</span>
                                        <img src="<?php echo $itemimage ?>" class="img-fluid" />
                                    </div>
                                    </div>
                                    <div class="col-md-8 col-8 col-xs-8 mbp-0 pl-1">
                                    <h3 class="product-title text-truncate"><?php echo ucwords(strtolower($row_item->item_name)); ?></h3>
                                    <?php
                                    $CI =& get_instance();
                                    ?>
                                    <p class="product-description">One piece. Order chips and gravy as extras.</p>
                                   
                                    <p class="option-ava text-center d-none">&nbsp;<span>Option available</span></p>
                                    <div class=" mobile-md-left">
                                        <div class="row  mb-start" >
                                            <div class="col-5 col-md-6 col-sm-5 col-sx-8 " >
                                                 <h5 class="price-user"><?= $CI->currency(app_number_format($saleprice)); ?><span class="strike d-none"><?= $CI->currency(app_number_format($saleprice)); ?></span></h5>
                                                </div>
                                    <div class="col-5 col-md-6 col-sm-5 col-sx-8 justify-content-end" >
                                    <div  class="<?php echo $selectBoxDisplay; ?> buttonCart_<?php echo $row_item->id; ?>">
                                    
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                        <a onClick="show_cart_option(<?php echo $row_item->id; ?>,1)" class="btn btn-secondary btn-number btn-cartplus"  data-type="minus" data-field="quant[2]">
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                        </a>
                                        </span>
                                        <input type="text" name="quant[2]"    class="input-number form-control counter-control qtyBox1 product_quantity_<?php echo $row_item->id; ?>" value="<?php echo $product_quantity; ?>" min="0"  readonly="readonly">
                                        <span class="input-group-btn">
                                        <a onClick="show_cart_option(<?php echo $row_item->id; ?>,0)"  class="btn btn-secondary btn-number btn-cartminus" data-type="plus" data-field="quant[2]">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        </a>
                                        </span>
                                    </div>
                                    
                                    </div>
                                    <div class="input-group  mb-start justify-content-end">
                                        <button style="text-align:center;position:relative"    type="button"  class="<?php echo $cardHide; ?> cart-icon  buttonAdd_<?php echo $row_item->id; ?>" onClick="show_cart(<?php echo $row_item->id; ?>,0)"><i class="las la-concierge-bell"></i></button>
                                    </div>										
                                    
                                    
                                    </div>
                                    </div>
                                        </div>
                                </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
         <?php
include_once'footer.php';
?>
 
        <!-- The Product Modal -->
        <div class="modal fade" id="myModalmodifier">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Product Details -->
                    <div class="">
                      <div class="modal-body p-2">
<div class="productDetailModal">



</div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
      <script>
          $(window).scroll(function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 400) {
        $(".navbar-fixed-header").addClass('shadow-none-brd');
        $(".mneu-list-product").addClass("fixed-menu");
    } else {
         $(".navbar-fixed-header").removeClass('shadow-none-brd');
          $(".mneu-list-product").removeClass("fixed-menu");
    }
});
/*$('.cart-icon').on('click', function () {
        var cart = $('.shopping-cart');
        var imgtodrag = $(this).parent('.item').find("img").eq(0);
        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
                .css({
                'opacity': '0.5',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '100'
            })
                .appendTo($('body'))
                .animate({
                'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 75,
                    'height': 75
            }, 1000, 'easeInOutExpo');
            
            setTimeout(function () {
                cart.effect("shake", {
                    times: 2
                }, 200);
            }, 1500);

            imgclone.animate({
                'width': 0,
                    'height': 0
            }, function () {
                $(this).detach()
            });
        }
    });*/
      </script>
    </body>
</html>
