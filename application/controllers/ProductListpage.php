<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductListpage extends MY_Controller {
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
		$this->load->view('users/productListPage',$data);
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
	    $item=$this->items->item_home_withprice($catId);
	    foreach ($item as $key => $field) {
	        $item[$key]->image =cygen_product_img($field->image_code);
	    }
	    return $item;
	  
	}
   public function item_list(){
        $catid=$_POST['catid'];
        $item=$this->items->item_home_withprice($catid);
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
    public function product_modifier(){
        $mod_id=$_POST['productId'];
       // $mod_id=3;
        $mod_result_group =$this->db->query(" select  * FROM db_item_group WHERE  item_id='$mod_id' AND status='1' ");
        $numrows_group=$mod_result_group->num_rows();
        if($numrows_group > 0){
        $item_modifier=$mod_result_group->result_array();
         foreach ($item_modifier as $key => $field) {
	        $modifiergroup_id=$field['id'];
	        $modifiergroup_nameid=$field['modifiergroup_id'];
	         $groupName=getSingleColumnName($modifiergroup_nameid,'id','modifiergroup_name','db_modifier_group');
	          $item_modifier[$key]['modifier_name'] =$groupName;
	        $item_modifier[$key]['modifier'] =self::group_modifier($mod_id,$modifiergroup_id);
	       
	    }
            $product_name=getSingleColumnName($mod_id,'id','item_name','db_items');
             
            if($this->session->userdata('select_order_type')!=""){
                if($this->session->userdata('select_order_type')==1){
                $saleprice=getSingleColumnName($mod_id,'id','price3','db_items');
                }else if($this->session->userdata('select_order_type')==2){
                $saleprice=getSingleColumnName($mod_id,'id','price4','db_items');
                }else if($this->session->userdata('select_order_type')==3){
                $saleprice=getSingleColumnName($mod_id,'id','price2','db_items');
                }else{
                $saleprice=getSingleColumnName($mod_id,'id','price3','db_items');
                }
                }else{
                $saleprice=getSingleColumnName($mod_id,'id','price3','db_items');
                }

            $product_price=$saleprice;
		   $data['item_modifier']=$item_modifier;
		   $data['item_name']=$product_name;
		   $data['item_price']=$product_price;
		   $data['item_products_all']=$mod_id;
	      $this->load->view('users/ajax/modifier',$data);
        }else{
            echo 1;
        }
        
      
    }
    public function group_modifier($id,$groupid){
         $mod_result =$this->db->query(" select  * FROM db_items_modifier WHERE  item_id='$id' AND item_group_id='$groupid' AND status='1' ");
        $numrows=$mod_result->num_rows();
        if($numrows > 0){
            $list_modifier =$mod_result->result_array();
		    return $list_modifier;
        }
    }
    public function addonsave_cart(){
    if($this->session->userdata('CART_TEMP_RANDOM') == "") {
    $this->session->set_userdata('CART_TEMP_RANDOM',rand(10, 10).time());
    }
    if($this->session->userdata('user_login_session_id') == "") {
     $user_id = 0;
    } else {
    $user_id = $this->session->userdata('user_login_session_id');
    }
    $session_cart_id = $this->session->userdata('CART_TEMP_RANDOM');
   
    $product_id   = $_POST['productId'];
    $addon_price  = $_POST['addon_price'];
    $addon_name   = $_POST['addon_name'];
    $addon_id     = $_POST['addon_id'];
    $qty          = $_POST['qty'];
     $note         = $_POST['note'];
    $selCnt = " * FROM db_cart_addon WHERE item_id='$product_id' AND addon_id = '$addon_id' AND session_cart_id='$session_cart_id' ";
    $this->db->select($selCnt);
    $query = $this->db->get();
   
   $getQun=$query->row_array();
    if($query->num_rows() > 0){
       
        $product_quantity = $getQun['qty']+$qty;
        $total_price=$getQun['total_price']+$addon_price; 
        $saveItems ="UPDATE db_cart_addon SET qty='$product_quantity',total_price='$total_price' WHERE item_id='$product_id' AND addon_id = '$addon_id' AND session_cart_id='$session_cart_id'"; 	
    } else {
          $total_price=$_POST['qty']*$addon_price;
          $product_quantity = $_POST['qty'];
          $saveItems = "INSERT INTO `db_cart_addon`(`user_id`, `session_cart_id`,`item_id`,`addon_name`,`price`,`addon_id`,`qty`,`total_price`,`note`) VALUES ('$user_id','$session_cart_id','$product_id','$addon_name','$addon_price','$addon_id','$qty','$total_price','$note')"; 	
        }
        $saveCart =$this->db->query($saveItems);
    }    

}
