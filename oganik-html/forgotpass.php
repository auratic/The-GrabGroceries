<?php

// Initialize the session
session_start();

/*
$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

if($pageWasRefreshed ) {
  //do something because page was refreshed;
  header("location: login.php");
} else {
  //do nothing;
}
*/

// Check if the user is logged in
if(isset($_SESSION["loggedin"])) {
    header("location: index.php");
    exit;
}
 
require "config.php";
 
$n=6;
function getName($n) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
  
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
  
    return $randomString;
}

$email = $code  = "";
$email_err = $code_err = "";
$send_status = "";
$verify_status = "";

//*************************//
//   Check if email exist
//*************************//

if(isset($_POST["send-email"])) {
    
    $email_err = "";
    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email";
    } else {
        $email = $_POST["email"]; 
    }

	// Prepare a select statement
	$sql = "SELECT * FROM user WHERE email = '$email'";
	$result = mysqli_query($link, $sql);

	if (mysqli_num_rows($result) == 1) {
		
		while($row = mysqli_fetch_assoc($result)) {
			$_SESSION["resetid"] = $row["id"];
			$_SESSION["resetemail"] = $row["email"];
		}
	} else {
		$email_err = "E-mail could not be found.";
	}

    if($email_err == "") {
		$send_status = "Email sent";
        $_SESSION["ver_code"] = getName($n);
        $to      = "1191201218@student.mmu.edu.my"; // Send email to our user
        $subject = 'Reset Password'; // Give the email a subject 
        $message = '
        <html>
            <body style="
                padding:20px; 
                background-color:gray;
                width: 500px;
                height: 600px;
                color: white;"
                >
            <h1>Dear '. $email . ',</h1>
            <br>
            
            <p style="color: white;">Here is your password reset PIN:</p>
            <br>
            <br>

            <h1 style="
                padding:20px; 
                font-size:40px; 
                width: 400px; 
                height: 50px; 
                text-align: center;
                background-color:seagreen;
                color:white;
                border-radius:25px;
                font-family:Arial, Helvetica, sans-serif;
                margin: auto"
                >
                '.$_SESSION["ver_code"].'
            </h1>
            <br>
            <br>
            
            <p style="color: white;">Enjoy your stay on TheGrabGroceries website!</p>
            
            <p style="color: white;">If this is not sent by you, please ignore this email</p>

            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>

            <p style="color: white;">Best Regards</p></br>
            <p style="color: white;">TheGrabGroceries Staff</p>
            </body>
        </html>
        ';
                                
        $headers = 'From: TheGrabGroceries <thegrabgroceries@gmail.com>' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  // Set from headers
        mail($to, $subject, $message, $headers); // Send our email
    }
}

//*************************//
//      Verify Code
//*************************//

if(isset($_POST["confirm-code"])) {
    $verify_status = "";
    $code_err = "";
	if(isset($_SESSION["ver_code"]) && (strtoupper($_POST["ver-code"]) == $_SESSION["ver_code"])) {
			
		$verify_status = "Correct PIN entered";

	} else if (strtoupper($_POST["ver-code"]) == ""){

		$code_err = "Enter your PIN";

	} else {

		$code_err = "Wrong PIN entered";
	
	}
}

//*************************//
//      Set password
//*************************//

if(isset($_POST["new-pass"])) {
	
	$sql = "UPDATE user 
			SET password = '".$_POST['new-pass']."' 
			WHERE id = ".$_SESSION["resetid"];
	
	if(mysqli_query($link, $sql)) {
		echo "
		<script>
			alert('Password updated');
			location.href = 'login.php';
		</script>";

	} else {
		echo "
		<script>
			alert('Something went wrong, please try again');
			location.href = 'login.php';
		</script>";
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Reset Password || TheGrabGroceries</title>
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
	
	<!-- template styles -->
	<link rel="stylesheet" href="assets/css/organik.css" />
    <style>
        body{
            background-color: var(--thm-base);
			background-image: url("https://cdn.wallpapersafari.com/68/37/Gwgjo6.jpg")
        }
        .forgot-password {
            background-color: white;
            padding: 20px;
            border-radius: 25px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

		.modal {
			background-color: rgba(0,0,0,0.5);
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
							<p>Email <a href="mailto:info@organik.com">thegrabgroceries@gmail.com</a></p>
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
			<!-- /.main-menu -->
		</header><!-- /.main-header -->


		<section>
			<div class="container forgot-password">
                <div class="row">
                    <div class="col-md-6" style="margin:auto">

                        <h2>Reset Password</h2>
                        <p>Please enter your email to receive password reset PIN</p>

                        <form action="forgotpass.php" method="post"> 
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Enter your email</label>
                                        <input type="email" name="email" id="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                                        <span class="invalid-feedback email-err"><?php echo $email_err; ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="submit" name="send-email" id="submit" class="btn btn-primary" value="Send">
                                    </div>
                                </div>
                                </br>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <p id="sent-status"  style='color:var(--thm-base)'><?php echo $send_status; ?></p>
                                    <p id="try-again" style="visibility: hidden; ">You can resend the email in <span>60</span></p>
                                </div>
                            </div>

                        </form>
                        
                        <hr><br>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Key in your code</label>
                                        <input type="text" name="ver-code" id="ver-code" class="form-control <?php echo (!empty($code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $code; ?>">
                                        <span class="invalid-feedback"><?php echo $code_err; ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="submit" name="confirm-code" id="verify-btn" class="btn btn-primary" value="Enter">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <p id="verify-status"  style='color:var(--thm-base)'><?php echo $verify_status; ?></p>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
			</div><!-- /.container -->
            
		</section><!-- /.checkout-page -->

		<footer class="site-footer background-black-2">
			<img src="assets/images/shapes/footer-bg-1-1.png" alt="" class="site-footer__shape-1">
			<img src="assets/images/shapes/footer-bg-1-2.png" alt="" class="site-footer__shape-2">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
						<div class="footer-widget footer-widget__about-widget">
							<a href="index.php" class="footer-widget__logo">
								<img src="assets/images/logo-light.png" alt="" width="105" height="43">
							</a>
							<p class="thm-text-dark">Atiam rhoncus sit amet adip
								scing sed ipsum. Lorem ipsum
								dolor sit amet adipiscing <br>
								sem neque.</p>
						</div><!-- /.footer-widget -->
					</div><!-- /.col-sm-12 col-md-6 -->
					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-2">
						<div class="footer-widget footer-widget__contact-widget">
							<h3 class="footer-widget__title">Contact</h3><!-- /.footer-widget__title -->
							<ul class="list-unstyled footer-widget__contact">
								<li>
									<i class="fa fa-phone-square"></i>
									<a href="tel:666-888-0000">666 888 0000</a>
								</li>
								<li>
									<i class="fa fa-envelope"></i>
									<a href="mailto:info@company.com">info@company.com</a>
								</li>
								<li>
									<i class="fa fa-map-marker-alt"></i>
									<a href="#">66 top broklyn street.
										New York</a>
								</li>
							</ul><!-- /.list-unstyled footer-widget__contact -->
						</div><!-- /.footer-widget -->
					</div><!-- /.col-sm-12 col-md-6 col-lg-2 -->
					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-2">
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
									<a href="about.php">About Store</a>
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
									<a href="checkout.php">My Account</a>
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
					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
						<div class="footer-widget">
							<h3 class="footer-widget__title">Newsletter</h3><!-- /.footer-widget__title -->
							<form action="#" data-url="YOUR_MAILCHIMP_URL" class="mc-form">
								<input type="email" name="EMAIL" id="mc-email" placeholder="Email Address">
								<button type="submit">Subscribe</button>
							</form>
							<div class="mc-form__response"></div><!-- /.mc-form__response -->
						</div><!-- /.footer-widget -->
					</div><!-- /.col-sm-12 col-md-6 col-lg-2 -->
				</div><!-- /.row -->
			</div><!-- /.container -->
			<div class="bottom-footer">
				<div class="container">
					<hr>
					<div class="inner-container text-center">
						<div class="bottom-footer__social">
							<a href="#" class="fab fa-twitter"></a>
							<a href="#" class="fab fa-facebook-square"></a>
							<a href="#" class="fab fa-instagram"></a>
						</div><!-- /.bottom-footer__social -->
						<p class="thm-text-dark">© Copyright <span class="dynamic-year"></span> by Company.com</p>
					</div><!-- /.inner-container -->
				</div><!-- /.container -->
			</div><!-- /.bottom-footer -->
		</footer><!-- /.site-footer -->

	</div><!-- /.page-wrapper -->


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
			<form action="#">
				<label for="search" class="sr-only">search here</label><!-- /.sr-only -->
				<input type="text" id="search" placeholder="Search Here..." />
				<button type="submit" aria-label="search submit" class="thm-btn">
					<i class="organik-icon-magnifying-glass"></i>
				</button>
			</form>
		</div>
		<!-- /.search-popup__content -->
	</div>
	<!-- /.search-popup -->

	<div class="modal" id="reset-modal" role="dialog">
        <div class="modal-dialog modal-lg">
                
		<!-- Modal content-->
			<div class="modal-content reset-modal">
				<div class="modal-header" style="background-color:var(--thm-base)">
					<!--
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Modal Header</h4>
					-->
				</div> 
				<!-- Modal Header-->

				<div class="modal-body">
				
					<form> 
								
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>New password</label>
									<input type="password" name="new-pass" id="new-pass" class="form-control <?php echo (!empty($code_err)) ? 'is-invalid' : ''; ?>">
									<span class="new-pass-err" style="color:crimson"></span>
								</div>
							</div>
						</div>
								
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Confirm password</label>
									<input type="password" name="confirm-pass" id="confirm-pass" class="form-control <?php echo (!empty($code_err)) ? 'is-invalid' : ''; ?>">
									<span class="con-pass-err" style="color:crimson"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<input type="submit" class="btn btn-primary" value="Enter" onclick="return passReset()">
								</div>
							</div>
						</div>
                    </form>

				</div>
				<!-- Modal Body-->

				<div class="modal-footer" style="background-color:var(--thm-base)">
					<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
				</div> 
				<!-- Modal Footer-->
			</div>
                
        </div>
    </div>
	<!-- /.modal -->
	
	<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

	<script src="assets/js/organik.js"></script>
    <script type="text/javascript">
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}

        var sent_status = document.querySelector("#sent-status");
        var ver_status = document.querySelector("#verify-status");
        var submit_button = document.querySelector("#submit");
        var try_again = document.querySelector("#try-again");
        var verify_btn = document.getElementById("verify-btn");
        var count; 


		function validateEmail(email) {
			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
				return true

			} else {
				return false

			}
		}

		if(sent_status.innerHTML == "Email sent") {

			/*
			$.ajax({
				type:"post",
				url:"forgotpass.php",
				data: 
				{  
				'email' :email
				},
				cache:false,
				success: function (html) {
					alert('Sent');
				}
			});
			*/
           	try_again.style.visibility = "visible";
			if(document.querySelector("#try-again > span").innerHTML != -1) {
				count = setInterval(() => {
				document.querySelector("#try-again > span").innerHTML -= 1;
				submit_button.disabled = true;

					if (document.querySelector("#try-again > span").innerHTML == -1) {
						clearInterval(count);
						try_again.style.visibility = "hidden";
						document.querySelector("#try-again > span").innerHTML = 60;
						sent_status.innerHTML = "<i>You can resend the verification email</i>";
						submit_button.disabled = false;

					}
				}, 1000);
			} 
		}

		if(ver_status.innerHTML == "Correct PIN entered") {
			$('#reset-modal').fadeIn();
		}

		function resetComplete () {
			alert("Password updated");
  			location.href="login.php";
		}

		function passReset() {
			var newpass = document.getElementById("new-pass").value;
			var conpass = document.getElementById("confirm-pass").value;
			var newpasserr = document.querySelector(".new-pass-err");
			var conpasserr = document.querySelector(".con-pass-err");
			
			if (newpass == "") {
				newpasserr.innerHTML = "Please enter password";
			} else if (newpass.length < 6) {
				newpasserr.innerHTML = "Ensure your password is longer than 6 characters";
			} else if (conpass == "") {
				conpasserr.innerHTML = "Please confirm password";
			} else if (newpass !== conpass) {
				conpasserr.innerHTML = "Password not met";
			} else {
				$.ajax({
					type: "post",
					url: "forgotpass.php",
					data: {  
					'new-pass' : newpass
					},
					cache: false,
					success: function (html) {
						alert('Password updated');
						location.href = 'login.php';
					}
				});
			}
			return false;
		}

    </script>
</body>

</html>

<?php

?>