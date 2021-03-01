
//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent,target){

    if(kevent.keyCode==13){
		$("#"+target).focus();
    }
	
}
/*Email validation code*/
function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}
$('.void_invoice').click(function (e) {
     var hidden_order_id=$("#hidden_order_id").val();
    if(hidden_order_id!=0){
        toastr["warning"]("You have selected running order's");
        return;
    }
      swal({
title: 'Void All Products?',
icon: "warning",
buttons: [
'Cancel',
'OK'
],
dangerMode: true,
}).then(function(isConfirm) {
     if (isConfirm) {
		var id =1;
		var base_url=$("#base_url").val().trim();
		$.post(base_url+"pos/voidCart",{id:id},function(result_data){
			if(result_data) {
			  $.post(base_url+"pos/cart_detail",{id:id},function(result_data_response){
				$("#pos-form-tbody").html(result_data_response);
				$.post(base_url+"pos/cart_summery",{id:id},function(result_data_response_summery){
				  var cart_summery=result_data_response_summery.split('~')
				$(".tot_qty").text(0);
				$(".tot_amt").text(0);
				$(".tot_grand").text(0);
				$(".tot_discount_amt").text(0) ;
				
				
				});
	
			  });
	
	
			}	

		});

	$(".overlay").remove();
	success.currentTime = 0;
	success.play();
     }
    swal.close(); 
});

}); //void_invoice end


// for place order
















$('#save1,#update1').click(function (e) {
alert();
});


/* *********************** HOLD INVOICE START****************************/
$('#hold_invoice').click(function (e) {

	//table should not be empty
	if($(".items_table tr").length==1){
    	toastr["error"]("Please Select Items from List!!");
    	failed.currentTime = 0;
		failed.play();
		return;
    }

	swal({
		title: "Hold Invoice ?",icon: "warning",buttons: true,dangerMode: true,
		content: {
			element: "input",attributes: 
			{
				placeholder: "Please Enter Reference Number!",
				type: "text",
				
				inputAttributes: {
				    maxlength: '5'
				  }
			},},
		}).then(name => {
			//If input box blank Throw Error
			if (!name.trim()){ throw null; return false; }
			var reference_id = name;
			/* ********************************************************** */
			var base_url=$("#base_url").val().trim();
    
			//RETRIVE ALL DYNAMIC HTML VALUES
		    var tot_qty=$(".tot_qty").text();
		    var tot_amt=$(".tot_amt").text();
		    var tot_disc=$(".tot_disc").text();
		    var tot_grand=$(".tot_grand").text();
		    var hidden_rowcount=$("#hidden_rowcount").val();

		    var this_id=this.id;//id=save or id=update

				e.preventDefault();
				data = new FormData($('#pos-form')[0]);//form name
				/*Check XSS Code*/
				if(!xss_validation(data)){ return false; }
				
				$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
				$("#"+this_id).attr('disabled',true);  //Enable Save or Update button				
				$.ajax({
					type: 'POST',
					url: base_url+'pos/hold_invoice?reference_id='+reference_id,
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					success: function(result){
					    console.log(result);
						//alert(result);return;
						// $("#hidden_invoice_id").val('');
						// result=result.trim().split("<<<###>>>");
						
						// 	if(result[0]=="success")
						// 	{
						// 		$('#pos-form-tbody').html('');
						// 		//CALCULATE FINAL TOTAL AND OTHER OPERATIONS
		    			// 		final_total();

						// 		hold_invoice_list();
						// 		success.currentTime = 0;
						// 		success.play();
						// 	}
						// 	else if(result[0]=="failed")
						// 	{
						// 	   toastr['error']("Sorry! Failed to save Record.Try again");
						// 	}
						// 	else
						// 	{
						// 		alert(result);
						// 	}
						
					//	$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
						$(".overlay").remove();
				   }
			   });
			/* ********************************************************** */

		}) //name end
	.catch(err => {
	    toastr['error']("Failed!! Invoice Not Saved! <br/>Please Enter Reference Number");
	    failed.currentTime = 0;
		failed.play();
	});//swal end

}); //hold_invoice end

   $('body').on('click', '.savecash_in', function(e) {
			/* ********************************************************** */
			var base_url=$("#base_url").val().trim();
			
			 var flag=true;

    function check_field(id)
    {
      if(!$("#"+id).val().trim() ) //Also check Others????
        {
            $('#'+id+'_msg').fadeIn(200).show().html('Required Field').addClass('required');
           // $('#'+id).css({'background-color' : '#E8E2E9'});
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
             //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }

    //Validate Input box or selection box should not be blank or empty	
	check_field("amount");	
	
    if(flag==false)
    {

		toastr["warning"]("You have Missed Something to Fillup!")
		return;
    }
    
			//RETRIVE ALL DYNAMIC HTML VALUES
		   var user_id11=$("#user_id11").val();
		   var amount=$("#amount").val();

		    var this_id=this.id;//id=save or id=update

				e.preventDefault();
				data = new FormData($('#pos-form')[0]);//form name
				/*Check XSS Code*/
				if(!xss_validation(data)){ return false; }
				
				$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
				$("#"+this_id).attr('disabled',true);  //Enable Save or Update button				
				$.ajax({
					type: 'POST',
					url: base_url+'poscashin/save_cashin?command='+this_id+'&user_id11='+user_id11+'&amount='+amount,
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					success: function(result){
							if(result[0]=="success")
							{
							   //alert("Record Saved Successfully!");
							window.location=base_url+"pos";
							//return;
							}
							else if(result[0]=="failed")
							{
							   toastr['error']("Sorry! Failed to save Record.Try again");
							}
							else
							{
							     window.location=base_url+"pos";	
								toastr["success"](result);
							}
						
						$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
						$(".overlay").remove();
				   }
			   });
			/* ********************************************************** */

	


}); //hold_invoice end

function hold_invoice_list(){
	var base_url=$("#base_url").val().trim();
  $.post(base_url+"pos/hold_invoice_list",{},function(result){
  	//alert(result);
  	var data = jQuery.parseJSON(result)
    $("#hold_invoice_list").html('').html(data['result']);
    $(".hold_invoice_list_count").html('').html(data['tot_count']);
  });
}
function hold_invoice_delete(invoice_id){
	swal({ title: "Are you sure?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
			  if(sure) {//confirmation start
	var base_url=$("#base_url").val().trim();
  $.post(base_url+"pos/hold_invoice_delete/"+invoice_id,{},function(result){
  	result=result.trim();
    if(result=='success'){
    	toastr["success"]("Success! Invoice Deleted!!");
	    success.currentTime = 0;
		success.play();
	    hold_invoice_list();
    }
    else{
    	toastr['error']("Failed to Delete Invoice! Try again!!");
    	failed.currentTime = 0;
		failed.play();
    }
  });
  } //confirmation sure
		}); //confirmation end
}

function hold_invoice_delete_edit(invoice_id){

	var base_url=$("#base_url").val().trim();
  $.post(base_url+"pos/hold_invoice_delete/"+invoice_id,{},function(result){
  	result=result.trim();
    if(result=='success'){
    	// toastr["success"]("Success! Invoice Deleted!!");
	    success.currentTime = 0;
		success.play();
	    hold_invoice_list();
    }
    
  });
  
}




function hold_invoice_edit(invoice_id){
    
	swal({ title: "Are you sure?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
	if(sure) {//confirmation start
	
	$("#holdmodal").modal('hide');
	var base_url=$("#base_url").val().trim();
	$.post(base_url+"pos/hold_invoice_edit?invoice_id="+invoice_id,{},function(result){
    	//	alert(result);
						$("#hidden_invoice_id").val(invoice_id);

						var data = jQuery.parseJSON(result)
						
						if(data.length > 0){
								//	Make empty table list
								$('#pos-form-tbody').html('');
							//	 $("#hidden_rowcount").val('0');
								for(k=0;k<data.length;k++){
								   // alert(k);
									$("#hidden_rowcount").val(k);
									var item_id=data[k]['item_id'];
									var item_qty=data[k]['item_qty'];
									for(j=1;j<=item_qty;j++){
					  					addrow(item_id);
					  					//sudhakar
									}
					  		}
					  		//CALCULATE FINAL TOTAL AND OTHER OPERATIONS
	    					final_total();
                            $("#hidden_rowcount").val('0');
							hold_invoice_list();
							success.currentTime = 0;
							success.play();
							
						}
						
						hold_invoice_delete_edit(invoice_id);
    	});

				
		} //confirmation sure
	}); //confirmation end
}
/* *********************** HOLD INVOICE END****************************/
/* *********************** ORDER INVOICE START****************************/
function get_id_value(id){
	return $("#"+id).val().trim();
}
$('#collect_customer_info').click(function (e) {
	
	//table should not be empty
	if($(".items_table tr").length==1){
    	toastr["error"]("Please Select Items from List!!");
    	failed.currentTime = 0;
		failed.play();
		return;
    }
    if(get_id_value('customer_id')==1){
    	//$('#customer-modal').modal('toggle');
    	toastr["error"]("Please Select Customer!!");
    	failed.currentTime = 0;
		failed.play();
    	return false;
    }
    else{
    	$('#delivery-info').modal('toggle');
    }
}); //hold_invoice end
$('.show_payments_modal').click(function (e) {
	 document.getElementById("amount_1").value = ""
     calculate_payments();
	//table should not be empty
	if($(".items_table tr").length==1){
    	toastr["error"]("Please Select Items from List!!");
    	failed.currentTime = 0;
		failed.play();
		return;
    }
    else{
    	adjust_payments();
    	$("#add_payment_row,#payment_type_1").parent().show();
    	$("#amount_1").parent().parent().removeClass('col-md-12').addClass('col-md-6');
    	$('#multiple-payments-modal').modal('toggle');
    }
}); //hold_invoice end
$('#show_cash_modal').click(function (e) {
    
	//table should not be empty
	if($(".items_table tr").length==1){
    	toastr["error"]("Please Select Items from List!!");
    	failed.currentTime = 0;
		failed.play();
		return;
    }
    else{
    	adjust_payments_cash();
    	$("#add_payment_row,#payment_type_1").parent().hide();
    	$("#amount_1").focus();
    	$("#amount_1").parent().parent().removeClass('col-md-6').addClass('col-md-12');
    	$('#multiple-payments-modal-single').modal('toggle');
    }
   
}); //hold_invoice end
$('#add_payment_row').click(function (e) {
    document.getElementById("amount_1").value = ""
    calculate_payments();
	var base_url=$("#base_url").val().trim();
	//table should not be empty
	if($(".items_table tr").length==1){
    	toastr["error"]("Please Select Items from List!!");
    	failed.currentTime = 0;
		failed.play();
		return;
    }
    /*if(get_id_value('customer_id')==1){
    	//$('#customer-modal').modal('toggle');
    	toastr["error"]("Please Select Customer!!");
    	failed.currentTime = 0;
failed.play();
    	return false;
    }*/
    else{
    	/*BUTTON LOAD AND DISABLE START*/
    	var this_id=this.id;
    	var this_val=$(this).html();
    	$("#"+this_id).html('<i class="fa fa-spinner fa-spin"></i> Please Wait..');
    	$("#"+this_id).attr('disabled',true);  
    	/*BUTTON LOAD AND DISABLE END*/

    	var payment_row_count=get_id_value("payment_row_count");
    	$.post(base_url+"pos/add_payment_row",{payment_row_count:payment_row_count},function(result){
    		$('.payments_div').parent().append(result);
    		
    		$("#payment_row_count").val(parseFloat(payment_row_count)+1);

    		/*BUTTON LOAD AND DISABLE START*/
    		$("#"+this_id).html(this_val);
    		$("#"+this_id).attr('disabled',false); 
    		/*BUTTON LOAD AND DISABLE END*/    	
    		failed.currentTime = 0;
			failed.play();
    		adjust_payments();
    	});
    }
  
}); //hold_invoice end
function remove_row(id){
	$(".payments_div_"+id).html('');
	failed.currentTime = 0;
	failed.play();
	adjust_payments();
}
function calculate_payments(){
	adjust_payments();
}
function calculate_payments_cash(){
	adjust_payments_cash();
}
/* *********************** ORDER INVOICE END****************************/
