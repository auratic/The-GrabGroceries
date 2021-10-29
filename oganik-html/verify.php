<?php

include 'cust_header.php';

if (!isset($_SESSION["loggedin"])) {
    echo "
     <script>
       alert('Please login');
       location.href='login.php';
     </script>";
} else if ($_SESSION["verified"] == "true") {
    echo "
     <script>
       alert('This account is already verified');
       location.href='index.php';
     </script>";
}

$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

if ($pageWasRefreshed) {
    //do something because page was refreshed;
    // header("location: verify.php");
} else {
    //do nothing;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ver_err = '';

    if (empty($_POST["ver_code"])) {
        $ver_err = 'Please enter your verification code';
    } else if (trim(strtoupper($_POST["ver_code"])) != $_SESSION["ver_code"]) {
        $ver_err = 'Wrong verification code';
    }

    if (empty($ver_err)) {
        $sql = "
            UPDATE users
            SET verified = 'true'
            WHERE user_id = '" . $_SESSION["userid"] . "'";

        if (mysqli_query($link, $sql)) {
            $_SESSION["verified"] = "true";
            $_SESSION["ver_code"] = "";
            echo "
                <script>
                    Swal.fire({
                        title: 'Successful',
                        text: 'Your account has been verified.',
                        icon: 'success'
                    }).then(function() {
                    location.href = 'index.php'
                    })
                </script>";
        } else {
            echo "
            <script>
                alert('Something went wrong verifying your account');
                location.href = 'index.php'
            </script>";
        }
    }
}

$n = 6;
function getName($n)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

if (isset($_GET["message"])) {

    $_SESSION["ver_code"] = getName($n);
    $to      = "1191201218@student.mmu.edu.my"; // Send email to our user
    $subject = 'Signup | Verification'; // Give the email a subject 
    $message = '
    <html>
        <body style="
            padding:20px; 
            background-color:gray;
            width: 500px;
            height: 600px;
            color: white;"
            >
        <h1>Dear ' . $_SESSION["lname"] . ',</h1>
        <br>
        
        <p style="color: white;">Thanks for signing up with us! Here is your verification code:</p>
        <br>
        <br>

        <h1 style="
            padding:20px; 
            font-size:40px; 
            width: 400px; 
            height: 50px; 
            text-align: center;
            background-color:seagreen;
            color:white;
            border-radius:25px;
            font-family:Arial, Helvetica, sans-serif;
            margin: auto"
            >
            ' . $_SESSION["ver_code"] . '
        </h1>
        <br>
        <br>
        
        <p style="color: white;">Enjoy your stay on TheGrabGroceries website!</p>
        
        <p style="color: white;">If this is not sent by you, please ignore this email</p>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <p style="color: white;">Best Regards</p></br>
        <p style="color: white;">TheGrabGroceries Staff</p>
        </body>
    </html>
    ';

    $headers = 'From: TheGrabGroceries <thegrabgroceries@gmail.com>' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  // Set from headers
    mail($to, $subject, $message, $headers); // Send our email
}
?>


<div class="container" style="margin: auto; margin-top: 50px; padding: 20px; background-color:azure; width:80%">
    <h4 style="margin-bottom: 20px">Verify</h4>
    <p>
        Click <b>Send Verification Email</b> button to receive verification code </br>
    </p>
    <p id="try-again" style="visibility: hidden;">
        You can resend the email in <span>60</span> seconds.
    </p>

    <button type="button" class="btn btn-md btn-info" id="verify-btn" style="margin-top:20px; margin-bottom:20px">Send Verification Email</button>
    <p id="sent" style="color:crimson; margin: 0;"></p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group" style="text-align: left">
            <label><b>Please enter your verification code</b></label> </br>
            <input type="text" name="ver_code" class="form-control <?php echo (!empty($ver_err)) ? 'is-invalid' : ''; ?>" style="width:200px">
            <span class="invalid-feedback"><?php echo $ver_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Verify">
        </div>
    </form>
</div>
</div>


<script>
    var try_again = document.querySelector("#try-again");
    var verify_btn = document.querySelector("#verify-btn");
    var sent_status = document.querySelector("#sent");
    var count;

    verify_btn.onclick = () => {

        try_again.style.visibility = "visible";
        sent_status.innerHTML = "";

        var xhttp = new XMLHttpRequest();

        xhttp.open("GET", "verify.php?message=true", true);
        xhttp.send();
        xhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
                sent_status.innerHTML = "<i>Email sent. Check spam folder if you did not see the email.</i>" //this.responseText;

            } else {
                sent_status.innerHTML = "<i>Fail to send email</i>";

            }
        }

        if (document.querySelector("#try-again > span").innerHTML != -1) {

            count = setInterval(() => {
                document.querySelector("#try-again > span").innerHTML -= 1;
                verify_btn.disabled = true;

                if (document.querySelector("#try-again > span").innerHTML == -1) {
                    clearInterval(count);
                    try_again.style.visibility = "hidden";
                    document.querySelector("#try-again > span").innerHTML = 60;
                    sent_status.innerHTML = "<i>You can resend the verification email</i>";
                    verify_btn.disabled = false;

                }
            }, 1000);

        }
    }
</script>
<?php include 'cust_footer.php'; ?>