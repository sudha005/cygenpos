<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategory_model extends CI_Model {

	var $table = 'db_subcategory as a';
	var $column_order = array('a.id','a.subcategory_code','a.subcategory_name','a.description','a.cat_id','a.subcat_image','a.show_big_image','a.show_small_image','a.status','a.subcat_url_slag','b.category_name'); //set column field database for datatable orderable
	var $column_search = array('a.id','a.subcategory_code','a.subcategory_name','a.description','a.cat_id','a.subcat_image','a.show_big_image','a.show_small_image','a.status','a.subcat_url_slag','b.category_name'); //set column field database for datatable searchable 
	var $order = array('id' => 'desc'); // default order 

	private function _get_datatables_query()
	{
		
	 $this->db->select($this->column_order);
		$this->db->from($this->table);
		$this->db->join('db_category as b','b.id=a.cat_id');

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
	    //		$this->db->trans_begin();
	//	$this->db->trans_strict(TRUE);

		$file_name='';
		if(!empty($_FILES['subcat_image']['name'])){

			$new_name = time();
			$config['file_name'] = $new_name;
			$config['upload_path']          = './uploads/subcategory/';
	        $config['allowed_types']        = 'jpg|png|jpeg';
	        $config['max_size']             = 1024;
	        $config['max_width']            = 1000;
	        $config['max_height']           = 1000;
	       
	        $this->load->library('upload', $config);

	        if ( ! $this->upload->do_upload('subcat_image'))
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
				$config['source_image'] = 'uploads/subcategory/'.$file_name;
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
		$query=$this->db->query("select * from db_subcategory where upper(subcategory_name)=upper('$subcategory_name') and upper(cat_id)=upper('$cat_id')");
		if($query->num_rows()>0){
			return "This SubCategory Name already Exist.";
			
		}
		else{
		
			//Create category unique Number
			$qs4="select coalesce(max(id),0)+1 as maxid from db_subcategory";
			$q1=$this->db->query($qs4);
			$maxid=$q1->row()->maxid;
			$subcategory_code='SC'.str_pad($maxid, 4, '0', STR_PAD_LEFT);
			//end
			
				$show_big_image = (isset($show_big_image)) ? 1 : 0;
			$show_small_image = (isset($show_small_image)) ? 1 : 0;
			$query1="insert into db_subcategory(subcategory_code,subcategory_name,description,cat_id,show_big_image,show_small_image,pos_subcategory,status) 
								values('$subcategory_code','$subcategory_name','$description','$cat_id','$show_big_image','$show_small_image','$pos_subcategory',1)";
			if ($this->db->simple_query($query1)){
			    $subcategory_id = $this->db->insert_id();
			    if(!empty($file_name)){
					$q1=$this->db->query("update db_subcategory set subcat_image ='$file_name' where id=".$subcategory_id);
					//	echo $this->db->last_query(); die;	
				}
					$this->session->set_flashdata('success', 'Success!! New Sub Category Added Successfully!');
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
		$query=$this->db->query("select * from db_subcategory where upper(id)=upper('$id')");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			$query=$query->row();
			$data['q_id']=$query->id;
			$data['subcat_image']=$query->subcat_image;
			$data['subcategory_code']=$query->subcategory_code;
			$data['subcategory_name']=$query->subcategory_name;
			$data['description']=$query->description;
			$data['cat_id']=$query->cat_id;
			$data['show_big_image']=$query->show_big_image;
			$data['show_small_image']=$query->show_small_image;
			$data['subcat_url_slag']=$query->subcat_url_slag;
			$data['pos_subcategory']=$query->pos_subcategory;
			return $data;
		}
	}
	public function update_subcategory(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));

		//Validate This category already exist or not
		$query=$this->db->query("select * from db_subcategory where upper(subcategory_name)=upper('$subcategory_name') and upper(cat_id)=upper('$cat_id') and id<>$q_id");
		if($query->num_rows()>0){
			return "This SubCategory Name already Exist.";
			
		}
		else{
		    
		    	$file_name=$subcat_image='';
			if(!empty($_FILES['subcat_image']['name'])){

				$new_name = time();
				$config['file_name'] = $new_name;
				$config['upload_path']          = './uploads/subcategory/';
		        $config['allowed_types']        = 'jpg|png|jpeg';
		        $config['max_size']             = 1024;
		        $config['max_width']            = 1000;
		        $config['max_height']           = 1000;
		       
		        $this->load->library('upload', $config);

		        if ( ! $this->upload->do_upload('subcat_image'))
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
					$config['source_image'] = 'uploads/subcategory/'.$file_name;
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width']         = 75;
					$config['height']       = 50;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					//end

					$subcat_image=" ,subcat_image='".$file_name."' ";

		        }
			}
			$show_big_image = (isset($show_big_image)) ? 1 : 0;
			$show_small_image = (isset($show_small_image)) ? 1 : 0;
			$query1="update db_subcategory set subcategory_name='$subcategory_name',cat_id='$cat_id',description='$description',show_big_image='$show_big_image',show_small_image='$show_small_image',pos_subcategory='$pos_subcategory' $subcat_image where id=$q_id";
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
		
        $query1="update db_subcategory set status='$status' where id=$id";
        if ($this->db->simple_query($query1)){
            echo "success";
        }
        else{
            echo "failed";
        }
	}
	
    public function subcat_home($catId){
        $this->_get_datatables_query('1');
        $this->db->where('a.cat_id',$catId);
         $this->db->where('a.status',1);
        $this->db->limit(20,0);
        $query = $this->db->get();
        //	echo $this->db->last_query(); die;
        return $query->result();
    
    }
	
		public function subcat_by_Category($cat_id){
	    $this->_get_datatables_query('1');
	    $this->db->where('a.cat_id',$cat_id);
	     $this->db->where('a.status',1);
		$query = $this->db->get();
		return $query->result();
		
	}
	
	
// 	public function delete_subcategories_from_table($ids){
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


    public function subcat_pos(){
        $this->_get_datatables_query('1');
        $this->db->where('a.status',1);
        $this->db->limit(8,0);
        $query = $this->db->get();
        return $query->result();
    }



}
