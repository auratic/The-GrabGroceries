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

   $address = $phone_num = $confirm_phnum = "";

   $ph_err = $add_err = $confirm_ph_err = "";
   
   if(isset($_POST["update"])){

        if(empty(trim($_POST["address"]))) {
            $add_err = "Please enter address";
        } else {
            $address = ucwords(trim($_POST["address"]));
        }

        if(empty(trim($_POST["phnum"]))) {
            $ph_err = "Please enter phone number";
        } else {
            $phone_num = ucwords(trim($_POST["phnum"]));
        }

        if (empty($_POST["confirm_phnum"])) {
            $confirm_ph_err = "Please confirm phone number.";     
    
        } else {
            $confirm_phnum = $_POST["confirm_phnum"];
    
            if (empty($ph_err) && ($phone_num != $confirm_phnum)) {
                $confirm_ph_err = "Phone number did not match.";
    
            }
        }

        if($ph_err == "" && $add_err == "" && $confirm_ph_err == "")
        {
            $sql = "UPDATE user set phone = '$phone_num',  address = '$address' WHERE id = '".$_SESSION['userid']."'";

        if (mysqli_query($link, $sql)) {
            echo "
            <script>
            alert('Address updated!');
            location.href = 'profile.php';
            </script>";

        } else {
            echo "
            <script>
            alert('Error: " . $sql . "\n" . mysqli_error($link) . "')
            </script>";

            }
        }
        // Close connection
        mysqli_close($link);
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
            margin-top: 50px;
            margin-left: 50px;
            margin-bottom: 50px;
            border-radius: 5px;
            border-style: double;
            width: 1430px;
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
            
            <!-- :::::::::: Edit Address :::::::::: -->
            <div class="edtaddress container">
                <h2>New Address</h2>
                <p>Please enter your new information.</p>
                <form 
                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" 
                    method="post"
                    style="text-align: left">
                    
                    <div class="form-group">
                        <label>New Address</label> </br>
                        <input type="text" name="address" class="form-control <?php echo (!empty($add_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>">
                        <span class="invalid-feedback"></span><?php echo $add_err; ?></span>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label> </br>
                        <input type="tel" pattern="[0-9]{3}-[0-9]{7}" name="phnum" placeholder="012-3456789"class="form-control <?php echo (!empty($ph_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone_num; ?>">
                        <span class="invalid-feedback"></span><?php echo $ph_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Phone Number</label> </br>
                        <input type="tel" pattern="[0-9]{3}-[0-9]{7}" name="confirm_phnum" placeholder="012-3456789" class="form-control <?php echo (!empty($comfirm_ph_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_phnum; ?>">
                        <span class="invalid-feedback"> </span><?php echo $confirm_ph_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="update" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                    </div>
                    
                </form>
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