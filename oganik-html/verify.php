<?php
  session_start();

  require "config.php";

  if(!isset($_SESSION["loggedin"])) {
    echo "
     <script>
       alert('Please login');
       location.href='login.php';
     </script>";
   } else if ($_SESSION["verified"] == "true") {
    echo "
     <script>
       alert('This account is already verified');
       location.href='index.php';
     </script>";
      
   }

  $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

  if($pageWasRefreshed ) {
    //do something because page was refreshed;
    // header("location: verify.php");
  } else {
    //do nothing;
  }

  
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $ver_err = '';

    if(empty($_POST["ver_code"])) {
        $ver_err = 'Please enter your verification code';
    } else if(trim(strtoupper($_POST["ver_code"])) != $_SESSION["ver_code"]) {
        $ver_err = 'Wrong verification code';
    }

    if(empty($ver_err)) {
        $sql = "
            UPDATE users
            SET verified = 'true'
            WHERE user_id = '".$_SESSION["userid"]."'";
        
        if(mysqli_query($link, $sql)){
            $_SESSION["verified"] = "true";
            $_SESSION["ver_code"] = "";
            echo "
            <script>
                alert('Account successfully verified');
                location.href = 'index.php'
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

  if(isset($_GET["message"])) {
       
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
        <h1>Dear '. $_SESSION["lname"] . ',</h1>
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify || TheGrabGroceries</title>
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
          background-image: url("https://cdn.wallpapersafari.com/68/37/Gwgjo6.jpg");
        }
        .signup-form{ width: 360px; padding: 20px; }
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
                            <img src="assets/images/logo-dark.png" width="105" alt="">
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
                    <a href="<?php if(isset($_SESSION["lname"])) { echo "adminprofile.php";} else { echo "login.php"; }?>" >
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
                        <li>
                            <a href="adminprofile.php">Profile</a>
                        </li>
                        <li>
                            <a href="additem.php">Add item</a>
                        </li>
                        <li>
                            <a href="displayitem.php">Update Item</a>
                        </li>
                        <li class="dropdown"><a href="news.php">Transactions</a>
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

                    if(document.querySelector("#try-again > span").innerHTML != -1) {

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