<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exploremenu extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_info();
	//	$this->load_global();
		$this->load->model('items_model','items');
		$this->load->model('category_model','category');
		
	}

	public function index()
	{
	   
	    $data['item_menu_left'] =self::home_product_left();
	    $data['item_menu_right'] =self::home_product_right();
		$this->load->view('users/ourmenu',$data);
	}

	
	public function home_product_left()
	{ 
	     $q1cat=$this->db->query("SELECT * FROM db_category WHERE STATUS=1  ORDER BY id limit 0,6");
	    $list_category =$q1cat->result();
	    foreach ($list_category as $key => $field) {
	        $cat=$field->id;
	        $list_category[$key]->product_list =self::item_category($cat);
	    }
		return $list_category;
		
	}
		public function home_product_right()
	{ 
	     $q1cat=$this->db->query("SELECT * FROM db_category WHERE STATUS=1  ORDER BY id  limit 6,16");
	    $list_category =$q1cat->result();
	    foreach ($list_category as $key => $field) {
	        $cat=$field->id;
	        $list_category[$key]->product_list =self::item_category($cat);
	    }
		return $list_category;
		
	}
	public function item_category($catId){
	    $item=$this->items->item_home($catId);
	    return $item;
	  
	}
	

	
	
	
	


}
