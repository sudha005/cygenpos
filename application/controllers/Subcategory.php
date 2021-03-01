<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategory extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('subcategory_model','subcategory');
	}

	public function add(){
		$data=$this->data;
		$data['page_title']='Sub Category';
		$this->load->view('subcategory', $data);
	}
	public function newsubcategory(){
			$this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
			$this->form_validation->set_rules('subcategory_name', 'Sub Category', 'trim|required');
	

		if ($this->form_validation->run() == TRUE) {
			$result=$this->subcategory->verify_and_save();
			echo $result;
		} else {
			echo "Please Enter Require Fields.";
		}
	}
	public function update($id){
		$data=$this->data;
		$result=$this->subcategory->get_details($id,$data);
		$data=array_merge($data,$result);
	   $data['page_title']='Sub Category';
		$this->load->view('subcategory', $data);
	}
	public function update_subcategory(){
		$this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
			$this->form_validation->set_rules('subcategory_name', 'Sub Category', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->subcategory->update_subcategory();
			echo $result;
		} else {
			echo "Please Enter Require Fields.";
		}
	}
	public function view(){
		$data=$this->data;
		$data['page_title']='Subcategory List';
		$this->load->view('subcategory-view', $data);
	}

	public function ajax_list()
	{
		$list = $this->subcategory->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $category) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$category->id.' class="checkbox column_checkbox" >';
				$row[] = "<a title='Click for Bigger!' href='".base_url('uploads/subcategory/'.$category->subcat_image)."' data-toggle='lightbox'>
						<image style='border:1px #72afd2 solid;' src='".base_url('uploads/subcategory/'.$category->subcat_image)."'  width='75px' height='50px' > </a>";
			$row[] = $category->id;
			$row[] = $category->category_name;
			$row[] = $category->subcategory_name;
			$row[] = $category->description;
			 		if($category->status==1){ 
			 			$str= "<span onclick='update_status(".$category->id.",0)' id='span_".$category->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$category->id.",1)' id='span_".$category->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

										
											$str2.='<li>
												<a title="Edit Record ?" href="update/'.$category->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

										
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_subcategory('.$category->id.')">
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
						"recordsTotal" => $this->subcategory->count_all(),
						"recordsFiltered" => $this->subcategory->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function update_status(){
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$result=$this->subcategory->update_status($id,$status);
		return $result;
	}
	
	public function delete_subcategory(){
		$id=$this->input->post('q_id');
		return $this->subcategory->delete_subcategories_from_table($id);
	}
	public function multi_delete(){
		$ids=implode (",",$_POST['checkbox']);
		return $this->subcategory->delete_subcategories_from_table($ids);
	}

}

