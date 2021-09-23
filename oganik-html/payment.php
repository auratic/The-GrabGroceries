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

    $card_name = array();
    $card_no = array();
    $card_exp = array();
    $card_cvv = array();


    if(isset($_POST['detail']))
    {
        /*if(empty($card_name))
        {
            $cname_err = "Please enter a name.";
        }
        else if(!preg_match("/^[a-zA-Z-' ]*$/",($_POST["card_name"]))) 
        {
            $cname_err = "Only letters and white space allowed";
        }
        else
        {
            $card_name = ucwords($_POST["card_name"]);
        }

        if(empty($card_no))
        {
            $cno_err = "Please enter card number";
        }
        else
        {
            $card_no = $_POST["card_no"];
        }

        if(empty($card_exp))
        {
            $cexp_err = "Please enter date.";
        }
        else
        {
            $card_exp = $_POST["card_exp"];
        }

        if(empty($card_cvv))
        {
            $ccvv_err = "Please enter CVV number";
        }
        else
        {
            $card_cvv = $_POST["card_cvv"];
        }*/
        $sql_insert_cc = "
            UPDATE cust_card
            SET 
            cardName".$_POST["no"]." = '".ucwords($_POST['card_name'])."', 
            cardNo".$_POST["no"]."= '".$_POST["card_no"]."', 
            cardExp".$_POST["no"]." = '".$_POST["card_exp"]."',
            cardCvv".$_POST["no"]." = '".$_POST["card_cvv"]."'
            WHERE user_id = ".$_SESSION["userid"];
     
        if(mysqli_query($link, $sql_insert_cc)) 
        {
            echo "
            <script>
                alert('Payment Method updated!');
            </script>";
        } 
        else 
        {
            echo "
            <script>
                alert('Something went wrong, please try again');
            </script>";
        }
    }

    $sql = "SELECT * FROM cust_card where user_id = ".$_SESSION["userid"];
    if($result = mysqli_query($link, $sql))
    {
        while($row=mysqli_fetch_assoc($result))
        {
            array_push($card_name, $row['cardName1'], $row['cardName2'], $row['cardName3'], $row['cardName4'], $row['cardName5']);
            array_push($card_no  , $row['cardNo1']  , $row['cardNo2']  , $row['cardNo3']  , $row['cardNo4']  , $row['cardNo5']);
            array_push($card_cvv , $row['cardCvv1'] , $row['cardCvv2'] , $row['cardCvv3'] , $row['cardCvv4'] , $row['cardCvv5']);
            array_push($card_exp , $row['cardExp1'] , $row['cardExp2'] , $row['cardExp3'], $row['cardExp4'] , $row['cardExp5']);
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">


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
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.4.3.min.js"></script>

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

        #add-card1, #add-card2, #add-card3, #add-card4, #add-card5
        {
            cursor: pointer;
        }
        
        .form-control
        {
            padding: 13px 0 13px 25px;
            text-align: center;
            width : 100%;
            border: 2px solid #dddddd;
            border-radius: 5px;
            letter-spacing: 1px;
            word-spacing: 3px;
            outline: none;
            font-size: 16px;
            color: #555555;
        }

        .card-grp
        {
            display: flex;
            justify-content: space-between;
        }

        .space
        {
            margin-bottom: 20px;
        }

        .label
        {
            margin-left:-95px;
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
                                <!-- :::::::::: Page Content :::::::::: -->
                                <div class="col-xl-8 col-md-8">
                                    <div class="tab-content my-account-tab" id="pills-tabContent">
                                        <div class="#" id="pills-payment" aria-labelledby="pills-payment-tab">
                                            <div class="my-account-payment account-wrapper">
                                                <h4 class="account-title">Payment Method</h4>
                                                <div class="row">
                                                <?php
                                                /*
                                                    $sql = "SELECT * FROM cust_card WHERE user_id = '".$_SESSION['userid']."'";
                                                    $result = mysqli_query($link, $sql);

                                                    while($row=mysqli_fetch_assoc($result)) 
                                                    {
                                                        $card_name = $row['cardName1'];
                                                        $card_no = $row['cardNo1'];
                                                        $card_exp = $row['cardExp1'];
                                                        $card_cvv = $row['cardCvv1'];
                                                    }

                                                    echo'
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <p>Card Name   :'.$card_name.' </p>
                                                                <p>Card Number :'.$card_no.'</span></p>
                                                                <a class="box-btn m-t-25 " id="add-card" onclick="return addCard(0)"><i class="far fa-edit"></i>Edit</a>
                                                            </div>';

                                                    */
                                                            $counterr = 0;
                                                            for($x=0; $x<5; $x++) 
                                                            {
                                                                $counterr++;
                                                                echo'
                                                                <div class="col-4">
                                                                    <p>Card Name   :'.$card_name[$x].' </p>
                                                                    <!-- <p>Card Number :<span id="card_display_no'.$counterr.'">'.$card_no[$x].'</span></p> -->
                                                                    <p>Card Number :'.$card_no[$x].'</span></p>
                                                                    <a class="box-btn m-t-25 " id="add-card'.$counterr.'" onclick="return addCard('.$counterr.')"><i class="far fa-edit"></i>Edit</a>
                                                                </div>';
                                                            }
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

            $counter = 0;
            for($x=0; $x<5; $x++) 
            {
                $counter++;
                echo'
                <!--Modal-->
                <div class="modal" id="card-modal'.$counter.'" role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:var(--thm-base)">
                                <h4 class="modal-title"><span style="color:white;">Credit Cards</span></h4>
                                <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                            </div> 
                            <!-- Modal Header-->

                            <div class="modal-body">
                            
                                <form> 
                                    <div class="row cardd space iconn-relative">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label"><i class="fas fa-user"> Card Holder</i></label>
                                                <input type="text" name="card_name'.$counter.'" id="card_name'.$counter.'" placeholder="Your Name" class="form-control '. ((!empty($cname_err)) ? "is-invalid" : '' ).'" value="'.$card_name[$x].'">
                                                    <span class="invalid-feedback"><?php echo $cname_err; ?></span>
                                            </div>
                                        </div>
                                    </div> 
                                    
                                    <div class="row cardd space iconn-relative">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label"><i class="fas fa-credit-card"> Card Number</i></label>
                                                <input type="text" name="card_no'.$counter.'" id="card_no'.$counter.'" onkeyup="censor('.$counter.')" placeholder="Card Number" maxlength="19" class="form-control card_no'.$counter.' '. ((!empty($cno_err)) ? "is-invalid" : '' ).'" value="'.$card_no[$x].'">
                                                    <span class="invalid-feedback"><?php echo $cno_err; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row space iconn-relative">
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="label"><i class="fas fa-calendar-alt"> Expiry Date</i></label>
                                                <input type="text" name="card_exp'.$counter.'" id="card_exp'.$counter.'" name="expiry-data" data-mask="00 / 00"  placeholder="MM / YY" class="form-control '. ((!empty($cexp_err)) ? "is-invalid" : '' ).'" value="'.$card_exp[$x].' ">
                                                <span class="invalid-feedback"><?php echo $cexp_err; ?></span>
                                            </div>
                                        </div>
                                            
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="label"><i class="fas fa-lock"> CVV</i></label>
                                                <input type="text" name="card_cvv'.$counter.'" id="card_cvv'.$counter.'" data-mask="000" placeholder="000" class="form-control '. ((!empty($ccvv_err)) ? "is-invalid" : '' ).'" value="'.$card_cvv[$x].' ">
                                                <span class="invalid-feedback"><?php echo $ccvv_err ; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="Submit" onclick="return updateCard('.$counter.');">
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <!-- Modal Body-->

                            <div class="modal-footer" style="background-color:var(--thm-base)">
                                <button type="button" class="btn btn-danger"  onclick="return closeModal('.$counter.')">Cancel</button>
                            </div> 
                            <!-- Modal Footer-->
                        </div>
                    </div>
                </div>';
            }
        ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    <!-- template js -->
    <script src="assets/js/organik.js"></script>

    <script>

        function updateCard(counter)
        {
            var cardName = document.getElementById("card_name"+counter).value;
            var cardNum = document.getElementById("card_no"+counter).value;
            var cardExp = document.getElementById("card_exp"+counter).value;
            var cardCvv = document.getElementById("card_cvv"+counter).value;

            if(cardName != "" && cardNum != "" && cardExp != "" && cardCvv != "")
            {   
                $.ajax({
                    type: "post",
                    url : "payment.php",
                    data: {
                        'detail': true,
                        'no':counter,
                        'card_name': cardName,
                        'card_no': cardNum,
                        'card_exp': cardExp,
                        'card_cvv': cardCvv
                    },
                    cache: false,
                    success: function (html) {
                        alert('Payment updated');
                        location.reload();
                    }
                });
            }
            return false;
        }
        
        function addCard(counter)
        {
            $('#card-modal'+counter).fadeIn();
            return false;
        }

        function closeModal(counter) 
        {
            $('#card-modal'+counter).fadeOut();
            return false;
        }

        function censor(counter) {
            var CCNValue = $("#card_no"+counter).val();
            CCNValue = CCNValue.replace(/ /g, '');
            var CCNLength = CCNValue.length;
            var m = 1;
            var arr = CCNValue.split('');
            var ccnnewval = "";

            if (arr.length > 0) {
                for (var m = 0; m < arr.length; m++) {
                    if (m == 4 || m == 8 || m == 12) {
                        ccnnewval = ccnnewval + ' ';
                    }

                    if (m <= 11) {
                        ccnnewval = ccnnewval + arr[m].replace(/[0-9]/g, "*");
                    } else {
                        ccnnewval = ccnnewval + arr[m];
                    }
                }
            }

            $("#card_no"+counter).val(ccnnewval);
        }
        
        /*
        $(document).ready(function () {

            $("#card_no").keyup(function (e) {
                
            });
        });
        */

       /*
        String.prototype.replaceAt = function(index, char) {
            var a = this.split("");
            a[index] = char;
            return a.join("");
        }

        window.onload = function() {
            
            for(var j = 0 ; j < 5 ; j ++) {
                var card_no = document.getElementById("card_no"+(j+1)).value;
                
                if(card_no != "") {

                for(var i = 0 ; i < 15 ; i++) {
                    var char = "*";
                    if (i == 4 || i == 9 || i == 14) {
                        char = " ";
                    }
                    card_no = card_no.replaceAt(i, char);
                }
                    
                document.getElementById("card_no"+(j+1)).value = card_no;
                }
            }

            for(var j = 0 ; j < 5 ; j ++) {

                var card_no = document.getElementById("card_display_no"+(j+1)).innerHTML;
                    
                if(card_no != "") {

                    for(var i = 0 ; i < 15 ; i++) {
                        var char = "*";
                        if (i == 4 || i == 9 || i == 14) {
                            char = " ";
                        }
                        card_no = card_no.replaceAt(i, char);
                    }
                        
                    document.getElementById("card_display_no"+(j+1)).innerHTML = card_no;
                }
            }
        }
       */
    </script>
</body>

</html>
