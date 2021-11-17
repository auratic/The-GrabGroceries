<?php include 'admin_header.php' ;



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

        <div class="row" style="border: solid black 1px; padding:1%">
            <div class="col-sm-10">
                <a href="logout.php">
                    <button class="btn btn-info btn-lg">Logout</button>
                </a>
            </div>
            <div class="col-sm-2">
            </div>
        </div>

        <div class="row">
            <!--
            <div style="object-fit: cover">
                <img src="assets/images/digital-dashboard-for-clients.png" style="width:100%">
            </div>
            -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <h5 class="card-header" style="background-color: rgba(255,255,255,0.5)">Number of users</h5>
                        <div class="card-body">
                            <h5 class="card-title">10</h5>
                            <p class="card-text"></p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <h5 class="card-header" style="background-color: rgba(255,255,255,0.5)">Total Orders</h5>
                        <div class="card-body">
                            <h5 class="card-title">10</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <h5 class="card-header" style="background-color: rgba(255,255,255,0.5)">Total Products</h5>
                        <div class="card-body">
                            <h5 class="card-title">10</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <h5 class="card-header" style="background-color: rgba(255,255,255,0.5)">Total Visits</h5>
                        <div class="card-body">
                            <h5 class="card-title">10</h5>
                            <p class="card-text">higher than last month</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-5">
                <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                <script>
                    const month = new Array();
                    month[0] = "January";
                    month[1] = "February";
                    month[2] = "March";
                    month[3] = "April";
                    month[4] = "May";
                    month[5] = "June";
                    month[6] = "July";
                    month[7] = "August";
                    month[8] = "September";
                    month[9] = "October";
                    month[10] = "November";
                    month[11] = "December";

                    var today = new Date();

                    var xValues = [month[today.getMonth() - 4], month[today.getMonth() - 3], month[today.getMonth() - 2], month[today.getMonth() - 1], month[today.getMonth()]];
                    var yValues = [55, 49, 44, 24, 15];
                    var barColors = ["red", "green", "blue", "orange", "brown"];

                    new Chart("myChart", {
                        type: "bar",
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                            }]
                        },
                        options: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: "Sales report last 5 months"
                            }
                        }
                    });
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
    </div>

</section>
</div> <!-- page wrapper -->

<!-- /.search-popup -->

<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

<!-- template js -->
<script src="assets/js/organik.js"></script>
</body>

</html>