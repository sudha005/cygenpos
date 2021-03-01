<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_info();
	}
	public function index()
	{
	        $CI =& get_instance();
            $logout_time = date('Y-m-d H:i:s');
            $login_time = date('Y-m-d H:i:s');
            $data_da=array(
                'start_time'=>$login_time,
                'end_time'=>$logout_time,
                'is_login'=>0
            ); 
            $user_id = $CI->session->userdata('inv_userid');           
            $CI->db->where('id',$user_id);
            $CI->db->update('db_users', $data_da);
            
            
        $data_ses=array(
        'login_outtime'=>date('Y-m-d h:i:s')
        );            
        $CI->db->where('user_id',$user_id);
        $CI->db->update('db_user_loginsess', $data_ses);         
		$data = $this->data;
		$array_items = array('inv_username','inv_userid','logged_in','permissions','currency');
		$this->session->unset_userdata('cashin_added');
		$this->session->unset_userdata($array_items);
		
		 
		
		
		
		redirect(base_url('login'));
	}
}
