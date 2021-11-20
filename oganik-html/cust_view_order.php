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

if(isset($_GET["receive"])) {
    
    $date = date('Y-m-d H:i:s');
    $sql = "UPDATE delivery_system SET delivery_status = 'Received', receive_time = '$date', estimated_time = 'Received' WHERE delivery_id = '".$_GET['id']."'";
    $get_rider = mysqli_query($link, "SELECT rider_id FROM delivery_system WHERE delivery_id = '".$_GET['id']."'");

    while($row_rider = mysqli_fetch_assoc($get_rider)) {
        $rider_id = $row_rider["rider_id"];
    }
    $update_rider = "UPDATE rider SET rider_status = 'Available', current_delivery = NULL WHERE rider_id = '$rider_id'";

    if(mysqli_query($link, $sql)) {
        mysqli_query($link, $update_rider);
        echo "
        <script>
        Swal.fire({
            title: 'Updated',
            text: 'Thank you for shopping with us ! ',
            icon: 'success'
        }).then(function() {
            location.href = 'cust_view_order.php'
        })
        </script>";
    } else {
        echo "
        <script>
        Swal.fire({
            title: 'Error',
            text: 'Some error occured..',
            icon: 'error'
        }).then(function() {
            location.href = 'cust_view_order.php'
        })
        </script>";
    }
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
<style>

#progressbar {
    margin-bottom: 3vh;
    overflow: hidden;
    color: rgb(252, 103, 49);
    padding-left: 0px;
    margin-top: 3vh
}

#progressbar li {
    list-style-type: none;
    font-size: x-small;
    width: 25%;
    float: left;
    position: relative;
    font-weight: 400;
    color: rgb(160, 159, 159)
}

#progressbar #step1:before {
    content: "";
    color: rgb(252, 103, 49);
    width: 5px;
    height: 5px;
    margin-left: 0px !important
}

#progressbar #step2:before {
    content: "";
    color: #fff;
    width: 5px;
    height: 5px;
    margin-left: 32%
}

#progressbar #step3:before {
    content: "";
    color: #fff;
    width: 5px;
    height: 5px;
    margin-right: 32%
}

#progressbar #step4:before {
    content: "";
    color: #fff;
    width: 5px;
    height: 5px;
    margin-right: 0px !important
}

#progressbar li:before {
    line-height: 29px;
    display: block;
    font-size: 12px;
    background: #ddd;
    border-radius: 50%;
    margin: auto;
    z-index: -1;
    margin-bottom: 1vh
}

#progressbar li:after {
    content: '';
    height: 2px;
    background: #ddd;
    position: absolute;
    left: 0%;
    right: 0%;
    margin-bottom: 2vh;
    top: 1px;
    z-index: 1
}

.progress-track {
    padding: 0 8%
}

#progressbar li:nth-child(2):after {
    margin-right: auto
}

#progressbar li:nth-child(1):after {
    margin: auto
}

#progressbar li:nth-child(3):after {
    float: left;
    width: 68%
}

#progressbar li:nth-child(4):after {
    margin-left: auto;
    width: 132%
}

#progressbar li.active {
    color: black
}

#progressbar li.active:before,
#progressbar li.active:after {
    background: rgb(252, 103, 49)
}

  .dot {
    display: inline;
    margin-left: 0.2em;
    margin-right: 0.2em;
    position: relative;
    opacity: 0;
    animation: showHideDot 2.5s ease-in-out infinite;
    font-size: 2em;
  }

    .one { animation-delay: 0.2s; }
    .two { animation-delay: 0.4s; }
    .three { animation-delay: 0.6s; }

@keyframes showHideDot {
  0% { opacity: 0; }
  50% { opacity: 1; }
  60% { opacity: 1; }
  100% { opacity: 0; }
}

div.dt-buttons {
    position: relative;
    float: left;
}
</style>
<div class="col-xl-10 col-md-10">
    <div class="tab-content my-account-tab" id="pills-tabContent">
        <h4 class="account-title"><?php echo $lang['order'] ?></h4>
        <p>
            <b>
                <?php echo $lang["cancleOD"] ?>
                <a style="text-decoration: none;" href="https://api.whatsapp.com/send?phone=60123608370&text=Hi,%20I%20want%20to%20cancel%20order." target="_blank">
                    <i>Whatsapp</i>
                </a>.
                <i style="color: red;"><?php echo $lang['xcancel'] ?></i>
            </b>
        </p>
        <div class="panel-group" id="accordion">
            <div class="panel panel-default text-center">
                <?php
                if (count($receipt_array) == 0) {
                    echo "<h1 style='text-align: center'>You have no orders yet!</h1>";
                } else {
                    
                    echo '
                        <table class="" style="width: 100%;" id="dtBasicExample">
                            <thead>
                                <tr>
                                    <th><h5>' . $lang['rid'] . '</h5></th>
                                    <th><h5>' . $lang['rname'] . '</h5></th>
                                    <th><h5>' . $lang['tdate'] . '</h5></th>
                                    <th><h5>' . $lang['total'] . '</h5></th>
                                    <th><h5>' . $lang['status'] . '</h5></th>
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
                            $display_row['receipt_postcode'] = $receipt_row["receipt_postcode"];
                            $display_row['receipt_state'] = $receipt_row["receipt_state"];
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
                            $display_row['delivery_time'] = $delivery_row["delivery_time"];
                            $display_row['receive_time'] = $delivery_row["receive_time"];
                        }
                        echo "<script>console.log('".$display_row['delivery_id']." , ".$display_row['delivery_status']."')</script>";
                        $get_rider = mysqli_query($link, "SELECT * FROM rider WHERE rider_id = '".$display_row['rider_id']."'");
                        while($rider_row = mysqli_fetch_assoc($get_rider)) {
                            $display_row['rider_fullname'] = $rider_row["rider_name"] . " " . $rider_row["rider_lastname"];
                            $display_row['rider_phone'] = $rider_row["rider_phone"];
                        }
                        $rID = $display_row['receipt_id'];
                        $rName = $display_row['receipt_lname'];
                        $Fname = $display_row['receipt_fname'];
                        $tDate = $display_row['receipt_date'];
                        $rEmail = $display_row['receipt_email'];
                        $rPhone = $display_row['receipt_phone'];
                        $rAdds = $display_row['receipt_address'];
                        $rArea = $display_row['receipt_area'];
                        $rPcode = $display_row['receipt_postcode'];
                        $rState = $display_row['receipt_state'];
                        $total = $display_row['payment_cost'];
                        $method = $display_row['payment_method'];
                        $uid = $display_row['user_id'];
                        $delStatus = $display_row['delivery_status'];
                        $delRider = $display_row['rider_id'];
                        $delETA = ($display_row['estimated_time'] == "") ? "<i>Your order is pending</i>" : $display_row['estimated_time'];
                        $delID = $display_row['delivery_id'];
                        $delTime = ($display_row['delivery_time'] == "") ? "<i>Your order is yet to deliver</i>" : $display_row['delivery_time'];
                        $receiveTime = $display_row['receive_time'];
                        $riderName = ($delRider == "No available rider" || $delRider == "") ? "" : $display_row['rider_fullname'];
                        $riderPhone = (isset($display_row['rider_phone'])) ? $display_row['rider_phone'] : "" ;

                        if($delStatus == "Delivering") {
                            $dispStatus = "<p style='color:orange'>".$lang['deliver']."</p>";
                        } else if($delStatus == "Received") {
                            $dispStatus = "<p style='color:limegreen'>".$lang['received']."</p>";
                        } else if($delStatus == "Cancelled") {
                            $dispStatus = "<p style='color:crimson'>".$lang['cancelle']."</p>";
                        } else if($delStatus == "Not Set") {
                            $dispStatus = "<p style='color:gray'>".$lang['notset']."</p>";
                        } else if($delStatus == "Preparing") {
                            $dispStatus = "<p style='color:pink'>".$lang['preparin']."</p>";
                        }
                        /*
                        if ($status == "Not Set")
                            $display = '<p>'.$lang['notset'].'</p>';
                        elseif ($status == "Delivering")
                            $display = '<p>'.$lang['deliver'].'</p>';
                        elseif ($status == "Preparing")
                            $display = '<p>'.$lang['preparin'].'</p>';
                        elseif ($status == "Cancelled")
                            $display = '<p style="color:crimson;">'.$lang['cancelle'].'</p>';
                        elseif ($status == "Received")
                            $display = '<p style="color:limegreen;">'.$lang['received'].'</p>';
                            */
                        echo '
                                                                       
                                <tr onmouseover="this.style.backgroundColor = `lightgray`" onmouseout="this.style.backgroundColor = `white`" onclick="openModal(' . $rID . ')" style="cursor:pointer">
                                    <td><p><p>' . $rID . '</p></p></td>
                                    <td><p><p>' . $Fname . ' ' . $rName . '</p></p></td>
                                    <td><p><p>' . $tDate . '</p></p></td>
                                    <td><p><p>' . number_format($total, 2) . '</p></p></td>
                                    <td><p>' . $dispStatus . '</p></td>
                                </tr>
                                                                    
                                ';
                        echo '
                                <div id="receipt-' . $rID . '" class="modal" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content" style="text-align: left;">
                                            <div class="modal-header" style="background-color:var(--thm-base)">
                                                <h4 class="modal-title"><span style="color:white;">' . $lang['detail'] . '</span></h4>
                                                <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                                            </div> 
                                            <!-- Modal Header-->

                                            <div class="modal-body">
                                                <div>
                                                    <h4>'.$lang['dStatus'].'</h4>
                                                    <hr>
                                                    <div style="display: flex"><img style="height:18vh; margin:auto" src="assets/images/delivery.gif"></div>
                                                    <div class="progress-track">
                                                        <ul id="progressbar">';
                                                        if ($delStatus == "Not set") {
                                                            echo 
                                                            '
                                                                <li class="step0 active " id="step1">'.$lang['notset'].'</li>
                                                                <li class="step0 text-center" id="step2">'.$lang['preparin'].'</li>
                                                                <li class="step0 text-right" id="step3">'.$lang['deliver'].'</li>
                                                                <li class="step0 text-right" id="step4">'.$lang['received'].'</li>
                                                            ';
                                                        } elseif ($delStatus == "Preparing") {
                                                            echo 
                                                            '
                                                                <li class="step0 active " id="step1">'.$lang['notset'].'</li>
                                                                <li class="step0 active text-center" id="step2">'.$lang['preparin'].'</li>
                                                                <li class="step0 text-right" id="step3">'.$lang['deliver'].'</li>
                                                                <li class="step0 text-right" id="step4">'.$lang['received'].'</li>
                                                            ';
                                                            
                                                        } elseif ($delStatus == "Delivering") {
                                                            echo 
                                                            '
                                                                <li class="step0 active " id="step1">'.$lang['notset'].'</li>
                                                                <li class="step0 active text-center" id="step2">'.$lang['preparin'].'</li>
                                                                <li class="step0 active text-right" id="step3">'.$lang['deliver'].'</li>
                                                                <li class="step0 text-right" id="step4">'.$lang['received'].'</li>
                                                            ';
                                                        } elseif ($delStatus == "Received") {
                                                            echo 
                                                            '
                                                                <li class="step0 active " id="step1">'.$lang['notset'].'</li>
                                                                <li class="step0 active text-center" id="step2">'.$lang['preparin'].'</li>
                                                                <li class="step0 active text-right" id="step3">'.$lang['deliver'].'</li>
                                                                <li class="step0 active text-right" id="step4">'.$lang['received'].'</li>
                                                                <h5 style="text-align: center; margin-top: 12%">'.$lang['received'].'</h5>
                                                            ';

                                                        } elseif ($delStatus == "Cancelled"){
                                                            echo '<h5 style="text-align: center">'.$lang['cancelle'].'</h5>';
                                                        }
                                                        echo '
                                                        </ul>
                                                    </div>';

                                                    if($delStatus != "Received" && $delStatus != "Cancelled") {
                                                        echo'
                                                    <div style="text-align: center;" class="loading-dots">
                                                        <h5 style="display: inline">'.$lang['ETA'].': '.$delETA.'</h5>
                                                        <h5 class="dot one">.</h5><h5 class="dot two">.</h5><h5 class="dot three">.</h5>
                                                    </div>';
                                                    }

                                                    echo'
                                                </div>
                                                
                                                <div>
                                                    <hr>
                                                        <h4>Your Rider</h4>
                                                    <hr>
                                                    <p>Rider Name: '. (($riderName == "") ? '<i>We are finding you a rider..</i>' : $riderName) .'</p>
                                                    <p>Rider Phone: '.$riderPhone.'</p>
                                                    <p>Delivery time: '.$delTime.'</p>
                                                    <p>Receive time: '.$receiveTime.'</p>
                                                </div>

                                                <div>
                                                    <hr>
                                                        <h4>'.$lang['receiptD'].'</h4>
                                                    <hr>
                                                    <p>' . $lang['rid'] . ': ' . $rID . '</p>
                                                    <p>' . $lang['payment'] . ': ' . $lang['pmethod'] . '</p>
                                                    <p>' . $lang['pcost'] . ': ' . $total . '</p>
                                                    <p>' . $lang['tdate'] . ': ' . $tDate . '</p>
                                                </div>

                                                <div>
                                                    <hr>
                                                        <h4>' . $lang['buyer'] . '</h4>
                                                    <hr>
                                                    <p>' . $lang['uid'] . ': ' . $uid . '</p>
                                                    <p>' . $lang['name'] . ': ' . $Fname . ' ' . $rName . '</p>
                                                    <p>' . $lang['email'] . ': ' . $rEmail . '</p>
                                                    <p>' . $lang['phone'] . ': ' . $rPhone . '</p>
                                                    <p>' . $lang['address'] . ': ' . $rAdds . ' ' . $rArea . ' ' . $rPcode . ' ' . $rState . '</p>
                                                </div>

                                                <div>
                                                    <hr>
                                                        <h4>' . $lang['purchase'] . '</h4>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p><b>' . $lang['item'] . '</b></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p><b>' . $lang['amount'] . '</b></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p><b>' . $lang['unit'] . '</b></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p><b>' . $lang['t_cost'] . '</b></p>
                                                        </div>
                                                 </div>
                            ';

                        $trans_sql = "  SELECT * FROM cust_transaction
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
                                                        <p>RM' . number_format($trans_row['cost'],2) . '</p>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <p>RM' . number_format($trans_row['total_cost'],2) . '</p>
                                                    </div>
                                                </div>
                                ';
                            }
                        }
                        echo '
                                            </div>
                                        </div>

                                        <div class="modal-footer" style="background-color:var(--thm-base)">';
                                            if($delStatus == "Delivering") {

                                                echo'
                                                <button type="button" class="btn btn-primary" onclick="receiveOrder('.$delID.')">'  .$lang['received']. '</button>
                                                ';

                                            }
                                            else if($delStatus != "Received" && $delStatus != "Cancelled") {

                                                echo'
                                                <button type="button" class="btn btn-primary" onclick="cancelOrder()">'  .$lang['cancelod']. '</button>';

                                            }
                                            echo '
                                            <a href="EditableInvoice/invoice.php?id=' . $rID . '" target="_blank">
                                                <button type="button" class="btn btn-primary" >'  .$lang['invoice']. '</button>
                                            </a>
                                            <button type="button" class="btn btn-danger"  onclick="return closeModal(' . $rID . ')">' . $lang['close'] . '</button>
                                        </div> 
                                        
                                    </div>
                                </div>
                            ';
                    }
                    echo '
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><h5>' . $lang['rid'] . '</h5></th>
                                    <th><h5>' . $lang['rname'] . '</h5></th>
                                    <th><h5>' . $lang['tdate'] . '</h5></th>
                                    <th><h5>' . $lang['total'] . '</h5></th>
                                    <th><h5>' . $lang['status'] . '</h5></th>
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
                {
                    text: 'Contact Us',
                    action: function ( e, dt, node, config ) {
                        window.open(
                            "https://api.whatsapp.com/send?phone=60123608370&text=Hi,%20I%20want%20to%20cancel%20order.",
                            '_blank' // <- This is what makes it open in a new window.
                        );
                    }
                }
            ],
            "order": [[ 2, "dsc" ]]

        });
    });

    function receiveOrder(id) {
        Swal.fire({
            title: 'Order received ?',
            text: 'Action cannot be undone',
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                location.href = "cust_view_order.php?receive&id="+id
            }
        });
    }
    function cancelOrder() {
        Swal.fire({
            title: 'Cancel Order',
            text: 'Please contact us on Whatsapp to inform us.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Contact Us',
        }).then((result) => {
            if (result.isConfirmed) {
                let a= document.createElement('a');
                a.target= '_blank';
                a.href= 'https://api.whatsapp.com/send?phone=60123608370&text=Hi,%20I%20want%20to%20cancel%20order.';
                a.click();
                //location.href = 'https://api.whatsapp.com/send?phone=60123608370&text=Hi,%20I%20want%20to%20cancel%20order.'
            }
        })
    }

</script>
</div>
</div>
</div>
</main>

<?php include 'cust_footer.php'; ?>