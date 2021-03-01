<div class="sales_item_modal">
   <div class="modal fade in" id="sales_item">
      <div class="modal-dialog ">
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center">Manage Sales Item</h4>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="row invoice-info">
                        <div class="col-sm-6 invoice-col">
                           <b>Item Name : </b> <span id='popup_item_name'><span>
                        </div>
                        <!-- /.col -->
                     </div>
                     <!-- /.row -->
                  </div>
                  <div class="col-md-12">
                     <div>
                        
                        <div class="col-md-12 ">
                           <div class="box box-solid bg-gray">
                              <div class="box-body">
                                 <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="popup_tax_type">Tax Type</label>
                                         <select class="form-control" id="popup_tax_type" name="popup_tax_id"  style="width: 100%;" >
                                          <option value="Exclusive">Exclusive</option>
                                           <option value="Inclusive">Inclusive</option>
                                          </select>
                                        </div>
                                   
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="popup_tax_id">Tax</label>
                                         <select class="form-control" id="popup_tax_id" name="popup_tax_id"  style="width: 100%;" >
                                            <?php
                                            $query2="select * from db_tax where status=1";
                                            $q2=$this->db->query($query2);
                                            if($q2->num_rows()>0)
                                             {
                                              echo '<option value="">-Select-</option>'; 
                                              foreach($q2->result() as $res1)
                                               {
                                                 echo "<option data-tax='".$res1->tax."' data-tax-value='".$res1->tax_name."' value='".$res1->id."'>".$res1->tax_name."</option>";
                                               }
                                             }
                                             else
                                             {
                                                ?>
                                                <option value="">No Records Found</option>
                                                <?php
                                             }
                                            ?>
                                                  </select>
                                        </div>
                                   
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                          <label for="popup_tax_type">Description</label>
                                         <textarea type="text" class="form-control" id="popup_description" placeholder=""></textarea>
                                        </div>
                                   
                                    </div>

                                    <!-- <div class="col-md-6">
                                       <div class="">
                                          <label for="popup_tax_amt">Tax Amount</label>
                                          <input type="text" class="form-control text-right paid_amt" id="popup_tax_amt" name="popup_tax_amt" readonly>
                                          <span id="popup_tax_amt_msg"  style="display:none" class="text-danger"></span>
                                       </div>
                                    </div> -->

                                    <div class="clearfix"></div>
                                 </div>
                                 
                              </div>
                           </div>
                        </div>
                        <!-- col-md-12 -->
                     </div>
                  </div>
                  <!-- col-md-9 -->
                  <!-- RIGHT HAND -->
               </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="popup_row_id">
               <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
               <button type="button" onclick="set_info()" class="btn bg-green btn-lg place_order btn-lg">Set<i class="fa  fa-check "></i></button>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>

<div class="sales_item_modal">
   <div class="modal fade in" id="sales_discount_item">
      <div class="modal-dialog ">
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center">Manage Sales Item</h4>
            </div>
            <div class="modal-body">
               <div class="row">
                
                  <div class="col-md-12">
                     <div>
                        
                        <div class="col-md-12 ">
                           <div class="box box-solid bg-gray">
                              <div class="box-body">
                                
                                 <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="popup_tax_type">Discount Type</label>
                                         <select class="form-control" id="popup_discount_id" name="popup_discount_id"  style="width: 100%;" >
                                          <option value="1">Percentage</option>
                                           <option value="2">Fix</option>
                                          </select>
                                        </div>
                                   
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="popup_tax_type">Discount</label>
                                          <input type="text" class="form-control text-right discount_amt" id="discount_id" name="discount_id">
                                        </div>
                                   
                                    </div>

                                    <div class="clearfix"></div>
                                 </div> 
                                 
                                 
                              </div>
                           </div>
                        </div>
                        <!-- col-md-12 -->
                     </div>
                  </div>
                  <!-- col-md-9 -->
                  <!-- RIGHT HAND -->
               </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="popup_row_id_dis">
               <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
               <button type="button" onclick="set_discount_info()" class="btn bg-green btn-lg place_order btn-lg">save<i class="fa  fa-check "></i></button>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>


<div class="sales_item_modal modal_store">
   <div class="modal fade in" id="holdmodal">
      <div class="modal-dialog " >
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center">Hold List</h4>
            </div>
            <div class="modal-body">
               
                
                  
                              
                         <div class="row">
                  <div class="col-xs-12 text-center " >
                    <table class="table table-bordered" >
                      <thead>
                      <tr class="newrow" width="100%">
                        <td width="50%">Item ID</td>
                        <td>Date</td>
                        <td>Ref.ID</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                      </thead>
                      <tbody id="hold_invoice_list" style="max-height:300px;overflow-y: scroll;">
                       <?=$result?>
                      </tbody>
                    </table>
                  </div>
                </div>
                 
            </div>
            
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>


<div class="sales_item_modal">
   <div class="modal fade in" id="sales_total_discount_item">
      <div class="modal-dialog ">
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center">Discount</h4>
            </div>
            <div class="modal-body">
               <div class="row">
                
                  <div class="col-md-12">
                     <div>
                        
                        <div class="col-md-12 ">
                           <div class="box box-solid bg-gray">
                              <div class="box-body">
                                
                                 <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="popup_tax_type">Discount Type</label>
                                         <select class="form-control" id="popup_discount_id2" name="popup_discount_id"  style="width: 100%;" >
                                          <option value="1">Percentage</option>
                                           <option value="2">Fix</option>
                                          </select>
                                        </div>
                                   
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="popup_tax_type">Discount</label>
                                          <input type="text" class="form-control text-right discount_amt_all" id="discount_amt_all" name="discount_id">
                                        </div>
                                   
                                    </div>

                                    <div class="clearfix"></div>
                                 </div> 
                                 
                                 
                              </div>
                           </div>
                        </div>
                        <!-- col-md-12 -->
                     </div>
                  </div>
                  <!-- col-md-9 -->
                  <!-- RIGHT HAND -->
               </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="popup_row_id_dis">
               <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
               <button type="button" onclick="set_all_discount_info()" class="btn bg-green btn-lg place_order btn-lg">save<i class="fa  fa-check "></i></button>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>


<div class="sales_item_modal">
   <div class="modal fade in come-from-modal right" id="cashinoutmodal">
      <div class="modal-dialog " >
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center">Cash In/Out</h4>
            </div>
            <div class="modal-body">
                                  <div class="row">
                                     <div class="col-md-12">
                                        <div class="form-group">
                                          <label for="popup_tax_type">Cash Type</label>
                                         <select class="form-control" id="cash_type" name="cash_type">
                                             <option value="2">Cash Out</option>
                                             <option value="1">Cash In</option>
                                         </select>
                                        </div>
                                   
                                    </div>
                                    <div class="clearfix"></div>
                                 </div> 
                                 <div class="row">
                                     <div class="col-md-12">
                                        <div class="form-group">
                                          <label for="popup_tax_type">Amount</label>
                                         <input type="text" class="form-control  amount_cashout" id="amount_cashout" name="amount_cashout">
                                        </div>
                                   
                                    </div>
                                    <div class="clearfix"></div>
                                 </div> 
                                
                                
                                <div class="row">
                                     <div class="col-md-12">
                                        <div class="form-group">
                                          <label for="popup_tax_type">Descrptions</label>
                                         <textarea id="cashout_desc" class="form-control" rows="3"></textarea>
                                        </div>
                                   
                                    </div>
                                    <div class="clearfix"></div>
                                </div> 
                                <div class="row">
                                     <div class="col-md-12">
                                     <button type="button"  class="btn bg-green btn-lg cashoutbtn btn-lg">save<i class="fa  fa-check "></i></button>   
                                    </div>
                                    <div class="clearfix"></div>
                                 </div> 
                             
                             
                             
                             
                              
                        
                 
            </div>
            
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>

<div class="sales_item_modal">
   <div class="modal fade in come-from-modal right" id="shiftinoutmodal">
      <div class="modal-dialog " >
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center">Cash In/Out</h4>
            </div>
            <div class="modal-body">
                                 
                                 <div class="row">
                                     <div class="col-md-12">
                                        <div class="form-group">
                                          <label for="popup_tax_type">Amount</label>
                                         <input type="text" class="form-control  amount_cashout_shift" id="amount_cashout_shift" name="amount_cashout_shift">
                                        </div>
                                   
                                    </div>
                                    <div class="clearfix"></div>
                                 </div> 
                                
                                
                                <div class="row">
                                     <div class="col-md-12">
                                        <div class="form-group">
                                          <label for="popup_tax_type">Descrptions</label>
                                         <textarea id="cashout_desc_shift" class="form-control" rows="3"></textarea>
                                        </div>
                                   
                                    </div>
                                    <div class="clearfix"></div>
                                </div> 
                                <div class="row">
                                     <div class="col-md-12">
                                     <button type="button"  class="btn bg-green btn-lg shiftbtn btn-lg">save<i class="fa  fa-check "></i></button>   
                                    </div>
                                    <div class="clearfix"></div>
                                 </div> 
                             
                             
                             
                             
                              
                        
                 
            </div>
            
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>



<div class="sales_item_modal">
   <div class="modal fade in" id="pickupmodal">
      <div class="modal-dialog " >
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center">Pickup List</h4>
            </div>
            <div class="modal-body">
               
                
                  
                              
                         <div class="row">
                  <div class="col-xs-12 text-center " >
                    <table class="table table-bordered" width="100%">
                      <thead>
                      <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>KOT</th>
                        <th>Bill</th>
                      </tr>
                      </thead>
                      <tbody>
                       <?php
                       $str ='';
                         $q2=$this->db->query("select * from db_sales  where status=1 order by id desc limit 0,5");
          if($q2->num_rows()>0){
            foreach($q2->result() as $res2){
                 $url=base_url()."pos/print_kot_pos/".$res2->id;
                  $str =$str."<tr>";
                  $str =$str."<td>".$res2->sales_code."</td>";
                  $str =$str."<td>".show_date($res2->sales_date)."</td>";
                  $str =$str."<td>".$res2->grand_total."</td>";
                 $str =$str."<td>";
                  	
                  
                  	$str =$str.'<a class="fa fa-fw fa-edit text-success" style="cursor: pointer;font-size: 20px;" onclick="print_kot_pos('.$res2->id.')" title="Print KOT?"></a>';
                  $str =$str."</td>";
                   $str =$str."<td>";
                 $str =$str.'<a class="fa fa-fw fa-print text-success" style="cursor: pointer;font-size: 20px;" onclick="print_invoice('.$res2->id.')" title="Print Bill?"></a>';
                  $str =$str."</td>";
                $str =$str."</tr>";
         
              
              }//for end
          }//if num_rows() end
          else{
          	
          	$str =$str."<tr>";
          		$str =$str.'<td colspan="4" class="text-danger text-center">No Records Found</td>';
          	$str =$str.'</tr>';
          	
          }
          echo $str;
                       ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                 
            </div>
            
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>



<div class="sales_item_modal">
   <div class="modal fade in come-from-modal right" id="runningmodal">
      <div class="modal-dialog modal-lg" >
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center">Running Order List</h4>
            </div>
            <div class="modal-body">
               
                  <div class="row m-0" id="latest_running_orders_ajax">
                      
                      
                    
                 
                 
             </div>
             
         </div>  
                  
                              
                        
                 
            </div>
            
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>












<div class="sales_item_modal">
   <div class="modal fade in" id="extradescmodal">
      <div class="modal-dialog " >
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center">Update Product Name</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                        <label for="popup_tax_type">Descrptions</label>
                        <input type="text" class="form-control" id="short_desc"  name="short_desc">
                        </div>
                    </div>
                </div>
            </div>
              <div class="modal-footer">
              <input type="hidden" id="current_item_id">
              <input type="hidden" id="rowcnt_desc">
               <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
               <button type="button"  class="btn bg-green btn-lg short_desc_btn btn-lg">save<i class="fa  fa-check "></i></button>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>


<div class="sales_item_modal">
   <div class="modal fade in" id="refundmodal">
      <div class="modal-dialog " >
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center">Cash In/Out</h4>
            </div>
            <div class="modal-body">
               
            <div class="row">
            <div class="col-md-12">
            <div class="form-group">
                <label for="popup_tax_type">Notes</label>
                    <select  class="form-control" name="refund_type" id="refund_type">
                        <option value="1">Customer Didn’t Like</option>
                        <option value="2">Product Damaged (Wastage Bin)
                        <option value="3">Product Expired (Wastage Bin)</option>
                        <option value="4">Product Issue</option>
                        <option value="5">Wrong Purchase</option>
                        <option value="6">High Price</option>
                        <option value="7">Other</option>
                    </select>
            </div>
            </div>
            <div class="clearfix"></div>
            </div>              
                             
                              
                        
                 
            </div>
             <div class="modal-footer">
              <input type="hidden" id="current_item_id">
              <input type="hidden" id="rowcnt_desc">
               <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
               <button type="button"  class="btn bg-green btn-lg save_refund btn-lg">save<i class="fa  fa-check "></i></button>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>

<div class="modal fade" id="myModalmodifier">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Product Details -->
                    <div class="modal-body ">
                      <div class="modal-body p-2">
<div class="productDetailModal">



</div>
                    </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="sales_item_modal">
   <div class="modal fade in come-from-modal right" id="placeorder_modal">
      <div class="modal-dialog modal-lg" >
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center">Table List</h4>
            </div>
            <div class="modal-body" id="running_table_list">
                
                
                
                
           
            
            </div>
             <div class="modal-footer">
              <input type="hidden" id="current_item_id">
              <input type="hidden" id="rowcnt_desc">
                <input type="hidden"  id="order_type"  value="1">
                <input type="hidden"  class="form-control table_number" name="table_number" id="table_number">
              <input type="hidden"  class="form-control " name="order_number" id="order_number">
               <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
               <button type="button"  class="btn bg-green btn-lg save_place_order btn-lg d-none">Save<i class="fa  fa-check "></i></button>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>



 <div class="sales_item_modal">
   <div class="modal fade in" id="card_modal">
      <div class="modal-dialog modal-sm" >
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center">card payment</h4>
            </div>
            <div class="modal-body">
                            
            
            <div class="row">
            <div class="col-md-12 ">
                <div class="form-group">
                    <label for="email">Amount</label>
                    <?php 
                    
                    
                     $CI =& get_instance();
                    $cashier_id=$CI->session->userdata('inv_userid');
                   if($orderId=="" || $orderId=='0'){
                        $cashier_id=$this->session->userdata('inv_userid');
                        $zerorow=$this->db->query("select count(*) as total_qty ,sum(total_price) as total_amount from db_poscart_all WHERE cashier_id='$cashier_id' ");
                        $newd=$zerorow->num_rows();
                        $row_data=$zerorow->row_array();
                        $qty_card = $row_data['total_qty'];
                        $zerorow2=$this->db->query("select count(*) as total_qty2 ,sum(total_price) as total_amount2 from db_pos_cart_addon  where cashier_id='$cashier_id'");
                        $newd2=$zerorow2->num_rows();
                        $row_data2=$zerorow2->row_array();
                        $all_amount = $row_data['total_amount']+$row_data2['total_amount2'];
                        
                        
                        }else{
                          $cashier_id=$this->session->userdata('inv_userid');
                        $zerorow=$this->db->query("select sum(grand_total) as total_amount from db_sales WHERE id='$orderId' ");
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
                        
                        
                        }
                    ?>
                    <input readonly="true" type="text" class="form-control" id="card_amount_detail" value="<?php echo $all_amount; ?>">
                </div>
                
                <?php
                if($this->session->userdata('session_price_id')=='' || $this->session->userdata('session_price_id')=='0')
                {
                ?>
                <div class="form-group">
                    <label for="email">Card Number</label>
                    <input type="text" class="form-control" id="card_number" placeholder="Last 4 digit card number">
                </div>
                <div class="form-group">
                    <label for="email">Name</label>
                    <input type="text" class="form-control" id="card_name">
                </div>
                <div class="form-group">
                    <label for="email">Mobile</label>
                    <input type="text" class="form-control" id="card_mobile">
                     <input type="hidden" class="form-control price_id"  value="0">
                </div>
            </div>
            <?php
                }else{
                    if($this->session->userdata('session_price_id')==6){
                        $payfor='Uber Eats';
                    }
                    elseif($this->session->userdata('session_price_id')==7){
                        $payfor='Menulog';
                    }
                     elseif($this->session->userdata('session_price_id')==8){
                        $payfor='Doordash';
                    }else{
                        $payfor='thirdparty';
                    }
                    ?>
                    <div class="form-group">
                    <label for="email">Payment for</label>
                    <input type="text" class="form-control" id="card_namedfgg" disabled="disabled" value="<?php echo $payfor ?>">
                </div>
                    <input type="hidden" class="form-control price_id"  value="<?php echo $this->session->userdata('session_price_id'); ?>">
                    <?php
                }
            ?>
              <div class="clearfix"></div>
            </div>
            
            
            
             
            
            
            
            
            
            
            
            </div>
             <div class="modal-footer">
        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Back</button>
        <button type="button" class="btn btn-success btn-lg make_sale btn-lg" onclick="save_card(true)"><i class="fa  fa-print "></i> Enter</button>

      </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>





<div id="myModal" class="modal fade come-from-modal right" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header header-custom">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Table Layout</h4>
      </div>
      <div class="modal-body table-layout-modal">
       <div class="">
    
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        
        
        
        <?php
        $o=0;
        $CI = get_instance();
        $sql_table_result =$CI->db->query("select * from db_booking_area where status=1");
        $row_data=$sql_table_result->result_array();
        $tapnel_array=array();
        foreach($row_data as $row_table){
            $tapnel_array[]=$row_table['id'];
        if($o==0){
            $active='active';
        }else{
             $active='ggactive';
        }
        ?>
      <li class="<?php echo $active; ?>">
          <a href="#home<?php echo $row_table['id']; ?>" role="tab" data-toggle="tab">
             <?php
             echo $row_table['area'];
             ?>
          </a>
      </li>
      <?php
      $o++;
        }
      ?>
    </ul>
    
    <!-- Tab panes -->
    <div class="tab-content">
        <?php
        $m=0;
        foreach($tapnel_array as $row_table){
          if($m==0) {
              $active="active";
          } else{
              $active="notactive";
          }
            
        ?>
      <div class="tab-pane fade <?php echo $active; ?> in" id="home<?php echo $row_table; ?>">
          
          
          <div class="layout-table">
             <div class="row">
                 
                 <?php
                 $sql_ord=$CI->db->query("select id,order_number,table_number from db_sales where order_number!='0' AND is_order_running=1 and table_number!='0' and (payment_status='Unpaid' || payment_status IS NULL)");
                $result_ord=$sql_ord->result_array();
                foreach ($result_ord as $key => $field) {
        	        $table_list=$field['table_number'];
        	        $tablelist[]=$table_list;
                }
                 $area=$row_table;
                 $sql_table_result2 =$CI->db->query("select * from db_restaurant_tables where area='$area'");
                $row_data2=$sql_table_result2->result_array();
        
                  foreach($row_data2 as $row_table){
                      if(in_array($row_table['table_name'],$tablelist)){
                          $borderclass="borderclass";
                      }else{
                          $borderclass="nonborderclass";
                      }
                 ?>
                 
                 <div class="col-md-4 <?php echo $borderclass; ?>">
                     <div class="table-grid">
                         <h5>Table <span><?php echo  $row_table['table_name']; ?></span></h5>
                         <ul class="list-inline table-li-half">
                        <li><i class="las la-user-friends"></i> <span><?php echo  $row_table['table_capacity']; ?></span></li>
                        <li class="text-right"><i class="las la-chair"></i> <span><?php echo  $row_table['chair']; ?></span></li>
                         </ul>
                     </div>
                     </div>
                    <?php
        }
                    ?>
                     
                     
                        
                 </div>
             </div> 
              
          </div>
          <?php
          $m++;
        }
          ?>
      </div>
   
    </div>
    
</div>









      </div>
     
    </div>

  </div>
  
  








































<style>
 .modal_store input[type="radio"] {
	 display: none;
}
 .modal_store input[type="radio"]:not(:disabled) ~ label {
	 cursor: pointer;
}
 .modal_store input[type="radio"]:disabled ~ label {
	 color: rgba(188, 194, 191, 1);
	 border-color: rgba(188, 194, 191, 1);
	 box-shadow: none;
	 cursor: not-allowed;
}
 .modal_store label {
	 height: 100%;
	 display: block;
	 background: white;
	 border: 2px solid rgba(32, 223, 128, 1);
	 border-radius: 20px;
	 padding: 1rem;
	 margin-bottom: 1rem;
	 text-align: center;
	 box-shadow: 0px 3px 10px -2px rgba(161, 170, 166, 0.5);
	 position: relative;
}
 .modal_store input[type="radio"]:checked + label {
	 background: rgba(32, 223, 128, 1);
	 color: rgba(255, 255, 255, 1);
	 box-shadow: 0px 0px 20px rgba(0, 255, 128, 0.75);
}
 .modal_store input[type="radio"]:checked + label::after {
	 color: rgba(61, 63, 67, 1);
	 font-family: FontAwesome;
	 border: 2px solid rgba(29, 201, 115, 1);
	 content: "\f00c";
	 font-size: 24px;
	 position: absolute;
	 top: -25px;
	 left: 50%;
	 transform: translateX(-50%);
	 height: 50px;
	 width: 50px;
	 line-height: 50px;
	 text-align: center;
	 border-radius: 50%;
	 background: white;
	 box-shadow: 0px 2px 5px -2px rgba(0, 0, 0, 0.25);
}
 .modal_store input[type="radio"]#control_05:checked + label {
	 background: red;
	 border-color: red;
}
 .modal_store p {
	 font-weight: 900;
}
 @media only screen and (max-width: 700px) {
	 .modal_store section {
		 flex-direction: column;
	}
}
.modal-dialoghold{
    width:280px!important;
    height:350px!important;
}
.modal-bodytext{
   
    height:350px!important;
}
.newrow{
    width:280px!important;
}
</style>











