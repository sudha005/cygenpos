<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modifiergroup extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('modifiersgroup_model','modifiersgroup');
	}

	public function add(){
		$data=$this->data;
		$data['page_title']='Modifier Group';
		$this->load->view('modifiergroup', $data);
	}
	public function newmodifiergroup(){
	    $this->form_validation->set_rules('modifiergroup_name', 'Modifier Group Name', 'trim|required');
	    	if ($this->form_validation->run() == TRUE) {
			$result=$this->modifiersgroup->verify_and_save();
			echo $result;
	    	} else {
			echo "Please Enter Required Fields.";
		}
	
	}
	public function update($id){
		$data=$this->data;
		$result=$this->modifiersgroup->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']='Modifier Group';
		$this->load->view('modifiergroup', $data);
	}
	public function update_modifiergroup(){
	    $this->form_validation->set_rules('modifiergroup_name', 'Modifier Group Name', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$result=$this->modifiersgroup->update_modifiergroup();
			echo $result;
		} else {
			echo "Please Enter Required Fields.";
		}
	}
	public function view(){
		$data=$this->data;
		$data['page_title']='Modifier Group List';
		$this->load->view('modifiergroup-view', $data);
	}

	public function ajax_list()
	{
		$list = $this->modifiersgroup->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cms) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$cms->id.' class="checkbox column_checkbox" >';
			$row[] = $cms->id;
			$row[] = $cms->modifiergroup_code;
			$row[] = $cms->modifiergroup_name;

			 		if($cms->status==1){ 
			 			$str= "<span onclick='update_status(".$cms->id.",0)' id='span_".$cms->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$cms->id.",1)' id='span_".$cms->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

										
											$str2.='<li>
												<a title="Edit Record ?" href="update/'.$cms->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

										
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_modifier('.$cms->id.')">
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
						"recordsTotal" => $this->modifiersgroup->count_all(),
						"recordsFiltered" => $this->modifiersgroup->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function update_status(){
		$this->permission_check_with_msg('cms_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$result=$this->modifiers->update_status($id,$status);
		return $result;
	}
	
	public function delete_modifier(){
		$this->permission_check_with_msg('cms_delete');
		$id=$this->input->post('q_id');
		return $this->modifiers->delete_modifier_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('cms_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->modifiers->delete_modifier_from_table($ids);
	}

}

