<?php

include 'admin_header.php';

if (isset($_GET["update"])) {
    $receipt_id = $_GET["receipt_id"];
    $status = $_GET["status"];
    $date = date('Y-m-d H:i:s');
    $activity_sql = "INSERT INTO admin_activity (user_id, activity, activity_time, target) VALUES (" . $_SESSION["userid"] . ", 'update receipt', '$date', '";

    for ($i = 0; $i < count($receipt_id); $i++) {

        if ($i < 1) {
            $activity_sql .= $receipt_id[$i];
        } else {
            $activity_sql .= "," . $receipt_id[$i];
        }

        if ($status == "Not Set") {
            $sql = "UPDATE cust_receipt SET product_status = '$status', delivery_date = NULL, receive_date = NULL WHERE receipt_id = " . $receipt_id[$i];
        } elseif ($status == "Preparing") {
            $sql = "UPDATE cust_receipt SET product_status = '$status' WHERE receipt_id = " . $receipt_id[$i];
        } elseif ($status == "Delivering") {
            $sql = "UPDATE cust_receipt SET product_status = '$status', delivery_date = '$date' WHERE receipt_id = " . $receipt_id[$i];
        } elseif ($status == "Received") {
            $sql = "UPDATE cust_receipt SET product_status = '$status', receive_date = '$date' WHERE receipt_id = " . $receipt_id[$i];
        }

        if (mysqli_query($link, $sql)) {
            echo "
            <script>alert('Updated')</script>";
        } else {
            echo "
            <script>alert('Something went wrong')</script>";
        }
    }
    $activity_sql .= "')";
    mysqli_query($link, $activity_sql);
}

$sql_receipt = "SELECT receipt_id FROM cust_receipt";
$receipt_array = array();

if ($receipt_result = mysqli_query($link, $sql_receipt)) {
    while ($receipt_row = mysqli_fetch_assoc($receipt_result)) {
        array_push($receipt_array, $receipt_row["receipt_id"]);
    }
}

if (isset($_POST["filter"])) {

    unset($receipt_array);
    $receipt_array = array();

    $search_id = "";
    $date_from = "";
    $date_to = "";

    $id_error = $date_from_error = $date_to_error = "";

    if (isset($_POST["search-id"])) {
    }

    if ($id_error == "" && $date_from_error = "" && $date_to_error == "") {

        if ($search_id == "" && $date_from == "" && $date_to == "") {
            $sql_receipt = "SELECT receipt_id FROM cust_receipt";
        }
    }
}
?>


<section class="">
    <div class="container" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">
        <h1>Customer's transaction</h1>
    </div>

    <div class="container" style="background-color:rgba(255,255,255,0.8); padding: 2%">
        <div class="row">

            <div class="col-sm-12">
                <div class='row' style="margin: 1%">
                    <div class="col-sm-6"></div>

                    <div class="col-sm-6">
                        <form style="
                                        display: flex;
                                        justify-content: flex-end;">
                            <!--
                                        <select id="status" name="status">
                                            <option value="'.$display_row["product_status"].'" selected disabled hidden>'.$display_row["product_status"].'</option>
                                            <option value="Not Set">Not set</option>
                                            <option value="Preparing">Preparing</option>
                                            <option value="Delivering">Delivering</option>
                                            <option value="Received">Received</option>
                                        </select>
                                        -->
                            <div class="form-group" style="text-align: left; margin-right: 1rem">
                                <label>Status</label> <br>
                                <select id="status" name="status" style="text-align: left; margin-right: 1rem">
                                    <option value="--Status--" selected disabled hidden>--Status--</option>
                                    <option value="Not Set">Not set</option>
                                    <option value="Preparing">Preparing</option>
                                    <option value="Delivering">Delivering</option>
                                    <option value="Received">Received</option>
                                </select>
                                <p id="status-err" style="font-style: italic; color: crimson;"></p>
                            </div>
                            <div class="form-group" style="text-align: left; margin-right: 1rem">
                                <label for="select-all">Select All</label> <br>
                                <input type="checkbox" id="select-all" />
                            </div>
                            <div class="form-group" style="text-align: left;">
                                <button class="btn btn-info btn-sm" onclick="return updateStatus();">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel-group" id="accordion">

                            <?php

                            if (count($receipt_array) == 0) {

                                echo "<h1 style='text-align: center'>You have no orders yet!</h1>";
                            } else {

                                echo '
                                        <table id="dtBasicExample" class="display" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th><h5>Receipt ID</h5></th>
                                                    <th><h5>Receipt Name</h5></th>
                                                    <th><h5>Transaction Date</h5></th>
                                                    <th><h5>Total(RM)</h5></th>
                                                    <th><h5>Status</h5></th>
                                                    <th><h5>Action</h5></th>
                                                    <th><h5></h5></th>
                                                </tr>
                                            </thead>
                                            <tbody>';

                                foreach ($receipt_array as $x => $x_value) {
                                    $display_sql = "SELECT * FROM cust_receipt 
                                            INNER JOIN users ON cust_receipt.user_id = users.user_id 
                                            WHERE cust_receipt.receipt_id = $x_value;
                                            ";

                                    $display_result = mysqli_query($link, $display_sql);

                                    while ($display_row = mysqli_fetch_assoc($display_result)) {

                                        $rID = $display_row['receipt_id'];
                                        $rName = $display_row['receipt_lname'];
                                        $Fname = $display_row['receipt_fname'];
                                        $tDate = $display_row['receipt_date'];
                                        $rEmail = $display_row['receipt_email'];
                                        $rPhone = $display_row['receipt_phone'];
                                        $rAdds = $display_row['receipt_address'];
                                        $total = $display_row['payment_cost'];
                                        $status = $display_row['product_status'];
                                        $method = $display_row['payment_method'];
                                        $uid = $display_row['user_id'];
                                    }
                                    echo '
                                                <tr>
                                                    <td>' . $rID . '</td>
                                                    <td>' . $Fname . ' ' . $rName . '</td>
                                                    <td>' . $tDate . '</td>
                                                    <td>' . $total . '</td>
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
                                                    <td> <input type="checkbox" name="select-item" value="' . $rID . '"> </td>
                                                </tr>
                                            ';

                                    //Modal

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
                                                                <div class="col-md-2"></div>
                                                                <div class="col-md-2"><p><b>Item name</b></p></div>
                                                                <div class="col-md-2"><p><b>Amount</b></p></div>
                                                                <div class="col-md-2"><p><b>Unit Cost</b></p></div>
                                                                <div class="col-md-2"><p><b>Total Cost</b></p></div>
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
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th><h5>Receipt ID</h5></th>
                                                    <th><h5>Receipt Name</h5></th>
                                                    <th><h5>Transaction Date</h5></th>
                                                    <th><h5>Total(RM)</h5></th>
                                                    <th><h5>Status</h5></th>
                                                    <th><h5>Action</h5></th>
                                                    <th><h5></h5></th>
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
</section>
</div> <!-- page wrapper -->

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

    //check for Navigation Timing API support
    if (window.performance) {
        console.info("window.performance works fine on this browser");
    }
    console.info(performance.navigation.type);
    if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
        location.href = "admin_view_transaction.php";
    } else {
        console.info("This page is not reloaded");
    }

    var checkboxes = document.getElementsByName('select-item');
    var select_all = document.getElementById("select-all");

    select_all.onclick = () => {

        if (select_all.checked) {
            //console.log("yes")
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = true;
            }
        } else {
            //console.log("no")
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = false;
            }
        }
    }

    function updateStatus() {
        var receipt_id = [];
        var status = document.getElementById("status").value;

        if (status === "--Status--") {
            document.getElementById("status-err").innerHTML = "Choose status";
        } else {

            for (var i = 0, n = checkboxes.length; i < n; i++) {
                if (checkboxes[i].checked == true) {
                    receipt_id.push(checkboxes[i].value);
                }
            }

            if (confirm("Set status to '" + status + "'? Press 'OK' to continue")) {
                $.ajax({
                    type: "get",
                    url: "admin_view_transaction.php",
                    data: {
                        'update': true,
                        'receipt_id': receipt_id,
                        'status': status
                    },
                    cache: false,
                    success: function(html) {
                        alert('Updated');
                        location.href = 'admin_view_transaction.php';
                    }
                });

            } else {}
        }

        return false;
    }

    function download() {
        $.ajax({
            type: "get",
            url: "EditableInvoice/invoice.php",
            data: {
                'id': true
            },
            cache: false,
            success: function(html) {

            }
        });
        return false;
    }
    
    $(document).ready(function() {
        var table = $('#dtBasicExample').DataTable({
            "scrollY": "50vh",
            "scrollCollapse": true,
            "pagingType": "full_numbers",
            dom: 'Bfrtip',
            buttons: [
                'pdf',
                'csv',
                'excel',
                'colvis'
            ],
        });

        table.buttons().container()
            .appendTo('#dtBasicExample_wrapper .col-md-6:eq(0)');
    });
</script>
<!-- /.search-popup -->

<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

<!-- template js -->
<script src="assets/js/organik.js"></script>
</body>

</html>