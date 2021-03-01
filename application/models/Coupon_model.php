<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon_model extends CI_Model {

	var $table = 'db_coupon';
	var $column_order = array('coupon_offertext','coupon_name','coupon_image','coupon','start_date','end_date','status'); //set column field database for datatable orderable
	var $column_search = array('coupon','start_date','end_date','status'); //set column field database for datatable searchable 
	var $order = array('id' => 'desc'); // default order 

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if(@$_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}


	public function verify_and_save(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));
        $file_name='';
		if(!empty($_FILES['coupon_image']['name'])){

			$new_name = time();
			$config['file_name'] = $new_name;
			$config['upload_path']          = './uploads/coupon/';
	        $config['allowed_types']        = 'jpg|png|jpeg';
	        $config['max_size']             = 1024;
	        $config['max_width']            = 1000;
	        $config['max_height']           = 1000;
	       
	        $this->load->library('upload', $config);

	        if ( ! $this->upload->do_upload('coupon_image'))
	        {	
	                $error = array('error' => $this->upload->display_errors());
	                print($error['error']);
	                exit();
	        }
	        else
	        {		
	        	$file_name=$this->upload->data('file_name');
	        	/*Create Thumbnail*/
	        	$config['image_library'] = 'gd2';
				$config['source_image'] = 'uploads/coupon/'.$file_name;
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width']         = 75;
				$config['height']       = 50;
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				//end

	        	
	        }
		}
		//Validate This country already exist or not
		$query=$this->db->query("select * from db_coupon where upper(coupon)=upper('$coupon_name')");
		if($query->num_rows()>0){
			return "coupon Name already Exist2.";
			
		}
		else{
		    $qs4="select coalesce(max(id),0)+1 as maxid from db_coupon";
			$q1=$this->db->query($qs4);
			$maxid=$q1->row()->maxid;
			$coupon_code='CP'.str_pad($maxid, 4, '0', STR_PAD_LEFT);
		    $start_date=$start_date!=''?date_dob_format($start_date):date('Y-m-d');
		    $end_date=$end_date!=''?date_dob_format($end_date):date('Y-m-d');
			$query1="insert into db_coupon(coupon_offertext,coupon_name,coupon_code,coupon,start_date,end_date,status) values('$coupon_offertext','$coupon','$coupon_code','$coupon_name','$start_date','$end_date',1)";
			if ($this->db->simple_query($query1)){
			    
			    $category_id = $this->db->insert_id();
			    if(!empty($file_name)){
					$q1=$this->db->query("update db_coupon set coupon_image ='$file_name' where id=".$category_id);
					//	echo $this->db->last_query(); die;	
				}
					$this->session->set_flashdata('success', 'Success!! New coupon Name Added Successfully!');
			        return "success";
			}
			else{
			        return "failed";
			}
		}
	}

	//Get country_details
	public function get_details($id){
		$data=$this->data;
		extract($data);
		extract($_POST);

		//Validate This country already exist or not
		$query=$this->db->query("select * from db_coupon where upper(id)=upper('$id')");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			$query=$query->row();
			$data['q_id']=$query->id;
			$data['coupon_name']=$query->coupon_name;
			$data['coupon']=$query->coupon;
			$data['start_date']=date_dob_format($query->start_date);
			$data['end_date']=date_dob_format($query->end_date);
			$data['coupon_image']=$query->coupon_image;
			$data['coupon_offertext']=$query->coupon_offertext;
			
			
			
			return $data;
		}
	}
	public function update_coupon(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));
			$file_name=$cat_image='';
			if(!empty($_FILES['coupon_image']['name'])){

				$new_name = time();
				$config['file_name'] = $new_name;
				$config['upload_path']          = './uploads/coupon/';
		        $config['allowed_types']        = 'jpg|png|jpeg';
		        $config['max_size']             = 1024;
		        $config['max_width']            = 1000;
		        $config['max_height']           = 1000;
		       
		        $this->load->library('upload', $config);

		        if ( ! $this->upload->do_upload('coupon_image'))
		        {
		                $error = array('error' => $this->upload->display_errors());
		                print($error['error']);
		                exit();
		        }
		        else
		        {		
		        	$file_name=$this->upload->data('file_name');
		        	
		        	/*Create Thumbnail*/
		        	$config['image_library'] = 'gd2';
					$config['source_image'] = 'uploads/coupon/'.$file_name;
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width']         = 75;
					$config['height']       = 50;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					//end

					$cat_image=" ,coupon_image='".$file_name."' ";

		        }
			}
		//Validate This country already exist or not
		$query=$this->db->query("select * from db_coupon where upper(coupon)=upper('$coupon_name') and id<>$q_id");
		if($query->num_rows()>10){
		//	return "Coupon Name already Exist.";
			
		}
		else{
			$start_date=$start_date!=''?date_dob_format($start_date):date('Y-m-d');
		    $end_date=$end_date!=''?date_dob_format($end_date):date('Y-m-d');
			$query1="update db_coupon set coupon_offertext='$coupon_offertext',coupon_name='$coupon',coupon='$coupon_name',start_date='$start_date',end_date='$end_date' $cat_image  where id=$q_id";
			if ($this->db->simple_query($query1)){
					$this->session->set_flashdata('success', 'Success!! coupon Name Updated Successfully!');
			        return "success";
			}
			else{
			        return "failed";
			}
		}
	}
	public function update_status($id,$status){
		
        $query1="update db_coupon set status='$status' where id=$id";
        if ($this->db->simple_query($query1)){
            echo "success";
        }
        else{
            echo "failed";
        }
	}
	public function delete_coupon($id){
        $query1="delete from db_coupon where id=$id";
        if ($this->db->simple_query($query1)){
            echo "success";
        }
        else{
            echo "failed";
        }
	}
	public function coupon_latest(){
	    $this->_get_datatables_query();
	    $this->db->order_by("id", "desc");
		$this->db->limit(20,0);
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		return $query->result();
    }

  




}
