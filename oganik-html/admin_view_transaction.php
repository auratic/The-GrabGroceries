<?php

  session_start();

  date_default_timezone_set("Asia/Kuala_Lumpur");

  if(!isset($_SESSION["loggedin"]) || !isset($_SESSION["mode"]) || $_SESSION["mode"] !== "admin") {
   echo "
    <script>
      alert('You are not authorized to this page');
      location.href='index.php';
    </script>";
  }

  require "config.php";

  if(isset($_GET["update"])) {
    $receipt_id = $_GET["receipt_id"];
    $status = $_GET["status"];
    $date = date('Y-m-d H:i:s');

    for($i = 0 ; $i < count($receipt_id) ; $i++) {
        if($status == "Not Set") {
            $sql = "UPDATE cust_receipt SET product_status = '$status', delivery_date = NULL, receive_date = NULL WHERE receipt_id = ".$receipt_id[$i];

        } elseif ($status == "Preparing") {
            $sql = "UPDATE cust_receipt SET product_status = '$status' WHERE receipt_id = ".$receipt_id[$i];

        } elseif ($status == "Delivering") {
            $sql = "UPDATE cust_receipt SET product_status = '$status', delivery_date = '$date' WHERE receipt_id = ".$receipt_id[$i];

        } elseif ($status == "Received") {
            $sql = "UPDATE cust_receipt SET product_status = '$status', receive_date = '$date' WHERE receipt_id = ".$receipt_id[$i];
        }

        if(mysqli_query($link,$sql)) {
            echo "
            <script>alert('Updated')</script>";
        } else {
            echo "
            <script>alert('Something went wrong')</script>";
        }
    }
  }

  $sql_receipt = "SELECT receipt_id FROM cust_receipt";
  $receipt_array = array();

  if($receipt_result = mysqli_query($link, $sql_receipt)) {
    while($receipt_row = mysqli_fetch_assoc($receipt_result)) {
        array_push($receipt_array, $receipt_row["receipt_id"]);
    }
  }

  if(isset($_POST["filter"])) {

    unset($receipt_array);
    $receipt_array = array();

    $search_id = "";
    $date_from = "";
    $date_to = "";

    $id_error = $date_from_error = $date_to_error = "";

    if(isset($_POST["search-id"])) {
        
    }

    if($id_error == "" && $date_from_error = "" && $date_to_error == "") {

        if($search_id == "" && $date_from == "" && $date_to == "") {
            $sql_receipt = "SELECT receipt_id FROM cust_receipt";
        }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Customer's Transactions || TheGrabGroceries</title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicons/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicons/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicons/favicon-16x16.png" />
    <link rel="manifest" href="assets/images/favicons/site.webmanifest" />
    <meta name="description" content="Agrikon HTML Template For Agriculture Farm & Farmers" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Homemade+Apple&family=Abril+Fatface&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />


    <link rel="stylesheet" href="assets/vendors/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/vendors/bootstrap-select/bootstrap-select.min.css" />
    <link rel="stylesheet" href="assets/vendors/animate/animate.min.css" />
    <link rel="stylesheet" href="assets/vendors/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="assets/vendors/jarallax/jarallax.css" />
    <link rel="stylesheet" href="assets/vendors/organik-icon/organik-icons.css" />
    <link rel="stylesheet" href="assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css" />
    <link rel="stylesheet" href="assets/vendors/nouislider/nouislider.min.css" />
    <link rel="stylesheet" href="assets/vendors/nouislider/nouislider.pips.css" />
    <link rel="stylesheet" href="assets/vendors/odometer/odometer.min.css" />
    <link rel="stylesheet" href="assets/vendors/swiper/swiper.min.css" />
    <link rel="stylesheet" href="assets/vendors/tiny-slider/tiny-slider.min.css" />
    <link rel="stylesheet" type="assets/css" href="css/organik.css">

    <script src="assets/vendors/jquery/jquery-3.5.1.min.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="assets/vendors/jarallax/jarallax.min.js"></script>
    <script src="assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js"></script>
    <script src="assets/vendors/jquery-appear/jquery.appear.min.js"></script>
    <script src="assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js"></script>
    <script src="assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="assets/vendors/jquery-validate/jquery.validate.min.js"></script>
    <script src="assets/vendors/nouislider/nouislider.min.js"></script>
    <script src="assets/vendors/odometer/odometer.min.js"></script>
    <script src="assets/vendors/swiper/swiper.min.js"></script>
    <script src="assets/vendors/tiny-slider/tiny-slider.min.js"></script>
    <script src="assets/vendors/wnumb/wNumb.min.js"></script>
    <script src="assets/vendors/wow/wow.js"></script>
    <script src="assets/vendors/isotope/isotope.js"></script>
    <script src="assets/vendors/countdown/countdown.min.js"></script>

    <!-- template styles -->
    <link rel="stylesheet" href="assets/css/organik.css" />
    <style>
        body { 
          font: 14px sans-serif; 
          background-image: url("https://cdn.wallpapersafari.com/68/37/Gwgjo6.jpg")
        }
        .signup-form{ 
          padding: 20px; 
          margin: 20px 50px 20px 50px;
          background-color: azure;
          overflow: auto;
        }

        .panel-heading {
            border: solid var(--thm-base) 1px;
            box-sizing: border-box;
            background-color: azure/*var(--thm-base)*/;
            padding: 2%;
            margin: 1%
        }
    </style>
</head>

<body>
    <div class="preloader">
        <img class="preloader__image" width="55" src="assets/images/loaderr.png" alt="" />
    </div>
    <!-- /.preloader -->
    <div class="page-wrapper">
        <header class="main-header">
            <div class="topbar">
                <div class="container">
                    <div class="main-logo">
                        <a href="index.php" class="logo">
                            <img src="assets/images/logo-dark.png" width="105" alt="">
                        </a>
                        <div class="mobile-nav__buttons">
                            <a href="#" class="search-toggler"><i class="organik-icon-magnifying-glass"></i></a>
                            <a href="#" class="mini-cart__toggler"><i class="organik-icon-shopping-cart"></i></a>
                        </div><!-- /.mobile__buttons -->

                        <span class="fa fa-bars mobile-nav__toggler"></span>
                    </div><!-- /.main-logo -->

                    <div class="topbar__left">
                        <div class="topbar__social">
                            <a href="https://twitter.com/" class="fab fa-twitter"></a>
                            <a href="https://www.facebook.com/" class="fab fa-facebook-square"></a>
                            <a href="https://www.instagram.com/" class="fab fa-instagram"></a>
                        </div><!-- /.topbar__social -->
                        <div class="topbar__info">
                            <i class="organik-icon-email"></i>
                            <p>Email <a href="mailto:thegrabgroceries@gmail.com">thegrabgroceries@gmail.com</a></p>
                        </div><!-- /.topbar__info -->
                    </div><!-- /.topbar__left -->
                    <div class="topbar__right">
                        <div class="topbar__info">
                            <i class="organik-icon-calling"></i>
                            <p>Phone <a href="tel:+92-666-888-0000">+60123456789</a></p>
                        </div><!-- /.topbar__info -->
                        <div class="topbar__buttons">
                            <a href="#" class="search-toggler"><i class="organik-icon-magnifying-glass"></i></a>
                            <a href="#" class="mini-cart__toggler"><i class="organik-icon-shopping-cart"></i></a>
                        </div><!-- /.topbar__buttons -->
                    </div><!-- /.topbar__left -->

                </div><!-- /.container -->
            </div><!-- /.topbar -->
            <nav class="main-menu">
                <div class="container">
                    <div class="main-menu__login">
                    <a href="<?php if(isset($_SESSION["lname"])) { echo "adminprofile.php";} else { echo "login.php"; }?>" >
                            <i class="organik-icon-user"></i>
                                <?php 

                                if(isset($_SESSION["lname"])) { 
                                    echo $_SESSION['lname'];
                                } else { 
                                    echo "Login / Register";
                                }
                                
                                ?>
                        </a>
                    </div><!-- /.main-menu__login -->
                    <ul class="main-menu__list">
                        <li>
                            <a href="adminprofile.php">Profile</a>
                        </li>
                        <li>
                            <a href="additem.php">Add item</a>
                        </li>
                        <li class="dropdown">
                            <a href="displayitem.php">Update product</a>
                            <ul>
                                <li><a href="displayitem.php">Update product</a></li>
                                <li><a href="archiveitem.php">Archive product</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="admin_view_transaction.php">Transactions</a>
                        </li>
                        <li><a href="adminlist.php">Admin</a></li>
                    </ul>
                    <div class="main-menu__language">
                        <img src="assets/images/resources/flag-1-1.jpg" alt="">
                        <label class="sr-only" for="language-select">select language</label>
                        <!-- /#language-select.sr-only -->
                        <select class="selectpicker" id="language-select-header">
                            <option value="english">English</option>
                            <option value="arabic">Arabic</option>
                        </select>
                    </div><!-- /.main-menu__language -->
                </div><!-- /.container -->
            </nav>
        </header>

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->

        <section class="">
                <div class="container" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">
                    <h1>Customer's transaction</h1>
                </div>

                <div class="container" style="background-color:rgba(255,255,255,0.8); padding: 2%">
                    <div class="row">
                        <div class="col-sm-2" style="
                            border: gray solid 1px;
                            border-radius: 10px;
                            padding: 1%;
                            background-color: lightgray;">
                            <form action="admin_view_transaction.php" method="post">

                                
                                    <div class="form-group" style="text-align: left">
                                        <label>Search by Receipt ID</label> <br>
                                        <input type="text" name="search-id" class="form-control"></input>
                                    </div>
                                            
                                    <div class="form-group" style="text-align: left">
                                        <label>Search by email</label> <br>
                                        <input type="text" name="search-id" class="form-control"></input>
                                    </div>

                                    <hr>

                                    <label><b>Transaction Date</b></label> </br>
                                    <div class="form-group" style="text-align: left">
                                        <p>from</p>           
                                        <input type="date" name="date-from" class="form-control"></input>
                                    </div>
                                    <div class="form-group" style="text-align: left">
                                        <p>to</p>
                                        <input type="date" name="date-to" class="form-control"></input>
                                    </div>
                                            
                                    <div class="form-group" style="text-align: left">
                                        <input class="btn btn-primary" type="submit" value="Filter" name="filter">
                                    </div>
                                        
                            </form>
                        </div>

                        <div class="col-sm-10">
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
                                    
                                    if(count($receipt_array) == 0) {
                                        echo "<h1 style='text-align: center'>You have no orders yet!</h1>";
                                    } else {
                                        foreach($receipt_array as $x => $x_value) {
                                            $display_sql = "SELECT * FROM cust_receipt 
                                            INNER JOIN users ON cust_receipt.user_id = users.user_id 
                                            WHERE cust_receipt.receipt_id = $x_value;
                                            ";

                                            if ($display_result = mysqli_query($link, $display_sql)) {

                                                while ($display_row = mysqli_fetch_assoc($display_result)) {
                                                        echo '
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <div class="row">
                                                                    <input type="" hidden value="'.$display_row["receipt_id"].'" name="receipt"></input>
                                                                    <div class="col-md-3">
                                                                        <h5 class="panel-title">Receipt ID: </h5>
                                                                        <p>'.$display_row["receipt_id"].'</p>
                                                                            
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <h5>Transaction Date: </h5>
                                                                        <p>'.$display_row["receipt_date"].'</p>
                                                                    </div>
                                                                        
                                                                    <div class="col-md-3">
                                                                        <h5>Status: </h5>
                                                                        <p>'.$display_row["product_status"].'</p>
                                                                    </div>

                                                                    <div class="col-md-2" style="display: flex; flex-direction: column; align-items: flex-end;">
                                                                        <input type="checkbox" name="select-item" value="'.$display_row['receipt_id'].'">
                                                                    </div>
                                                                </div> 
                                                                
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
                                                                </div>';
                                                                

                                                                $trans_sql = "SELECT * FROM cust_transaction
                                                                INNER JOIN item ON cust_transaction.item_id = item.item_id
                                                                WHERE cust_transaction.receipt_id = $x_value;";
                                            
                                                                if ($trans_result = mysqli_query($link, $trans_sql)) {

                                                                    while ($trans_row = mysqli_fetch_assoc($trans_result)) {

                                                                        echo '
                                                                        <div class="row">
                                                                            <div class="col-md-2">
                                                                                <img src="assets/images/items/'.$trans_row['image'].'" style="width:50%;object-fit:contain;">
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <p>'.$trans_row['item'].'</p>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <p>x'.$trans_row['amount'].'</p>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <p>RM'.$trans_row['cost'].'</p>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <p>RM'.$trans_row['total_cost'].'</p>
                                                                            </div>
                                                                        </div>
                                                                        ';
                                                                    }

                                                                }
                                                                echo '<hr>
                                                                
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <p><b>Receipt Name: </b> <br>'.$display_row["receipt_name"].'</p>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <p><b>Receipt Email: </b> <br>'.$display_row["receipt_email"].'</p>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <p><b>Receipt Phone: </b> <br>'.$display_row["receipt_phone"].'</p>
                                                                    </div>
                                                                    <div class="col-md-3" style="display: flex; flex-direction: column; align-items: flex-end;">
                                                                        
                                                                        <div class="dropdown show">
                                                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                More option
                                                                            </a>

                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                <a class="dropdown-item" href="EditableInvoice/invoice.php?id='.$display_row["receipt_id"].'" target="_blank">
                                                                                    View Details
                                                                                 </a>
                                                                                 <a class="dropdown-item" href="EditableInvoice/invoice.php?id='.$display_row["receipt_id"].'" target="_blank">
                                                                                    Invoice
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>

                                                                <div class="row more-detail" style="display: flex; justify-content: center; cursor: pointer;" data-toggle="collapse" data-parent="#accordion" data-target="#R'.$display_row["receipt_id"].'">
                                                                    <h5>Click to show more detail<i class="fas fa-plus"></i></h5>
                                                                </div>
                                                            </div>

                                                            <div id="R'.$display_row["receipt_id"].'" class="panel-collapse collapse in" style="margin: 2%;">
                                                                <p>User ID: '.$display_row["user_id"].'</p>
                                                                <p>Name: '.$display_row["receipt_name"].'</p>
                                                                <p>Email: '.$display_row["receipt_email"].'</p>
                                                                <p>Phone: '.$display_row["receipt_phone"].'</p>
                                                                <p>Address: '.$display_row["receipt_address"].'</p>
                                                                <p>Payment Method: '.$display_row["payment_method"].'</p>
                                                                <p>Payment Cost: '.$display_row["payment_cost"].'</p>
                                                            </div>
                                                        </div>
                                                        ';
                                                }
                                            }
                                        }           
                                    }        
                                    ?>

                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
    <script>
        //Hide other panel when another collapses
        $('.more-detail').click( function(e) {
            $('.collapse').collapse('hide');
        });

        //check for Navigation Timing API support
        if (window.performance) {
            console.info("window.performance works fine on this browser");
        }
        console.info(performance.navigation.type);
        if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
            location.href = "admin_view_transaction.php";
        } else {
            console.info( "This page is not reloaded");
        }

        var checkboxes = document.getElementsByName('select-item');
        var select_all = document.getElementById("select-all");

        select_all.onclick = () => {

            if(select_all.checked) {
                //console.log("yes")
                for(var i=0, n=checkboxes.length;i<n;i++) {
                    checkboxes[i].checked = true;
                }
            } else {
                //console.log("no")
                for(var i=0, n=checkboxes.length;i<n;i++) {
                    checkboxes[i].checked = false;
                }
            }
        }

        function updateStatus() {
            var receipt_id = [];
            var status = document.getElementById("status").value;

            if(status === "--Status--") {
                document.getElementById("status-err").innerHTML = "Choose status";
            } else {

                for(var i=0, n=checkboxes.length;i<n;i++) {
                    if(checkboxes[i].checked == true) {
                        receipt_id.push(checkboxes[i].value);
                    }
                }

                if (confirm("Set status to '"+ status +"'? Press 'OK' to continue")) {
                    $.ajax({
                        type: "get",
                        url: "admin_view_transaction.php",
                        data: {  
                        'update' : true,
                        'receipt_id' : receipt_id,
                        'status': status
                        },
                        cache: false,
                        success: function (html) {
                            alert('Updated');
                            location.href = 'admin_view_transaction.php';
                        }
                    });
                    
                } else {
                }
            }

            return false;
        }

        function download() {
            $.ajax({
                        type: "get",
                        url: "EditableInvoice/invoice.php",
                        data: {  
                        'id' : true
                        },
                        cache: false,
                        success: function (html) {
                            
                        }
                    });
            return false;
        }
    </script>
    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- template js -->
    <script src="assets/js/organik.js"></script>
</body>

</html>
