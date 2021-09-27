<?php

    session_start();

    if(!isset($_SESSION["loggedin"]) || !isset($_SESSION["mode"]) || $_SESSION["mode"] !== "superadmin") {
    echo "
        <script>
        alert('You are not authorized to this page');
        location.href='admin_profile.php';
        </script>";
    }

    require "config.php";

    // Define variables and initialize with empty values
    $email = $fname = $lname = $password = $confirm_password = $phone = "";
    $fname_err = $lname_err = $email_err = $password_err = $confirm_password_err = $phone_err = "";
    $registering = "";

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $registering = "true";

        if(empty($_POST["phone"])) {
            $phone_err = "Phone number is required";
        } else if (!preg_match('/^[0-9]{10}+$/', $_POST["phone"]) && !preg_match('/^[0-9]{11}+$/', $_POST["phone"]) && !preg_match('/^[0-9]{12}+$/', $_POST["phone"])) {
            $phone_err = "Please enter valid phone number";
        } else {
            $phone = $_POST["phone"];
        }

        // Validate first name
        if (empty($_POST["fname"])) {
            $fname_err = "Name is required";

        } else if (!preg_match("/^[a-zA-Z-' ]*$/",test_input($_POST["fname"]))) {
            $fname_err = "Only letters and white space allowed";

        } else {
            $fname = ucwords(test_input($_POST["fname"]));
        }

        // Validate last name
        if (empty($_POST["lname"])) {
            $lname_err = "Name is required";

        } else if (!preg_match("/^[a-zA-Z-' ]*$/",test_input($_POST["lname"]))) {
            $lname_err = "Only letters and white space allowed";

        } else {
            $lname = ucwords(test_input($_POST["lname"]));
        }

        // Validate email
        if (empty($_POST["email"])) {
            $email_err = "Email is required";

        } else if (!filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
                $email_err = "Invalid email format";
                
        } else {
            // Prepare a select statement

            $sql = "SELECT user_id FROM users WHERE email = '" . test_input($_POST["email"]) . "'";
            $result = mysqli_query($link, $sql);

            if (mysqli_num_rows($result) > 0) {
                $email_err = "Email is taken";

            } else 
            {
                $email = test_input($_POST["email"]);
            }
        }

        // Validate password
        if (empty($_POST["password"])) {
            $password_err = "Please enter a password.";    

        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Password must have atleast 6 characters.";

        } else {
            $password = $_POST["password"];

        }
        
        // Validate confirm password
        if (empty($_POST["confirm_password"])) {
            $confirm_password_err = "Please confirm password.";     

        } else {
            $confirm_password = $_POST["confirm_password"];

            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Password did not match.";

            }
        }
        
        // Check input errors before inserting in database
        if (empty($lname_err) && empty($fname_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($phone_err)) {
            
            // Prepare an insert statement
            $sql = "INSERT INTO users (email, password, mode, firstname, lastname, phone) VALUES ('$email', '$password', 'admin', '$fname', '$lname', '$phone');";
            
            if (mysqli_query($link, $sql)) {
                echo "
                <script>
                    alert('New admin added');
                    location.href = 'admin_manage.php';
                </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Customer's Transactions || TheGrabGroceries</title>
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
        .modal {
			background-color: rgba(0,0,0,0.5);
        }
        .modal > div {
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
                        <a href="<?php if(isset($_SESSION["lname"])) { echo "admin_profile.php";} else { echo "login.php"; }?>" >
                            <i class="organik-icon-user"></i>
                                <?php 

                                if(isset($_SESSION["lname"])) { 
                                    echo $_SESSION['lname'] ." (".$_SESSION['mode'].")";
                                } else { 
                                    echo "Login / Register";
                                }
                                
                                ?>
                        </a>
                    </div><!-- /.main-menu__login -->
                    <ul class="main-menu__list">
                        <li>
                            <a href="admin_profile.php">Profile</a>
                        </li>
                        <li>
                            <a href="admin_additem.php">Add item</a>
                        </li>
                        <li class="dropdown">
                            <a href="admin_displayitem.php">Update product</a>
                            <ul>
                                <li><a href="admin_displayitem.php">Update product</a></li>
                                <li><a href="admin_archiveitem.php">Archive product</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="admin_view_transaction.php">Transactions</a>
                        </li>
                        <?php 

                        if($_SESSION["mode"] == "superadmin") {
                            echo "<li><a href='admin_manage.php'>Manage Admins</a></li>";
                        }
                        
                        ?>
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

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->

        <section class="">
                <div class="container admin-header" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">
                    <h1>Admins</h1>
                </div>

                <div class="container admin-content" style="background-color:rgba(255,255,255,0.8); padding: 2%">
                    <div class="row">
                        <div class="col-sm-5">
                                <h4>Admin Feeds</h4>
                                <hr>
                        </div>

                        <div class="col-sm-7">
                                <h4>Admin list</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-8">
                                    </div>
                                    <div class="col-sm-4" 
                                        style="
                                        display: flex;
                                        align-items: center;
                                        justify-content: flex-end;">
                                        <div class="form-group" style="text-align: left; margin-right: 1rem">
                                            <button class="btn btn-info btn-sm" onclick="return addAdmin();">Add</button>
                                        </div>
                                        <div class="form-group" style="text-align: left">
                                            <button class="btn btn-info btn-sm" onclick="return deleteAdmin();">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped table-hover table-condensed">
                                    <tr>
                                        <th>User ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                    </tr>
                                    <?php

                                    $sql = "SELECT * FROM users WHERE mode = 'admin'";

                                    if ($result = mysqli_query($link, $sql)) {

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '
                                            <tr>
                                                <td>'.$row['user_id'].'</td>
                                                <td>'.$row['firstname'].'</td>
                                                <td>'.$row['lastname'].'</td>
                                                <td>'.$row['email'].'</td>
                                                <td>'.$row['phone'].'</td>
                                            </tr>';
                                        }
                                    }
                                    ?>
                                </table>
                        </div>
                    </div>
                </div>
        </section>
    </div>
    <!-- /.search-popup -->
    <div class="modal" id="add-modal" role="dialog">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">
                <div class="modal-header" style="background-color:var(--thm-base)">
                    <h4 class="modal-title"><span style="color:white;">Add Admin</span></h4>
                    <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                </div> 
                <!-- Modal Header-->

                <div class="modal-body">
                    <form 
                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); /* $_SERVER["PHP_SELF"] Returns the filename of the currently executing script */ ?>" 
                    method="post"
                    style="text-align: left">
                        <div class="form-group">
                            <label>E-mail</label> </br>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="grocery@gmail.com">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div> 

                        <div class="form-group">
                            <label>Phone</label> </br>
                            <input type="text" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>" placeholder="60123334444" maxlength="12">
                            <span class="invalid-feedback"><?php echo $phone_err; ?></span>
                        </div> 

                        <div class="form-group" style="display: flex; justify-content: space-between">
                            <div>
                                <label>First Name</label> </br>
                                <input type="text" name="fname" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fname; ?>">
                                <span class="invalid-feedback"><?php echo $fname_err; ?></span>
                            </div>   
                                
                            <div>
                                <label>Last Name</label> </br>
                                <input type="text" name="lname" class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lname; ?>">
                                <span class="invalid-feedback"><?php echo $lname_err; ?></span>
                            </div>    
                        </div>    

                        <div class="form-group">
                            <label>Password</label> </br>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>

                        <div class="form-group" style="text-align: left">
                            <label>Confirm Password</label> </br>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="add" class="btn btn-primary" value="Submit">
                        </div>
                    </form>
                </div>
                <!-- Modal Body-->

                <div class="modal-footer" style="background-color:var(--thm-base)">
                    <button type="button" class="btn btn-danger"  onclick="return closeModal()">Cancel</button>
                </div> 
                 <!-- Modal Footer-->
            </div>
            <!-- Modal content-->
        </div>
    </div>
    <!--Modal-->
    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>
    <p id="registering"><?php echo $registering ?></p>


    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
        if(document.getElementById("registering").innerHTML != "") {
            $('#add-modal').fadeIn();
        }

        function addAdmin() {
            $('#add-modal').fadeIn();
            return false;
        }
        function closeModal() {
            $('#add-modal').fadeOut();
            return false;
        }
    </script>
    <!-- template js -->
    <script src="assets/js/organik.js"></script>
</body>

</html>
