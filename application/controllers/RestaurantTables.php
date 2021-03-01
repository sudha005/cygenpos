<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RestaurantTables extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('RestaurantTables_Model');
	}

    // --------- View Part Start------
    public function view(){
		//$this->permission_check('table_view');

		$data=$this->data;
		$data['page_title']='Restaurant Tables';
		$this->load->view('restaurant-tables-view', $data);
	}

	public function ajax_list()
	{
		$tables = $this->RestaurantTables_Model->get_datatables();
		
		$data = array(); 
		$no = $_POST['start'];
		foreach ($tables as $table) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$table->id.' class="checkbox column_checkbox" >';
			$row[] = $table->table_name;
			$row[] = $table->table_details;
			$row[] = $table->table_capacity;			
			// $row[] = $table->description;

			 		if($table->status==1){ 
			 			$str= "<span onclick='update_status(".$table->id.",0)' id='span_".$table->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$table->id.",1)' id='span_".$table->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											// if($this->permissions('table_edit'))
											$str2.='<li>
												<a title="Edit Record ?" href="update/'.$table->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											// if($this->permissions('table_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_restaurentTbl('.$table->id.')">
													<i class="fa fa-fw fa-trash text-red"></i>Delete
												</a>
											</li>
											
										</ul>
									</div>';			

			$row[] = $str2;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->RestaurantTables_Model->count_all(),
						"recordsFiltered" => $this->RestaurantTables_Model->count_filtered(),
						"data" => $data,
				);  
		//output to json format
		echo json_encode($output);
    }
    
    //-----------view part End-------------

    //-----------Add part Start-------------	

     public function add(){
		$data=$this->data;
		//$data['id']=$this->uri->segment(3);#echo $this->uri->segment(3);exit;
		$data['page_title']='Restaurant Tables Add'; #echo '<pre>';print_r($data);
		$this->load->view('restaurant-tables-add', $data);
	}
	public function newtable(){ #echo "hai";exit;
		$this->form_validation->set_rules('table_name', 'Table Name', 'trim|required');
		// $this->form_validation->set_rules('table_details', 'Table Details', 'trim|required');
		$this->form_validation->set_rules('table_capacity', 'Table Capacity', 'trim|required');
		
		
		if ($this->form_validation->run() == TRUE) {  
           
            //$this->load->model('RestaurantTables_Model');
            $result=$this->RestaurantTables_Model->save_restaurantTable();

			echo $result;
		} else {
			echo "Please Enter Required Fields.";
		}
	}

    //-----------Add part End-------------


    //-----------update part Start-------------
	
	public function update($id){ //echo $id;exit;
		//$this->permission_check('blog_edit');
		$data=$this->data;

		//$this->load->model('RestaurantTables_Model');
		$result=$this->RestaurantTables_Model->get_details($id,$data);
		$data=array_merge($data,$result);
		//print_r($data);exit;
		$data['page_title']='Restaurant Update';
		$this->load->view('restaurant-tables-add', $data);
	}
	public function update_RestaurantTbl(){ 
		$this->form_validation->set_rules('table_name', 'Table Name', 'trim|required');
		// $this->form_validation->set_rules('table_details', 'Table Details', 'trim|required');
		$this->form_validation->set_rules('table_capacity', 'Table Capacity', 'trim|required');

		if ($this->form_validation->run() == TRUE) {

			$result=$this->RestaurantTables_Model->update_restaurantTbl();
			echo $result;
		} else {
			echo "Please Enter Category name.";
		}
	}

 //-----------update part End-------------



	public function update_status(){
		//$this->permission_check_with_msg('table_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');		
		$result=$this->RestaurantTables_Model->update_status($id,$status);
		return $result;
	}
	
	public function delete_restaurentTbl($q_id){ //echo $q_id;
		//$this->permission_check_with_msg('table_delete');
		$id=$this->input->post('q_id');
		return $this->RestaurantTables_Model->delete_restaurent_tbl($id);
	}
	public function multi_delete(){ 
		//$this->permission_check_with_msg('table_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->RestaurantTables_Model->multi_delete($ids);
	}

}
