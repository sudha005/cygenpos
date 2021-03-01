<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RestaurantTables_Model extends CI_Model {

	var $table = 'db_restaurant_tables';
	var $column_order = array(null, 'table_name','table_details','table_capacity','status','area'); //set column field database for datatable orderable
	var $column_search = array('table_name','table_details','table_capacity','status','area'); //set column field database for datatable searchable 
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
       //echo $table ;exit;
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

	public function get_details($id,$data){ //echo $id;exit;
		//Validate This category already exist or not
        $query=$this->db->query("select * from db_restaurant_tables where upper(id)=upper('$id')");
       //print_r($query->row());exit;
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			$query=$query->row();
			$data['id']=$query->id;
			$data['table_name']=$query->table_name;			
			$data['table_details']=$query->table_details;			
			$data['table_capacity']=$query->table_capacity;			
			$data['status']=$query->status;	
			$data['area']=$query->area;	
			$data['chair']=$query->chair;	
			return $data;
		}
	}

	public function save_restaurantTable(){ 
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));
	    		
		if(!empty($_POST)){		
			$area=$area!=''?$area:'0';
			$query1="insert into db_restaurant_tables (table_name,table_details,table_capacity,area,chair) 
							values('$table_name','$table_details',$table_capacity,'$area','$chair')";
			if ($this->db->simple_query($query1)){
			    
					$this->session->set_flashdata('success', 'Success!! New Restaurant Table Added Successfully!');
			        return "success";
			}
			else{
			        return "failed";
			}
		}
	}


	
	
	public function update_restaurantTbl(){ //echo $id;exit;
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));
			$area=$area!=''?$area:'0';	
			
			$query1="update db_restaurant_tables set table_name='$table_name',table_details='$table_details',table_capacity='$table_capacity',area=$area,chair='$chair' where id=$id";
			if ($this->db->simple_query($query1)){
					$this->session->set_flashdata('success', 'Success!! Restaurant Updated Successfully!');
			        return "success";
			}
			else{
				echo "failed";
				die();
					return "failed";

			}
		
	}
	
	public function update_status($id,$status){
		
        $query1="update db_restaurant_tables set status='$status' where id=$id";
        if ($this->db->simple_query($query1)){
            echo "success";
        }
        else{
            echo "failed";
        }
	}


	public function delete_restaurent_tbl($id){ //echo $id;exit;
		if($id==1){
			echo "Restricted! Can't Delete User Admin!!";
			exit();
		}
        $query1="delete from db_restaurant_tables where id=$id";
        if ($this->db->simple_query($query1)){
            echo "success";
            $this->session->set_flashdata('success', 'Success!! User Deleted Succssfully!');
        }
        else{
            echo "failed";
        }
	}

	public function multi_delete($ids){
		$query1="delete from db_restaurant_tables where id in($ids)";
		if ($this->db->simple_query($query1)){
			echo "success";
		}
		else{
			echo "failed";
		}	
	
}


}
