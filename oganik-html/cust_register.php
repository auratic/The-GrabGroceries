<?php

include 'cust_header.php';

// Define variables and initialize with empty values
$email = $fname = $lname = $password = $confirm_password = "";
$fname_err = $lname_err = $email_err = $password_err = $confirm_password_err = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") { // $_SERVER["REQUEST_METHOD"] Returns the request method used to access the page (such as POST)

    // Validate username
    /*
    if (empty(trim($_POST["username"]))) {

        $username_err = "Please enter a username.";

    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {

        $username_err = "Username can only contain letters, numbers, and underscores.";

    } else {
        // Prepare a select statement

        $sql = "SELECT id FROM user WHERE username = '" . trim($_POST["username"]) . "'";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            $username_err = "Username is taken";
        } else {
            $username = trim($_POST["username"]);
        }
    }
    */

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
    } else if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", test_input($_POST["email"]))) {
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
    $password = $_POST["password"];

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (empty($_POST["password"])) {
        $password_err = "Please enter a password.";
    } elseif (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        $password_err = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
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
    if (empty($lname_err) && empty($fname_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        // Prepare an insert statement
        $sql = "INSERT INTO users (email, password, mode, firstname, lastname) VALUES ('$email', '$hash', 'customer', '$fname', '$lname');";
        $sql_get_id = "SELECT user_id FROM users WHERE email = '$email' and password = '$hash'";

        if (mysqli_query($link, $sql)) {

            if ($id_result = mysqli_query($link, $sql_get_id)) {

                while ($row = mysqli_fetch_assoc($id_result)) {

                    $sql_insert_address = "INSERT INTO cust_address (user_id) VALUES (" . $row['user_id'] . ")";
                    $sql_insert_card = "INSERT INTO cust_card (user_id) VALUES (" . $row['user_id'] . ")";

                    if (mysqli_query($link, $sql_insert_address)) {

                        if (mysqli_query($link, $sql_insert_card)) {

                            echo "
                            <script>
                                Swal.fire({
                                    title: 'Successful',
                                    text: 'New account created',
                                    icon: 'success'
                                }).then(function() {
                                location.href = 'login.php'
                                })
                            </script>";
                        } else {
                            echo "
                            <script>
                            alert('Error: " . $sql_insert_card . "\n" . mysqli_error($link) . "')
                            </script>";
                        }
                    } else {
                        echo "
                        <script>
                          alert('Error: " . $sql_insert_address . "\n" . mysqli_error($link) . "')
                        </script>";
                    }
                }
            } else {
                echo "
                <script>
                  alert('Error: " . $sql_get_id . "\n" . mysqli_error($link) . "')
                </script>";
            }
        } else {
            echo "
          <script>
            alert('Error: " . $sql . "\n" . mysqli_error($link) . "')
          </script>";
        }
    }
    // Close connection
    mysqli_close($link);
}

?>


<style>
    body {
            font: 14px sans-serif;
            background-image: url("https://cdn.wallpapersafari.com/68/37/Gwgjo6.jpg")
        }
</style>

<div class="signup-form container loginbox">
    <h2>Sign Up</h2>
    <p>Please fill this form to create an account.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); /* $_SERVER["PHP_SELF"] Returns the filename of the currently executing script */ ?>" method="post" style="text-align: left">
        <div class="form-group">
            <label>E-mail</label> </br>
            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="grocery@gmail.com">
            <span class="invalid-feedback"><?php echo $email_err; ?></span>
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
            <input type="password" name="password" onkeyup="validatePassword(this.value);" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>"><span id="msg"></span>
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group" style="text-align: left">
            <label>Confirm Password</label> </br>
            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>

<script>
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
                strength = " Very Weak";
                color = "red";
                break;
            case 3:
                strength = " Medium";
                color = "orange";
                break;
            case 4:
                strength = " Strong";
                color = "green";
                break;
        }
        document.getElementById("msg").innerHTML = strength;
        document.getElementById("msg").style.color = color;
    }

    function ValidateEmail(email) {

    }
</script>


<?php include 'cust_footer.php'; ?>