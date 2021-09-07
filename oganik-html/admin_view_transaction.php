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

  if(isset($_GET["receipt"])) {
    $receipt_id = $_GET["receipt"];
    $status = $_GET["status"];
    $date = date('Y-m-d H:i:s');

    if($status == "Not Set") {
        $sql = "UPDATE cust_receipt SET product_status = '$status', delivery_date = NULL, receive_date = NULL WHERE receipt_id = $receipt_id";

    } elseif ($status == "Preparing") {
        $sql = "UPDATE cust_receipt SET product_status = '$status' WHERE receipt_id = $receipt_id";

    } elseif ($status == "Delivering") {
        $sql = "UPDATE cust_receipt SET product_status = '$status', delivery_date = '$date' WHERE receipt_id = $receipt_id";

    } elseif ($status == "Received") {
        $sql = "UPDATE cust_receipt SET product_status = '$status', receive_date = '$date' WHERE receipt_id = $receipt_id";
    }

    if(mysqli_query($link,$sql)) {
        echo "
        <script>alert('Updated')</script>";
    } else {
        echo "
        <script>alert('Something went wrong')</script>";
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
            background-color: var(--thm-base);
            border-radius: 25px;
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
                        <li>
                            <a href="displayitem.php">Update Item</a>
                        </li>
                        <li>
                            <a href="admin_view_transaction.php">Transactions</a>
                        </li>
                        <li><a href="contact.php">Contact</a></li>
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

            <div class="signup-form fluid-container">

                <form action="admin_view_transaction.php" method="post">
                    <h4 style="margin: 0px 0px 1% 1.5%;">Customer's Transactions</h4>

                    <div style="background-color:var(--thm-base); margin:1%; padding:2%; border-radius:25px;">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Search by Receipt ID</label>
                                <input type="text" name="search-id"></input>
                            </div>
                            <div class="col-md-3">
                                <label>Minimize View</label><input type="checkbox"></input>
                                <label>View Details</label><input type="checkbox"></input>
                            </div>
                            <div class="col-md-3">
                                <label>From</label><input type="date" name="date-from"></input>
                                <br>
                                <label>To</label><input type="date" name="date-to"></input>
                            </div>

                            <div class="col-md-3">
                                <input class="btn btn-default btn-md" value="Filter" name="filter"></button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="panel-group" id="accordion">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                            <form action="admin_view_transaction.php?receipt=R999999999">
                                <div class="row">
                                    <div class="col-md-2">
                                        <h4 class="panel-title">
                                            Receipt ID: R999999999
                                        </h4>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>Transaction Date: </h4>
                                        <p>2010-10-10 10:10:10</p>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <h4>Delivery Date: </h4>
                                        <p>2010-10-10 10:10:10</p>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <h4>Receive Date: </h4>
                                        <p>2010-10-10 10:10:10</p>
                                    </div>
                                        <div class="col-md-2">
                                            <h4>Status: </h4>
                                            <select id="status" name="status">
                                                <!-- <option value="" selected disabled hidden>Choose here</option> -->
                                                <option value="Not Set">Not Set</option>
                                                <option value="Preparing">Preparing</option>
                                                <option value="Delivering">Delivering</option>
                                                <option value="Received">Received</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2" style="display: flex; flex-direction: column; align-items: flex-end;">
                                                <button class="btn btn-default btn-lg" type="submit" style="background-color:azure">Update Status</button>
                                        </div>
                                </div> 
                            </form>
                            <hr>
                            <div class="row more-detail" style="display: flex; justify-content: center; cursor: pointer;" data-toggle="collapse" data-parent="#accordion" data-target="#collapse1">
                                <h5>Click to show more detail<i class="fas fa-plus"></i></h5>
                            </div>
                        </div>

                        <div id="collapse1" class="panel-collapse collapse in" style="margin: 2%;">
                            <p>Name: mw</p>
                            <p>Email: mw@gmail.com</p>
                            <p>Phone: 01234567890</p>
                            <p>Address: Jalan Bukit Beruang</p>
                            <p>Payment Method: Visa ****-****-****-1448</p>
                            <p>Payment Made: RM999.99</p>
                            <p>Products Purchased:</p>
                            <table>
                            <table class="table table-bordered table-striped table-hover table-condensed">
                                <tr>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Amount</th>
                                    <th>Cost Rer Product</th>
                                    <th>Total Cost</th>
                                </tr>
                                <tr>
                                    <td>'.$row['id'].'</td>
                                    <td>'.$row['item'].'</td>
                                    <td>'.$row['category'].'</td>
                                    <td>'.$row['description'].'</td>
                                    <td>'.$row['stock'].'</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
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
                                                <form method="get" action="admin_view_transaction.php">
                                                <div class="row">
                                                    <input type="" hidden value="'.$display_row["receipt_id"].'" name="receipt"></input>
                                                    <div class="col-md-2">
                                                        <h4 class="panel-title">
                                                            Receipt ID: '.$display_row["receipt_id"].'
                                                        </h4>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <h4>Transaction Date: </h4>
                                                        <p>'.$display_row["receipt_date"].'</p>
                                                    </div>
                                                    
                                                    <div class="col-md-2">
                                                        <h4>Delivery Date: </h4>
                                                        <p>'.$display_row["delivery_date"].'</p>
                                                    </div>
                                                    
                                                    <div class="col-md-2">
                                                        <h4>Receive Date: </h4>
                                                        <p>'.$display_row["receive_date"].'</p>
                                                    </div>
                                                    
                                                    <div class="col-md-2">
                                                        <h4>Status: </h4>
                                                        <select id="status" name="status">
                                                            <option value="'.$display_row["product_status"].'" selected disabled hidden>'.$display_row["product_status"].'</option>
                                                            <option value="Not Set">Not set</option>
                                                            <option value="Preparing">Preparing</option>
                                                            <option value="Delivering">Delivering</option>
                                                            <option value="Received">Received</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2" style="display: flex; flex-direction: column; align-items: flex-end;">
                                                        <button class="btn btn-default btn-lg" type="submit" style="background-color:azure">Update Status</button>
                                                    </div>
                                                </div> 
                                                </form>
                                                
                                                <hr>

                                                <div class="row more-detail" style="display: flex; justify-content: center; cursor: pointer;" data-toggle="collapse" data-parent="#accordion" data-target="#R'.$display_row["receipt_id"].'">
                                                    <h5>Click to show more detail<i class="fas fa-plus"></i></h5>
                                                </div>
                                            </div>

                                            <div id="R'.$display_row["receipt_id"].'" class="panel-collapse collapse in" style="margin: 2%;">
                                                <p>Name: '.$display_row["firstname"]." ".$display_row["lastname"].'</p>
                                                <p>Email: '.$display_row["email"].'</p>
                                                <p>Phone: '.$display_row["phone"].'</p>
                                                <p>Address: '.$display_row["address1"].'</p>
                                                <p>Payment Method: '.$display_row["payment_method"].'</p>
                                                <p>Payment Cost: '.$display_row["payment_cost"].'</p>
                                                <p>Products Purchased:</p>
                                                <table class="table table-bordered table-striped table-hover table-condensed">
                                                    <tr>
                                                        <th>Item ID</th>
                                                        <th>Item Name</th>
                                                        <th>Amount</th>
                                                        <th>Cost Rer Product</th>
                                                        <th>Total Cost</th>
                                                    </tr>';
                                }
                            }

                            $trans_sql = "SELECT * FROM cust_transaction
                                          INNER JOIN item ON cust_transaction.item_id = item.item_id
                                          WHERE cust_transaction.receipt_id = $x_value;";
                                          
                            if ($trans_result = mysqli_query($link, $trans_sql)) {

                                while ($trans_row = mysqli_fetch_assoc($trans_result)) {

                                    echo '
                                        <tr>
                                            <td>'.$trans_row['item_id'].'</td>
                                            <td>'.$trans_row['item'].'</td>
                                            <td>'.$trans_row['amount'].'</td>
                                            <td>'.$trans_row['cost'].'</td>
                                            <td>'.$trans_row['total_cost'].'</td>
                                        </tr>
                                        ';
                                }

                            }
                                        
                            echo '
                            </table>
                            </div>
                            </div>';
                        }
                                    
                    }        
                    ?>

                </div> 
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
            </script>
    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- template js -->
    <script src="assets/js/organik.js"></script>
</body>

</html>
