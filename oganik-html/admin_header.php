<?php
session_start();

date_default_timezone_set("Asia/Kuala_Lumpur");

require "config.php";

if (!isset($_SESSION["loggedin"]) || !isset($_SESSION["mode"]) || ($_SESSION["mode"] !== "admin" && $_SESSION["mode"] !== "superadmin")) {
    echo "
    <script>
      alert('You are not authorized to this page');
      location.href='index.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin || TheGrabGroceries</title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicons/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicons/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicons/favicon-16x16.png" />
    <link rel="manifest" href="assets/images/favicons/site.webmanifest" />
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

    <!-- template styles -->
    <link rel="stylesheet" type="text/css" href="assets/css/organik.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/admin.css" />

    <style>
        body {
            font: 14px sans-serif;
            background-image: url("https://cdn.wallpapersafari.com/68/37/Gwgjo6.jpg")
        }
    </style>
</head>

<body>
    <div class="preloader">
        <img class="preloader__image" width="55" src="assets/images/loaderr.png" alt="" />
    </div>
    <!-- /.preloader -->
    <div class="page-wrapper">
        <header class="main-header" id="main-header">

            <nav class="main-menu">

                <div class="row" style="padding: 50px 0 50px 0;">
                    <div class="main-menu__login" style="margin-left: 5%;">
                        <a href="<?php if (isset($_SESSION["lname"])) {
                                        echo "admin_profile.php";
                                    } else {
                                        echo "login.php";
                                    } ?>">
                            <i class="organik-icon-user"></i>
                            <?php

                            if (isset($_SESSION["lname"])) {
                                echo $_SESSION['lname'] . " (" . $_SESSION['mode'] . ")";
                            } else {
                                echo "Login / Register";
                            }

                            ?>
                        </a>
                    </div><!-- /.main-menu__login -->
                    <a href="index.php" class="admin-logo">
                        <img src="assets/images/logo-trans.png" width="105" alt="">
                    </a> <!-- Logo -->

                </div>
                <!--
                    <ul class="main-menu__list">
                        <li>
                            <a href="admin_profile.php">Profile</a>
                        </li>
                        <li>
                            <a href="admin_additem.php">Add item</a>
                        </li>
                        <li class="dropdown">
                            <a href="admin_displayitem.php">Update product</a>
                            <ul>
                                <li><a href="admin_displayitem.php">Update product</a></li>
                                <li><a href="admin_archiveitem.php">Archive product</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="admin_view_transaction.php">Transactions</a>
                        </li>
                        <?php

                        if ($_SESSION["mode"] == "superadmin") {
                            echo "<li><a href='admin_manage.php'>Manage Admins</a></li>";
                        }

                        ?>
                    </ul>
                    -->
            </nav>
        </header>

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->

        <div class="sidenav" id="sidenav">
            <div id="admin-overlay" class="admin-overlay">
                <div id="accordion">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <a href="admin_profile.php">
                                    Profile
                                </a>
                            </h5>
                        </div>
                    </div>

                    <div class="card">

                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" data-target="#sidebarCollapse" aria-expanded="false" aria-controls="collapseThree" style="display: flex; justify-content: space-between;">
                                    Products <i class="fas fa-plus" style="margin: 0"></i>
                                </a>
                            </h5>
                        </div>
                        <div id="sidebarCollapse" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <a href="admin_additem.php">
                                    Add Products
                                </a>
                                <hr>
                                <a href="admin_displayitem.php">
                                    Show Products
                                </a>
                                <hr>
                                <a href="admin_category.php">
                                    Categories
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <a href="admin_view_transaction.php">
                                    Transactions
                                </a>
                            </h5>
                        </div>
                    </div>
                    <?php

                    if ($_SESSION["mode"] == "superadmin") {
                        echo '
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <a href="admin_manage.php">
                                            Admins
                                        </a>
                                    </h5>
                                </div>
                            </div>';
                    }

                    ?>
                </div>
                <div class="card" style="background-color:black">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <a href="logout.php">
                                Logout
                            </a>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var headerHeight = document.getElementById("main-header").offsetHeight;
            document.getElementById("sidenav").style.paddingTop = headerHeight + "px";

            window.onresize = () => {
                headerHeight = document.getElementById("main-header").offsetHeight;
                document.getElementById("sidenav").style.paddingTop = headerHeight + "px";
            }
        </script>