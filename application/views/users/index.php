<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once'header.php';?>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/newhomepagestyles.css">
    </head>
    <body>
        <header>
            
            <div class="clearfix"></div>
            <div class="owl-carousel owl-theme">
                
                                 <?php
                                foreach($banner as $bannerList){
                                    $mainbannerimage =base_url().$bannerList->banner_image;
                                ?>
                
                              
                
                <div class="item">
                     <img src="<?php echo $mainbannerimage; ?>" alt="images not found">
                    
                    <div class="cover">
                        <div class="container">
                            <div class="header-content">
                                <div class="line"></div>
                                      <h3 class="slider-h3">Discover the Delicious Food with </h3>
                                <h2 class="slider-h2"> Chicky’s huge Menu Selection</h2>
                            </div>
                        </div>
                    </div>
                </div> 
                <?php
                }
                ?>
                           
                <!--<div class="item">-->
                <!--   <img src="assets/images/Kids+Shake.jpg" alt="images not found">-->
                <!--    <div class="cover">-->
                <!--        <div class="container">-->
                <!--            <div class="header-content">-->
                <!--                <div class="line animated bounceInLeft"></div>-->
                <!--                      <h3 class="slider-h3">Made with love</h3>-->
                <!--                <h2 class="slider-h2">We Serve Quality Food</h2>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>                -->
                <!--<div class="item">-->
                <!--    <img src="assets/images/banner3.jpg" alt="images not found">-->
                <!--    <div class="cover">-->
                <!--        <div class="container">-->
                <!--            <div class="header-content">-->
                <!--                <div class="line animated bounceInLeft"></div>-->

                <!--                  <h3 class="slider-h3">Party On Mind</h3>-->
                <!--                <h2 class="slider-h2"> We are here to provide the best service</h2>-->
                                <!-- <h3 class="slider-h3">Eat healthy. Stay healthy</h3>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
            </div>

        </header>
                <div class="clearfix"></div>
        <section class="" id="about-us-new-home">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center form-group">
                        <h4>History of</h4>
                        <h2> ChickyCharChar</h2>
                        <img src="assets/images/flower-decor.png" class="heading-decor" />
                        <p>Chicky Char Char is an Australian authentic restaurant and café unwrapped in the year 2015, where you can find a combination of healthy and sassy food for any meal of your day. The proprietors of chicky char char are into hospitality industry for more than 3 decades which makes them completely understand the mindset for any age from youth to the senior citizens. Chicky is doing wonders and operating its store successfully in and around Sydney CBD and proximity suburbs.</p>
                        <a href="<?php echo base_url() ?>Aboutus"  class="button mb--m4">Our Story</a>
                    </div>
                    <div class="col-md-6 form-group">
                        <img src="http://placehold.jp/1ooo/eeeeee/000000/1000x1000.png" class="img-fluid mb--m4" />
                    </div>
                </div>
                <div class="col-md-12 form-group">&nbsp;</div>
                   <div class="clearfix"></div>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <img src="assets/images/chickyabt-2.jpg" class="img-fluid abt-secondimg form-group" />
                    </div>
                    <div class="col-md-6 text-center form-group">
                        <h4>Lorem ipsum</h4>
                        <h2>Lorem ipsum</h2>
                        <img src="assets/images/flower-decor.png" class="heading-decor" />
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        <a href="<?php echo base_url() ?>Aboutus" class="button mb--m4">Know more    </a>
                    </div>

                </div>
            </div>
        </section>
                <section class="" id="party-order">
            <div class="container-fluid lineargreadient-bg p-0 ">
                <div class="row h-100 align-items-center m-0">
                    <div class="col-md-6 pl-0">
                        <img src="http://placehold.jp/1ooo/eeeeee/000000/1000x1000.png" class="img-fluid" />
                    </div>   
                    <div class="col-md-6">
                        <div class="party-box mx-auto">
                            <h4 class="cursive-heading"> make it special</h4>
                            <h2 class="main-heading-h2">Celebrate your important moments with chickycharchar</h2>
                      <!--      <p>If you're organising a function, an all day workshop or even a party at home.</p>-->
                            <div class="text-center mt-4">
                                <button class="button">Enquiry Now   </button>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </section>
        <section class="valuable">
            <div class="container h-100">
                <div class="row h-100 justify-content-center align-items-center">
                    <div class="col-md-12">
                        <h3>Our most valuable asset</h3>
                        <h2>ALWAYS FRIENDLY &amp; PROFESSIONAL STAFF</h2>
                    </div>

                </div>
            </div>
        </section>
<!--        <div class="clearfix"></div>


                <section class="menu-items">
            <div class="container">
                <h3 class="small-cursive">Deliciousness! This is where it happens!</h3>
                <h2 class="menu-heading">CAST YOUR EYES UPON OUR ENCHANTING MENU</h2>
   <div class="form-group mt-4 text-center">
                            <?php
                              if($this->session->userdata('select_order_type')==3){
                              ?>
                            <a href="<?php echo base_url(); ?>productListpage" class="coco-btn"><span>Explore Our Menu</span></a>
                            <?php
                              }
                            ?>
                        </div>
            </div>

        </section>-->










        <section class="contact-us-section" id="contactUs">
            <div class="container">
                <div class="row m-0  h-100 justify-content-center align-items-center">
                    <div class="col-md-12 mbp-0" id="cntformid">
                        <h2 class="contactush2 ">
                            How to Find &amp; Contact Us
                        </h2>

                        <div class="row m-0">
                            <div class="col-md-4 text-center mbp-0 ">
                                <div class="contact-address-box">
                                    <div class="icon-box">
                                        <span class="lnr lnr-map"></span>
                                    </div>
                                    <h6>Address</h6>
                                    <p>Shop 1/145 McEvoy St, Alexandria NSW 2015, Australia</p>
                                </div>
                            </div>
                                         <div class="col-md-4 text-center mbp-0">
                                <div class="contact-address-box">
                                    <div class="icon-box">
                                       <span class="lnr lnr-phone-handset"></span>
                                    </div>
                                    <h6>Phone Number</h6>
                                    <p>0293182000</p>
                                </div>
                            </div>
                                         <div class="col-md-4 text-center mbp-0">
                                <div class="contact-address-box">
                                    <div class="icon-box">
                                       <span class="lnr lnr-envelope"></span>
                                    </div>
                                    <h6>Email</h6>
                                    <p>info@chickycharchar.com.au</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mbp-0">
                             <div class="contact-form">
                       <form method="post" action="<?php echo base_url() ?>Home/saveenquiryform">
                           <?php echo $this->session->flashdata('error_pwd'); ?>
                            <div class="row m-0">


                                <div class="form-group col-md-4" >
                                    <input type="text" placeholder="Enter Name" name = "name" class="form-control" required/>
                                </div>

                                <div class="form-group col-md-4" >
                                    <input type="text" placeholder="Enter Mobile Number" maxlength = "11" name = "phone" class="form-control" required />
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" placeholder="Enter Email Id" name = "email" class="form-control" required />
                                </div>

                                <div class=" form-group col-md-12">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                    <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>"> 
                                    <textarea placeholder="Enter Message" name = "additionalinfo" class="form-control" rows="9" required></textarea>  
                                </div>
                                <div class="col-md-12 mt-4 text-center">
                                    
                                      <button type="submit" class="button" name = "submit" value = "submit">Send Message</button>
                                </div>
                            </div>
                             </form>
   </div>   </div>
                    </div>
                </div>
            </div>

                </section>

<style>
.process-icon img{
  height: 70px;
    object-fit: contain;  
}   
.home-hide{
    display:none!important;
}
</style>
           
            
  <?php
include_once'footer.php';
?>
            </body>
        </html>
