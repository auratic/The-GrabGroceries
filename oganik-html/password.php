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

    if (count($_POST) > 0)
    {
        $result = mysqli_query($link, "SELECT * from users WHERE user_id=" . $_SESSION["userid"]);
        $row = mysqli_fetch_array($result);

        if (strlen(trim($_POST["newPassword"])) < 6) 
        {
            $message = "<span style='color: red;'>Password must have atleast 6 characters.</span>";
        }
        else if ($_POST["currentPassword"] == $row["password"]) 
        {
            mysqli_query($link, "UPDATE users set password='" . $_POST["newPassword"] . "' WHERE user_id=" . $_SESSION["userid"]);
            $message = "Password Changed";
        } else
            $message = "<span style='color: red;'>Current Password is not correct</span>";
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
            background-color:white;
            margin-top: 70px;
            margin-left: 50px;
            margin-bottom: 80px;
            border-radius: 5px;
            border-style: double;
            width: 1430px;
        }

        .btnSubmit
        {
            color:white;
            background-color:#4CAF50;
            border-radius: 5px;
            text-align:center;
            font-size: 16px;
            text-decoration: none;
            padding: 5px 15px;
            margin-top: 10px;
            outline: none; 
            border: none;
        }
    </style>

    <script>
        function validatePassword() 
        {
            var currentPassword,newPassword,confirmPassword,output = true;

            currentPassword = document.frmChange.currentPassword;
            newPassword = document.frmChange.newPassword;
            confirmPassword = document.frmChange.confirmPassword;

            if(!currentPassword.value) {
                currentPassword.focus();
                document.getElementById("currentPassword").innerHTML = "Required";
                output = false;
            }
            else if(!newPassword.value) {
                newPassword.focus();
                document.getElementById("newPassword").innerHTML = "Required";
                output = false;
            }
            else if(!confirmPassword.value) {
                confirmPassword.focus();
                document.getElementById("confirmPassword").innerHTML = "Required";
                output = false;
            }

            if(newPassword.value != confirmPassword.value) 
            {
                newPassword.value="";
                confirmPassword.value="";
                newPassword.focus();
                document.getElementById("confirmPassword").innerHTML = "Did not match";
                output = false;
            } 	
            
            return output;
        }
    </script>
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
            
            <!-- :::::::::: Profile :::::::::: -->
            <main id="main-container" class="main-container">
                <div class="containerr">
                    <div class="row">
                        <div class="col-12">
                            <!-- :::::::::: Start My Account Section :::::::::: -->
                            <div class="my-account-area">
                                <div class="row">
                                    <div class="col-xl-3 col-md-4" style="border-right: 1px solid black">
                                        <div class="my-account-menu">
                                            <ul class="nav account-menu-list flex-column nav-pills" id="pills-tab" role="tablist">
                                                <li>
                                                    <a href="profile.php"><i
                                                            class="fas fa-tachometer-alt"></i> Dashboard</a>
                                                </li>
                                                <li>
                                                    <a href="view_order.php"><i
                                                            class="fas fa-shopping-cart"></i> Order</a>
                                                </li>
                                                <li>
                                                    <a href="download.php"><i
                                                            class="fas fa-cloud-download-alt"></i> Download</a>
                                                </li>
                                                <li>
                                                    <a href="payment.php"><i
                                                            class="fas fa-credit-card"></i> Payment Method</a>
                                                </li>
                                                <li>
                                                    <a href="address.php"><i
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
                                    <div class="col-xl-8 col-md-8">

                                        <div class="tab-content my-account-tab" id="pills-tabContent">
                                            <div class="#" id="pills-account" aria-labelledby="pills-account-tab">
                                                <div class="my-account-details account-wrapper">
                                                    <h4 class="account-title">Password Changes</h4>

                                                    <form name="frmChange" method="post" action="" onSubmit="return validatePassword()">
                                                        <div style="width: 500px;">
                                                            <div class="message"><?php if(isset($message)) { echo $message; } ?></div>
                                                                <table class="tblSaveForm">
                                                                    <tr>
                                                                        <td width="40%"><label>Current Password</label></td>
                                                                        <td width="60%"><input type="password"
                                                                            name="currentPassword" class="txtField" /><span
                                                                            id="currentPassword" class="required"></span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>New Password</label></td>
                                                                        <td><input type="password" name="newPassword"
                                                                            class="txtField" /><span id="newPassword"
                                                                            class="required"></span></td>
                                                                    </tr>
                                                                    <td><label>Confirm Password</label></td>
                                                                    <td><input type="password" name="confirmPassword"
                                                                        class="txtField" /><span id="confirmPassword"
                                                                        class="required"></span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2"><input type="submit" name="submit"
                                                                            value="Submit" class="btnSubmit"></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </form>
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
        </header>

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

    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>


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
    <!-- template js -->
    <script src="assets/js/organik.js"></script>
</body>

</html>
