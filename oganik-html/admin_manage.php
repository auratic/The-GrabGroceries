<?php

include 'admin_header.php';

// Define variables and initialize with empty values
$email = $fname = $lname = $password = $confirm_password = $phone = "";
$fname_err = $lname_err = $email_err = $password_err = $confirm_password_err = $phone_err = "";
$registering = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registering = "true";

    if (empty($_POST["phone"])) {
        $phone_err = "Phone number is required";
    } else if (!preg_match('/^[0-9]{10}+$/', $_POST["phone"]) && !preg_match('/^[0-9]{11}+$/', $_POST["phone"]) && !preg_match('/^[0-9]{12}+$/', $_POST["phone"])) {
        $phone_err = "Please enter valid phone number";
    } else {
        $phone = $_POST["phone"];
    }

    // Validate first name
    if (empty($_POST["fname"])) {
        $fname_err = "Name is required";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", test_input($_POST["fname"]))) {
        $fname_err = "Only letters and white space allowed";
    } else {
        $fname = ucwords(test_input($_POST["fname"]));
    }

    // Validate last name
    if (empty($_POST["lname"])) {
        $lname_err = "Name is required";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", test_input($_POST["lname"]))) {
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
        } else {
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
        $sql = "INSERT INTO users (email, password, mode, firstname, lastname, phone, verified) VALUES ('$email', '".password_hash($password, PASSWORD_DEFAULT)."', 'admin', '$fname', '$lname', '$phone', 'true');";

        if (mysqli_query($link, $sql)) {
            $date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO admin_activity (user_id, activity, target, activity_time) VALUES (" . $_SESSION["userid"] . ", 'add admin', '$lname $fname', '$date')";
            mysqli_query($link, $sql);

            $date = date("F j, Y, g:i a");
            $to = "1191201218@student.mmu.edu.my"; //send to our email
            $subject = "Hi admin!";
            $message = '
                <html>
                    <body style="
                        padding:20px; 
                        background-color:gray;
                        width: 500px;
                        height: 600px;
                        color: white;"
                        >
                    <h1>Dear '.$lname.' '. $fname .',</h1>
                    <br>

                    <h1 style="
                        padding:20px; 
                        font-size:25px; 
                        width: 400px; 
                        height: 40px; 
                        text-align: center;
                        background-color:seagreen;
                        color:white;
                        border-radius:25px;
                        font-family:Arial, Helvetica, sans-serif;
                        margin: auto"
                        >
                        Admin Registration Successful
                    </h1>
                    <br>
                    <h3>
                        Congratulations, you have been added as TheGrabGroceries admin on  <i>' . $date . '</i>.
                    </h3>
                    <br>
                    
                    <p style="color: white;">
                        Here is your login details:<br>
                        Email: '.$email.'<br>
                        Password: '.$password.'<br>
                    </p>

                    <br>
                    <br>
                    <br>
                    <br>
                    <br>

                    <p style="color: white;">This is auto generated email</p></br>
                    </body>
                </html>
                ';

            $headers = 'From: TheGrabGroceries <thegrabgroceries@gmail.com>' . "\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  // Set from headers
            mail($to, $subject, $message, $headers);

            
            echo "
                <script>
                Swal.fire({
                    icon: 'success',
                    title: 'New admin added',
                    confirmButtonText: 'Okay',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = 'admin_manage.php';
                    }
                })
                </script>";
        }
    }
}

if (isset($_GET["deactivate"])) {
    $user_id = $_GET["user_id"];

    $sql = "UPDATE users SET mode = 'deactivate' where user_id = $user_id";

    if (mysqli_query($link, $sql)) {
        header("Location: admin_manage.php");
        die();
    }
}

if (isset($_GET["activate"])) {
    $user_id = $_GET["user_id"];

    $sql = "UPDATE users SET mode = 'admin' where user_id = $user_id";

    if (mysqli_query($link, $sql)) {
        header("Location: admin_manage.php");
        die();
    }
}

?>

<section class="">
    <div class="container admin-header" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">
        <h1>Admins</h1>
    </div>

    <div class="container admin-content" style="background-color:rgba(255,255,255,0.8); padding: 2%">
        <div class="row">
            <div class="col-sm-4">
                <div>
                    <h4>Admin's Activities</h4>
                    <hr>
                </div>

                <div id="feed" style="
                                background-color: azure;
                                max-height: 50vh;
                                width: 100%;
                                overflow: scroll;
                                border: solid lightgreen 1px;">

                    <?php

                    $sql = "SELECT * FROM admin_activity 
                                            INNER JOIN users ON admin_activity.user_id = users.user_id";

                    if ($result = mysqli_query($link, $sql)) {

                        while ($row = mysqli_fetch_assoc($result)) {
                            switch ($row["activity"]) {
                                case 'login':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") <b>logged in</b> at " . $row["activity_time"] . "</p>";
                                    break;
                                case 'add item':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") 
                                                        <b>added a product</b> (item_name: " . $row["target"] . ") 
                                                        at " . $row["activity_time"] . "</p>";
                                    break;
                                case 'update item':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") 
                                                        <b>updated product</b> (item_id: " . $row["target"] . ") 
                                                        at " . $row["activity_time"] . "</p>";
                                    break;
                                case 'archive item':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") 
                                                        <b>archived product</b> (item_id: " . $row["target"] . ") 
                                                        at " . $row["activity_time"] . "</p>";
                                    break;
                                case 'restore item':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") 
                                                        <b>restored product</b> (item_id: " . $row["target"] . ") 
                                                        at " . $row["activity_time"] . "</p>";
                                    break;
                                case 'delete item':
                                    break;
                                case 'update receipt':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") 
                                                        <b>update receipt</b> (receipt_id: " . $row["target"] . ") 
                                                        at " . $row["activity_time"] . "</p>";
                                    break;
                                case 'add admin':
                                    echo "<p>" . $row['lastname'] . " " . $row['firstname'] . "(user_id: " . $row['user_id'] . ") 
                                                        <b>added a new admin</b> (" . $row["target"] . ") 
                                                        at " . $row["activity_time"] . "</p>";
                                    break;
                            }
                        }
                    }

                    ?>

                </div>
            </div>

            <div class="col-sm-8">
                <!--
                
                -->
                <div class="product-tab-box tabs-box" style="margin:0">
                    <ul class="tab-btns tab-buttons clearfix list-unstyled">
                        <li data-tab="#desc" class="tab-btn active-btn"><span>Active admin</span></li>
                        <li data-tab="#addi__info" class="tab-btn"><span>Inactive admin</span></li>
                    </ul>
                    <div class="tabs-content">
                        <div class="tab active-tab" id="desc">
                            <div class="product-details-content" style="padding: 20px 30px;">
                                <div class="desc-content-box">
                                    <!--
                                    <div class="row">
                                        <div class="col-sm-8">
                                        </div>
                                        <div class="col-sm-4" style="
                                        display: flex;
                                        align-items: center;
                                        justify-content: flex-end;">
                                            <div class="form-group" style="text-align: left; margin-right: 1rem">
                                                <button class="btn btn-info btn-sm" onclick="return addAdmin();">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    -->
                                    <table id="dtBasicExample" class="display">
                                        <thead>
                                            <tr>
                                                <th>User ID</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $sql = "SELECT * FROM users WHERE mode = 'admin'";

                                        if ($result = mysqli_query($link, $sql)) {

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '
                                            <tr>
                                                <td>' . $row['user_id'] . '</td>
                                                <td>' . $row['firstname'] . '</td>
                                                <td>' . $row['lastname'] . '</td>
                                                <td>' . $row['email'] . '</td>
                                                <td>' . $row['phone'] . '</td>
                                                <td>
                                                    <div class="form-group" style="text-align: left">
                                                        <button class="btn btn-info btn-sm" onclick="return deactivateAdmin(' . $row['user_id'] . ');">Deactivate</button>
                                                    </div>
                                                </td>
                                            </tr>';
                                            }
                                        }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>User ID</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="tab" id="addi__info">
                            <div class="product-details-content" style="padding: 20px 30px;">
                                <div class="desc-content-box">

                                    <table id="dtTableInactive" class="display">
                                        <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $sql = "SELECT * FROM users WHERE mode = 'deactivate'";

                                        if ($result = mysqli_query($link, $sql)) {

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '
                                        <tr>
                                            <td>' . $row['user_id'] . '</td>
                                            <td>' . $row['firstname'] . '</td>
                                            <td>' . $row['lastname'] . '</td>
                                            <td>' . $row['email'] . '</td>
                                            <td>' . $row['phone'] . '</td>
                                            <td>
                                                <div class="form-group" style="text-align: left">
                                                    <button class="btn btn-info btn-sm" onclick="return activateAdmin(' . $row['user_id'] . ');">Activate</button>
                                                </div>
                                            </td>
                                        </tr>';
                                            }
                                        }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>User ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>

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

<div class="modal" id="add-modal" role="dialog">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header" style="background-color:var(--thm-base)">
                <h4 class="modal-title"><span style="color:white;">Add Admin</span></h4>
                <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
            </div>
            <!-- Modal Header-->

            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); /* $_SERVER["PHP_SELF"] Returns the filename of the currently executing script */ ?>" method="post" style="text-align: left">
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
                        <input id="pass" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>

                    <div class="form-group" style="text-align: left">
                        <label>Confirm Password</label> </br>
                        <input id="con-pass" type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>

                    <input type="checkbox" onclick="showPass()"><label style="margin: 2%; margin-top: 0;">Show password</label>
                    <script>
                        function showPass() {
                            var x = document.getElementById("pass");
                            var y = document.getElementById("con-pass");

                            if(x.type == "password") {
                                x.type = "text";
                                y.type = "text";
                            } else {
                                x.type = "password";
                                y.type = "password";
                            }
                        }
                    </script>

                    <div class="form-group">
                        <input type="submit" name="add" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
            <!-- Modal Body-->

            <div class="modal-footer" style="background-color:var(--thm-base)">
                <button type="button" class="btn btn-danger" onclick="return closeModal()">Cancel</button>
            </div>
            <!-- Modal Footer-->
        </div>
        <!-- Modal content-->
    </div>
</div>
<!--Modal-->

<!-- /.search-popup -->
<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>
<p id="registering"><?php echo $registering ?></p>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    if (document.getElementById("registering").innerHTML != "") {
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

    function deactivateAdmin(id) {

        Swal.fire({
            title: 'Deactivate this admin ?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: "admin_manage.php",
                    data: {
                        'deactivate': true,
                        'user_id': id
                    },
                    cache: false,
                    success: function(html) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully Updated',
                            confirmButtonText: 'Okay',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'admin_manage.php';
                            }
                        })
                    }
                });
            }
        });
        return false;
    }

    function activateAdmin(id) {

        Swal.fire({
            title: 'Activate this admin ?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: "admin_manage.php",
                    data: {
                        'activate': true,
                        'user_id': id
                    },
                    cache: false,
                    success: function(html) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully Updated',
                            confirmButtonText: 'Okay',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'admin_manage.php';
                            }
                        })
                    }
                });
            }
        });
        return false;
    }
    $(document).ready(function() {
        var table = $('#dtBasicExample').DataTable({
            "scrollY": "50vh",
            "scrollCollapse": true,
            "pagingType": "full_numbers",
            dom: 'Bfrtip',
            buttons: [
                'pdf',
                {
                text: 'Add admin',
                action: function ( e, dt, node, config ) {
                    $('#add-modal').fadeIn();
                }
            }
            ],
        });

        var table = $('#dtTableInactive').DataTable({
            "scrollY": "50vh",
            "scrollCollapse": true,
            "pagingType": "full_numbers",
            dom: 'Bfrtip',
            buttons: [
                'pdf'
            ],
        });
        //table.buttons().container()
        //    .appendTo('#dtBasicExample_wrapper .col-md-6:eq(0)');
    });
</script>
<!-- template js -->
<script src="assets/js/organik.js"></script>
</body>

</html>