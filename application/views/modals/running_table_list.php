 <div class="row">
                
                 <?php
                $tablelist=array();
                $CI =& get_instance();
                $sql_ord=$CI->db->query("select id,order_number,table_number from db_sales where order_number!='0' AND is_order_running=1 and table_number!='0' and (payment_status='Unpaid' || payment_status IS NULL)");
                $result_ord=$sql_ord->result_array();
                foreach ($result_ord as $key => $field) {
        	        $table_list=$field['table_number'];
        	        $tablelist[]=$table_list;
                } 
                
              ?>
            </div>                  
             <div class="row" id="empty_table" >
            <div class="col-md-12 ">
            <div class="tabel-box">
                    <?php
                    $CI = get_instance();
                    $sql_table_result =$CI->db->query("select * from db_restaurant_tables");
                    $row_data=$sql_table_result->result_array();
                    foreach($row_data as $row_table){
                        if(!in_array($row_table['table_name'],$tablelist)){
                    ?>
                    <a style="cursor:pointer" class="allTbl" table_id="<?php echo $row_table['table_name']; ?>"><div class="table-number" id="tbldiv<?php echo $row_table['table_name']; ?>">
                    <span>Table</span><strong><?php echo $row_table['table_name']; ?></strong>    
                    </div></a>
                    <?php
                    }
                    }
                    ?>
                         
            </div>
            </div>
              <div class="clearfix"></div>
            </div>
            
            <div class="row" id="running_table" >
            <div class="col-md-12 ">
            <div class="tabel-box">
                    <?php
                   foreach($result_ord as $row){
                    ?>
                    <a style="cursor:pointer" class="allTbl" orderNumberid="<?php echo $row['id'] ?>"  table_id="<?php echo $row['table_number']; ?>"><div class="table-number" id="tbldiv<?php echo $row['table_number']; ?>">
                    <span>Table</span><strong><?php echo $row['table_number']; ?></strong>    
                    </div></a>
                    <?php
                    }
                    
                    ?>
                         
            </div>
            </div>
              <div class="clearfix"></div>
            </div>
            
            