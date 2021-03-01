<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('offers_model','offers');
	}

	public function add(){
		$data=$this->data;
		$data['page_title']='Offers';
		$this->load->view('offer', $data);
	}
	public function newoffer(){
	    	$this->form_validation->set_rules('offer_name', 'Offer Name', 'trim|required');
		$this->form_validation->set_rules('offer_percentage', 'Offer Percentage', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
			$result=$this->offers->verify_and_save();
			echo $result;
			} else {
			echo "Please Enter Required Fields.";
		}
	
	}
	public function update($id){
		$data=$this->data;
		$result=$this->offers->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']='Offers';
		$this->load->view('offer', $data);
	}
	public function update_offer(){
		$this->form_validation->set_rules('offer_name', 'Offer Name', 'trim|required');
		$this->form_validation->set_rules('offer_percentage', 'Offer Percentage', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->offers->update_offer();
			echo $result;
		} else {
	echo "Please Enter Required Fields.";
		}
	}
	public function view(){
		$data=$this->data;
		$data['page_title']='Offer List';
		$this->load->view('offer-view', $data);
	}

	public function ajax_list()
	{
		$list = $this->offers->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cms) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$cms->id.' class="checkbox column_checkbox" >';
			$row[] = $cms->offer_code;
			$row[] = $cms->offer_name;
			$row[] = $cms->offer_percentage;

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

								// 			if($this->permissions('cms_edit'))
											$str2.='<li>
												<a title="Edit Record ?" href="update/'.$cms->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

								// 			if($this->permissions('cms_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_offers('.$cms->id.')">
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
						"recordsTotal" => $this->offers->count_all(),
						"recordsFiltered" => $this->offers->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function update_status(){
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$result=$this->offers->update_status($id,$status);
		return $result;
	}
	
	public function delete_offers(){
		$this->permission_check_with_msg('cms_delete');
		$id=$this->input->post('q_id');
		return $this->offers->delete_offer_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('cms_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->offers->delete_offer_from_table($ids);
	}

}

