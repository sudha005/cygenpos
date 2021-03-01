<?php
$str = '';
$q2 = $this
    ->db
    ->query("select * from db_sales  where status=1   order by order_view desc limit 0,10");
if ($q2->num_rows() > 0)
{
    foreach ($q2->result() as $res2)
    {
        $bill = base_url() . 'pos?orderId=' . $res2->id;
        if($res2->payment_status=='Paid'||$res2->payment_status==='Paid'){
            $payment_status=1;
        }else{
          $payment_status=0;  
        }
        $str = $str . "<tr>";
        $str = $str . "<td><span  class='pickup_count' >".$q2->num_rows()."</span>" . $res2->sales_code . "</td>";
        $str = $str . "<td>" . show_date($res2->sales_date) . "</td>";
        $str = $str . "<td>" . $res2->grand_total . "</td>";

        $str = $str . "<td>";
        $str = $str . '<a payment_status="'.$payment_status.'" order_id_running="' . $res2->id . '" class="running_orderbill fa fa-fw fa-print text-success bill-btn" style="cursor: pointer;font-size: 20px;"  title="Print Bill?"></a>';
        $str = $str . "</td>";
        $str = $str . "</tr>";

    } //for end
    
} //if num_rows() end
else
{

    $str = $str . "<tr>";
    $str = $str . '<td colspan="4" class="text-danger text-center">No Records Found</td>';
    $str = $str . '</tr>';

}
echo $str;
?>
