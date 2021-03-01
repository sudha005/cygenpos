<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_model extends CI_Model {

	var $table = 'db_banners';
	var $column_order = array(null, 'banner_code','title_banner','description_banner','banner_image','status'); //set column field database for datatable orderable
	var $column_search = array('banner_code','title_banner','description_banner','banner_image','status'); //set column field database for datatable searchable 
	var $order = array('id' => 'desc'); // default order 

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
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
		//	$this->db->trans_begin();
	//	$this->db->trans_strict(TRUE);

		$file_name='';
		if(!empty($_FILES['banner_image']['name'])){

			$new_name = time();
			$config['file_name'] = $new_name;
			$config['upload_path']          = './uploads/banners/';
	        $config['allowed_types']        = 'jpg|png|jpeg';
	        $config['max_size']             = 1024;
	        $config['max_width']            = 2000;
	        $config['max_height']           = 1000;
	       
	        $this->load->library('upload', $config);

	        if ( ! $this->upload->do_upload('banner_image'))
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
				$config['source_image'] = 'uploads/banners/'.$file_name;
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width']         = 75;
				$config['height']       = 50;
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				//end

	        	
	        }
		}
		
		
		//Validate This category already exist or not
		$query=$this->db->query("select * from db_banners where upper(title_banner)=upper('$banner')");
		if($query->num_rows()>0){
			return "This Banner Name already Exist.";
			
		}
		else{
			$qs5="select banner_init from db_company";
			$q5=$this->db->query($qs5);
			$banner_init=$q5->row()->banner_init;
			
			//Create category unique Number
			$qs4="select coalesce(max(id),0)+1 as maxid from db_banners";
			$q1=$this->db->query($qs4);
			$maxid=$q1->row()->maxid;
			$banner_code=$banner_init.str_pad($maxid, 4, '0', STR_PAD_LEFT);
			//end
			
		$query1op="insert into db_banners(banner_code,title_banner,description_banner,status)values('$banner_code','$banner','$description',1)";
		
							
							//	echo $this->db->last_query(); die;			
		if ($this->db->simple_query($query1op)){
			    $banner_id = $this->db->insert_id();
			    if(!empty($file_name)){
					$q1=$this->db->query("update db_banners set banner_image ='uploads/banners/$file_name' where id=".$banner_id);
					//	echo $this->db->last_query(); die;	
				}
					$this->session->set_flashdata('success', 'Success!! New Banner Added Successfully!');
			        return "success";
			}
			else{
			        return "failed";
			}
		}
	}

	//Get banner_details
	public function get_details($id,$data){
		//Validate This category already exist or not
		$query=$this->db->query("select * from db_banners where upper(id)=upper('$id')");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			$query=$query->row();
			$data['q_id']=$query->id;
			$data['banner_code']=$query->banner_code;
				$data['banner_image']=$query->banner_image;
			$data['banner']=$query->title_banner;
			$data['description']=$query->description_banner;
			return $data;
		}
	}
	public function update_banner(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));

		//Validate This category already exist or not
		$query=$this->db->query("select * from db_banners where upper(title_banner)=upper('$banner') and id<>$q_id");
		if($query->num_rows()>0){
			return "This Banner Name already Exist.";
			
		}
		else{
		    	$file_name=$cat_image='';
			if(!empty($_FILES['banner_image']['name'])){

				$new_name = time();
				$config['file_name'] = $new_name;
				$config['upload_path']          = './uploads/banners/';
		        $config['allowed_types']        = 'jpg|png|jpeg';
		        $config['max_size']             = 1024;
		        $config['max_width']            = 1000;
		        $config['max_height']           = 1000;
		       
		        $this->load->library('upload', $config);

		        if ( ! $this->upload->do_upload('banner_image'))
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
					$config['source_image'] = 'uploads/banners/'.$file_name;
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width']         = 75;
					$config['height']       = 50;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					//end

					$banner_image=" ,banner_image='".$config['source_image']."' ";

		        }
			}
			$query1="update db_banners set title_banner='$banner',description_banner='$description' $banner_image where id=$q_id";
			if ($this->db->simple_query($query1)){
					$this->session->set_flashdata('success', 'Success!! Banner Updated Successfully!');
			        return "success";
			}
			else{
			        return "failed";
			}
		}
	}
	public function update_status($id,$status){
		
        $query1="update db_banners set status='$status' where id=$id";
        if ($this->db->simple_query($query1)){
            echo "success";
        }
        else{
            echo "failed";
        }
	}
// 	public function delete_categories_from_table($ids){
// 		$tot=$this->db->query('SELECT COUNT(*) AS tot,b.category_name FROM db_items a,`db_category` b WHERE b.id=a.`category_id` AND a.category_id IN ('.$ids.') GROUP BY a.category_id');
// 		if($tot->num_rows() > 0){
// 			foreach($tot->result() as $res){
// 				$category_name[] =$res->category_name;
// 			}
// 			$list=implode (",",$category_name);
// 			echo "Sorry! Can't Delete,<br>Category Name {".$list."} already in use in Items!";
// 			exit();
// 		}
// 		else{
// 			$query1="delete from db_category where id in($ids)";
// 	        if ($this->db->simple_query($query1)){
// 	            echo "success";
// 	        }
// 	        else{
// 	            echo "failed";
// 	        }	
// 		}
// 	}


}
