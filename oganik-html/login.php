<?php

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
} else if (isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang'])) {
    if ($_GET['lang'] == 'en')
        $_SESSION['lang'] = 'en';
    else if ($_GET['lang'] == 'cn')
        $_SESSION['lang'] = 'cn';
}

include  $_SESSION['lang'] . ".php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    </style>

</head>

<body>
    <?php

    date_default_timezone_set("Asia/Kuala_Lumpur");

    // Initialize the session
    session_start();

    // Check if the user is already logged in, if yes then redirect him to welcome page
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {

        if($_SESSION["mode"] == "admin" || $_SESSION["mode"] == "superadmin") {
            header("location: admin_dashboard.php");
        } else {
            header("location: index.php");
            exit;
        }
    }

    // Include config file
    require_once "config.php";

    if (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = 'en';
    } else if (isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang'])) {
        if ($_GET['lang'] == 'en')
            $_SESSION['lang'] = 'en';
        else if ($_GET['lang'] == 'cn')
            $_SESSION['lang'] = 'cn';
        else if ($_GET['lang'] == 'ms')
            $_SESSION['lang'] = 'ms';
    }

    include  $_SESSION['lang'] . ".php";

    // Define variables and initialize with empty values
    $email = $password = "";
    $email_err = $password_err = $login_err = $recaptcha_err = "";

    if (isset($_GET["verify"])) {

        if($result = mysqli_query($link, "SELECT * FROM users WHERE user_id = ". $_GET["id"])) {

            $row = mysqli_fetch_assoc($result);

            if($row["verified"] != "true") {
                echo "
                    <script>
                        Swal.fire({
                            icon: 'warning',
                            text: '"  . $lang['verifyacc'] ."',
                            showCancelButton: true,
                            confirmButtonText: 'Proceed',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'verify.php?verify&id=" . $_GET["id"] . "'
                            }
                        });
                    </script>";
            }
        }
    }

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Check if email is empty
        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter email.";
        } else {
            $email = trim($_POST["email"]);
        }

        // Check if password is empty
        if (empty($_POST["password"])) {
            $password_err = "Please enter your password.";
        } else {
            $password = $_POST["password"];
        }

        if (isset($_POST['g-recaptcha-response'])) {
            // RECAPTCHA SETTINGS
            $captcha = $_POST['g-recaptcha-response'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $key = '6LcwLAQcAAAAAHg2kPKE7VdugnrUrY1q4an9sa0E';
            $url = 'https://www.google.com/recaptcha/api/siteverify';

            // RECAPTCH RESPONSE
            $recaptcha_response = file_get_contents($url . '?secret=' . $key . '&response=' . $captcha . '&remoteip=' . $ip);
            $data = json_decode($recaptcha_response);

            if (isset($data->success) &&  $data->success === true) {
            } else {
                $recaptcha_err = 'Verify your reCAPTCHA';
            }
        }

        // Validate credentials
        if (empty($email_err) && empty($password_err) && empty($recaptcha_err)) {
            // Prepare a select statement

            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($link, $sql);

            if (mysqli_num_rows($result) == 1) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if (password_verify($password, $row['password'])) {

                        if ($row["mode"] == "deactivate") {

                            echo "
                            <script>
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Your account is deactivated. Please contact us to activate your account.',
                                    icon: 'warning'
                                })
                                /*
                                .then(function() {
                                    location.href = 'login.php'
                                })
                                */
                            </script>";
                        } else if ($row["verified"] == "false") {

                            echo "
                            <script>
                                Swal.fire({
                                    title: '" . $lang['error'] . "',
                                    text: '" . $lang['verify'] . "',
                                    icon: 'warning'
                                }).then(function() {
                                    location.href = 'verify.php?verify&id=" . $row["user_id"] . "'
                                })
                            </script>";
                        } else {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["mode"] = $row["mode"];
                            $_SESSION["lname"] = $row["lastname"];
                            $_SESSION["userid"] = $row["user_id"];
                            $_SESSION['email'] = $row['email'];

                            if ($_SESSION["mode"] == "admin" || $_SESSION["mode"] == "superadmin") {

                                $date = date('Y-m-d H:i:s');
                                $sql = "INSERT INTO admin_activity (user_id, activity, target, activity_time) VALUES (" . $_SESSION["userid"] . ", 'login', NULL, '$date')";
                                mysqli_query($link, $sql);

                                header("location: admin_dashboard.php");
                            } else {
                                header("location: index.php");
                            }
                        }
                    } else {
                        $login_err = "Email or password is invalid";
                    }
                }
            } else {
                $login_err = "Email or password is invalid";
                //echo "Error: " . $sql . "<br>" . mysqli_error($link);
            }
        }
    }
    ?>
    <!-- re-captcha -->
    <script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang['recap'] ?>"></script>

    <title><?php echo $lang['title'] ?></title>
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
                            } ?>" class="logo">
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
                            <p><?php echo $lang['email'] ?> <a href="mailto:thegrabgroceries@gmail.com">thegrabgroceries@gmail.com</a></p>
                        </div><!-- /.topbar__info -->
                    </div><!-- /.topbar__left -->
                    <div class="topbar__right">
                        <div class="topbar__info">
                            <i class="organik-icon-calling"></i>
                            <p><?php echo $lang['phone'] ?> <a href="tel:+60186620551">+60123608370</a></p>
                        </div><!-- /.topbar__info -->
                        <div class="topbar__buttons">
                            <a href="#" class="search-toggler"><i class="organik-icon-magnifying-glass"></i></a>
                            <a href="cart.php"><i class="organik-icon-shopping-cart"></i></a>
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
                            <a href="index.php"><?php echo $lang['home'] ?></a>
                        </li>
                        <li class="dropdown">
                            <a href="products.php"><?php echo $lang['shop'] ?></a>
                            <?php
                            if (isset($_SESSION["loggedin"]))
                                echo "
                                    <ul>
                                        <li><a href='cart.php'>Cart Page</a></li>
                                        <li><a href='checkout.php'>Checkout</a></li>
                                    </ul>";
                            ?>
                        </li>

                        <li><a href='review.php'><?php echo $lang['review'] ?></a></li>

                        <li class="dropdown">
                            <a href="#"><?php echo $lang['more'] ?></a>
                            <ul>
                                <li><a href="cust_contact.php"><?php echo $lang['contact'] ?></a></li>
                                <li><a href="about.php"><?php echo $lang['about'] ?></a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="main-menu__language">
                        <label class="sr-only" for="language-select">select language</label>
                        <!-- /#language-select.sr-only -->
                        <form action="" method="GET">
                            <select class="selectpicker" name="lang" id="language-select-header">
                                <option value="en"><?php echo $lang['chglg'] ?></option>
                                <option value="en" <?php if (isset($_GET['lang']) && $_GET['lang'] == 'en') {
                                                        echo "selected";
                                                    } ?>><?php echo $lang['eng'] ?></option>
                                <option value="ms" <?php if (isset($_GET['lang']) && $_GET['lang'] == 'ms') {
                                                        echo "selected";
                                                    } ?>><?php echo $lang['ms'] ?></option>
                                <option value="cn" <?php if (isset($_GET['lang']) && $_GET['lang'] == 'cn') {
                                                        echo "selected";
                                                    } ?>><?php echo $lang['man'] ?></option>
                            </select>
                            <button type="submit" class="btn btn-success" style="margin-left: 5px;"><?php echo $lang['save'] ?></button>
                        </form>
                    </div><!-- /.main-menu__language -->
                </div><!-- /.container -->
            </nav>
            <!-- /.main-menu -->
        </header><!-- /.main-header -->

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->


        <div class="container signup-form loginbox">
            <h2><?php echo $lang['login'] ?><br>TheGrabGroceries</h2>
            <p><?php echo $lang['cred'] ?></p>

            <?php
            if (!empty($login_err)) {
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group" style="text-align: left">
                    <label><b><?php echo $lang['email'] ?></b> </label> </br>
                    <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group" style="text-align: left">
                    <label><b><?php echo $lang['password'] ?></b></label> </br>
                    <input type="password" id="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <label style="cursor: pointer;"><input style="cursor: pointer; margin-top: 5px;" type="checkbox" onclick="myFunction()"><?php echo $lang['seepwd'] ?></label>
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group" style="text-align: left">
                    <div class="g-recaptcha" data-sitekey="6LcwLAQcAAAAAMhvxlQCfVC7rHJl0BRtHxa4zR17"></div>
                    <span class="reCAPTCHA-err" style="margin-top: .25rem; font-size: 80%; color: #dc3545;"><?php echo $recaptcha_err; ?></span>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary signinbtn" value="<?php echo $lang['login'] ?>">
                </div>
                <a href="forgotpass.php"><?php echo $lang['fgtpwd'] ?></a>
                <p><?php echo $lang['no_acc'] ?><a href="cust_register.php"><?php echo $lang['register'] ?></a>.</p>
            </form>
        </div>
        <script>
            function myFunction() {
                var x = document.getElementById("password");

                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
        </script>
        <?php

        include 'cust_footer.php';


        ?>