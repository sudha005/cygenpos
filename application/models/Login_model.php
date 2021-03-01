<?php
class Login_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function verify_credentials($username,$password)
	{
		//Filtering XSS and html escape from user inputs 
		$username=$this->security->xss_clean(html_escape($username));
		$password=$this->security->xss_clean(html_escape($password));
				
		$query=$this->db->query("select a.id,a.username,a.role_id,b.role_name from db_users a, db_roles b where b.id=a.role_id and  a.username='$username' and a.password='".md5($password)."' and a.status=1");
		if($query->num_rows()==1){

			$logdata = array('inv_username'  => $query->row()->username,
				        	 'inv_userid'  => $query->row()->id,
				        	 'logged_in' => TRUE,
				        	 'role_id' => $query->row()->role_id,
				        	 'role_name' => trim($query->row()->role_name),
				        	);
				        	//echo ($this->is_concurrent_login($query->row()->id));
				        //	exit;
		    if($this->is_concurrent_login($query->row()->id)){
		        
		      $data_user=array(
		          'user_id'=>$query->row()->id,
		          'login_intime'=>date('Y-m-d h:i:s'),
		          'login_outtime'=>date('Y-m-d h:i:s')
		          ); 
		    $this->db->insert('db_user_loginsess',$data_user);    
			$this->session->set_userdata($logdata);
			$this->session->set_flashdata('success', 'Welcome '.ucfirst($query->row()->username)." !");
			return true;
		    }else{
		       false; 
		    }
		}
		else{
			return false;
		}		
	}
	
	 public function is_concurrent_login($user_id_val)
    {
        $CI =& get_instance();
        $current_time = date('Y-m-d H:i:s');
        $user_id = $user_id_val;
        $user_login = getSingleColumnName($user_id,'id','is_login','db_users');
        $sessValue=$CI->session->userdata('sess_token');  
        $end_time =getSingleColumnName($user_id,'id','end_time','db_users');
        $sessDbValue=getSingleColumnName($user_id,'id','sess_token','db_users');
        $curdate=strtotime(date('Y-m-d H:i:s'));
        $mydate=strtotime($end_time);
        if($user_login==0)
        { 
             $sessionValue=generator(10);
            $user_data2 = array(
                'sess_token' =>$sessionValue 
            );
            $CI->session->set_userdata($user_data2);
            $logout_time = date('Y-m-d H:i:s', strtotime('50 minutes'));
            $login_time = date('Y-m-d H:i:s');
            $data=array(
                'start_time'=>$login_time,
                'end_time'=>$logout_time,
                'is_login'=>0,
                'sess_token'=>$sessionValue 
            );            
            $CI->db->where('id', $user_id);
            $CI->db->update('db_users', $data); 
            return true;
        }elseif($user_login==1 && $sessDbValue==$sessValue)
        {
            return true;
        }else{
            return false;
        }
        
    }
  	
	
	
	
	
	
	
	
	public function verify_email_send_otp($email)
	{
		$q1=$this->db->query("select email,company_name from db_company where email<>''");
		if($q1->num_rows()==0){
			$this->session->set_flashdata('failed', 'Failed to send OTP! Contact admin :(');
			return false;
			exit();
		}
		//Filtering XSS and html escape from user inputs 
		$email_id=$this->security->xss_clean(html_escape($email));
				
		$query=$this->db->query("select * from db_users where email='$email' and status=1");
		if($query->num_rows()==1){
			$otp=rand(1000,9999);

			$server_subject = "OTP for Password Change | OTP: ".$otp;
			$ready_message="---------------------------------------------------------
Hello User,

You are requested for Password Change,
Please enter ".$otp." as a OTP.

Note: Don't share this OTP with anyone.
Thank you
---------------------------------------------------------
		";
		
			$this->load->library('email');
			$this->email->from($q1->row()->email, $q1->row()->company_name);
			$this->email->to($email_id);
			$this->email->subject($server_subject);
			$this->email->message($ready_message);

			if($this->email->send()){
				//redirect('contact/success');
				$this->session->set_flashdata('success', 'OTP has been sent to your email ID!');
				$otpdata = array('email'  => $email,'otp'  => $otp );
				$this->session->set_userdata($otpdata);
				//echo "Email Sent";
				return true;
			}
			else{
				//echo "Failed to Send Message.Try again!";
				return false;
			}
		}
		else{
			return false;
		}		
	}
	public function verify_otp($otp)
	{
		//Filtering XSS and html escape from user inputs 
		$otp=$this->security->xss_clean(html_escape($otp));
		$email=$this->security->xss_clean(html_escape($email));
		if($this->session->userdata('email')==$email){ redirect(base_url().'logout','refresh');	}
				
		$query=$this->db->query("select * from db_users where username='$username' and password='".md5($password)."' and status=1");
		if($query->num_rows()==1){

			$logdata = array('inv_username'  => $query->row()->username,
				        	 'inv_userid'  => $query->row()->id,
				        	 'logged_in' => TRUE 
				        	);
			$this->session->set_userdata($logdata);
			return true;
		}
		else{
			return false;
		}		
	}
	public function change_password($password,$email){
			$query=$this->db->query("select * from db_users where email='$email' and status=1");
			if($query->num_rows()==1){
				/*if($query->row()->username == 'admin'){
					echo "Restricted Admin Password Change";exit();
				}*/
				$password=md5($password);
				$query1="update db_users set password='$password' where email='$email'";
				if ($this->db->simple_query($query1)){

				        return true;
				}
				else{
				        return false;
				}
			}
			else{
				return false;
				}

		}
}