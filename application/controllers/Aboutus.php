<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aboutus extends MY_Controller {
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
	    $data['category_menu'] =$category;
		$this->load->view('users/index',$data);
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
            $product_quantity = $getQun['product_quantity']+$_POST['product_quantity'];
            $saveItems = "UPDATE grocery_cart SET product_quantity='$product_quantity' WHERE product_id='$product_id' AND product_weight_type = '$product_weight_type' AND session_cart_id='$session_cart_id'"; 	
        }else{
        if($getQun['product_quantity']>1){
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

}
