<?php

include 'admin_header.php';

if (isset($_GET["update"])) {

    $delivery_id = $_GET["id"];
    $rider = $_GET["rider"];
    $est_time = $_GET["est_time"];
    $status = $_GET["status"];
    $date = date('Y-m-d H:i:s');
    
    $get_receipt_res = mysqli_query($link, "SELECT receipt_id FROM cust_receipt WHERE delivery_id = $delivery_id");
    $init_rider_res = mysqli_query($link, "SELECT rider_id FROM delivery_system WHERE delivery_id = '$delivery_id'");
    while($row_receipt = mysqli_fetch_assoc($get_receipt_res)) {
        $get_receipt = $row_receipt["receipt_id"];
    }
    while($row_rider = mysqli_fetch_assoc($init_rider_res)) {
        $init_rider = $row_rider["rider_id"];
    }
    
    $activity_sql = "INSERT INTO admin_activity (user_id, activity, activity_time, target) VALUES (" . $_SESSION["userid"] . ", 'update receipt', '$date', '".$get_receipt."')";
    
    if($status == "Preparing") {

        $sql = "UPDATE delivery_system 
                SET rider_id = '$rider', delivery_status = '$status', delivery_time = NULL, receive_time = NULL, estimated_time = '$est_time' 
                WHERE delivery_id = " . $delivery_id;
        
        if($rider == "No available rider") {
            if($init_rider != "No available rider" && $init_rider != "" && $init_rider != NULL) 
                $set_rider = "UPDATE rider SET rider_status = 'Available', current_delivery = NULL WHERE rider_id = '".$init_rider."'";
            else
                $set_rider = "";
        } elseif ($rider != "No available rider") {
            $set_rider = "UPDATE rider SET rider_status = 'Unavailable', current_delivery = '$get_receipt' WHERE rider_id = '$rider'";
        }

    } else if ($status == "Delivering") {

        $sql = "UPDATE delivery_system SET rider_id = '$rider', delivery_status = '$status', estimated_time = '$est_time', delivery_time = '$date' WHERE delivery_id = " . $delivery_id;
        $set_rider = "UPDATE rider SET rider_status = 'Unavailable', current_delivery = '$get_receipt' WHERE rider_id = '$rider'";

    } else if ($status == "Received") {

        $sql = "UPDATE delivery_system SET delivery_status = '$status', receive_time = '$date', estimated_time = 'Received' WHERE delivery_id = " . $delivery_id;
        $set_rider = "UPDATE rider SET rider_status = 'Available', current_delivery = NULL WHERE rider_id = '$rider'";

    } else if ($status == "Cancelled") {

        $sql = "UPDATE delivery_system SET delivery_status = '$status', delivery_time = NULL, receive_time = NULL, estimated_time = 'Cancelled' WHERE delivery_id = " . $delivery_id;
        if($rider != "No available rider") {
            $set_rider = "UPDATE rider SET rider_status = 'Available', current_delivery = NULL WHERE rider_id = '$rider'";
        }

    }

    if (mysqli_query($link, $sql)) {
        mysqli_query($link, $activity_sql);

        if($set_rider != "") {
            mysqli_query($link, $set_rider);
        }

        echo "
            <script>
                Swal.fire({
                icon: 'success',
                title: 'Receipt : $get_receipt updated to \"$status\"',
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
    /*
    if (isset($_GET["del_status"])) {
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
    */
}

$rider_name = array();
$rider_location = array();
$rider_id = array();
$no_rider = 0;

$sql_rider = "SELECT * FROM rider";
if ($rider_result = mysqli_query($link, $sql_rider)) {
    $total_rider = mysqli_num_rows($rider_result);

    while ($rider_row = mysqli_fetch_assoc($rider_result)) {
        if ($rider_row["rider_status"] == "Available") {
            array_push($rider_name, $rider_row["rider_name"]);
            array_push($rider_location, $rider_row["rider_location"]);
            array_push($rider_id, $rider_row["rider_id"]);
            $no_rider++;
        }
    }
}

$sql_receipt = "SELECT receipt_id FROM cust_receipt";
$receipt_array = array();

if ($receipt_result = mysqli_query($link, $sql_receipt)) {
    while ($receipt_row = mysqli_fetch_assoc($receipt_result)) {
        array_push($receipt_array, $receipt_row["receipt_id"]);
    }
}

?>

<style>
    .btn-dark { filter: brightness(0.5); }
</style>

<section class="">
    <div class="container" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">
        <h1>Customer's transaction</h1>
    </div>

    <div class="container" style="background-color:rgba(255,255,255,0.8); padding: 2%">
        <div class="row">

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
                                    
                                    $display_row = array();
                                    $get_receipt = mysqli_query($link, "SELECT * FROM cust_receipt WHERE receipt_id = $x_value");
                                    while ($receipt_row = mysqli_fetch_assoc($get_receipt)) {
                                        $display_row['receipt_id'] = $receipt_row["receipt_id"];
                                        $display_row['receipt_lname'] = $receipt_row["receipt_lname"];
                                        $display_row['receipt_fname'] = $receipt_row["receipt_fname"];
                                        $display_row['receipt_date'] = $receipt_row["receipt_date"];
                                        $display_row['receipt_email'] = $receipt_row["receipt_email"];
                                        $display_row['receipt_phone'] = $receipt_row["receipt_phone"];
                                        $display_row['receipt_address'] = $receipt_row["receipt_address"];
                                        $display_row['receipt_area'] = $receipt_row["receipt_area"];
                                        $display_row['payment_cost'] = $receipt_row["payment_cost"];
                                        $display_row['payment_method'] = $receipt_row["payment_method"];
                                        $display_row['user_id'] = $receipt_row["user_id"];
                                        $display_row['delivery_id'] = $receipt_row["delivery_id"];
                                    }
                                    $get_delivery = mysqli_query($link, "SELECT * FROM delivery_system WHERE delivery_id = '".$display_row['delivery_id']."'");
                                    while ($delivery_row = mysqli_fetch_assoc($get_delivery)) {
                                        $display_row['delivery_status'] = $delivery_row["delivery_status"];
                                        $display_row['rider_id'] = $delivery_row["rider_id"];
                                        $display_row['estimated_time'] = $delivery_row["estimated_time"];
                                    }
                                    echo "<script>console.log('".$display_row['delivery_id']." , ".$display_row['delivery_status']."')</script>";
                                    $get_rider = mysqli_query($link, "SELECT * FROM rider WHERE rider_id = '".$display_row['rider_id']."'");
                                    while($rider_row = mysqli_fetch_assoc($get_rider)) {
                                        $display_row['rider_fullname'] = $rider_row["rider_name"] . " " . $rider_row["rider_lastname"];
                                    }
                                    /*
                                        SELECT 
                                        a.receipt_id, a.receipt_fname, a.receipt_lname, a.receipt_date, a.receipt_email, a.receipt_address, a.receipt_area, a.receipt_phone, a.receipt_address, a.payment_cost, a.payment_method, 
                                        b.user_id,
                                        c.delivery_status, c.rider_id, c.estimated_time, c.delivery_id
                                        FROM cust_receipt AS a
                                        INNER JOIN users AS b
                                        INNER JOIN delivery_system AS c ON (a.delivery_id = c.delivery_id and a.user_id = b.user_id)
                                        WHERE a.receipt_id = 300000007

                                        SELECT *
                                        FROM cust_receipt AS a
                                        INNER JOIN users AS b ON (a.user_id = b.user_id)
                                        INNER JOIN delivery_system AS c ON (a.delivery_id = c.delivery_id)
                                        WHERE a.receipt_id = 300000007        
                                    */
                                    $rID = $display_row['receipt_id'];
                                    $rName = $display_row['receipt_lname'];
                                    $Fname = $display_row['receipt_fname'];
                                    $tDate = $display_row['receipt_date'];
                                    $rEmail = $display_row['receipt_email'];
                                    $rPhone = $display_row['receipt_phone'];
                                    $rAdds = $display_row['receipt_address'];
                                    $rArea = $display_row['receipt_area'];
                                    $total = $display_row['payment_cost'];
                                    $method = $display_row['payment_method'];
                                    $uid = $display_row['user_id'];
                                    $delStatus = $display_row['delivery_status'];
                                    $delRider = $display_row['rider_id'];
                                    $delETA = $display_row['estimated_time'];
                                    $delID = $display_row['delivery_id'];
                                    $riderName = ($delRider == "No available rider" || $delRider == "") ? "" : $display_row['rider_fullname'];

                                    if($delStatus == "Delivering") {
                                        $dispStatus = "<p style='color:orange'>".$delStatus."</p>";
                                    } else if($delStatus == "Received") {
                                        $dispStatus = "<p style='color:limegreen'>".$delStatus."</p>";
                                    } else if($delStatus == "Cancelled") {
                                        $dispStatus = "<p style='color:crimson'>".$delStatus."</p>";
                                    } else if($delStatus == "Not Set") {
                                        $dispStatus = "<p style='color:gray'>".$delStatus."</p>";
                                    } else if($delStatus == "Preparing") {
                                        $dispStatus = "<p style='color:pink'>".$delStatus."</p>";
                                    }

                                    echo '
                                                <tr>
                                                    <form method="GET" action="#">
                                                        <input type="hidden" value="' . $rID . '" name="id">
                                                        <td><p>' . $rID . '</p></td>
                                                        <td><p>' . $Fname . ' ' . $rName . '</p></td>
                                                        <td><p>' . $tDate . '</p></td>
                                                        <td><p>' . $total . '</p></td>
                                                        <td><b>' . $dispStatus . '</b></td>
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
                                                        <td> <button type="button" class="btn-sm ' . (($delStatus == "Received" || $delStatus == "Cancelled") ? 'btn-dark' : 'btn-primary') . '" name="update" ' . (($delStatus == "Received" || $delStatus == "Cancelled") ? 'disabled' : '') . ' onclick="return updateStatus(`'.$delID.'`, `'.$delStatus.'`, `'.$rArea.'`, `'.$delRider.'`,`'.$delETA.'`, `'.$riderName.'`)"/>Update Status</button></td>
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

    function updateStatus(id, init_status, c_area, init_rider, init_ETA, riderName) {
        
        var status_select = (function() {
            if(init_status == "Not Set") {
                return '<option value="Preparing">Preparing</option>' +
                    '<option value="Delivering">Delivering</option>' +
                    '<option value="Cancelled">Cancelled</option>';
            } else if(init_status == "Preparing") {
                return '<option value="Delivering">Delivering</option>' +
                    '<option value="Cancelled">Cancelled</option>';
            } else if(init_status == "Delivering") {
                return '<option value="Preparing">Preparing</option>' +
                    '<option value="Received">Received</option>' +
                    '<option value="Cancelled">Cancelled</option>';
            }
        })();
        
        default_status = (init_status == "" || init_status == null || init_status == "Not Set") ? '<option  hidden selected value="">--Set Status--</option>': '<option  hidden selected value="'+init_status+'">'+init_status+'</option>';
        default_ETA = (init_ETA == "" || init_ETA == null) ? '<option  hidden selected value="">--Estimated time--</option>': '<option  hidden selected value="'+init_ETA+'">'+init_ETA+'</option>';
        default_rider = (init_rider == "" || init_rider == null) ? '<option  hidden selected value="">--Assign rider--</option>': '<option  hidden selected value="'+init_rider+'">'+((riderName=="")?init_rider:riderName)+'</option>';

        Swal.fire({
            title: 'Update status',
            html: '<hr><p style="text-align:left">Available rider : <?php echo $no_rider . " / " . $total_rider ?></p>' +
                '<p style="text-align:left">Initial status : '+ init_status +'</p>' +
                '<p style="text-align:left">Customer Area : '+ c_area +'</p><hr>' +
                '<div style="display:flex; align-items: flex-end; justify-content: space-between;">' +
                '   <h4>Delivery Status : </h4>' +
                '   <select id="swal-input1" class="swal2-input"  style="width:50%; margin:0">' +
                default_status +
                status_select +
                '   </select>' +
                '</div>' +
                '</br><br>' +
                '<div style="display:flex; align-items: flex-end; justify-content: space-between;">' +
                '   <h4>Estimated time : </h4>' +
                '   <select id="swal-input2" class="swal2-input" style="width:50%; margin:0">' +
                default_ETA+
                '       <option value="Within 1 hour">Within 1 hour</option>' +
                '       <option value="Within 3 hour">Within 3 hour</option>' +
                '       <option value="Within 6 hour">Within 6 hour</option>' +
                '       <option value="The next day">The next day</option>' +
                '   </select>' +
                '</div>' +
                '</br><br>' +
                '<div style="display:flex; align-items: flex-end; justify-content: space-between;">' +
                '   <h4>Assign rider : </h4>' +
                '   <select id="swal-input3" class="swal2-input" style="width:50%; margin:0">' +
                default_rider +
                '       <option value="No available rider">No available rider</option>' +
                '       <?php for ($i = 0; $i < count($rider_name); $i++) echo '<option value="'.$rider_id[$i].'">' . $rider_name[$i] . " (" . $rider_location[$i] . ")</option>" ?>' +
                '   </select>' +
                '</div>',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Save',
        }).then((result) => {
            if (result.isConfirmed) {
                var get_status = $("#swal-input1").val();
                var get_est_time = $("#swal-input2").val();
                var get_rider = $("#swal-input3").val();
                console.log(get_status);
                console.log(get_est_time);
                console.log(get_rider);

                var err = false;

                if((get_status == "" || get_status == null) || (get_est_time == "" || get_est_time == null) ||  (get_rider == "" || get_rider == null)) {
                    Swal.fire({
                        icon: "warning",
                        title: "Please update all of the selections"
                    });
                    err = true;
                } 
                /*
                if(get_status == init_status) {
                    Swal.fire({
                        icon: "warning",
                        title: "Same status"
                    });
                    err = true;
                } 
                */

                if(get_status == "Delivering"|| get_status == "Received") {
                    if(get_rider == "No available rider") {
                        Swal.fire({
                            icon: "warning",
                            title: "You have no available rider!"
                        });
                        err = true;
                    }
                }

                if(!err){
                    
                    $.ajax({
                        type: "get",
                        url: "admin_view_transaction.php",
                        data: {
                            'update': true,
                            'id': id,
                            'status': get_status,
                            'est_time': get_est_time,
                            'rider': get_rider
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
            }
            /*
            if (result.isConfirmed) {
                //location.href = 'admin_view_transaction.php';
            }
            */
        });

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
                */
                {
                    text: 'Rider available : <?php echo $no_rider . " / " . $total_rider ?>',
                    className: "displayRider",
                },
                {
                    text: "Download as Excel",
                    className: "excel",
                    action: function(e, dt, node, config) {
                        location.href = "excel.php";
                    },
                }
            ],
            "order": [
                [0, "dsc"]
            ]
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

        $(".excel").css({
            "background-color": "green"
        });
        
        $(".displayRider").css({
            "color": "black",
            "background-color": "rgba(255,255,255,0.8)"
        });
        $(".displayRider").attr("disabled", "true");

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