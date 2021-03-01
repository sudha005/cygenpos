<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modifier extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('modifiers_model','modifiers');
	}

	public function add(){
		$this->permission_check('cms_add');
		$data=$this->data;
		$data['page_title']='Modifier';
		$this->load->view('modifier', $data);
	}
	public function newmodifier(){
	    $this->form_validation->set_rules('modifier_name', 'Modifier Name', 'trim|required');
	    $this->form_validation->set_rules('modifier_price', 'Modifier Price', 'trim|required');
	    	if ($this->form_validation->run() == TRUE) {
			$this->load->model('modifiers_model');
			$result=$this->modifiers_model->verify_and_save();
			echo $result;
	    	} else {
			echo "Please Enter Required Fields.";
		}
	
	}
	public function update($id){
		$this->permission_check('cms_edit');
		$data=$this->data;

		$this->load->model('modifiers_model');
		$result=$this->modifiers_model->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']='Modifier List';
		$this->load->view('modifier', $data);
	}
	public function update_modifier(){
	    $this->form_validation->set_rules('modifier_name', 'Modifier Name', 'trim|required');
	    $this->form_validation->set_rules('modifier_price', 'Modifier Price', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			/*$data=$this->data;
			$category=$this->input->post('category');
			$description=$this->input->post('description');
			$q_id=$this->input->post('q_id');*/
			
			$this->load->model('modifiers_model');
			$result=$this->modifiers_model->update_modifier();
			echo $result;
		} else {
			echo "Please Enter Required Fields.";
		}
	}
	public function view(){
		$this->permission_check('cms_view');
		$data=$this->data;
		$data['page_title']='Modifiers List';
		$this->load->view('modifier-view', $data);
	}

	public function ajax_list()
	{
		$list = $this->modifiers->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cms) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$cms->id.' class="checkbox column_checkbox" >';
			$row[] = $cms->modifier_code;
			$row[] = $cms->modifier_name;
			$row[] = $cms->modifier_price;

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

											if($this->permissions('cms_edit'))
											$str2.='<li>
												<a title="Edit Record ?" href="update/'.$cms->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('cms_delete'))
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
						"recordsTotal" => $this->modifiers->count_all(),
						"recordsFiltered" => $this->modifiers->count_filtered(),
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

