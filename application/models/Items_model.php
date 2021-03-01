<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items_model extends CI_Model {

	//Datatable start
	var $table = 'db_items as a';
	var $column_order = array( 'a.id','a.item_image','a.category_id','a.image_code','a.item_code','a.item_name','b.category_name','a.lot_number','c.unit_name','a.stock','a.alert_qty','a.sales_price','a.price2','a.price3','a.price4','a.price5','a.price6','a.price7','a.price8','a.price9','d.tax_name','d.tax','a.status','e.brand_name'); //set column field database for datatable orderable
	var $column_search = array( 'a.id','a.item_image','a.item_code','a.item_name','b.category_name','a.lot_number','c.unit_name','a.stock','a.alert_qty','a.sales_price','d.tax_name','d.tax','a.status','e.brand_name','a.custom_barcode'); //set column field database for datatable searchable 
	var $order = array('a.id' => 'desc'); // default order 
	var $order_asc = array('a.id' => 'asc'); // default order 
    var $order_price = array('a.sales_price' => 'asc'); // default order 
	public function __construct()
	{
		parent::__construct();
	}
		private function _get_datatables_query_asc($filter=null)
	{
		$this->db->select($this->column_order);
		$this->db->from($this->table);
		$this->db->select("CASE WHEN e.brand_name IS NULL THEN '' ELSE e.brand_name END AS brand_name");
		$this->db->join('db_brands as e','e.id=a.brand_id','left');

		$this->db->join('db_category as b','b.id=a.category_id','left');
		$this->db->join('db_units as c','c.id=a.unit_id','left');
		$this->db->join('db_tax as d','d.id=a.tax_id','left');

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if(@$_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, @$_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
		    if($filter!=null){
		        $order = $this->order_price;
		    }else{
			$order = $this->order_asc;
		  }
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	private function _get_datatables_query($filter=null)
	{
		$this->db->select($this->column_order);
		$this->db->from($this->table);
		$this->db->select("CASE WHEN e.brand_name IS NULL THEN '' ELSE e.brand_name END AS brand_name");
		$this->db->join('db_brands as e','e.id=a.brand_id','left');

		$this->db->join('db_category as b','b.id=a.category_id','left');
		$this->db->join('db_units as c','c.id=a.unit_id','left');
		$this->db->join('db_tax as d','d.id=a.tax_id','left');

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if(@$_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, @$_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
		    if($filter!=null){
		        $order = $this->order_price;
		    }else{
			$order = $this->order;
		  }
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	//Datatable end

	public function stock_entry($entry_date,$item_id,$qty='0'){
		$q1=$this->db->query("insert into db_stockentry(entry_date,item_id,qty,status) values('$entry_date',$item_id,$qty,1)");
		if(!$q1){
			return false;
		}
		else{
			return true;
		}
	}
	//Save Cutomers
	public function verify_and_save(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));

		$this->db->trans_begin();
		$this->db->trans_strict(TRUE);

		$file_name='';
		if(!empty($_FILES['item_image']['name'])){

			$new_name = time();
			$config['file_name'] = $new_name;
			$config['upload_path']          = './uploads/items/';
	        $config['allowed_types']        = 'jpg|png|jpeg';
	        $config['max_size']             = 2524;
	        $config['max_width']            = 2000;
	        $config['max_height']           = 2000;
	       
	        $this->load->library('upload', $config);

	        if ( ! $this->upload->do_upload('item_image'))
	        {	
	                $error = array('error' => $this->upload->display_errors());
	                print($error['error']);
	                exit();
	        }
	        else
	        {		
	        	$file_name=$this->upload->data('file_name');
	        	/*Create Thumbnail*/
	        	$config['image_library'] = 'gd2';
				$config['source_image'] = 'uploads/items/'.$file_name;
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width']         = 75;
				$config['height']       = 50;
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				//end

	        	
	        }
		}
		
		//Validate This items already exist or not
		$query=$this->db->query("select * from db_items where upper(item_name)=upper('$item_name')");
		if($query->num_rows()>0){
			return "Sorry! This Items Name already Exist.";
		}
		
		$qs5="select item_init from db_company";
		$q5=$this->db->query($qs5);
		$item_init=$q5->row()->item_init;

		//Create items unique Number
		$this->db->query("ALTER TABLE db_items AUTO_INCREMENT = 1");
		$qs4="select coalesce(max(id),0)+1 as maxid from db_items";
		$q1=$this->db->query($qs4);
		$maxid=$q1->row()->maxid;
		$item_code=$item_init.str_pad($maxid, 4, '0', STR_PAD_LEFT);
		//end
		$price2=$price2!=""?$price2:0;
		$price2=$price3!=""?$price3:0;
		$price2=$price4!=""?$price4:0;
		$price2=$price5!=""?$price5:0;
		$price2=$price6!=""?$price6:0;
		$price7=$price7!=""?$price7:0;
		$price8=$price8!=""?$price8:0;
		$price9=$price9!=""?$price9:0;
		$new_opening_stock = (empty($new_opening_stock)) ? 0 :$new_opening_stock;
		//$stock = $current_opening_stock + $new_opening_stock;
        $quick_food=$quick_food!=''?$quick_food:'0';
        $modifier=$modifier!=''?$modifier:'0';
		$alert_qty = empty(trim($alert_qty)) ? '0' : $alert_qty;
		$profit_margin = (empty(trim($profit_margin))) ? 'null' : $profit_margin;

		$expire_date= (!empty(trim($expire_date))) ? date('Y-m-d',strtotime($expire_date)) : null;

		$query1="insert into db_items(description,item_code,item_name,brand_id,category_id,sku,unit_id,alert_qty,lot_number,expire_date,
									price,price2,price3,price4,price5,price6,price7,price8,price9,tax_id,purchase_price,tax_type,profit_margin,
									sales_price,custom_barcode,
									system_ip,system_name,created_date,created_time,created_by,status,quick_food,modifier)

							values('$description','$item_code','$item_name','$brand_id','$category_id','$sku','$unit_id','$alert_qty','$lot_number','$expire_date',
									'$price','$price2','$price3','$price4','$price5','$price6','$price7','$price8','$price9','$tax_id','$purchase_price','$tax_type',$profit_margin,
									'$sales_price','$custom_barcode',
									'$SYSTEM_IP','$SYSTEM_NAME','$CUR_DATE','$CUR_TIME','$CUR_USERNAME',1,'$quick_food','$modifier')";
		
		$query1=$this->db->simple_query($query1);
		// echo $this->db->last_query(); die;
		if(!$query1){
			return "failed";
		}
		$item_id = $this->db->insert_id();
		if(!empty($new_opening_stock) && $new_opening_stock!=0){
			$q1=$this->stock_entry($CUR_DATE,$item_id,$new_opening_stock);
			if(!$q1){
				return "failed";
			}
		}
		//UPDATE itemS QUANTITY IN itemS TABLE
		$this->load->model('pos_model');				
		$q6=$this->pos_model->update_items_quantity($item_id);
		if(!$q6){
			return "failed";
		}
		if ($query1){
				
				if(!empty($file_name)){
					//echo "update db_items set item_image ='$file_name' where id=".$item_id;exit();
					$q1=$this->db->query("update db_items set item_image ='uploads/items/$file_name' where id=".$item_id);
				}
				$this->db->query("update db_items set expire_date=null where expire_date='0000-00-00'");
				$this->db->trans_commit();
				$this->session->set_flashdata('success', 'Success!! New Item Added Successfully!');
		        return "success";
		}
		else{
				$this->db->trans_rollback();
				//unlink('uploads/items/'.$file_name);
		        return "failed";
		}
		
	}

	//Get items_details
	public function get_details($id,$data){
		//Validate This items already exist or not
		$query=$this->db->query("select * from db_items where upper(id)=upper('$id')");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			$query=$query->row();
			$data['q_id']=$query->id;
			$data['item_code']=$query->item_code;
			$data['item_name']=$query->item_name;
			$data['description']=$query->description;
			$data['brand_id']=$query->brand_id;
			$data['category_id']=$query->category_id;
			$data['sku']=$query->sku;
			$data['unit_id']=$query->unit_id;
			$data['alert_qty']=$query->alert_qty;
			$data['price']=$query->price;
			$data['tax_id']=$query->tax_id;
			$data['purchase_price']=$query->purchase_price;
			$data['tax_type']=$query->tax_type;
			$data['profit_margin']=$query->profit_margin;
			$data['sales_price']=$query->sales_price;
			$data['stock']=$query->stock;
			$data['lot_number']=$query->lot_number;
			$data['custom_barcode']=$query->custom_barcode;
			$data['expire_date']=(!empty($query->expire_date)) ? show_date($query->expire_date):'';
			$data['quick_food']=$query->quick_food;
			$data['modifier']=$query->modifier;
			$data['avl_start_time']=$query->avl_start_time;
			$data['avl_close_time']=$query->avl_close_time;

			$data['price2']=$query->price2;
			$data['price3']=$query->price3;
			$data['price4']=$query->price4;
			$data['price5']=$query->price5;
			$data['price6']=$query->price6;
			$data['price7']=$query->price7;
			$data['price8']=$query->price8;
			$data['price9']=$query->price9;
			
			
				
			return $data;
		}
	}
	public function update_items(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));
		
		//Validate This items already exist or not
		$this->db->trans_begin();
		$query=$this->db->query("select * from db_items where upper(item_name)=upper('$item_name') and id<>$q_id");
		if($query->num_rows()>10){
			return "This Items Name already Exist.";
		}
		else{

			$file_name=$item_image='';
			if(!empty($_FILES['item_image']['name'])){

				$new_name = time();
				$config['file_name'] = $new_name;
				$config['upload_path']          = './uploads/items/';
		        $config['allowed_types']        = 'jpg|png|jpeg';
		        $config['max_size']             = 3024;
		        $config['max_width']            = 3000;
		        $config['max_height']           = 3000;
		       
		        $this->load->library('upload', $config);

		        if ( ! $this->upload->do_upload('item_image'))
		        {
		                $error = array('error' => $this->upload->display_errors());
		                print($error['error']);
		                exit();
		        }
		        else
		        {		
		        	$file_name=$this->upload->data('file_name');
		        	
		        	/*Create Thumbnail*/
		        	$config['image_library'] = 'gd2';
					$config['source_image'] = 'uploads/items/'.$file_name;
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width']         = 75;
					$config['height']       = 50;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					//end

					$item_image=" ,item_image='".$config['source_image']."' ";

		        }
			}
			$price2=$price2!=""?$price2:0;
			$price2=$price3!=""?$price3:0;
			$price2=$price4!=""?$price4:0;
			$price2=$price5!=""?$price5:0;
			$price2=$price6!=""?$price6:0;
			$price7=$price7!=""?$price7:0;
			$price8=$price8!=""?$price8:0;
			$price9=$price9!=""?$price9:0;
            $quick_food=$quick_food!=''?$quick_food:'0';
            $modifier=$modifier!=''?$modifier:'0';
            $avl_start_time=$avl_start_time!=''?date("H:i:s", strtotime($avl_start_time)):date("H:i:s", strtotime('10:00:00'));
            $avl_close_time=$avl_close_time!=''?date("H:i:s", strtotime($avl_close_time)):date("H:i:s", strtotime('6:00:00'));
			//$stock = $current_opening_stock + $new_opening_stock;
			$alert_qty = (empty(trim($alert_qty))) ? '0' : $alert_qty;
			$profit_margin = (empty(trim($profit_margin))) ? 'null' : $profit_margin;
			$expire_date= (!empty(trim($expire_date))) ? date('Y-m-d',strtotime($expire_date)) : 'null';
			$query1="update db_items set 
						item_name='$item_name',
						description='$description',
						brand_id='$brand_id',
						category_id='$category_id',
						sku='$sku',
						unit_id='$unit_id',
						alert_qty='$alert_qty',
						lot_number='$lot_number',
						expire_date='$expire_date',
						custom_barcode='$custom_barcode',
						price='$price',
						tax_id='$tax_id',
						purchase_price='$purchase_price',
						quick_food=$quick_food,
						modifier=$modifier,
						tax_type='$tax_type',
						profit_margin=$profit_margin,
						avl_start_time='$avl_start_time',
						avl_close_time='$avl_close_time',
						sales_price='$sales_price',
						price2='$price2',
						price3='$price3',
						price4='$price4',
						price5='$price5',
						price6='$price6',
						price7='$price7',
						price8='$price8',
						price9='$price9'
						$item_image 
						where id=$q_id";
					
			$query1=$this->db->query($query1);
			if(!$query1){
				return "failed";
			}
			if(!empty($new_opening_stock) && $new_opening_stock!=0){
				$q1=$this->stock_entry($CUR_DATE,$q_id,$new_opening_stock);
				if(!$q1){
					return "failed";
				}			
			}
			//UPDATE itemS QUANTITY IN itemS TABLE
			$this->load->model('pos_model');				
			$q6=$this->pos_model->update_items_quantity($q_id);
			if(!$q6){
				return "failed";
			}

			if ($query1){
				   $this->db->query("update db_items set expire_date=null where expire_date='0000-00-00'");
				   $this->db->trans_commit();
				   $this->session->set_flashdata('success', 'Success!! Item Updated Successfully!');
			        return "success";
			}
			else{
					$this->db->trans_rollback();
			        return "failed";
			}
		}
	}
	public function update_status($id,$status){
        $query1="update db_items set status='$status' where id=$id";
        if ($this->db->simple_query($query1)){
            echo "success";
        }
        else{
            echo "failed";
        }
	}
	public function delete_items_from_table($ids){
		$this->db->trans_begin();
		$q1=$this->db->query("delete from db_items where id in($ids)");
		$q2=$this->db->query("delete from db_stockentry where item_id in($ids)");
        if($q1 && $q2){
        	$this->db->trans_commit();
            echo "success";
        }
        else{
            echo "failed";
        }	
	}


	public function inclusive($price='',$tax_per){
		return $price/(($tax_per/100)+1)/10;
	}

	//GET Labels from Purchase Invoice
	public function get_purchase_items_info($rowcount,$item_id,$purchase_qty){
		$q1=$this->db->select('*')->from('db_items')->where("id=$item_id")->get();
		$tax=$this->db->query("select tax from db_tax where id=".$q1->row()->tax_id)->row()->tax;

		$info['item_id'] = $q1->row()->id;
		$info['item_name'] = $q1->row()->item_name;
		$info['item_available_qty'] = $q1->row()->stock;
		$info['item_sales_qty'] = $purchase_qty;

	    return $this->return_row_with_data($rowcount,$info);
	}

	public function get_items_info($rowcount,$item_id){
		$q1=$this->db->select('*')->from('db_items')->where("id=$item_id")->get();
		$tax=$this->db->query("select tax from db_tax where id=".$q1->row()->tax_id)->row()->tax;

		$info['item_id'] = $q1->row()->id;
		$info['item_name'] = $q1->row()->item_name;
		$info['item_available_qty'] = $q1->row()->stock;
		$info['item_sales_qty'] = 1;

		$this->return_row_with_data($rowcount,$info);
	}
	

	public function return_row_with_data($rowcount,$info){
		extract($info);

		?>
            <tr id="row_<?=$rowcount;?>" data-row='<?=$rowcount;?>'>
               <td id="td_<?=$rowcount;?>_1">
                  <!-- item name  -->
                  <input type="text" style="font-weight: bold;" id="td_data_<?=$rowcount;?>_1" class="form-control no-padding" value='<?=$item_name;?>' readonly >
               </td>
               <!-- Qty -->
               <td id="td_<?=$rowcount;?>_3">
                  <div class="input-group ">
                     <span class="input-group-btn">
                     <button onclick="decrement_qty(<?=$rowcount;?>)" type="button" class="btn btn-default btn-flat"><i class="fa fa-minus text-danger"></i></button></span>
                     <input typ="text" value="<?=$item_sales_qty;?>" class="form-control no-padding text-center" onkeyup="calculate_tax(<?=$rowcount;?>)" id="td_data_<?=$rowcount;?>_3" name="td_data_<?=$rowcount;?>_3">
                     <span class="input-group-btn">
                     <button onclick="increment_qty(<?=$rowcount;?>)" type="button" class="btn btn-default btn-flat"><i class="fa fa-plus text-success"></i></button></span>
                  </div>
               </td>
               
               <!-- Remove button -->
               <td id="td_<?=$rowcount;?>_16" style="text-align: center;">
                  <a class=" fa fa-fw fa-minus-square text-red" style="cursor: pointer;font-size: 34px;" onclick="removerow(<?=$rowcount;?>)" title="Delete ?" name="td_data_<?=$rowcount;?>_16" id="td_data_<?=$rowcount;?>_16"></a>
               </td>
              <input type="hidden" id="tr_available_qty_<?=$rowcount;?>_13" value="<?=$item_available_qty;?>">
               <input type="hidden" id="tr_item_id_<?=$rowcount;?>" name="tr_item_id_<?=$rowcount;?>" value="<?=$item_id;?>">
            </tr>
		<?php

	}
	public function xss_html_filter($input){
		return $this->security->xss_clean(html_escape($input));
	}

	public function preview_labels(){
		//print_r($_POST);exit();
		$CI =& get_instance();
		//Filtering XSS and html escape from user inputs 
		$company_name=$this->db->query("select company_name from db_company")->row()->company_name;
		$rowcount = $this->input->post('hidden_rowcount');
		?>
		<div style=" height:11in !important;  width:8.5in !important; line-height: 16px !important;">
			<div class="inner-div-2" style=" height:11in !important;  width:8.5in !important; line-height: 16px !important;">
				<div style="">

					<?php
					//Import post data from form
					for($i=1;$i<=$rowcount;$i++){
					
						if(isset($_POST['tr_item_id_'.$i]) && !empty($_POST['tr_item_id_'.$i])){
							

							$item_id 			=$this->xss_html_filter(trim($_POST['tr_item_id_'.$i]));
							$item_count 			=$this->xss_html_filter(trim($_POST['td_data_'.$i."_3"]));
							$res1=$this->db->query("select item_name,item_code,sales_price from db_items where id=$item_id")->row();

							$item_name =$res1->item_name;
							$item_code =$res1->item_code;
							$item_price =$res1->sales_price;

							for($j=1;$j<=$item_count;$j++){
							?>
							<div style="height:1in !important; line-height: 1in; width:3.6375in !important; display: inline-block;  " class="label_border text-center">
							<div style="display:inline-block;vertical-align:middle;line-height:16px !important;">
								<b style="display: block !important" class="text-uppercase"><?=$company_name;?></b>
									<span style="display: block !important">
									<?= $item_name;?>
									</span>
								<b>Price:</b>
								<span><?= $CI->currency($item_price);?></span>
								<img class="center-block" style="max-height: 0.35in !important; width: 100%; opacity: 1.0" src="<?php echo base_url();?>barcode/<?php echo $item_code;?>">

							</div>
							</div>
							<?php
							}
						}
					
					}//for end
					?>
					
					
				</div>
			</div>
		</div>
		<?php
		
	}


	public function delete_stock_entry($entry_id){
		$item_id = $this->input->post('item_id');
        $this->db->trans_begin();
		$q1=$this->db->query("delete from db_stockentry where id=$entry_id");
		if(!$q1){
			return "failed";
		}
		//UPDATE itemS QUANTITY IN itemS TABLE
		$this->load->model('pos_model');				
		$q6=$this->pos_model->update_items_quantity($item_id);

		if(!$q6){
			return "failed";
		}

		$this->session->set_flashdata('success', 'Success!! Item Opening Stock Entry Deleted!');
		$this->db->trans_commit();
		return "success";
	}
	
	public function item_home($catId){
	    $currenttime=date('H:i:s');    
	    $this->_get_datatables_query_asc();
	    $this->db->where('a.category_id',$catId);
	   // $this->db->where('a.avl_start_time <=',$currenttime);
      //  $this->db->where('a.avl_close_time >=',$currenttime);
	 //    $this->db->where('a.image_code!=',1);
	     $this->db->where('a.status',1);
	     // $this->db->order_by('a.sales_price',"desc");
	//	$this->db->limit(20,0);
		$query = $this->db->get();
	//	echo $this->db->last_query(); die;
		return $query->result();
		
	}
		public function item_home_withprice($catId){
		$currenttime=date('H:i:s');        
	    $this->_get_datatables_query();
	    $this->db->where('a.category_id',$catId);
	    $this->db->where('a.sales_price >',0);
	  //  $this->db->where('a.avl_start_time <=',$currenttime);
     //   $this->db->where('a.avl_close_time >=',$currenttime);
	 //    $this->db->where('a.image_code!=',1);
	     $this->db->where('a.status',1);
	     // $this->db->order_by('a.sales_price',"desc");
	//	$this->db->limit(20,0);
		$query = $this->db->get();
	//	echo $this->db->last_query(); die;
		return $query->result();
		
	}
	
	
	
	
    	public function item_home_filter($catId,$min,$max){
    	$currenttime=date('H:i:s');    
    	$dateRange = "a.sales_price BETWEEN '$max' AND '$min'";
	    $this->_get_datatables_query('1');
	   //  $this->db->where('a.avl_start_time <=',$currenttime);
      //  $this->db->where('a.avl_close_time >=',$currenttime);
	    $this->db->where('a.category_id',$catId);
	     $this->db->where('a.image_code!=',1);
	     $this->db->where('a.status',1);
	     $this->db->where($dateRange,NULL, FALSE);
	 //   $this->db->order_by('a.sales_price',"desc");
	    
		$this->db->limit(20,0);
		$query = $this->db->get();
	//	 echo $this->db->last_query(); die;
		return $query->result();
		
	}
    
    
    
    
    
    	public function item_list(){
	    $this->_get_datatables_query('1');
	   //  $this->db->where('a.image_code!=',1);
	 //    $this->db->order_by('a.sales_price',"desc");
		$this->db->limit(20,0);
		$query = $this->db->get();
	//	echo $this->db->last_query(); die;
		return $query->result();
    	}
    public function item_detail($Id){
	    $this->_get_datatables_query();
	    $this->db->where('a.id',$Id);
		$this->db->limit(1,0);
		$query = $this->db->get();
	//	echo $this->db->last_query(); die;
		return $query->result();
		
	}
	 public function getSingleColumnNameMultiple($expColumn,$table,$wherearray){
        $this->db->select($expColumn);
        $this->db->where($wherearray);
        $this->db->order_by($expColumn, "desc");
        $query = $this->db->get($table);
        $result = $query->row();
        //echo $this->db->last_query(); die;
        if($result){
            return $result->$expColumn ;
        }
        else{
            return "" ;
        }
    }   
    
    	public function item_search($item_text){
    	$currenttime=date('H:i:s');    
	    $this->_get_datatables_query();
	    $this->db->where('a.image_code!=',1);
	   // $this->db->where('a.avl_start_time <=',$currenttime);
       // $this->db->where('a.avl_close_time >=',$currenttime);
	    $this->db->like('a.item_name', $item_text);
	    $this->db->order_by('a.sales_price',"desc");
		$this->db->limit(15,0);
		$query = $this->db->get();
	   //echo $this->db->last_query(); die;
		return $query->result_array();
	}
    
    public function item_list_rand1(){
        $currenttime=date('H:i:s');
	    $this->_get_datatables_query();
	    $this->db->where('a.image_code!=',1);
	    $this->db->where('a.sales_price!=',0);
	  //  $this->db->where('a.avl_start_time <=',$currenttime);
       // $this->db->where('a.avl_close_time >=',$currenttime);
	    $this->db->order_by('rand()');
		$this->db->limit(24,0);
		$query = $this->db->get();
	//	echo $this->db->last_query(); die;
		return $query->result();
    }
    public function item_list_rand2(){
	    $this->_get_datatables_query();
	    $this->db->where('a.image_code!=',1);
	    $this->db->order_by('rand()');
		$this->db->limit(4,4);
		$query = $this->db->get();
	//	echo $this->db->last_query(); die;
		return $query->result();
    }
    public function item_list_rand3(){
	    $this->_get_datatables_query();
	    $this->db->where('a.image_code!=',1);
	    $this->db->order_by('rand()');
		$this->db->limit(4,8);
		$query = $this->db->get();
	//	echo $this->db->last_query(); die;
		return $query->result();
    }
    
    public function item_list_home1(){
	    $this->_get_datatables_query('1');
	   //  $this->db->where('a.image_code!=',1);
	 //    $this->db->order_by('a.sales_price',"desc");
		$this->db->limit(6,0);
		$query = $this->db->get();
	//	echo $this->db->last_query(); die;
		return $query->result();
    	}
    
    public function item_list_home2(){
	    $this->_get_datatables_query('1');
	   //  $this->db->where('a.image_code!=',1);
	 //    $this->db->order_by('a.sales_price',"desc");
		$this->db->limit(6,6);
		$query = $this->db->get();
	//	echo $this->db->last_query(); die;
		return $query->result();
    	}
    
    
    
}
