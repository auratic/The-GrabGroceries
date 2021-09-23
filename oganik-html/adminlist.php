<?php

  session_start();

  if(!isset($_SESSION["loggedin"]) || !isset($_SESSION["mode"]) || $_SESSION["mode"] !== "admin") {
   echo "
    <script>
      alert('You are not authorized to this page');
      location.href='index.php';
    </script>";
  }

  require "config.php";

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
                        <li class="dropdown">
                            <a href="displayitem.php">Update product</a>
                            <ul>
                                <li><a href="displayitem.php">Update product</a></li>
                                <li><a href="archiveitem.php">Archive product</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="admin_view_transaction.php">Transactions</a>
                        </li>
                        <li><a href="adminlist.php">Admin</a></li>
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
                        <div class="col-sm-9">
                        </div>
                        <div class="col-sm-3">
                            <form method="post" style="display: flex; justify-content: flex-end;">

                                <div class="form-group" style="text-align: left">
                                    <input class="btn btn-info btn-sm" type="submit" value="Add Admin" name="filter" style="margin-right: 1rem;" onclick="return addAdmin()">
                                </div>
                                        
                                <div class="form-group" style="text-align: left">
                                    <input class="btn btn-info btn-sm" type="submit" value="Delete Admin" name="filter" >
                                </div>
        
                            </form>
                        </div>
                    </div>

                    <div class="row">
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
                                                <input type="text" name="card_no'.$counter.'" id="card_no'.$counter.'" onkeyup="censor('.$counter.')" placeholder="Card Number" maxlength="19" class="form-control '. ((!empty($cno_err)) ? "is-invalid" : '' ).'" value="'.$card_no[$x].'">
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
                    <button type="button" class="btn btn-danger"  onclick="return closeModal()">Cancel</button>
                </div> 
                 <!-- Modal Footer-->
            </div>
            <!-- Modal content-->
        </div>
    </div>
    <!--Modal-->
    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

    <script>
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
