<?php

include 'cust_header.php';

if (!isset($_SESSION["loggedin"])) {
    echo "
        <script>
        Swal.fire({
            title: '".$lang['error']."',
            text: 'Please log in.',
            icon: 'error'
        }).then(function() {
        location.href = 'login.php'
        })
        </script>";
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname_err = $lname_err = $phone_err = $email_err = "";


    /*if (empty($_POST["fname"])) {
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
    }*/

    if (empty($_POST["phone"])) {
        $phone_err = "Phone number is required";
    } 
    else if (!preg_match('/^(\+?601)[0|1|2|3|4|6|7|8|9]\-*[0-9]{7,8}$/', $_POST["phone"]))
    {
        $phone_err = "Please enter valid phone number (60123456789)";
    } 
    else 
    {
        $new_phone = $_POST["phone"];
    }

    /*$new_email = test_input($_POST["email"]);

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
    }*/

    if (empty($phone_err)) {
        $sql = "
            UPDATE users SET
            phone = '$new_phone'
            WHERE user_id = " . $_SESSION["userid"];

        if (mysqli_query($link, $sql)) {
            echo "
                <script>
                    Swal.fire({
                        title: '".$lang['success']."',
                        text: '".$lang['updated']."',
                        icon: 'success'
                    }).then(function() {
                    location.href = 'cust_accdetails.php'
                    })
                </script>";
        } else {
            echo "
                <script>
                    alert('Errors occur!!!')
                    location.href = 'cust_accdetails.php'
                </script>";
        }
    }
}
?>

<!-- :::::::::: Profile :::::::::: -->
<?php include 'cust_profile_layout.php' ?>
<div class="col-xl-10 col-md-10">

    <div class="tab-content my-account-tab" id="pills-tabContent">
        <div class="#" id="pills-account" aria-labelledby="pills-account-tab">
            <div class="my-account-details account-wrapper">
                <h4 class="account-title"><?php echo $lang['accd']?></h4>
                <div class="account-details">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); /* $_SERVER["PHP_SELF"] Returns the filename of the currently executing script */ ?>" method="post">
                                <div class="row">

                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <span><b><?php echo $lang['email']?></b></span>
                                            <input type="text" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" name="email" placeholder="<?php echo $email ?>" style="width:100%" value="" disabled>
                                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <span><b><?php echo $lang['fname']?></b></span>
                                            <input type="text" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" name="fname" placeholder="<?php echo $fname ?>" style="width:100%" value="" disabled>
                                            <span class="invalid-feedback"><?php echo $fname_err; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <span><b><?php echo $lang['lname']?></b></span>
                                            <input type="text" class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" name="lname" placeholder="<?php echo $lname ?>" style="width:100%" value="" disabled>
                                            <span class="invalid-feedback"><?php echo $lname_err; ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <span><b><?php echo $lang['tel']?></b><i></i></span>
                                            <input type="text" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" name="phone" placeholder="<?php echo $phone ?>  " style="width:100%" value="">
                                            <span class="invalid-feedback"><?php echo $phone_err; ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <input type="submit" name="save" class="btn btn-primary" value="Save">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <a href="index.php">
                                <img src="assets/images/Logo6.png" style="width: 100%; object-fit: contain; border-radius: 25px;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div><!-- :::::::::: End My Account Section :::::::::: -->
</div>
</div>
</main>

<?php include 'cust_footer.php'; ?>