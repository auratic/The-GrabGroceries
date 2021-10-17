<?php
session_start();

if (!isset($_SESSION["loggedin"])) {
    echo "
     <script>
       alert('Please login');
       location.href='login.php';
     </script>";
}

require "config.php";


$sql_receipt = "SELECT receipt_id FROM cust_receipt 
                  WHERE user_id = " . $_SESSION['userid'];
$receipt_array = array();

if ($receipt_result = mysqli_query($link, $sql_receipt)) {
    while ($receipt_row = mysqli_fetch_assoc($receipt_result)) {
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

        .signup-form {
            width: 360px;
            padding: 20px;
        }

        .containerr {
            color: black;
            background-color: white;
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
            background-color: azure
                /*var(--thm-base)*/
            ;
            padding: 2%;
            margin: 1%
        }

        .modal {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal>div {
            padding: 10px;
        }

        .modal-content {
            border-radius: 25px;
        }

        .modal-body {
            overflow-y: scroll;
            max-height: calc(100vh - 210px);
        }

        .modal-header {
            border-radius: 25px 25px 0 0;
        }

        .modal-footer {
            border-radius: 0 0 25px 25px;
        }

        .fas {
            margin-left: 0;
        }

        tr{
            font-size: 16px;
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
                        <a href="<?php if (isset($_SESSION["lname"])) {
                                        echo "profile.php";
                                    } else {
                                        echo "login.php";
                                    } ?>">
                            <i class="organik-icon-user"></i>
                            <?php

                            if (isset($_SESSION["lname"])) {
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
                                <li><a href="cart.php">Cart Page</a></li>
                                <li><a href="checkout.php">Checkout</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="news.php">News</a>
                        </li>
                        <li>
                            <a href="review.php">Review</a>
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
            <div class="container" style="background-color: rgba(255,255,255,0.9); margin: 20px auto;">
                <div class="row">
                    <div class="col-12">
                        <!-- :::::::::: Start My Account Section :::::::::: -->
                        <div class="my-account-area">
                            <div class="row">
                                <div class="col-xl-2 col-md-2" style="border-right: 1px solid black">
                                    <div class="my-account-menu">
                                        <ul class="nav account-menu-list flex-column nav-pills" id="pills-tab" role="tablist">
                                            <li>
                                                <a href="profile.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                                            </li>
                                            <li>
                                                <a href="view_order.php"><i class="fas fa-shopping-cart"></i> Order</a>
                                            </li>
                                            <li>
                                                <a href="payment.php"><i class="fas fa-credit-card"></i> Payment Method</a>
                                            </li>
                                            <li>
                                                <a href="address.php"><i class="fas fa-map-marker-alt"></i> Address</a>
                                            </li>
                                            <li>
                                                <a href="accdetails.php"><i class="fas fa-user"></i>
                                                    Account Details</a>
                                            </li>
                                            <li>
                                                <a href="password.php">
                                                    <i class="fas fa-lock"></i> Password Changes</a>
                                            </li>
                                            <li>
                                                <a class="link--icon-left" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="col-xl-10 col-md-10">
                                    <div class="tab-content my-account-tab" id="pills-tabContent">
                                        <h4 class="account-title">Orders</h4>

                                        <div class="panel-group" id="accordion">
                                            <div class="panel panel-default text-center">
                                                <?php
                                                    if (count($receipt_array) == 0) 
                                                    {
                                                        echo "<h1 style='text-align: center'>You have no orders yet!</h1>";
                                                    } 
                                                    else 
                                                    {
                                                        echo'
                                                        <table class="table table-striped table-bordered table-hover" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th><h5>Receipt ID</h5></th>
                                                                    <th><h5>Receipt Name</h5></th>
                                                                    <th><h5>Transaction Date</h5></th>
                                                                    <th><h5>Total (RM)</h5></th>
                                                                    <th><h5>Status</h5></th>
                                                                    <th><h5>Action</h5></th>
                                                                </tr>
                                                            </thead>';
                                                            foreach($receipt_array as $x => $x_value) 
                                                            {
                                                                $sql = "SELECT * FROM cust_receipt INNER JOIN users ON cust_receipt.user_id = users.user_id WHERE cust_receipt.receipt_id = $x_value";
                                                                $result=mysqli_query($link, $sql);
                                                                while($row=mysqli_fetch_assoc($result))
                                                                {
                                                                    $rID = $row['receipt_id'];
                                                                    $rName = $row['receipt_lname'];
                                                                    $Fname = $row['receipt_fname'];
                                                                    $tDate = $row['receipt_date'];
                                                                    $rEmail = $row['receipt_email'];
                                                                    $rPhone = $row['receipt_phone'];
                                                                    $rAdds = $row['receipt_address'];
                                                                    $total = $row['payment_cost'];
                                                                    $status = $row['product_status'];
                                                                    $method = $row['payment_method'];
                                                                    $uid = $row['user_id'];
                                                                }
                                                    
                                                                    echo'
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>'.$rID.'</td>
                                                                                <td>'.$Fname.' '.$rName.'</td>
                                                                                <td>'.$tDate.'</td>
                                                                                <td>'.number_format($total,2).'</td>
                                                                                <td>'.$status.'</td>
                                                                                <td>
                                                                                    <a class="btn btn-default dropdown-toggle" href="#" style="margin-top:-10px;" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                        More option
                                                                                    </a>
                                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                        <a class="dropdown-item" onclick="openModal('.$rID.')" target="_blank" style="cursor:pointer">
                                                                                            View Details
                                                                                        </a>
                                                                                        <a class="dropdown-item" href="EditableInvoice/invoice.php?id='.$rID.'" target="_blank">
                                                                                            Invoice
                                                                                        </a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    ';
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
                                                                                            <p>Name: '.$Fname.' ' . $rName . '</p>
                                                                                            <p>Email: ' . $rEmail . '</p>
                                                                                            <p>Phone: ' . $rPhone . '</p>
                                                                                            <p>Address: ' . $rAdds . '</p>
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
                                                                                            </div>
                                                                                            ';

                                                                                            $trans_sql = "SELECT * FROM cust_transaction
                                                                                                        INNER JOIN item ON cust_transaction.item_id = item.item_id
                                                                                                        WHERE cust_transaction.receipt_id = $x_value;";

                                                                                            if ($trans_result = mysqli_query($link, $trans_sql)) 
                                                                                            {
                                                                                                while ($trans_row = mysqli_fetch_assoc($trans_result)) 
                                                                                                {
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
                                                        echo'
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
                        </script>
                    </div>
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
    <div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <!-- /.mobile-nav__overlay -->
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"><i class="organik-icon-close"></i></span>

            <div class="logo-box">
                <a href="index.php" aria-label="logo image"><img src="assets/images/logo-light.png" width="155" alt="" /></a>
            </div>
            <!-- /.logo-box -->
            <div class="mobile-nav__container"></div>
            <!-- /.mobile-nav__container -->

            <ul class="mobile-nav__contact list-unstyled">
                <li>
                    <i class="organik-icon-email"></i>
                    <a href="mailto:needhelp@organik.com">needhelp@organik.com</a>
                </li>
                <li>
                    <i class="organik-icon-calling"></i>
                    <a href="tel:666-888-0000">666 888 0000</a>
                </li>
            </ul><!-- /.mobile-nav__contact -->
            <div class="mobile-nav__top">
                <div class="mobile-nav__language">
                    <img src="assets/images/resources/flag-1-1.jpg" alt="">
                    <label class="sr-only" for="language-select">select language</label>
                    <!-- /#language-select.sr-only -->
                    <select class="selectpicker" id="language-select">
                        <option value="english">English</option>
                        <option value="arabic">Arabic</option>
                    </select>
                </div><!-- /.mobile-nav__language -->
                <div class="main-menu__login">
                    <a href="<?php if (isset($_SESSION["lname"])) {
                                    echo "profile.php";
                                } else {
                                    echo "login.php";
                                } ?>">
                        <i class="organik-icon-user"></i>
                        <?php

                        if (isset($_SESSION["lname"])) {
                            echo $_SESSION['lname'];
                        } else {
                            echo "Login / Register";
                        }

                        ?>
                    </a>
                </div><!-- /.main-menu__login -->
            </div><!-- /.mobile-nav__top -->



        </div>
        <!-- /.mobile-nav__content -->
    </div>
    <!-- /.mobile-nav__wrapper -->

    <div class="mini-cart">
        <div class="mini-cart__overlay mini-cart__toggler"></div>
        <div class="mini-cart__content">
            <div class="mini-cart__top">
                <h3 class="mini-cart__title">Shopping Cart</h3>
                <span class="mini-cart__close mini-cart__toggler"><i class="organik-icon-close"></i></span>
            </div><!-- /.mini-cart__top -->
            <div class="mini-cart__item">
                <img src="assets/images/products/cart-1-1.jpg" alt="">
                <div class="mini-cart__item-content">
                    <div class="mini-cart__item-top">
                        <h3><a href="product-details.php">Banana</a></h3>
                        <p>$9.99</p>
                    </div><!-- /.mini-cart__item-top -->
                    <div class="quantity-box">
                        <button type="button" class="sub">-</button>
                        <input type="number" id="2" value="1" />
                        <button type="button" class="add">+</button>
                    </div>
                </div><!-- /.mini-cart__item-content -->
            </div><!-- /.mini-cart__item -->
            <div class="mini-cart__item">
                <img src="assets/images/products/cart-1-2.jpg" alt="">
                <div class="mini-cart__item-content">
                    <div class="mini-cart__item-top">
                        <h3><a href="product-details.php">Tomato</a></h3>
                        <p>$9.99</p>
                    </div><!-- /.mini-cart__item-top -->
                    <div class="quantity-box">
                        <button type="button" class="sub">-</button>
                        <input type="number" id="2" value="1" />
                        <button type="button" class="add">+</button>
                    </div>
                </div><!-- /.mini-cart__item-content -->
            </div><!-- /.mini-cart__item -->
            <div class="mini-cart__item">
                <img src="assets/images/products/cart-1-3.jpg" alt="">
                <div class="mini-cart__item-content">
                    <div class="mini-cart__item-top">
                        <h3><a href="product-details.php">Bread</a></h3>
                        <p>$9.99</p>
                    </div><!-- /.mini-cart__item-top -->
                    <div class="quantity-box">
                        <button type="button" class="sub">-</button>
                        <input type="number" id="2" value="1" />
                        <button type="button" class="add">+</button>
                    </div>
                </div><!-- /.mini-cart__item-content -->
            </div><!-- /.mini-cart__item -->
            <a href="checkout.php" class="thm-btn mini-cart__checkout">Proceed To Checkout</a>
        </div><!-- /.mini-cart__content -->
    </div><!-- /.cart-toggler -->

    <div class="search-popup">
        <div class="search-popup__overlay search-toggler"></div>
        <!-- /.search-popup__overlay -->
        <div class="search-popup__content">
            <form action="products.php" method="GET">
                <label for="search" class="sr-only">search here</label><!-- /.sr-only -->
                <input type="text" id="search" name="search" placeholder="Search Here..." />
                <button type="submit" aria-label="search submit" class="thm-btn">
                    <i class="organik-icon-magnifying-glass"></i>
                </button>
            </form>
        </div>
        <!-- /.search-popup__content -->
    </div>
    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- template js -->
    <script src="assets/js/organik.js"></script>
</body>

</html>
