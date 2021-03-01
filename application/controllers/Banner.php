<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('banner_model','banner');
	}

	public function add(){
		$data=$this->data;
		$data['page_title']=$this->lang->line('banner');
		$this->load->view('banner', $data);
	}
	public function newbanner(){
		$this->form_validation->set_rules('banner', 'Banner', 'trim|required');
	

		if ($this->form_validation->run() == TRUE) {
			$result=$this->banner->verify_and_save();
			echo $result;
		} else {
			echo "Please Enter Required Fields.";
		}
	}
	public function update($id){
		$data=$this->data;

	
		$result=$this->banner->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('banner');
		$this->load->view('banner', $data);
	}
	public function update_banner(){
		$this->form_validation->set_rules('banner', 'Banner', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
		
			$result=$this->banner->update_banner();
			echo $result;
		} else {
			echo "Please Enter Required Fields.";
		}
	}
	public function view(){
		$this->permission_check('banner_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('banner_list');
		$this->load->view('banner-view', $data);
	}

	public function ajax_list()
	{
		$list = $this->banner->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $banner) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$banner->id.' class="checkbox column_checkbox" >';
				$row[] = "<a title='Click for Bigger!' href='".base_url($banner->banner_image)."' data-toggle='lightbox'>
						<image style='border:1px #72afd2 solid;' src='".base_url($banner->banner_image)."'  width='75px' height='50px' > </a>";
			$row[] = $banner->banner_code;
			$row[] = $banner->title_banner;
			$row[] = $banner->description_banner;

			 		if($banner->status==1){ 
			 			$str= "<span onclick='update_status(".$banner->id.",0)' id='span_".$banner->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$banner->id.",1)' id='span_".$banner->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

										
											$str2.='<li>
												<a title="Edit Record ?" href="update/'.$banner->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

										
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_banner('.$banner->id.')">
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
						"recordsTotal" => $this->banner->count_all(),
						"recordsFiltered" => $this->banner->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function update_status(){
		$id=$this->input->post('id');
		$status=$this->input->post('status');

	
		$result=$this->banner->update_status($id,$status);
		return $result;
	}
	
	public function delete_banner(){
		$id=$this->input->post('q_id');
		return $this->banner->delete_categories_from_table($id);
	}
	public function multi_delete(){
		$ids=implode (",",$_POST['checkbox']);
		return $this->banner->delete_categories_from_table($ids);
	}

}

