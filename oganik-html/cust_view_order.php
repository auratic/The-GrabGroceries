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
    $sql = "UPDATE cust_receipt SET delivery_status = 'Received', product_status = 'Received' WHERE receipt_id = ".$_GET['id'];

    if(mysqli_query($link, $sql)) {
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
</style>
<div class="col-xl-10 col-md-10">
    <div class="tab-content my-account-tab" id="pills-tabContent">
        <h4 class="account-title"><?php echo $lang['order'] ?></h4>

        <div class="panel-group" id="accordion">
            <b><?php echo $lang["cancleOD"] ?><a style="text-decoration: none;" href="https://api.whatsapp.com/send?phone=60123608370&text=Hi,%20I%20want%20to%20cancel%20order." target="_blank"><i>Whatsapp</i></a>.
                <i style="color: red;"><?php echo $lang['xcancel'] ?></i></b>
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
                            $del_status = $row["delivery_status"];
                            $method = $row['payment_method'];
                            $uid = $row['user_id'];
                        }

                        
                        if ($del_status == "Not set")
                            $del_display = $lang['notset'];
                        elseif ($del_status == "Delivering")
                            $del_display = $lang['deliver'];
                        elseif ($del_status == "Preparing")
                            $del_display = $lang['preparin'];
                        elseif ($del_status == "Cancelled")
                            $del_display = $lang['cancelle'];
                        elseif ($del_status == "Received")
                            $del_display = $lang['received'];
                        else
                            $del_display = $del_status;

                        if ($status == "Not Set")
                            $display = $lang['notset'];
                        elseif ($status == "Delivering")
                            $display = $lang['deliver'];
                        elseif ($status == "Preparing")
                            $display = $lang['preparin'];
                        elseif ($status == "Cancelled")
                            $display = '<p style="color:crimson;">'.$lang['cancelle'].'</p>';
                        elseif ($status == "Received")
                            $display = '<p style="color:limegreen;">'.$lang['received'].'</p>';
                        echo '
                                                                       
                                <tr onmouseover="this.style.backgroundColor = `lightgray`" onmouseout="this.style.backgroundColor = `white`" onclick="openModal(' . $rID . ')" style="cursor:pointer">
                                    <td><p>' . $rID . '</p></td>
                                    <td><p>' . $Fname . ' ' . $rName . '</p></td>
                                    <td><p>' . $tDate . '</p></td>
                                    <td><p>' . number_format($total, 2) . '</p></td>
                                    <td><p>' . $display . '</p></td>
                                </tr>
                                                                    
                                ';
                        if ($method == "Credit/Debit Cards")
                            $dispMethod = $lang['pmethod'];
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
                                                        if ($status == "Not set") {
                                                            echo 
                                                            '
                                                                <li class="step0 active " id="step1">'.$lang['notset'].'</li>
                                                                <li class="step0 text-center" id="step2">'.$lang['preparin'].'</li>
                                                                <li class="step0 text-right" id="step3">'.$lang['deliver'].'</li>
                                                                <li class="step0 text-right" id="step4">'.$lang['received'].'</li>
                                                            ';
                                                        } elseif ($status == "Preparing") {
                                                            echo 
                                                            '
                                                                <li class="step0 active " id="step1">'.$lang['notset'].'</li>
                                                                <li class="step0 active text-center" id="step2">'.$lang['preparin'].'</li>
                                                                <li class="step0 text-right" id="step3">'.$lang['deliver'].'</li>
                                                                <li class="step0 text-right" id="step4">'.$lang['received'].'</li>
                                                            ';
                                                            
                                                        } elseif ($status == "Delivering") {
                                                            echo 
                                                            '
                                                                <li class="step0 active " id="step1">'.$lang['notset'].'</li>
                                                                <li class="step0 active text-center" id="step2">'.$lang['preparin'].'</li>
                                                                <li class="step0 active text-right" id="step3">'.$lang['deliver'].'</li>
                                                                <li class="step0 text-right" id="step4">'.$lang['received'].'</li>
                                                            ';
                                                        } elseif ($status == "Received") {
                                                            echo 
                                                            '
                                                                <li class="step0 active " id="step1">'.$lang['notset'].'</li>
                                                                <li class="step0 active text-center" id="step2">'.$lang['preparin'].'</li>
                                                                <li class="step0 active text-right" id="step3">'.$lang['deliver'].'</li>
                                                                <li class="step0 active text-right" id="step4">'.$lang['received'].'</li>
                                                            ';

                                                        } elseif ($status == "Cancelled"){
                                                            echo '<h5 style="text-align: center">'.$lang['cancelle'].'</h5>';
                                                        }
                                                        echo '
                                                        </ul>
                                                    </div>
                                                    <h5 style="text-align: center">'.$lang['ETA'].': '.$del_display.'</h5>
                                                </div>
                                                <div>
                                                    <hr>
                                                        <h4>'.$lang['receiptD'].'</h4>
                                                    <hr>
                                                    <p>' . $lang['rid'] . ': ' . $rID . '</p>
                                                    <p>' . $lang['payment'] . ': ' . $dispMethod . '</p>
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

                                        <div class="modal-footer" style="background-color:var(--thm-base)">';
                                            if($status != "Received" && $status != "Cancelled") {

                                                echo'
                                                <button type="button" class="btn btn-primary" onclick="receiveOrder('.$rID.')">'  .$lang['received']. '</button>
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
                /*
                'pdf',
                'csv',
                'excel',
                'colvis'*/
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