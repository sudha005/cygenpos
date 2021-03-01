<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_info();
	//	$this->load_global();
		$this->load->model('items_model','items');
		$this->load->model('category_model','category');
		$this->load->helper('url');
	}

	public function index()
	{
	  
   if($this->session->userdata('CART_TEMP_RANDOM') == "") {
       $baseurl=base_url();
       redirect($baseurl.'Store');
    }
    if($this->session->userdata('user_login_session_id') == "") {
        $baseurl=base_url();
        redirect($baseurl.'Store');
    } 
$user_session_id=$this->session->userdata('user_login_session_id');    
$cartItems1 = "SELECT * FROM grocery_cart WHERE user_id = '$user_session_id'";
$cartItems =$this->db->query($cartItems1);
$cart_count = $cartItems->num_rows(); 
if($cart_count <=0){
        $baseurl=base_url();
        redirect($baseurl.'Store');
}

	    $category =self::category_menu();
	    $data['category_menu'] =$category;
		$this->load->view('users/checkout',$data);
	}
	
	
	 public function logout()
	{
	  $this->session->sess_destroy();
	  $this->session->userdata('user_login_session_id','');
       $baseurl=base_url();
       redirect($baseurl);
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
	public function aboutus()
	{
	     $category =self::category_menu();
	    $data['category_menu'] =$category;
		$this->load->view('users/about-us',$data);
	}
	
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
	//	saveAdminLogs('3',$this->session->userdata('user_login_session_id'),$message);//3- for grocery_cart
		$user_id = $this->session->userdata('user_login_session_id');
		$session_cart_id=$this->session->userdata('CART_TEMP_RANDOM');
        $updateCart = "UPDATE `grocery_cart` SET user_id='".$user_id."' WHERE session_cart_id = '".$session_cart_id."'";
		$updateCart1 = $this->db->query($updateCart);

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
                <table  align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border: 1px solid #cccccc;background-color:#8ec400;padding:10px;">
                    <tr bgcolor="#fff">
                        <td align="center"  style="color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <img width="120px" src="http://cygendev.com/dev/chicky/assets/images/logo.png" alt="Cygen"  style="display: block;" />
                        </td>
                    </tr>
                   
						<tr style="min-height:500px;" bgcolor="#8ec400"><td colspan="3">
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
   // $this->session->userdata('CART_TEMP_RANDOM')
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
$weightPrice=$row['sales_price'];
$catId=$row['category_id'];
$category_name=$row['category_name'];


$subcatId=1;
$weighttypeId=$row['unit_name'];
$imgData =cygen_product_img($row['image_code']);
// if($this->session->userdata('select_order_type')==3){
// //$room_rows = getIndividualDetails('product_rooms','product_id',$pid);
// //$rooms="[".'Row-'.$room_rows['room_row'].',Asile-'.$room_rows['room_asile'].',Shelf-'.$room_rows['room_shelf']."]";

// }else{
// 	$rooms ="";
// } 
?>
<div class="display_box" align="left" >
    <div class="row m-0">
        <div class="col-2 col-md-1 col-sm-2 p-0" >
            <div class="justify-content-center">
            <img src="<?php echo $imgData; ?>" class="img-fluid w-100 " />
            </div>
        </div>
        <div class="col-10 col-md-5 col-sm-9" >
            <a href="single.php?pid=<?php echo $pid;?>" class="searchAuto"> <span style="display:block;"> <?php echo ucwords(strtolower(($category_name)));?></span> <span style="display:block;margin-top:-5px"> <?php echo substr(preg_replace('#[0-9 ]*#', '',$final_fname),0,35)."..."; ?></span></a>
        </div>
        <div class="col-3 col-md-1 col-sm-3 newCls" >
            <p class="pull-left searchAuto autoMiniType"><?php echo $weightType ?></p>
        </div>
        <div class="col-6 col-md-2 col-sm-2">
            <p class="offer-price mb-0 pull-left searchAuto newCls newCls2" >
            $<?php echo $weightPrice;?>
            </p>
        </div>
        <div class="col-12 col-md-3 col-sm-12">
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

public function save_checkout(){
    
    if(!empty($_POST['mobile'])) {
        
	$first_name = $_POST['first_name'];
	$email = $_POST['email'];
    $mobile = $_POST['mobile']; 
	$flatno = $_POST['flatno'];
	$location = $_POST['location'];
	$saveas = $_POST['saveas'];
	$landmark = $_POST['landmark'];
	$user_id = $this->session->userdata('user_login_session_id');
	date_default_timezone_set('Australia/Sydney');
	$order_date = date("Y-m-d h:i:s");
	if($this->session->userdata('select_order_type')!="2"){
		$addAddress = "INSERT INTO grocery_add_address (`user_id`,`first_name`,`email`,`phone`,`area`,`landmark`,`flatno`,`location`,`saveas`,`created_at`) VALUES ('$user_id','$first_name','$email','$mobile','0','$landmark','$flatno','$location','$saveas','$order_date')";
	   $this->db->query($addAddress);
	 }

} else {
	$address_id = $_POST['address_id'];
	$getAllCustomerAddress = "SELECT id,first_name,email,phone,flatno,location,saveas,landmark FROM grocery_add_address WHERE id = '$address_id'";
	$getCustomerAddress = $this->db->query($getAllCustomerAddress);
	$getCustomerDeatils = $getCustomerAddress->row_array();
	$first_name = $getCustomerDeatils['first_name'];
	$email = $getCustomerDeatils['email'];
	$mobile = $getCustomerDeatils['phone'];
	$flatno = $getCustomerDeatils['flatno'];
	$location = $getCustomerDeatils['location'];
	$saveas = $getCustomerDeatils['saveas'];
	$landmark = $getCustomerDeatils['landmark'];
}

if($this->session->userdata('user_login_session_id')!="" && $mobile!="") {
	
	//Save Order function here
	$coupon_code = $_POST["coupon_code"]!=''?$_POST["coupon_code"]:'0';
	$coupon_code_type = $_POST["coupon_code_type"]!=''?$_POST["coupon_code_type"]:'0';
	$discount_money = $_POST["discount_money"]!=''?$_POST["discount_money"]:'0';
	$coupon_id = $_POST["coupon_id"]!=''?$_POST["coupon_id"]:'0';
	$coupon_device_type = $_POST["coupon_device_type"]!=''?$_POST["coupon_device_type"]:'0';
	//echo "<pre>"; print_r($_POST); die;
	$payment_group = $_POST["pay_mn"]!=''?$_POST["pay_mn"]:'0';
	$order_date = date("Y-m-d h:i:s");
	$string1 = str_shuffle('1234567890');
	$random1 = substr($string1,0,3);
	$string2 = str_shuffle('1234567890');
	$random2 = substr($string2,0,3);
	$contstr = "SPICY";
	$reference_no=new_random_number(); 
    $qs5="select sales_init from db_company";
	$q5=$this->db->query($qs5);
	$sales_init=$q5->row()->sales_init;
    $sales_date=date('Y-m-d');  
	$this->db->query("ALTER TABLE db_sales AUTO_INCREMENT = 1");
	$q4=$this->db->query("select coalesce(max(id),0)+1 as maxid from db_sales");
	$maxid=$q4->row()->maxid;
	$order_id = $sales_init.str_pad($maxid, 4, '0', STR_PAD_LEFT);
	$sales_code=$order_id;
	$service_tax = $_POST["service_tax"]!=''?$_POST["service_tax"]:'0';
	$itemCount = count($_POST["product_id"]);
//	$reward_points = $_POST["reward_points"]!=''?$_POST["reward_points"]:'0';
//	$product_reward_points = $_POST["product_reward_points"]!=''?$_POST["product_reward_points"]:'0';
	//Saving user id and coupon id
	$user_id = $this->session->userdata('user_login_session_id');
	$payment_status = 2; //In progress
	$country = 99;		
	$this->session->set_userdata('order_last_session_id',$order_id);
	$_SESSION['payment_service_type'] = 3; //Groceries
	$delivery_charges = $_POST["delivery_charges"]!=''?$_POST["delivery_charges"]:'0';
	$expdelivery_charge=$_POST["expdelivery_charge"]!=''?$_POST["expdelivery_charge"]:'0';
	$delivery_type=$_POST["delivery_type"]!=''?$_POST["delivery_type"]:'0';

	if($_POST["delivery_type"]==2){
	    $delivery_time = date("Y-m-d");
	    $delivery_date = date("Y-m-d h:i:s", time());
	}else{
	    $delivery_time = date("Y-m-d", strtotime("+1 day"));
	    $delivery_date =date("Y-m-d", strtotime("+1 day"));
	    $expdelivery_charge=0;
	}
	
	
	$lkp_sub_area_id = $_POST['lkp_sub_area_id']!=''?$_POST["lkp_sub_area_id"]:'0';
	$order_total = $_POST['order_total']!=''?$_POST["order_total"]:'0';
    $session_cart_id = $this->session->userdata('CART_TEMP_RANDOM');
  	
	if($this->session->userdata('select_order_type')!=""){
	    $order_type=$this->session->userdata('select_order_type');
	}else{
	    $order_type=1;
	}    
   
	
	
	
	      $offerid=getSingleColumnName($user_id,'id','offer_id','db_customers');  
	        if($offerid !='' && $offerid !='0'){
	            $offer_percentage=getSingleColumnName($offerid,'id','offer_percentage','db_offers');
	            if($offer_percentage > 0){
	            $offer_amount=($order_total)*$offer_percentage/100;
	            $discount_to_all_input=$offer_percentage;
	            $discount_to_all_type='in_percentage';
	            $order_total=$order_total-$offer_amount;
	            $tot_discount_to_all_amt=$offer_amount;
	            }else{
	            $offer_amount=0;
	            $discount_to_all_input=0;
	            $discount_to_all_type=0;
	            $order_total=$order_total;
	            $tot_discount_to_all_amt=0;
	            }
	        }else{
	            $offer_amount=0;
	            $discount_to_all_input=0;
	            $discount_to_all_type=0;
	            $order_total=$order_total;
	            $tot_discount_to_all_amt=0;
	        }
	        
            $sales_status='Final';
            $customer_id=$user_id;
            $other_charges_input=0;
            $other_charges_tax_id=0;
            $other_charges_amt=0;
		    $sales_entry = array(
		    				'sales_code' 				=> $sales_code, 
		    				'reference_no' 				=> $reference_no, 
		    				'sales_date' 				=> $sales_date,
		    				'sales_status' 				=> $sales_status,
		    				'customer_id' 				=> $customer_id,
		    				/*'warehouse_id' 				=> $warehouse_id,*/
		    				/*Other Charges*/
		    				'other_charges_input' 		=> 0,
		    				'other_charges_tax_id' 		=> 0,
		    				'other_charges_amt' 		=> 0,
		    				/*Discount*/
		    				'discount_to_all_input' 	=> $discount_to_all_input,
		    				'discount_to_all_type' 		=> $discount_to_all_type,
		    				'tot_discount_to_all_amt' 	=> $tot_discount_to_all_amt,
		    				/*Subtotal & Total */
		    				'subtotal' 					=> $_POST["sub_total"],
		    				'round_off' 				=> 0,
		    		    	'grand_total' 				=> $order_total,
		    				'sales_note' 				=> 0,
		    				/*System Info*/
		    				'created_date' 				=> date('Y-m-d'),
		    				'created_time' 				=> date('H:i:s a'),
		    				'created_by' 				=> $customer_id,
		    				'system_ip' 				=>$_SERVER['SERVER_ADDR'],
		    				'system_name' 				=> gethostname(),
		    				'payment_status'            =>"Unpaid",
		    				'delivery_type'             => $delivery_date,
		    				'delivery_slot_date'        =>1,
		    				'order_type'                =>$order_type,
		    				'order_status'              =>1,
		    				'order_view'                =>1,
		    				'status'                    =>0,
		    				'order_device'              =>1
		    			);

			$q1 = $this->db->insert('db_sales', $sales_entry);
			$sales_id = $this->db->insert_id();	
    if($this->session->userdata('select_order_type')=="2"){
		$delAddr = "INSERT INTO grocery_del_addr(`user_id`,`first_name`, `last_name`, `email`, `mobile`, `address`,`landmark`,`flatno`,`location`,`saveas`, `lkp_state_id`, `lkp_district_id`, `lkp_city_id`, `lkp_pincode_id`, `lkp_location_id`, `lkp_sub_location_id`, `order_id`) VALUES ('$user_id','$first_name','0', '$email','$mobile','$address','$landmark','$flatno','$location','$saveas','0','0','0','0','0','0','$order_id')"; 
	}else{
	     if($this->session->userdata('select_order_type')=="3"){
	        $tblnum=$this->session->userdata('select_order_table');
	        $pickup_datetime=date("Y-m-d H:i:s"); 
	    }else{
	         $tblnum=0;
	         $pickup_datetime=date("Y-m-d H:i:s", strtotime($_POST['pickup_datetime'])); 
	    }
	    
		$delAddr = "INSERT INTO grocery_pickup_detail(`user_id`,`name`,`phone`,`created_at`,`order_id`,`email`,`pickup_datetime`,`table_number`) VALUES ('$user_id','$first_name','$mobile','$order_date','$order_id','$email','$pickup_datetime','$tblnum')";
	}
	
	$delAddrData = $this->db->query($delAddr);
	$q45=$this->db->query("select coalesce(max(kot_number),0)+1 as maxkot from db_salesitems");
    $kot_number=$q45->row()->maxkot;
	for($i=0;$i<$itemCount;$i++) {
	    
	    
		//Generate sub randon id
		$string1 = str_shuffle('abcdefghijklmnopqrstuvwxyz');
		$random1 = substr($string1,0,3);
		$string2 = str_shuffle('1234567890');
		$random2 = substr($string2,0,3);
		$date = date("ymdhis");
		$contstr = "SPICYGR-GR";
		$sub_order_id = $contstr.$random1.$random2.$date;
		$proId = $_POST["product_id"][$i];
// 		$masterCatId = getSingleColumnValue('grocery_products','masterCatId','id',$proId);
// 		$vendorId = getSingleColumnValue('grocery_products','storeId','id',$proId);
// 		$orderDetails = "INSERT INTO grocery_order_details (`user_id`,`vendorId`,`masterCatId`,`category_id`, `sub_cat_id`, `product_id`, `item_weight_type_id`, `item_price`, `item_quantity`,`order_id`,`order_sub_id`) VALUES ('$user_id','$vendorId','" . $masterCatId . "','" . $_POST["category_id"][$i] . "','" . $_POST["sub_cat_id"][$i] . "','" . $_POST["product_id"][$i] . "','".$_POST['product_weight'][$i]."','" . $_POST["product_price"][$i] . "','" . $_POST["product_quantity"][$i] . "','$order_id','$sub_order_id')";
// 		$groceryOrderDetails = $this->db->query($orderDetails);
        $total_cost_data=$_POST["product_price"][$i]*$_POST["product_quantity"][$i];
        
		
		

				$item_id 			=$_POST["product_id"][$i];
				$sales_qty			=$_POST["product_quantity"][$i];
				$price_per_unit 	=$_POST["product_price"][$i];
				$tax_id 			='3';
				$tax_amt 			=0;
				$unit_total_cost	=$total_cost_data;
				$unit_discount_per	=0;
				$total_cost			=$total_cost_data;
				$tax_type			='Inclusive';
				$unit_tax			=0;
				$description		='0';
                $unit_discount_per  =0;
				$discount_amt 		=0;
				
			
				if($tax_type=='Exclusive'){
					$single_unit_total_cost = $price_per_unit + ($unit_tax * $price_per_unit / 100);
					$single_unit_discount = ($single_unit_total_cost * $unit_discount_per)/100;
					$single_unit_total_cost -=$single_unit_discount;
				}
				else{//Inclusive
					$single_unit_discount = ($price_per_unit * $unit_discount_per)/100;
					$single_unit_total_cost =$price_per_unit-$single_unit_discount;
				}
				

				if($tax_id=='' || $tax_id==0){$tax_id=null;}
				if($tax_amt=='' || $tax_amt==0){$tax_amt=null;}
				if($unit_discount_per=='' || $unit_discount_per==0){$unit_discount_per=null;}
				//if($unit_total_cost=='' || $unit_total_cost==0){$unit_total_cost=null;}
				if($total_cost=='' || $total_cost==0){$total_cost=null;}
				
				if(!empty($discount_to_all_input) && $discount_to_all_input!=0){
					$unit_discount_per =null;
					$discount_amt =null;
				}
				
				$salesitems_entry = array(
		    				'sales_id' 			=> $sales_id, 
		    				'sales_status'		=> $sales_status, 
		    				'item_id' 			=> $item_id, 
		    				'description' 		=> $description, 
		    				'sales_qty' 		=> $sales_qty,
		    				'price_per_unit' 	=> $price_per_unit,
		    				'tax_type' 			=> $tax_type,
		    				'tax_id' 			=> $tax_id,
		    				'tax_amt' 			=> $tax_amt,
		    				'unit_discount_per' => $unit_discount_per,
		    				'discount_amt' 		=> $discount_amt,
		    				'unit_total_cost' 	=> $single_unit_total_cost,
		    				'total_cost' 		=> $total_cost,
		    				'status'	 		=> 1,
		    				'kot_number'        => $kot_number

		    			);

				$q2 = $this->db->insert('db_salesitems', $salesitems_entry);
				     $user_id=$this->session->userdata('user_login_session_id');
					 $sql_addon_query=$this->db->query("select * from db_cart_addon where item_id='$item_id' AND user_id='$user_id'");
				if($sql_addon_query->num_rows() > 0){
				 $sql_addon=$sql_addon_query->result_array();
                    foreach($sql_addon as $addon_row){
                        $adon_id=$addon_row['addon_id']!=''?$addon_row['addon_id']:0;
                        $price=$addon_row['price']!=''?$addon_row['price']:0;
                        $qty=$addon_row['qty']!=''?$addon_row['qty']:0;
                        $total_price=$addon_row['total_price']!=''?$addon_row['total_price']:0;
                        $note=$addon_row['note']==''?'0':$addon_row['note'];
                        $addon_name=$addon_row['addon_name'];
                        $salesaddon_items_entry = array(
		    				'sales_id'=> $sales_id, 
		    				'item_id'=> $item_id, 
		    				'addon_id'=> $adon_id, 
		    				'price'=> $price,
		    				'qty'=> $qty,
		    				'total_price'=> $total_price,
		    				'note'=> $note,
		    				'customer_id'=>$user_id,
		    				'note'       =>$note
		    			);

				$q20= $this->db->insert('db_sales_addon_detail', $salesaddon_items_entry);
                  //  echo $this->db->last_query(); die;
                    }
				}
				
				
				//UPDATE itemS QUANTITY IN itemS TABLE
			//	$this->load->model('pos_model');				
		//		$q6=$this->pos_model->update_items_quantity($item_id);
			//	if(!$q6){
			//		return "failed";
			//	}
				
			
		
	
        
       





	}
	
	if($order_total==0 || $order_total < 0){
	    	 $this->ordersuccess();
		     //$baseurl=base_url();
	}
	
	if($payment_group == 1) {
		//cod 
		$baseurl=base_url();
        redirect($baseurl.'squareup');			
	} elseif($payment_group == 3) {
		$baseurl=base_url();
        //redirect($baseurl.'squareup');
        $this->ordersuccess();
	} elseif($payment_group == 4) {
		//online paytm money
		//header("Location: stripe/index.php?pay_key=".encryptPassword($order_total)."");
		//Stripe
		$this->ordersuccess();
		$baseurl=base_url();
        //redirect($baseurl.'squareup');
	} else {
	//	header("Location: ordersuccess.php?odi=".$order_id."&pay_stau=1");
			$baseurl=base_url();
       // redirect($baseurl.'squareup');
       $this->ordersuccess();
	}			
} else {
	header("Location: failure.php");
}


}

public function ordersuccess(){
	if($this->session->userdata('order_last_session_id')!="") {
	$payment_status = $_GET['pay_stau']; //success
	$order_id = $this->session->userdata('order_last_session_id');
	$user_id = $this->session->userdata('user_login_session_id');
	//Saving data into reward transactions
	$order_date = date('Y-m-d H:i:s');
	//after placing order that item will delete in cart

            $session_cart_id = $this->session->userdata('CART_TEMP_RANDOM');
         	$delCart ="DELETE FROM grocery_cart WHERE user_id = '$user_id' OR session_cart_id='$session_cart_id' ";
        	$this->db->query($delCart);
        	
        	$delCart22 ="DELETE FROM db_sales_addon_detail WHERE customer_id = '$user_id' OR session_cart_id='$session_cart_id' ";
        	$this->db->query($delCart22);



	$getWalletAmount = getIndividualDetails('db_sales','sales_code',$this->session->userdata('order_last_session_id'));
	$getUserDetails = getIndividualDetails('db_customers','id',$user_id);
	$getOrderAddress = getIndividualDetails('grocery_del_addr','order_id',$this->session->userdata('order_last_session_id'));
	$delivery_type =$getWalletAmount['delivery_type'];
	$deliveryDate= date("d-F-Y", strtotime($getWalletAmount['delivery_slot_date']));
    $saleid = $getWalletAmount['id'];
    $sales_id= $getWalletAmount['id'];
        	$CUR_DATE=date('Y-d-m');
        		     $salespayments_entry = array(
					'sales_id' 		=> $sales_id, 
					'payment_date'		=> $CUR_DATE,//Current Payment with sales entry
					'payment_type' 		=> 'store',
					'payment' 			=> 0,
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
							paid_amount=0,
							status=1
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
	$from_email="info@Cygen.com.au";
   // $from_email="sudhakar@cygenit.com";
	$subject = "Your Cygen  new order  ( '.$order_id.' )";
	$this->email->from($from_email,"Your Cygen new order  (".$order_id.")"); 
	$this->email->to($customer_email);
	$this->email->subject($subject); 
	$body = $this->load->view('users/emailtemplate/order_email',$data,TRUE);
	$this->email->message($body); 
	$this->email->send();
          $baseurl=base_url();
          redirect($baseurl.'thankyou');
  // $this->thankyou();


	//echo $message; die;
	//$sendMail = sendEmail($to,$subject,$message,$from);
	//$name = "Your Cygen order confirmation ( '.$order_id.' )";
	//$mail = sendEmail1($to,$subject,$message,$from,$name);
	//Sending SMS after placing Order to customer
//	$user_mobile = $getUserDetails['user_mobile'];
	//$message1 = 'Thankyou for placing order. Your order number is '.$order_id; // Message text required to deliver on mobile number
	//$sendSMS = sendMobileSMS($message1,$user_mobile);

	//Sending SMS after placing Order to My Servant
	//	$user_mobile1 = $getSiteSettings1['mobile'];
	//	$message2 = 'Order Placed by '.$getUserDetails['user_full_name'].'  mobile number '.$getUserDetails['user_mobile'].' and the order id is <a href="http://Cygen.com.au/grocery_admin">'.$order_id.'</a>.'; // Message text required to deliver on mobile number
	//  $sendSMS = sendMobileSMS($message2,$user_mobile1);
	   //Sending SMS after placing Order to My Servant
	  
	 //  $user_mobile2 = '61458116301';
	  //  $message3 = 'Order Placed by '.$getUserDetails['user_full_name'].'  mobile number '.$getUserDetails['user_mobile'].' and the order ID is <a href="http://Cygen.com.au/grocery_admin">'.$order_id.'</a>.'; // Message text required to deliver on mobile number
	   // $sendSMS = sendMobileSMS($message3,$user_mobile2);
		/*
		//Sending SMS after placing Order to My Servant
		$user_mobile3 = '9866000887';
		$message4 = 'Order Placed by '.$getUserDetails['user_full_name'].'  mobile number '.$getUserDetails['user_mobile'].' and the order id is '.$order_id.'.'; // Message text required to deliver on mobile number
		$sendSMS = sendMobileSMS($message4,$user_mobile3);

	   */
	//header("Location: thankyou.php?odi=".$order_id."");
	}
}


public function thankyou(){
        $user_id = $this->session->userdata('user_login_session_id');
    	$session_cart_id = $this->session->userdata('CART_TEMP_RANDOM');
        $delCart =$this->db->query("DELETE FROM grocery_cart WHERE user_id = '$user_id' OR session_cart_id='$session_cart_id' ");
        $delCart2 =$this->db->query("DELETE FROM db_cart_addon WHERE user_id = '$user_id' OR session_cart_id='$session_cart_id' ");
    $this->load->view('users/thankyou');
}

public function thankyouapp(){
    
    	$order_id = $this->input->get('order_id');
    	$data['order_id']   = $order_id;
    $this->load->view('users/thankyou_app',$data);
}







}
