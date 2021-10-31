<?php
include 'admin_header.php';

$reset_page = "";

$sql = "SELECT * FROM users WHERE user_id = " . $_SESSION['userid'];
$result = mysqli_query($link, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $fname = $row['firstname'];
    $lname = $row['lastname'];
    $email = $row['email'];
    $phone = $row['phone'];
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST["reset_info"])) {
    $reset_page = "info";
    $fname_err = $lname_err = $phone_err = $email_err = "";


    if (empty($_POST["fname"])) {
        $fname_err = "Name is required";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", test_input($_POST["fname"]))) {
        $fname_err = "Only letters and white space allowed";
    } else {
        $new_fname = ucwords(test_input($_POST["fname"]));
    }

    if (empty($_POST["lname"])) {
        $lname_err = "Name is required";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", test_input($_POST["lname"]))) {
        $lname_err = "Only letters and white space allowed";
    } else {
        $new_lname = ucwords(test_input($_POST["lname"]));
    }

    if (empty($_POST["phone"])) {
        $phone_err = "Phone number is required";
    } else if (!preg_match('/^[0-9]{10}+$/', test_input($_POST["phone"])) && !preg_match('/^[0-9]{11}+$/', test_input($_POST["phone"])) && !preg_match('/^[0-9]{12}+$/', test_input($_POST["phone"]))) {
        $phone_err = "Please enter valid phone number";
    } else {
        $new_phone = test_input($_POST["phone"]);
    }

    $new_email = test_input($_POST["email"]);

    if (empty($_POST["email"])) {
        $email_err = "Email is required";
    } else if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", test_input($_POST["email"]))) {
        $email_err = "Invalid email format";
    } else {
        // Prepare a select statement

        $sql = "SELECT user_id FROM users WHERE email = '$new_email'";
        $result = mysqli_query($link, $sql);

        if ($new_email != $email) {

            if (mysqli_num_rows($result) > 0) {
                $email_err = "Email is taken";
            }
        }
    }

    if (empty($fname_err) && empty($lname_err) && empty($phone_err) && empty($email_err)) {
        $sql = "
            UPDATE users SET
            lastname = '$new_lname',
            firstname = '$new_fname',
            phone = '$new_phone',
            verified = 'false',
            email = '$new_email'
            WHERE user_id = " . $_SESSION["userid"];

        if (mysqli_query($link, $sql)) {
            echo "
                <script>
                    Swal.fire({
                        title: 'Successful',
                        text: 'Your details have been updated!',
                        icon: 'success'
                    }).then(function() {
                    location.href = 'admin_profile.php'
                    })
                </script>";
        } else {
            echo "
                <script>
                    Swal.fire({
                        title: 'Oops..',
                        text: 'Some error occured',
                        icon: 'error'
                    }).then(function() {
                    location.href = 'admin_profile.php'
                    })
                </script>";
        }
    }
}

$curPwd = $newPwd = $cfmPwd = "";

if (isset($_POST["reset_pass"])) {
    $reset_page = "pass";
    $cur_pass_err = $new_pass_err = $con_pass_err = "";

    $curPwd = trim($_POST["cur_pass"]);
    $newPwd = trim($_POST["new_pass"]);
    $cfmPwd = trim($_POST["con_pass"]);

    $sql = "SELECT * from users WHERE user_id=" . $_SESSION["userid"];
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    //hashing part
    $uppercase = preg_match('@[A-Z]@', $newPwd);
    $lowercase = preg_match('@[a-z]@', $newPwd);
    $number    = preg_match('@[0-9]@', $newPwd);
    $specialChars = preg_match('@[^\w]@', $newPwd);

    if (empty($curPwd)) {
        $cur_pass_err = "Please fill in the section";
    } else if (!password_verify($curPwd, $row["password"])) {
        $cur_pass_err = "Current Password is not correct";
    }

    if (empty($newPwd)) {
        $new_pass_err = "Please fill in the section";
    } else if ($curPwd === $newPwd) {
        $new_pass_err = "Password cannot be the same";
    } else if (!$uppercase || !$lowercase || !$number || !$specialChars || (strlen(trim($newPwd)) < 8)) {
        $new_pass_err = "Password should be at least 8 characters, including at least one upper case letter, one number, and one special character.";
    }

    if (empty($cfmPwd)) {
        $con_pass_err = "Please fill in the section";
    } else if ($_POST["new_pass"] != $_POST["con_pass"]) {
        $con_pass_err = "Password did not match";
    }

    if (empty($cur_pass_err) && empty($new_pass_err) && empty($con_pass_err)) {
        $sql_update_password = "UPDATE users set password= '" . password_hash($newPwd, PASSWORD_DEFAULT) . "' WHERE user_id=" . $_SESSION["userid"];

        if (mysqli_query($link, $sql_update_password)) {
            echo "
                    <script>
                        Swal.fire({
                            title: 'Successful',
                            text: 'New password updated!',
                            icon: 'success'
                        }).then(function() {
                        location.href = 'admin_profile.php'
                        })
                    </script>";


            $date = date("F j, Y, g:i a");
            $to = "1191201218@student.mmu.edu.my"; //send to our email
            $subject = "Password Changed";
            $message = '
            <html>
                <body style="
                    padding:20px; 
                    background-color:gray;
                    width: 500px;
                    height: 600px;
                    color: white;"
                    >
                <h1>Dear ' . $row['email'] . ',</h1>
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
                    Did you change your password?
                </h1>
                <br>
                <h3>
                    We notice the password for your TheGrabGroceries account was recently changed on <i>' . $date . '</i>. If this was you,
                    you can safely disregard this email.
                </h3>
                <br>
                
                <p style="color: white;">Enjoy your stay on TheGrabGroceries website!</p>
                
                <p style="color: white;">If this is not sent by you, please ignore this email</p>

                <br>
                <br>
                <br>
                <br>
                <br>

                <p style="color: white;">Best Regards,</p></br>
                <p style="color: white;">TheGrabGroceries Staff</p>
                </body>
            </html>
            ';

            $headers = 'From: TheGrabGroceries <thegrabgroceries@gmail.com>' . "\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  // Set from headers
            mail($to, $subject, $message, $headers);
        } else {
            echo "
                        <script>
                        alert('Error: " . $sql_update_password . "\n" . mysqli_error($link) . "')
                        </script>";
        }
    }
}
?>
?>

<section>
    <p id="reset_page" style="display:none"><?php echo $reset_page ?></p>
    <div class="container" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">

        <h1>Profile</h1>

    </div>

    <div class="container" style="padding:2%; background-color:rgba(255,255,255,0.8);">
        <!-- Modal Add Item -->
        <div style="display: flex; justify-content: center;">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); /* $_SERVER["PHP_SELF"] Returns the filename of the currently executing script */ ?>" method="post">

                <div id="reset-info">
                    <h2>Update Details</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <span><b>First Name</b></span>
                                <input type="text" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" name="fname" value="<?php echo $fname ?>" style="width:100%">
                                <span class="invalid-feedback"><?php echo $fname_err; ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <span><b>Last Name</b></span>
                                <input type="text" class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" name="lname" value="<?php echo $lname ?>" style="width:100%">
                                <span class="invalid-feedback"><?php echo $lname_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <span><b>Phone Number</b></span>
                                <input type="text" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" name="phone" value="<?php echo $phone ?>" style="width:100%">
                                <span class="invalid-feedback"><?php echo $phone_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span><b>Email Address</b></span>
                                <input type="text" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" name="email" value="<?php echo $email ?>" style="width:100%">
                                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <input type="submit" name="reset_info" class="btn btn-primary" value="Save">
                                <button type="button" class="btn btn-primary" onclick="resetPass()">Reset password</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="reset-pass" style="display:none;">
                    <h2>Reset Password</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <span><b>Current Password</b></span>
                                <input id="cur-pass" type="password" class="form-control <?php echo (!empty($cur_pass_err)) ? 'is-invalid' : ''; ?>" name="cur_pass" value="<?php echo $curPwd; ?>" style="width:100%">
                                <span class="invalid-feedback"><?php echo $cur_pass_err; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <span><b>New password</b></span>
                                <input id="new-pass" type="password" class="form-control <?php echo (!empty($new_pass_err)) ? 'is-invalid' : ''; ?>" onkeyup="validatePassword(this.value);" name="new_pass" value="<?php echo $newPwd; ?>" style="width:100%"><span id="msg"></span>
                                <span class="invalid-feedback"><?php echo $new_pass_err; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <span><b>Confirm password</b></span>
                                <input id="con-pass" type="password" class="form-control <?php echo (!empty($con_pass_err)) ? 'is-invalid' : ''; ?>" name="con_pass" style="width:100%">
                                <span class="invalid-feedback"><?php echo $con_pass_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <input type="checkbox" onclick="showPass()"><label style="margin: 2%; margin-top: 0;">Show password</label>
                    <script>
                        function showPass() {
                            var x = document.getElementById("new-pass");
                            var y = document.getElementById("con-pass");
                            var z = document.getElementById("cur-pass");

                            if (x.type == "password") {
                                x.type = "text";
                                y.type = "text";
                                z.type = "text";
                            } else {
                                x.type = "password";
                                y.type = "password";
                                z.type = "password";
                            }
                        }
                    </script>
                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" name="reset_pass" class="btn btn-primary" value="Save">
                                <button type="button" class="btn btn-primary" onclick="resetInfo()">View account details</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function resetInfo() {
                        document.getElementById("reset-info").style.display = "block";
                        document.getElementById("reset-pass").style.display = "none";
                    }

                    function resetPass() {
                        document.getElementById("reset-info").style.display = "none";
                        document.getElementById("reset-pass").style.display = "block";

                    }
                </script>
            </form>
        </div>
    </div>

</section>
</div> <!-- page wrapper -->

<!-- /.search-popup -->

<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

<!-- template js -->
<script src="assets/js/organik.js"></script>

<script>
    window.onload = () => {
        var reset_page = document.getElementById("reset_page").innerHTML;

        if (reset_page == "info") {

            document.getElementById("reset-info").style.display = "block";
            document.getElementById("reset-pass").style.display = "none";

        } else if (reset_page == "pass") {

            document.getElementById("reset-info").style.display = "none";
            document.getElementById("reset-pass").style.display = "block";

        }
    }

    function myFunction() {
        var x = document.getElementById("curPwd");
        var y = document.getElementById("newPwd");
        var z = document.getElementById("cfmPwd");

        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }

        if (y.type === "password") {
            y.type = "text";
        } else {
            y.type = "password";
        }

        if (z.type === "password") {
            z.type = "text";
        } else {
            z.type = "password";
        }
    }

    function validatePassword(password) {
        // Do not show anything when the length of password is zero.
        if (password.length === 0) {
            document.getElementById("msg").innerHTML = "";
            return;
        }
        // Create an array and push all possible values that you want in password
        var matchedCase = new Array();
        matchedCase.push("[$@$!%*#?&]"); // Special Charector
        matchedCase.push("[A-Z]"); // Uppercase Alpabates
        matchedCase.push("[0-9]"); // Numbers
        matchedCase.push("[a-z]"); // Lowercase Alphabates

        // Check the conditions
        var ctr = 0;
        for (var i = 0; i < matchedCase.length; i++) {
            if (new RegExp(matchedCase[i]).test(password)) {
                ctr++;
            }
        }
        // Display it
        var color = "";
        var strength = "";
        switch (ctr) {
            case 0:
            case 1:
            case 2:
                strength = " (Very Weak)";
                color = "red";
                break;
            case 3:
                strength = " (Medium)";
                color = "orange";
                break;
            case 4:
                strength = " (Strong)";
                color = "green";
                break;
        }
        document.getElementById("msg").innerHTML = strength;
        document.getElementById("msg").style.color = color;
    }
</script>
</body>

</html>