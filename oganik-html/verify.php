<?php

session_start();

date_default_timezone_set("Asia/Kuala_Lumpur");

require "config.php";

if (!isset($_SESSION["loggedin"])) {
    echo "
            <script>
                Swal.fire({
                    title: 'Error',
                    text: 'Please login first..',
                    icon: 'error'
                }).then(function() {
                location.href = 'login.php'
                })
            </script>";
} 

$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

if ($pageWasRefreshed) {
    //do something because page was refreshed;
    // header("location: verify.php");
} else {
    //do nothing;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ver_err = '';

    if (empty($_POST["ver_code"])) {
        $ver_err = 'Please enter your verification code';
    } else if (trim(strtoupper($_POST["ver_code"])) != $_SESSION["ver_code"]) {
        $ver_err = 'Wrong verification code';
    }

    if (empty($ver_err)) {
        $sql = "
            UPDATE users
            SET verified = 'true'
            WHERE user_id = '" . $_SESSION["userid"] . "'";

        if (mysqli_query($link, $sql)) {
            $_SESSION["verified"] = "true";
            $_SESSION["ver_code"] = "";
            echo "
                <script>
                    Swal.fire({
                        title: 'Successful',
                        text: 'Your account has been verified.',
                        icon: 'success'
                    }).then(function() {
                    location.href = 'index.php'
                    })
                </script>";
        } else {
            echo "
            <script>
                alert('Something went wrong verifying your account');
                location.href = 'index.php'
            </script>";
        }
    }
}

$n = 6;
function getName($n)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

if (isset($_GET["message"])) {

    $_SESSION["ver_code"] = getName($n);
    $to      = "1191201218@student.mmu.edu.my"; // Send email to our user
    $subject = 'Signup | Verification'; // Give the email a subject 
    $message = '
    <html>
        <body style="
            padding:20px; 
            background-color:gray;
            width: 500px;
            height: 600px;
            color: white;"
            >
        <h1>Dear ' . $_SESSION["lname"] . ',</h1>
        <br>
        
        <p style="color: white;">Thanks for signing up with us! Here is your verification code:</p>
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
            ' . $_SESSION["ver_code"] . '
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TheGrabGroceries</title>
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
                            <a href="https://twitter.com/" class="fab fa-twitter" target="_blank"></a>
                            <a href="https://www.facebook.com/Thegrabgroceries-100840225730842/" class="fab fa-facebook-square" target="_blank"></a>
                            <a href="https://www.instagram.com/" class="fab fa-instagram" target="_blank"></a>
                        </div><!-- /.topbar__social -->
                        <div class="topbar__info">
                            <i class="organik-icon-email"></i>
                            <p>Email <a href="mailto:thegrabgroceries@gmail.com">thegrabgroceries@gmail.com</a></p>
                        </div><!-- /.topbar__info -->
                    </div><!-- /.topbar__left -->
                    <div class="topbar__right">
                        <div class="topbar__info">
                            <i class="organik-icon-calling"></i>
                            <p>Phone <a href="tel:+60186620551">+60123456789</a></p>
                        </div><!-- /.topbar__info -->
                        <div class="topbar__buttons">
                            <a href="#" class="search-toggler"><i class="organik-icon-magnifying-glass"></i></a>
                            <a href="cart.php" ><i class="organik-icon-shopping-cart"></i></a>
                        </div><!-- /.topbar__buttons -->
                    </div><!-- /.topbar__left -->

                </div><!-- /.container -->
            </div><!-- /.topbar -->
            <nav class="main-menu">
                <div class="container">
                    <div class="main-menu__login">
                        <a href="<?php if (isset($_SESSION["lname"])) {
                                        echo "cust_profile.php";
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
                            <a href='review.php'>Testimonial</a>
                        </li>

                        <li class="dropdown">
                            <a href="#">More</a>
                            <ul>
                                <li><a href='news.php'>News</a></li>
                                <li><a href="cust_contact.php">Contact Us</a></li>
                                <li><a href="about.php">About Us</a></li>
                            </ul>
                        </li>
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

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->
<div class="container" style="margin: auto; margin-top: 50px; padding: 20px; background-color:azure; width:80%">

    <h4 style="margin-bottom: 20px">Verify</h4>
    <p>
        Click <b>Send Verification Email</b> button to receive verification code </br>
    </p>
    <p id="try-again" style="visibility: hidden;">
        You can resend the email in <span>60</span> seconds.
    </p>

    <button type="button" class="btn btn-md btn-info" id="verify-btn" style="margin-top:20px; margin-bottom:20px">Send Verification Email</button>
    <p id="sent" style="color:crimson; margin: 0;"></p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group" style="text-align: left">
            <label><b>Please enter your verification code</b></label> </br>
            <input type="text" name="ver_code" class="form-control <?php echo (!empty($ver_err)) ? 'is-invalid' : ''; ?>" style="width:200px">
            <span class="invalid-feedback"><?php echo $ver_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Verify">
        </div>
    </form>
</div>
</div>


<script>
    var try_again = document.querySelector("#try-again");
    var verify_btn = document.querySelector("#verify-btn");
    var sent_status = document.querySelector("#sent");
    var count;

    verify_btn.onclick = () => {

        try_again.style.visibility = "visible";
        sent_status.innerHTML = "";

        var xhttp = new XMLHttpRequest();

        xhttp.open("GET", "verify.php?message=true", true);
        xhttp.send();
        xhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
                sent_status.innerHTML = "<i>Email sent. Check spam folder if you did not see the email.</i>" //this.responseText;

            } else {
                sent_status.innerHTML = "<i>Fail to send email</i>";

            }
        }

        if (document.querySelector("#try-again > span").innerHTML != -1) {

            count = setInterval(() => {
                document.querySelector("#try-again > span").innerHTML -= 1;
                verify_btn.disabled = true;

                if (document.querySelector("#try-again > span").innerHTML == -1) {
                    clearInterval(count);
                    try_again.style.visibility = "hidden";
                    document.querySelector("#try-again > span").innerHTML = 60;
                    sent_status.innerHTML = "<i>You can resend the verification email</i>";
                    verify_btn.disabled = false;

                }
            }, 1000);

        }
    }
</script>
<?php include 'cust_footer.php';
if($_SESSION["verified"] == "true") {
    echo "
        <script>
            Swal.fire({
                title: 'Successful',
                text: 'Your account is already verified.',
                icon: 'success'
            }).then(function() {
            location.href = 'index.php'
            })
        </script>";
}
?>