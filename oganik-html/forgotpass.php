<?php

include 'cust_header.php';
/*
$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

if($pageWasRefreshed ) {
  //do something because page was refreshed;
  header("location: login.php");
} else {
  //do nothing;
}
*/

// Check if the user is logged in
if (isset($_SESSION["loggedin"])) {
	header("location: index.php");
	exit;
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

$email = $code  = "";
$email_err = $code_err = "";
$send_status = "";
$verify_status = "";

//*************************//
//   Check if email exist
//*************************//

if (isset($_POST["send-email"])) {

	$email_err = "";
	if (empty(trim($_POST["email"]))) {
		$email_err = "Please enter your email";
	} else {
		$email = $_POST["email"];
	}

	// Prepare a select statement
	$sql = "SELECT * FROM users WHERE email = '$email'";
	$result = mysqli_query($link, $sql);

	if (mysqli_num_rows($result) == 1) {

		while ($row = mysqli_fetch_assoc($result)) {
			$_SESSION["resetid"] = $row["user_id"];
			$_SESSION["resetemail"] = $row["email"];
		}
	} else {
		$email_err = "E-mail could not be found.";
	}

	if ($email_err == "") {
		$send_status = "Email sent";
		$_SESSION["ver_code"] = getName($n);
		$to      = "1191201218@student.mmu.edu.my"; // Send email to our user
		$subject = 'Reset Password'; // Give the email a subject 
		$message = '
        <html>
            <body style="
                padding:20px; 
                background-color:gray;
                width: 500px;
                height: 600px;
                color: white;"
                >
            <h1>Dear ' . $email . ',</h1>
            <br>
            
            <p style="color: white;">Here is your password reset PIN:</p>
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
}

//*************************//
//      Verify Code
//*************************//

if (isset($_POST["confirm-code"])) {
	$verify_status = "";
	$code_err = "";
	if (isset($_SESSION["ver_code"]) && (strtoupper($_POST["ver-code"]) == $_SESSION["ver_code"])) {

		$verify_status = "Correct PIN entered";
	} else if (strtoupper($_POST["ver-code"]) == "") {

		$code_err = "Enter your PIN";
	} else {

		$code_err = "Wrong PIN entered";
	}
}

//*************************//
//      Set password
//*************************//

if (isset($_POST["new-pass"])) {

	$sql = "UPDATE users
			SET password = '" . $_POST['new-pass'] . "' 
			WHERE user_id = " . $_SESSION["resetid"];

	if (mysqli_query($link, $sql)) {
		echo "
		<script>
			alert('Password updated');
			location.href = 'login.php';
		</script>";
	} else {
		echo "
		<script>
			alert('Something went wrong, please try again');
			location.href = 'login.php';
		</script>";
	}
}

?>

<style>
	body {
		background-color: var(--thm-base);
		background-image: url("https://cdn.wallpapersafari.com/68/37/Gwgjo6.jpg")
	}

	.forgot-password {
		background-color: white;
		padding: 20px;
		border-radius: 5px;
		margin-top: 20px;
		margin-bottom: 20px;
	}
</style>

<section>
	<div class="container forgot-password">
		<div class="row">
			<div class="col-md-6" style="margin:auto">

				<h2>Reset Password</h2>
				<p>Please enter your email to receive password reset PIN</p>

				<form action="forgotpass.php" method="post">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Enter your email</label>
								<input type="email" name="email" id="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
								<span class="invalid-feedback email-err"><?php echo $email_err; ?></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<input type="submit" name="send-email" id="submit" class="btn btn-primary" value="Send">
							</div>
						</div>
						</br>

					</div>
					<div class="row">
						<div class="col-md-10">
							<p id="sent-status" style='color:var(--thm-base)'><?php echo $send_status; ?></p>
							<p id="try-again" style="visibility: hidden; ">You can resend the email in <span>60</span></p>
						</div>
					</div>

				</form>

				<hr>

			</div>
		</div>
	</div><!-- /.container -->

</section><!-- /.checkout-page -->

<div class="modal" id="ver-modal" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content ver-modal">
			<div class="modal-header" style="background-color:var(--thm-base)">
				<h4 class="modal-title" style="color: white">Verify PIN</h4>
			</div>
			<!-- Modal Header-->

			<div class="modal-body">
				<h5>Email Sent. Check your email to get your PIN</h5>

				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Key in your code</label>
								<input type="text" name="ver-code" id="ver-code" class="form-control <?php echo (!empty($code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $code; ?>">
								<span class="invalid-feedback"><?php echo $code_err; ?></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<input type="submit" name="confirm-code" id="verify-btn" class="btn btn-primary" value="Enter">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-10">
							<p id="verify-status" style='color:var(--thm-base)'><?php echo $verify_status; ?></p>
						</div>
					</div>

				</form>

			</div><!-- Modal Body-->

			<div class="modal-footer" style="background-color:var(--thm-base)">
				<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
			</div>
			<!-- Modal Footer-->
		</div>

	</div>
</div>
<!-- /.modal -->


<div class="modal" id="reset-modal" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content reset-modal">
			<div class="modal-header" style="background-color:var(--thm-base)">
				<h4 class="modal-title" style="color: white;">Reset Password</h4>
			</div>
			<!-- Modal Header-->

			<div class="modal-body">

				<form>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>New password</label>
								<input type="password" name="new-pass" id="new-pass" onkeyup="validatePassword(this.value);" class="form-control <?php echo (!empty($code_err)) ? 'is-invalid' : ''; ?>"><span id="msg"></span>
								<span class="new-pass-err" style="color:crimson"></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Confirm password</label>
								<input type="password" name="confirm-pass" id="confirm-pass" class="form-control <?php echo (!empty($code_err)) ? 'is-invalid' : ''; ?>">
								<span class="con-pass-err" style="color:crimson"></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<input type="submit" class="btn btn-primary" value="Enter" onclick="return passReset()">
							</div>
						</div>
					</div>
				</form>

			</div>
			<!-- Modal Body-->

			<div class="modal-footer" style="background-color:var(--thm-base)">
				<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
			</div>
			<!-- Modal Footer-->
		</div>

	</div>
</div>
<!-- /.modal -->

<script type="text/javascript">
	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}

	var sent_status = document.querySelector("#sent-status");
	var ver_status = document.querySelector("#verify-status");
	var submit_button = document.querySelector("#submit");
	var try_again = document.querySelector("#try-again");
	var verify_btn = document.getElementById("verify-btn");
	var count;


	function validateEmail(email) {
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
			return true

		} else {
			return false

		}
	}

	if (sent_status.innerHTML == "Email sent") {

		$('#ver-modal').fadeIn();
		/*
		$.ajax({
			type:"post",
			url:"forgotpass.php",
			data: 
			{  
			'email' :email
			},
			cache:false,
			success: function (html) {
				alert('Sent');
			}
		});
		*/
		try_again.style.visibility = "visible";
		if (document.querySelector("#try-again > span").innerHTML != -1) {
			count = setInterval(() => {
				document.querySelector("#try-again > span").innerHTML -= 1;
				submit_button.disabled = true;

				if (document.querySelector("#try-again > span").innerHTML == -1) {
					clearInterval(count);
					try_again.style.visibility = "hidden";
					document.querySelector("#try-again > span").innerHTML = 60;
					sent_status.innerHTML = "<i>You can resend the verification email</i>";
					submit_button.disabled = false;

				}
			}, 1000);
		}
	}

	if (ver_status.innerHTML == "Correct PIN entered") {
		$('#reset-modal').fadeIn();
	}

	function passReset() {
		var newpass = document.getElementById("new-pass").value;
		var conpass = document.getElementById("confirm-pass").value;
		var newpasserr = document.querySelector(".new-pass-err");
		var conpasserr = document.querySelector(".con-pass-err");

		if (newpass == "") {
			newpasserr.innerHTML = "Please enter password";
		} else if (newpass.length < 6) {
			newpasserr.innerHTML = "Ensure your password is longer than 6 characters";
		} else if (conpass == "") {
			conpasserr.innerHTML = "Please confirm password";
		} else if (newpass !== conpass) {
			conpasserr.innerHTML = "Password not met";
		} else {
			$.ajax({
				type: "post",
				url: "forgotpass.php",
				data: {
					'new-pass': newpass
				},
				cache: false,
				success: function(html) {
					alert('Password updated');
					location.href = 'login.php';
				}
			});
		}
		return false;
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
</script>

<?php include 'cust_footer.php'; ?>