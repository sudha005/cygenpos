<!DOCTYPE html>
<html lang="en">
    <head>
       <?php
include_once'header.php';
?>
    </head>
    <body>
       
        <div id="fb-root"></div>
        <section class="abt-banner p-0">
            <div class="container h-100">
                <div class="row m-0 h-100 justify-content-center align-items-center">
                    <div class="col-md-12 text-center">
                        <h3 class="heading-inner-page">Stores</h3>
                    </div>
                </div>
            </div> 
        </section>
        <section class="multiple-store">

            <div class="container h-100">
                <div class="row m-0  h-100 justify-content-center align-items-center">
                    <div class="col-md-6 text-center">
                        <div class="location-box">
                            <img src="assets/images/pin.png" class="img-fluid" />
                            <h4>Bigbite <span>Blacktown</span></h4>
                            <p> One of the unique Indian joint serving authentic indian taste in Sydney. We specialize in Indian fast food preparation</p>
                        </div>
                        <div class="row m-0">
                                 <div class="col-md-12 p-0">
                                     <div class="menu-loc-box">
                                     <h3 class="special-heading">Special Menu in Blacktown</h3>
                            <ul class="menu-list-view text-left">
                                <li>Cheese Tava Pulav  <span>$ 15.00</span></li>
                                <li>Masala Pav <span>$ 15.00</span></li>
                                <li>Dabeli <span>$ 15.00</span></li>
                            </ul>
                                          <a href="<?php echo base_url(); ?>ProductListpage" class="button">Go to store</a>
                        </div>
                                     </div>
                            </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="location-box">
                            <img src="assets/images/pin.png" class="img-fluid" />
                            <h4>Bigbite <span>Wentworthville</span></h4>
                            <p> One of the unique Indian joint serving authentic indian taste in Sydney. We specialize in Indian fast food preparation.</p>
                        </div>
                                         <div class="row m-0">
                                 <div class="col-md-12 p-0">
                                     <div class="menu-loc-box">
                                     <h3 class="special-heading">Special Menu in Wentworthville</h3>
                            <ul class="menu-list-view text-left">
                                <li>Cheese Tava Pulav  <span>$ 15.00</span></li>
                                <li>Masala Pav <span>$ 15.00</span></li>
                                <li>Dabeli <span>$ 15.00</span></li>
                            </ul>
                                          <a href="<?php echo base_url(); ?>ProductListpage" class="button">Go to store</a>
                        </div>
                                     </div>
                            </div>
                    </div>
                </div>

            </div>
        </section>
        
       <?php
include_once'footer.php';
?>
    </body>
</html>


