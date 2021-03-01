<!DOCTYPE html>
<html lang="en">
    <head>
         <?php
include_once'header.php';
?>
      
         <style>
            .menu-card{
                border: 1px solid #f52f2c;
                border-radius: 6px;
                margin-bottom: 1rem;
            }
            .menu-header{
                background: #f52f2c;
                padding: 5px 10px;
                color: #fff;
                font-weight: 600;
                font-size: 1rem;
            }
            .menu-card-body{
                padding:1rem;
            }
            .menu-card-view{
                list-style: none;
            }
            .menu-card-view>li {
                border-bottom: none;
                color: #20202f;
                font-size: 0.8rem;
                margin-bottom: 10px;
                font-weight: 500;
            }
            .menu-card-view>li span{
                float: right;
                color: #e2120e;
            }
            @media only screen and (min-device-width: 320px) and (max-device-width: 760px) {
                .menu-card-view>li {
    border-bottom: none;
    color: #20202f;
    font-size: 0.75rem;
    margin-bottom: 6px;
    font-weight: 500;
}
.menu-header {

    padding: 3px 10px;
    color: #fff;
    font-weight: 600;
    font-size: 0.9rem;
}
.menu-card-view {
    list-style: none;
    margin-bottom: 0;
}
            }
        </style>
    </head>
    <body>
      
        <div id="fb-root"></div>
        <section class="abt-banner p-0">
          
            <div class="container h-100">
                <div class="row m-0 h-100 justify-content-center align-items-center">
                    <div class="col-md-12 text-center">
                        
                        <h6 class="heading-inner-page"> Choose our Menu options to order</h6>
                    </div>
                </div>
            </div> 
        </section>
         
          

        <section class="about-pages-section">
            <div class="container h-100">
                <div class="row m-0 justify-content-center">
                    <div class="col-md-6 mbp-0">
                         <?php
                             $CI =& get_instance();
                            foreach($item_menu_left as $row_menu){
                            ?>
                            
                        <div class="menu-card"> 
                            <div class="menu-header">
                               <?php echo $row_menu->category_name;?>
                            </div>
                            <div class="menu-card-body">
                                <ul class="menu-card-view">
                                    <?php
                             foreach($row_menu->product_list as $row_menu_product) { ?>
                                    <li><?php echo $row_menu_product->item_name;?><span><?= $CI->currency(app_number_format($row_menu_product->sales_price)); ?></span></li>
                                     <?php } ?>
                                </ul>
                            </div>
                        </div>
                         <?php } ?>
                    </div>
                       <div class="col-md-6 mbp-0">
                          
                         <?php
                             $CI =& get_instance();
                            foreach($item_menu_right as $row_menu){
                            ?>
                            
                        <div class="menu-card"> 
                            <div class="menu-header">
                               <?php echo $row_menu->category_name;?>
                            </div>
                            <div class="menu-card-body">
                                <ul class="menu-card-view">
                                    <?php
                             foreach($row_menu->product_list as $row_menu_product) { ?>
                                    <li><?php echo $row_menu_product->item_name;?><span><?= $CI->currency(app_number_format($row_menu_product->sales_price)); ?></span></li>
                                     <?php } ?>
                                </ul>
                            </div>
                        </div>
                         <?php } ?>
                    </div>
                </div>
            </div>    
        </section>
<?php
include_once'footer.php';
?>

    </body>
</html>
