 <?php
                       $str ='';
                         $q2=$this->db->query("select * from db_sales  where status=1 AND 	is_order_running=1 AND table_number > 0 order by id desc limit 0,15");
          if($q2->num_rows()>0){
            foreach($q2->result() as $res2){   
                       $bill=base_url().'pos?orderId='.$res2->id;
                       $url=base_url()."pos/print_kot_pos/".$res2->id;
                  ?>    
                      
                 <div class="col-md-3 pl-1 pr-1">
                 <div class="order-box-grid-pos position-relative">
                     <p class="order-p-pos">Ord <span><?php echo $res2->order_number; ?></span></p>
                        <p class="table-p-pos ">Table <span><?php echo $res2->table_number; ?></span></p>
                          <p class="amount-p-pos ">Amount <span>$<?php echo $res2->grand_total; ?></span></p>
                          <div class="text-center">
                             <a style="cursor:pointer" class="running_orderbill" order_id_running="<?php echo $res2->id; ?>"  class="bill-running-order">Bill</a> 
                              
                          </div>
               
                 </div>
                 </div>
                    
                 <?php
            }
            }else{
                ?>
                <div class="col-md-2 pl-1 pr-1">
                 <p>Order's Not found</p>
                 </div>
                <?php
            }
                 ?>
                 
                 