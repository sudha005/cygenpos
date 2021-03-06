<?php
@session_start();
@ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Boostrap style -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/icon-font.min.css">
 <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
<!-- link to the SqPaymentForm library -->
<script type="text/javascript" src="https://js.squareup.com/v2/paymentform">
</script>
<!-- link to the local SqPaymentForm initialization -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/sqpaymentform.js">
</script>
<!-- link to the custom styles for SqPaymentForm -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/sqpaymentform-basic.css">
<script>
document.addEventListener("DOMContentLoaded", function(event) {
if (SqPaymentForm.isSupportedBrowser()) {
paymentForm.build();
paymentForm.recalculateSize();
}
});
</script>
</head>   
   
   <body>
<?php 
$CI =& get_instance();
$amount =$price;  
?>
     
                <div class='container mt-5 mb-5 p-0'>
    <div class="inner row d-flex justify-content-center">
      
        <div class="card col-md-6 col-12 box2">
            <div class="card-content">
                <div class="card-header box2-head">
                    
                    <div class="row">
      <div class="col s10 text-center">
          <img src="https://chickycharchar.com.au/assets/images/logo.png" height="50px">
      </div>
   </div>
                    <div class="heading2"> PAYMENT DETAILS </div>
                </div>
                <div class="card-body col-10 offset-1">
                   <div id="sq-ccbox">
                      <p style="color:#FF0000"> <?php echo ($this->session->flashdata('message')!='' &&  $this->session->flashdata('message')!='')?$this->session->flashdata('message'):''; ?></p>
    <!--
      Be sure to replace the action attribute of the form with the path of
      the Transaction API charge endpoint URL you want to POST the nonce to
      (for example, "/process-card")
    -->
    <form id="nonce-form" novalidate action="<?php echo base_url() ?>Stripe/paymentProcess" method="post">
         <input type="hidden" name="<?php echo $CI->security->get_csrf_token_name(); ?>" value="<?php echo $CI->security->get_csrf_hash(); ?>" />
      <fieldset>
        <span class="label">Card Number</span>
        <div id="sq-card-number"></div>

        <div class="third">
          <span class="label">Expiry Date</span>
          <div id="sq-expiration-date"></div>
        </div>

        <div class="third">
          <span class="label">CVV</span>
          <div id="sq-cvv"></div>
        </div>

      
      </fieldset>

      <button id="sq-creditcard" class="button-credit-card" onclick="requestCardNonce(event)">Pay <?php echo $amount; ?></button>

      <div id="error"></div>

      <!--
        After a nonce is generated it will be assigned to this hidden input field.
      -->
	  <input type="hidden" id="amount" name="amount" value="<?php echo $amount; ?>">
      <input type="hidden" id="card-nonce" name="nonce">
    </form>
  </div> <!-- end #sq-ccbox -->
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
               
                
            
      
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://js.stripe.com/v2/"></script>
	<script>
// Set your publishable key
Stripe.setPublishableKey('pk_test_51HDJV4B7W3cmPoGrzVTMUrhoxFjS0tWnUiaiTQlOxZ2J1QdJUxIGJ5CWR1eKsTZM0via6lmyqc98Js0HAGpsLx9Z00y8ZW2jAG');
// Callback to handle the response from stripe
function stripeResponseHandler(status, response) {
    console.log(response);
   
    if (response.error) {
        // Enable the submit button
        $('#payBtn').removeAttr("disabled");
        // Display the errors on the form
        $(".payment-status").html('<p style="color:red">'+response.error.message+'</p>');
        return false;
    } else {
        var form$ = $("#paymentFrm");
        // Get token id
        var token = response.id;
        // Insert the token into the form
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        // Submit form to the server
         form$.get(0).submit();
         return false;
    }
}
$(document).ready(function() {
    // On form submit
    $("#paymentFrm").submit(function() {
        
        // Disable the submit button to prevent repeated clicks
        $('#payBtn').attr("disabled", "disabled");
	
        // Create single-use token to charge the user
        Stripe.createToken({
            number: $('#card_number').val(),
            exp_month:$('#card_exp_month').val(),
            exp_year: $('#card_exp_year').val(),
            cvc: $('#card_cvc').val()
        }, stripeResponseHandler);
		
        // Submit from callback CheckNoYear
        return false;
    });
});
</script>
<script type="text/javascript">
function CheckNo(sender){
    if(!isNaN(sender.value)){
        if(sender.value > 12 )
            sender.value = 12;
        if(sender.value <= 0 )
            sender.value = 1;
    }else{
          sender.value = 1;
    }
}
function CheckNoYear(sender){
    if(!isNaN(sender.value)){
        if(sender.value > 2030)
            sender.value = 2030;
        if(sender.value <= 2019 )
            sender.value = 2019;
    }else{
          sender.value = 2019;
    }
}
</script>
     <style>
      .lastcont{
          margin-bottom:38px!important;
      }
      h6 .letterspace{
          letter-spacing:0px!important;
      }
      label.error{
          color:red;
      }
      .bt-question-form{
          border:1px solid #d3d3d3;
          padding:50px;
          height:410px;
          border-radius:10px;
		  background-color:#2d3b52;
      }
    
.box1 {
    background-color: #263238;
    color: white
}

.card-header {
    background: none
}

.box1 {
    height: 600px
}

.box2 {
    height: 600px
}

.heading {
    font-weight: 900
}

.heading2 {
    padding-left: 40px
}

.box2-head {
    font-weight: 900;
    background: none;
    border: none
}

.card-header {
    margin-top: 50px;
    padding-left: 19px
}

.sub-heading {
    font-weight: 900;
    font-size: 14px
}

.sub-heading2 {
    border: 1px solid white;
    padding-top: 10px;
    padding-bottom: 10px
}

.sub-heading1 {
    background-color: white;
    color: #263238;
    padding-top: 10px;
    padding-bottom: 10px
}

.credit {
    position: absolute;
    left: 8vw
}

.frnt {
    z-index: 2;
    position: absolute
}

.back {
    position: absolute;
    z-index: 1;
    left: 70px;
    top: 30px
}

.form-group>input {
    border: none;
    border-bottom: 1px solid lightgray
}

.card-number>input {
    border: none
}

.card-number {
    border-bottom: 1px solid lightgray
}

.card-number>input::-webkit-input-placeholder {
    color: peachpuff;
    font-size: 25px
}

.card-number>input::-moz-placeholder {
    color: peachpuff;
    font-size: 25px
}

.card-number>input:-ms-input-placeholder {
    color: peachpuff;
    font-size: 25px
}

.card-number>input::placeholder {
    color: peachpuff;
    font-size: 25px
}

input.focus,
input:focus {
    outline: 0;
    box-shadow: none !important
}

.card-number.hover,
.card-number:hover {
    outline: 0;
    box-shadow: none !important;
    border-bottom: 1px solid lightskyblue
}

select.focus,
select:focus {
    outline: 0;
    box-shadow: none !important
}

.form-control {
    border: none;
    border-bottom: 1px solid lightgray
}

.txt {
    justify-content: space-between
}

.txt>p>small {
    font-weight: 900
}

.total {
    justify-content: space-between
}

.btn {
    height: 60px;
    background-color: #00B8D4;
    color: white
}

.footer2 {
    background: none
}

.btn.focus,
.btn:focus {
    outline: 0;
    box-shadow: none !important
}

@media (min-width: 1025px) and (max-width: 1280px) {
    .inner {
        margin-left: 150px
    }
}
      </style>
   </body>
</html>