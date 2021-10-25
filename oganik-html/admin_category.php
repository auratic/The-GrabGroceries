    <?php

    include 'admin_header.php';

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

                                                    $count_sql = "SELECT * from item WHERE category_id = '" . $row['category_id'] . "'";
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
                                                        <input type="submit" class="btn btn-primary" value="Edit" ';
                                                    echo ($row['category_name'] == "Not Set") ? "disabled" : "";
                                                    echo '/>
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
                                                        <input type="submit" class="btn btn-primary" value="Edit" ';
                                                    echo ($row['category_name'] == "Not Set") ? "disabled" : "";
                                                    echo '/>
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
    </div><!-- page wrapper -->

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
