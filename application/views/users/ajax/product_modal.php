<?php
$i=0;
foreach($item as  $row_item){
$i++;  
$selectBoxDisplay="hideSelect1";
$cardHide="cardHide";
 $CI =& get_instance();
?>
<div class="col-lg-5">
                                <div class="sp-img_area">
                                     <input type="hidden" class="cat_id_<?php echo $row_item->id; ?>" value="<?php echo $row_item->category_id; ?>">
                                     <input type="hidden" class="sub_cat_id_<?php echo $row_item->id; ?>" value="<?php echo $row_item->category_id; ?>">
                                     <input type="hidden" class="pro_name_<?php echo $row_item->id; ?>" value="<?php echo preg_replace('#[0-9 ]*#', '',$row_item->item_name); ?>">
    							     <input type="hidden" class="get_pr_price_<?php echo $row_item->id; ?>" value="<?php echo $row_item->unit_name; ?>,<?php echo $row_item->sales_price; ?>,<?php echo $row_item->id; ?>">
                                    <div class="sp-img_slider-2 slick-img-slider umino-slick-slider arrow-type-two" data-slick-options='{
                                                        "slidesToShow": 1,
                                                        "arrows": false,
                                                        "fade": true,
                                                        "draggable": false,
                                                        "swipe": false,
                                                        "asNavFor": ".sp-img_slider-nav"
                                                        }'>
                                        <div class="single-slide red">
                                            <img src="<?php echo $row_item->image ?>" alt="Umino's Product Image">
                                        </div>
                                        
                                    </div>
                                    <div class="sp-img_slider-nav slick-slider-nav umino-slick-slider arrow-type-two" data-slick-options='{
                                   "slidesToShow": 4,
                                    "asNavFor": ".sp-img_slider-2",
                                   "focusOnSelect": true
                                  }' data-slick-responsive='[
                                                        {"breakpoint":1501, "settings": {"slidesToShow": 3}},
                                                        {"breakpoint":1200, "settings": {"slidesToShow": 2}},
                                                        {"breakpoint":992, "settings": {"slidesToShow": 4}},
                                                        {"breakpoint":768, "settings": {"slidesToShow": 3}},
                                                        {"breakpoint":321, "settings": {"slidesToShow": 2}}
                                                    ]'>
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-6">
                                <div class="sp-content">
                                    <div class="sp-heading">
                                         <h5 class="product-name"><?php echo  preg_replace('#[0-9 ]*#', '',$row_item->item_name); ?></h5>
                                    </div>
                                    <div class="price-box">
                                        <span class="new-price"><?= $CI->currency(app_number_format($row_item->sales_price)); ?></span>
                                        <span class="old-price d-none"><i class="fa fa-usd" aria-hidden="true"></i><?php echo  number_format($row_item->sales_price,2); ?></span>
                                    </div>
                                    
                                    <div class="quantity-area d-none">
                                        <div class="quantity">
                                            <label>Quantity</label>
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" value="1" type="text">
                                                <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                                <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                            </div>
                                        </div>
                                        <div class="quantity-btn">
                                            <ul>
                                                <li><a href="cart.html" class="add-to_cart">Add To Cart</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="short-desc ">
                                        <p>Product descriptions Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco,Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus</p>
                                    </div>
                                    <div class="umino-social_link">
                                        <div class="social-title">
                                            <h3>Share This Product</h3>
                                        </div>
                                        <ul>
                                            <li class="facebook">
                                                <a href="https://www.facebook.com/" data-toggle="tooltip" target="_blank" title="Facebook">
                                                    <i class="fab fa-facebook"></i>
                                                </a>
                                            </li>
                                            <li class="twitter">
                                                <a href="https://twitter.com/" data-toggle="tooltip" target="_blank" title="Twitter">
                                                    <i class="fab fa-twitter-square"></i>
                                                </a>
                                            </li>
                                            <li class="youtube">
                                                <a href="https://www.youtube.com/" data-toggle="tooltip" target="_blank" title="Youtube">
                                                    <i class="fab fa-youtube"></i>
                                                </a>
                                            </li>
                                            <li class="google-plus">
                                                <a href="https://www.plus.google.com/discover" data-toggle="tooltip" target="_blank" title="Google Plus">
                                                    <i class="fab fa-google-plus"></i>
                                                </a>
                                            </li>
                                            <li class="instagram">
                                                <a href="https://rss.com/" data-toggle="tooltip" target="_blank" title="Instagram">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            
<?php
}
?>
 
                            