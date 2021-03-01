<?php
  function demo_app(){
    return false;
  }
	function show_date($date=''){
	$CI =& get_instance();
    if ($CI->session->userdata('view_date')=='dd/mm/yyyy') {
      return date('d/m/Y',strtotime(str_replace('/', '-', $date)));
    }
    elseif($CI->session->userdata('view_date')=='mm/dd/yyyy'){
      return date("m/d/Y",strtotime($date));
    }
    else{
      return date("d-m-Y",strtotime($date));
    }
  }
  function show_time($time=''){
    if(empty($time)){
      return $time;
    }
    $CI =& get_instance();
    if($CI->session->userdata('view_time')=='24') {
      return date('h:i',strtotime($time));
    }
    else{
      return date('h:i a',strtotime($time));
    }
  }

  function return_item_image_thumb($path=''){
    return str_replace(".", "_thumb.", $path);
  }

  /*Find the change return show in pos or not*/
  function change_return_status(){
    $CI =& get_instance();
    return $CI->db->select('change_return')->get('db_sitesettings')->row()->change_return;
  }

  function get_change_return_amount($sales_id){
    $CI =& get_instance();
    return $CI->db->select('coalesce(sum(change_return),0) as change_return_amount')->where('sales_id',$sales_id)->get('db_salespayments')->row()->change_return_amount;
  }

  function get_invoice_format_id(){
    $CI =& get_instance();
    return $CI->db->select('sales_invoice_format_id')->where('id',1)->get('db_sitesettings')->row()->sales_invoice_format_id;
  }
  function is_enabled_round_off(){
    $CI =& get_instance();
    $round_off=$CI->db->select('round_off')->where('id',1)->get('db_sitesettings')->row()->round_off;
    if($round_off==1){
      return true;
    }
    return false;
  }
  function get_profile_picture(){
    $CI =& get_instance();
    $profile_picture = $CI->db->select('profile_picture')->where("id",$CI->session->userdata('inv_userid'))->get('db_users')->row()->profile_picture;
    if(!empty($profile_picture)){
      $profile_picture = base_url($profile_picture);
    }
    else{
      $profile_picture = base_url("theme/dist/img/avatar5.png");
    }
    return $profile_picture;
  }
  function record_customer_payment($customer_id=null){
    $CI =& get_instance();
    $customer_id_str='';
    if(empty($customer_id)){
      $CI->db->query("delete from db_customer_payments"); 
    }
    else{
      $CI->db->query("delete from db_customer_payments where customer_id=$customer_id");
      $customer_id_str = " and b.customer_id=$customer_id ";
    }
    
    
    $q1 = $CI->db->query("INSERT INTO db_customer_payments (salespayment_id,customer_id,payment_date,payment_type, 
      payment,payment_note,
      system_ip,system_name,created_date,
      created_time,created_by, STATUS ) 
      SELECT a.id,b.customer_id,a.payment_date,a.payment_type, 
           COALESCE(SUM(a.payment)),a.payment_note,
           a.system_ip,a.system_name,a.created_date,a.created_time,a.created_by,1 FROM db_salespayments AS a, db_sales AS b WHERE b.id=a.sales_id $customer_id_str GROUP BY b.customer_id,a.payment_type,a.payment_date,a.created_time,a.created_date");
    if(!$q1){
      return false;
    }
    return true;
  }
 function record_supplier_payment($supplier_id=null){
    $CI =& get_instance();
    $supplier_id_str='';
    if(empty($supplier_id)){
      $CI->db->query("delete from db_supplier_payments"); 
    }
    else{
      $CI->db->query("delete from db_supplier_payments where supplier_id=$supplier_id");
      $supplier_id_str = " and b.supplier_id=$supplier_id ";
    }

    $q1 = $CI->db->query("INSERT INTO db_supplier_payments ( purchasepayment_id,supplier_id,payment_date,payment_type, payment,payment_note,system_ip,system_name,created_date,created_time,created_by, STATUS ) SELECT a.id,b.supplier_id,a.payment_date,a.payment_type, COALESCE(SUM(a.payment)),a.payment_note,a.system_ip,a.system_name,a.created_date,a.created_time,a.created_by,1 FROM db_purchasepayments AS a, db_purchase AS b 
      WHERE b.id=a.purchase_id $supplier_id_str GROUP BY b.supplier_id,a.payment_type,a.payment_date,a.created_time,a.created_date");
    if(!$q1){
      return false;
    }
    return true;
  }
  function calculate_inclusive($amount,$tax){
  $tot = ($amount/(($tax/100)+1)/10);
    return number_format($tot,2,".","");
  }
  function calculate_exclusive($amount,$tax){
    $tot = (($amount*$tax)/(100));
    return number_format($tot,2,".","");
  }
  function app_number_format($value=''){
    return (empty($value)) ? $value : number_format($value,2);
  }
  function show_upi_code(){
    $CI =& get_instance();
    return $CI->db->select('show_upi_code')->get('db_sitesettings')->row()->show_upi_code;
  }
  
  function cygen_product_img($imgCode){
       $img_array =json_encode(array('image_code' => $imgCode));
        $ch = curl_init('https://cygen.com.au/beta/retail_images/cygen_admin/cygenimg.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$img_array);
        // execute!
        $response = curl_exec($ch);
        $img_array=json_decode($response,true);
        if($img_array['success']==0){
            return $img_array['image'];
        }else{
            return base_url().'assets/img/noimage.png';
        }
   }
  
   function encryptPassword($pwd) {
        $key = "123";
        $admin_pwd = bin2hex(openssl_encrypt($pwd,'AES-128-CBC', $key));
        return $admin_pwd;
    }

    function decryptPassword($admin_password) {
        $key = "123";
        $admin_pwd = openssl_decrypt(hex2bin($admin_password),'AES-128-CBC',$key);
        return $admin_pwd;
    }
    function userLogin($user_email,$user_pwd) {
        $CI =& get_instance();
        $sql="SELECT * FROM  db_customers  WHERE (email = '$user_email' OR mobile = '$user_email') AND user_password = '$user_pwd' AND status = 1";
        $result = $CI->db->query($sql);        
        return $result;
    }
    
     function saveUser($user_full_name, $user_email, $user_mobile, $user_password) {
        //Save data into users table
         $CI =& get_instance();
        $created_at = date("Y-m-d h:i:s");
        $customer_code=rand(102030,45263);
        $sqlIns = "INSERT INTO db_customers (customer_code,email,mobile,user_password,status,customer_name) VALUES ('$customer_code','$user_email','$user_mobile','$user_password','1','$user_full_name')"; 
        if ($CI->db->query($sqlIns) === TRUE) {
            return 1;
        } else {
            return 0;
        } 
    }
    function forgotPassword($email) {
        $CI =& get_instance();
        $sql="SELECT * from db_customers WHERE email = '$email' ";
        $result = $CI->db->query($sql);
        return $result;
    }
  
    function sendEmail($to,$subject,$message,$from,$name) {
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  
        $headers .= 'From: '.$name.'<'.$from.'>'. "\r\n";
        if(mail($to, $subject, $message, $headers)) {
            return 0;
        } else {
            return 1;
        }

    }
    function getIndividualDetails($table,$clause,$id)  {
         $CI =& get_instance();
        $sql="select * from `$table` where `$clause` = '$id' ";
        $result = $CI->db->query($sql);
        $row = $result->row_array();        
        return $row;
    }
      function checkTime($time1,$time2)
{
  $start = strtotime($time1);
  $end = strtotime($time2);
  if ($start-$end > 0)
    return 1;
  else
   return 0;
}
 function getAllDataWhere($table,$clause,$value)  {
        $CI =& get_instance();
        $sql="select * from `$table` WHERE `$clause` = '$value' ";
        $result = $CI->db->query($sql);        
        return $result;
    }
    
     function getSingleColumnName($value,$column,$expColumn,$table){
        $CI =& get_instance();
        $sql="select $expColumn from `$table` WHERE $column = '$value'";
        $result = $CI->db->query($sql); 
        $row = $result->row_array();
      return $row[$expColumn];
    }
    function getSingleColumnNameorder($value,$column,$expColumn,$table){
        $CI =& get_instance();
        $sql="select $expColumn from `$table` WHERE $column = '$value' ORDER BY id desc";
        $result = $CI->db->query($sql); 
        $row = $result->row_array();
      return $row[$expColumn];
    }
   function distance($lat1, $lon1, $lat2, $lon2){
    $unit="K";
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);
  
    if ($unit == "K") {
     $ceil=ceil($miles * 1.609344);
          return $ceil;
    } else if ($unit == "N") {
        return ($miles * 0.8684);
      } else {
          return $miles;
        }
  }
  
  function new_random_number(){
        $length="8"; // Define length of the Random string.
        $char="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; // Define characters which you needs in your random string
        $random=substr(str_shuffle($char), 0, $length); // Put things together.
        return $random;
  }
   function userLoginWithmobileonly($user_email) {
        $CI =& get_instance();
        $sql="SELECT * FROM  db_customers  WHERE mobile = '$user_email' ";
        $result = $CI->db->query($sql);        
        return $result;
    }
    
      function generator($lenth)
    {
        $number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","1","2","3","4","5","6","7","8","9","0");
    
        for($i=0; $i<$lenth; $i++)
        {
            $rand_value=rand(0,34);
            $rand_number=$number["$rand_value"];
        
            if(empty($con))
            { 
            $con=$rand_number;
            }
            else
            {
            $con="$con"."$rand_number";}
        }
        return $con;
    }
    function date_view_format($date){
        return date("d-m-Y",strtotime($date));
    }
  function date_dob_format($date){
        return date("Y-m-d",strtotime($date));
    }