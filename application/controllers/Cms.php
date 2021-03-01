<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('cms_model','cms');
	}

	public function add(){
		$this->permission_check('cms_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('cms');
		$this->load->view('cms', $data);
	}
	public function newcms(){
			$this->load->model('cms_model');
			$result=$this->cms_model->verify_and_save();
			echo $result;
	
	}
	public function update($id){
		$this->permission_check('cms_edit');
		$data=$this->data;

		$this->load->model('cms_model');
		$result=$this->cms_model->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('cms');
		$this->load->view('cms', $data);
	}
	public function update_cms(){
		$this->form_validation->set_rules('cms', 'Cms', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			/*$data=$this->data;
			$category=$this->input->post('category');
			$description=$this->input->post('description');
			$q_id=$this->input->post('q_id');*/
			
			$this->load->model('cms_model');
			$result=$this->cms_model->update_cms();
			echo $result;
		} else {
			echo "Please Enter Title.";
		}
	}
	public function view(){
		$this->permission_check('cms_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('cms_list');
		$this->load->view('cms-view', $data);
	}

	public function ajax_list()
	{
		$list = $this->cms->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cms) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$cms->id.' class="checkbox column_checkbox" >';
			$row[] = $cms->cms_code;
			$row[] = $cms->title;
			$row[] = $cms->description;

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
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_cms('.$cms->id.')">
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
						"recordsTotal" => $this->cms->count_all(),
						"recordsFiltered" => $this->cms->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function update_status(){
		$this->permission_check_with_msg('cms_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		$this->load->model('cms_model');
		$result=$this->cms_model->update_status($id,$status);
		return $result;
	}
	
	public function delete_cms(){
		$this->permission_check_with_msg('cms_delete');
		$id=$this->input->post('q_id');
		return $this->cms->delete_cms_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('cms_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->cms->delete_cms_from_table($ids);
	}

}

