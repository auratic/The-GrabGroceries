    <?php

    include 'admin_header.php';

    if (isset($_GET["active"])) {
        $category_id = $_GET["category_id"];

        $date = date('Y-m-d H:i:s');
        $activity_sql = "INSERT INTO admin_activity (user_id, activity, activity_time, target) VALUES (" . $_SESSION["userid"] . ", 'Deactivate category', '$date', $category_id)";
        $sql = "UPDATE category SET category_status = 'Inactive' WHERE category_id = " . $category_id;

        if (mysqli_query($link, $sql)) {

            echo "<script>alert('Updated');</script>";
            mysqli_query($link, $activity_sql);
        } else {
            echo "<script>alert('Some error occured');</script>";
        }
    }

    if (isset($_GET["inactive"])) {
        $category_id = $_GET["category_id"];

        $date = date('Y-m-d H:i:s');
        $activity_sql = "INSERT INTO admin_activity (user_id, activity, activity_time, target) VALUES (" . $_SESSION["userid"] . ", 'Activate category', '$date', '$category_id')";

        $sql = "UPDATE category SET category_status = 'Active' WHERE category_id = " . $category_id;


        if (mysqli_query($link, $sql)) {
            echo "<script>
                Swal.fire(
                    'Good job!',
                    'You clicked the button!',
                    'success'
                )
              </script>";
            mysqli_query($link, $activity_sql);
        } else {
            echo "<script>alert('Some error occured');</script>";
        }
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

    if(isset($_GET["save"])) {

        
        $sql = "SELECT category_name FROM category WHERE category_name = '" . $_GET["category"] . "'";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);

        if(empty($_GET["category"])) {
            echo "
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Empty input field !'
            });
            </script>";
        } else if (mysqli_num_rows($result) > 0) {

            if ($row["category_name"] != $_GET["cur_category"]) {
                echo "
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Category name is taken !'
                });
                </script>";

            } else {
                
                echo "
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No name changed'
                });
                </script>";

            }

        } else {

            $sql = "UPDATE category SET category_name = '" .ucwords($_GET["category"]). "' WHERE category_id = " . $_GET["id"];
            if(mysqli_query($link, $sql)) {
                echo "
                <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: 'Category name updated!'
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
                                                    <form method="GET" action="#">

                                                        <input type="hidden" name="id" value="'.$row['category_id'].'">
                                                        <input type="hidden" name="cur_category" value="'.$row['category_name'].'">
                                                        <td><p>' . $row['category_id'] . '</p></td>

                                                        <td>
                                                            <p id="p-' . $row['category_id'] . '">' . $row['category_name'] . '</p>
                                                            <input name="category" id="text-' . $row['category_id'] . '" style="display:none; max-height: 30px; min-height: 30px;" value="' . $row['category_name'] . '">
                                                        </td>

                                                        <td><p>' . $no_of_item . '</p></td>
                                                        <td style="display: flex;
                                                                justify-content: space-evenly;
                                                                align-items: center;">

                                                            <button id="save-' . $row['category_id'] . '" name="save" type="submit" class="btn btn-primary" style="display:none">Save</button>
                                                            <button id="cancel-' . $row['category_id'] . '" type="button" class="btn btn-primary" style="display:none" onclick="offEdit(' . $row['category_id'] . ')">Cancel</button>

                                                            ';

                                                            if($row['category_name'] == "Not Set") {

                                                                echo '
                                                            <button id="edit-' . $row['category_id'] . '" type="button" class="btn btn-primary" disabled> Edit </button>
                                                            <button class="btn btn-info btn-sm" onclick="return setInactive(' . $row['category_id'] . ');" disabled> Deactivate </button>';

                                                            } else {

                                                                echo '
                                                            <button id="edit-' . $row['category_id'] . '" type="button" class="btn btn-primary edit-button" onclick="onEdit(' . $row['category_id'] . ')" /> Edit </button>
                                                            <button class="btn btn-info btn-sm" onclick="return setInactive(' . $row['category_id'] . ');" > Deactivate</button>';
                                                            
                                                            }
                                                            echo '
                                                        </td>
                                                    </form>
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

                                                    $count_sql = "SELECT * from item WHERE category_id = '" . $row['category_id'] . "'";
                                                    $count_result = mysqli_query($link, $count_sql);
                                                    $no_of_item = mysqli_num_rows($count_result);

                                                    echo '
                                                   
                                                <tr>
                                                <form method="GET" action="#">

                                                    <input type="hidden" name="id" value="'.$row['category_id'].'">
                                                    <input type="hidden" name="cur_category" value="'.$row['category_name'].'">
                                                    <td><p>' . $row['category_id'] . '</p></td>

                                                    <td>
                                                        <p id="p-' . $row['category_id'] . '">' . $row['category_name'] . '</p>
                                                        <input name="category" id="text-' . $row['category_id'] . '" style="display:none; max-height: 30px; min-height: 30px;" value="' . $row['category_name'] . '">
                                                    </td>

                                                    <td><p>' . $no_of_item . '</p></td>
                                                    <td style="display: flex;
                                                            justify-content: space-evenly;
                                                            align-items: center;">

                                                        <button id="save-' . $row['category_id'] . '" name="save" type="submit" class="btn btn-primary" style="display:none">Save</button>
                                                        <button id="cancel-' . $row['category_id'] . '" type="button" class="btn btn-primary" style="display:none" onclick="offEdit(' . $row['category_id'] . ')">Cancel</button>

                                                        ';

                                                        if($row['category_name'] == "Not Set") {

                                                            echo '
                                                        <button id="edit-' . $row['category_id'] . '" type="button" class="btn btn-primary" disabled> Edit </button>
                                                        <button class="btn btn-info btn-sm" onclick="return setInactive(' . $row['category_id'] . ');" disabled> Activate </button>';

                                                        } else {

                                                            echo '
                                                        <button id="edit-' . $row['category_id'] . '" type="button" class="btn btn-primary edit-button" onclick="onEdit(' . $row['category_id'] . ')" /> Edit </button>
                                                        <button class="btn btn-info btn-sm" onclick="return setActive(' . $row['category_id'] . ');" > Activate</button>';
                                                        
                                                        }
                                                        echo '
                                                    </td>
                                                </form>
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

                                        <form action="#" method="GET">

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

    <!-- template js -->
    <script src="assets/js/organik.js"></script>
    <script>
        if (window.performance) {
            console.info("window.performance works fine on this browser");
        }
        if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
            location.href = "admin_category.php";
        } else {}

        function setInactive(id) {

            Swal.fire({
                title: 'Deactivate this category ?',
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
                            'category_id': id
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
            });

            return false;
        }

        function setActive(id) {

            Swal.fire({
                title: 'Activate this category ?',
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
                            'category_id': id
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
            });

            return false;
        }

        function onEdit(id) {
            document.getElementById("p-" + id).style.display = "none";
            document.getElementById("text-" + id).style.display = "block";

            document.getElementById("edit-" + id).style.display = "none";
            document.getElementById("save-" + id).style.display = "block";
            document.getElementById("cancel-" + id).style.display = "block";


            $( ".edit-button" ).prop('disabled', true);
        }

        function offEdit(id) {
            document.getElementById("p-" + id).style.display = "block";
            document.getElementById("text-" + id).style.display = "none";

            document.getElementById("edit-" + id).style.display = "block";
            document.getElementById("save-" + id).style.display = "none";
            document.getElementById("cancel-" + id).style.display = "none";

            $( ".edit-button" ).prop('disabled', false);
        }
    </script>
    </body>

    </html>