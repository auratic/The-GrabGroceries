<?php

include 'cust_header.php';

if (!isset($_SESSION["loggedin"])) {
    echo "
        <script>
        Swal.fire({
            title: 'Error',
            text: 'Please log .',
            icon: 'error'
        }).then(function() {
        location.href = 'login.php'
        })
        </script>";
}

$newPassword_err = $currentPassword_err = $confirmPassword_err = $samePassword_err = "";

if (count($_POST) > 0) {
    $newPassword_err = $currentPassword_err = $confirmPassword_err = $samePassword_err = "";

    $curPwd = $_POST["currentPassword"];
    $newPwd = $_POST["newPassword"];
    $cfmPwd = $_POST["confirmPassword"];

    $sql = "SELECT * from users WHERE user_id=" . $_SESSION["userid"];
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    //hashing part
    if (password_verify($curPwd, $row["password"])) {
        $uppercase = preg_match('@[A-Z]@', $newPwd);
        $lowercase = preg_match('@[a-z]@', $newPwd);
        $number    = preg_match('@[0-9]@', $newPwd);
        $specialChars = preg_match('@[^\w]@', $newPwd);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || (strlen(trim($newPwd)) < 8)) {
            $newPassword_err = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
        } else if ($_POST["newPassword"] != $_POST["confirmPassword"]) {
            $confirmPassword_err = "Password did not match";
        }

        if (empty($newPassword_err) && empty($currentPassword_err) && empty($confirmPassword_err)) {
            if ($curPwd == $newPwd) {
                $newPassword_err = "The new password cannot be the same as the current password.";
            } else {
                $sql_update_password = "UPDATE users set password= '" . password_hash($newPwd, PASSWORD_DEFAULT) . "' WHERE user_id=" . $_SESSION["userid"];

                if (mysqli_query($link, $sql_update_password)) {
                    echo "
                    <script>
                        Swal.fire({
                            title: 'Successful',
                            text: 'Your password have updated!',
                            icon: 'success'
                        }).then(function() {
                        location.href = 'cust_password.php'
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
    } else {
        $currentPassword_err = "Current Password is not correct";
    }
}

?>


<!-- :::::::::: Profile :::::::::: -->
<?php include 'cust_profile_layout.php' ?>
<div class="col-xl-10 col-md-10">

    <div class="tab-content my-account-tab" id="pills-tabContent">
        <div class="#" id="pills-account" aria-labelledby="pills-account-tab">
            <div class="my-account-details account-wrapper">
                <h4 class="account-title">Password Changes</h4>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); /* $_SERVER["PHP_SELF"] Returns the filename of the currently executing script */ ?>" method="post" style="text-align: left">
                    <div class="form-group">
                        <label>Current Password</label> </br>
                        <input type="password" id="curPwd" name="currentPassword" style="width: 50%;" class="form-control <?php echo (!empty($currentPassword_err)) ? 'is-invalid' : ''; ?>" required>
                        <span class="invalid-feedback"><?php echo $currentPassword_err; ?></span>
                    </div>

                    <div class="form-group">
                        <label>New Password</label><i><span id="msg"></span></i></br>
                        <input type="password" id="newPwd" name="newPassword" onkeyup="validatePassword(this.value);" style="width: 50%;" class="form-control <?php echo (!empty($newPassword_err)) ? 'is-invalid' : ''; ?>" required><br>
                        <span class="invalid-feedback"><?php echo $newPassword_err; ?></span>
                    </div>
                    <div>
                        <label>Confirm Password</label> </br>
                        <input type="password" id="cfmPwd" name="confirmPassword" style="width: 50%;" class="form-control <?php echo (!empty($confirmPassword_err)) ? 'is-invalid' : ''; ?>" required><span id="msg"></span>
                        <span class="invalid-feedback"><?php echo $confirmPassword_err; ?></span>
                    </div>

                    <div style="margin-top: 10px;">
                        <label style="cursor: pointer;"><input style="cursor: pointer;" type="checkbox" onclick="myFunction()">Show Password</label>
                    </div>

                    <div class="form-group" style="margin: 1%;">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-secondary ml-2" value="Reset" style="outline: none">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div><!-- :::::::::: End My Account Section :::::::::: -->
</div>
</div>
</div>
</main>

<script>
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

<?php include 'cust_footer.php'; ?>