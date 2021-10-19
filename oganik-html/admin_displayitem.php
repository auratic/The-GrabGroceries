<?php
session_start();

date_default_timezone_set("Asia/Kuala_Lumpur");

if (!isset($_SESSION["loggedin"]) || !isset($_SESSION["mode"]) || ($_SESSION["mode"] !== "admin" && $_SESSION["mode"] !== "superadmin")) {
    echo "
    <script>
      alert('You are not authorized to this page');
      location.href='index.php';
    </script>";
}

require "config.php";

if (isset($_GET["archive"])) {

    $item_id = $_GET["item_id"];

    $date = date('Y-m-d H:i:s');
    $activity_sql = "INSERT INTO admin_activity (user_id, activity, activity_time, target) VALUES (" . $_SESSION["userid"] . ", 'archive item', '$date', '";

    for ($i = 0; $i < count($item_id); $i++) {
        $sql = "UPDATE item SET item_status = 'Inactive' WHERE item_id = " . $item_id[$i];

        if ($i < 1) {
            $activity_sql .= $item_id[$i];
        } else {
            $activity_sql .= "," . $item_id[$i];
        }

        if (mysqli_query($link, $sql)) {
            echo "<script>alert('Updated');</script>";
        } else {
            echo "<script>alert('Some error occured');</script>";
        }
    }
    $activity_sql .= "')";
    mysqli_query($link, $activity_sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Item || TheGrabGroceries</title>
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

        .signup-form {
            padding: 20px 50px;
            margin: 20px 50px 20px 50px;
            background-color: azure;
            overflow: auto;
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
                        <a href="<?php if (isset($_SESSION["lname"])) {
                                        echo "admin_profile.php";
                                    } else {
                                        echo "login.php";
                                    } ?>">
                            <i class="organik-icon-user"></i>
                            <?php

                            if (isset($_SESSION["lname"])) {
                                echo $_SESSION['lname'] . " (" . $_SESSION['mode'] . ")";
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

                        if ($_SESSION["mode"] == "superadmin") {
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

        <section>
            <div class="container" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">
                <h1>Your active products</h1>
            </div>

            <div class="container" style="padding:2%; background-color:rgba(255,255,255,0.8);">
                <div class="row">

                    <div class="col-sm-2" style="
                        border: gray solid 1px;
                        border-radius: 10px;
                        padding: 1%;
                        background-color: lightgray;">
                        <form>
                            <div class="form-group" style="text-align: left">
                                <label><b>Search by name</b></label> </br>
                                <input type="text" name="search_name" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo ""; ?>">
                                <span class="invalid-feedback"><?php echo $name_err; ?></span>
                            </div>

                            <div class="form-group" style="text-align: left">
                                <label><b>Search by id</b></label> </br>
                                <input type="text" name="search_id" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo ""; ?>">
                                <span class="invalid-feedback"><?php echo $id_err; ?></span>
                            </div>

                            <hr>

                            <div class="form-group" style="text-align: left">
                                <label><b>Search by category</b></label> </br>
                                <select id="category" name="category" class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $category; ?>">
                                    <option value="Fruit & Vegetables">Fruit & Vegetables</option>
                                    <option value="Meat">Meat</option>
                                    <option value="Seafood">Seafood</option>
                                    <option value="Snack">Snack</option>
                                </select>
                                <span class="invalid-feedback"><?php echo $category_err; ?></span>
                            </div>

                            <hr>

                            <label><b>Date added</b></label> </br>
                            <div class="form-group" style="text-align: left">
                                <p>from</p>
                                <input type="date" name="date_added_from" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $added_from_err; ?></span>
                            </div>

                            <div class="form-group" style="text-align: left">
                                <p>to</p>
                                <input type="date" name="date_added_to" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $added_to_err; ?></span>
                            </div>

                            <hr>

                            <label><b>Expiry Date</b></label> </br>
                            <div class="form-group" style="text-align: left">
                                <p>from</p>
                                <input type="date" name="exp_date_from" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $exp_from_err; ?></span>
                            </div>

                            <div class="form-group" style="text-align: left">
                                <p>to</p>
                                <input type="date" name="exp_date_to" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $exp_to_err; ?></span>
                            </div>

                            <hr>

                            <div class="form-group" style="text-align: left">
                                <input type="submit" class="btn btn-primary" value="Filter">
                            </div>

                        </form>
                    </div>

                    <div class="col-sm-10">

                        <div class="product-tab-box tabs-box" style="margin:0">

                            <ul class="tab-btns tab-buttons clearfix list-unstyled">
                                <li data-tab="#desc" class="tab-btn active-btn"><span>Active products</span></li>
                                <li data-tab="#addi__info" class="tab-btn" onclick="location.href='admin_archiveitem.php'"><span>Archived products</span></li>
                            </ul>

                            <div class="tabs-content">

                                <div class="tab active-tab" id="desc">

                                    <div class="product-details-content" style="padding: 0;">

                                        <div class="desc-content-box">

                                            <div class='row' style="margin: 1%">
                                                <div class="col-sm-8">
                                                    <!--
                                                <form>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label><b>Date added</b></label> </br>
                                                            <div class="form-group" style="text-align: left">
                                                                <p>from</p>
                                                                <input type="date" name="date_added_from" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                                                                <span class="invalid-feedback"><?php echo $added_from_err; ?></span>
                                                            </div>   
                                                            
                                                            <div class="form-group" style="text-align: left">
                                                                <p>to</p>
                                                                <input type="date" name="date_added_to" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                                                                <span class="invalid-feedback"><?php echo $added_to_err; ?></span>
                                                            </div>
                                                        </div>      

                                                        <div class="col-sm-6">
                                                            <label><b>Expiry Date</b></label> </br>
                                                            <div class="form-group" style="text-align: left">
                                                                <p>from</p>
                                                                <input type="date" name="exp_date_from" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                                                                <span class="invalid-feedback"><?php echo $exp_from_err; ?></span>
                                                            </div>   

                                                            <div class="form-group" style="text-align: left">
                                                                <p>to</p>
                                                                <input type="date" name="exp_date_to" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                                                                <span class="invalid-feedback"><?php echo $exp_to_err; ?></span>
                                                            </div>   
                                                        </div>      
                                                    </div>

                                                </form>
                                                -->
                                                </div>

                                                <!--
                                                <div class="col-sm-3" 
                                                    style="
                                                    display:flex; 
                                                    align-items:flex-end; 
                                                    justify-content: flex-end" 
                                                    >
                                                -->
                                                <div class="col-sm-4">
                                                    <form style="
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: flex-end;">
                                                        <div class="form-group" style="text-align: left; margin-right: 1rem">
                                                            <input type="checkbox" id="select-all" />
                                                            <label for="select-all">Select All</label>
                                                        </div>
                                                        <div class="form-group" style="text-align: left; margin-right: 1rem">
                                                            <button class="btn btn-info btn-sm" onclick="return archiveItem();">Archive</button>
                                                        </div>
                                                        <div class="form-group" style="text-align: left">
                                                            <button class="btn btn-info btn-sm" onclick="return deleteItem();">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div style="padding: 1%;">
                                                <table class="table table-bordered table-striped table-hover table-condensed">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Item name</th>
                                                        <th>Category</th>
                                                        <th>Description</th>
                                                        <th>Stock</th>
                                                        <th>Image</th>
                                                        <th>Cost</th>
                                                        <th>Expiry Date</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    <?php
                                                    $sql = "SELECT * from item";

                                                    if ($result = mysqli_query($link, $sql)) {

                                                        while ($row = mysqli_fetch_assoc($result)) {

                                                            if ($row["item_status"] == "Active") {
                                                                echo '
                                                <tr>
                                                <td>' . $row['item_id'] . '</td>
                                                <td>' . $row['item'] . '</td>
                                                <td>' . $row['category'] . '</td>
                                                <td>' . $row['description'] . '</td>
                                                <td>' . $row['stock'] . '</td>
                                                <td><img src="assets/images/items/' . $row['image'] . '" style="width:100%;height:200px;object-fit:contain;"></td>
                                                <td>RM' . $row['cost'] . '</td>
                                                <td>' . $row['exp_date'] . '</td>
                                                <td>
                                                    <a href="admin_updateitem.php?id=' . $row['item_id'] . '">
                                                    <button class="btn btn-info btn-sm">Edit</button>
                                                    </a>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="select-item" value="' . $row['item_id'] . '">
                                                </td>
                                                </tr>';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- tab-content -->

                        </div> <!-- product-tab-box -->

                    </div> <!-- col-sm-10 -->

                </div>
            </div>
        </section>

        <!-- /.search-popup -->

        <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>
        <script>
            var checkboxes = document.getElementsByName('select-item');
            var select_all = document.getElementById("select-all");

            select_all.onclick = () => {

                if (select_all.checked) {
                    //console.log("yes")
                    for (var i = 0, n = checkboxes.length; i < n; i++) {
                        checkboxes[i].checked = true;
                    }
                } else {
                    //console.log("no")
                    for (var i = 0, n = checkboxes.length; i < n; i++) {
                        checkboxes[i].checked = false;
                    }
                }
            }

            function archiveItem() {
                var item_id = [];

                for (var i = 0, n = checkboxes.length; i < n; i++) {
                    if (checkboxes[i].checked == true) {
                        item_id.push(checkboxes[i].value);
                    }
                }
                if (confirm("Move to archive? Press 'OK' to continue")) {
                    $.ajax({
                        type: "get",
                        url: "admin_displayitem.php",
                        data: {
                            'archive': true,
                            'item_id': item_id
                        },
                        cache: false,
                        success: function(html) {
                            alert('Updated');
                            location.href = 'admin_displayitem.php';
                        }
                    });

                    //alert("Updated");
                } else {}

                return false;
            }

            function deleteItem() {
                if (confirm("Delete permenantly? Press 'OK' to continue")) {
                    alert("Not working yet");
                } else {

                }

            }
        </script>

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