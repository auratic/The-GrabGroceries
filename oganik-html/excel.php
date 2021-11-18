<?php
    require "config.php";

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date = date('Y-m-d H:i:s');

    $output = "";
    $sql="SELECT * FROM cust_receipt";
    $result=mysqli_query($link, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        $output .= '
            <table class="table" bordered="1">
                <tr>
                    <th>Receipt ID</th>
                    <th>Receipt Name</th>
                    <th>Transaction Date</th>
                    <th>Total (RM)</th>
                </tr>
        ';
        while($row=mysqli_fetch_assoc($result))
        {
            $output .='
                <tr>
                    <td>'.$row['receipt_id'].'</td>
                    <td>'.$row['receipt_lname'].' '.$row['receipt_fname'].'</td>
                    <td>'.$row['receipt_date'].'</td>
                    <td>'.$row['payment_cost'].'</td>
                </tr>
            ';
        }
        $output .= '</table>';
        header("Content-Type: application/xlsx");
        header("Content-Disposition: attactment; filename=Transaction ".$date.".xlsx");
        echo $output;
    }
?>