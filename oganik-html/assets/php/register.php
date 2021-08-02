<?php
  // Include config file
  require_once "config.php";
 
  // Define variables and initialize with empty values
  $username = $password = $confirm_password = "";
  $username_err = $password_err = $confirm_password_err = "";
 
  // Processing form data when form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") { // $_SERVER["REQUEST_METHOD"] Returns the request method used to access the page (such as POST)
 
    // Validate username
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
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        
        // Prepare an insert statement
        $sql = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
         
        
        if (mysqli_query($link, $sql)) {
          echo "New record created successfully";
          header("location: login.php");

        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($link);

        }
    }
    // Close connection
    mysqli_close($link);
  }

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form 
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); /* $_SERVER["PHP_SELF"] Returns the filename of the currently executing script */ ?>" 
          method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
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
</body>
</html>