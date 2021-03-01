<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
class Pos extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('pos_model','pos_model');
		$this->load->helper('sms_template_helper');
	}
	public function is_sms_enabled(){
		return is_sms_enabled();
	}
	public function index()
	{ 
	    $this->session->unset_userdata('session_price_id');
	    $this->db->empty_table('db_pos_cart'); 
		$this->permission_check('sales_add');
		$ordId =$this->input->get('orderId')==''?'':$this->input->get('orderId');
		$data=$this->data;
		$data['page_title']='POS';
		$data['result'] = $this->get_hold_invoice_list();
		$data['last_invoice_link']=$this->get_last_invoice();
		$data['tot_count'] = $this->get_hold_invoice_count();
		$data['orderId'] = $ordId;
		$this->load->view('pos',$data);
	}
	//adding new item from Modal
	public function newcustomer(){
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
			$this->load->model('customers_model');
			$result=$this->customers_model->verify_and_save();
			//fetch latest item details
			$res=array();
			$query=$this->db->query("select id,customer_name from db_customers order by id desc limit 1");
			$res['id']=$query->row()->id;
			$res['customer_name']=$query->row()->customer_name;
			$res['result']=$result;
			
			echo json_encode($res);

		} 
		else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	public function get_details(){
		echo $this->pos_model->get_details();
	}
	public function getsubcat_details(){
	    	echo $this->pos_model->get_details();
	}
	public function receive_order(){
	    echo $this->pos_model->receive_order();
	}
	public function pos_save_update(){
	    $result='';
	    if($this->input->post('command')=='update'){//Update
	    	$result = $this->pos_model->pos_save_update();
	    }
	    else{//Save
	    	$result = $this->pos_model->pos_save_update();
		    $result =$result."<<<###>>>".$this->pos_model->get_details();
		    $result =$result."<<<###>>>".$this->pos_model->hold_invoice_list();
		    $q1=$this->db->query("SELECT * FROM temp_holdinvoice WHERE STATUS=1 GROUP BY invoice_id");
			$data['tot_count']=$q1->num_rows();
		    $result =$result."<<<###>>>".$q1->num_rows();
	    }
	    
	    echo $result;exit();
	}
	public function edit($sales_id){
		$this->permission_check('sales_edit');
	    $data=$this->data;
	    $data['sales_id']=$sales_id;
	    $data['page_title']='POS Update';
	    $data['result'] = $this->get_hold_invoice_list();
		$data['tot_count'] = $this->get_hold_invoice_count();
		$this->load->view('pos',$data);
	}
	public function fetch_sales($sales_id){
	    $result=$this->pos_model->edit_pos($sales_id);
	}
	/* ######################################## HOLD INVOICE ############################# */
	public function hold_invoice(){
		$reference_id=$this->input->get('reference_id')!=''?$this->input->get('reference_id'):rand(859674,159753);
		//sudhakar hold
		$hold_id =rand(1277,2377);
		$cashier_id=$this->session->userdata('inv_userid');    
		$zerorow=$this->db->query("select * from db_poscart_all where  cashier_id='$cashier_id'  order by id desc ");
		$newd=$zerorow->num_rows();
		$row_data=$zerorow->result_array();
		$o=0;
		foreach($row_data as $row){
			//RECEIVE VALUES FROM FORM
			$item_id 	= $row['item_id'];
			$data_array_latest = array(
				'hold_id'=>$hold_id,
				'reference_id'=>$reference_id,
				'item_id'=>$item_id,
				'cart_id'=>$row['cart_id'],
				'cat_id'=>$row['cat_id'],
				'qty'=>$row['qty'],
				'price'=>$row['price'],
				'offer_price'=>0,
				'group_id'=>0,
				'item_name'=>$row['item_name'],
				'total_price'=>$row['total_price'],
				'cashier_id'=>$row['cashier_id']
				);
				$cart_id =$row['cart_id'];
				$this->db->insert('db_pos_hold_all',$data_array_latest);
			//	echo "select * from db_pos_cart_addon  where item_id='$item_id' AND cashier_id='$cashier_id'";
			 $sql_addon_query=$this->db->query("select * from db_pos_cart_addon  where item_id='$item_id' AND cashier_id='$cashier_id'");
			if($sql_addon_query->num_rows() > 0){

			 $sql_addon=$sql_addon_query->result_array();
				foreach($sql_addon as $addon_row){
					$adon_id=$addon_row['addon_id'];
					$price=$addon_row['price'];
					$qty=$addon_row['qty'];
					$total_price=$addon_row['total_price'];
					$note=$addon_row['note']==''?'0':$addon_row['note'];
					$addon_name=$addon_row['addon_name'];
					$salesaddon_items_entry = array(
						'hold_id'=> $hold_id, 
						'item_id'=> $item_id, 
						'addon_id'=> $adon_id, 
						'price'=> $price,
						'qty'=> $qty,
						'total_price'=> $total_price,
						'note'=> $note,
						'customer_id'=>'1',
						'note'       =>$note,
						'user_id'=>$row['cashier_id']
					);
                
			$q20= $this->db->insert('db_hold_addon', $salesaddon_items_entry);
			  //  echo $this->db->last_query(); die;
				}
			}
		}
		$cashier_id=$this->session->userdata('inv_userid');
	   $mod_result =$this->db->query(" delete from db_poscart_all WHERE cashier_id='$cashier_id'");
		$mod_result_addon =$this->db->query(" delete from db_pos_cart_addon WHERE cashier_id='$cashier_id'");
        echo 1;
     
	  //  echo $this->pos_model->hold_invoice();
	}
	public function hold_invoice_list(){
		$data =array();
		$data['result'] = $this->get_hold_invoice_list();
		$data['tot_count'] = $this->get_hold_invoice_count();
		echo json_encode($data);
	}

	public function get_hold_invoice_list(){
		$data =array();
		$result= $this->pos_model->hold_invoice_list();
		return $result;
	}
	public function get_hold_invoice_count(){
		$q1=$this->db->query("SELECT * FROM temp_holdinvoice WHERE STATUS=1 GROUP BY invoice_id");
		return $q1->num_rows();
	}

	public function hold_invoice_delete($invoice_id){
		$result=$this->pos_model->hold_invoice_delete($invoice_id);
		echo trim($result);
	}
	public function hold_invoice_edit(){
		echo $this->pos_model->hold_invoice_edit();
	}
	public function add_payment_row(){
		return $this->load->view('modals_pos_payment/modal_payments_multi_sub');
	}
	//Print sales POS invoice 
	public function print_invoice_pos($sales_id){
		if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_invoice');
		$data=array_merge($data,array('sales_id'=>$sales_id));
		$this->load->view('sal-invoice-pos',$data);
	}
	public function get_last_invoice(){
    	$query=$this->db->query("select id from db_sales order by id desc limit 1");
    	if($query->num_rows() > 0){
		$id=$query->row()->id;
        if(isset($id)) {
        $id_invoice =$id;
        $url_invoice=$id_invoice;
        } else {
        $url_invoice="#";
        } }else{
            $url_invoice="#";
        } 
        return $url_invoice;
	}
	public function return_row_with_data($rowcount,$item_id){
		echo $this->pos_model->get_items_info($rowcount,$item_id);
	}
	public function get_search_details(){
		echo $this->pos_model->get_search_details();
	}
	public function add_product_cart(){
	   	$data=$this->data;
		extract($data);
		extract($_POST);
        $i=0;
        $str='';
        $min=102050;
        $max=205045;
		$cardid=rand($min,$max);
		$this->session->set_userdata('cart_pos',$cardid);
        $sales_price =$sales_price;
		$qtye =$qtye;  
		$user_id=$this->session->userdata('inv_userid');
		$yourArray=$_POST['yourArray'];
		$implode_item=implode(',',$yourArray);
		echo "SELECT * FROM `db_pos_cart_addon` where item_id='$id' AND 	addon_id IN($implode_item)";
		$cartaddon_sql=$this->db->query("SELECT * FROM `db_pos_cart_addon` where item_id='$id' AND 	addon_id IN($implode_item)");
		$newd_cart=$cartaddon_sql->num_rows(); 
		$zerorow=$this->db->query("select * from db_poscart_all where item_id='$id' AND cashier_id='$user_id'  order by id desc ");
		$newd=$zerorow->num_rows(); 
       if($newd > 0 && $newd_cart > 0){
         $sql_data=$this->db->query("update db_poscart_all set qty=qty+1 where item_id='$id'");
		}else{
			$data_array = array(
			'item_id'=>$id,
			'cart_id'=>$cardid,
			'qty'=>1,
			'price'=>$sales_price,
			'cashier_id'=>$user_id
			);
			$cat_id = getSingleColumnName($id,'id','category_id','db_items');
			$item_name = getSingleColumnName($id,'id','item_name','db_items');
			$data_array_latest = array(
			'item_id'=>$id,
			'cart_id'=>$cardid,
			'cat_id'=>$cat_id,
			'qty'=>$qtye,
			'price'=>$sales_price,
			'offer_price'=>0,
			'group_id'=>0,
			'item_name'=>$item_name,
			'total_price'=>$qtye*$sales_price,
			'cashier_id'=>$user_id
			);
			$this->db->insert('db_poscart_all',$data_array_latest);
	}
	
	print_r($yourArray);
        //echo 1;
      
	}
	
//update Qty 
public function updateQty(){
	$data=$this->data;
	extract($data);
	extract($_POST);
	 $updatetype=$updatetype!=""?$updatetype:1;
	 $cashier_id=$this->session->userdata('inv_userid');
	IF($updatetype==1){
		$zerorow=$this->db->query("select * from db_poscart_all where item_id='$id' and cashier_id='$cashier_id'  order by id desc ");
		$newd=$zerorow->num_rows(); 
		if($newd > 0){
		$row=$zerorow->row_array();
		$tot_qty= $row['qty']+1;  
        $amount=$row['price']*$tot_qty; 
		$sql_data=$this->db->query("update db_poscart_all set qty=qty+1,total_price='$amount' where item_id='$id' and cashier_id='$cashier_id' ");
		  
		}	
	}else{
		$zerorow=$this->db->query("select sum(qty) as total_qty,price as price_cart from db_poscart_all where item_id='$id' and cashier_id='$cashier_id'");
		$newd=$zerorow->num_rows();
		$total_result=$zerorow->row() ;
		$total_qty=$total_result->total_qty;
		if($total_qty > 1){
			//$row=$zerorow->row_array();
			$tot_qty= $total_qty-1;  
			$amount=$total_result->price_cart*$tot_qty; 
			$sql_data=$this->db->query("update db_poscart_all set qty=qty-1,total_price='$amount' where item_id='$id' and cashier_id='$cashier_id' ");
		}else{
			$sql_data=$this->db->query("delete from  db_poscart_all  where item_id='$id' and cashier_id='$cashier_id' ");
			$sql_data2=$this->db->query("delete from  db_pos_cart_addon  where item_id='$id' and cashier_id='$cashier_id' ");
		}
	}
}	
public function cart_detail(){	
	$cashier_id=$this->session->userdata('inv_userid');    
	$zerorow=$this->db->query("select * from db_poscart_all where  cashier_id='$cashier_id'  order by id desc ");
	$newd=$zerorow->num_rows();
	$row_data=$zerorow->result_array();
	$o=0;
	foreach($row_data as $row){

	?>
	  <tr class="car_<?php echo $row['item_id']; ?>" id="row_0" data-row="0" data-item-id="<?php echo $row['item_id']; ?>">
   <!--<td class="srl_number"><?php echo $newd-$o; ?></td>-->
   <td style="width:50%" class="caritemname_<?php echo $row['item_id']; ?>" id="td_0_0"><a class="pointer item-name-pos text-truncate" id="td_data_0_0"><?php echo substr($row['item_name'],0,35).'...'; ?></a> <span id="spandesc<?php echo $row['item_id']; ?>"></span><i rowcnt="0" id="<?php echo $row['item_id']; ?>" class="edit-icon short_desc fa fa-pencil-square-o" aria-hidden="true&quot;"></i></td>
   <td style="display:none" id="td_0_1">1500000.00</td>
   
   <td id="td_0_3" class="text-right"><input id="sales_price_0" onblur="set_to_original(0,<?php echo $row['price']; ?>)" onclick="show_discount_item_modal(0)" onkeyup="update_price(0,<?php echo $row['total_price']; ?>)" name="sales_price_0" type="text" class="form-control no-padding " value="<?php echo $row['price']; ?>"></td>
  <td id="td_0_2">
      <div class="input-group input-group-sm"><span class="input-group-btn"><button id="dr0" onclick="decrement_qty(<?php echo $row['item_id']; ?>,0)" type="button" class="counter-increment"><i class="lnr lnr-circle-minus"></i></button></span><input readonly="readonly" typ="text" value="<?php echo $row['qty']; ?>" class="form-control no-padding text-center qty-incr-control" id="item_qty_<?php echo $row['item_id']; ?>" name="item_qty_<?php echo $row['item_id']; ?>"><span class="input-group-btn"><button id="in0" onclick="increment_qty(<?php echo $row['item_id']; ?>,0)" type="button" class="counter-increment"><i class="lnr lnr-plus-circle"></i></button></span></div>
   </td>
   <td style="display:none" id="td_0_11"><input data-toggle="tooltip" title="Click to Change" id="td_data_0_11" onclick="show_sales_item_modal(0)" name="td_data_0_11" type="text" class="form-control no-padding pointer" readonly="" value="0.00"></td>
   <td id="td_0_4" class="text-right caritemprice_<?php echo $row['item_id']; ?>"><input data-toggle="tooltip" title="Total" id="td_data_0_4" name="td_data_0_4" type="text" class="form-control no-padding pointer" readonly="" value="<?php echo $row['total_price']; ?>"></td>
   <td style="display:none" id="td_0_8" class="text-right"><input type="text" name="td_data_0_8" id="td_data_0_8" class="form-control text-right no-padding only_currency text-center item_discount " value="0"></td>
   <td style="display:none" id="td_0_5"><a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="removerow(0)" title="Delete Item?"></a></td>
   <input type="hidden" name="tr_item_id_0" id="tr_item_id_0" value="<?php echo $row['item_id']; ?>">
   <input type="hidden" id="tr_sales_price_temp_0" name="tr_sales_price_temp_0" value="<?php echo $row['total_price']; ?>">
   <input type="hidden" id="tr_sales_price_temp2_0" name="tr_sales_price_temp2_0" value="<?php echo $row['total_price']; ?>">
   <input type="hidden" id="tr_tax_type_0" name="tr_tax_type_0" value="Exclusive">
   <input type="hidden" id="tr_tax_id_0" name="tr_tax_id_0" value="4">
   <input type="hidden" id="tr_tax_value_0" name="tr_tax_value_0" value="0.00"><input type="hidden" id="description_0" name="description_0" value=""><input type="hidden" id="refund_id_0" name="refund_id_0" value="0">
   <input type="hidden" id="refund_type_0" name="refund_type_0" value="0">
   <td width="10%" class="text-center "><span style="cursor:pointer;"  onclick="remove_item(<?php echo $row['id']; ?>)" class="lnr lnr-trash trash-icon"></span></td>
</tr>
	<?php
	$addonaall=0;
	$item_ids=$row['item_id'];
	 $sql_addon_query=$this->db->query("select * from db_pos_cart_addon where item_id='$item_ids'");
	 $sql_addon=$sql_addon_query->result_array();

	 foreach($sql_addon as $addon_row){
		 $addonaall=$addonaall+$addon_row['total_price'];
   ?>
	<tr>
	
	<td><span style="color:#337ab7;margin-left:10px"><?php echo $addon_row['addon_name']; ?></span></td>

	<td><span class="text-center" style="color:#337ab7"><center><?php echo $addon_row['total_price']; ?></center></span></td>
    	<td><div class="input-group input-group-sm"><span class="input-group-btn"><button id="dr0" onclick="decrement_qty_addon(<?php echo $addon_row['id']; ?>,0)" type="button" class="counter-increment"><i class="lnr lnr-circle-minus"></i></button></span><input readonly="readonly" typ="text" value="<?php echo $addon_row['qty']; ?>" class="form-control no-padding text-center qty-incr-control" id="item_qty_addon<?php echo $addon_row['id']; ?>" name="item_qty_<?php echo $addon_row['id']; ?>"><span class="input-group-btn"><button id="in0" onclick="increment_qty_addon(<?php echo $addon_row['id']; ?>,0)" type="button" class="counter-increment"><i class="lnr lnr-plus-circle"></i></button></span></div></td>
	<td><span class="text-center" style="color:#337ab7"><center><?php echo $addon_row['total_price']; ?></center></span></td>
	<td width="10%" class="text-center "><span style="cursor:pointer;"  onclick="remove_item_addon(<?php echo $addon_row['id']; ?>)" class="lnr lnr-trash trash-icon"></span></td>
	</tr>
	<?php
	 }
	 $o++;
	}
}

public function cart_summery(){	  
	$cashier_id=$this->session->userdata('inv_userid');    
	$zerorow=$this->db->query("select count(*) as total_qty ,sum(total_price) as total_amount,total_discount as all_discount from db_poscart_all  where cashier_id='$cashier_id'");
	$newd=$zerorow->num_rows();
	if($newd > 0){
	        $row_data=$zerorow->row_array();
	    	$zerorow2=$this->db->query("select count(*) as total_qty2 ,sum(total_price) as total_amount2 from db_pos_cart_addon  where cashier_id='$cashier_id'");
      	   $newd2=$zerorow2->num_rows();
	       $row_data2=$zerorow2->row_array();
		   $all_amount = ($row_data['total_amount']+$row_data2['total_amount2'])-$row_data['all_discount'];
		echo $row_data['total_qty'].'~'.$all_amount.'~'.($all_amount+$row_data['all_discount']);
	}else{
		echo"0~0~0";
	}
	
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	public function family_offer_details(){
		    
	}
 
 
    public function subcatList(){
    $CI = & get_instance();
    $this->load->model('subcategory_model','subcategory');
    $cat_id = $this->input->post('catId');
     $subcatList = $this->subcategory->subcat_by_Category($cat_id);
    $data['subcatList']  = $subcatList;
    $this->load->view('subcatpos_list_ajax',$data);
    }
    
    
     public function cashout(){
        $CUR_DATE=date('Y-m-d');
        $CUR_TIME=date('H:i:s');
        $cash_type=$_POST['cash_type'];
        if($cash_type==1){
            
            $user_id11= $this->session->userdata('inv_userid');
			$amount_cashout = $this->input->post('amount_cashout');
		    $cashout_desc   = $this->input->post('cashout_desc')!=''?$this->input->post('cashout_desc'):'0';
    		$q1=$this->db->simple_query("INSERT into db_cash_in(amount,user_id,
    			created_date,created_time,detail_desc)
				VALUES
				('$amount_cashout','$user_id11',
				'$CUR_DATE','$CUR_TIME','$cashout_desc')");
				$last=$this->db->insert_id();
				if($last > 0){
				   echo 3;  
				}else{
				    echo'0';
				}
           
            
        }else{
        $CI = & get_instance();
        $user_id=$this->session->userdata('inv_userid');
        $date_payment=date('Y-m-d');
        $amount_cashout = $this->input->post('amount_cashout');
        $cashout_desc   = $this->input->post('cashout_desc');
        $detail_desc=$this->input->post('detail_desc');
        $q1=$this->db->simple_query("INSERT into db_cashout_middle_middle(amount,user_id,
    			created_date,created_time,detail_desc)
				VALUES
				('$amount_cashout','$user_id',
				'$CUR_DATE','$CUR_TIME','$cashout_desc')");
        
        $last=$this->db->insert_id();
				if($last > 0){
				   echo 1;  
				}else{
				    echo'0';
				}
        
        
        }
        
    }
    
    
     public function shiftout(){
        
        $cash_type=$_POST['cash_type'];
        if($cash_type==1){
            $CUR_DATE=date('Y-m-d');
            $CUR_TIME=date('H:i:s');
            $user_id11= $this->session->userdata('inv_userid');
			$amount_cashout = $this->input->post('amount_cashout');
		    $cashout_desc   = $this->input->post('cashout_desc')!=''?$this->input->post('cashout_desc'):'0';
    		$q1=$this->db->simple_query("INSERT into db_cash_in(amount,user_id,
    			created_date,created_time,detail_desc)
				VALUES
				('$amount_cashout','$user_id11',
				'$CUR_DATE','$CUR_TIME','$cashout_desc')");
           echo 3; 
            
        }else{
        $CI = & get_instance();
        $user_id=$this->session->userdata('inv_userid');
        $date_payment=date('Y-m-d');
        $amount_cashout = $this->input->post('amount_cashout');
         $cashout_desc   = $this->input->post('cashout_desc');
         $detail_desc=$this->input->post('detail_desc');
        $sql_cashier=$this->db->query("select sum(card_payment) as all_card_payment,sum(cash_payment) as all_cash_payment from db_cashier_transaction where user_id='$user_id' AND date_payment='$date_payment' AND draw_session='0' ORDER BY id desc ");
        $countrecod=$sql_cashier->num_rows();
        if($countrecod > 0){
        $data=$sql_cashier->row_array();
         $card_payment=$data['all_card_payment']!="0"?$data['all_card_payment']:0;
         
         $cash_payment=$data['all_cash_payment']!="0"?$data['all_cash_payment']:0;
        
        $sql_dats=$this->db->query("select sum(amount) as all_amount from db_cash_in where user_id='$user_id' AND created_date='$date_payment' ORDER BY id ");
        //echo  $this->db->last_query(); die;
        $row=$sql_dats->row_array();
       
         $amount=$row['all_amount'];
         
         $sql_dats_cash_middle=$this->db->query("select sum(amount) as all_amount from db_cashout_middle_middle where user_id='$user_id' AND created_date='$date_payment' AND draw_session='0' ORDER BY id ");
        //echo  $this->db->last_query(); die;
        $row_middle=$sql_dats_cash_middle->row_array();
        $amount_middle=$row_middle['all_amount'];
        $allamount=$amount+$card_payment+$cash_payment;
        $allcashout=$amount_middle+$amount_cashout;
        if($allamount!='' && $allamount > 0 && $amount_cashout > 0 && $allcashout==$allamount)
        {
             $CUR_TIME=date('H:i:s');
            $data_array=array(
                       'user_id'=>$user_id,
                       'amount'=>$allamount,
                       'cashout_status'=>1,
                       'date'=>$date_payment,
                       'created_time'=>$CUR_TIME,
                       'detail_desc'=>$detail_desc
                       );
                   $q788 = $this->db->insert('db_cashout', $data_array);
                   $sql_cashier_update=$this->db->query("UPDATE  db_cashier_transaction SET draw_session='1' where user_id='$user_id' AND date_payment='$date_payment'"); 
                  $sql_cashier_middle=$this->db->query("UPDATE  db_cashout_middle_middle SET draw_session='1' where user_id='$user_id' AND date_payment='$date_payment'");
   
            echo 1;
           //	redirect(base_url('Logout'));
        }else{
           // echo 0;
        }
        
        }else{
           // echo  0;
        }
        }
        
    }
    
    
    
    
    public function void_cart()
	{
	    $this->db->empty_table('db_pos_cart'); 
		
	}
	
	public function product_modifier(){
        
	   // $mod_id=3;
	    $data=$this->data;
		extract($data);
		extract($_POST);
		$mod_id=$id;
        $mod_result_group =$this->db->query(" select  * FROM db_item_group WHERE  item_id='$mod_id' AND status='1' ");
        $numrows_group=$mod_result_group->num_rows();
        if($numrows_group > 0){
        $item_modifier=$mod_result_group->result_array();
         foreach ($item_modifier as $key => $field) {
	        $modifiergroup_id=$field['id'];
	        $modifiergroup_nameid=$field['modifiergroup_id'];
	         $groupName=getSingleColumnName($modifiergroup_nameid,'id','modifiergroup_name','db_modifier_group');
	          $item_modifier[$key]['modifier_name'] =$groupName;
	        $item_modifier[$key]['modifier'] =self::group_modifier($mod_id,$modifiergroup_id);
	       
	    }
            $product_name=getSingleColumnName($mod_id,'id','item_name','db_items');
             
            if($this->session->userdata('session_price_id')!=""){
                if($this->session->userdata('session_price_id')==6){
                $saleprice=getSingleColumnName($mod_id,'id','price6','db_items');
                }else if($this->session->userdata('session_price_id')==7){
                $saleprice=getSingleColumnName($mod_id,'id','price7','db_items');
                }else if($this->session->userdata('session_price_id')==8){
                $saleprice=getSingleColumnName($mod_id,'id','price8','db_items');
                }else{
                $saleprice=getSingleColumnName($mod_id,'id','sales_price','db_items');
                }
                }else{
                $saleprice=getSingleColumnName($mod_id,'id','sales_price','db_items');
                }

           $product_price=$saleprice;
		   $data['item_modifier']=$item_modifier;
		   $data['item_name']=$product_name;
		   $data['item_price']=$product_price;
		   $data['item_products_all']=$mod_id;
	      $this->load->view('modals/modifer',$data);
        }else{
            echo 1;
        }
        
      
    }
    public function group_modifier($id,$groupid){
         $mod_result =$this->db->query(" select  * FROM db_items_modifier WHERE  item_id='$id' AND item_group_id='$groupid' AND status='1' ");
        $numrows=$mod_result->num_rows();
        if($numrows > 0){
            $list_modifier =$mod_result->result_array();
		    return $list_modifier;
        }
    }
	public function voidCart(){
		$cashier_id=$this->session->userdata('inv_userid');
	    $mod_result =$this->db->query(" delete from db_poscart_all WHERE cashier_id='$cashier_id'");
		$mod_result_addon =$this->db->query(" delete from db_pos_cart_addon WHERE cashier_id='$cashier_id'");
		// echo $this->db->last_query(); die;
		if($mod_result){
		   echo 1 ;
	   }else{
		   echo 0;
	   }
   }

   public function addonsave_cart(){

	$cashier_id  =$this->session->userdata('inv_userid');
	$cart_pos =$this->session->userdata('cart_pos');
    $product_id   = $_POST['productId'];
    $addon_price  = $_POST['addon_price'];
    $addon_name   = $_POST['addon_name'];
    $addon_id     = $_POST['addon_id'];
    $qty          = $_POST['qty'];
    $note         = $_POST['note'];
   $selCnt = " * FROM db_pos_cart_addon WHERE item_id='$product_id' AND addon_id = '$addon_id' AND cashier_id='$cashier_id' ";
    $this->db->select($selCnt);
    $query = $this->db->get();
   
   $getQun=$query->row_array();
    if($query->num_rows() > 0){
       
        $product_quantity = $getQun['qty']+$qty;
        $total_price=$getQun['total_price']+$addon_price; 
        $saveItems ="UPDATE db_pos_cart_addon SET qty='$product_quantity',total_price='$total_price' WHERE item_id='$product_id' AND addon_id = '$addon_id' AND cashier_id='$cashier_id'"; 	
    } else {
          $total_price=$_POST['qty']*$addon_price;
          $product_quantity = $_POST['qty'];
          $saveItems = "INSERT INTO `db_pos_cart_addon`(`cashier_id`, `cart_id`,`item_id`,`addon_name`,`price`,`addon_id`,`qty`,`total_price`,`note`) VALUES ('$cashier_id','$cart_pos','$product_id','$addon_name','$addon_price','$addon_id','$qty','$total_price','$note')"; 	
        }
        $saveCart =$this->db->query($saveItems);
    } 

    public function pos_place_order(){
		$cashier_id  =$this->session->userdata('inv_userid');
		$cart_pos =$this->session->userdata('cart_pos');
		$table_number = $_POST['table_number'];
		$order_type = $_POST['order_type'];
		$CUR_DATE=date('Y-m-d');
        $CUR_TIME=date('H:i:s');
        $SYSTEM_NAME=$_SERVER['REMOTE_ADDR'];
        $CUR_USERNAME==$this->session->userdata('inv_userid'); 
        $SYSTEM_IP=$_SERVER['REMOTE_ADDR'];
        $all_amount=0;
		$ord= $_POST['order_number']!='0'?$_POST['order_number']:'0';
		if($ord!='' && $ord!='0'){
			$sql_data =$this->db->query("select * from db_sales where id='$ord'");
			$data_row=$sql_data->row_array();
			$subtotal=$data_row['subtotal'];
			$grand_total = $data_row['grand_total'];
			$sales_id=$data_row['id'];
			$zerorow=$this->db->query("select count(*) as total_qty ,sum(total_price) as total_amount from db_poscart_all WHERE cashier_id='$cashier_id' ");
			$newd=$zerorow->num_rows();
			$row_data=$zerorow->row_array();
			
			$zerorow2=$this->db->query("select count(*) as total_qty2 ,sum(total_price) as total_amount2 from db_pos_cart_addon  where cashier_id='$cashier_id'");
            $newd2=$zerorow2->num_rows();
            $row_data2=$zerorow2->row_array();
            $all_amount = $row_data['total_amount']+$row_data2['total_amount2'];
			
			
			
			$tot_grand = $all_amount+$grand_total;
			$tot_amt =   $all_amount+$grand_total;
			$tot_grand 		= (empty($tot_grand)) ? 'NULL' : $tot_grand;
            $sales_date 		=date("Y-m-d h:i:s");
			// update records 
			$sales_entry = array(
			'sales_date' 				=> $sales_date,
			/*Subtotal & Total */
			'subtotal' 					=> $tot_amt,
			'round_off' 				=> $round_off,
			'grand_total' 				=> $tot_grand,
			);
	        $q3 = $this->db->where('id',$sales_id)->update('db_sales', $sales_entry);

            if($sales_id) {
                $q45=$this->db->query("select coalesce(max(kot_number),0)+1 as maxkot from db_salesitems");
                 $kot_number_db=$q45->row()->maxkot;
				 $kot_number =$kot_number_db!=''?$kot_number_db:rand(12,23);
				$cashier_id=$this->session->userdata('inv_userid');    
				$zerorow=$this->db->query("select * from db_poscart_all where  cashier_id='$cashier_id'  order by id desc ");
				$newd=$zerorow->num_rows();
				$row_data=$zerorow->result_array();
				$o=0;
				$item_amount_all=0;
				foreach($row_data as $row){
					//RECEIVE VALUES FROM FORM
					$item_id 	= $row['item_id'];
					$catid      = getSingleColumnName($item_id,'id','category_id','db_items');
					$sales_qty 	=$row['qty'];
					$price_per_unit =$row['price'];
					$tax_amt =NULL;
					$tax_type ='Inclusive';
					$tax_id =3;
					$tax_value =0;//%
					$total_cost =$row['total_price'];
					$description =0;
					$refund_id=0;
					$refund_type=NULL;
					$unit_discount_per	=0;
					if($tax_type=='Exclusive'){
						$single_unit_total_cost = $price_per_unit + ($tax_value * $price_per_unit / 100);
					}
					else{//Inclusive
						$single_unit_total_cost =$price_per_unit;
					}
					$discount_amt 		=$discount_amt > 0 ?($sales_qty * $price_per_unit)*$unit_discount_per/100:'0';
					if($tax_id=='' || $tax_id==0){$tax_id=null;}
					if($tax_amt=='' || $tax_amt==0){$tax_amt=null;}
					if($total_cost=='' || $total_cost==0){$total_cost=null;}
					if(!empty($discount_to_all_input) && $discount_to_all_input!=0){
						$unit_discount_per =null;
						$discount_amt =null;
					}
					if(!empty($discount_to_all_input) && $discount_to_all_input!=0){
						$discount_amt =null;
					}
					/* ******************************** */
					$salesitems_entry = array(
								'sales_id' 			=> $sales_id, 
								'sales_status'		=> 'Final', 
								'item_id' 			=> $item_id, 
								'description' 		=> $description, 
								'sales_qty' 		=> $sales_qty,
								'price_per_unit' 	=> $price_per_unit,
								'tax_id' 			=> $tax_id,
								'tax_amt' 			=> $tax_amt,
								'tax_type' 			=> $tax_type,
								'unit_discount_per' => $unit_discount_per,
								'discount_amt' 		=> $discount_amt,
								'unit_total_cost' 	=> $single_unit_total_cost,
								'total_cost' 		=> $total_cost,
								'status'	 		=> 1,
								'kot_number'        =>$kot_number,
								'cat_id'            =>$catid
							);
					$q4 = $this->db->insert('db_salesitems', $salesitems_entry);
	                $item_amount_all=$item_amount_all+$total_cost;
					$sql_addon_query=$this->db->query("select * from db_pos_cart_addon  where item_id='$item_id' AND cashier_id='$cashier_id'");
					if($sql_addon_query->num_rows() > 0){
					  $item_amount_all_addon=0; 
					 $sql_addon=$sql_addon_query->result_array();
						foreach($sql_addon as $addon_row){
							$adon_id=$addon_row['addon_id'];
							$price=$addon_row['price'];
							$qty=$addon_row['qty'];
							$total_price=$addon_row['total_price'];
							$note=$addon_row['note']==''?'0':$addon_row['note'];
							$addon_name=$addon_row['addon_name'];
							$salesaddon_items_entry = array(
								'sales_id'=> $sales_id, 
								'item_id'=> $item_id, 
								'addon_id'=> $adon_id, 
								'price'=> $price,
								'qty'=> $qty,
								'total_price'=> $total_price,
								'note'=> $note,
								'customer_id'=>'1',
								'note'       =>$note
							);
	                   $item_amount_all_addon=$item_amount_all_addon+$total_price;
					$q20= $this->db->insert('db_sales_addon_detail', $salesaddon_items_entry);
					  //  echo $this->db->last_query(); die;
						}
					}
				}
				
				
				
				
		}

			}else{
			    $all_amount22=0;
			$zerorow=$this->db->query("select count(*) as total_qty ,sum(total_price) as total_amount from db_poscart_all WHERE cashier_id='$cashier_id' ");
			$newd=$zerorow->num_rows();
			$row_data=$zerorow->row_array();
			$order_number='ORD'.rand(100,200);
	        
	                    $zerorow2=$this->db->query("select sum(total_price) as total_amount22 from db_pos_cart_addon  where cashier_id='$cashier_id'");
                        $newd2=$zerorow2->num_rows();
                        $row_data22=$zerorow2->row_array();
                         $all_amount22 = $row_data['total_amount']+$row_data22['total_amount22']; 
			//save order 
			
			$sales_date 		=date("Y-m-d h:i:s");
			//$points 			= (empty($points_use)) ? 'NULL' : $points_use;
			$discount_input 	= NULL;
			$tot_disc 		= NULL;
	
			$tot_grand = $all_amount22;
			$tot_amt =   $all_amount22;
			$tot_grand 		= (empty($tot_grand)) ? 'NULL' : $tot_grand;
			//$tot_grand		=round($tot_amt);
			$round_off = number_format($tot_grand-$tot_amt,2,'.','');
	
			$q1=$this->db->query("select customer_name,mobile from db_customers where id=1");
			$customer_name 	= $q1->row()->customer_name;
			$mobile 		= $q1->row()->mobile;
			
			// sales insert
	
			//GET SALES INITIAL
			$q5=$this->db->query("select sales_init from db_company where id=1");
			$init=$q5->row()->sales_init;	
			
	
			//ORDER SALES CREATION
			$maxid=$this->db->query("SELECT COALESCE(MAX(id),0)+1 AS maxid FROM db_sales")->row()->maxid;
			$sales_code=$init.str_pad($maxid, 4, '0', STR_PAD_LEFT);
	
			$sales_entry = array(
							'sales_code' 				=> $sales_code, 
							'sales_date' 				=> $sales_date,
							'sales_status' 				=> 'Running',
							'customer_id' 				=> 1,
							/*'warehouse_id' 				=> $warehouse_id,*/
							/*Discount*/
							'discount_to_all_input' 	=> $discount_input,
							'discount_to_all_type' 		=> $discount_type,
							'tot_discount_to_all_amt' 	=> $tot_disc,
							/*Subtotal & Total */
							'subtotal' 					=> $tot_amt,
							'round_off' 				=> $round_off,
							'grand_total' 				=> $tot_grand,
							/*System Info*/
							'created_date' 				=> $CUR_DATE,
							'created_time' 				=> $CUR_TIME,
							'created_by' 				=> $CUR_USERNAME,
							'system_ip' 				=> $SYSTEM_IP,
							'system_name' 				=> $SYSTEM_NAME,
							'pos' 						=> 1,
							'status' 					=> 1,
							'is_order_running'          => 1,
							'table_number'              => $table_number,
							'order_number'              => $order_number 
						);
	
			$q3 = $this->db->insert('db_sales', $sales_entry);
			$sales_id = $this->db->insert_id();
			if($sales_id) {
			    $q45=$this->db->query("select coalesce(max(kot_number),0)+1 as maxkot from db_salesitems");
				$kot_number_db=$q45->row()->maxkot;
				$kot_number =$kot_number_db!=''?$kot_number_db:rand(12,23);
				$cashier_id=$this->session->userdata('inv_userid');    
				$zerorow=$this->db->query("select * from db_poscart_all where  cashier_id='$cashier_id'  order by id desc ");
				$newd=$zerorow->num_rows();
				$row_data=$zerorow->result_array();
				$o=0;
				foreach($row_data as $row){
					//RECEIVE VALUES FROM FORM
					$item_id 	= $row['item_id'];
					$catid      = getSingleColumnName($item_id,'id','category_id','db_items');
					$sales_qty 	=$row['qty'];
					$price_per_unit =$row['price'];
					$tax_amt =NULL;
					$tax_type ='Inclusive';
					$tax_id =3;
					$tax_value =0;//%
					$total_cost =$row['total_price'];
					$description =0;
					$refund_id=0;
					$refund_type=NULL;
					$unit_discount_per	=0;
					if($tax_type=='Exclusive'){
						$single_unit_total_cost = $price_per_unit + ($tax_value * $price_per_unit / 100);
					}
					else{//Inclusive
						$single_unit_total_cost =$price_per_unit;
					}
					$discount_amt 		=$discount_amt > 0 ?($sales_qty * $price_per_unit)*$unit_discount_per/100:'0';
					if($tax_id=='' || $tax_id==0){$tax_id=null;}
					if($tax_amt=='' || $tax_amt==0){$tax_amt=null;}
					if($total_cost=='' || $total_cost==0){$total_cost=null;}
					if(!empty($discount_to_all_input) && $discount_to_all_input!=0){
						$unit_discount_per =null;
						$discount_amt =null;
					}
					if(!empty($discount_to_all_input) && $discount_to_all_input!=0){
						$discount_amt =null;
					}
					/* ******************************** */
					$salesitems_entry = array(
								'sales_id' 			=> $sales_id, 
								'sales_status'		=> 'Final', 
								'item_id' 			=> $item_id, 
								'description' 		=> $description, 
								'sales_qty' 		=> $sales_qty,
								'price_per_unit' 	=> $price_per_unit,
								'tax_id' 			=> $tax_id,
								'tax_amt' 			=> $tax_amt,
								'tax_type' 			=> $tax_type,
								'unit_discount_per' => $unit_discount_per,
								'discount_amt' 		=> $discount_amt,
								'unit_total_cost' 	=> $single_unit_total_cost,
								'total_cost' 		=> $total_cost,
								'status'	 		=> 1,
								'kot_number'        =>$kot_number,
								'cat_id'            =>$catid
							);
					$q4 = $this->db->insert('db_salesitems', $salesitems_entry);
	
					$sql_addon_query=$this->db->query("select * from db_pos_cart_addon  where item_id='$item_id' AND cashier_id='$cashier_id'");
					if($sql_addon_query->num_rows() > 0){
					   
					 $sql_addon=$sql_addon_query->result_array();
						foreach($sql_addon as $addon_row){
							$adon_id=$addon_row['addon_id'];
							$price=$addon_row['price'];
							$qty=$addon_row['qty'];
							$total_price=$addon_row['total_price'];
							$note=$addon_row['note']==''?'0':$addon_row['note'];
							$addon_name=$addon_row['addon_name'];
							$salesaddon_items_entry = array(
								'sales_id'=> $sales_id, 
								'item_id'=> $item_id, 
								'addon_id'=> $adon_id, 
								'price'=> $price,
								'qty'=> $qty,
								'total_price'=> $total_price,
								'note'=> $note,
								'customer_id'=>'1',
								'note'       =>$note
							);
	
					$q20= $this->db->insert('db_sales_addon_detail', $salesaddon_items_entry);
					  //  echo $this->db->last_query(); die;
						}
					}
				}
		}
        


	
		} 
		
      
			$cashier_id=$this->session->userdata('inv_userid');
			$mod_result =$this->db->query(" delete from db_poscart_all WHERE cashier_id='$cashier_id'");
			$mod_result_addon =$this->db->query(" delete from db_pos_cart_addon WHERE cashier_id='$cashier_id'");
	        echo $sales_id;
	    

	}

	public function print_kot_pos($sales_id){
		// echo   "update db_sales set order_view=0  where order_view=1 AND id='$sales_id'";
		  $sql23 =$this->db->query("update db_sales set order_view=0  where order_view=1 AND id='$sales_id'");
		  // self::fun2($sales_id);
		  self::fun1($sales_id);
		  $sql23 =$this->db->query("update db_salesitems set kot_print=1  where  sales_id='$sales_id'");

	}
    	public function fun2($sales_id){
	    		if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_invoice');
		
		$kitchen_kot=array();
		$coff_kot=array();
		// echo "select cat_id from db_salesitems where 'sales_id'=$sales_id";
		$query_cat=$this->db->query("select cat_id from db_salesitems where sales_id=$sales_id");
		$row=$query_cat->result_array();
		foreach($row  as $rowitem){
		   
		    $catid=$rowitem['cat_id'];
		    $kottype=getSingleColumnName($catid,'id','kot_type','db_category');
		    if($kottype==0){
		        $kitchen_kot[]=$catid;
		    }else{
		      $coff_kot[]=$catid;  
		    }
		}
	
		if(count($coff_kot) > 0){
		    flush(); //this sends the output to the client. You may also need ob_flush();
            sleep(1); //wait 10 seconds 
		    $data=array_merge($data,array('kot_cat'=>$coff_kot));
	    	$data=array_merge($data,array('sales_id'=>$sales_id));
	    	$this->load->view('kot-invoice-pos',$data);
		}
	}	 
	public function fun1($sales_id){
       
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_invoice');
		
		$kitchen_kot=array();
		$coff_kot=array();
		// echo "select cat_id from db_salesitems where 'sales_id'=$sales_id";
		$query_cat=$this->db->query("select cat_id from db_salesitems where sales_id=$sales_id AND kot_print=0 ");
		$row=$query_cat->result_array();
		foreach($row  as $rowitem){
		   
		    $catid=$rowitem['cat_id'];
		    $kottype=getSingleColumnName($catid,'id','kot_type','db_category');
		    if($kottype==0){
		        $kitchen_kot[]=$catid;
		    }else{
		     // $coff_kot[]=$catid;  
		    }
		}
		
	if(count($kitchen_kot) > 0){
		    $data=array_merge($data,array('kot_cat'=>$kitchen_kot));
		    $data=array_merge($data,array('sales_id'=>$sales_id));
	   	    $this->load->view('kot-invoice-pos_second',$data);
		}
		
	}
    public function table_number(){
		$id = $_POST['currentid'];
		$sql_data =$this->db->query("select table_number from db_sales where id='$id'");
		$row=$sql_data->row_array();
		echo $row['table_number'];
	}
	
    public function cart_item_delete(){
        $id = $_POST['id']; // cart id
        $item_id = getSingleColumnName($id,'id','item_id','db_poscart_all');
		$cashier_id=$this->session->userdata('inv_userid');
		$mod_result =$this->db->query(" delete from db_poscart_all WHERE cashier_id='$cashier_id' AND id='$id' ");
		$mod_result_addon =$this->db->query(" delete from db_pos_cart_addon WHERE cashier_id='$cashier_id' and item_id='$item_id'");
		echo 1;
		
	}
    public function cartaddon_item_delete(){
        $id = $_POST['id']; // cart id
		$cashier_id=$this->session->userdata('inv_userid');
		$mod_result_addon =$this->db->query(" delete from db_pos_cart_addon WHERE cashier_id='$cashier_id' and id='$id'");
		echo 1;
		
	}
    
    // add on plus minus
    public function updateQty_addon(){
	$data=$this->data;
	extract($data);
	extract($_POST);
	 $updatetype=$updatetype!=""?$updatetype:1;
	 $cashier_id=$this->session->userdata('inv_userid');
	IF($updatetype==1){
		$zerorow=$this->db->query("select * from db_pos_cart_addon where id='$id' and cashier_id='$cashier_id'  order by id desc ");
		$newd=$zerorow->num_rows(); 
		if($newd > 0){
		$row=$zerorow->row_array();
		$tot_qty= $row['qty']+1;  
        $amount=$row['price']*$tot_qty; 
		$sql_data=$this->db->query("update db_pos_cart_addon set qty=qty+1,total_price='$amount' where id='$id' and cashier_id='$cashier_id' ");
		  
		}	
	}else{
		$zerorow=$this->db->query("select sum(qty) as total_qty,price as price_cart from db_pos_cart_addon where id='$id' and cashier_id='$cashier_id'");
		$newd=$zerorow->num_rows();
		$total_result=$zerorow->row() ;
		$total_qty=$total_result->total_qty;
		if($total_qty > 1){
			//$row=$zerorow->row_array();
			$tot_qty= $total_qty-1;  
			$amount=$total_result->price_cart*$tot_qty; 
			$sql_data=$this->db->query("update db_pos_cart_addon set qty=qty-1,total_price='$amount' where id='$id' and cashier_id='$cashier_id' ");
		}else{
			$sql_data=$this->db->query("delete from  db_pos_cart_addon  where id='$id' and cashier_id='$cashier_id' ");
			$sql_data2=$this->db->query("delete from  db_pos_cart_addon  where id='$id' and cashier_id='$cashier_id' ");
		}
	}
}



    public function pos_save_order(){
    		$cashier_id  =$this->session->userdata('inv_userid');
    		$cart_pos =$this->session->userdata('cart_pos');
    		$table_number = 0;
    		$order_type =0;
    		$customer_id = $_GET['customer_id'];
    		$hidden_order_id=$_GET['hidden_order_id'];
    		if($hidden_order_id=='' || $hidden_order_id=='0'){
    		$ord='0';
			$zerorow=$this->db->query("select count(*) as total_qty ,sum(total_price) as total_amount from db_poscart_all WHERE cashier_id='$cashier_id' ");
			$newd=$zerorow->num_rows();
			$row_data=$zerorow->row_array();
			$order_number=0;
	        $zerorow2=$this->db->query("select count(*) as total_qty2 ,sum(total_price) as total_amount2 from db_pos_cart_addon  where cashier_id='$cashier_id'");
            $newd2=$zerorow2->num_rows();
            $row_data2=$zerorow2->row_array();
			//save order 
			
			 $sales_date 		=date("Y-m-d h:i:s");
			//$points 			= (empty($points_use)) ? 'NULL' : $points_use;
			$discount_input 	= NULL;
			$tot_disc 		= NULL;
	
			$tot_grand = $row_data['total_amount']+$row_data2['total_amount2'];
			$tot_amt =   $row_data['total_amount']+$row_data2['total_amount2'];
			$tot_grand 		= (empty($tot_grand)) ? 'NULL' : $tot_grand;
			//$tot_grand		=round($tot_amt);
			$round_off = number_format($tot_grand-$tot_amt,2,'.','');
	
			$q1=$this->db->query("select customer_name,mobile from db_customers where id=1");
			$customer_name 	= $q1->row()->customer_name;
			$mobile 		= $q1->row()->mobile;
			
			// sales insert
	
			//GET SALES INITIAL
			$q5=$this->db->query("select sales_init from db_company where id=1");
			$init=$q5->row()->sales_init;	
			$CUR_DATE=date('Y-m-d');
            $CUR_TIME=date('H:i:s');
	        $SYSTEM_NAME=$_SERVER['REMOTE_ADDR'];
	        $CUR_USERNAME==$this->session->userdata('inv_userid'); 
	        $SYSTEM_IP=$_SERVER['REMOTE_ADDR'];
			//ORDER SALES CREATION
			$maxid=$this->db->query("SELECT COALESCE(MAX(id),0)+1 AS maxid FROM db_sales")->row()->maxid;
			$sales_code=$init.str_pad($maxid, 4, '0', STR_PAD_LEFT);
	
			$sales_entry = array(
							'sales_code' 				=> $sales_code, 
							'sales_date' 				=> $sales_date,
						    'sales_status'		=> 'Final', 
							'customer_id' 				=> $customer_id,
							/*'warehouse_id' 				=> $warehouse_id,*/
							/*Discount*/
							'discount_to_all_input' 	=> $discount_input,
							'discount_to_all_type' 		=> $discount_type,
							'tot_discount_to_all_amt' 	=> $tot_disc,
							/*Subtotal & Total */
							'subtotal' 					=> $tot_amt,
							'round_off' 				=> $round_off,
							'grand_total' 				=> $tot_grand,
							/*System Info*/
							'created_date' 				=> $CUR_DATE,
							'created_time' 				=> $CUR_TIME,
							'created_by' 				=> $CUR_USERNAME,
							'system_ip' 				=> $SYSTEM_IP,
							'system_name' 				=> $SYSTEM_NAME,
							'pos' 						=> 1,
							'status' 					=> 1,
							'is_order_running'          => 0,
							'table_number'              => $table_number,
							'order_number'              => $order_number 
						);
	
			$q3 = $this->db->insert('db_sales', $sales_entry);
			
		//	echo $this->db->last_query(); die;
			
			$sales_id = $this->db->insert_id();
			if($sales_id) {
				$q45=$this->db->query("select coalesce(max(kot_number),0)+1 as maxkot from db_salesitems");
				$kot_number_db=$q45->row()->maxkot;
				$kot_number =$kot_number_db!=''?$kot_number_db:rand(12,23);
				$cashier_id=$this->session->userdata('inv_userid');    
				$zerorow=$this->db->query("select * from db_poscart_all where  cashier_id='$cashier_id'  order by id desc ");
				$newd=$zerorow->num_rows();
				$row_data=$zerorow->result_array();
				$o=0;
				foreach($row_data as $row){
					//RECEIVE VALUES FROM FORM
					$item_id 	= $row['item_id'];
					$catid      = getSingleColumnName($item_id,'id','category_id','db_items');
					$sales_qty 	=$row['qty'];
					$price_per_unit =$row['price'];
					$tax_amt =NULL;
					$tax_type ='Inclusive';
					$tax_id =3;
					$tax_value =0;//%
					$total_cost =$row['total_price'];
					$description =0;
					$refund_id=0;
					$refund_type=NULL;
					$unit_discount_per	=0;
					if($tax_type=='Exclusive'){
						$single_unit_total_cost = $price_per_unit + ($tax_value * $price_per_unit / 100);
					}
					else{//Inclusive
						$single_unit_total_cost =$price_per_unit;
					}
					$discount_amt 		=$discount_amt > 0 ?($sales_qty * $price_per_unit)*$unit_discount_per/100:'0';
					if($tax_id=='' || $tax_id==0){$tax_id=null;}
					if($tax_amt=='' || $tax_amt==0){$tax_amt=null;}
					if($total_cost=='' || $total_cost==0){$total_cost=null;}
					if(!empty($discount_to_all_input) && $discount_to_all_input!=0){
						$unit_discount_per =null;
						$discount_amt =null;
					}
					if(!empty($discount_to_all_input) && $discount_to_all_input!=0){
						$discount_amt =null;
					}
					/* ******************************** */
					$salesitems_entry = array(
								'sales_id' 			=> $sales_id, 
								'sales_status'		=> 'Final', 
								'item_id' 			=> $item_id, 
								'description' 		=> $description, 
								'sales_qty' 		=> $sales_qty,
								'price_per_unit' 	=> $price_per_unit,
								'tax_id' 			=> $tax_id,
								'tax_amt' 			=> $tax_amt,
								'tax_type' 			=> $tax_type,
								'unit_discount_per' => $unit_discount_per,
								'discount_amt' 		=> $discount_amt,
								'unit_total_cost' 	=> $single_unit_total_cost,
								'total_cost' 		=> $total_cost,
								'status'	 		=> 1,
								'kot_number'        =>$kot_number,
								'cat_id'            =>$catid
							);
					$q4 = $this->db->insert('db_salesitems', $salesitems_entry);
	
					$sql_addon_query=$this->db->query("select * from db_pos_cart_addon  where item_id='$item_id' AND cashier_id='$cashier_id'");
					if($sql_addon_query->num_rows() > 0){
					   
					 $sql_addon=$sql_addon_query->result_array();
						foreach($sql_addon as $addon_row){
							$adon_id=$addon_row['addon_id'];
							$price=$addon_row['price'];
							$qty=$addon_row['qty'];
							$total_price=$addon_row['total_price'];
							$note=$addon_row['note']==''?'0':$addon_row['note'];
							$addon_name=$addon_row['addon_name'];
							$salesaddon_items_entry = array(
								'sales_id'=> $sales_id, 
								'item_id'=> $item_id, 
								'addon_id'=> $adon_id, 
								'price'=> $price,
								'qty'=> $qty,
								'total_price'=> $total_price,
								'note'=> $note,
								'customer_id'=>'1',
								'note'       =>$note
							);
	
					$q20= $this->db->insert('db_sales_addon_detail', $salesaddon_items_entry);
					  //  echo $this->db->last_query(); die;
						}
					}
				}
		}
        
			$cashier_id=$this->session->userdata('inv_userid');
			$mod_result =$this->db->query(" delete from db_poscart_all WHERE cashier_id='$cashier_id'");
			$mod_result_addon =$this->db->query(" delete from db_pos_cart_addon WHERE cashier_id='$cashier_id'");
			if($sales_id!=''){
			    
			    
$amount 		=$_GET['paid_amt'];
$payment_type 	='Cash';
$payment_note 	='Paid By Cash';
$tot_grand=$_GET['tot_grand'];

$payment_type 	='Card';
$payment_note 	='Note';
$change_return =$_GET['change_return'];

                 $change_return=0;
				if($amount>$tot_grand){
					$change_return =$amount-$tot_grand;
					$amount =$tot_grand;
				}

$sales_date=date('Y-m-d H:i:s');
$CUR_DATE=date('Y-m-d');
$CUR_TIME=date('H:i:s');
$SYSTEM_NAME=$_SERVER['REMOTE_ADDR'];
$SYSTEM_IP=$_SERVER['REMOTE_ADDR'];
$CUR_USERNAME==$this->session->userdata('inv_userid'); 
$SYSTEM_IP=$_SERVER['REMOTE_ADDR'];
$salespayments_entry = array(
'sales_id' 		=> $sales_id, 
'payment_date'		=> $sales_date,//Current Payment with sales entry
'payment_type' 		=> 'Cash',
'payment' 			=> $amount,
'payment_note' 		=> $payment_note,
'created_date' 		=> $CUR_DATE,
'created_time' 		=> $CUR_TIME,
'created_by' 		=> $CUR_USERNAME,
'system_ip' 		=> $SYSTEM_IP,
'system_name' 		=> $SYSTEM_NAME,
'change_return' 	=> $change_return,
'status' 			=> 1,
);

$q7 = $this->db->insert('db_salespayments', $salespayments_entry);
$user_id=$this->session->userdata('inv_userid');
$date_payment=date('Y-m-d');
$this->load->model('sales_model');	
$q6=$this->sales_model->update_sales_payment_status($sales_id,$customer_id);

// $sql_cashier=$this->db->query("select * from db_cashier_transaction where user_id='$user_id' AND date_payment='$date_payment' AND draw_session='0' ORDER BY id desc ");
// $countrecod=$sql_cashier->num_rows();
// if($countrecod > 0){
// $data=$sql_cashier->row_array();
// $card_payment=$data['card_payment']!="0"?$data['card_payment']:0;
// $cash_payment=$data['cash_payment']!="0"?$data['cash_payment']:0;
// if($payment_type=='Cash'){
// $cash_paymentnew=$cash_payment+$amount;
// }else{
// $card_paymentnew=$card_payment+$amount;
// }

// $sql_cashier_update=$this->db->query("UPDATE  db_cashier_transaction SET card_payment='$card_paymentnew',cash_payment='$cash_paymentnew' where user_id='$user_id' AND date_payment='$date_payment' AND draw_session='0' ");  
// }else{

// if($payment_type=='Card'){
// $cash_paymentnew=$amount;
// $card_paymentnew=0;
// }else{
// $cash_paymentnew=0;
// $card_paymentnew=$amount;
// }


$data_array=array(
'user_id'=>$user_id,
'date_payment'=>$date_payment,
'cash_payment'=>$amount,
'card_payment'=>0,
'status'      =>1,
'draw_session'=>0
);

$q788 = $this->db->insert('db_cashier_transaction', $data_array);


//}  
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			   echo '1'.'~'.$sales_id; 
			}else{
			    echo '2'.'~'.'0';  
			}
			
	    
	    
    }else{
        
$sales_id =$_GET['hidden_order_id'];     



$amount =$_GET['paid_amt'];
$payment_type 	='Cash';
$payment_note 	='Paid By Cash';
$tot_grand=$_GET['tot_grand'];

$payment_type 	='Card';
$payment_note 	='Note';
$change_return =$_GET['change_return'];

                 $change_return=0;
				if($amount>$tot_grand){
					$change_return =$amount-$tot_grand;
					$amount =$tot_grand;
				}

$sales_date=date('Y-m-d H:i:s');
$CUR_DATE=date('Y-m-d');
$SYSTEM_NAME=$_SERVER['REMOTE_ADDR'];
$CUR_USERNAME==$this->session->userdata('inv_userid'); 
$SYSTEM_IP=$_SERVER['REMOTE_ADDR'];
$SYSTEM_IP=$_SERVER['REMOTE_ADDR'];
$CUR_TIME=date('H:i:s');
$salespayments_entry = array(
'sales_id' 		=> $sales_id, 
'payment_date'		=> $sales_date,//Current Payment with sales entry
'payment_type' 		=> 'Cash',
'payment' 			=> $amount,
'payment_note' 		=> $payment_note,
'created_date' 		=> $CUR_DATE,
'created_time' 		=> $CUR_TIME,
'created_by' 		=> $CUR_USERNAME,
'system_ip' 		=> $SYSTEM_IP,
'system_name' 		=> $SYSTEM_NAME,
'change_return' 	=> $change_return,
'status' 			=> 1,
);

$q7 = $this->db->insert('db_salespayments', $salespayments_entry);
$user_id=$this->session->userdata('inv_userid');
$date_payment=date('Y-m-d');


$user_id=$this->session->userdata('inv_userid');
$date_payment=date('Y-m-d');
// $sql_cashier=$this->db->query("select * from db_cashier_transaction where user_id='$user_id' AND date_payment='$date_payment' AND draw_session='0' ORDER BY id desc ");
// $countrecod=$sql_cashier->num_rows();
// if($countrecod > 0){
// $data=$sql_cashier->row_array();
// $card_payment=$data['card_payment']!="0"?$data['card_payment']:0;
// $cash_payment=$data['cash_payment']!="0"?$data['cash_payment']:0;
// if($payment_type=='Cash'){
// $cash_paymentnew=$cash_payment+$amount;
// }else{
// $card_paymentnew=$card_payment+$amount;
// }

// $sql_cashier_update=$this->db->query("UPDATE  db_cashier_transaction SET card_payment='$card_paymentnew',cash_payment='$cash_paymentnew' where user_id='$user_id' AND date_payment='$date_payment' AND draw_session='0' ");  
// }else{

// if($payment_type=='Card'){
// $cash_paymentnew=$amount;
// $card_paymentnew=0;
// }else{
// $cash_paymentnew=0;
// $card_paymentnew=$amount;
// }


$data_array=array(
'user_id'=>$user_id,
'date_payment'=>$date_payment,
'cash_payment'=>$cash_paymentnew,
'card_payment'=>$card_paymentnew,
'status'      =>1,
'draw_session'=>0
);

$q788 = $this->db->insert('db_cashier_transaction', $data_array);


//}  









$this->load->model('sales_model');	
$q6=$this->sales_model->update_sales_payment_status($sales_id,$customer_id); 
$sqlUPDATE=$this->db->query("update db_sales set sales_status='Final',is_order_running='0',payment_status='Paid' where id='$sales_id'");
   if($q7){
        echo '1'.'~'.$sales_id; 
   } else{
       echo '2'.'~'.'0';  
   }    
       
        
    }
	    
	    
	    
	    
	    

	}


 public function pos_save_order_card(){
    		$cashier_id  =$this->session->userdata('inv_userid');
    		$cart_pos =$this->session->userdata('cart_pos');
    		
    		$table_number = 0;
    		$order_type =0;
    		$customer_id = $_GET['customer_id'];
    		$price_id = $_GET['price_id']!=''?$_GET['price_id']:'0';
    		if($_GET['hidden_order_id']=='' || $_GET['hidden_order_id']=='0'){
    		$ord='0';
			$zerorow=$this->db->query("select count(*) as total_qty ,sum(total_price) as total_amount from db_poscart_all WHERE cashier_id='$cashier_id' ");
			$newd=$zerorow->num_rows();
			$row_data=$zerorow->row_array();
			$order_number=0;
	
			//save order 
			
			$sales_date 		=date("Y-m-d h:i:s");
			//$points 			= (empty($points_use)) ? 'NULL' : $points_use;
			$discount_input 	= NULL;
			$tot_disc 		= NULL;
	
	
	                $zerorow2=$this->db->query("select count(*) as total_qty2 ,sum(total_price) as total_amount2 from db_pos_cart_addon  where cashier_id='$cashier_id'");
                    $newd2=$zerorow2->num_rows();
                    $row_data2=$zerorow2->row_array();
                  //  $all_amount = $row_data['total_amount']+$row_data2['total_amount2'];
	
			$tot_grand = $row_data['total_amount']+$row_data2['total_amount2'];
			$tot_amt =   $row_data['total_amount']+$row_data2['total_amount2'];
			$tot_grand 		= (empty($tot_grand)) ? 'NULL' : $tot_grand;
			//$tot_grand		=round($tot_amt);
			$round_off = number_format($tot_grand-$tot_amt,2,'.','');
	
			$q1=$this->db->query("select customer_name,mobile from db_customers where id=1");
			$customer_name 	= $q1->row()->customer_name;
			$mobile 		= $q1->row()->mobile;
			
			// sales insert
	
			//GET SALES INITIAL
			$q5=$this->db->query("select sales_init from db_company where id=1");
			$init=$q5->row()->sales_init;	
			$CUR_DATE=date('Y-m-d');
            $CUR_TIME=date('H:i:s');
	        $SYSTEM_NAME=$_SERVER['REMOTE_ADDR'];
	        $CUR_USERNAME==$this->session->userdata('inv_userid'); 
	        $SYSTEM_IP=$_SERVER['REMOTE_ADDR'];
			//ORDER SALES CREATION
			$maxid=$this->db->query("SELECT COALESCE(MAX(id),0)+1 AS maxid FROM db_sales")->row()->maxid;
			$sales_code=$init.str_pad($maxid, 4, '0', STR_PAD_LEFT);
	
			$sales_entry = array(
							'sales_code' 				=> $sales_code, 
							'sales_date' 				=> $sales_date,
						    'sales_status'		=> 'Final', 
							'customer_id' 				=> $customer_id,
							/*'warehouse_id' 				=> $warehouse_id,*/
							/*Discount*/
							'discount_to_all_input' 	=> $discount_input,
							'discount_to_all_type' 		=> $discount_type,
							'tot_discount_to_all_amt' 	=> $tot_disc,
							/*Subtotal & Total */
							'subtotal' 					=> $tot_amt,
							'round_off' 				=> $round_off,
							'grand_total' 				=> $tot_grand,
							/*System Info*/
							'created_date' 				=> $CUR_DATE,
							'created_time' 				=> $CUR_TIME,
							'created_by' 				=> $CUR_USERNAME,
							'system_ip' 				=> $SYSTEM_IP,
							'system_name' 				=> $SYSTEM_NAME,
							'pos' 						=> 1,
							'status' 					=> 1,
							'is_order_running'          => 0,
							'table_number'              => $table_number,
							'order_number'              => $order_number 
						);
	
			$q3 = $this->db->insert('db_sales', $sales_entry);
			$sales_id = $this->db->insert_id();
			if($sales_id) {
				$q45=$this->db->query("select coalesce(max(kot_number),0)+1 as maxkot from db_salesitems");
				$kot_number_db=$q45->row()->maxkot;
				$kot_number =$kot_number_db!=''?$kot_number_db:rand(12,23);
				$cashier_id=$this->session->userdata('inv_userid');    
				$zerorow=$this->db->query("select * from db_poscart_all where  cashier_id='$cashier_id'  order by id desc ");
				$newd=$zerorow->num_rows();
				$row_data=$zerorow->result_array();
				$o=0;
				foreach($row_data as $row){
					//RECEIVE VALUES FROM FORM
					$item_id 	= $row['item_id'];
					$catid      = getSingleColumnName($item_id,'id','category_id','db_items');
					$sales_qty 	=$row['qty'];
					$price_per_unit =$row['price'];
					$tax_amt =NULL;
					$tax_type ='Inclusive';
					$tax_id =3;
					$tax_value =0;//%
					$total_cost =$row['total_price'];
					$description =0;
					$refund_id=0;
					$refund_type=NULL;
					$unit_discount_per	=0;
					if($tax_type=='Exclusive'){
						$single_unit_total_cost = $price_per_unit + ($tax_value * $price_per_unit / 100);
					}
					else{//Inclusive
						$single_unit_total_cost =$price_per_unit;
					}
					$discount_amt 		=$discount_amt > 0 ?($sales_qty * $price_per_unit)*$unit_discount_per/100:'0';
					if($tax_id=='' || $tax_id==0){$tax_id=null;}
					if($tax_amt=='' || $tax_amt==0){$tax_amt=null;}
					if($total_cost=='' || $total_cost==0){$total_cost=null;}
					if(!empty($discount_to_all_input) && $discount_to_all_input!=0){
						$unit_discount_per =null;
						$discount_amt =null;
					}
					if(!empty($discount_to_all_input) && $discount_to_all_input!=0){
						$discount_amt =null;
					}
					/* ******************************** */
					$salesitems_entry = array(
								'sales_id' 			=> $sales_id, 
								'sales_status'		=> 'Final', 
								'item_id' 			=> $item_id, 
								'description' 		=> $description, 
								'sales_qty' 		=> $sales_qty,
								'price_per_unit' 	=> $price_per_unit,
								'tax_id' 			=> $tax_id,
								'tax_amt' 			=> $tax_amt,
								'tax_type' 			=> $tax_type,
								'unit_discount_per' => $unit_discount_per,
								'discount_amt' 		=> $discount_amt,
								'unit_total_cost' 	=> $single_unit_total_cost,
								'total_cost' 		=> $total_cost,
								'status'	 		=> 1,
								'kot_number'        =>$kot_number,
								'cat_id'            =>$catid
							);
					$q4 = $this->db->insert('db_salesitems', $salesitems_entry);
	
					$sql_addon_query=$this->db->query("select * from db_pos_cart_addon  where item_id='$item_id' AND cashier_id='$cashier_id'");
					if($sql_addon_query->num_rows() > 0){
					   
					 $sql_addon=$sql_addon_query->result_array();
						foreach($sql_addon as $addon_row){
							$adon_id=$addon_row['addon_id'];
							$price=$addon_row['price'];
							$qty=$addon_row['qty'];
							$total_price=$addon_row['total_price'];
							$note=$addon_row['note']==''?'0':$addon_row['note'];
							$addon_name=$addon_row['addon_name'];
							$salesaddon_items_entry = array(
								'sales_id'=> $sales_id, 
								'item_id'=> $item_id, 
								'addon_id'=> $adon_id, 
								'price'=> $price,
								'qty'=> $qty,
								'total_price'=> $total_price,
								'note'=> $note,
								'customer_id'=>'1',
								'note'       =>$note
							);
	
					$q20= $this->db->insert('db_sales_addon_detail', $salesaddon_items_entry);
					  //  echo $this->db->last_query(); die;
						}
					}
				}
		}
        
			$cashier_id=$this->session->userdata('inv_userid');
			$mod_result =$this->db->query(" delete from db_poscart_all WHERE cashier_id='$cashier_id'");
			$mod_result_addon =$this->db->query(" delete from db_pos_cart_addon WHERE cashier_id='$cashier_id'");
			if($sales_id!=''){
			    
			    
$amount 		=$_GET['paid_amt'];
$payment_note 	='Paid By Card';
$tot_grand=$_GET['tot_grand'];
$payment_type 	='Card';
$payment_note 	='Note';
$change_return =$_GET['change_return'];

$card_mobile=$_GET['card_mobile']!=''?$_GET['card_mobile']:'0';
$card_name=$_GET['card_name']!=''?$_GET['card_name']:'0';
$card_number=$_GET['card_number']!=''?$_GET['card_number']:'0';
$price_id = $_GET['price_id']!=''?$_GET['price_id']:'0';

if($price_id==6){
$payfor='Uber Eats';
}
elseif($price_id==7){
$payfor='Menulog';
}
elseif($price_id==8){
$payfor='Doordash';
}else{
$payfor='Card';
}

                 $change_return=0;
				if($amount>$tot_grand){
					$change_return =$amount-$tot_grand;
					$amount =$tot_grand;
				}


$CUR_DATE=date('Y-m-d');
$CUR_TIME=date('H:i:s');
$SYSTEM_NAME=$_SERVER['REMOTE_ADDR'];
$CUR_USERNAME==$this->session->userdata('inv_userid'); 
$SYSTEM_IP=$_SERVER['REMOTE_ADDR'];
$salespayments_entry = array(
'sales_id' 		=> $sales_id, 
'payment_date'		=> $CUR_DATE,//Current Payment with sales entry
'payment_type' 		=> $payfor,
'payment' 			=> $amount,
'payment_note' 		=> $payment_note,
'created_date' 		=> $CUR_DATE,
'created_time' 		=> $CUR_TIME,
'created_by' 		=> $CUR_USERNAME,
'system_ip' 		=> $SYSTEM_IP,
'system_name' 		=> $SYSTEM_NAME,
'change_return' 	=> $change_return,
'status' 			=> 1,
'card_mobile'       => $card_mobile,
'card_name'        => $card_name,
'card_number'      => $card_number,
'price_id'         =>$price_id
);

$q7 = $this->db->insert('db_salespayments', $salespayments_entry);
$user_id=$this->session->userdata('inv_userid');
$date_payment=date('Y-m-d');
$this->load->model('sales_model');	
$q6=$this->sales_model->update_sales_payment_status($sales_id,$customer_id);

// $sql_cashier=$this->db->query("select * from db_cashier_transaction where user_id='$user_id' AND date_payment='$date_payment' AND draw_session='0' ORDER BY id desc ");
// $countrecod=$sql_cashier->num_rows();
// if($countrecod > 0){
// $data=$sql_cashier->row_array();
// $card_payment=$data['card_payment']!="0"?$data['card_payment']:0;
// $cash_payment=$data['cash_payment']!="0"?$data['cash_payment']:0;
// if($payment_type=='Cash'){
// $cash_paymentnew=$cash_payment+$amount;
// }else{
// $card_paymentnew=$card_payment+$amount;
// }

// $sql_cashier_update=$this->db->query("UPDATE  db_cashier_transaction SET card_payment='$card_paymentnew',cash_payment='$cash_paymentnew' where user_id='$user_id' AND date_payment='$date_payment' AND draw_session='0' ");  
// }else{

// if($payment_type=='Card'){
// $cash_paymentnew=$amount;
// $card_paymentnew=0;
// }else{
// $cash_paymentnew=0;
// $card_paymentnew=$amount;
// }


$data_array=array(
'user_id'=>$user_id,
'date_payment'=>$date_payment,
'cash_payment'=>0,
'card_payment'=>$amount,
'status'      =>1,
'draw_session'=>0
);

$q788 = $this->db->insert('db_cashier_transaction', $data_array);


//}  
			    
		    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			   echo '1'.'~'.$sales_id; 
			}else{
			    echo '2'.'~'.'0';  
			}
			
	    

	

 }else{
        
$sales_id =$_GET['hidden_order_id'];        
$amount =$_GET['paid_amt'];
$payment_type 	='Cash';
$payment_note 	='Paid By Cash';
$tot_grand=$_GET['tot_grand'];

$payment_type 	='Card';
$payment_note 	='Note';
$change_return =0;

                 $change_return=0;
				if($amount>$tot_grand){
					$change_return =0;
					$amount =$tot_grand;
				}


$CUR_DATE=date('Y-m-d');
$CUR_TIME=date('H:i:s');
$SYSTEM_NAME=$_SERVER['REMOTE_ADDR'];
$CUR_USERNAME==$this->session->userdata('inv_userid'); 
$SYSTEM_IP=$_SERVER['REMOTE_ADDR'];
$sales_date=date('Y-m-d H:i:s');
$salespayments_entry = array(
'sales_id' 		=> $sales_id, 
'payment_date'		=> $CUR_DATE,//Current Payment with sales entry
'payment_type' 		=> 'Cash',
'payment' 			=> $amount,
'payment_note' 		=> $payment_note,
'created_date' 		=> $CUR_DATE,
'created_time' 		=> $CUR_TIME,
'created_by' 		=> $CUR_USERNAME,
'system_ip' 		=> $SYSTEM_IP,
'system_name' 		=> $SYSTEM_NAME,
'change_return' 	=> $change_return,
'status' 			=> 1,
);

$user_id=$this->session->userdata('inv_userid');
$date_payment=date('Y-m-d');
// $sql_cashier=$this->db->query("select * from db_cashier_transaction where user_id='$user_id' AND date_payment='$date_payment' AND draw_session='0' ORDER BY id desc ");
// $countrecod=$sql_cashier->num_rows();
// if($countrecod > 0){
// $data=$sql_cashier->row_array();
// $card_payment=$data['card_payment']!="0"?$data['card_payment']:0;
// $cash_payment=$data['cash_payment']!="0"?$data['cash_payment']:0;
// if($payment_type=='Cash'){
// $cash_paymentnew=$cash_payment+$amount;
// }else{
// $card_paymentnew=$card_payment+$amount;
// }

// $sql_cashier_update=$this->db->query("UPDATE  db_cashier_transaction SET card_payment='$card_paymentnew',cash_payment='$cash_paymentnew' where user_id='$user_id' AND date_payment='$date_payment' AND draw_session='0' ");  
// }else{

// if($payment_type=='Card'){
// $cash_paymentnew=$amount;
// $card_paymentnew=0;
// }else{
// $cash_paymentnew=0;
// $card_paymentnew=$amount;
// }


$data_array=array(
'user_id'=>$user_id,
'date_payment'=>$date_payment,
'cash_payment'=>$amount,
'card_payment'=>0,
'status'      =>1,
'draw_session'=>0
);

$q788 = $this->db->insert('db_cashier_transaction', $data_array);


//}  
			    










$q7 = $this->db->insert('db_salespayments', $salespayments_entry);
$user_id=$this->session->userdata('inv_userid');
$date_payment=date('Y-m-d');
$this->load->model('sales_model');	
$q6=$this->sales_model->update_sales_payment_status($sales_id,$customer_id); 
//$sqlUPDATE=$this->db->query("update db_sales set sales_status='Final',is_order_running='0',payment_status='Paid' where id='$sales_id'");
   if($q7){
        echo '1'.'~'.$sales_id; 
   } else{
       echo '2'.'~'.'0';  
   }    
       
        
    }


}


public function dayEnd(){
      	$data['page_title']='Sales Report';
		$this->load->view('dayend_report',$data);
}

public function price_third_party(){
    $current_id=$_POST['current_id'];
    if($current_id!='' && $current_id!='0'){
        $cashier_id=$this->session->userdata('inv_userid');
        $sql_data=$this->db->query("delete from  db_poscart_all  where  cashier_id='$cashier_id' ");
        $sql_data2=$this->db->query("delete from  db_pos_cart_addon  where cashier_id='$cashier_id' ");
        $this->session->set_userdata('session_price_id', $current_id);
    }else{
       $this->session->set_userdata('session_price_id', '');  
    }
}

    public function cart_discount(){
    	$cashier_id  =$this->session->userdata('inv_userid');
    	$cart_pos =$this->session->userdata('cart_pos');
        $discount_amount   = $_POST['discount_amount'];
        $selCnt = " * FROM db_poscart_all WHERE cashier_id='$cashier_id' ";
        $this->db->select($selCnt);
        $query = $this->db->get();
        $getQun=$query->row_array();
        if($query->num_rows() > 0){
            $amount=$_POST['amount'];
            $discount_type=$_POST['discount_type'];
            $cashier_id=$this->session->userdata('inv_userid');
            $zerorow=$this->db->query("select count(*) as total_qty ,sum(total_price) as total_amount,total_discount as all_discount from db_poscart_all WHERE cashier_id='$cashier_id' ");
            $newd=$zerorow->num_rows();
            $row_data=$zerorow->row_array();
            $qty_card = $row_data['total_qty'];
            $discount_all=$row_data['all_discount'];
            $all_amount = $row_data['total_amount'];
            if($discount_type==1){
              $discount = ($amount / 100) * $all_amount;  
            }else{
               $discount = $amount;   
            }
            $saveItems ="UPDATE db_poscart_all SET total_discount='$discount' where cashier_id='$cashier_id'"; 	
            $sql_data2=$this->db->query($saveItems);
            
        } 
    
   }
   
   
   public function running_order_detail(){
    $orderId=$_POST['order_id'];   
    $cashier_id=$this->session->userdata('inv_userid');
    $zerorow=$this->db->query("select sum(grand_total) as total_amount,tot_discount_to_all_amt  as all_discount from db_sales WHERE id='$orderId' ");
    $newd=$zerorow->num_rows();
    $row_data=$zerorow->row_array();
    $zerorow2=$this->db->query("select sum(total_price) as total_amount2 from db_sales_addon_detail  where 	sales_id='$orderId'");
    $newd2=$zerorow2->num_rows();
    $row_data2=$zerorow2->row_array();
    $all_amount = $row_data['total_amount'];  
    $zerorow3=$this->db->query("select sum(sales_qty) as total_qty from db_salesitems  where 	sales_id='$orderId'");
    $newd3=$zerorow3->num_rows();
    $row_data3=$zerorow3->row_array();
    $qty_card = $row_data3['total_qty'];   
    echo $qty_card.'~'.$all_amount.'~'.($all_amount+$row_data['all_discount']);   
   }
   
   
   
   
   
   
   
   
   
   
   public function running_orderlist_detail(){
$orderId=$_POST['order_id'];   
$zerorow_sale=$this->db->query("select * from db_salesitems WHERE sales_id='$orderId'  order by id desc ");
$newd_sale=$zerorow_sale->num_rows();
$row_ord_data_sale=$zerorow_sale->result_array();
$o=0;
foreach($row_ord_data_sale as $row_ord){
$item_name = getSingleColumnName($row_ord['item_id'],'id','item_name','db_items');
?>
<tr class="car_<?php echo $row_ord['item_id']; ?>"  data-row="0" data-item-id="<?php echo $row_ord['item_id']; ?>">
<!--<td class="srl_number"><?php echo $newd_sale-$o; ?></td>-->
<td style="width:50%" class="caritemname_<?php echo $row_ord['item_id']; ?>"><a class="pointer item-name-pos text-truncate" id="td_data_0_0"><?php echo substr($item_name,0,35).'...'; ?></a> <span id="spandesc<?php echo $row_ord['item_id']; ?>"></span><i rowcnt="0" id="<?php echo $row_ord['item_id']; ?>" class="edit-icon short_desc fa fa-pencil-square-o" aria-hidden="true&quot;"></i></td>
<td style="display:none" >1500000.00</td>
 <td id="td_0_3" class="text-right"><input readonly="" id="sales_price_0"  name="sales_price_0" type="text" class="form-control no-padding " value="<?php echo $row_ord['price_per_unit']; ?>"></td>
  <td id="td_0_2">
      <div class="input-group input-group-sm"><span class="input-group-btn"><button id="dr0<?php echo $row_ord['item_id']; ?>"  type="button" class="counter-increment"><i class="lnr lnr-circle-minus"></i></button></span><input readonly="readonly" typ="text" value="<?php echo $row_ord['sales_qty']; ?>" class="form-control no-padding text-center qty-incr-control" id="item_qty_<?php echo $row['item_id']; ?>" name="item_qty_<?php echo $row['item_id']; ?>"><span class="input-group-btn"><button id="in0"  type="button" class="counter-increment"><i class="lnr lnr-plus-circle"></i></button></span></div>
   </td>

<td style="display:none" ><input data-toggle="tooltip" title="Click to Change" id="td_data_0_11<?php echo $row_ord['item_id']; ?>" onclick="show_sales_item_modal(0)" name="td_data_0_11" type="text" class="form-control no-padding pointer" readonly="" value="0.00"></td>
<td id="td_0_4" class="text-right caritemprice_<?php echo $row_ord['item_id']; ?>"><input data-toggle="tooltip" title="Total" id="td_data_0_4" name="td_data_0_4" type="text" class="form-control no-padding pointer" readonly="" value="<?php echo $row_ord['total_cost']; ?>"></td>
<td style="display:none"  class="text-right"><input type="text" name="td_data_0_8" id="td_data_0_8<?php echo $row_ord['item_id']; ?>" class="form-control text-right no-padding only_currency text-center item_discount " value="0"></td>
<td style="display:none"><a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="removerow(0)" title="Delete Item?"></a></td>
<input type="hidden" name="tr_item_id_<?php echo $row_ord['item_id']; ?>" id="tr_item_id_<?php echo $row_ord['item_id']; ?>" value="<?php echo $row_ord['item_id']; ?>">
<input type="hidden" id="tr_sales_price_temp_<?php echo $row_ord['item_id']; ?>" name="tr_sales_price_temp_0" value="<?php echo $row_ord['total_cost']; ?>">
<input type="hidden" id="tr_sales_price_temp2_<?php echo $row_ord['item_id']; ?>" name="tr_sales_price_temp2_0" value="<?php echo $row_ord['total_cost']; ?>">
<input type="hidden" id="tr_tax_type_<?php echo $row_ord['item_id']; ?>" name="tr_tax_type_<?php echo $row_ord['item_id']; ?>" value="Exclusive">
<input type="hidden" id="tr_tax_id_<?php echo $row_ord['item_id']; ?>" name="tr_tax_id_<?php echo $row_ord['item_id']; ?>" value="4">
<input type="hidden" id="tr_tax_value_<?php echo $row_ord['item_id']; ?>" name="tr_tax_value_<?php echo $row_ord['item_id']; ?>" value="0.00"><input type="hidden" id="description_<?php echo $row_ord['item_id']; ?>" name="description_0" value=""><input type="hidden" id="refund_id_0" name="refund_id_0" value="0">
<input type="hidden" id="refund_type_<?php echo $row_ord['item_id']; ?>" name="refund_type_<?php echo $row_ord['item_id']; ?>" value="0">
<td width="10%" class="text-center "><span style="cursor:pointer;"   class="lnr lnr-trash trash-icon"></span></td>
</tr>
<?php
$addonaall=0;
$item_ids=$row_ord['item_id'];
$sales_id_ord =$row_ord['sales_id'];
$sql_addon_query=$this->db->query("select * from db_sales_addon_detail where item_id='$item_ids'  AND  sales_id='$sales_id_ord'");
$sql_addon=$sql_addon_query->result_array();

foreach($sql_addon as $addon_row){
$addonaall=$addonaall+$addon_row['total_price'];
$addon_name =getSingleColumnName($addon_row['addon_id'],'id','modifier_name','db_modifier'); 
?>
<tr>

<td><span style="color:#337ab7;margin-left:10px"><?php echo $addon_name; ?></span></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><span class="text-center" style="color:#337ab7"><center><?php echo $addon_row['total_price']; ?></center></span></td>
<td><span class="text-center" style="color:#337ab7"><center><?php echo $addon_row['total_price']; ?></center></span></td>
<td width="10%" class="text-center "><span style="cursor:pointer;"   class="lnr lnr-trash trash-icon"></span></td>
</tr>
<?php
}
$o++;
}
 
   }
  
public function displaytime(){
    echo date('H:i:s');
} 
 

public function running_table(){
        $data=$this->data;
		$data=array_merge($data,array('sales_id'=>$sales_id));
		$this->load->view('modals/running_table_list',$data);
 
}

public function running_order_ajax(){
        $data=$this->data;
		$data['page_title']=$this->lang->line('sales_invoice');
		$this->load->view('modals/latest_running_orders_ajax',$data);
 
}
public function store_pickup_order_ajax(){
        $data=$this->data;
		$data['page_title']='Store Pickup Order';
		$this->load->view('store_pickup_order_ajax',$data);
 
}

public function online_order_ajax(){
        $data=$this->data;
		$data['page_title']='Online  Order';
		$this->load->view('online_order_ajax',$data);
 
}
public function instore_order_ajax(){
        $data=$this->data;
		$data['page_title']='instore  Order';
		$this->load->view('instore_order_ajax',$data);
 
}
public function print_last_invoice_pos(){
	    $sql_data=$this->db->query("select id from db_sales where status=1 order by id desc limit 0,1");
	    $result=$sql_data->row_array();
	    $sales_id=$result['id'];
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_invoice');
		$data=array_merge($data,array('sales_id'=>$sales_id));
		$this->load->view('sal-invoice-pos',$data);
} 

//pos print
// FOR KOT POS
public function printer_kot_pos(){
	$sales_id=1;
	// echo   "update db_sales set order_view=0  where order_view=1 AND id='$sales_id'";
	//   $sql23 =$this->db->query("update db_sales set order_view=0  where order_view=1 AND id='$sales_id'");
	//   self::fun2($sales_id);
	  self::posprint_fun1($sales_id);
	  self::posprint_fun2($sales_id);
	}
	
 public function posprint_fun1($sales_id)	
 {
	 

	$kitchen_kot=array();
	$coff_kot=array();
	// echo "select cat_id from db_salesitems where 'sales_id'=$sales_id";
	$query_cat=$this->db->query("select cat_id from db_salesitems where sales_id=$sales_id ");
	$row=$query_cat->result_array();
	foreach($row  as $rowitem){
	   
		$catid=$rowitem['cat_id'];
		$kottype=getSingleColumnName($catid,'id','kot_type','db_category');
		if($kottype==1){
			$kitchen_kot[]=$catid;
		}
	}

	if(count($kitchen_kot) > 0){


	try {
		// Enter the share name for your USB printer here
  // $connector = null;
  //$connector = new NetworkPrintConnector("192.168.0.104", 1700);
  $connector = new WindowsPrintConnector("cygen-printer");
   //$connector = new NetworkPrintConnector("cygen-printer");
   /* Print a "Hello world" receipt" */
   //
 
		//flush(); //this sends the output to the client. You may also need ob_flush();
		//sleep(1); //wait 10 seconds 
		//$data=array_merge($data,array('kot_cat'=>$kitchen_kot));
		//$data=array_merge($data,array('sales_id'=>$sales_id));
	//	$this->load->view('kot-invoice-pos',$data);
	$CAID=implode(",",$kitchen_kot);
	
		   
	$CI =& get_instance();

$q1=$this->db->query("select * from db_company where id=1 and status=1");
$res1=$q1->row();
$company_logo=$res1->company_logo;
$company_name		=$res1->company_name;
$company_mobile		=$res1->mobile;
$company_phone		=$res1->phone;
$company_email		=$res1->email;
$company_country	=$res1->country;
$company_state		=$res1->state;
$company_city		=$res1->city;
$company_address	=$res1->address;
$company_postcode	=$res1->postcode;
$company_gst_no		=$res1->gst_no;//Goods and Service Tax Number (issued by govt.)
$company_vat_number		=$res1->vat_no;//Goods and Service Tax Number (issued by govt.)
$website            =$res1->website;

$q3=$this->db->query("SELECT a.customer_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,
				   a.opening_balance,a.country_id,a.state_id,
				   a.postcode,a.address,b.sales_date,b.created_time,b.reference_no,
				   b.sales_code,b.sales_note,
				   coalesce(b.grand_total,0) as grand_total,
				   coalesce(b.subtotal,0) as subtotal,
				   coalesce(b.paid_amount,0) as paid_amount,
				   coalesce(b.other_charges_input,0) as other_charges_input,
				   other_charges_tax_id,
				   coalesce(b.other_charges_amt,0) as other_charges_amt,
				   discount_to_all_input,
				   b.discount_to_all_type,
				   coalesce(b.tot_discount_to_all_amt,0) as tot_discount_to_all_amt,
				   coalesce(b.round_off,0) as round_off,
				   b.payment_status

				   FROM db_customers a,
				   db_sales b 
				   WHERE 
				   a.`id`=b.`customer_id` AND 
				   b.`id`='$sales_id'  ");
				   
				 //  echo $this->db->last_query(); die;
				   /*GROUP BY 
				   b.`customer_code`*/

$res3=$q3->row();
$customer_name=$res3->customer_name;
$customer_mobile=$res3->mobile;
$customer_phone=$res3->phone;
$customer_email=$res3->email;
$customer_country=$res3->country_id;
$customer_state=$res3->state_id;
$customer_address=$res3->address;
$customer_postcode=$res3->postcode;
$customer_gst_no=$res3->gstin;
$customer_tax_number=$res3->tax_number;
$customer_opening_balance=$res3->opening_balance;
$sales_date=show_date($res3->sales_date);
$reference_no=$res3->reference_no;
$created_time=show_time($res3->created_time);
$sales_code=$res3->sales_code;
$sales_note=$res3->sales_note;


$subtotal=$res3->subtotal;
$grand_total=$res3->grand_total;
$other_charges_input=$res3->other_charges_input;
$other_charges_tax_id=$res3->other_charges_tax_id;
$other_charges_amt=$res3->other_charges_amt;
$paid_amount=$res3->paid_amount;
$discount_to_all_input=$res3->discount_to_all_input;
$discount_to_all_type=$res3->discount_to_all_type;
//$discount_to_all_type = ($discount_to_all_type=='in_percentage') ? '%' : 'Fixed';
$tot_discount_to_all_amt=$res3->tot_discount_to_all_amt;
$round_off=$res3->round_off;
$payment_status=$res3->payment_status;

if($discount_to_all_input>0){
$str="($discount_to_all_input%)";
}else{
$str="(Fixed)";
}

if(!empty($customer_country)){
$customer_country = $this->db->query("select country from db_country where id='$customer_country'")->row()->country;  
}
if(!empty($customer_state)){
$customer_state = $this->db->query("select state from db_states where id='$customer_state'")->row()->state;  
}






   $printer = new Printer($connector);
   $printer->setJustification(Printer::JUSTIFY_CENTER);
   $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
   $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
   $printer -> text("$company_name"."\n");
   $printer->selectPrintMode();
   $printer -> text($company_address."\n");
   $printer -> text($company_city."\n");
   $printer -> text($company_gst_no);
   $printer -> text("ABN Number:".$company_vat_number."\n");
   $printer -> text("Phone:".$company_mobile."\n");
   $printer->feed(1);
   $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
   $printer -> text("KOT Number    ".$sales_code."\n");
   
   $texttoprint2 = sprintf('%-4.30s %-20.30s %-3.5s',"#","Description","Qty"); 
   $printer->text($texttoprint2."\n");
   $printer->selectPrintMode();
   $i=0;
   $tot_qty=0;
   $subtotal=0;
   $tax_amt=0;
 //  $CAID=implode(",",$kot_cat);
   $q2=$this->db->query("select b.item_name,a.sales_qty,a.unit_total_cost,a.price_per_unit,a.tax_amt,c.tax,a.total_cost from db_salesitems a,db_items b,db_tax c where c.id=a.tax_id and b.id=a.item_id and a.sales_id='$sales_id' AND a.cat_id IN($CAID)");
   foreach ($q2->result() as $res2) {
	  $item_name = substr($res2->item_name,0,18).'...';
	  $m=++$i;
	  $sales_qty = $res2->sales_qty;
	//  $texttoprint .= sprintf('%s %s %f', $m,$item_name,$sales_qty); // very basic start: A string and a float
		$texttoprint = sprintf('%-4.30s %-22.30s %3.2f',$m,$item_name,$sales_qty); 
	//  $printer->text("{$m} {$item_name} -{$sales_qty} \n");
	$printer->text("{$texttoprint} \n");
   }	  
	
   $printer->feed(1);
 $printer -> setUnderline(0); // Reset
 $printer->  text("\n");
$printer->  feed();
$printer->  feed();
$printer -> cut();
/* Close printer */
 $printer -> close();
} 

catch (Exception $e) {
   echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}
}
 }	
	
 public function posprint_fun2($sales_id)	
 {
	 

	$kitchen_kot=array();
	$coff_kot=array();
	// echo "select cat_id from db_salesitems where 'sales_id'=$sales_id";
	$query_cat=$this->db->query("select cat_id from db_salesitems where sales_id=$sales_id ");
	$row=$query_cat->result_array();
	foreach($row  as $rowitem){
	   
		$catid=$rowitem['cat_id'];
		$kottype=getSingleColumnName($catid,'id','kot_type','db_category');
		if($kottype==2){
			$coff_kot[]=$catid;  
		}
	}

	if(count($coff_kot) > 0){
	try {
		// Enter the share name for your USB printer here
		  // $connector = null;
	   $connector = new WindowsPrintConnector("cygen-printer");
		   /* Print a "Hello world" receipt" */
		//flush(); //this sends the output to the client. You may also need ob_flush();
		//sleep(1); //wait 10 seconds 
		//$data=array_merge($data,array('kot_cat'=>$kitchen_kot));
		//$data=array_merge($data,array('sales_id'=>$sales_id));
		//	$this->load->view('kot-invoice-pos',$data);
	$CAID=implode(",",$coff_kot);
	
		   
	$CI =& get_instance();

$q1=$this->db->query("select * from db_company where id=1 and status=1");
$res1=$q1->row();
$company_logo=$res1->company_logo;
$company_name		=$res1->company_name;
$company_mobile		=$res1->mobile;
$company_phone		=$res1->phone;
$company_email		=$res1->email;
$company_country	=$res1->country;
$company_state		=$res1->state;
$company_city		=$res1->city;
$company_address	=$res1->address;
$company_postcode	=$res1->postcode;
$company_gst_no		=$res1->gst_no;//Goods and Service Tax Number (issued by govt.)
$company_vat_number		=$res1->vat_no;//Goods and Service Tax Number (issued by govt.)
$website            =$res1->website;

$q3=$this->db->query("SELECT a.customer_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,
				   a.opening_balance,a.country_id,a.state_id,
				   a.postcode,a.address,b.sales_date,b.created_time,b.reference_no,
				   b.sales_code,b.sales_note,
				   coalesce(b.grand_total,0) as grand_total,
				   coalesce(b.subtotal,0) as subtotal,
				   coalesce(b.paid_amount,0) as paid_amount,
				   coalesce(b.other_charges_input,0) as other_charges_input,
				   other_charges_tax_id,
				   coalesce(b.other_charges_amt,0) as other_charges_amt,
				   discount_to_all_input,
				   b.discount_to_all_type,
				   coalesce(b.tot_discount_to_all_amt,0) as tot_discount_to_all_amt,
				   coalesce(b.round_off,0) as round_off,
				   b.payment_status

				   FROM db_customers a,
				   db_sales b 
				   WHERE 
				   a.`id`=b.`customer_id` AND 
				   b.`id`='$sales_id'  ");
				   
				 //  echo $this->db->last_query(); die;
				   /*GROUP BY 
				   b.`customer_code`*/

$res3=$q3->row();
$customer_name=$res3->customer_name;
$customer_mobile=$res3->mobile;
$customer_phone=$res3->phone;
$customer_email=$res3->email;
$customer_country=$res3->country_id;
$customer_state=$res3->state_id;
$customer_address=$res3->address;
$customer_postcode=$res3->postcode;
$customer_gst_no=$res3->gstin;
$customer_tax_number=$res3->tax_number;
$customer_opening_balance=$res3->opening_balance;
$sales_date=show_date($res3->sales_date);
$reference_no=$res3->reference_no;
$created_time=show_time($res3->created_time);
$sales_code=$res3->sales_code;
$sales_note=$res3->sales_note;


$subtotal=$res3->subtotal;
$grand_total=$res3->grand_total;
$other_charges_input=$res3->other_charges_input;
$other_charges_tax_id=$res3->other_charges_tax_id;
$other_charges_amt=$res3->other_charges_amt;
$paid_amount=$res3->paid_amount;
$discount_to_all_input=$res3->discount_to_all_input;
$discount_to_all_type=$res3->discount_to_all_type;
//$discount_to_all_type = ($discount_to_all_type=='in_percentage') ? '%' : 'Fixed';
$tot_discount_to_all_amt=$res3->tot_discount_to_all_amt;
$round_off=$res3->round_off;
$payment_status=$res3->payment_status;

if($discount_to_all_input>0){
$str="($discount_to_all_input%)";
}else{
$str="(Fixed)";
}

if(!empty($customer_country)){
$customer_country = $this->db->query("select country from db_country where id='$customer_country'")->row()->country;  
}
if(!empty($customer_state)){
$customer_state = $this->db->query("select state from db_states where id='$customer_state'")->row()->state;  
}






   $printer = new Printer($connector);
   $printer->setJustification(Printer::JUSTIFY_CENTER);
   $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
   $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
   $printer -> text("$company_name"."\n");
   $printer->selectPrintMode();
   $printer -> text($company_address."\n");
   $printer -> text($company_city."\n");
   $printer -> text($company_gst_no);
   $printer -> text("ABN Number:".$company_vat_number."\n");
   $printer -> text("Phone:".$company_mobile."\n");
   $printer->feed(1);
   $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
   $printer -> text("KOT Number    ".$sales_code."\n");
   
   $texttoprint2 = sprintf('%-4.30s %-20.30s %-3.5s',"#","Description","Qty"); 
   $printer->text($texttoprint2."\n");
   $printer->selectPrintMode();
   $i=0;
   $tot_qty=0;
   $subtotal=0;
   $tax_amt=0;
 //  $CAID=implode(",",$kot_cat);
   $q2=$this->db->query("select b.item_name,a.sales_qty,a.unit_total_cost,a.price_per_unit,a.tax_amt,c.tax,a.total_cost from db_salesitems a,db_items b,db_tax c where c.id=a.tax_id and b.id=a.item_id and a.sales_id='$sales_id' AND a.cat_id IN($CAID)");
   foreach ($q2->result() as $res2) {
	  $item_name = substr($res2->item_name,0,18).'...';
	  $m=++$i;
	  $sales_qty = $res2->sales_qty;
	//  $texttoprint .= sprintf('%s %s %f', $m,$item_name,$sales_qty); // very basic start: A string and a float
		$texttoprint = sprintf('%-4.30s %-22.30s %3.2f',$m,$item_name,$sales_qty); 
	//  $printer->text("{$m} {$item_name} -{$sales_qty} \n");
	$printer->text("{$texttoprint} \n");
   }	  
	
   $printer->feed(1);
 $printer -> setUnderline(0); // Reset
 $printer->  text("\n");
$printer->  feed();
$printer->  feed();
$printer -> cut();
/* Close printer */
 $printer -> close();
} 

catch (Exception $e) {
   echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}
}
 }	
 
    
}
