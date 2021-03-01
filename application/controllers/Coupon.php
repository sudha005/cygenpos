<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('coupon_model','coupon');
	}

	public function index(){
		$this->permission_check('places_view');
		$data=$this->data;
		$data['page_title']='Coupon_list';
		$this->load->view('coupon-list', $data);
	}
	public function newcoupon(){
		$this->form_validation->set_rules('coupon_name', 'Coupon', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$result=$this->coupon->verify_and_save();
			echo $result;
		} else {
			echo "Please Enter Coupon name.";
		}
	}
	public function update($id){
		$this->permission_check('places_edit');
		$result=$this->coupon->get_details($id);
		$data=array_merge($this->data,$result);
		$data['page_title']='Coupon';
		$this->load->view('coupon', $data);
	}
	public function update_coupon(){
		
		$this->form_validation->set_rules('coupon_name', 'Coupon', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->coupon->update_coupon();
			echo $result;
		} else {
			echo "Please Enter coupon name.";
		}
	}
	public function add(){
	   //$this->permission_check('places_add');
		$data=$this->data;
		$data['page_title']='coupon';
		$this->load->view('coupon', $data);
	}

	public function ajax_list()
	{
		$list = $this->coupon->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $country) {
			$no++;
			$row = array();
			$row[] = $country->coupon_name;
			$row[] = $country->coupon;
			$row[] = $country->coupon_offertext;
			$row[] = date_view_format($country->start_date);
			$row[] = date_view_format($country->end_date);


			 		if($country->status==1){ 
			 			$str= "<span onclick='update_status(".$country->id.",0)' id='span_".$country->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$country->id.",1)' id='span_".$country->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
			         $str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											if($this->permissions('places_edit'))
											$str2.='<li>
												<a title="Edit Record ?" href="coupon/update/'.$country->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('places_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_country('.$country->id.')">
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
						"recordsTotal" => $this->coupon->count_all(),
						"recordsFiltered" => $this->coupon->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function update_status(){
		$this->permission_check_with_msg('places_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$result=$this->coupon->update_status($id,$status);
		return $result;
	}
	public function delete_country(){
		$this->permission_check_with_msg('places_delete');
		$id=$this->input->post('q_id');
		$result=$this->coupon->delete_coupon($id);
		return $result;
	}
}

