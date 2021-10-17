<?php
  session_start();

  require "config.php";


  $alert = "";

  $n=6;
  function getID($n) {
      $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $randomString = '';
    
      for ($i = 0; $i < $n; $i++) {
          $index = rand(0, strlen($characters) - 1);
          $randomString .= $characters[$index];
      }
    
      return $randomString;
  }
  
  if($_SERVER["REQUEST_METHOD"] == "POST") {
       
    do {
        $id = getID($n);
        $result = mysqli_query($link, "SELECT * from cust_message where case_id = '".$id."'");

    } while(mysqli_num_rows($result) == 1);

    $date = date("Y-m-d H:i:s");
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $title = $_POST["subject"];
    $user_message = $_POST["message"];

    $to      = "1191201218@student.mmu.edu.my"; // Send email to our user //$email
    $subject = 'Contact Us | TheGrabGroceries'; // Give the email a subject 
    $message = '
    <html>
        <body style="
            padding:20px; 
            background-color:gray;
            width: 500px;
            height: 1000px;
            color: white;"
            >
        <h1>Dear '. ucwords($name) . ',</h1>
        <br>
        
        <p style="color: white;">Thanks for contacting us! Our staff will get in touch with you as soon as possible:</p>
        <br>
        <p style="color: white;">Your message: </p>
        <br>

        <div style="
            padding:20px; 
            width: 400px; 
            height: 300px; 
            background-color:seagreen;
            color:white;
            border-radius:25px;
            margin: auto">
            <h3 style="font-size:20px; font-family:Arial, Helvetica, sans-serif;">'.ucwords($title).'</h3>
            <p style="color: white;">'.ucfirst($user_message).'</p>
        </div>
        <br>
        <br>
        
        <p style="color: white;">Enjoy your stay on TheGrabGroceries website!</p>
        
        <p style="color: white;">If this is not sent by you, please ignore this email</p>
        
        <h4 style="font-size:25px; font-family:Arial, Helvetica, sans-serif;">Case ID:'.$id.'</h4>
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


    $sql = "INSERT INTO cust_message 
            VALUES ('".$id."', '".ucwords($name)."', '".$email."', '".$phone."', '".ucwords($title)."', '".ucfirst($user_message)."', '".$date."')";

    if(mysqli_query($link, $sql)) {
        mail($to, $subject, $message, $headers);
        $alert = "true";
        //alertBox();
        echo "
        <script>
            alert('Message sent. Thank you for contacting us!');
        </script>";

   } else {
        //alertBox();
        echo "
        <script>
            alert('Some error occured, please try again');
        </script>";

   }


  }

  /*get_brightness($hex) { 
    // returns brightness value from 0 to 255 
    // strip off any leading # 
    $hex = str_replace('#', '', $hex;)
    $c_r = hexdec(substr($hex, 0, 2)); 
    $c_g = hexdec(substr($hex, 2, 2)); 
    $c_b = hexdec(substr($hex, 4, 2)); 
    
    return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
  }
  
  $color = "#******"; 
  if ($get_brightness($color) > 130) { // will have to experiment with this number 
    echo '<font style="color:black;">Black</font>'; 
  } else {  
    echo '<font style="color:white;">White</font>'; 
  }  */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us || TheGrabGroceries</title>
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

    <!-- template styles -->
    <link rel="stylesheet" href="assets/css/organik.css" />
    <style>
    .mode
    {
        color: #fff;
        background-color: #4CAF50;
        border: none;
        border-radius: 5px;
        text-align:center;
        font-size: 16px;
        margin-left: 20px;
    }

    .dark-mode 
    {
        background-color: black;
        color: white;
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
                            <?php 
                                if(isset($_SESSION["loggedin"]))
                                    echo "
                                    <ul>
                                        <li><a href='cart.php'>Cart Page</a></li>
                                        <li><a href='checkout.php'>Checkout</a></li>
                                    </ul>";
                            ?>
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
                    <div>
                        <button style="outline: none;" class="mode" onclick="myFunction()">Mode</button>
                    </div>
                </div><!-- /.container -->
            </nav>
            <!-- /.main-menu -->
        </header><!-- /.main-header -->

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2>Contact</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li>/</li>
                    <li><span>Contact</span></li>
                </ul><!-- /.thm-breadcrumb list-unstyled -->
            </div><!-- /.container -->
        </section><!-- /.page-header -->


        <section class="contact-one">
            <img src="assets/images/shapes/contact-bg-1-1.png" alt="" class="contact-one__shape-1">
            <img src="assets/images/shapes/contact-bg-1-2.png" alt="" class="contact-one__shape-2">
            <div class="container">
                <div class="block-title text-center">
                    <div class="block-title__decor"></div><!-- /.block-title__decor -->
                    <p>Get in Touch With Us</p>
                    <h3>Do You’ve Any Question? <br>
                        Write us a Message</h3>
                </div><!-- /.block-title -->

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="contact-one__form" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <label><strong>Name</strong></label>
                                <input type="text" name="name" placeholder="Your Name" required>
                            </div><!-- /.col-md-6 -->
                            <div class="col-md-6">
                                <label><strong>Email Address</strong></label>
                                <input type="email" placeholder="thegrabgroceries@gmail.com" name="email" required>
                            </div><!-- /.col-md-6 -->
                            <div class="col-md-6">
                                <label><strong>Phone Number</strong></label>
                                <input type="text" placeholder="0123456789" name="phone" required>
                            </div><!-- /.col-md-6 -->
                            <div class="col-md-6">
                                <label><strong>Subject</strong></label>
                                <input type="text" placeholder="How to order?" name="subject" required>
                            </div><!-- /.col-md-6 -->
                            <div class="col-md-12">
                                <label><strong>Message</strong></label>
                                <textarea placeholder="Write a Message" name="message" required></textarea>
                            </div><!-- /.col-md-12 -->
                            <div class="col-md-12 text-center">
                                <input type="submit" class="thm-btn" value="Send a Message">
                            </div><!-- /.col-md-12 -->
                        </div><!-- /.row -->    
                    </form>

            </div><!-- /.container -->
        </section><!-- /.contact-one -->

        <section class="contact-infos">
            <div class="container">
                <div class="thm-tiny__slider" id="contact-infos-box" data-tiny-options='{
                    "container": "#contact-infos-box",
                    "items": 1,
                    "slideBy": "page",
                    "gutter": 0,
                    "mouseDrag": true,
                    "autoplay": true,
                    "nav": false,
                    "controlsPosition": "bottom",
                    "controlsText": ["<i class=\"fa fa-angle-left\"></i>", "<i class=\"fa fa-angle-right\"></i>"],
                    "autoplayButtonOutput": false,
                    "responsive": {
                        "640": {
                        "items": 2,
                        "gutter": 30
                        },
                        "992": {
                        "gutter": 30,
                        "items": 3
                        },
                        "1200": {
                        "disable": true
                        }
                    }
                }'>
                    <div>
                        <div class="contact-infos__single">
                            <i class="organik-icon-location"></i>
                            <h3>Visit Anytime</h3>
                            <p>66 Melaka Street, Melaka. Malaysia</p>
                        </div><!-- /.contact-infos__single -->
                    </div>
                    <div>
                        <div class="contact-infos__single">
                            <i class="organik-icon-email"></i>
                            <h3>Send Email</h3>
                            <p>
                                <a href="mailto:thegrabgroceries@gmail.com">thegrabgroceries@gmail.com</a>
                            </p>
                        </div><!-- /.contact-infos__single -->
                    </div>
                    <div>
                        <div class="contact-infos__single">
                            <i class="organik-icon-calling"></i>
                            <h3>Contact Us</h3>
                            <p><a href="tel:92-666-888-0000">+60123456789</a> <br>
                            </p>
                        </div><!-- /.contact-infos__single -->
                    </div>
                </div>
            </div><!-- /.container -->
        </section><!-- /.contact-infos -->

        <div class="google-map__default">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7973.782605444915!2d102.23828442413114!3d2.1948269936007874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d1f1c323a61f9d%3A0x6f5f4f8fb415adee!2sTaman%20Kota%20Laksamana%2C%2075200%20Malacca!5e0!3m2!1sen!2smy!4v1630305293445!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" class="map__default" allowfullscreen></iframe>
        </div>
        <!-- /.google-map -->

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

    <script>
        function myFunction() 
        {
            var element = document.body;
            element.classList.toggle("dark-mode");
        }
    </script>
</body>

</html>