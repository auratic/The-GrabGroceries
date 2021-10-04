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

$fname = $lname = $default_address = $default_phone = "";
$name = array();
$address = array();
$phone = array();
$email = array();


if (isset($_POST["details"])) {
    if ($_POST["no"] == 0) {
        $sql = "
            UPDATE users
            SET 
            address = '" . ucwords($_POST['address']) . "', 
            phone= '" . $_POST["phone"] . "'
            WHERE user_id = " . $_SESSION["userid"];
    } else {
        $sql = "
                UPDATE cust_address
                SET 
                address" . $_POST["no"] . " = '" . ucwords($_POST['address']) . "', 
                phone" . $_POST["no"] . "= '" . $_POST["phone"] . "', 
                name" . $_POST["no"] . " = '" . $_POST["name"] . "',
                email" . $_POST["no"] . " = '" . $_POST["email"] . "'
                WHERE user_id = " . $_SESSION["userid"];
    }

    if (mysqli_query($link, $sql)) {
        echo "
            <script>
                alert('Details updated.');
            </script>";
    } else {
        echo "
            <script>
                alert('Something went wrong, please try again');
            </script>";
    }
}




$sql = "SELECT * FROM cust_address where user_id = " . $_SESSION["userid"];
if ($result = mysqli_query($link, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($name,    $row['name1'], $row['name2'], $row['name3'], $row['name4'], $row['name5']);
        array_push($address, $row['address1'], $row['address2'], $row['address3'], $row['address4'], $row['address5']);
        array_push($phone,   $row['phone1'], $row['phone2'], $row['phone3'], $row['phone4'], $row['phone5']);
        array_push($email,   $row['email1'], $row['email2'], $row['email3'], $row['email4'], $row['email5']);
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
            background-color: white;
            margin-top: 70px;
            margin-left: 50px;
            margin-bottom: 80px;
            border-radius: 5px;
            border-style: double;
            width: 1430px;
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

        .modal-header {
            border-radius: 25px 25px 0 0;
        }

        .modal-footer {
            border-radius: 0 0 25px 25px;
        }

        #edit-address,
        #edit-address1,
        #edit-address2,
        #edit-address3,
        #edit-address4,
        #edit-address5 {
            cursor: pointer;
        }

        .div1 {
            border: 2px solid var(--thm-base);
        }
        .fas
        {
            margin-left: 0;
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

                                <!-- :::::::::: Page Content :::::::::: -->

                                <div class="col-xl-10 col-md-10">
                                    <div class="tab-content my-account-tab" id="pills-tabContent">
                                        <div class="#" id="pills-address" aria-labelledby="pills-address-tab">
                                            <div class="my-account-address account-wrapper">
                                                <h4 class="account-title">Address</h4>
                                                <div class="account-address m-t-30 div1">
                                                    <?php
                                                    $sql = "SELECT * FROM users WHERE user_id = '" . $_SESSION['userid'] . "'";
                                                    $result = mysqli_query($link, $sql);

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $fname = $row['firstname'];
                                                        $lname = $row['lastname'];
                                                        $default_address = $row['address'];
                                                        $default_phone = $row['phone'];
                                                        $default_email = $row['email'];
                                                    }

                                                    echo '
                                                                <div class="row">
                                                                    <div class="col-4" style="margin-bottom: 5%; margin-top: 1%;">
                                                                        <p>Full name: <strong>  ' . $fname . ' ' . $lname . '</strong></p>
                                                                        <p>Email    : ' . $default_email . '</span></p>
                                                                        <p>Address  : <span style="font-style:italic;">' . $default_address . '</span> </p>
                                                                        <p>Contact  : <span style="font-style:italic;">' . $default_phone . '</span></p>
                                                                        <a class="box-btn m-t-25 " id="edit-address" onclick="return edit(0)"><i class="far fa-edit"></i>Edit</a> <span style="background-color: var(--thm-base); color: white; border-radius: 5px; padding: 4px;">Default</span>
                                                                    </div>';
                                                    $counterr = 0;
                                                    for ($x = 0; $x < 5; $x++) {
                                                        $counterr++;
                                                        echo '
                                                                            <div class="col-4" style="margin-bottom: 5%; margin-top: 1%;">
                                                                                <p>Full name: <strong>  ' . $name[$x] . '</strong></p>
                                                                                <p>Email    : ' . $email[$x] . '</span></p>
                                                                                <p>Address  : <span style="font-style:italic;">' . $address[$x] . '</span></p>
                                                                                <p>Contact  : <span style="font-style:italic;">' . $phone[$x] . '</span></p>
                                                                                <a class="box-btn m-t-25 " id="edit-address' . $counterr . '" onclick="return edit(' . $counterr . ')" ><i class="far fa-edit"></i>Edit</a>
                                                                            </div>';
                                                    }

                                                    echo "</div>";
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div><!-- :::::::::: End My Account Section :::::::::: -->
                    </div>
                </div>
            </div>
        </main>

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

        <?php
        echo '
                <div class="modal" id="address-modal0" role="dialog">
                    <div class="modal-dialog modal-lg">
                        
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:var(--thm-base)">
                                <h4 class="modal-title"><span style="color:white;">Edit Details</span></h4>
                                <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                            </div> 
                            <!-- Modal Header-->

                            <div class="modal-body">
                            
                                <form> 
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="" name="name0" id="name0" required class="form-control ' . ((!empty($code_err)) ? "is-invalid" : '') . '" value="' . $fname . ' ' . $lname . '" disabled>
                                                <span class="con-pass-err" style="color:crimson"></span>
                                            </div>
                                        </div>
                                    </div> 
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="" name="email0" id="email0" required class="form-control ' . ((!empty($code_err)) ? "is-invalid" : '') . '" value="' . $default_email . '" disabled>
                                                <span class="con-pass-err" style="color:crimson"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="" name="address0" id="address0" required class="form-control ' . ((!empty($address_err)) ? "is-invalid" : '') . '" value="' . $default_address . '">
                                                <span class="invalid-feedback d-block" id="address_err0"><?php echo $address_err; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                            
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="" name="phone0" id="phone0" required class="form-control ' . ((!empty($phone_err)) ? "is-invalid" : '') . '" value="' . $default_phone . '">
                                                <span class="invalid-feedback d-block" id="phone_err0"><?php echo $phone_err; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="Save change" onclick="return updateAddress(0);">
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <!-- Modal Body-->

                            <div class="modal-footer" style="background-color:var(--thm-base)">
                                <button type="button" class="btn btn-default" style="background-color: azure;" onclick="return closeModal(0)">Close</button>
                            </div> 
                            <!-- Modal Footer-->
                        </div>
                    </div>
                        
                </div>
            ';
        $counter = 0;
        for ($x = 0; $x < 5; $x++) {
            $counter++;

            echo '
                <div class="modal" id="address-modal' . $counter . '" role="dialog">
                    <div class="modal-dialog modal-lg">
                        
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:var(--thm-base)">
                                <h4 class="modal-title"><span style="color:white;">Edit Details</span></h4>
                                <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                            </div> 
                            <!-- Modal Header-->

                            <div class="modal-body">
                            
                                <form> 
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="" name="name' . $counter . '" id="name' . $counter . '" class="form-control ' . ((!empty($name_err)) ? "is-invalid" : '') . '" value="' . $name[$x] . '" placeholder="John Doe" required />
                                                <span class="invalid-feedback d-block" id="name_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="email' . $counter . '" id="email' . $counter . '" class="form-control ' . ((!empty($email_err)) ? "is-invalid" : '') . '" value="' . $email[$x] . '" placeholder="JohnDoe@gmail.com" required />
                                                <span class="invalid-feedback d-block" id="email_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="" name="address' . $counter . '" id="address' . $counter . '" class="form-control ' . ((!empty($address_err)) ? "is-invalid" : '') . '" value="' . $address[$x] . '" placeholder="No 1 Tmn Asin 70000" required />
                                                <span class="invalid-feedback d-block" id="address_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div>
                                            
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="" name="phone' . $counter . '" id="phone' . $counter . '" class="form-control ' . ((!empty($phone_err)) ? "is-invalid" : '') . '" value="' . $phone[$x] . '" placeholder="60122228888" maxlength=12 required />
                                                <span class="invalid-feedback d-block" id="phone_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="Save change" onclick="return updateAddress(' . $counter . ');">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Modal Body-->

                            <div class="modal-footer" style="background-color:var(--thm-base)">
                                <button type="button" class="btn btn-default" style="background-color: azure;" onclick="return closeModal(' . $counter . ')">Close</button>
                            </div> 
                            <!-- Modal Footer-->
                        </div>
                    </div>
                </div>';
        }
        ?>

    </div>
    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>



    <!-- template js -->
    <script src="assets/js/organik.js"></script>

    <script>
        function updateAddress(counter) {
            var address = document.getElementById("address" + counter).value;
            var phone = document.getElementById("phone" + counter).value;
            var name = document.getElementById("name" + counter).value;
            var email = document.getElementById("email" + counter).value;
            document.getElementById("address_err" + counter).innerHTML = "";
            document.getElementById("phone_err" + counter).innerHTML = "";
            document.getElementById("name_err" + counter).innerHTML = "";
            document.getElementById("email_err" + counter).innerHTML = "";

            var pass = true;

            if (address == "") {
                document.getElementById("address_err" + counter).innerHTML = "Address is required";
                pass = false;
            }

            if (phone == "") {
                document.getElementById("phone_err" + counter).innerHTML = "Phone Number is required";
                pass = false;
            } else if (isNaN(phone)) {
                document.getElementById("phone_err" + counter).innerHTML = "Please enter valid number";
                pass = false;
            }

            if (name == "") {
                document.getElementById("name_err" + counter).innerHTML = "Name is required";
                pass = false;
            } else if (!/^(([A-Za-z]+[\-\']?)*([A-Za-z]+)?\s)+([A-Za-z]+[\-\']?)*([A-Za-z]+)?$/.test(name)) {
                document.getElementById("name_err" + counter).innerHTML = "Please enter valid name";
                pass = false;
            }

            if (email == "") {
                document.getElementById("email_err" + counter).innerHTML = "Email is required";
                pass = false;
            } else if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                document.getElementById("email_err" + counter).innerHTML = "Please enter valid email";
                pass = false;
            }

            if (pass) {
                $.ajax({
                    type: "post",
                    url: "address.php",
                    data: {
                        'details': true,
                        'no': counter,
                        'name': name,
                        'address': address,
                        'phone': phone,
                        'email': email
                    },
                    cache: false,
                    success: function(html) {
                        alert('Details updated');
                        location.reload();
                    }
                });
            }
            return false;
        }

        function edit(counter) {
            $('#address-modal' + counter).fadeIn();
            return false;
        }

        function closeModal(counter) {

            $('#address-modal' + counter).fadeOut();
            return false;
        }
    </script>



</body>