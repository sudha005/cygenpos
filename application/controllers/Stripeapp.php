<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class Stripeapp extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_info();
	//	$this->load_global();
		$this->load->model('items_model','items');
		$this->load->model('category_model','category');
		
	}

	public function index()
	{
          	$id = $this->input->get('order_id');
          	$wherearray2=array('id'=>$id);
         	$order_id=$this->items->getSingleColumnNameMultiple('sales_code','db_sales',$wherearray2);
         	$wherearray=array('sales_code'=>$order_id);
         	$price=$this->items->getSingleColumnNameMultiple('grand_total','db_sales',$wherearray);
         	$user_id = $this->items->getSingleColumnNameMultiple('customer_id','db_sales',$wherearray);
            $customer_id=$this->items->getSingleColumnNameMultiple('customer_id','db_sales',$wherearray);
        //	$price=1;
         $data['price']   = $price;
         $data['order_id']   = $order_id;
		$this->load->view('users/stripe/payment_form',$data);
	}
    public function paymentProcess(){
         	$order_id =$_POST['order_id'];
         	$wherearray=array('sales_code'=>$order_id);
         	$price=$this->items->getSingleColumnNameMultiple('grand_total','db_sales',$wherearray);
         	$user_id = $this->items->getSingleColumnNameMultiple('customer_id','db_sales',$wherearray);
            $customer_id=$this->items->getSingleColumnNameMultiple('customer_id','db_sales',$wherearray);
        require_once('application/libraries/connect-php-sdk-master/vendor/autoload.php');
      
$access_token = 'EAAAEJ3TjlDW-BjuoAz6sNEcLzaE_-3LyH6tIFlrsno1jqEjzt2hRbSDKJgaLX5w';
# setup authorization
\SquareConnect\Configuration::getDefaultConfiguration()->setAccessToken($access_token);
# create an instance of the Transaction API class
$transactions_api = new \SquareConnect\Api\TransactionsApi();
$location_id ='LY1QS1HA57RH1';
$nonce = $_POST['nonce'];

$request_body = array (
    "card_nonce" => $nonce,
    # Monetary amounts are specified in the smallest unit of the applicable currency.
    # This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
    "amount_money" => array (
        "amount" => (int) ($_POST['amount']*100),
        "currency" => "AUD"
    ),
    # Every payment you process with the SDK must have a unique idempotency key.
    # If you're unsure whether a particular payment succeeded, you can reattempt
    # it with the same idempotency key without worrying about double charging
    # the buyer.
    "idempotency_key" => uniqid()
);

try {
    $result = $transactions_api->charge($location_id,  $request_body);
     
	if($result['transaction']['id']){
		
	 	       
            	$user_id = $user_id;
            	//Saving data into reward transactions
            	$order_date = date('Y-m-d H:i:s');
            	//after placing order that item will delete in cart
                $totalPrice=$_POST['amount'];
         
        	
        	
        	
        	$getWalletAmount = getIndividualDetails('db_sales','sales_code',$order_id);
	$getUserDetails = getIndividualDetails('db_customers','id',$user_id);
	$getOrderAddress = getIndividualDetails('grocery_del_addr','order_id',$order_id);
	$delivery_type =$getWalletAmount['delivery_type'];
	$deliveryDate= date("d-F-Y", strtotime($getWalletAmount['delivery_slot_date']));
    $saleid = $getWalletAmount['id'];
    $sales_id= $getWalletAmount['id'];
        	$CUR_DATE=date('Y-d-m');
        		     $salespayments_entry = array(
					'sales_id' 		=> $sales_id, 
					'payment_date'		=> $CUR_DATE,//Current Payment with sales entry
					'payment_type' 		=> 'squareup',
					'payment' 			=> $totalPrice,
					'payment_note' 		=> 'online payment',
					'created_date' 		=> $CUR_DATE,
    				'created_time' 		=> date('H:i:s a'),
    				'created_by' 		=> $customer_id,
    				'system_ip' 		=> $_SERVER['SERVER_ADDR'],
    				'system_name' 		=> gethostname(),
    				'status' 			=> 1,
				);

			$q3 = $this->db->insert('db_salespayments', $salespayments_entry);
        	$payment_status="Paid";
        	$q7=$this->db->query("update db_sales set 
							payment_status='$payment_status',
							paid_amount=$totalPrice,
							status=1
							where id='$sales_id'");


		$q12 = $this->db->query("update db_customers set sales_due=(select COALESCE(SUM(grand_total),0)-COALESCE(SUM(paid_amount),0) from db_sales where customer_id='$customer_id' and sales_status='Final') where id=$customer_id");
        	if($q3 && $q7){
        	     $paymentstatus_entry = array(
					'sales_id' 		=> $sales_id,
					'payment_status' => '1'
					
				);
        	}else{
        	    $paymentstatus_entry = array(
					'sales_id' 		=> $sales_id,
					'payment_status' => '2'
					
				);
        	}
			$payments = $this->db->insert('db_online_transaction_history', $paymentstatus_entry);
        
    $data['sales_id']= $saleid;
	$this->load->library('email'); 
	$config['mailtype'] = 'html';
	$this->email->initialize($config);
	$customer_email=$getUserDetails['email'];
//	$from_email="info@Cococubanorousehill.com.au";
    $from_email="jollygoodindian@gmail.com";
	$subject = "JOLLY GOOD  ( '.$order_id.' )";
	$this->email->from($from_email,"Your JOLLY GOOD new order  (".$order_id.")"); 
	$this->email->to($customer_email);
	$this->email->subject($subject); 
	$body = $this->load->view('users/emailtemplate/order_email',$data,TRUE);
	$this->email->message($body); 
	$this->email->send();	
    $statusMsg = "The transaction was successful.";	
		
	     
    $CI =& get_instance();
    $url = "https://cozyerp.com/cozypos/v2/cygenpos_orders/orderRelay/receive_orders";
    	
    	
   $getorders = $this->db->query("SELECT created_time,created_date,customer_id,grand_total,tot_discount_to_all_amt,id,other_charges_amt,other_charges_tax_id FROM db_sales WHERE id = '$saleid' AND status = 1");
      
	  $getorderDetails =$getorders->row_array();
	  if($getorders->num_rows() > 0){
        $payment_detail=$this->db->query("SELECT * FROM db_salespayments  WHERE sales_id = '$saleid'");
        if($payment_detail->num_rows() > 0){
            $payment_type='Online';
        }else{
            $payment_type='Pay at Store';
        }  	
    	
    	
$custname =getSingleColumnName($getorderDetails['customer_id'],'id','customer_name','db_customers');
$email    =getSingleColumnName($getorderDetails['customer_id'],'id','email','db_customers');
$mobile   =getSingleColumnName($getorderDetails['customer_id'],'id','mobile','db_customers');
$custid   =getSingleColumnName($getorderDetails['customer_id'],'id','id','db_customers');  
//   $data_pos=array (
//   'customer_id' => $getorderDetails['customer_id'],
//   'cart_gst' => $getorderDetails['other_charges_amt'],
//   'order_packing_charges' => '0.00',
//   'order_packing_charges_sgst_percent' => '0.00',
//   'cart_igst_percent' => '0.00',
//   'cart_sgst' => '0.00',
//   'cart_sgst_percent' => '0',
//   'callback_url' => NULL,
//   'cart_cgst_percent' => '0',
//   'cart_igst' => '0.00',
//   'order_packing_charges_gst' => '0.00',
//   'order_edit' => 'FALSE',
//   'delivery_type' => 'PICKUP',
//   'cart_gst_percent' => '0.00',
//   'order_packing_charges_cgst' => '0.00',
//   'order_packing_charges_igst_percent' => '0',
//   'order_type' => 'Online',
//   'restaurant_gross_bill' => $getorderDetails['grand_total'],
//   'order_packing_charges_sgst' => '0.00',
//   'order_date_time' => $getorderDetails['created_date'].' '.$getorderDetails['created_time'],
//   'cart_cgst' => '0.00',
//   'restaurant_service_charges' => '0.00',
//   'payment_type' => '',
//   'instructions '=>'',
//   'restaurant_discount' => '0.00',
//   'order_packing_charges_cgst_percent' => '0',
//   'outlet_id' => 'S01610',
//   'order_edit_reason' => NULL,
//   'is_thirty_mof' => false,
//   'customer_name' => $custname,
//   'customer_email' => $email,
//   'customer_mobile' => $mobile,
//   'order_id' => $order_id,
//   'items'    =>self::seles_detail($saleid)
// );
    	
    	
// 		$encodedJsonData = json_encode($data_pos,true);
// 		$this->curl->option(CURLOPT_HTTPHEADER, array("api-key: " . '614BF0BE8A6748798AA0800F26462944','Content-Type: application/json'));
// 		$this->curl->create($url);
// 		$this->curl->post($encodedJsonData);
// 		$result = json_decode($this->curl->execute(),true);
// 		$info = curl_getinfo($ch);
//       // print_r($info);
	     
// 	  //  echo $encodedJsonData;
// 	  // print_r($result);
// 	  if(count($result) > 0){
// 	  $timestamp=$result['timestamp'];
// 	   $status_code=$result['status_code'];
// 	    $status_message=$result['status_message'];
// 	     $external_order_id=$result['external_order_id'];
// 	      $swiggy_order_id=$result['swiggy_order_id'];
// 	      $sqlcozy = "INSERT INTO db_cozyapi_logs (`timestamp`, `status_code`, `status_message`, `external_order_id`,`swiggy_order_id`) VALUES ('$timestamp','$status_code','$status_message','$external_order_id','$swiggy_order_id')";
//           $result=$this->db->query($sqlcozy);
          
//           $fileLocation =realpath(FCPATH.'uploads/cozyapijson')."/".$order_id.".txt";
//           $file = fopen($fileLocation,"w");
//           fwrite($file,$encodedJsonData);
//           fclose($file);
// 	  }
	    //db_cozyapi_logs
	  
	 //  exit;
	
	  }	
        

        
        // $CI->session->unset_userdata($sample);
          $this->session->set_flashdata('message',$statusMsg);
          $baseurl=base_url().'thankyou?order_id='.$order_id;
          redirect($baseurl);	

		
	//	echo "Transation ID: ".$result['transaction']['id']."";
	}
} catch (\SquareConnect\ApiException $e) {
   // echo "Exception when calling TransactionApi->charge:";
   
           $erro_detailar= json_encode($e->getResponseBody());
          
           $this->session->set_flashdata('message',$erro_detailar);
          $baseurl=base_url().'squareupapp?order_id='.$order_id;
          redirect($baseurl);	
    
    
    
}
    }
	    public function stripePost()
    {        

       	    $order_id = $this->session->userdata('order_last_session_id');
         	$user_id = $this->session->userdata('user_login_session_id');
         	$wherearray=array('sales_code'=>$order_id);
        $totalPrice  = $this->items->getSingleColumnNameMultiple('grand_total','db_sales',$wherearray);
        $totalPrice=1;
        $sales_id=$this->items->getSingleColumnNameMultiple('id','db_sales',$wherearray);
        $firstName = 'Cococubanorousehill';
        $email = 'info@spicybean.com.au';
        require_once('application/libraries/stripe-php/init.php');
        try{
        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
        //     $customer = \Stripe\Customer::create(array(
        //     'email' => $email,
        //     'source'  => $stripe_token
        // ));
        $charge = \Stripe\Charge::create ([
                "amount" =>$totalPrice * 100,
                "currency" => "AUD",
                "source" => $this->input->post('stripeToken'),
                "description" => "Payment For Cococubanorousehill"
                
        ]);
        $chargeJson = $charge->jsonSerialize();
        
        if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){

        //retrieve charge details
        $chargeJson = $charge->jsonSerialize();
        $stripe_token=$this->input->post('stripeToken');
        $amount = $chargeJson['amount'];
        $balance_transaction = $chargeJson['balance_transaction'];
        $currency = $chargeJson['currency'];
        $status = $chargeJson['status'];
        $date = date("Y-m-d H:i:s");
        
        // $bookingId = $this->session->userdata('carbookingId');
        // $where=array(
        //     'bookingNumber'=>$bookingId
        // );
        // $update =array(
        //   'status'=>1
        // );
        if($status =='succeeded'){
        //      $CI = & get_instance();
        //      $CI->load->model('Accounts_model');
        //       $data=array(
        //       'status'=>1
        //       );
        //   $transactionsId =implode(",",$trasactionList);
        //   $CI->db->where_in('id',$transactionsId);
         // $saveCart = $CI->db->update('customer_ledger', $data); 
            	$order_id = $this->session->userdata('order_last_session_id');
            	$user_id = $this->session->userdata('user_login_session_id');
            	//Saving data into reward transactions
            	$order_date = date('Y-m-d H:i:s');
            	//after placing order that item will delete in cart

         	$session_cart_id = $this->session->userdata('CART_TEMP_RANDOM');
         	$delCart ="DELETE FROM grocery_cart WHERE user_id = '$user_id' OR session_cart_id='$session_cart_id' ";
        	$this->db->query($delCart);
        	$CUR_DATE=date('Y-d-m');
        		     $salespayments_entry = array(
					'sales_id' 		=> $sales_id, 
					'payment_date'		=> $CUR_DATE,//Current Payment with sales entry
					'payment_type' 		=> 'Stripe',
					'payment' 			=> $totalPrice,
					'payment_note' 		=> 'online payment',
					'created_date' 		=> $CUR_DATE,
    				'created_time' 		=> date('H:i:s a'),
    				'created_by' 		=> $CUR_USERNAME,
    				'system_ip' 		=> $_SERVER['SERVER_ADDR'],
    				'system_name' 		=> gethostname(),
    				'status' 			=> 1,
				);

			$q3 = $this->db->insert('db_salespayments', $salespayments_entry);
        	$payment_status="Paid";
        	$q7=$this->db->query("update db_sales set 
							payment_status='$payment_status',
							paid_amount=$totalPrice 
							where id='$sales_id'");


		$q12 = $this->db->query("update db_customers set sales_due=(select COALESCE(SUM(grand_total),0)-COALESCE(SUM(paid_amount),0) from db_sales where customer_id='$customer_id' and sales_status='Final') where id=$customer_id");
        	
        $getWalletAmount = getIndividualDetails('db_sales','sales_code',$this->session->userdata('order_last_session_id'));
	$getUserDetails = getIndividualDetails('db_customers','id',$user_id);
	$getOrderAddress = getIndividualDetails('grocery_del_addr','order_id',$this->session->userdata('order_last_session_id'));
	$delivery_type =$getWalletAmount['delivery_type'];
	$deliveryDate= date("d-F-Y", strtotime($getWalletAmount['delivery_slot_date']));
    $saleid = $getWalletAmount['id'];
    $data['sales_id']= $saleid;
	$this->load->library('email'); 
	$config['mailtype'] = 'html';
	$this->email->initialize($config);
	$customer_email=$getUserDetails['email'];
//	$from_email="info@Cococubanorousehill.com.au";
    $from_email="info@spicybean.com.au";
	$subject = "Cococubanorousehill new order  ( '.$order_id.' )";
	$this->email->from($from_email,"Your Cococubanorousehill new order  (".$order_id.")"); 
	$this->email->to($customer_email);
	$this->email->subject($subject); 
	$body = $this->load->view('users/emailtemplate/order_email',$data,TRUE);
	$this->email->message($body); 
	$this->email->send();	
        	
          $statusMsg = "The transaction was successful.";
        }else{
            $statusMsg = "Transaction has been failed";
        }
    }else{
        $statusMsg = "Transaction has been failed";
    }
    
        }
    
    catch(Stripe_CardError $e) {
  $statusMsg = $e->getMessage();
} catch (Stripe_InvalidRequestError $e) {
  // Invalid parameters were supplied to Stripe's API
  $statusMsg = $e->getMessage();
} catch (Stripe_AuthenticationError $e) {
  // Authentication with Stripe's API failed
  $statusMsg = $e->getMessage();
} catch (Stripe_ApiConnectionError $e) {
  // Network communication with Stripe failed
  $statusMsg = $e->getMessage();
} catch (Stripe_Error $e) {
  // Display a very generic error to the user, and maybe send
  // yourself an email
  $statusMsg = $e->getMessage();
} catch (Exception $e) {
  // Something else happened, completely unrelated to Stripe
  $statusMsg = $e->getMessage();
}
      if($status =='succeeded'){
          
    $CI =& get_instance();
    $url = "https://cozyerp.com/cozypos/v2/cygenpos_orders/orderRelay/receive_orders";
    	
    	
   $getorders = $this->db->query("SELECT created_time,created_date,customer_id,grand_total,tot_discount_to_all_amt,id,other_charges_amt,other_charges_tax_id FROM db_sales WHERE id = '$saleid' AND status = 1");
      
	  $getorderDetails =$getorders->row_array();
	  if($getorders->num_rows() > 0){
        $payment_detail=$this->db->query("SELECT * FROM db_salespayments  WHERE sales_id = '$saleid'");
        if($payment_detail->num_rows() > 0){
            $payment_type='Online';
        }else{
            $payment_type='Pay at Store';
        }  	
    	
    	
$custname =getSingleColumnName($getorderDetails['customer_id'],'id','customer_name','db_customers');
$email    =getSingleColumnName($getorderDetails['customer_id'],'id','email','db_customers');
$mobile   =getSingleColumnName($getorderDetails['customer_id'],'id','mobile','db_customers');
$custid   =getSingleColumnName($getorderDetails['customer_id'],'id','id','db_customers');  
  $data_pos=array (
  'customer_id' => $getorderDetails['customer_id'],
  'cart_gst' => $getorderDetails['other_charges_amt'],
  'order_packing_charges' => '0.00',
  'order_packing_charges_sgst_percent' => '0.00',
  'cart_igst_percent' => '0.00',
  'cart_sgst' => '0.00',
  'cart_sgst_percent' => '0',
  'callback_url' => NULL,
  'cart_cgst_percent' => '0',
  'cart_igst' => '0.00',
  'order_packing_charges_gst' => '0.00',
  'order_edit' => 'FALSE',
  'delivery_type' => 'PICKUP',
  'cart_gst_percent' => '0.00',
  'order_packing_charges_cgst' => '0.00',
  'order_packing_charges_igst_percent' => '0',
  'order_type' => 'Online',
  'restaurant_gross_bill' => $getorderDetails['grand_total'],
  'order_packing_charges_sgst' => '0.00',
  'order_date_time' => $getorderDetails['created_date'].' '.$getorderDetails['created_time'],
  'cart_cgst' => '0.00',
  'restaurant_service_charges' => '0.00',
  'payment_type' => '',
  'instructions '=>'',
  'restaurant_discount' => '0.00',
  'order_packing_charges_cgst_percent' => '0',
  'outlet_id' => 'S01610',
  'order_edit_reason' => NULL,
  'is_thirty_mof' => false,
  'customer_name' => $custname,
  'customer_email' => $email,
  'customer_mobile' => $mobile,
  'order_id' => $order_id,
  'items'    =>self::seles_detail($saleid)
);
    	
    	
// 		$encodedJsonData = json_encode($data_pos,true);
// 		$this->curl->option(CURLOPT_HTTPHEADER, array("api-key: " . '614BF0BE8A6748798AA0800F26462944','Content-Type: application/json'));
// 		$this->curl->create($url);
// 		$this->curl->post($encodedJsonData);
// 		$result = json_decode($this->curl->execute(),true);
// 		$info = curl_getinfo($ch);
       // print_r($info);
	     
	  //  echo $encodedJsonData;
	  // print_r($result);
// 	  if(count($result) > 0){
// 	  $timestamp=$result['timestamp'];
// 	   $status_code=$result['status_code'];
// 	    $status_message=$result['status_message'];
// 	     $external_order_id=$result['external_order_id'];
// 	      $swiggy_order_id=$result['swiggy_order_id'];
// 	      $sqlcozy = "INSERT INTO db_cozyapi_logs (`timestamp`, `status_code`, `status_message`, `external_order_id`,`swiggy_order_id`) VALUES ('$timestamp','$status_code','$status_message','$external_order_id','$swiggy_order_id')";
//           $result=$this->db->query($sqlcozy);
          
//           $fileLocation =realpath(FCPATH.'uploads/cozyapijson')."/".$order_id.".txt";
//           $file = fopen($fileLocation,"w");
//           fwrite($file,$encodedJsonData);
//           fclose($file);
// 	  }
	    //db_cozyapi_logs
	  
	 //  exit;
	
	  }	
        
        
        
        
        
        
        // $CI->session->unset_userdata($sample);
          $this->session->set_flashdata('message',$statusMsg);
          $baseurl=base_url().'thankyou';
          redirect($baseurl);
      }else{
         echo $statusMsg ;
        $this->session->set_flashdata('message', 'Trasaction Fial');
        $baseurl=base_url().'thankyou';
       // redirect($baseurl);
      }
                
    }
	
	
	
public function seles_detail($salesId){
    $getitems = $this->db->query("SELECT * FROM db_salesitems WHERE sales_id = '$salesId' AND status = 1");
	        $getitemDetails =$getitems->result();
	        foreach ($getitemDetails as $key1 => $field1) {
	        $getitemDetails[$key1]->itemName = getSingleColumnName($field1->item_id,'id','item_name','db_items');
	        
	        $getitemDetails[$key1]->sgst = $field1->tax_amt> 0?$field1->tax_amt:'0';
	        $getitemDetails[$key1]->gst_inclusive = $field1->tax_type;
	        $getitemDetails[$key1]->quantity = $field1->sales_qty;
	        $getitemDetails[$key1]->cgst_percent = 0;
	        $getitemDetails[$key1]->reward_type = null;
	        $getitemDetails[$key1]->addons = [];
	        $getitemDetails[$key1]->discount = $field1->discount_amt;
	        $getitemDetails[$key1]->cgst = $field1->tax_amt> 0?$field1->tax_amt:'0';
	        $getitemDetails[$key1]->variants = [];
	        $getitemDetails[$key1]->igst = $field1->tax_amt> 0?$field1->tax_amt:'0';
	        $getitemDetails[$key1]->sgst_percent = 0;
	        $getitemDetails[$key1]->subtotal = $field1->total_cost;
	        $getitemDetails[$key1]->price = $field1->price_per_unit;
	        
            $getitemDetails[$key1]->id = getSingleColumnName($field1->item_id,'id','cozy_id','db_items');
            $getitemDetails[$key1]->name =getSingleColumnName($field1->item_id,'id','item_name','db_items');
            $getitemDetails[$key1]->igst_percent = 0;
            $getitemDetails[$key1]->packing_charges = 0;
             unset($getitemDetails[$key1]->itemName);
             unset($getitemDetails[$key1]->tax_amt);
             unset($getitemDetails[$key1]->tax_type);
             unset($getitemDetails[$key1]->sales_qty);
             unset($getitemDetails[$key1]->discount_amt);
             unset($getitemDetails[$key1]->item_id);
             unset($getitemDetails[$key1]->price_per_unit);
             unset($getitemDetails[$key1]->sales_id);
             unset($getitemDetails[$key1]->sales_status);
             unset($getitemDetails[$key1]->description);
             unset($getitemDetails[$key1]->status);
             unset($getitemDetails[$key1]->total_cost);
              unset($getitemDetails[$key1]->unit_total_cost);
              unset($getitemDetails[$key1]->unit_discount_per);
                unset($getitemDetails[$key1]->tax_id);
             
	       }
	        return $getitemDetails;
	        
}


}
