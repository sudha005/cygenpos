<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userdashboard extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_info();
		
		$this->load->helper('custom');
	}

// 	public function index()
// 	{
// 	      if($this->session->userdata('user_login_session_id')!= "") {
//              $user_id = $this->session->userdata('user_login_session_id');
//             } else {
//             $baseurl=base_url();
//       redirect($baseurl);
//             }
// 	    $category =self::category_menu();
// 	    $data['category_menu'] =$category;
// 	     $getusers=$this->db->query("SELECT * FROM db_customers WHERE STATUS=1 AND id ='$user_id'");
// 	    $list_users =$getusers->result();
// 	    $data['userdetails'] =$list_users;
// 	    $getaddress=$this->db->query("SELECT * FROM grocery_add_address WHERE lkp_status_id=0 AND user_id ='$user_id'");
// 	    $list_address =$getaddress->result();
// 	    $data['addressList'] =$list_address;
// 		$this->load->view('users/my-account',$data);
// 	}

	public function index()
	{
	     if($this->session->userdata('user_login_session_id')!= "") {
             $user_id = $this->session->userdata('user_login_session_id');
            } else {
            $baseurl=base_url();
      redirect($baseurl);
            }
            $getusers=$this->db->query("SELECT * FROM db_customers WHERE STATUS=1 AND id ='$user_id'");
	    $list_users =$getusers->result();
	    $data['userdetails'] =$list_users;
	    
		$this->load->view('users/myProfile',$data);
	}
	
	public function category_menu()
	{   
	    $q1=$this->db->query("SELECT * FROM db_category WHERE STATUS=1 ORDER BY id desc");
	    $list_category =$q1->result_array();
	    return $list_category;
		
	} 
	
		public function updatePassword()
	{   
	      if($this->session->userdata('user_login_session_id')!= "") {
             $user_id = $this->session->userdata('user_login_session_id');
        // $userData = getIndividualDetails('db_customers','id',$user_id);
         $getusers1=$this->db->query("SELECT * FROM db_customers WHERE id ='$user_id'");
	    $userData =$getusers1->result();
        $password = $userData[0]->user_password;
	    if (isset($_POST['submit'])){
	         $newPw=$_POST['newPassword'];
            $confirmPassword=$_POST['confirmPassword'];
             if($newPw!=$confirmPassword){
                 $this->session->set_flashdata('error_pwd','<div class="alert alert-danger succ_msg">Password and Confirm Password Must be Same.</div>');
			redirect(base_url().'Userdashboard');
            }else{
          $currentPwd=encryptPassword($_POST['currentPassword']);
        if($currentPwd== $password){
        $NewPass = encryptPassword($_POST["newPassword"]);
        $sql1 = "UPDATE db_customers SET user_password = '$NewPass' WHERE  id = '$user_id'";
        $updatepwd = $this->db->query($sql1);
         $this->session->set_flashdata('error_pwd','<div class="alert alert-success succ_msg">Your Password Changed Successfully.</div>');
			redirect(base_url().'Userdashboard');
        } else { 
            $this->session->set_flashdata('error_pwd','<div class="alert alert-danger succ_msg">Your Password not Changed!</div>');
            redirect(base_url().'Userdashboard');
        }
        }
	        
	    }
	      } else {
            $baseurl=base_url();
      redirect($baseurl);
            }
		
	} 
	
		public function updateProfile()
	{   
	      if($this->session->userdata('user_login_session_id')!= "") {
             $user_id = $this->session->userdata('user_login_session_id');
         $getusers1=$this->db->query("SELECT * FROM db_customers WHERE id ='$user_id'");
	    $userData =$getusers1->result();
	    if (isset($_POST['submit'])){
	         $user_name = $_POST["user_name"];
            $user_email = $_POST["user_email"];
          
        $sql1 = "UPDATE db_customers SET customer_name = '$user_name',email = '$user_email' WHERE  id = '$user_id'";
        $updateprofile = $this->db->query($sql1);
        if($updateprofile){
         $this->session->set_flashdata('error_pwd','<div class="alert alert-success succ_msg">Your Profile Updated Successfully.</div>');
			redirect(base_url().'Userdashboard');
        }else{
            $this->session->set_flashdata('error_pwd','<div class="alert alert-danger succ_msg">Your Profile not Updated!</div>');
			redirect(base_url().'Userdashboard');
        }
	    }
	      } else {
            $baseurl=base_url();
            redirect($baseurl);
            }
		
	} 
	
	
		public function ChangePassword()
	{
		$this->load->view('users/changePassword');
	}
	
	
		public function MyAddress()
	{
		$this->load->view('users/myAddress');
	}
		public function userDashboardOrders()
	{
	     if($this->session->userdata('user_login_session_id')!= "") {
             $user_id = $this->session->userdata('user_login_session_id');
            } else {
            $baseurl=base_url();
      redirect($baseurl);
            }
	     $getsales=$this->db->query("SELECT * FROM db_sales WHERE STATUS=1 AND customer_id ='$user_id'");
	    $list_sals =$getsales->result();
	    $data['orderdetails'] =$list_sals;
		$this->load->view('users/userDashboard',$data);
	}
	
	public function userDashboardOrdersold()
	{
	     if($this->session->userdata('user_login_session_id')!= "") {
             $user_id = $this->session->userdata('user_login_session_id');
            } else {
            $baseurl=base_url();
      redirect($baseurl);
            }
	     
		$this->load->view('users/userDashboard1.php');
	}
	
	
}
?>