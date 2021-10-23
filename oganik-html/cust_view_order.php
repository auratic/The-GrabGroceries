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
        <h4 class="account-title">Orders</h4>

        <div class="panel-group" id="accordion">
            <div class="panel panel-default text-center">
                <?php
                if (count($receipt_array) == 0) {
                    echo "<h1 style='text-align: center'>You have no orders yet!</h1>";
                } else {
                    echo '
                                                        <table class="table table-striped table-bordered table-hover" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th><h5>Receipt ID</h5></th>
                                                                    <th><h5>Receipt Name</h5></th>
                                                                    <th><h5>Transaction Date</h5></th>
                                                                    <th><h5>Total (RM)</h5></th>
                                                                    <th><h5>Status</h5></th>
                                                                    <th><h5>Action</h5></th>
                                                                </tr>
                                                            </thead>';
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
                            $total = $row['payment_cost'];
                            $status = $row['product_status'];
                            $method = $row['payment_method'];
                            $uid = $row['user_id'];
                        }

                        echo '
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>' . $rID . '</td>
                                                                                <td>' . $Fname . ' ' . $rName . '</td>
                                                                                <td>' . $tDate . '</td>
                                                                                <td>' . number_format($total, 2) . '</td>
                                                                                <td>' . $status . '</td>
                                                                                <td>
                                                                                    <a class="btn btn-default dropdown-toggle" href="#" style="margin-top:-10px;" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                        More option
                                                                                    </a>
                                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                        <a class="dropdown-item" onclick="openModal(' . $rID . ')" target="_blank" style="cursor:pointer">
                                                                                            View Details
                                                                                        </a>
                                                                                        <a class="dropdown-item" href="EditableInvoice/invoice.php?id=' . $rID . '" target="_blank">
                                                                                            Invoice
                                                                                        </a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    ';
                        echo '
                                                                        <div id="receipt-' . $rID . '" class="modal" role="dialog">
                                                                            <div class="modal-dialog modal-lg">
                                                                                <div class="modal-content" style="text-align: left;">
                                                                                    <div class="modal-header" style="background-color:var(--thm-base)">
                                                                                        <h4 class="modal-title"><span style="color:white;">Details</span></h4>
                                                                                        <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                                                                                    </div> 
                                                                                    <!-- Modal Header-->

                                                                                    <div class="modal-body">
                                                                                        <div>
                                                                                            <h4>Receipt Details</h4>
                                                                                            <hr>
                                                                                            <p>Receipt ID: ' . $rID . '</p>
                                                                                            <p>Payment Method: ' . $method . '</p>
                                                                                            <p>Payment Cost: ' . $total . '</p>
                                                                                            <p>Transaction Date: ' . $tDate . '</p>
                                                                                        </div>

                                                                                        <div>
                                                                                            <hr>
                                                                                            <h4>Buyer\'s Details</h4>
                                                                                            <hr>
                                                                                            <p>User ID: ' . $uid . '</p>
                                                                                            <p>Name: ' . $Fname . ' ' . $rName . '</p>
                                                                                            <p>Email: ' . $rEmail . '</p>
                                                                                            <p>Phone: ' . $rPhone . '</p>
                                                                                            <p>Address: ' . $rAdds . '</p>
                                                                                        </div>

                                                                                        <div>
                                                                                            <hr>
                                                                                            <h4>Purchased Products</h4>
                                                                                            <hr>
                                                                                            <div class="row">
                                                                                                <div class="col-md-2">
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <p><b>Item name</b></p>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <p><b>Amount</b></p>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <p><b>Unit Cost</b></p>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <p><b>Total Cost</b></p>
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
                                                                                    <button type="button" class="btn btn-danger"  onclick="return closeModal(' . $rID . ')">Cancel</button>
                                                                                </div> 
                                                                            </div>
                                                                        </div>
                                                                ';
                    }
                    echo '
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
</script>
</div>
</div>
</div>
</main>

<?php include 'cust_footer.php'; ?>