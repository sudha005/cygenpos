<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itemsmodifier_model extends CI_Model {

	var $table = 'db_items_modifier as a';
	var $column_order = array('a.id','a.items_modifier_code','a.item_id','a.modifier_id','a.item_group_id','b.item_name','c.modifier_name','a.status'); //set column field database for datatable orderable
	var $column_search = array('a.id','a.items_modifier_code','a.item_id','a.modifier_id','a.item_group_id','b.item_name','c.modifier_name','a.status'); //set column field database for datatable searchable 
// 	var $column_order = array(null, 'items_modifier_code','item_id','modifier_id','status'); //set column field database for datatable orderable
// 	var $column_search = array('items_modifier_code','item_id','modifier_id','status'); //set column field database for datatable searchable 
	var $order = array('id' => 'desc'); // default order 

	private function _get_datatables_query()
	{
		
// 		$this->db->from($this->table);

	 $this->db->select($this->column_order);
		$this->db->from($this->table);
		$this->db->join('db_items as b','b.id=a.item_id');
		$this->db->join('db_modifier as c','c.id=a.modifier_id');

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

	function get_datatables($id)
	{
		$this->_get_datatables_query();
		$this->db->where('a.item_id',$id);
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
		
		//Validate This category already exist or not
		$query=$this->db->query("select * from db_item_group where upper(modifiergroup_id)=upper('$modifiergroup_id') AND upper(item_id)=upper('$q_id')");
		if($query->num_rows()>0){
			return "This Item Modifier  already Exist.";
			
		}
		else{
// 			$qs5="select cms_init from db_company";
// 			$q5=$this->db->query($qs5);
// 			$cms_init=$q5->row()->cms_init;
			
			//Create category unique Number
			$qs4="select coalesce(max(id),0)+1 as maxid from db_items_modifier";
			$q1=$this->db->query($qs4);
			$maxid=$q1->row()->maxid;
			$items_modifier_code='IMD'.str_pad($maxid, 4, '0', STR_PAD_LEFT);
			//end
			
				$query2="insert into db_item_group(item_id,modifiergroup_id,status) 
								values('$q_id','$modifiergroup_id',1)";
								
								//echo $query2;exit;

// 			$query1="insert into db_items_modifier(items_modifier_code,item_id,modifier_id,status) 
// 								values('$items_modifier_code','$q_id','$modifier_id',1)";
			if ($this->db->simple_query($query2)){
			    	$item_group_id = $this->db->insert_id();
		       //$store_counter
		        if(count($modifier) > 0){
		    	for($um=0;$um< count(array_filter($modifier));$um++){
		        $modifier_id=$modifier[$um];
		      //  $query12="insert into db_user_assign(user_id,counter_id) 
								// 	values('$userlast_id','$counter_id')";
		      //  $this->db->query($query12);
		      	$items_modifier_entry = array(
		    				'items_modifier_code' 			=> $items_modifier_code, 
		    				'item_id'		=> $q_id, 
		    				'modifier_id' 			=> $modifier_id,
		    				'item_group_id' 			=> $item_group_id,
		    				'status' 			=> 1
		    			);
				$q4 = $this->db->insert('db_items_modifier', $items_modifier_entry);
			}
			$this->session->set_flashdata('success', 'Success!! New Item Modifier Added Successfully!');
			        return "success";
		        }
					$this->session->set_flashdata('success', 'Success!! New Item Modifier Added Successfully!');
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
		$query=$this->db->query("select * from db_items_modifier where upper(id)=upper('$id')");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			$query=$query->row();
			$data['q_id']=$query->id;
			$data['items_modifier_code']=$query->items_modifier_code;
			$data['item_id']=$query->item_id;
			$data['modifier_id']=$query->modifier_id;
			return $data;
		}
	}
	public function update_itemmodifier(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));

			$query1="update db_items_modifier set modifier_id='$modifier_id' where id=$q_id";
			if ($this->db->simple_query($query1)){
					$this->session->set_flashdata('success', 'Success!! Item Modifier Updated Successfully!');
			        return "success";
			}
			else{
			        return "failed";
			}
	
	}
	public function update_status($id,$status){
		
        $query1="update db_items_modifier set status='$status' where id=$id";
        if ($this->db->simple_query($query1)){
            echo "success";
        }
        else{
            echo "failed";
        }
	}
	
	public function delete_item_modifier_from_table($ids){
		
			$query1="delete from db_items_modifier where id in($ids)";
	        if ($this->db->simple_query($query1)){
	            echo "success";
	        }
	        else{
	            echo "failed";
	        }	
		
	}
// 	public function delete_cms_from_table($ids){
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
// 			$query1="delete from db_cms where id in($ids)";
// 	        if ($this->db->simple_query($query1)){
// 	            echo "success";
// 	        }
// 	        else{
// 	            echo "failed";
// 	        }	
// 		}
// 	}


}
