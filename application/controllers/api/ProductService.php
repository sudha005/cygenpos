<?php
error_reporting('0');
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . '/libraries/REST_Controller.php');

/**
 * Description of RestPostController
 * 
 */
class ProductService extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->helper("sms_template");
        $this->load->helper("custom");
    }
    public function test_get(){
        $responseList = self::success_response('TRUE','0','success');
        $this->set_response($responseList,REST_Controller::HTTP_OK); 
    }
    
     // for success response json 
    public function success_response($status, $responseCode, $message, $data = null)
    {
        $json_data['status'] = $status;
        $json_data['responseCode'] = $responseCode;
        $json_data['message'] = $message;
        if ($data != "") {
            $json_data['list'] = $data;
        }
        return $json_data;
    }
}


?>