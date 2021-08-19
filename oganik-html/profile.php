<?php
  session_start()
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
            margin-top:150px;
            margin-left: 50px;
            border-radius: 5px;
            border-style: double;
        }
    </style>
</head>

<body>
    <div class="preloader">
        <img class="preloader__image" width="55" src="assets/images/loader.png" alt="" />
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
                                <div class="col-xl-3 col-md-4">
                                    <div class="my-account-menu">
                                        <ul class="nav account-menu-list flex-column nav-pills" id="pills-tab" role="tablist">
                                            <li>
                                                <a class="active link--icon-left" id="pills-dashboard-tab" data-toggle="pill" href="#pills-dashboard"
                                                    role="tab" aria-controls="pills-dashboard" aria-selected="true"><i
                                                        class="fas fa-tachometer-alt"></i> Dashboard</a>
                                            </li>
                                            <li>
                                                <a id="pills-order-tab" class="link--icon-left" data-toggle="pill" href="#pills-order" role="tab"
                                                    aria-controls="pills-order" aria-selected="false"><i
                                                        class="fas fa-shopping-cart"></i> Order</a>
                                            </li>
                                            <li>
                                                <a id="pills-download-tab" class="link--icon-left" data-toggle="pill" href="#pills-download" role="tab"
                                                    aria-controls="pills-download" aria-selected="false"><i
                                                        class="fas fa-cloud-download-alt"></i> Download</a>
                                            </li>
                                            <li>
                                                <a id="pills-payment-tab" class="link--icon-left" data-toggle="pill" href="#pills-payment" role="tab"
                                                    aria-controls="pills-payment" aria-selected="false"><i
                                                        class="fas fa-credit-card"></i> Payment Method</a>
                                            </li>
                                            <li>
                                                <a id="pills-address-tab" class="link--icon-left" data-toggle="pill" href="#pills-address" role="tab"
                                                    aria-controls="pills-address" aria-selected="false"><i
                                                        class="fas fa-map-marker-alt"></i> Address</a>
                                            </li>
                                            <li>
                                                <a id="pills-account-tab" class="link--icon-left" data-toggle="pill" href="#pills-account" role="tab"
                                                    aria-controls="pills-account" aria-selected="false"><i class="fas fa-user"></i>
                                                    Account Details</a>
                                            </li>
                                            <li>
                                                <a class="link--icon-left" href="login.html"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md-8">
                                    <div class="tab-content my-account-tab" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-dashboard" role="tabpanel"
                                            aria-labelledby="pills-dashboard-tab">
                                            <div class="my-account-dashboard account-wrapper">
                                                <h4 class="account-title">Dashboard</h4>
                                                <div class="welcome-dashboard m-t-30">
                                                    <p>Hello, <strong>Alex Tuntuni</strong> (If Not <strong>Tuntuni !</strong> <a
                                                            href="#">Logout</a> )</p>
                                                </div>
                                                <p class="m-t-25">From your account dashboard. you can easily check &amp; view your
                                                    recent orders, manage your shipping and billing addresses and edit your password and
                                                    account details.</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab">
                                            <div class="my-account-order account-wrapper">
                                                <h4 class="account-title">Orders</h4>
                                                <div class="account-table text-center m-t-30 table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="no">No</th>
                                                                <th class="name">Name</th>
                                                                <th class="date">Date</th>
                                                                <th class="status">Status</th>
                                                                <th class="total">Total</th>
                                                                <th class="action">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Mostarizing Oil</td>
                                                                <td>Aug 22, 2020</td>
                                                                <td>Pending</td>
                                                                <td>$100</td>
                                                                <td><a href="#">View</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>Katopeno Altuni</td>
                                                                <td>July 22, 2020</td>
                                                                <td>Approved</td>
                                                                <td>$45</td>
                                                                <td><a href="#">View</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>Murikhete Paris</td>
                                                                <td>June 22, 2020</td>
                                                                <td>On Hold</td>
                                                                <td>$99</td>
                                                                <td><a href="#">View</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-download" role="tabpanel"
                                            aria-labelledby="pills-download-tab">
                                            <div class="my-account-download account-wrapper">
                                                <h4 class="account-title">Download</h4>
                                                <div class="account-table text-center m-t-30 table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="name">Product</th>
                                                                <th class="date">Date</th>
                                                                <th class="status">Expire</th>
                                                                <th class="action">Download</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Mostarizing Oil</td>
                                                                <td>Aug 22, 2020</td>
                                                                <td>Yes</td>
                                                                <td><a href="#">Download File</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Katopeno Altuni</td>
                                                                <td>July 22, 2020</td>
                                                                <td>Never</td>
                                                                <td><a href="#">Download File</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-payment" role="tabpanel"
                                            aria-labelledby="pills-payment-tab">
                                            <div class="my-account-payment account-wrapper">
                                                <h4 class="account-title">Payment Method</h4>
                                                <p class="m-t-30">You Can't Saved Your Payment Method yet.</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-address" role="tabpanel"
                                            aria-labelledby="pills-address-tab">
                                            <div class="my-account-address account-wrapper">
                                                <h4 class="account-title">Payment Method</h4>
                                                <div class="account-address m-t-30">
                                                    <h6 class="name">Alex Tuntuni</h6>
                                                    <p>1355 Market St, Suite 900 <br> San Francisco, CA 94103</p>
                                                    <p>Mobile: (123) 456-7890</p>
                                                    <a class="box-btn m-t-25 " href="#"><i class="far fa-edit"></i> Edit Address</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-account" role="tabpanel"
                                            aria-labelledby="pills-account-tab">
                                            <div class="my-account-details account-wrapper">
                                                <h4 class="account-title">Account Details</h4>

                                                <div class="account-details">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-box__single-group">
                                                                <input type="text" placeholder="First Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-box__single-group">
                                                                <input type="text" placeholder="Last Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-box__single-group">
                                                                <input type="text" placeholder="Display Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-box__single-group">
                                                                <input type="text" placeholder="Email address">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-box__single-group">
                                                                <h5 class="title">Password change</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-box__single-group">
                                                                <input type="password" placeholder="Current Password">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-box__single-group">
                                                                <input type="password" placeholder="New Password">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-box__single-group">
                                                                <input type="password" placeholder="Confirm Password">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-box__single-group">
                                                                <button class="btn btn--box btn--radius btn--small btn--black btn--black-hover-green btn--uppercase font--bold">Save Change</button>
                                                            </div>
                                                        </div>
                                                    </div>
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
            <div class="container" style="margin: auto;">
                <a href="logout.php">
                  <button style="height: 25px; width: 100px;">Logout</button>
                </a>
            </div>

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
