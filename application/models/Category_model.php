<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

	var $table = 'db_category';
	var $column_order = array(null, 'category_code','category_name','description','cat_image','status','pastabar'); //set column field database for datatable orderable
	var $column_search = array('category_code','category_name','description','cat_image','status'); //set column field database for datatable searchable 
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
	    //		$this->db->trans_begin();
	//	$this->db->trans_strict(TRUE);

		$file_name='';
		if(!empty($_FILES['category_image']['name'])){

			$new_name = time();
			$config['file_name'] = $new_name;
			$config['upload_path']          = './uploads/category/';
	        $config['allowed_types']        = 'jpg|png|jpeg';
	        $config['max_size']             = 10204;
	        $config['max_width']            = 10000;
	        $config['max_height']           = 10000;
	       
	        $this->load->library('upload', $config);

	        if ( ! $this->upload->do_upload('category_image'))
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
				$config['source_image'] = 'uploads/category/'.$file_name;
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
		$query=$this->db->query("select * from db_category where upper(category_name)=upper('$category')");
		if($query->num_rows()>0){
			return "This Category Name already Exist.";
			
		}
		else{
			$qs5="select category_init from db_company";
			$q5=$this->db->query($qs5);
			$category_init=$q5->row()->category_init;
			
			//Create category unique Number
			$qs4="select coalesce(max(id),0)+1 as maxid from db_category";
			$q1=$this->db->query($qs4);
			$maxid=$q1->row()->maxid;
			$cat_code='CT'.str_pad($maxid, 4, '0', STR_PAD_LEFT);
			//end
			
			$pastabar=$pastabar!=''?$pastabar:'0';

			$query1="insert into db_category(category_code,category_name,description,status,pastabar,catbgimg_pos) 
								values('$cat_code','$category','$description',1,'$pastabar','$catbgimg_pos')";
			if ($this->db->simple_query($query1)){
			    $category_id = $this->db->insert_id();
			    if(!empty($file_name)){
					$q1=$this->db->query("update db_category set cat_image ='$file_name' where id=".$category_id);
					//	echo $this->db->last_query(); die;	
				}
					$this->session->set_flashdata('success', 'Success!! New Category Added Successfully!');
			        return "success";
			}
			else{
			        return "failed";
			}
		}
	}

	//Get category_details
	public function get_details($id,$data){
		//Validate This category already exist or not
		$query=$this->db->query("select * from db_category where upper(id)=upper('$id')");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			$query=$query->row();
			$data['q_id']=$query->id;
			$data['cat_image']=$query->cat_image;
			$data['category_code']=$query->category_code;
			$data['category_name']=$query->category_name;
			$data['description']=$query->description;
			$data['pastabar']=$query->pastabar;
			$data['catbgimg_pos']=$query->catbgimg_pos;	
			return $data;
		}
	}
	public function update_category(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));

		//Validate This category already exist or not
		$query=$this->db->query("select * from db_category where upper(category_name)=upper('$category') and status = 1 and id<>$q_id");
		if($query->num_rows()>0){
			return "This Category Name already Exist.";
			
		}
		else{
		    
		    	$file_name=$cat_image='';
			if(!empty($_FILES['category_image']['name'])){

				$new_name = time();
				$config['file_name'] = $new_name;
				$config['upload_path']          = './uploads/category/';
		        $config['allowed_types']        = 'jpg|png|jpeg';
		        $config['max_size']             = 1024;
		        $config['max_width']            = 1000;
		        $config['max_height']           = 1000;
		       
		        $this->load->library('upload', $config);

		        if ( ! $this->upload->do_upload('category_image'))
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
					$config['source_image'] = 'uploads/category/'.$file_name;
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width']         = 75;
					$config['height']       = 50;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					//end

					$cat_image=" ,cat_image='".$file_name."' ";

		        }
			}
			$pastabar=$pastabar!=''?$pastabar:'0';
			$catbgimg_pos= (isset($catbgimg_pos)) ? 1 : 0;
			$query1="update db_category set category_name='$category',description='$description',pastabar='$pastabar',catbgimg_pos='$catbgimg_pos' $cat_image where id=$q_id";
			if ($this->db->simple_query($query1)){
					$this->session->set_flashdata('success', 'Success!! Category Updated Successfully!');
			        return "success";
			}
			else{
			        return "failed";
			}
		}
	}
	public function update_status($id,$status){
		
        $query1="update db_category set status='$status' where id=$id";
        if ($this->db->simple_query($query1)){
            echo "success";
        }
        else{
            echo "failed";
        }
	}
	public function delete_categories_from_table($ids){
		$tot=$this->db->query('SELECT COUNT(*) AS tot,b.category_name FROM db_items a,`db_category` b WHERE b.id=a.`category_id` AND a.category_id IN ('.$ids.') GROUP BY a.category_id');
		if($tot->num_rows() > 0){
			foreach($tot->result() as $res){
				$category_name[] =$res->category_name;
			}
			$list=implode (",",$category_name);
			echo "Sorry! Can't Delete,<br>Category Name {".$list."} already in use in Items!";
			exit();
		}
		else{
			$query1="delete from db_category where id in($ids)";
	        if ($this->db->simple_query($query1)){
	            echo "success";
	        }
	        else{
	            echo "failed";
	        }	
		}
	}


}
