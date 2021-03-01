<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itemmodifier extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('itemsmodifier_model','itemsmodifier');
	}

	public function add($id){
		$data=$this->data;
		
		$this->load->model('items_model');
		$result=$this->items_model->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']='Item Modifier';
		$this->load->view('item_modifier', $data);
	}
	public function newitemmodifier(){
			$this->load->model('itemsmodifier_model');
			$result=$this->itemsmodifier_model->verify_and_save();
			echo $result;
			exit;
	
	}
	public function update($id){
		$this->permission_check('cms_edit');
		$data=$this->data;

		$this->load->model('itemsmodifier_model');
		$result=$this->itemsmodifier_model->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']='Item Modifier';
		$this->load->view('item_modifier', $data);
	}
	public function update_itemmodifier(){
		$this->form_validation->set_rules('q_id', '', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			/*$data=$this->data;
			$category=$this->input->post('category');
			$description=$this->input->post('description');
			$q_id=$this->input->post('q_id');*/
			
			$this->load->model('itemsmodifier_model');
			$result=$this->itemsmodifier_model->update_itemmodifier();
			echo $result;
		} else {
			echo "Please Enter Title.";
		}
	}
	public function view($id){
		$data=$this->data;
		$data['page_title']='Item Modifiers List';
		$data['id']=$id;
		$this->load->view('itemmodifier-view', $data);
	}

	public function ajax_list()
	{
	    $id = $this->input->post('id');
	    //$id = 164;
		$list = $this->itemsmodifier->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cms) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$cms->id.' class="checkbox column_checkbox" >';
			$row[] = $cms->items_modifier_code;
			$row[] = $cms->item_name;
			$row[] = $cms->modifier_name;

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
												<a title="Edit Record ?" href="'.base_url("itemmodifier/update/".$cms->id).'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('cms_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_itemmodifier('.$cms->id.')">
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
						"recordsTotal" => $this->itemsmodifier->count_all(),
						"recordsFiltered" => $this->itemsmodifier->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function update_status(){
		$this->permission_check_with_msg('cms_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$result=$this->itemsmodifier->update_status($id,$status);
		return $result;
	}
	
		public function modifierList(){
        $CI = & get_instance();
        $this->load->model('modifiers_model','modifiers');
        $modifiergruoupId = $this->input->post('modifiergruoupId');
         $modifierList = $this->modifiers->modifier_by_group($modifiergruoupId);
        $data['modifierList']  = $modifierList;
        $this->load->view('modifier_list_ajax',$data);
    }
	
	public function delete_itemmodifier(){
		$this->permission_check_with_msg('cms_delete');
		$id=$this->input->post('q_id');
		return $this->itemsmodifier->delete_item_modifier_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('cms_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->itemsmodifier->delete_item_modifier_from_table($ids);
	}

}

