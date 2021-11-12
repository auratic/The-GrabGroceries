<?php

session_start();

date_default_timezone_set("Asia/Kuala_Lumpur");

require "config.php";

if(!isset($_SESSION['lang']))
{
    $_SESSION['lang'] = 'en';
}
else if(isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang']))
{
    if($_GET['lang'] == 'en')
    $_SESSION['lang'] = 'en';
    else if($_GET['lang'] == 'cn')
    $_SESSION['lang'] = 'cn';
    else if($_GET['lang'] == 'ms')
    $_SESSION['lang'] = 'ms';
}

include  $_SESSION['lang']. ".php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $lang['title']?></title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicons/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicons/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicons/favicon-16x16.png" />
    <link rel="manifest" href="assets/images/favicons/site.webmanifest" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <meta name="description" content="Agrikon HTML Template For Agriculture Farm & Farmers" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Homemade+Apple&family=Abril+Fatface&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />

    <!-- Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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

    <!--icon-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/style.css" />

    <!-- re-captcha -->
    <script src="https://www.google.com/recaptcha/api.js"></script>

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

    <!-- template styles -->
    <link rel="stylesheet" href="assets/css/organik.css" />

    <!-- Datatable CDN -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap5.min.css" />

    <!-- PDFMake -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <style>
        .mode {
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            margin-left: 20px;
        }

        .dark-mode {
            background-color: black;
            color: white;
        }
        
        .signup-form {
            width: 360px;
            padding: 20px;
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

        /*
        .modal-header {
            border-radius: 25px 25px 0 0;
        }

        .modal-footer {
            border-radius: 0 0 25px 25px;
        }
        */
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
                        <a href="
                            <?php  
                                if (isset($_SESSION["mode"]) && ($_SESSION["mode"] == "admin" || $_SESSION["mode"] == "superadmin")) {
                                    echo "admin_dashboard.php";
                                } else {
                                    echo "index.php";
                                } ?>" 
                            class="logo">
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
                            <a href="https://www.facebook.com/Thegrabgroceries-100840225730842/" class="fab fa-facebook-square" target="_blank"></a>
                        </div><!-- /.topbar__social -->
                        <div class="topbar__info">
                            <i class="organik-icon-email"></i>
                            <p><?php echo $lang['email']?> <a href="mailto:thegrabgroceries@gmail.com">thegrabgroceries@gmail.com</a></p>
                        </div><!-- /.topbar__info -->
                    </div><!-- /.topbar__left -->
                    <div class="topbar__right">
                        <div class="topbar__info">
                            <i class="organik-icon-calling"></i>
                            <p><?php echo $lang['phone']?> <a href="tel:+60186620551">+60123608370</a></p>
                        </div><!-- /.topbar__info -->
                        <div class="topbar__buttons">
                            <a href="#" class="search-toggler"><i class="organik-icon-magnifying-glass"></i></a>
                            <a href="cart.php" ><i class="organik-icon-shopping-cart"></i></a>
                            <a href="cust_view_order.php"><i class="fas fa-truck" style="margin:0; height:0;"></i></a>
                        </div><!-- /.topbar__buttons -->
                    </div><!-- /.topbar__left -->

                </div><!-- /.container -->
            </div><!-- /.topbar -->
            <nav class="main-menu">
                <div class="container">
                    <div class="main-menu__login">
                        <a href="<?php  
                                    if (isset($_SESSION["mode"]) && ($_SESSION["mode"] == "admin" || $_SESSION["mode"] == "superadmin")) {
                                        echo "admin_dashboard.php";
                                    } elseif (isset($_SESSION["lname"])) {
                                        echo "cust_profile.php";
                                    } else {
                                        echo "login.php";
                                    } ?>">
                            <i class="organik-icon-user"></i>
                            <?php

                            if (isset($_SESSION["lname"])) {
                                echo $_SESSION['lname'];
                            } else {
                                echo $lang['login/re'];
                            }

                            ?>
                        </a>
                    </div><!-- /.main-menu__login -->
                    <ul class="main-menu__list">
                        <li class="dropdown">
                            <a href="index.php"><?php echo $lang['home']?></a>
                        </li>
                        <li class="dropdown">
                            <a href="products.php"><?php echo $lang['shop']?></a>
                            <?php 
                                if(isset($_SESSION["loggedin"]))
                                    echo "
                                    <ul>
                                        <li><a href='cart.php'>".$lang['cart']."</a></li>
                                        <li><a href='checkout.php'>".$lang['checkout']."</a></li>
                                    </ul>";
                            ?>
                        </li>

                        <li>
                            <a href='review.php'><?php echo $lang['review']?></a>
                        </li>

                        <li class="dropdown">
                            <a href="#"><?php echo $lang['more']?></a>
                            <ul>
                                <li><a href="cust_contact.php"><?php echo $lang['contact']?></a></li>
                                <li><a href="about.php"><?php echo $lang['about']?></a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="main-menu__language">
                        <label class="sr-only" for="language-select">select language</label>
                        <!-- /#language-select.sr-only -->
                        <form action="" method="GET">
                            <select class="selectpicker" name="lang" id="language-select-header">
                                <option value="en"><?php echo $lang['chglg']?></option>
                                <option value="en"<?php if(isset($_GET['lang']) && $_GET['lang'] == 'en'){echo "selected";}?>><?php echo $lang['eng']?></option>
                                <option value="ms"<?php if(isset($_GET['lang']) && $_GET['lang'] == 'ms'){echo "selected";}?>><?php echo $lang['ms']?></option>
                                <option value="cn"<?php if(isset($_GET['lang']) && $_GET['lang'] == 'cn'){echo "selected";}?>><?php echo $lang['man']?></option>
                            </select>
                            <button type="submit" class="btn btn-success" style="margin-left: 5px;"><?php echo $lang['save']?></button>
                        </form>
                    </div><!-- /.main-menu__language -->
                </div><!-- /.container -->
            </nav>
            <!-- /.main-menu -->
        </header><!-- /.main-header -->

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->