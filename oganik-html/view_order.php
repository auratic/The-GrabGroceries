<?php
  session_start();
  
  if(!isset($_SESSION["loggedin"])) {
    echo "
     <script>
       alert('Please login');
       location.href='login.php';
     </script>";
   }

  require "config.php";

   
  $sql_receipt = "SELECT receipt_id FROM cust_receipt 
                  WHERE user_id = ".$_SESSION['userid'];
  $receipt_array = array();

  if($receipt_result = mysqli_query($link, $sql_receipt)) {
    while($receipt_row = mysqli_fetch_assoc($receipt_result)) {
        array_push($receipt_array, $receipt_row["receipt_id"]);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile || TheGrabGroceries</title>
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
        .signup-form{ width: 360px; padding: 20px; }

        .containerr
        {
            color:black;
            background-color:white;
            margin-top: 70px;
            margin-left: 50px;
            margin-bottom: 80px;
            border-radius: 5px;
            border-style: double;
            width: 1430px;
        }

        .panel-heading {
            border: solid var(--thm-base) 1px;
            box-sizing: border-box;
            background-color: azure/*var(--thm-base)*/;
            padding: 2%;
            margin: 1%
        }
        .modal {
			background-color: rgba(0,0,0,0.5);
        }
        .modal > div {
            padding: 10px;
        }
		.modal-content {
            border-radius: 25px;
		}

        .modal-header {
            border-radius: 25px 25px 0 0;
        }

        .modal-footer {
            border-radius: 0 0 25px 25px;
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
                            <img src="assets/images/Logo6.png" width="105" alt="">
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
                    <a href="<?php if(isset($_SESSION["lname"])) { echo "profile.php";} else { echo "login.php"; }?>" >
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
                        <li class="dropdown">
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                            <a href="about.php">About</a>
                        </li>
                        <li class="dropdown">
                            <a href="products.php">Shop</a>
                            <ul>
                                <li><a href="products.php">Shop</a></li>
                                <li><a href="product-details.php">Product Details</a></li>
                                <li><a href="cart.php">Cart Page</a></li>
                                <li><a href="checkout.php">Checkout</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="news.php">News</a>
                            <ul>
                                <li><a href="news.php">News</a></li>
                                <li><a href="news-details.php">News Details</a></li>
                            </ul>
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
        </header>
            
            <!-- :::::::::: Profile :::::::::: -->
            <main id="main-container" class="main-container">
                <div class="containerr">
                    <div class="row">
                            <!-- :::::::::: Start My Account Section :::::::::: -->
                            <div class="my-account-area">
                                <div class="row">
                                    <div class="col-xl-3 col-md-3" style="border-right: 1px solid black">
                                        <div class="my-account-menu">
                                            <ul class="nav account-menu-list flex-column nav-pills" id="pills-tab" role="tablist">
                                                <li>
                                                    <a href="profile.php"><i
                                                            class="fas fa-tachometer-alt"></i> Dashboard</a>
                                                </li>
                                                <li>
                                                    <a  href="view_order.php"><i
                                                            class="fas fa-shopping-cart"></i> Order</a>
                                                </li>
                                                <li>
                                                    <a href="payment.php"><i
                                                            class="fas fa-credit-card"></i> Payment Method</a>
                                                </li>
                                                <li>
                                                    <a  href="address.php"><i
                                                            class="fas fa-map-marker-alt"></i> Address</a>
                                                </li>
                                                <li>
                                                    <a href="accdetails.php"><i class="fas fa-user"></i>
                                                        Account Details</a>
                                                </li>
                                                <li>
                                                    <a href="password.php" >
                                                        <i class="fas fa-lock"></i> Password Changes</a>
                                                </li>
                                                <li>
                                                    <a class="link--icon-left" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class="col-xl-9 col-md-9">
                                        <div class="tab-content my-account-tab" id="pills-tabContent">
                                            <h4 class="account-title">Orders</h4>
                                                        
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
                                                                                            <a class="dropdown-item" onclick="openModal('.$display_row["receipt_id"].')" target="_blank" style="cursor:pointer">
                                                                                                View Details
                                                                                            </a>
                                                                                            <a class="dropdown-item" href="EditableInvoice/invoice.php?id='.$display_row["receipt_id"].'" target="_blank">
                                                                                                Invoice
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div id="receipt-'.$display_row["receipt_id"].'" class="modal" role="dialog">\
                                                                            <div class="modal-dialog modal-lg">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header" style="background-color:var(--thm-base)">
                                                                                        <h4 class="modal-title"><span style="color:white;">Details</span></h4>
                                                                                        <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                                                                                    </div> 
                                                                                    <!-- Modal Header-->

                                                                                    <div class="modal-body">
                                                                                        <div>
                                                                                            <h4>Receipt Details</h4>
                                                                                            <hr>
                                                                                            <p>Receipt ID: '.$display_row["receipt_id"].'</p>
                                                                                            <p>Payment Method: '.$display_row["payment_method"].'</p>
                                                                                            <p>Payment Cost: '.$display_row["payment_cost"].'</p>
                                                                                            <p>Transaction Date: '.$display_row["receipt_date"].'</p>
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
                                                                                            </div>';
                                                                                            
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
                                                                                        echo '
                                                                                        </div>
                                                                                        <div>
                                                                                            <hr>
                                                                                            <h4>Buyer\'s Details</h4>
                                                                                            <hr>
                                                                                            <p>User ID: '.$display_row["user_id"].'</p>
                                                                                            <p>Name: '.$display_row["receipt_name"].'</p>
                                                                                            <p>Email: '.$display_row["receipt_email"].'</p>
                                                                                            <p>Phone: '.$display_row["receipt_phone"].'</p>
                                                                                            <p>Address: '.$display_row["receipt_address"].'</p>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="modal-footer" style="background-color:var(--thm-base)">
                                                                                        <button type="button" class="btn btn-danger"  onclick="return closeModal('.$display_row["receipt_id"].')">Cancel</button>
                                                                                    </div> 
                                                                                </div>
                                                                            </div>
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
                            <!-- :::::::::: End My Account Section :::::::::: -->
                            <script>
                                //Hide other panel when another collapses
                                function openModal(id) {
                                    $('#receipt-'+id).fadeIn();
                                    return false;
                                }
                                function closeModal(id) {
                                    $('#receipt-'+id).fadeOut();
                                    return false;
                                }
                            </script>
                    </div>
                </div>
            </main> 
    </div>

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->

        <footer class="site-footer background-black-2">
            <img src="assets/images/shapes/footer-bg-1-1.png" alt="" class="site-footer__shape-1">
            <img src="assets/images/shapes/footer-bg-1-2.png" alt="" class="site-footer__shape-2">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-widget footer-widget__about-widget">
                            <a href="index.php" class="footer-widget__logo">
                                <img src="assets/images/tgg.png" alt="" width="150" height="150">
                            </a>
                            <p class="thm-text-dark">We are here to provide you <br>with just the greatest stuff.</p>
                        </div><!-- /.footer-widget -->
                    </div><!-- /.col-sm-12 col-md-6 -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-widget footer-widget__contact-widget">
                            <h3 class="footer-widget__title">Contact</h3><!-- /.footer-widget__title -->
                            <ul class="list-unstyled footer-widget__contact">
                                <li>
                                    <i class="fa fa-phone-square"></i>
                                    <a href="tel:666-888-0000">60123456789</a>
                                </li>
                                <li>
                                    <i class="fa fa-envelope"></i>
                                    <a href="mailto:thegrabgroceries@gmail.com">thegrabgroceries@gmail.com</a>
                                </li>
                                <li>
                                    <i class="fa fa-map-marker-alt"></i>
                                    <a href="https://goo.gl/maps/kLV5kZiqyVc5PKrH9" target="_blank">66 Melaka Street
                                        Malacca Malaysia</a>
                                </li>
                            </ul><!-- /.list-unstyled footer-widget__contact -->
                        </div><!-- /.footer-widget -->
                    </div><!-- /.col-sm-12 col-md-6 col-lg-2 -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-widget footer-widget__links-widget">
                            <h3 class="footer-widget__title">Links</h3><!-- /.footer-widget__title -->
                            <ul class="list-unstyled footer-widget__links">
                                <li>
                                    <a href="index.php">Top Sellers</a>
                                </li>
                                <li>
                                    <a href="products.php">Shopping</a>
                                </li>
                                <li>
                                    <a href="about.php">About</a>
                                </li>
                                <li>
                                    <a href="contact.php">Contact</a>
                                </li>
                                <li>
                                    <a href="contact.php">Help</a>
                                </li>
                            </ul><!-- /.list-unstyled footer-widget__contact -->
                        </div><!-- /.footer-widget -->
                    </div><!-- /.col-sm-12 col-md-6 col-lg-2 -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-2">
                        <div class="footer-widget">
                            <h3 class="footer-widget__title">Explore</h3><!-- /.footer-widget__title -->
                            <ul class="list-unstyled footer-widget__links">
                                <li>
                                    <a href="products.php">New Products</a>
                                </li>
                                <li>
                                    <a href="profile.php">My Account</a>
                                </li>
                                <li>
                                    <a href="contact.php">Support</a>
                                </li>
                                <li>
                                    <a href="contact.php">FAQs</a>
                                </li>
                            </ul><!-- /.list-unstyled footer-widget__contact -->
                        </div><!-- /.footer-widget -->
                    </div><!-- /.col-sm-12 col-md-6 col-lg-2 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
            <div class="bottom-footer">
                <div class="container">
                    <hr>
                    <div class="inner-container text-center">
                        <div class="bottom-footer__social">
                            <a href="https://twitter.com/" class="fab fa-twitter" target="_blank"></a>
                            <a href="https://facebook.com/" class="fab fa-facebook-square" target="_blank"></a>
                            <a href="https://instagram.com/" class="fab fa-instagram" target="_blank"></a>
                        </div><!-- /.bottom-footer__social -->
                        <p class="thm-text-dark">© Copyright <span class="dynamic-year"></span> by TGG</p>
                    </div><!-- /.inner-container -->
                </div><!-- /.container -->
            </div><!-- /.bottom-footer -->
        </footer><!-- /.site-footer -->
    </div>
    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- template js -->
    <script src="assets/js/organik.js"></script>
</body>

</html>
