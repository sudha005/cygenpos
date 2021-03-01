<!DOCTYPE html>
<html lang="en">
    <head>
         <?php include_once'header.php';?>
    </head>
    <body>
        
        <div id="fb-root"></div>
        <section class="abt-banner p-0">
           
            <div class="container h-100">
                <div class="row m-0 h-100 justify-content-center align-items-center">
                    <div class="col-md-12 text-center">
                        <h3>Order Placed</h3>
                    </div>
                </div>
            </div> 
        </section>
        <section class="user-dashboard">
            <div class="container h-100">
                <div class="order-palced-box">
                    <div class="row m-0 rowmobile align-items-center h-100">
                        <div class="col-md-5">
                            <div class="form-group text-center">
                            <span class="lnr lnr-checkmark-circle icon-placed"></span>
                                <h6>Order Placed....</h6>
                                </div>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3806.1942304770682!2d78.3788495147764!3d17.450415305577614!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb93ded9f6f0d7%3A0xa3d91e5d00d50b63!2sCyber%20Towers!5e0!3m2!1sen!2sin!4v1594012193640!5m2!1sen!2sin" width="100%" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0" class="map-frame"></iframe>
                            <div class="row m-0 h-100 align-items-center">
                                <div class="col-md-5 col-sm-12 col-12 p-0">
                                    <p class="deliveredadd ">Ord #:12345657</p>
                                    <span class="deliveredaddspan">Order Id By</span>    
                                </div>
                                <div class="col-md-7 col-sm-12 col-12 p-0 text-right ">
                                    <p class="deliveredadd text-right">326/336 Great Western Hwy, Wentworthville NSW 2145</p>
                                    <span class="deliveredaddspan">Delivered To</span>    
                                </div>


                            </div>
                        </div>
                        <div class="col-md-7">
                            <ul  class="progress-tracker progress-tracker--text progress-tracker--vertical progress-tracker--spaced">
                                <li class="progress-step is-complete">
                                    <span class="progress-marker"><i class="fa fa-check"></i></span>
                                    <span class="progress-text">
                                        <div class="info"><h4 class="progress-title">Order Placed.</h4>
                                            <p class="summary-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                                        </div>

                                    </span>
                                </li>

                                <li class="progress-step is-complete">
                                    <span class="progress-marker"><i class="fa fa-check"></i></span>
                                    <span class="progress-text">
                                        <div class="info">
                                            <h4 class="progress-title">Food is being prepared</h4>
                                            <p class="summary-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        </div>
                                    </span>
                                </li>

                                <li class="progress-step is-complete">
                                    <span class="progress-marker"><i class="fa fa-check"></i></span>
                                    <span class="progress-text">
                                        <div class="info">
                                            <h4 class="progress-title">Order Picked Up</h4>
                                            <p class="summary-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        </div>
                                    </span>
                                </li>

                                <li class="progress-step">
                                    <span class="progress-marker"><i class="fa fa-check"></i></span>
                                    <span class="progress-text">
                                        <div class="info">
                                            <h4 class="progress-title">Order on the way </h4>
                                            <p class="summary-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        </div>
                                    </span>
                                </li>

                                <li class="progress-step">
                                    <span class="progress-marker"><i class="fa fa-check"></i></span>
                                    <span class="progress-text">
                                        <div class="info">
                                            <h4 class="progress-title">Order Delivered</h4>
                                            <p class="summary-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        </div>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include_once'footer.php';?>
    </body>
</html>