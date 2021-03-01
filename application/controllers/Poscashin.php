<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poscashin extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('pos_model','pos_model');
		$this->load->helper('sms_template_helper');
		//$this->load->library('Curl');
	}

	public function is_sms_enabled(){
		return is_sms_enabled();
	}
	
	public function index()
	{
		$this->permission_check('sales_add');
		$data=$this->data;
		$data['page_title']='POS';
		$this->load->view('poscashin',$data);
	}
	
		public function get_hold_invoice_list(){
		$data =array();
		$result= $this->pos_model->hold_invoice_list();
		return $result;
	}

		public function save_cashin(){
	    echo $this->pos_model->save_cashin();
	}
}