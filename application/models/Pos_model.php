<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pos_model extends CI_Model {
	public function inclusive($price='',$tax_per){
		return ($tax_per!=0) ? $price/(($tax_per/100)+1)/10 : $tax_per;
	}

	public function get_details(){
		$data=$this->data;
		extract($data);
		extract($_POST);
		  $i=0;
		  $str='';
		  if(!empty($id)){
		  	$str="and a.category_id=$id";
		  }
		  if(!empty($subcatid)){
		  	$str="and a.subcategory_id=$subcatid";
		  }
		  $table='';
	      $q2=$this->db->query("select b.id as tax_id, a.*,b.tax,b.tax_name,a.tax_type,a.item_image from db_items a,db_tax b where b.id=a.tax_id and a.status=1 $str order by a.item_name ASC limit 0,100");
	      if($q2->num_rows()>0){
	        foreach($q2->result() as $res2){
	        	$item_tax_type = $res2->tax_type;
	        	$item_tax_id = $res2->tax_id;
	        	$item_sales_price = $res2->sales_price;
	        	$item_cost = $res2->purchase_price;
	        	$item_tax = $res2->tax;
	        	$item_tax_name = $res2->tax_name;
	        	$item_sales_qty = 1;
	        	
				$old_price= $res2->sales_price;
				
				$price_id=$this->session->userdata('session_price_id');
				//session_price_id
				
				if($price_id=='' || $price_id=='0'){
				$item_sales_price=  $res2->sales_price;
				}else{
				    if($price_id==6){
				    $item_sales_price=  $res2->price6;
				    }
				    elseif($price_id==7){
				        $item_sales_price=  $res2->price7;
				    }
				    elseif($price_id==8){
				        $item_sales_price=  $res2->price8;
				    }
				    else{
				       $item_sales_price=  $res2->sales_price; 
				    }
				}
	        	//Check Exculsive or Inclusive
	        	if($item_tax_type=='Exclusive'){
					//$single_unit_price = $item_sales_price;
					//$item_sales_price=$item_sales_price+ (($item_sales_price*$item_tax)/100);
					//$item_tax_amt = (($single_unit_price * $item_sales_qty)*$item_tax)/100;
				}
				else{//Inclusive	
					//$item_tax_amt=number_format($this->inclusive($item_sales_price,$item_tax),2,'.','');
					//$single_unit_price = $item_sales_price;
				}

				$item_tax_amt = ($item_tax_type=='Inclusive') ? calculate_inclusive($item_sales_price,$item_tax) :calculate_exclusive($item_sales_price,$item_tax);

				//$item_amount = ($item_sales_price * $item_sales_qty) + $item_tax_amt;
				//end 

	        	if($res2->stock <1){
	        		$str="zero_stock()";
	        		$disabled='';
	        		$bg_color="background-color:#c8c8c8";
	        	}
	        	else{
	        		$str="addrow($res2->id)";
	        		$disabled="disabled=disabled";
	        		$bg_color="background-color:#fff";
	        	}

	        	$img_src = (!empty($res2->item_image) && file_exists($res2->item_image)) ? base_url(return_item_image_thumb($res2->item_image)) : base_url('theme/images/logo-dark.jpg');

	        	$table .= '<div style="padding:2px;" class="col-md-3 col-xs-6 product-pos" id="item_parent_'.$i.'" '.$disabled.'>
	          <div class="box box-default item_box" id="div_'.$res2->id.'" onclick="'.$str.'"
	          				data-item-id="'.$res2->id.'"
	          				data-item-name="'.$res2->item_name.'"
	          				data-item-available-qty="'.$res2->stock.'"
	          				data-item-sales-price="'.$item_sales_price.'"
	          				data-item-cost="'.$item_cost.'"
	          				data-item-tax-id="'.$item_tax_id.'"
	          				data-item-tax-type="'.$item_tax_type.'"
	          				data-item-tax-value="'.$item_tax.'"
	          				data-item-tax-name="'.$item_tax_name.'"
	          				data-item-tax-amt="'.$item_tax_amt.'"
	           				style="max-height: 150px;min-height: 100px;border: 1px solid #d3d3d3;cursor: pointer;'.$bg_color.'">
	           	<span class="label label-danger pull-left" style="font-weight: bold;font-family: sans-serif;font-size:12px" >'.$item_sales_price.'</span>
	           	
	            <div >
	            
	              <lable class="text-center search_item" style="font-weight: bold;font-family: sans-serif;font-size:12px" id="item_'.$i.'">'.substr($res2->item_name,0,25).'</label>
	            </div>
	          </div>
	        </div>';
	          $i++;
	          }//for end
	          return $table;
	      }//if num_rows() end
	     
	}
	//CROSS SITE FILTER
	public function xss_html_filter($input){
		return $this->security->xss_clean(html_escape($input));
	}
	
	//Save Sales
	public function pos_save_update(){//Save or update sales
		$this->db->trans_begin();
		extract($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));
		//print_r($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));exit();

		//check payment method
		if(isset($by_cash) && $by_cash==true){ //by cash payment
			$by_cash=true;
			$payment_row_count=1;
		}else{ //by multiple payments
			$by_cash=false;
		}
		//end 

		$rowcount 			=$hidden_rowcount;
		$sales_date 		=date("Y-m-d",strtotime($CUR_DATE));
		//$points 			= (empty($points_use)) ? 'NULL' : $points_use;
		$discount_input 	= (empty($discount_input)) ? 'NULL' : $discount_input;
		$tot_disc 		= (empty($tot_disc) || $tot_disc==0) ? 'NULL' : $tot_disc;
		$tot_grand 		= (empty($tot_grand)) ? 'NULL' : $tot_grand;
		//$tot_grand		=round($tot_amt);
		$round_off = number_format($tot_grand-$tot_amt,2,'.','');
		

		//FIND CUSTOMER INFORMATION BY ITS ID
		$q1=$this->db->query("select customer_name,mobile from db_customers where id=$customer_id");
		$customer_name 	= $q1->row()->customer_name;
		$mobile 		= $q1->row()->mobile;

		
		if($command=='update'){
				$sales_entry = array(
		    				'sales_date' 				=> $sales_date,
		    				'sales_status' 				=> 'Final',
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
		    			);
					
				$q3 = $this->db->where('id',$sales_id)->update('db_sales', $sales_entry);

				$q11=$this->db->query("delete from db_salesitems where sales_id='$sales_id'");
				$q12=$this->db->query("delete from db_salespayments where sales_id='$sales_id'");
				if(!$q11 || !$q12){
					return "failed";
				}
		}
		else{
			//GET SALES INITIAL
			$q5=$this->db->query("select sales_init from db_company where id=1");
			$init=$q5->row()->sales_init;	
			

			//ORDER SALES CREATION
			$maxid=$this->db->query("SELECT COALESCE(MAX(id),0)+1 AS maxid FROM db_sales")->row()->maxid;
			$sales_code=$init.str_pad($maxid, 4, '0', STR_PAD_LEFT);

			$sales_entry = array(
		    				'sales_code' 				=> $sales_code, 
		    				'sales_date' 				=> $sales_date,
		    				'sales_status' 				=> 'Final',
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
		    			);

			$q3 = $this->db->insert('db_sales', $sales_entry);
			$sales_id = $this->db->insert_id();
		}
		//Import post data from form
		for($i=0;$i<$rowcount;$i++){
		
			if(isset($_REQUEST['tr_item_id_'.$i]) && trim($_REQUEST['tr_item_id_'.$i])!=''){
			
				//RECEIVE VALUES FROM FORM
				$item_id 	=$this->xss_html_filter(trim($_REQUEST['tr_item_id_'.$i]));
				$sales_qty 	=$this->xss_html_filter(trim($_REQUEST['item_qty_'.$item_id]));
				$price_per_unit =$this->xss_html_filter(trim($_REQUEST['sales_price_'.$i]));
				$tax_amt =$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_11']));
				$tax_type =$this->xss_html_filter(trim($_REQUEST['tr_tax_type_'.$i]));
				$tax_id =$this->xss_html_filter(trim($_REQUEST['tr_tax_id_'.$i]));
				$tax_value =$this->xss_html_filter(trim($_REQUEST['tr_tax_value_'.$i]));//%
				$total_cost =$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_4']));
				$description =$this->xss_html_filter(trim($_REQUEST['description_'.$i]));
				
				$refund_id=$this->xss_html_filter(trim($_REQUEST['refund_id_'.$i]));//refund_type_
				$refund_type=$this->xss_html_filter(trim($_REQUEST['refund_type_'.$i]));//refund_type_
				
				
				
				
				
				$unit_discount_per	=$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_8']))!=""?$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_8'])):0;
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
		    			);
				$q4 = $this->db->insert('db_salesitems', $salesitems_entry);

             
             
             






// for purchase return
if($refund_id!='0' && $refund_type!='0'){
  $qs5="select sales_return_init from db_company";
			$q5=$this->db->query($qs5);
			$sales_return_init=$q5->row()->sales_return_init;
            $reference_no=rand(102030,708090);
            $return_date=date('Y-m-d');
            $return_status=1;
			$this->db->query("ALTER TABLE db_salesreturn AUTO_INCREMENT = 1");
			$q4=$this->db->query("select coalesce(max(id),0)+1 as maxid from db_salesreturn");
			$maxid=$q4->row()->maxid;
			$return_code=$sales_return_init.str_pad($maxid, 4, '0', STR_PAD_LEFT);

		    $sales_entry = array(
		    				'sales_id' 		=> $sales_id,
		    				'return_code' 				=> $return_code, 
		    				'reference_no' 				=> $reference_no, 
		    				'return_date' 				=> $return_date,
		    				'return_status' 			=> $return_status,
		    				'customer_id' 				=> $customer_id,
		    				/*'warehouse_id' 				=> $warehouse_id,*/
		    				/*Other Charges*/
		    				'other_charges_input' 		=> 0,
		    				'other_charges_tax_id' 		=> 1,
		    				'other_charges_amt' 		=> 0,
		    				/*Discount*/
		    				'discount_to_all_input' 	=> 0,
		    				'discount_to_all_type' 		=> 0,
		    				'tot_discount_to_all_amt' 	=> 0,
		    				/*Subtotal & Total */
		    				'subtotal' 					=> $price_per_unit,
		    				'round_off' 				=> $price_per_unit,
		    				'grand_total' 				=> $price_per_unit,
		    				'return_note' 				=> $return_type,
		    				/*System Info*/
		    				'created_date' 				=> $CUR_DATE,
		    				'created_time' 				=> $CUR_TIME,
		    				'created_by' 				=> $CUR_USERNAME,
		    				'system_ip' 				=> $SYSTEM_IP,
		    				'system_name' 				=> $SYSTEM_NAME,
		    				'status' 					=> 1,
		    			);

			$q1 = $this->db->insert('db_salesreturn', $sales_entry);
			
			$return_id = $this->db->insert_id();
			
			$salesitems_entry = array(
							'sales_id' 		=> $sales_id,
		    				'return_id' 			=> $return_id, 
		    				'return_status'		=> $return_status, 
		    				'item_id' 			=> $item_id, 
		    				'return_qty' 		=> 1,
		    				'price_per_unit' 	=> $price_per_unit,
		    				'tax_id' 			=> $tax_id,
		    				'tax_amt' 			=> $tax_amt,
		    				'unit_discount_per' => $unit_discount_per,
		    				'discount_amt' 		=> $discount_amt,
		    				'unit_total_cost' 	=> $single_unit_total_cost,
		    				'total_cost' 		=> $single_unit_total_cost,
		    				'status'	 		=> 1,

		    			);

				$q2 = $this->db->insert('db_salesitemsreturn', $salesitems_entry);
			
			
			
			
			
			
}
//end purchase return 

















				$q11=$this->update_items_quantity($item_id);
				if(!$q11){
					return "failed";
				}

			}
			
			
			
			
			
			
			
		
		}//for end

		//UPDATE CUSTMER MULTPLE PAYMENTS
		for($i=1;$i<=$payment_row_count;$i++){
		
			if((isset($_REQUEST['amount_'.$i]) && trim($_REQUEST['amount_'.$i])!='') || ($by_cash==true)){

				if($by_cash==true){
					//RECEIVE VALUES FROM FORM
					$amount 		=$tot_grand;
					$payment_type 	='Cash';
					$payment_note 	='Paid By Cash';
				}
				else{
					//RECEIVE VALUES FROM FORM
					$amount 		=$this->xss_html_filter(trim($_REQUEST['amount_'.$i]));
					$payment_type 	=$this->xss_html_filter(trim($_REQUEST['payment_type_'.$i]));
					$payment_note 	=$this->xss_html_filter(trim($_REQUEST['payment_note_'.$i]));
				}

				//If amount is greater than paid amount
				$change_return=0;
				if($amount>$tot_grand){
					$change_return =$amount-$tot_grand;
					$amount =$tot_grand;
				}
				//end
				
				$salespayments_entry = array(
					'sales_id' 		=> $sales_id, 
					'payment_date'		=> $sales_date,//Current Payment with sales entry
					'payment_type' 		=> $payment_type,
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
               
               $sql_cashier=$this->db->query("select * from db_cashier_transaction where user_id='$user_id' AND date_payment='$date_payment' AND draw_session='0' ORDER BY id desc ");
               $countrecod=$sql_cashier->num_rows();
               if($countrecod > 0){
                   $data=$sql_cashier->row_array();
                   $card_payment=$data['card_payment']!="0"?$data['card_payment']:0;
                   $cash_payment=$data['cash_payment']!="0"?$data['cash_payment']:0;
                   if($payment_type=='Cash'){
                       $cash_paymentnew=$cash_payment+$amount;
                   }else{
                       $card_paymentnew=$card_payment+$amount;
                   }
                   
                 $sql_cashier_update=$this->db->query("UPDATE  db_cashier_transaction SET card_payment='$card_paymentnew',cash_payment='$cash_paymentnew' where user_id='$user_id' AND date_payment='$date_payment' AND draw_session='0' ");  
               }else{
                   
                    if($payment_type=='Card'){
                        $cash_paymentnew=$amount;
                        $card_paymentnew=0;
                   }else{
                        $cash_paymentnew=0;
                        $card_paymentnew=$amount;
                   }
                   
                   
                   $data_array=array(
                       'user_id'=>$user_id,
                       'date_payment'=>$date_payment,
                       'cash_payment'=>$cash_paymentnew,
                       'card_payment'=>$card_paymentnew,
                       'status'      =>1,
                       'draw_session'=>0
                       );
                   
                   $q788 = $this->db->insert('db_cashier_transaction', $data_array);
                   
                   
               }










			    if(!$q7)
				{
					echo "q7\n";	
					return "failed";
				}
				
			}//if()
		
		}//for end

	
		//UPDATE itemS QUANTITY IN itemS TABLE
		$this->load->model('sales_model');				
		$q6=$this->sales_model->update_sales_payment_status($sales_id,$customer_id);
		if(!$q6){
			return "failed";
		}

		if(isset($hidden_invoice_id) && !empty($hidden_invoice_id)){
			$q13=$this->hold_invoice_delete($hidden_invoice_id);
			if(!$q13){
				return "failed";
			}
		}
		//COMMIT RECORD
		$this->db->trans_commit();
		
		$sms_info='';
		if(isset($send_sms) && $customer_id!=1){
			if(send_sms_using_template($sales_id,1)==true){
				$sms_info = 'SMS Has been Sent!';
			}else{
				$sms_info = 'Failed to Send SMS';
			}
		}

		$this->session->set_flashdata('success', 'Success!! Sales Created Successfully!'.$sms_info);
        return "success<<<###>>>$sales_id";


	}

	public function update_items_quantity($item_id){
		//UPDATE itemS QUANTITY IN itemS TABLE
		$q7=$this->db->query("select COALESCE(SUM(qty),0) as stock_qty from db_stockentry where item_id='$item_id'");
		$stock_qty=$q7->row()->stock_qty;

		$q8=$this->db->query("select COALESCE(SUM(purchase_qty),0) as pu_tot_qty from db_purchaseitems where item_id='$item_id' and purchase_status='Received'");
		$pu_tot_qty=$q8->row()->pu_tot_qty;
		
		$q9=$this->db->query("select coalesce(SUM(sales_qty),0) as sl_tot_qty from db_salesitems where item_id='$item_id' and sales_status='Final'");
		$sl_tot_qty=$q9->row()->sl_tot_qty;

		/*Fid Return Items Count*/
		$q6=$this->db->query("select COALESCE(SUM(return_qty),0) as pu_return_tot_qty from db_purchaseitemsreturn where item_id='$item_id' ");/*and purchase_id is null */
		$pu_return_tot_qty=$q6->row()->pu_return_tot_qty;

		/*Fid Return Items Count*/
		$q6=$this->db->query("select COALESCE(SUM(return_qty),0) as sl_return_tot_qty from db_salesitemsreturn where item_id='$item_id' ");/*and sales_id is null */
		$sl_return_tot_qty=$q6->row()->sl_return_tot_qty;

		$stock=((($stock_qty+$pu_tot_qty)-$sl_tot_qty)+$sl_return_tot_qty)-$pu_return_tot_qty;
		$q7=$this->db->query("update db_items set stock=$stock where id='$item_id'");
		if($q7){
			return true;
		}
		else{
			return false;
		}
	}	
	

	public function edit_pos($sales_id){
		$data=$this->data;
		extract($data);
	     $q2=$this->db->query("select * from db_sales where id='$sales_id'");
	    if($q2->num_rows()>0){
	      $res2=$q2->row();
	      $sales_date=show_date($res2->sales_date);
	      $customer_id=$res2->customer_id;
	      $discount_input=$res2->discount_to_all_input;
	      $discount_type=$res2->discount_to_all_type;
	      $grand_total=$res2->grand_total;
	      

	      $q3=$this->db->query("SELECT * FROM db_salesitems WHERE sales_id='$sales_id'");
		  $rows=$q3->num_rows();
		  if($rows>0){
		  	$i=0;
		  	
		  	foreach ($q3->result() as $res3) { 
		  		$q5=$this->db->query("select a.item_name,a.purchase_price,a.stock from db_items a where a.id=".$res3->item_id);
		  		$price_per_unit = $res3->price_per_unit;
		  		$description = $res3->description;
		  		$stock=$q5->row()->stock + $res3->sales_qty;

		  		$q6=$this->db->query("select * from db_tax where id=".$res3->tax_id)->row();

		  		//$item_tax_type = $q5->row()->tax_type;
	        	/*if($item_tax_type=='Exclusive'){
	        		$per_item_price_inc_tax=$price_per_unit+(($price_per_unit*$q5->row()->tax)/100);
				}
				else{//Inclusive	
					$per_item_price_inc_tax=$price_per_unit;
				}*/
				$per_item_price_inc_tax=$price_per_unit;
				$per_item_price_inc_tax=number_format($per_item_price_inc_tax,2,'.','');	

				$tax_amt = ($res3->tax_amt==null || $res3->tax_amt==NULL|| $res3->tax_amt=='')?"0.00":$res3->tax_amt;
				$tax_type = $res3->tax_type;
				$tax_id = $res3->tax_id;
				$tax_value = ($q6->tax==null || $q6->tax==NULL|| $q6->tax=='')?"0.00":$q6->tax;

		  		$quantity        ='<div class="input-group input-group-sm"><span class="input-group-btn"><button onclick="decrement_qty('.$res3->item_id.','.$i.')" type="button" class="btn btn-default btn-flat"><i class="fa fa-minus text-danger"></i></button></span>';
			    $quantity       .='<input typ="text" value="'.$res3->sales_qty.'" class="form-control text-center" onkeyup="item_qty_input('.$res3->item_id.','.$i.')" id="item_qty_'.$res3->item_id.'" name="item_qty_'.$res3->item_id.'">';
			    $quantity       .='<span class="input-group-btn"><button onclick="increment_qty('.$res3->item_id.','.$i.')" type="button" class="btn btn-default btn-flat"><i class="fa fa-plus text-success"></i></button></span></div>';
			    //$sub_total       =$per_item_price_inc_tax * $res3->sales_qty;
			    $sub_total = $res3->total_cost;
			    $remove_btn      ='<a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="removerow('.$i.')" title="Delete Item?"></a>';
			    
		  		echo '<tr id="row_'.$i.'" data-row="0" data-item-id="'.$res3->item_id.'" >'; /*item id */
		  		echo '<td id="td_'.$i.'_0">
		  		<a data-toggle="tooltip" title="Click to Change Tax" class="pointer" id="td_data_'.$i.'_0" onclick="show_sales_item_modal('.$i.')">'.$q5->row()->item_name.'<i onclick="" class="fa fa-edit pointer"></i></a>
		  		</td>';  /*td_0_0 item name*/
		  		echo '<td style="display:none" id="td_'.$i.'_1">'.$stock.'</td>';  /*td_0_1 item available qty*/
		  		echo '<td id="td_'.$i.'_2">'.$quantity.'</td>';    /*td_0_2 item available qty */

		  		$info = '<input id="sales_price_'.$i.'" onblur="set_to_original('.$i.','.$q5->row()->purchase_price.')" onkeyup="update_price('.$i.','.$q5->row()->purchase_price.')" name="sales_price_'.$i.'" type="text" class="form-control text-left no-padding" value="'.$per_item_price_inc_tax.'">';

		  		echo '<td id="td_'.$i.'_3" class="text-right" >'.$info.'</td>';    /*td_0_3 item sales price */
		  		echo '<td id="td_'.$i.'_11"><input data-toggle="tooltip" title="Click to Change" id="td_data_'.$i.'_11" onclick="show_sales_item_modal('.$i.')" name="td_data_'.$i.'_11" type="text" class="form-control no-padding pointer" readonly value="'.$tax_amt.'"></td>';
		  		echo '<td id="td_'.$i.'_4" class="text-right" >
		  		<input data-toggle="tooltip" title="Total" id="td_data_'.$i.'_4" name="td_data_'.$i.'_4" type="text" class="form-control no-padding pointer" readonly value="'.number_format($sub_total,2,'.','').'"></td>';    /*td_0_4 item sub_total */
		  		echo '<td id="td_'.$i.'_5">'.$remove_btn.'</td>';    /* td_0_5 item gst_amt  */

		  		echo '<input type="hidden" name="tr_item_id_'.$i.'" id="tr_item_id_'.$i.'" value="'.$res3->item_id.'">'; 
		  		echo '<input type="hidden" id="tr_item_per_'.$i.'" name="tr_item_per_'.$i.'" value="'.$q6->tax.'">';
		  		echo '<input type="hidden" id="tr_sales_price_temp_'.$i.'" name="tr_sales_price_temp_'.$i.'" value="'.$per_item_price_inc_tax.'">';
		  		echo '</tr>';
		  		echo '<input type="hidden" id="tr_tax_type_'.$i.'" name="tr_tax_type_'.$i.'" value="'.$tax_type.'">';
        		echo '<input type="hidden" id="tr_tax_id_'.$i.'" name="tr_tax_id_'.$i.'" value="'.$tax_id.'">';
        		echo '<input type="hidden" id="tr_tax_value_'.$i.'" name="tr_tax_value_'.$i.'" value="'.$tax_value.'">';
        		echo '<input type="hidden" id="description_'.$i.'" name="description_'.$i.'" value="'.$description.'">';
		  		
		  		$i++;
		  	}//foreach() end

		  	echo "<<<###>>>".$discount_input."<<<###>>>".$discount_type."<<<###>>>".$customer_id;

		  }//if ()
		 
	    }
	    else{
	      print "Record Not Available";
	    }
	     
	}//edit_pos()

	
	/* ######################################## HOLD INVOICE ############################# */
	public function hold_invoice(){
		$this->db->trans_begin();

		extract($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));
		$this->db->query("DELETE from temp_holdinvoice where invoice_id='$hidden_invoice_id'");
		$maxid=$this->db->query("select coalesce(max(id),0)+1 as maxid from temp_holdinvoice")->row()->maxid;
		
    	for ($i=0; $i < $hidden_rowcount; $i++) { 
    		if(isset($_POST['tr_item_id_'.$i])){
    		$item_id=$this->xss_html_filter($_POST['tr_item_id_'.$i]);
			$item_qty=$this->xss_html_filter($_POST['item_qty_'.$item_id]);
			$item_price=$this->xss_html_filter($_POST['tr_sales_price_temp_'.$i]);
			//$tax=$this->xss_html_filter($_POST['tr_item_per_'.$i]);
			
			
    		$q1=$this->db->simple_query("INSERT into temp_holdinvoice(invoice_id,reference_id,invoice_date,
    			item_id,item_qty,item_price,tax,
    			created_date,created_time,created_by,system_ip,system_name,status,pos)
				VALUES
				($maxid,'$reference_id','$CUR_DATE',
				$item_id,'$item_qty',
				$item_price,'',
				'$CUR_DATE','$CUR_TIME','$CUR_USERNAME','$SYSTEM_IP','$SYSTEM_NAME',1,1)");
    		if(!$q1){
				return "failed";
			}	
			
		  }//if row exist
    	}//for end()
	 	
		//COMMIT RECORD
		$this->db->trans_commit();
        return "success<<<###>>>$maxid";

	}
	
		public function save_cashin(){
		$this->db->trans_begin();

		extract($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));
			$user_id11= $_POST['user_id11'];
			$amount= $_POST['amount'];
		
    		$q1=$this->db->simple_query("INSERT into db_cash_in(amount,user_id,
    			created_date,created_time)
				VALUES
				('$amount','$user_id11',
				'$CUR_DATE','$CUR_TIME')");
    		if(!$q1){
				return "failed";
			}else{
            $this->session->set_userdata('cashin_added','1');
        }
    
	 	
		//COMMIT RECORD
		$this->db->trans_commit();
        return "Records Saved Successfully";

	}
	public function hold_invoice_list(){
		$data=$this->data;
		extract($data);
		extract($_POST);
		  $i=0;
		  $str ='';
	      $q2=$this->db->query("select * from temp_holdinvoice where status=1 group by invoice_id order by id desc");
	      if($q2->num_rows()>0){
	        foreach($q2->result() as $res2){
	     
                  $str =$str."<tr>";
                  $str =$str."<td>".$res2->id."</td>";
                  $str =$str."<td>".show_date($res2->invoice_date)."</td>";
                  $str =$str."<td>".$res2->reference_id."</td>";
                  $str =$str."<td>";
                  	$str =$str.'<a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="hold_invoice_delete('.$res2->invoice_id.')" title="Delete Invoive?"></a>';
                  	$str =$str.'<a class="fa fa-fw fa-edit text-success" style="cursor: pointer;font-size: 20px;" onclick="hold_invoice_edit('.$res2->invoice_id.')" title="Edit Invoive?"></a>';
                  $str =$str."</td>";
                $str =$str."</tr>";
	     
	          $i++;
	          }//for end
	      }//if num_rows() end
	      else{
	      	
	      	$str =$str."<tr>";
	      		$str =$str.'<td colspan="4" class="text-danger text-center">No Records Found</td>';
	      	$str =$str.'</tr>';
	      	
	      }
		return $str;
	}
	public function hold_invoice_delete($invoice_id){
		$this->db->trans_begin();
		$q1=$this->db->query("DELETE from temp_holdinvoice where invoice_id='$invoice_id'");
		if(!$q1){
			return "failed";
		}
		//COMMIT RECORD
		$this->db->trans_commit();
        return "success";

	}
	public function hold_invoice_edit(){
		extract($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));
		$display_json = array();
		$sql =$this->db->query("SELECT * from temp_holdinvoice where invoice_id='$invoice_id'");	
		foreach ($sql->result() as $res) {
		     $json_arr["id"] = $res->id;
			 $json_arr["item_id"] = $res->item_id;
		  	 $json_arr['item_qty']=$res->item_qty;
			 $json_arr['item_price']=$res->item_price;
			 $json_arr['item_tax']=$res->tax;
			 array_push($display_json, $json_arr);
		}
		return json_encode($display_json);
	}
	public function get_items_info($rowcount,$item_id){
		$q1=$this->db->select('*')->from('db_items')->where("id=$item_id")->get();
		$q3=$this->db->query("select * from db_tax where id=".$q1->row()->tax_id)->row();
       if($q1->row()->id > 0){
        $item_id = $q1->row()->id;
		$item_name = $q1->row()->item_name;
		$description = '0';//$q1->row()->description;
		$item_available_qty = $q1->row()->stock;
		$item_sales_price = $q1->row()->sales_price;
		//$info['item_tax_id'] = $q1->row()->tax_id;
		$item_tax_name = $q3->tax_name;
		$item_price= $q1->row()->price;
		$item_sales_qty = 1;
		$item_tax_id = $q3->id;
		$item_tax = $q3->tax;
		$item_tax_type = $q1->row()->tax_type;
		$item_discount = '';
		$item_tax_amt= ($q1->row()->tax_type=='Inclusive') ? calculate_inclusive($q1->row()->sales_price,$q3->tax) :calculate_exclusive($q1->row()->sales_price,$q3->tax);
        $data_rows=$item_id.'~'.$item_name.'~'.$description.'~'.$item_available_qty.'~'.$item_sales_price.'~'.$item_tax_name.'~'.$item_sales_qty.'~'.$item_tax_id.'~'.$item_tax.'~'.$item_tax_type.'~'.$item_discount.'~'.$item_tax_amt.'~'.$item_price;
        
       }else{
           $item_id= 0;
		$item_name =0;
		$description = '';//$q1->row()->description;
		$item_available_qty = 0;
		$item_sales_price = 0;
		//$info['item_tax_id'] =0;
		$item_tax_name = 0;
		$item_price = 0;
		$item_sales_qty = 1;
		$item_tax_id = 0;
		$item_tax = 0;
		$item_tax_type = 0;
		$item_discount = '';
		$item_tax_amt = 0;
        $data_rows=$item_id.'~'.$item_name.'~'.$description.'~'.$item_available_qty.'~'.$item_sales_price.'~'.$item_tax_name.'~'.$item_sales_qty.'~'.$item_tax_id.'~'.$item_tax.'~'.$item_tax_type.'~'.$item_discount.'~'.$item_tax_amt.'~'.$item_price;  
       }
       return $data_rows;
	}
	
	public function get_search_details(){
		$data=$this->data;
		extract($data);
		extract($_POST);
		  $i=0;
		  $str='';
		  if(!empty($srch_text)){
		  	$str=" AND a.item_name LIKE '%".TRIM($srch_text)."%'";
		 
		  }
		  $table='';
	      $q2=$this->db->query("select b.id as tax_id, a.*,b.tax,b.tax_name,a.tax_type,a.item_image from db_items a,db_tax b where b.id=a.tax_id and a.status=1 $str order by a.stock desc limit 0,50");
	   //    echo $this->db->last_query(); die;
	    if($q2->num_rows()<=0){
	        if(!empty($srch_text)){
	               $string="category_name LIKE '%".TRIM($srch_text)."%'";
	            	$str=" and a.category_id IN ('select id from db_category WHERE $string')";
		           //$str=" AND a.item_name LIKE '% ".$srch_text."%'";
		  	$q2=$this->db->query("select b.id as tax_id, a.*,b.tax,b.tax_name,a.tax_type,a.item_image from db_items a,db_tax b where b.id=a.tax_id and a.status=1 $str order by a.stock desc limit 0,50");
		 // echo $this->db->last_query(); die;
		  } 
	    }
	   else{
	   
	   
	      if($q2->num_rows()>0){
	          
	          
	          
	          
	          
	        foreach($q2->result() as $res2){
	        	$item_tax_type = $res2->tax_type;
	        	$item_tax_id = $res2->tax_id;
	        	$item_sales_price = $res2->sales_price;
	        	$item_cost = $res2->purchase_price;
	        	$item_tax = $res2->tax;
	        	$item_tax_name = $res2->tax_name;
	        	$item_sales_qty = 1;

	        	//Check Exculsive or Inclusive
	        	if($item_tax_type=='Exclusive'){
					//$single_unit_price = $item_sales_price;
					//$item_sales_price=$item_sales_price+ (($item_sales_price*$item_tax)/100);
					//$item_tax_amt = (($single_unit_price * $item_sales_qty)*$item_tax)/100;
				}
				else{//Inclusive	
					//$item_tax_amt=number_format($this->inclusive($item_sales_price,$item_tax),2,'.','');
					//$single_unit_price = $item_sales_price;
				}

				$item_tax_amt = ($item_tax_type=='Inclusive') ? calculate_inclusive($item_sales_price,$item_tax) :calculate_exclusive($item_sales_price,$item_tax);

				//$item_amount = ($item_sales_price * $item_sales_qty) + $item_tax_amt;
				//end 

	        	if($res2->stock <1){
	        		$str="zero_stock()";
	        		$disabled='';
	        		$bg_color="background-color:#c8c8c8";
	        	}
	        	else{
	        		$str="addrow($res2->id)";
	        		$disabled="disabled=disabled";
	        		$bg_color="background-color:#fff";
	        	}

	        	$img_src = (!empty($res2->item_image) && file_exists($res2->item_image)) ? base_url(return_item_image_thumb($res2->item_image)) : base_url('theme/images/logo-dark.jpg');

	        	$table .= '<div class="col-md-3 col-xs-6 " id="item_parent_'.$i.'" '.$disabled.'>
	          <div class="box box-default item_box" id="div_'.$res2->id.'" onclick="'.$str.'"
	          				data-item-id="'.$res2->id.'"
	          				data-item-name="'.$res2->item_name.'"
	          				data-item-available-qty="'.$res2->stock.'"
	          				data-item-sales-price="'.$item_sales_price.'"
	          				data-item-cost="'.$item_cost.'"
	          				data-item-tax-id="'.$item_tax_id.'"
	          				data-item-tax-type="'.$item_tax_type.'"
	          				data-item-tax-value="'.$item_tax.'"
	          				data-item-tax-name="'.$item_tax_name.'"
	          				data-item-tax-amt="'.$item_tax_amt.'"
	           				style="max-height: 150px;min-height: 100px;border: 1px solid #d3d3d3;cursor: pointer;'.$bg_color.'">
	           	<span class="label label-danger push-right" style="font-weight: bold;font-family: sans-serif;font-size:12px" >'.$item_sales_price.'</span>
	            <div class="box-body box-profile">
	            
	              <lable class="text-center search_item" style="font-weight: bold;font-family: sans-serif;font-size:12px" id="item_'.$i.'">'.substr($res2->item_name,0,25).'</label>
	            </div>
	          </div>
	        </div>';
	          $i++;
	          }//for end
	          return $table;
	      }//if num_rows() end
	     
	}
	
	}
	
		public function get_items_info_offer($rowcount,$item_id){
		$q1=$this->db->select('*')->from('db_items')->where("id=$item_id")->get();
		$q3=$this->db->query("select * from db_tax where id=".$q1->row()->tax_id)->row();
       if($q1->row()->id > 0){
        $item_id = $q1->row()->id;
		$item_name = $q1->row()->item_name;
		$description = '0';//$q1->row()->description;
		$item_available_qty = $q1->row()->stock;
		$item_sales_price = $q1->row()->sales_price;
		//$info['item_tax_id'] = $q1->row()->tax_id;
		$item_tax_name = $q3->tax_name;
		$item_price= $q1->row()->price;
		$item_sales_qty = 1;
		$item_tax_id = $q3->id;
		$item_tax = $q3->tax;
		$item_tax_type = $q1->row()->tax_type;
		$item_discount = '';
		$item_tax_amt= ($q1->row()->tax_type=='Inclusive') ? calculate_inclusive($q1->row()->sales_price,$q3->tax) :calculate_exclusive($q1->row()->sales_price,$q3->tax);
        $data_rows=$item_id.'~'.$item_name.'~'.$description.'~'.$item_available_qty.'~'.$item_sales_price.'~'.$item_tax_name.'~'.$item_sales_qty.'~'.$item_tax_id.'~'.$item_tax.'~'.$item_tax_type.'~'.$item_discount.'~'.$item_tax_amt.'~'.$item_price;
        
       }else{
          
        $data_rows=0;  
       }
       return $data_rows;
	}
	
	
}
