<?php
include 'cust_header.php';

if (!isset($_SESSION["loggedin"])) {
    echo "
        <script>
        Swal.fire({
            title: 'Error',
            text: 'Please log in.',
            icon: 'error'
        }).then(function() {
        location.href = 'login.php'
        })
        </script>";
}

$sql_receipt = "SELECT receipt_id FROM cust_receipt 
                  WHERE user_id = " . $_SESSION['userid'];
$receipt_array = array();

if ($receipt_result = mysqli_query($link, $sql_receipt)) {
    while ($receipt_row = mysqli_fetch_assoc($receipt_result)) {
        array_push($receipt_array, $receipt_row["receipt_id"]);
    }
}
?>

<!-- :::::::::: Profile :::::::::: -->
<?php include 'cust_profile_layout.php' ?>
<div class="col-xl-10 col-md-10">
    <div class="tab-content my-account-tab" id="pills-tabContent">
        <h4 class="account-title"><?php echo $lang['order']?></h4>

        <div class="panel-group" id="accordion">
            <div class="panel panel-default text-center">
                <?php
                if (count($receipt_array) == 0) {
                    echo "<h1 style='text-align: center'>You have no orders yet!</h1>";
                } else {
                    echo '
                                                        <table class="display" style="width: 100%;" id="dtBasicExample">
                                                            <thead>
                                                                <tr>
                                                                    <th><h5>'.$lang['rid'].'</h5></th>
                                                                    <th><h5>'.$lang['rname'].'</h5></th>
                                                                    <th><h5>'.$lang['tdate'].'</h5></th>
                                                                    <th><h5>'.$lang['total'].'</h5></th>
                                                                    <th><h5>'.$lang['status'].'</h5></th>
                                                                    <th><h5>'.$lang['action'].'</h5></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';
                    foreach ($receipt_array as $x => $x_value) {
                        $sql = "SELECT * FROM cust_receipt INNER JOIN users ON cust_receipt.user_id = users.user_id WHERE cust_receipt.receipt_id = $x_value";
                        $result = mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $rID = $row['receipt_id'];
                            $rName = $row['receipt_lname'];
                            $Fname = $row['receipt_fname'];
                            $tDate = $row['receipt_date'];
                            $rEmail = $row['receipt_email'];
                            $rPhone = $row['receipt_phone'];
                            $rAdds = $row['receipt_address'];
                            $rArea = $row['receipt_area'];
                            $rState = $row['receipt_state'];
                            $rPcode = $row['receipt_postcode'];
                            $total = $row['payment_cost'];
                            $status = $row['product_status'];
                            $method = $row['payment_method'];
                            $uid = $row['user_id'];
                        }

                        if($status == "Not set")
                            $display = $lang['notset'];
                        elseif($status == "Delivering")
                            $display = $lang['deliver'];
                        elseif($status == "Preparing")
                            $display = $lang['preparin'];
                        elseif($status == "Cancelled")
                            $display = $lang['cancelle'];
                        elseif($status == "Received")
                            $display = $lang['received'];
                        echo '
                                                                       
                                                                            <tr>
                                                                                <td>' . $rID . '</td>
                                                                                <td>' . $Fname . ' ' . $rName . '</td>
                                                                                <td>' . $tDate . '</td>
                                                                                <td>' . number_format($total, 2) . '</td>
                                                                                <td>' . $display . '</td>
                                                                                <td>
                                                                                    <a class="btn btn-default dropdown-toggle" href="#" style="margin-top:-10px;" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                        '.$lang['option'].'
                                                                                    </a>
                                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                        <a class="dropdown-item" onclick="openModal(' . $rID . ')" target="_blank" style="cursor:pointer">
                                                                                            '.$lang['details'].'
                                                                                        </a>
                                                                                        <a class="dropdown-item" href="EditableInvoice/invoice.php?id=' . $rID . '" target="_blank">
                                                                                            '.$lang['invoice'].'
                                                                                        </a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                    
                                                                    ';
                                                                    if($method == "Credit/Debit Cards")
                                                                        $dispMethod = $lang['pmethod'];
                        echo '
                                                                        <div id="receipt-' . $rID . '" class="modal" role="dialog">
                                                                            <div class="modal-dialog modal-lg">
                                                                                <div class="modal-content" style="text-align: left;">
                                                                                    <div class="modal-header" style="background-color:var(--thm-base)">
                                                                                        <h4 class="modal-title"><span style="color:white;">'.$lang['detail'].'</span></h4>
                                                                                        <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                                                                                    </div> 
                                                                                    <!-- Modal Header-->

                                                                                    <div class="modal-body">
                                                                                        <div>
                                                                                            <h4>Receipt Details</h4>
                                                                                            <hr>
                                                                                            <p>'.$lang['rid'].': ' . $rID . '</p>
                                                                                            <p>'.$lang['payment'].': ' . $dispMethod . '</p>
                                                                                            <p>'.$lang['pcost'].': ' . $total . '</p>
                                                                                            <p>'.$lang['tdate'].': ' . $tDate . '</p>
                                                                                        </div>

                                                                                        <div>
                                                                                            <hr>
                                                                                            <h4>'.$lang['buyer'].'</h4>
                                                                                            <hr>
                                                                                            <p>'.$lang['uid'].': ' . $uid . '</p>
                                                                                            <p>'.$lang['name'].': ' . $Fname . ' ' . $rName . '</p>
                                                                                            <p>'.$lang['email'].': ' . $rEmail . '</p>
                                                                                            <p>'.$lang['phone'].': ' . $rPhone . '</p>
                                                                                            <p>'.$lang['address'].': ' . $rAdds . ' '.$rArea.' '.$rPcode.' '.$rState.'</p>
                                                                                        </div>

                                                                                        <div>
                                                                                            <hr>
                                                                                            <h4>'.$lang['purchase'].'</h4>
                                                                                            <hr>
                                                                                            <div class="row">
                                                                                                <div class="col-md-2">
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <p><b>'.$lang['item'].'</b></p>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <p><b>'.$lang['amount'].'</b></p>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <p><b>'.$lang['unit'].'</b></p>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <p><b>'.$lang['t_cost'].'</b></p>
                                                                                                </div>
                                                                                            </div>
                                                                                            ';

                        $trans_sql = "SELECT * FROM cust_transaction
                                                                                                        INNER JOIN item ON cust_transaction.item_id = item.item_id
                                                                                                        WHERE cust_transaction.receipt_id = $x_value;";

                        if ($trans_result = mysqli_query($link, $trans_sql)) {
                            while ($trans_row = mysqli_fetch_assoc($trans_result)) {
                                echo
                                '
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-2">
                                                                                                                <img src="assets/images/items/' . $trans_row['image'] . '" style="width:50%;object-fit:contain;">
                                                                                                            </div>
                                                                                                            <div class="col-md-2">
                                                                                                                <p>' . $trans_row['item'] . '</p>
                                                                                                            </div>
                                                                                                            <div class="col-md-2">
                                                                                                                <p>x' . $trans_row['amount'] . '</p>
                                                                                                            </div>
                                                                                                            <div class="col-md-2">
                                                                                                                <p>RM' . $trans_row['cost'] . '</p>
                                                                                                            </div>
                                                                                                            <div class="col-md-2">
                                                                                                                <p>RM' . $trans_row['total_cost'] . '</p>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                                            ';
                            }
                        }
                        echo '
                                                                                    </div>
                                                                                </div>

                                                                                <div class="modal-footer" style="background-color:var(--thm-base)">
                                                                                    <button type="button" class="btn btn-danger"  onclick="return closeModal(' . $rID . ')">'.$lang['close'].'</button>
                                                                                </div> 
                                                                            </div>
                                                                        </div>
                                                                ';
                    }
                    echo '
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th><h5>'.$lang['rid'].'</h5></th>
                                                                    <th><h5>'.$lang['rname'].'</h5></th>
                                                                    <th><h5>'.$lang['tdate'].'</h5></th>
                                                                    <th><h5>'.$lang['total'].'</h5></th>
                                                                    <th><h5>'.$lang['status'].'</h5></th>
                                                                    <th><h5>'.$lang['action'].'</h5></th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>';
                                                        
                }
                ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- :::::::::: End My Account Section :::::::::: -->
<script>
    //Hide other panel when another collapses
    function openModal(id) {
        $('#receipt-' + id).fadeIn();
        return false;
    }

    function closeModal(id) {
        $('#receipt-' + id).fadeOut();
        return false;
    }

    $(document).ready(function() {
        var table = $('#dtBasicExample').DataTable({
            "scrollY": "50vh",
            "scrollCollapse": true,
            "pagingType": "full_numbers",
            dom: 'Bfrtip',
            buttons: [
                /*
                'pdf',
                'csv',
                'excel',
                'colvis'*/
            ],
            
        });
    });
</script>
</div>
</div>
</div>
</main>

<?php include 'cust_footer.php'; ?>