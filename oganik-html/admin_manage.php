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
        $sql = "INSERT INTO users (email, password, mode, firstname, lastname, phone) VALUES ('$email', '$password', 'admin', '$fname', '$lname', '$phone');";

        if (mysqli_query($link, $sql)) {
            $date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO admin_activity (user_id, activity, target, activity_time) VALUES (" . $_SESSION["userid"] . ", 'add admin', '$lname $fname', '$date')";
            mysqli_query($link, $sql);

            echo "
                <script>
                    alert('New admin added');
                    location.href = 'admin_manage.php';
                </script>";
        }
    }
}
?>

<section class="">
    <div class="container admin-header" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">
        <h1>Admins</h1>
    </div>

    <div class="container admin-content" style="background-color:rgba(255,255,255,0.8); padding: 2%">
        <div class="row">
            <div class="col-sm-5">
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

            <div class="col-sm-7">
                <h4>Admin list</h4>
                <hr>
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
                                                <td>' . $row['user_id'] . '</td>
                                                <td>' . $row['firstname'] . '</td>
                                                <td>' . $row['lastname'] . '</td>
                                                <td>' . $row['email'] . '</td>
                                                <td>' . $row['phone'] . '</td>
                                            </tr>';
                        }
                    }
                    ?>
                </table>
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
</script>
<!-- template js -->
<script src="assets/js/organik.js"></script>
</body>

</html>