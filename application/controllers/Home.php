<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_info();
	//	$this->load_global();
		$this->load->model('items_model','items');
		$this->load->model('category_model','category');
		
	}

	public function index()
	{
	    $category =self::category_menu();
	    $item=$this->items->item_list_home1();
	    $item2=$this->items->item_list_home2();
	    $data['category_menu'] =$category;
	     $data['item_menu_left'] =$item;
	      $data['item_menu_right'] =$item2;
	      $q1=$this->db->query("SELECT * FROM db_banners WHERE STATUS=1 ORDER BY id asc");
	    $list_image =$q1->result();
		$data['banner']=$list_image;
		$this->load->view('users/index',$data);
	}
	public function Category()
	{
		$this->load->view('users/category');
	}
		public function Blog()
	{
		$this->load->view('users/blog');
	}
	
		public function Cart()
	{
		$this->load->view('users/cart');
	}
	
		public function Checkout()
	{
		$this->load->view('users/checkout');
	}
		public function OrderPlacedPage()
	{
		$this->load->view('users/orderPlacedPage');
	}
	
	
	public function Confirmation()
	{
		$this->load->view('users/confirmation');
	}
	
	public function Contact()
	{
	     $category =self::category_menu();
	    $data['category_menu'] =$category;
		$this->load->view('users/contact',$data);
	}
// 	public function aboutus()
// 	{
// 	     $category =self::category_menu();
// 	    $data['category_menu'] =$category;
// 		$this->load->view('users/about-us',$data);
// 	}
	
		public function Elements()
	{
		$this->load->view('users/elements');
	}
	
		public function Singleproduct()
	{
		$this->load->view('users/single_product');
	}
		public function Singleblog()
	{
		$this->load->view('users/single_blog');
	}
		public function Userlogin()
	{
		$this->load->view('users/user_login');
	}
	
	public function Tracking()
	{
		$this->load->view('users/tracking');
	}
	
	public function ProductListpage()
	{ 
	    $category =self::category_menu();
	    $data['category_menu'] =$category;
		$this->load->view('users/productListPage',$data);
	}
		public function Aboutus()
	{
		$this->load->view('users/aboutUs');
	}
	public function ProceedToPay()
	{
		$this->load->view('users/proceedToPay');
	}
	
	public function home_product()
	{ 
	     $q1cat=$this->db->query("SELECT * FROM db_category WHERE STATUS=1 AND id!='32' ORDER BY id desc limit 0,3");
	    $list_category =$q1cat->result();
	    foreach ($list_category as $key => $field) {
	        $cat=$field->id;
	        $list_category[$key]->product_list =self::item_category($cat);
	    }
		$data['item']=$list_category;
		$this->load->view('users/ajax/product_grid',$data);
	}
	public function item_category($catId){
	    $item=$this->items->item_home($catId);
	    foreach ($item as $key => $field) {
	        $item[$key]->image =cygen_product_img($field->image_code);
	    }
	    return $item;
	  
	}
	
	public function home_banner()
	{   
	    $q1=$this->db->query("SELECT * FROM db_banners WHERE STATUS=1 ORDER BY id desc");
	    $list_image =$q1->result_array();
		$data['item']=$list_image;
		$this->load->view('users/ajax/slider',$data);
	} 
	public function category_menu()
	{   
	    $q1=$this->db->query("SELECT * FROM db_category WHERE STATUS=1 ORDER BY id desc");
	    $list_category =$q1->result_array();
	    return $list_category;
		
	} 
    public function home_category()
	{   
	    $q1=$this->db->query("SELECT * FROM db_category WHERE STATUS=1 ORDER BY id desc");
	    $list_category =$q1->result_array();
		$data['item_category']=$list_category;
		$this->load->view('users/ajax/category_home',$data);
	} 
	
public function save_cart(){
    
    if($this->session->userdata('CART_TEMP_RANDOM') == "") {
    $this->session->set_userdata('CART_TEMP_RANDOM',rand(10, 10).time());
    }
    if($this->session->userdata('user_login_session_id') == "") {
     $user_id = 0;
    } else {
    $user_id = $this->session->userdata('user_login_session_id');
    }
    $session_cart_id = $this->session->userdata('CART_TEMP_RANDOM');
    $category_id = $_POST['catId'];
    $sub_category_id = $_POST['subCatId'];
    $product_id = $_POST['productId'];
    $product_price = $_POST['productPrice'];
    $product_name = $_POST['product_name'];
    $product_weight_type = $_POST['productWeightType'];
    $opType = $_POST['optype'];
    $created_at = date('Y-m-d H:i:s', time());
    $city_id = 1;
    $device_id = 1;
   
    $selCnt = " * FROM grocery_cart WHERE product_id='$product_id' AND product_weight_type = '$product_weight_type' AND session_cart_id='$session_cart_id' ";
    $this->db->select($selCnt);
    $query = $this->db->get();
   
    $getQun=$query->result_array();
    if($query->num_rows() > 0){
        if($opType==0 || $opType==""){
            $product_quantity = $getQun[0]['product_quantity']+$_POST['product_quantity'];
            $saveItems = "UPDATE grocery_cart SET product_quantity='$product_quantity' WHERE product_id='$product_id' AND product_weight_type = '$product_weight_type' AND session_cart_id='$session_cart_id'"; 	
        }else{
        if($getQun[0]['product_quantity']>1){
            $saveItems = "UPDATE  `grocery_cart` set  product_quantity=product_quantity-1 WHERE user_id='$user_id' AND session_cart_id='$session_cart_id' AND product_id='$product_id' AND product_weight_type = '$product_weight_type'";
        }
        else{
            $saveItems = " DELETE FROM  `grocery_cart` WHERE user_id='$user_id' AND session_cart_id='$session_cart_id' AND product_id='$product_id' AND product_weight_type='$product_weight_type'"; 
        }    
        }
    } else {
         $product_quantity = $_POST['product_quantity'];
         $saveItems = "INSERT INTO `grocery_cart`(`user_id`, `session_cart_id`, `category_id`, `sub_category_id`, `product_id`, `product_name`, `product_price`, `product_weight_type`,`product_quantity`, `lkp_city_id`, `created_at`,`device_id`,`reward_points`) VALUES ('$user_id','$session_cart_id','$category_id','$sub_category_id','$product_id','$product_name','$product_price','$product_weight_type','$product_quantity','$city_id','$created_at','$device_id','0')"; 	
    }
        $saveCart =$this->db->query($saveItems);
    }

    public function header_cart_count(){
        if (isset($_POST['cart_id'])){
            if($this->session->userdata('CART_TEMP_RANDOM') == "") {
                $this->session->set_userdata('CART_TEMP_RANDOM',rand(10, 10).time());
            }
            if($this->session->userdata('user_login_session_id') == "") {
                $user_id = 0;
            } else {
                $user_id = $this->session->userdata('user_login_session_id');
            }
                $cartId = $_POST['cart_id'];
                $session_cart_id = $this->session->userdata('CART_TEMP_RANDOM');
            
            if($this->session->userdata('user_login_session_id')!='') {
                $user_session_id = $this->session->userdata('user_login_session_id');
                $cartItems1 = " * FROM grocery_cart WHERE (user_id = '$user_session_id' OR session_cart_id='$session_cart_id') AND product_quantity!='0'";
                $this->db->select($cartItems1);
                $cartItems = $this->db->get();
            
            } else {
                $cartItems1 = " * FROM grocery_cart WHERE  product_quantity!='0' AND session_cart_id='$session_cart_id' ";
                $this->db->select($cartItems1);
                $cartItems = $this->db->get();
            }
                $cartTotal = 0;
                echo  $cart_count = $cartItems->num_rows();
                // if($cart_count==0 || $cart_count==''){
                //     echo 1;
                // }else{
                //     echo $cart_count;
                // }
        
        }
    }

    public function cartitem(){
        $this->load->view('users/ajax/cartitem');
    }
    
    
    public function cart_page_inc(){
        if (isset($_POST['cart_id'])){

    $cartId = $_POST['cart_id'];
    $delivery_charges = $_POST['delivery_charges'];
    $wherearray=array('id'=>$cartId);
    // $catid=$this->items->getSingleColumnNameMultiple('product_quantity','grocery_cart',$wherearray);
    // $getCartQuantity = getIndividualDetails('grocery_cart','id',$cartId);
    $itemPrevQuan =$this->items->getSingleColumnNameMultiple('product_quantity','grocery_cart',$wherearray);
    
    $itemPrevQuantity = $itemPrevQuan+1;
    
    if($itemPrevQuantity == 0){
        $sql3 = "DELETE FROM grocery_cart WHERE id ='$cartId' ";
        $this->db->query($sql3);
    }
    if($itemPrevQuantity <= 20)  {
        $updateItems = "UPDATE grocery_cart SET product_quantity = '$itemPrevQuantity' WHERE id = '$cartId' ";
        $upCart = $this->db->query($updateItems);
        
        if($this->session->userdata('CART_TEMP_RANDOM') == "") {
         $this->session->set_userdata('CART_TEMP_RANDOM',rand(10, 10).time());
       }
        $session_cart_id = $this->session->userdata('CART_TEMP_RANDOM');
        if($this->session->userdata('user_login_session_id') !='') {
            $user_session_id = $this->session->userdata('user_login_session_id');
            $cartItems1 = "SELECT * FROM grocery_cart WHERE (user_id = '$user_session_id' OR session_cart_id='$session_cart_id') AND product_quantity!='0'";
            $cartItems = $this->db->query($cartItems1);
        } else {
          $cartItems1 = "SELECT * FROM grocery_cart WHERE  product_quantity!='0' AND session_cart_id='$session_cart_id' ";
          $cartItems = $this->db->query($cartItems1);
        }
        $cart_count = $cartItems->num_rows(); 
        echo $cart_count;
    } else {
        echo 0;
    }
} 
    }

public function cart_page_dec(){
    if (isset($_POST['cart_id'])){

$cartId = $_POST['cart_id'];
$delivery_charges = $_POST['delivery_charges'];

$wherearray=array('id'=>$cartId);
// $catid=$this->items->getSingleColumnNameMultiple('product_quantity','grocery_cart',$wherearray);
// $getCartQuantity = getIndividualDetails('grocery_cart','id',$cartId);
$itemPrevQuan =$this->items->getSingleColumnNameMultiple('product_quantity','grocery_cart',$wherearray);

$itemPrevQuantity = $itemPrevQuan-1;

if($itemPrevQuantity == 0){
    $sql3 = "DELETE FROM grocery_cart WHERE id ='$cartId' ";
    $this->db->query($sql3);
}
    
$updateItems = "UPDATE grocery_cart SET product_quantity = '$itemPrevQuantity' WHERE id = '$cartId' ";
$upCart = $this->db->query($updateItems);

 if($this->session->userdata('CART_TEMP_RANDOM') == "") {
    $this->session->set_userdata('CART_TEMP_RANDOM',rand(10, 10).time());
    }
    if($this->session->userdata('user_login_session_id') == "") {
     $user_id = 0;
    } else {
    $user_id = $this->session->userdata('user_login_session_id');
    }
$session_cart_id = $this->session->userdata('CART_TEMP_RANDOM');
if($this->session->userdata('user_login_session_id')!='') {
    $user_session_id = $this->session->userdata('user_login_session_id');
    $cartItems1 = "SELECT * FROM grocery_cart WHERE (user_id = '$user_session_id' OR session_cart_id='$session_cart_id') AND product_quantity!='0'";
    $cartItems = $this->db->query($cartItems1);
} else {
  $cartItems1 = "SELECT * FROM grocery_cart WHERE  product_quantity!='0' AND session_cart_id='$session_cart_id' ";
  $cartItems = $this->db->query($cartItems1);
}
$cart_count = $cartItems->num_rows(); 
echo $cart_count;
}
}


public function delete_cart_item(){
    if (isset($_POST['cartId'])){
    $states = array();
    $cartId = $_POST['cartId'];
    
    $sql322 = "select *  FROM grocery_cart WHERE id ='$cartId' ";
    $result_add = $this->db->query($sql322);
    $row=$result_add->row_array();
    $item_id=$row['product_id'];
    
    $delCart2 =$this->db->query("DELETE FROM db_cart_addon WHERE item_id='$item_id'");
    
    $sql3 = "DELETE FROM grocery_cart WHERE id ='$cartId' ";
    if($this->db->query($sql3) === TRUE) {
         if($this->session->userdata('CART_TEMP_RANDOM') == "") {
    $this->session->set_userdata('CART_TEMP_RANDOM',rand(10, 10).time());
    }
         $session_cart_id =$this->session->userdata('CART_TEMP_RANDOM');
        if($this->session->userdata('user_login_session_id')!='') {
            $user_session_id = $this->session->userdata('user_login_session_id');
            $cartItems1 = "SELECT * FROM grocery_cart WHERE (user_id = '$user_session_id' OR session_cart_id='$session_cart_id') AND product_quantity!='0'";
            $cartItems = $this->db->query($cartItems1);
        } else {
          $cartItems1 = "SELECT * FROM grocery_cart WHERE  product_quantity!='0' AND session_cart_id='$session_cart_id' ";
          $cartItems =$this->db->query($cartItems1);
        }
        $cart_count = $cartItems->num_rows(); 
        echo $cart_count;
    } else {
        echo 0;
    }
}
}

public function login_ajax(){
    if(isset($_POST['username']) && isset($_POST['userpassword']))  { 
	//Login here
	$user_email = $_POST['username'];
	$user_password = encryptPassword($_POST['userpassword']);
	$getLoginData = userLogin($user_email,$user_password);
	//Set variable for session
	if($getLoggedInDetails = $getLoginData->row_array()) {
		$last_login_visit = date("Y-m-d h:i:s");
	//	$login_count = $getLoggedInDetails['login_count']+1;
	//	$sql = "UPDATE `users` SET login_count='$login_count', last_login_visit='$last_login_visit' WHERE user_email = '$user_email' OR user_mobile = '$user_email' ";
	//	$row = $this->db->query($sql);
	
        $this->session->set_userdata('user_login_session_id',$getLoggedInDetails['id']); 
        $this->session->set_userdata('user_login_session_name',$getLoggedInDetails['customer_name']); 
        $this->session->set_userdata('user_login_session_email',$getLoggedInDetails['email']);
        $this->session->set_userdata('timestamp',time()); 
		//Save log data here
		$message = "User";

	    $user_id = $this->session->userdata('user_login_session_id');
        $session_cart_id = $this->session->userdata('CART_TEMP_RANDOM');
		$updateCart = "UPDATE `grocery_cart` SET user_id='".$user_id."' WHERE session_cart_id = '".$session_cart_id."'";
	
	
		$updateCart2 = "UPDATE `db_cart_addon` SET user_id='".$user_id."' WHERE session_cart_id = '".$session_cart_id."'";
		$updateCart1 = $this->db->query($updateCart);
			$updateCart1 = $this->db->query($updateCart2);
		echo 1;
	} else {
		echo 0;
	}
} else {
	echo 2;
}
}

public function mobile_otp_ajax(){
    if (isset($_POST['useremail']) && isset($_POST['usermobile1']) && isset($_POST['user_password1']))  {
//   $getSiteSettings1 = getAllDataWhere('grocery_site_settings','id','1'); 
//   $getSiteSettingsData1 = $getSiteSettings1->fetch_assoc();
    $user_mobile = $_POST['usermobile1'];
    $mobile_otp = rand(1000, 9999); //Your message to send, Add URL encoding here.
    $mobile_otp = "1234";
    $message = ('OTP from Cygen is '.$mobile_otp.' . Do not share it with any one.'); // Message text required to deliver on mobile number
   // $sendSMS = sendMobileSMS($message,$user_mobile);
    $sql_otp=$this->db->query("select * from user_mobile_otp where user_mobile='$user_mobile'");
    $getNoRows = $sql_otp->num_rows(); 

    if($getNoRows > 0) {
        $mobOtpSave = "UPDATE user_mobile_otp SET mobile_otp = '$mobile_otp' WHERE user_mobile = '$user_mobile' ";
        $saveOTP = $this->db->query($mobOtpSave);
    } else {
        $mobOtpSave = "INSERT INTO `user_mobile_otp`(`user_mobile`, `mobile_otp`) VALUES ('$user_mobile', '$mobile_otp') ";
        $saveOTP = $this->db->query($mobOtpSave);
    } 

    if($saveOTP === TRUE) {
        
        
    	$to =$_POST['useremail'];
		$subject = "Cygen- OTP";
		$message11 = '';		
		$message11 .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" > 
        <tr>
            <td style="padding:10px;" >
                <table  align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border: 1px solid #cccccc;background-color:#f52f2c;padding:10px;">
                    <tr bgcolor="#fff">
                        <td align="center"  style="color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <img width="150px" src="http://cygendev.com/dev/chicky/assets/images/logo.png" alt="Cygen"  style="display: block;" />
                        </td>
                    </tr>
                            <tr style="min-height:500px;" bgcolor="#ededed">
                            
                            <td colspan="3" style="color: #153643; font-family: Arial, sans-serif; font-size:16px;padding:10px;">
                            Dear Customer,<br/>
                            Use the OTP '.$mobile_otp.' to login.<br/>
                            The code can be used only once. Do not share it with any one
                            
                            </td>
                            </tr>
                             <tr style="background-color:#f52f2c;">
                                    <td colspan="3">
                                     <span style="margin-top:30px;display:block;padding:10px;"> 
                                        <b>  See you soon,<br/>
                                        Team Cygen</b> 
                                    </span>
                                     </td> 
                                </tr>
                                <tr>
                                    <td bgcolor="#764c28" style="padding: 30px 30px 30px 30px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="90%">
                                                    In case you need any assistance please do not hesitate to call our customer service on +63 12345678 07:00 am to 10:00 pm on all days or email us at admin@Cygen.com.au 
                                                    All calls to our customer support number will be recorded for internal training and quality purposes.
                                                </td>
                                                <td align="right" width="10%">
                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                                <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                                    <img src="http://cygenpos.com.au/dev/Cygen/assets/images/fb.png" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                                                                </a>
                                                            </td>
                                                            <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                                            <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                                <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                                    <img src="http://cygenpos.com.au/dev/Cygen/assets/images/tw.png" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

		//echo $message; die;
		$name = "Cygen";
		$from = 'admin@Cygen.com.au';
	 	$resultEmail = sendEmail($to,$subject,$message11,$from,$name);    
        
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 2;
}
}


public function user_avail_check(){
    if(isset($_POST['user_mobile'])) {
		$user_mobile=$_POST['user_mobile']; 
	  	$sql = "SELECT mobile FROM `db_customers` WHERE `mobile` = '$user_mobile' ";
        $result = $this->db->query($sql);
        if($result->num_rows()) {
            echo  $result->num_rows();
        } else {
            echo 0;
        }
    } 
    if(isset($_POST['user_email'])) {
        $user_email=$_POST['user_email']; 
	  	$sql1 = "SELECT email FROM `db_customers` WHERE `email` = '$user_email' ";
        $result1 = $this->db->query($sql1); 
        if($result1->num_rows()) {
            echo  $result1->num_rows();
        } else {
            echo 0;
        }
    }
}

public function check_otp(){
    if(!empty($_POST['user_mobile']) && !empty($_POST['mobile_otp']))  {
	//echo "<pre>"; print_r($_POST); die;
	$mobile_otp = $_POST['mobile_otp'];
		
	$user_full_name = $_POST['user_name'];
	$user_email = $_POST['user_email'];
	$user_mobile = $_POST['user_mobile'];
	$user_password = encryptPassword($_POST['user_password']);	
	$lkp_status_id = 0; //0-active, 1- inactive
	$login_count = 1;
	$last_login_visit = date("Y-m-d h:i:s");
	$lkp_register_device_type_id=1; //1- web, 2- android, 3-ios
	$user_login_type = 1; //1-Normal, 2-Facebook,3-twitter
	$user_register_service_id = 3;
	$referal_code = 0;
	$created_at = date("Y-m-d h:i:s");

	$sql="SELECT * FROM user_mobile_otp WHERE user_mobile='$user_mobile' AND mobile_otp='$mobile_otp' ";
	$getCn = $this->db->query($sql);
	$getnoRows = $getCn->num_rows();
	if($getnoRows > 0) {
		$saveUser = saveUser($user_full_name, $user_email, $user_mobile,$user_password);
		$getUserData = userLogin($user_email,$user_password);
		$getLoggedInDetails = $getUserData->row_array();
		 $this->session->set_userdata('user_login_session_id',$getLoggedInDetails['id']);
		 $this->session->set_userdata('user_login_session_name',$getLoggedInDetails['customer_name']);
		 $this->session->set_userdata('user_login_session_email',$getLoggedInDetails['email']);
		 $this->session->set_userdata('timestamp',time());
		

        //Save log data here
		$message = "User";
	//	saveAdminLogs('3',$_SESSION['user_login_session_id'],$message);//3- for grocery_cart
		$user_id = $this->session->userdata('user_login_session_id');
		$session_cart_id=$this->session->userdata('CART_TEMP_RANDOM');
        $updateCart = "UPDATE `grocery_cart` SET user_id='".$user_id."' WHERE session_cart_id = '".$session_cart_id."'";
		$updateCart1 = $this->db->query($updateCart);


        $updateCart2 = "UPDATE `db_cart_addon` SET user_id='".$user_id."' WHERE session_cart_id = '".$session_cart_id."'";

		$updateCart11 = $this->db->query($updateCart2);








        $dataem = $getLoggedInDetails["email"];

        $user_password = decryptPassword($getLoggedInDetails["user_password"]);
		$to = $dataem;
		$subject = "Welcome to Cygen";
		$message = '';		
		$message .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" > 
        <tr>
            <td style="padding:10px;" >
                <table  align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border: 1px solid #cccccc;background-color:#f52f2c;padding:10px;">
                    <tr bgcolor="#fff">
                        <td align="center"  style="color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <img width="120px" src="http://cygenpos.com.au/dev/Cygen/assets/images/menu/logo/4.jpg" alt="Cygen"  style="display: block;" />
                        </td>
                    </tr>
                   
						<tr style="min-height:500px;" bgcolor="#ededed"><td colspan="3">
											   <article style=" border-left: 1px solid gray;overflow: hidden;text-align:justify; word-spacing:0.1px;line-height:25px;padding:15px">
									  <h1 style="color:#66aa44">Welcome To Cygen</h1>
									  <p>A very special welcome to you <span style="color:#66aa44;">'.$getLoggedInDetails["customer_name"].'</span>, Thank you for joining Cygen.com.au!</p>
										<p>Your pasword is <span style="color:#66aa44;">'.$user_password.'</span></p>
										<p>Please keep it secret, keep it safe!</p>
										<p>We hope you enjoy your stay at Cygen.com.au, if you have any problems, questions, opinions, praise, comments, suggestions, please free to contact us at any time.</p>
										<p>Warm Regards,<br>The Cygen Team </p>
									</article> 
						</td>			
						<tr>			
                                <tr>
                                    <td bgcolor="#764c28" style="padding: 30px 30px 30px 30px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="90%">
                                                    In case you need any assistance please do not hesitate to call our customer service on +63 12345678 07:00 am to 10:00 pm on all days or email us at customerservice@Cygen.com.au 
                                                    All calls to our customer support number will be recorded for internal training and quality purposes.
                                                </td>
                                                <td align="right" width="10%">
                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                                <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                                    <img src="http://Cygen.com.au/images/fb.png" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                                                                </a>
                                                            </td>
                                                            <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                                            <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                                <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                                    <img src="http://Cygen.com.au/images/tw.png" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

		//echo $message; die;
		$name = "Cygen";
		$from = 'admin@Cygen.com.au';
	 	$resultEmail = sendEmail($to,$subject,$message,$from,$name);
		//Sending SMS after registration
		$message1 =('Registration completed successfully.A very special welcome to you '.$getLoggedInDetails["customer_name"].', Thank you for joining Cygen.com.au! Your pasword is '.$user_password.''); // Message text required to deliver on mobile number
        //$sendSMS = sendMobileSMS($message1,$user_mobile);

		echo $getnoRows;
	} else {
		echo $getnoRows;
	}
}
}

public function ordertype_ajax(){
    
   if($_POST['orderId'] !=""){
       if($this->session->userdata('select_order_type') == $_POST['orderId'] || $this->session->userdata('select_order_type')=='') {
   // $_SESSION['CART_TEMP_RANDOM']
    }
   else{
  if($this->session->userdata('CART_TEMP_RANDOM') == "") {

    $this->session->set_userdata('CART_TEMP_RANDOM',rand(10, 10).time());
  }
  
  if($this->session->userdata('user_login_session_id') == "") {
       $user_id = 0;
  } else {
          $user_id = $this->session->userdata('user_login_session_id');
  }
  $session_cart_id =$this->session->userdata('CART_TEMP_RANDOM');
  $deleteCart = "DELETE FROM grocery_cart WHERE user_id='$user_id' OR session_cart_id='$session_cart_id' ";
  $this->db->query($deleteCart);
  
 
  $delCart2 =$this->db->query("DELETE FROM db_cart_addon WHERE user_id = '$user_id' OR session_cart_id='$session_cart_id' ");
  
  
}
 $this->session->set_userdata('select_order_type',$_POST['orderId']);
}else{
 $this->session->set_userdata('select_order_type','');
} 
    
}

public function search(){
    if($_POST)
{

$q=$_POST['searchword'];
echo"<div class='productDv'>";
$result=$this->items->item_search($q);
$count=count($result);
if($count > 0){
    
foreach($result as $row)
{
$fname=$row['item_name'];
$re_fname='<b>'.$q.'</b>';
$re_lname='<b>'.$q.'</b>';
$pid=$row['id'];
$cartId=$this->session->userdata('CART_TEMP_RANDOM')!=""?$this->session->userdata('CART_TEMP_RANDOM'):"";
$cardProductId = $pid;
$dataCart=$this->db->query("SELECT * FROM grocery_cart WHERE product_id='$cardProductId'  AND session_cart_id='$cartId'");
if($dataCart->num_rows() > 0){
    $cardRow=$dataCart->row_array();
    $selectBoxDisplay="";
    $cardHide="cardHide";
    $product_quantity = $cardRow['product_quantity'];
}else{
    $selectBoxDisplay="hideSelect ";
    $cardHide="";
    $product_quantity=0;
}

$final_fname = str_ireplace($q, $re_fname, $fname);

$weightType=$row['unit_name'];

if($this->session->userdata('select_order_type')!=""){
    if($this->session->userdata('select_order_type')==1){
    $saleprice=$row['price3'];
    }else if($this->session->userdata('select_order_type')==2){
    $saleprice=$row['price4'];
    }else if($this->session->userdata('select_order_type')==3){
    $saleprice=$row['price2'];
    }else{
    $saleprice=$row['price3'];
    }
    }else{
    $saleprice=$row['price3'];
    }



$weightPrice=$saleprice;
$catId=$row['category_id'];
$category_name=$row['category_name'];


$subcatId=1;
$weighttypeId=$row['unit_name'];
$imgData =cygen_product_img($row['image_code']);
// if($_SESSION['select_order_type']==3){
// //$room_rows = getIndividualDetails('product_rooms','product_id',$pid);
// //$rooms="[".'Row-'.$room_rows['room_row'].',Asile-'.$room_rows['room_asile'].',Shelf-'.$room_rows['room_shelf']."]";

// }else{
// 	$rooms ="";
// } 
?>
<div class="display_box" align="left" >
    <div class="row m-0 row m-0 h-100 align-items-center">
        <div class="col-2 col-md-1 col-sm-2 p-0 small-none" >
            <div class="justify-content-center">
            <img src="<?php echo $imgData; ?>" class="img-fluid w-100 " />
            </div>
        </div>
        <div class="col-6 col-md-6 col-sm-6 mbp-0" >
            <a  class="searchAuto"> <span class="cat-item" style="display:block;"> <?php echo ucwords(strtolower(($category_name)));?></span> <span class="cat-cart" style="display:block;"> <?php echo substr(ucwords(strtolower($final_fname)),0,35)."..."; ?></span></a>
         
        </div>
<!--        <div class="col-3 col-md-1 col-sm-3 newCls" >
            <p class="pull-left searchAuto autoMiniType"><?php echo $weightType ?></p>
        </div>-->
        <div class="col-2 col-md-2 col-sm-2">
            <p class="offer-price mb-0 pull-left searchAuto newCls newCls2" >
            $<?php echo $weightPrice;?>
            </p>
        </div>
        <div class="col-4 col-md-3 col-sm-4 p-0 text-center">
            <div class="<?php echo $selectBoxDisplay; ?> buttonCart_<?php echo $pid; ?>">
                <div class="input-group">
                <span class="input-group-btn">
                    <a onClick="show_cart_option(<?php echo $pid; ?>,1)" class="btn btn-secondary btn-number btn-cartplus"  data-type="minus" data-field="quant[2]">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </a>
                </span>
                <input type="text" name="quant[2]"    class="input-number form-control qtyBox1 product_quantity_<?php echo $pid; ?>" value="<?php echo $product_quantity; ?>" min="0" style="height:32px;text-align:center;outline:none;margin-top:1px;margin-left: 0px;" readonly="readonly">
                <span class="input-group-btn">
                    <a onClick="show_cart_option(<?php echo $pid; ?>,0)"  class="btn btn-secondary btn-number btn-cartminus" data-type="plus" data-field="quant[2]">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                </span>
                </div>
            </div>
            <button type="button" class="button2 <?php echo $cardHide; ?> btn btn-secondary btn-sm float-right addCart buttonAdd_<?php echo $pid; ?>" onClick="show_cart(<?php echo $pid; ?>,0)"> Add  <i class="mdi mdi-cart-outline"></i></button>

        </div>
    </div>
    <?php
    if($rooms!="0" || $rooms!=""){
    ?>
    <div class="row"><div class="col-12 col-md-12 col-sm-12"><p style="color:red"><?php echo $rooms ?></p></div></div>
    <?php
    }
    ?>
</div>
<input type="hidden" class="cat_id_<?php echo $pid; ?>" value="<?php echo $catId; ?>">
<input type="hidden" class="sub_cat_id_<?php echo $pid; ?>" value="<?php echo $subcatId; ?>">
<input type="hidden" class="pro_name_<?php echo $pid; ?>" value="<?php echo $fname; ?>">
<input type="hidden" class="get_pr_price_<?php echo $pid; ?>" value="<?php echo $weighttypeId; ?>,<?php echo $weightPrice; ?>,<?php echo $pid; ?>">
<?php
}
}else{
    ?>
    <div class="row">
<div class="col-md-4 col-sm-12">
</div>
<div class="col-md-4">
<p class="pview text-center" style="color:red;font-size:14px;padding-top:8px">No Products Founds</p>
</div>
<div class="col-md-4 ">
</div>

</div>
    <?php
}
?>
</div>
<?php

}
else
{
// echo "no result";
}
}
	
	
	public function forgot_password(){
    if(isset($_POST['forgot_email']))  { 

   
    //Login here
    $forgot_email = $_POST['forgot_email'];
    
    $getUserForgotData = forgotPassword($forgot_email);
    //Set variable for session
    if($getUserForgotPassword = $getUserForgotData->row_array()) {

        $pwd = decryptPassword($getUserForgotPassword['user_password']);+
        $user_password = decryptPassword($getUserForgotPassword['user_password']);
        $userId = encryptPassword($getUserForgotPassword['id']);
        $to = $_POST['forgot_email'];
        $subject =  "Cygen  -  Forgot Password";
        $message = '';
        $message .= '<body>
			<div class="container" style=" width:50%;border: 5px solid #f52f2c;margin:0 auto">
			<header style="padding:0.8em;color: white;background-color: #f52f2c;clear: left;text-align: center;">
			 <center>Cygen </center>
			</header>
			<article style=" border-left: 1px solid gray;overflow: hidden;text-align:justify; word-spacing:0.1px;line-height:25px;padding:15px">
			  <h1 style="color:#f7a201">Password Recovery From Cygen</h1>
			  <p>Dear <span style="color:#f52f2c;">'.$getUserForgotPassword["customer_name"].'</span>.</p>
			 <p>Your User Name  : '.$to.'  </p>
			 <p>Your Password : '.$user_password.'  </p>
			<footer style="padding: 1em;color: white;background-color: #f52f2c;clear: left;text-align: center;">All rights reserved @ Cygen 2020.</footer>
			</div>

			</body>';
        
        //echo $message; die;
        $name = "Cygen ";
        $from = 'sudhakar@cygenit.com';
        $resultEmail = sendEmail($to,$subject,$message,$from,$name);
        echo 0;
    } else {
        echo 1;
    }
}
}
	
public function count_neworder_storepickup(){
    $sql =$this->db->query("select id from db_sales where order_view =1 and order_type=1 AND status=1 GROUP BY id");
    echo $num = $sql->num_rows();
}

public function count_neworder_conifrm_delivery(){
    $sql =$this->db->query("select id from db_sales where order_view =1 and order_type=2 AND status=1 GROUP BY id");
    echo $num = $sql->num_rows();
}
	
public function count_neworder_instore(){
    $sql =$this->db->query("select id,sales_code from db_sales where  order_view =1 AND status=1 GROUP BY id");
   $num= $sql->num_rows();
    if($num > 0){
        $rowid= $sql->row_array();
        echo $num.'~'.$rowid['sales_code'].'~'.$rowid['id'];
    }else{
         echo '0~0~0';
    }
}

	public function saveenquiryform(){
	    if (isset($_POST['submit'])){
	        	$name = $_POST['name'];
            	$email = $_POST['email'];
            	$mobile = $_POST['phone'];
            	$info = $_POST['additionalinfo'];
          $baseurl=base_url()."#cntformid";
         $sql = "INSERT INTO enquiry_form (`name`, `email`, `mobile`, `info`) VALUES ('$name','$email','$mobile','$info')";
        $addenquiery = $this->db->query($sql);
        if($addenquiery){
         $this->session->set_flashdata('error_pwd','<div class="alert alert-success succ_msg">Enquiery Sent Successfully.</div>');
			 redirect($baseurl);
        }else{
            $this->session->set_flashdata('error_pwd','<div class="alert alert-danger succ_msg">Enquiery Sent Failed</div>');
			 redirect($baseurl);
        }
	    }
	} 

}
