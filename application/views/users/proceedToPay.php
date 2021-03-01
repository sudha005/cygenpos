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
                        <h3>Checkout</h3>
                    </div>
                </div>
            </div> 
        </section>
        <section class="checkout">
            <div class="container">
                <div class="row m-0 rowmobile">
                    <div class="col-md-8 p-0">
                        <div class="cart-box">
                            <h3 class="items-cart"> <span>Select delivery address</span></h3> 
                            <p>You have a saved address in this location.</p>
                   <div class="row m-0 rowmobile">
                       <div class="col-md-12 text-right form-group">
                       <a class="addtocart" href="">ADD NEW</a>
                       </div>
                       <div class="clearfix"></div>
                                    <div class="col-md-6 ">
                                        <div class="myaddressbox">
                                        <h3 class="add-heading">Work</h3>
                                            <p class="myaddressp">326/336 Great Western Hwy, Wentworthville NSW 2145</p>
                                            <a href="" class="edit-btn">Edit</a>&nbsp;&nbsp; <a href="" class="delete-btn">Delete</a>
                                        </div>
                                    </div>
                                     <div class="col-md-6 ">
                                        <div class="myaddressbox">
                                        <h3 class="add-heading">Home</h3>
                                            <p class="myaddressp">326/336 Great Western Hwy, Wentworthville NSW 2145</p>
                                            <a href="" class="edit-btn">Edit</a>&nbsp;&nbsp; <a href="" class="delete-btn">Delete</a>
                                        </div>
                                    </div>
                                     <div class="col-md-6 ">
                                        <div class="myaddressbox">
                                        <h3 class="add-heading">Other</h3>
                                            <p class="myaddressp">326/336 Great Western Hwy, Wentworthville NSW 2145</p>
                                            <a href="" class="edit-btn">Edit</a>&nbsp;&nbsp; <a href="" class="delete-btn">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            <div class="row m-0">
                             

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mbp-0">
                        <div class="cart-box">
                            <h3 class="items-cart"> <span>Review Order</span></h3> 
                            <ul class="cart-total">
                                <li>Subtotal<span>$45</span></li>
                                <li>Taxes<span>$45</span></li>  
                                <li>Packing Charges<span>$45</span></li>   
                                <li>Delivery Charges<span>$45</span></li>
                            </ul>
                            <h4 class="cart-total-heading">To Pay <span>$180</span></h4>
                            
                               <h3 class="items-cart"> <span>Payment</span></h3> 
                            <p>We accept <img src="assets/images/accepted_c22e0.png" class="img-fluid payimage"></p>
                            
                            <div class="form-group text-right">
                                <a href="" class="login-btn">Proceed</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
         <?php include_once'footer.php';?>
       
    </body>
</html>

<script>
    $(document).ready(function(){

        var quantitiy=0;
        $('.quantity-right-plus').click(function(e){
            e.preventDefault();
            var quantity = parseInt($('#quantity').val());
            $('#quantity').val(quantity + 1);
        });

        $('.quantity-left-minus').click(function(e){
            e.preventDefault();
            var quantity = parseInt($('#quantity').val());
            if(quantity>0){
                $('#quantity').val(quantity - 1);
            }
        });

    });
</script>