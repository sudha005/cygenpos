<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onlineorder extends MY_Controller {
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
		$this->load->view('users/onlineorder',$data);
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
		$this->load->view('users/contact');
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
	     $q1cat=$this->db->query("SELECT * FROM db_category WHERE  id!='32' AND status=1 ORDER BY id desc limit 0,3");
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
    public function item_list(){
        $item=$this->items->item_list();
        foreach ($item as $key => $field) {
            $item[$key]->image =cygen_product_img($field->image_code);
        }
        $data['item']=$item;
	    $this->load->view('users/ajax/product_grid',$data);
    
    }
    public function item_modal(){
        $data=array();
        //item_modal
        $product_id = $_POST['product_id'];
        $item=$this->items->item_detail($product_id);
        foreach ($item as $key => $field) {
            $item[$key]->image =cygen_product_img($field->image_code);
        }
        $data['item']=$item;
        $this->load->view('users/ajax/product_modal',$data);
       
    }
	public function home_banner()
	{   
	    $q1=$this->db->query("SELECT * FROM db_banners WHERE status=1 ORDER BY id desc");
	    $list_image =$q1->result_array();
		$data['item']=$list_image;
		$this->load->view('users/ajax/slider',$data);
	} 
	public function category_menu()
	{   
	    $q1=$this->db->query("SELECT * FROM db_category WHERE status=1 ORDER BY id desc");
	    $list_category =$q1->result_array();
	    return $list_category;
		
	} 
    public function home_category()
	{   
	    $q1=$this->db->query("SELECT * FROM db_category WHERE status=1 ORDER BY id desc");
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
