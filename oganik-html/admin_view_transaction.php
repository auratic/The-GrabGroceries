<?php

include 'admin_header.php';

if (isset($_GET["update"])) {
    $receipt_id = $_GET["id"];
    $status = $_GET["status"];
    $date = date('Y-m-d H:i:s');
    $activity_sql = "INSERT INTO admin_activity (user_id, activity, activity_time, target) VALUES (" . $_SESSION["userid"] . ", 'update receipt', '$date', '$receipt_id')";

    if(isset($_GET["del_status"])) {
        $del_status = $_GET["del_status"];
        if ($status == "Preparing") {
            $sql = "UPDATE cust_receipt SET product_status = '$status', delivery_status = '$del_status' WHERE receipt_id = " . $receipt_id;
        } elseif ($status == "Received") {
            $sql = "UPDATE cust_receipt SET product_status = '$status', delivery_status = '$del_status', receive_date = '$date' WHERE receipt_id = " . $receipt_id;
        } elseif ($status == "Cancelled") {
            $sql = "UPDATE cust_receipt SET product_status = '$status', delivery_status = '$del_status' WHERE receipt_id = " . $receipt_id;
        }

    } else {

        if ($status == "Delivering") {
            $sql = "UPDATE cust_receipt SET product_status = '$status', delivery_date = '$date' WHERE receipt_id = " . $receipt_id;
        } 

    }


    if (mysqli_query($link, $sql)) {
        mysqli_query($link, $activity_sql);
        echo "
            <script>
                Swal.fire({
                icon: 'success',
                title: 'Receipt : $receipt_id updated to \"$status\"',
                confirmButtonText: 'Okay',
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = 'admin_view_transaction.php';
                }
            })
            </script>";
    } else {
        echo "
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Cannot update to database',
                confirmButtonText: 'Okay',
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = 'admin_view_transaction.php';
                }
            })
            </script>";
    }
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
        <a class="btn btn-success" style="margin: 14px;" href="excel.php">Download as Excel</a>

            <div class="col-sm-12">
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
                                                    <form method="GET" action="#">
                                                        <input type="hidden" value="' . $rID . '" name="id">
                                                        <td>' . $rID . '</td>
                                                        <td>' . $Fname . ' ' . $rName . '</td>
                                                        <td>' . $tDate . '</td>
                                                        <td>' . $total . '</td>
                                                        <td style="text-align:center">';
                                    if ($status == "Received" || $status == "Cancelled") {
                                        echo "
                                                            <select class='form-control' disabled>
                                                                <option selected>$status</option>
                                                            </select>";
                                    } else {
                                        echo '
                                                            <select id="status-' . $rID . '" name="status" class="form-control" >
                                                                <option id="istatus-' . $rID . '" value="' . $status . '" selected hidden>' . $status . '</option>';
                                        if ($status == "Not Set") {
                                            echo '
                                                                <option value="Preparing">Preparing</option>
                                                                <option value="Cancelled">Cancelled</option>';
                                        } elseif ($status == "Preparing") {
                                            echo '
                                                                <option value="Delivering">Delivering</option>
                                                                <option value="Cancelled">Cancelled</option>';
                                        } elseif ($status == "Delivering") {
                                            echo '
                                                                <option value="Received">Received</option>
                                                                <option value="Cancelled">Cancelled</option>';
                                        } 
                                        echo '
                                                            </select>';
                                    }
                                    echo '
                                                        </td>
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
                                                        <td> <input type="submit" class="btn-sm btn-info" name="update" value="Update" ' . (($status == "Received" || $status == "Cancelled") ? 'disabled' : '') . ' onclick="return updateStatus(`' . $rID . '`)"/> </td>
                                                    </form>
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
                                                        <button type="button" class="btn btn-danger"  onclick="return closeModal(' . $rID . ')">Close</button>
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

    function updateStatus(id) {
        var status = document.getElementById("status-" + id).value;
        var init_status = document.getElementById("istatus-" + id).value;


        if (init_status == status) {
            Swal.fire({
                icon: 'error',
                title: 'Nothing is updated..',
                confirmButtonText: 'Okay',
            }).then((result) => {
                if (result.isConfirmed) {
                    //location.href = 'admin_view_transaction.php';
                }
            })
        } else if (status == "Preparing") {

            Swal.fire({
                title: 'Estimated delivery time',
                input: 'select',
                inputOptions: {
                    "Within 1 hour": 'Within 1 hour',
                    "Within 3 hour": "Within 3 hour",
                    "Next day": 'Next day',
                    "Within 3 days": 'Within 3 days',
                    "Within 1 week": "Within 1 week"
                },
                inputPlaceholder: '--Estimated Time--',
                showCancelButton: true
            }).then((result) => {
                var estimate = result.value;
                if(estimate == undefined) {

                } else if(estimate == "" ) {
                    Swal.fire({
                        icon: "error",
                        title: "Select a time"
                    });
                } else {
                    $.ajax({
                        type: "get",
                        url: "admin_view_transaction.php",
                        data: {
                            'update': true,
                            'id': id,
                            'status': status,
                            'del_status': estimate
                        },
                        cache: false,
                        success: function(html) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully Updated',
                                confirmButtonText: 'Okay',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'admin_view_transaction.php';
                                }
                            })
                        }
                    });
                }
            });

        } else if (status == "Cancelled") {
            Swal.fire({
                icon: 'warning',
                title: 'Cancel this order ? ',
                showCancelButton: true,
                confirmButtonText: 'Proceed',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Are you sure ?',
                        text: 'This cannot be undone',
                        showCancelButton: true,
                        confirmButtonText: 'Proceed',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "get",
                                url: "admin_view_transaction.php",
                                data: {
                                    'update': true,
                                    'id': id,
                                    'status': status,
                                    'del_status': "Cancelled"
                                },
                                cache: false,
                                success: function(html) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Successfully Updated',
                                        confirmButtonText: 'Okay',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.href = 'admin_view_transaction.php';
                                        }
                                    })
                                }
                            });
                        }
                    });
                }
            });
        } else if (status == "Delivering") {
            Swal.fire({
                title: 'Update order status ?',
                showCancelButton: true,
                confirmButtonText: 'Save',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "get",
                        url: "admin_view_transaction.php",
                        data: {
                            'update': true,
                            'id': id,
                            'status': status
                        },
                        cache: false,
                        success: function(html) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully Updated',
                                confirmButtonText: 'Okay',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'admin_view_transaction.php';
                                }
                            })
                        }
                    });
                }
            });
        } else if (status == "Received") {
            Swal.fire({
                title: 'Order received ?',
                text: 'Action cannot be undone',
                showCancelButton: true,
                confirmButtonText: 'Received',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "get",
                        url: "admin_view_transaction.php",
                        data: {
                            'update': true,
                            'id': id,
                            'status': status,
                            'del_status': "Received"
                        },
                        cache: false,
                        success: function(html) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully Updated',
                                confirmButtonText: 'Okay',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'admin_view_transaction.php';
                                }
                            })
                        }
                    });
                }
            });
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
                /*
                'pdf',
                'csv',
                'excel',
                */  
                'colvis'
            ],
            
            "order": [[ 0, "dsc" ]]
            //pageLength : 5
            /*
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
    
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
    
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                });
            }*/
        });

        //table.buttons().container()
        //    .appendTo('#dtBasicExample_wrapper .col-md-6:eq(0)');
    });
</script>
<!-- /.search-popup -->

<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

<!-- template js -->
<script src="assets/js/organik.js"></script>
</body>

</html>