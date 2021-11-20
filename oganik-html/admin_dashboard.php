<?php include 'admin_header.php' ;

    $sql = "SELECT COUNT(user_id) FROM users WHERE mode = 'customer'";
    $result = mysqli_query($link, $sql);
    if($row=mysqli_fetch_assoc($result))
    {
        $users = $row['COUNT(user_id)'];
    }
?>

<style>
    .card {
        min-height: 100%;
        min-width: 100%;
    }
</style>

<section>
    <div class="container" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">

        <h1>Dashboard</h1>

    </div>

    <div class="container" style="padding:2%; background-color:rgba(255,255,255,0.8);">

        <div class="row">
            <!--
            <div style="object-fit: cover">
                <img src="assets/images/digital-dashboard-for-clients.png" style="width:100%">
            </div>
            -->
            <div class="row" style="margin-top: 10px;">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <h5 class="card-header" style="background-color: rgba(255,255,255,0.5)">Number of customer</h5>
                        <div class="card-body" onclick="location.href='admin_custList.php'" style="cursor: pointer;" onmouseover="this.style.backgroundColor = 'azure'" onmouseout="this.style.backgroundColor = 'lightgray'">
                            <h5 class="card-title"><?php echo 'Currently we have <i>'.$users. '</i> customers registered.' ?></h5>
                            <p class="card-text"></p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <h5 class="card-header" style="background-color: rgba(255,255,255,0.5)">Total Orders</h5>
                        <div class="card-body" style="cursor: pointer;" onmouseover="this.style.backgroundColor = 'azure'" onmouseout="this.style.backgroundColor = 'lightgray'" onclick="location.href='admin_view_transaction.php'">
                            <?php
                                $order = "SELECT COUNT(receipt_id) FROM cust_receipt";
                                $orders = mysqli_query($link, $order);
                                if($orderC=mysqli_fetch_assoc($orders))
                                {
                                    $orderr = $orderC['COUNT(receipt_id)'];
                                }
                            ?>
                            <h5 class="card-title"><?php echo $orderr ?></h5>
                            <p class="card-text">All successful orders will be counted.</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <h5 class="card-header" style="background-color: rgba(255,255,255,0.5)">Total Products</h5>
                        <div class="card-body" style="cursor: pointer;" onmouseover="this.style.backgroundColor = 'azure'" onmouseout="this.style.backgroundColor = 'lightgray'" onclick="location.href='admin_displayitem.php'">
                            <?php
                                $items = "SELECT COUNT(item_id) FROM item WHERE item_status='Active'";
                                $checkitm = mysqli_query($link, $items);
                                if($chkitm=mysqli_fetch_assoc($checkitm))
                                {
                                    $product = $chkitm['COUNT(item_id)'];
                                }
                            ?>
                            <h5 class="card-title"><?php echo 'There are currently <i>'.$product.'</i> products on sale.' ?></h5>
                            <p class="card-text"></p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <h5 class="card-header" style="background-color: rgba(255,255,255,0.5)">Total Revenue</h5>
                        <div class="card-body" onClick="viewEarn();" style="cursor: pointer;" onmouseover="this.style.backgroundColor = 'azure'" onmouseout="this.style.backgroundColor = 'lightgray'">
                            <?php
                                $earn = "SELECT SUM(payment_cost), product_status FROM cust_receipt WHERE product_status = 'Received'";
                                $earnt = mysqli_query($link, $earn);
                                if($rearn=mysqli_fetch_assoc($earnt))
                                {
                                    $total = $rearn['SUM(payment_cost)'];
                                }
                            ?>
                            <h5 class="card-title">RM <?php echo number_format($total,2)?></h5>
                            <p class="card-text">Included shipping cost and received orders.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-5">
                <h4>Total Users</h4>
                <div id="piechart"></div>
                <?php
                    $SQL = "SELECT COUNT(user_id) as vcust FROM users WHERE mode = 'customer' AND verified = 'true'";
                    $resultss = mysqli_query($link, $SQL);
                    if($row=mysqli_fetch_assoc($resultss))
                    {
                        $usersv = $row['vcust'];
                    }

                    $noneVer = "SELECT COUNT(user_id) as nvcust FROM users WHERE mode = 'customer' AND verified = 'false'";
                    $resultsss = mysqli_query($link, $noneVer);
                    if($rowq=mysqli_fetch_assoc($resultsss))
                    {
                        $nusersv = $rowq['nvcust'];
                    }
            
                    $sqls = "SELECT COUNT(user_id) as Admin FROM users WHERE mode = 'admin'";
                    $resulta = mysqli_query($link, $sqls);
                    if($roww=mysqli_fetch_assoc($resulta))
                    {
                        $adminlist = $roww['Admin'];
                    }

                    $sqlss = "SELECT COUNT(user_id) as Adminn FROM users WHERE mode = 'deactivate'";
                    $resultaa = mysqli_query($link, $sqlss);
                    if($rowww=mysqli_fetch_assoc($resultaa))
                    {
                        $adminlists = $rowww['Adminn'];
                    }

                    $sqlss = "SELECT COUNT(user_id) as superadmin FROM users WHERE mode = 'superadmin'";
                    $resultb = mysqli_query($link, $sqlss);
                    if($rowl=mysqli_fetch_assoc($resultb))
                    {
                        $superadmin = $rowl['superadmin'];
                    }
                ?>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                <script type="text/javascript">
                // Load google charts
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                // Draw the chart and set the chart values
                function drawChart() {
                var data = google.visualization.arrayToDataTable([
                ['Roles', 'Amount'],
                ['Verified Customers', <?php echo $usersv?>],
                ['None Verified Customers', <?php echo $nusersv?>],
                ['Active Admin', <?php echo $adminlist?>],
                ['Inactive Admin', <?php echo $adminlists?>],
                ['Superadmin', <?php echo $superadmin?>],
                ]);

                // Optional; add a title and set the width and height of the chart
                var options = {'title':'TheGrabGroceries', 'width':450, 'height':376};

                // Display the chart inside the <div> element with id="piechart"
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
                }
                </script>
            </div>
            <div class="col-7">
                <div>
                    <h4>Admin's Activities</h4>
                </div>

                <div id="feed" style="
                                background-color: azure;
                                max-height: 50vh;
                                width: 100%;
                                overflow: scroll;
                                border: solid lightgreen 1px;">

                    <?php

                    $sql = "
                            SELECT * FROM admin_activity 
                            INNER JOIN users ON admin_activity.user_id = users.user_id
                            ORDER BY admin_activity.activity_time DESC";

                    if ($result = mysqli_query($link, $sql)) {

                        while ($row = mysqli_fetch_assoc($result)) {
                            switch ($row["activity"]) {
                                case 'login':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") <b>logged in</b> at " . $row["activity_time"] . "</p>";
                                    break;
                                case 'add item':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") 
                                                        <b>added a product</b> (item_name: " . $row["target"] . ") 
                                                        at " . $row["activity_time"] . "</p>";
                                    break;
                                case 'update item':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") 
                                                        <b>updated product</b> (item_id: " . $row["target"] . ") 
                                                        at " . $row["activity_time"] . "</p>";
                                    break;
                                case 'archive item':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") 
                                                        <b>archived product</b> (item_id: " . $row["target"] . ") 
                                                        at " . $row["activity_time"] . "</p>";
                                    break;
                                case 'restore item':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") 
                                                        <b>restored product</b> (item_id: " . $row["target"] . ") 
                                                        at " . $row["activity_time"] . "</p>";
                                    break;
                                case 'delete item':
                                    break;
                                case 'update receipt':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") 
                                                        <b>update receipt</b> (receipt_id: " . $row["target"] . ") 
                                                        at " . $row["activity_time"] . "</p>";
                                    break;
                                case 'add admin':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") 
                                                        <b>added a new admin</b> (" . $row["target"] . ") 
                                                        at " . $row["activity_time"] . "</p>";
                                    break;
                            }
                        }
                    }

                    ?>

                </div>

            </div>
        </div>

        <div class="row">
            <a href="logout.php">
                <button class="btn btn-info btn-lg" style="margin-top :10px; width: 1180px;">Logout</button>
            </a>
        </div>
    </div>

    <!--<div class="modal" id="add-modal" role="dialog">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">
                <div class="modal-header" style="background-color: #679aeb;">
                    <h4 class="modal-title"><span style="color:white;">Customer List</span></h4>
                    <button type="button" class="close" style="margin-right: 10px">&times;</button>
                </div>
                Modal Header

                <div class="modal-body">
                    <div class="row">
                        <table style="width: 100%;" id="dtBasicExample">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone</th>
                                    <th>E-mail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sqll = "SELECT * FROM users where mode ='customer'";
                                    $list = mysqli_query($link, $sqll);
                                    while ($rows = mysqli_fetch_assoc($list)) {
                                    echo '
                                    <tr>
                                        <td>' . $rows['user_id'] . '</td>
                                        <td>' . $rows['firstname'] . '</td>
                                        <td>' . $rows['lastname'] . '</td>
                                        <td>' . $rows['phone'] . '</td>
                                        <td>' . $rows['email'] . '</td>
                                    </tr>';
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Phone</th>
                                <th>E-mail</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
                 Modal Body

                <div class="modal-footer" style="background-color: #679aeb;">
                    <button type="button" class="btn btn-danger" onclick="closeList()">Close</button>
                </div>
                 Modal Footer
            </div>
             Modal content
        </div>
    </div>-->

    <div class="modal" id="add-modals" role="dialog">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">
                <div class="modal-header" style="background-color: #679aeb;">
                    <h4 class="modal-title"><span style="color:white;">Total Revenue</span></h4>
                    <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                </div>
                <!-- Modal Header-->

                <div class="modal-body">
                    <div class="row">
                        <table stlye="width: 100%;" id="dtBasicExamples">
                            <thead>
                                <tr>
                                    <th><h5>Receipt ID</h5></th>
                                    <th><h5>Name</h5></th>
                                    <th><h5>Transaction Date</h5></th>
                                    <th><h5>Total (RM)</h5></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $revenue = "SELECT * FROM cust_receipt where product_status = 'Received'";
                                $earns = mysqli_query($link, $revenue);
                                while ($rowss = mysqli_fetch_assoc($earns)) 
                                {
                                    echo'
                                    <tr>
                                        <td>'.$rowss['receipt_id'].'</td>
                                        <td>'.$rowss['receipt_fname'].' '.$rowss['receipt_lname'].'</td>
                                        <td>'.$rowss['receipt_date'].'</td>
                                        <td>'.$rowss['payment_cost'].'</td>
                                    </tr>
                                    ';
                                }
                            ?>
                            </tbody>
                            <tfoot>
                                    <th><h5>Receipt ID</h5></th>
                                    <th><h5>Name</h5></th>
                                    <th><h5>Transaction Date</h5></th>
                                    <th><h5>Total (RM)</h5></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- Modal Body-->

                <div class="modal-footer" style="background-color: #679aeb;">
                    <button type="button" class="btn btn-danger" onclick="closeEarn()">Close</button>
                </div>
                <!-- Modal Footer-->
            </div>
            <!-- Modal content-->
        </div>
    </div>
</section>
</div> <!-- page wrapper -->

<!-- /.search-popup -->

<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

<!-- template js -->
<script src="assets/js/organik.js"></script>
<script>
    function viewList() {
        $('#add-modal').fadeIn();
        return false;
    }

    function closeList() {
        $('#add-modal').fadeOut();
        return false;
    }

    function viewEarn() {
        $('#add-modals').fadeIn();
        return false;
    }

    function closeEarn() {
        $('#add-modals').fadeOut();
        return false;
    }

    $(document).ready(function() {
        var table = $('#dtBasicExample').DataTable({
            //"scrollY": "50vh",
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

        var table = $('#dtBasicExamples').DataTable({
            //"scrollY": "50vh",
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
    });
</script>
</body>

</html>