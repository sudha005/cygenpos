<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customerspecificprice extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('customerspecificprice_model','customerspecificprice');
		$this->load->helper('custom');
	}

	public function add(){
		$data=$this->data;
		$data['page_title']='Customer Specific Price';
		$this->load->view('customer_specificprice', $data);
	}
	public function new_customer_specificprice(){
			$result=$this->customerspecificprice->verify_and_save();
			echo $result;
	
	}
	public function update($id){
		$data=$this->data;
		$result=$this->customerspecificprice->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']='Customer Specific Price';
		$this->load->view('customer_specificprice', $data);
	}
	public function update_customer_specificprice(){
		$this->form_validation->set_rules('customer_id', 'Customer', 'trim|required');
		$this->form_validation->set_rules('item_id', 'Item', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
		
			$result=$this->customerspecificprice->update_customer_specificprice();
			echo $result;
		} else {
			echo "Please Enter Rquired Fields.";
		}
	}
	public function view(){
		$data=$this->data;
		$data['page_title']='Customer Specific Price List';
		$this->load->view('customerspecificprice-view', $data);
	}

	public function ajax_list()
	{
		$list = $this->customerspecificprice->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cms) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$cms->id.' class="checkbox column_checkbox" >';
			$row[] = $cms->id;
			$row[] = $cms->customer_name;
			$row[] = $cms->item_name;
			$row[] = $cms->new_price;

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
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_customer_specificprice('.$cms->id.')">
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
						"recordsTotal" => $this->customerspecificprice->count_all(),
						"recordsFiltered" => $this->customerspecificprice->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function update_status(){
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$result=$this->customerspecificprice->update_status($id,$status);
		return $result;
	}
	
	public function delete_customer_specificprice(){
		$id=$this->input->post('q_id');
		return $this->customerspecificprice->delete_customerspecific_price_from_table($id);
	}
	public function multi_delete(){
		$ids=implode (",",$_POST['checkbox']);
		return $this->customerspecificprice->delete_customerspecific_price_from_table($ids);
	}
	
	public function get_product_Price(){
    $CI = & get_instance();
   $productId=$this->input->post('productId');
   $categoryId = getSingleColumnName($productId,'id','price','db_items');
    if($categoryId!=""){
        echo $categoryId;
    }else{
        echo '0';
    }
}

}

