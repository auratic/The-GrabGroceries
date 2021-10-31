<?php

include 'cust_header.php';


if (isset($_SESSION["loggedin"])) {
    echo "
        <script>
        location.href = 'login.php'
        </script>";
}

if(isset($_GET["verify"])) {

    $user_id = $_GET["id"];
    if($result = mysqli_query($link, "SELECT * FROM users WHERE user_id = $user_id")) {
        while($row = mysqli_fetch_assoc($result)) {
            $lname = $row["lastname"];
            $fname = $row["firstname"];
        }
    }

} else {
    echo "
    <script>
        location.href = 'index.php'
    </script>";

}

if (isset($_POST["ver_code"])) {
    $ver_err = '';

     if(!isset($_SESSION["ver_code"])){
        echo "
        <script>
            Swal.fire({
                title: 'Error..',
                text: 'You have not retrieved your PIN yet !',
                icon: 'warning'
            }).then(function() {
                location.href = 'verify.php?verify&id=$user_id'
            })
        </script>";
    } else if (empty($_POST["ver_code"])) {
        echo "
        <script>
            Swal.fire({
                title: 'Error..',
                text: 'Please enter verification code',
                icon: 'error'
            }).then(function() {
                location.href = 'verify.php?verify&id=$user_id'
            })
        </script>";
    } else if (trim(strtoupper($_POST["ver_code"])) != $_SESSION["ver_code"]) {
        echo "
        <script>
            Swal.fire({
                title: 'Error..',
                text: 'Wrong PIN entered',
                icon: 'error'
            }).then(function() {
            location.href = 'verify.php?verify&id=$user_id'
            })
        </script>";
    } else {
        $sql = "
            UPDATE users
            SET verified = 'true'
            WHERE user_id = $user_id";

        if (mysqli_query($link, $sql)) {
            
            $_SESSION["ver_code"] = "";

            echo "
                <script>
                    Swal.fire({
                        title: 'Successful',
                        text: 'Your account has been verified.',
                        icon: 'success'
                    }).then(function() {
                    location.href = 'login.php'
                    })
                </script>";
        } else {
            echo "
            <script>
            Swal.fire({
                title: 'Error..',
                text: 'Fail to update to database',
                icon: 'error'
            }).then(function() {
            location.href = 'verify.php?verify&id=$user_id'
            })
        </script>";
        }
    }
}

?>
<style>
    body {
            font: 14px sans-serif;
            background-image: url("https://cdn.wallpapersafari.com/68/37/Gwgjo6.jpg")
        }
</style>
<div class="container" style="margin: auto; margin-top: 50px; margin-bottom: 50px; padding: 20px; background-color:rgba(255,255,255,0.8); width:80%">

    <h1 style="margin-bottom: 20px">Verify</h1>
    <p style="margin:0">
        Click <b style="color:crimson">Send Verification Email</b> button to receive verification code </br>
    </p>
    <button type="button" class="btn btn-md btn-info" id="verify-btn" style="margin-top:20px; margin-bottom:20px">Send Verification Email</button>
    <p id="try-again" style="display:none">
        You can resend the email in <span>60</span> seconds.
    </p>
    <p id="sent" style="color:crimson; margin: 0; display:none"></p>

    <hr>

    <form action="#" method="post">
        <div class="form-group" style="text-align: left">
            <label><b>Please enter your verification code</b></label> </br>
            <input type="text" name="ver_code" class="form-control <?php echo (!empty($ver_err)) ? 'is-invalid' : ''; ?>" style="width:200px" autocomplete="off"> 
            <span class="invalid-feedback"><?php echo $ver_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Verify">
            <input type="button" class="btn btn-danger" value="Logout" onclick="location.href = 'logout.php';">
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

        try_again.style.display = "block";
        sent_status.style.display = "none";

        /*
        var xhttp = new XMLHttpRequest();

        xhttp.open("GET", "send_verify.php?message=true&lname=<?php echo $lname ?>&fname=<?php echo $fname ?>", true);
        xhttp.send();
        xhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
                sent_status.style.display = 'block';
                sent_status.innerHTML = "<i>Email sent. Check spam folder if you did not see the email.</i>" //this.responseText;

            } else {
                sent_status.style.display = 'block';
                sent_status.innerHTML = "<i>Fail to send email</i>";

            }
        }
        */
        $.ajax({
                type: "get",
                url: "send_verify.php",
                data: {
                    'message': true,
                    'fname': "<?php echo $fname ?>",
                    'lname': "<?php echo $lname ?>"
                },
                cache: false,
                success: function(html) {
                    sent_status.style.display = 'block';
                    sent_status.innerHTML = "<i>Email sent. Check spam folder if you did not see the email.</i>" //this.responseText;
                }
            });

        if (document.querySelector("#try-again > span").innerHTML != -1) {

            count = setInterval(() => {
                document.querySelector("#try-again > span").innerHTML -= 1;
                verify_btn.disabled = true;

                if (document.querySelector("#try-again > span").innerHTML == -1) {
                    clearInterval(count);
                    try_again.style.display = "none";
                    document.querySelector("#try-again > span").innerHTML = 60;
                    sent_status.innerHTML = "<i>You can resend the verification email</i>";
                    verify_btn.disabled = false;

                }
            }, 1000);

        }
    }
</script>
<?php include 'cust_footer.php'; ?>