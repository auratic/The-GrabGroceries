<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Categories || TheGrabGroceries</title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicons/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicons/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicons/favicon-16x16.png" />
    <link rel="manifest" href="assets/images/favicons/site.webmanifest" />
    <meta name="description" content="Agrikon HTML Template For Agriculture Farm & Farmers" />

    <!-- Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    </style>
</head>

<body>
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

    if (isset($_GET["active"])) {
        $category_id = $_GET["category_id"];

        $date = date('Y-m-d H:i:s');
        $activity_sql = "INSERT INTO admin_activity (user_id, activity, activity_time, target) VALUES (" . $_SESSION["userid"] . ", 'Deactivate category', '$date', '";

        for ($i = 0; $i < count($category_id); $i++) {
            $sql = "UPDATE category SET category_status = 'Inactive' WHERE category_id = " . $category_id[$i];

            if ($i < 1) {
                $activity_sql .= $category_id[$i];
            } else {
                $activity_sql .= "," . $category_id[$i];
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

    if (isset($_GET["inactive"])) {
        $category_id = $_GET["category_id"];

        $date = date('Y-m-d H:i:s');
        $activity_sql = "INSERT INTO admin_activity (user_id, activity, activity_time, target) VALUES (" . $_SESSION["userid"] . ", 'Activate category', '$date', '";

        for ($i = 0; $i < count($category_id); $i++) {
            $sql = "UPDATE category SET category_status = 'Active' WHERE category_id = " . $category_id[$i];

            if ($i < 1) {
                $activity_sql .= $category_id[$i];
            } else {
                $activity_sql .= "," . $category_id[$i];
            }

            if (mysqli_query($link, $sql)) {
                echo "<script>
                Swal.fire(
                    'Good job!',
                    'You clicked the button!',
                    'success'
                )
              </script>";
            } else {
                echo "<script>alert('Some error occured');</script>";
            }
        }
        $activity_sql .= "')";
        mysqli_query($link, $activity_sql);
    }

    $category = $category_err = "";

    if (isset($_GET["add-category"])) {

        $sql = "SELECT * FROM category WHERE category_name = '" . $_GET["category-name"] . "'";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            $category_err = "Category name is taken";

            echo "
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Category name is taken!'
            });
            </script>";
        } else if (empty($_GET["category-name"])) {

            $category_err = "Input is empty";

            echo "
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Input field is empty!'
            });
            </script>";
        } else {
            $category = ucwords($_GET["category-name"]);
        }

        if (empty($category_err)) {
            $sql = "INSERT INTO category (category_name, category_status) VALUES ('$category', 'Active')";

            if (mysqli_query($link, $sql)) {
                echo "<script>
                Swal.fire({
                    title: 'Success',
                    text: 'New category added!',
                    icon: 'success'
                })
              </script>";
            } else {

                echo "
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error accessing database...'
                });
                </script>";
            }
        }
    }
    ?>

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

                <h1>Category</h1>

            </div>

            <div class="container" style="padding:2%; background-color:rgba(255,255,255,0.8);">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="product-tab-box tabs-box" style="margin:0">
                            <ul class="tab-btns tab-buttons clearfix list-unstyled">
                                <li data-tab="#desc" class="tab-btn active-btn"><span>Active category</span></li>
                                <li data-tab="#addi__info" class="tab-btn"><span>Inactive category</span></li>
                                <li data-tab="#review" class="tab-btn"><span>Add category</span></li>
                            </ul>
                            <div class="tabs-content">
                                <div class="tab active-tab" id="desc">
                                    <div class="product-details-content">
                                        <div class="desc-content-box">
                                            <div style="display: flex; justify-content: flex-end; padding: 15px; align-items: center;">
                                                Select all <input type="checkbox" id="select-all-active" style="margin: 1%" />
                                                <button class="btn btn-primary" id="set-inactive" onclick="return setInactive()">Set Inactive</button>
                                            </div>
                                            <table class="table table-bordered table-striped table-hover table-condensed">
                                                <tr>
                                                    <th>Category ID</th>
                                                    <th>Category name</th>
                                                    <th>Number of product</th>
                                                    <th></th>
                                                </tr>
                                                <?php
                                                $sql = "SELECT * from category WHERE category_status = 'Active'";

                                                if ($result = mysqli_query($link, $sql)) {

                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                        $count_sql = "SELECT * from item WHERE category = '" . $row['category_name'] . "'";
                                                        $count_result = mysqli_query($link, $count_sql);
                                                        $no_of_item = mysqli_num_rows($count_result);

                                                        echo '
                                                <tr>
                                                    <td>' . $row['category_id'] . '</td>
                                                    <td>' . $row['category_name'] . '</td>
                                                    <td>' . $no_of_item . '</td>
                                                    <td style="display: flex;
                                                            justify-content: space-evenly;
                                                            align-items: center;">
                                                        <input type="submit" class="btn btn-primary" value="Edit" '; echo ($row['category_name'] == "Not Set") ? "disabled" : ""; echo '/>
                                                        <input type="checkbox" value="' . $row['category_id'] . '" name="select-active" />
                                                    </td>
                                                </tr>';
                                                    }
                                                }
                                                ?>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab" id="addi__info">
                                    <div class="product-details-content">
                                        <div class="desc-content-box">

                                            <div style="display: flex; justify-content: flex-end; padding: 15px; align-items: center;">
                                                Select all <input type="checkbox" id="select-all-inactive" style="margin: 1%" />
                                                <button class="btn btn-primary" id="set-active" onclick="return setActive()">Set Active</button>
                                            </div>

                                            <table class="table table-bordered table-striped table-hover table-condensed">
                                                <tr>
                                                    <th>Category ID</th>
                                                    <th>Category name</th>
                                                    <th>Number of product</th>
                                                    <th></th>
                                                </tr>
                                                <?php
                                                $sql = "SELECT * from category WHERE category_status = 'Inactive'";

                                                if ($result = mysqli_query($link, $sql)) {

                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                        $count_sql = "SELECT * from item WHERE category = '" . $row['category_name'] . "'";
                                                        $count_result = mysqli_query($link, $count_sql);
                                                        $no_of_item = mysqli_num_rows($count_result);

                                                        echo '
                                                <tr>
                                                    <td>' . $row['category_id'] . '</td>
                                                    <td>' . $row['category_name'] . '</td>
                                                    <td>' . $no_of_item . '</td>
                                                    <td style="display: flex;
                                                            justify-content: space-evenly;
                                                            align-items: center;">
                                                        <input type="submit" class="btn btn-primary" value="Edit" '; echo ($row['category_name'] == "Not Set") ? "disabled" : ""; echo '/>
                                                        <input type="checkbox" value="' . $row['category_id'] . '" name="select-inactive" />
                                                    </td>
                                                </tr>';
                                                    }
                                                }
                                                ?>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab" id="review">
                                    <div class="product-details-content">
                                        <div class="desc-content-box">

                                            <form action="" method="GET">

                                                <div class="form-group col-md-6" style="text-align: left">
                                                    <label><b>Category Name</b></label> </br>
                                                    <input type="text" name="category-name" class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>" placeholder="Fruits, Vegetables etc." value="<?php echo $category; ?>">
                                                    <span class="invalid-feedback"><?php echo $category_err; ?></span>
                                                </div>

                                                <div class="form-group col-md-6" style="text-align: left">
                                                    <input type="submit" name="add-category" class="btn btn-primary" value="Add">
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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

        if (window.performance) {
            console.info("window.performance works fine on this browser");
        }
        if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
            location.href = "admin_category.php";
        } else {
            
        }

        var active_checkboxes = document.getElementsByName('select-active');
        var inactive_checkboxes = document.getElementsByName('select-inactive');
        var select_all_active = document.getElementById("select-all-active");
        var select_all_inactive = document.getElementById("select-all-inactive");

        select_all_active.onclick = () => {

            if (select_all_active.checked) {
                //console.log("yes")
                for (var i = 0, n = active_checkboxes.length; i < n; i++) {
                    active_checkboxes[i].checked = true;
                }
            } else {
                //console.log("no")
                for (var i = 0, n = active_checkboxes.length; i < n; i++) {
                    active_checkboxes[i].checked = false;
                }
            }
        }

        select_all_inactive.onclick = () => {

            if (select_all_inactive.checked) {
                //console.log("yes")
                for (var i = 0, n = inactive_checkboxes.length; i < n; i++) {
                    inactive_checkboxes[i].checked = true;
                }
            } else {
                //console.log("no")
                for (var i = 0, n = inactive_checkboxes.length; i < n; i++) {
                    inactive_checkboxes[i].checked = false;
                }
            }
        }

        function setInactive() {
            var category_id = [];

            for (var i = 0, n = active_checkboxes.length; i < n; i++) {
                if (active_checkboxes[i].checked == true) {
                    category_id.push(active_checkboxes[i].value);
                }
            }

            Swal.fire({
                title: 'Deactivate these category(s) ?',
                showCancelButton: true,
                confirmButtonText: 'Save',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "get",
                        url: "admin_category.php",
                        data: {
                            'active': true,
                            'category_id': category_id
                        },
                        cache: false,
                        success: function(html) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully Updated',
                                confirmButtonText: 'Okay',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'admin_category.php';
                                }
                            })
                        }
                    });
                }
            })

            return false;
        }

        function setActive() {
            var category_id = [];

            for (var i = 0, n = inactive_checkboxes.length; i < n; i++) {
                if (inactive_checkboxes[i].checked == true) {
                    category_id.push(inactive_checkboxes[i].value);
                }
            }

            Swal.fire({
                title: 'Activate these category(s) ?',
                showCancelButton: true,
                confirmButtonText: 'Save',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "get",
                        url: "admin_category.php",
                        data: {
                            'inactive': true,
                            'category_id': category_id
                        },
                        cache: false,
                        success: function(html) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully Updated',
                                confirmButtonText: 'Okay',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'admin_category.php';
                                }
                            })
                        }
                    });
                }
            })

            return false;
        }
    </script>
</body>

</html>
