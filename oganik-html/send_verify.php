<?php

session_start();

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
    $to      = $_SESSION['email']; // Send email to our user
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
        <h1>Dear Mr/Mrs. ' . $_GET["lname"] . ' ' .$_GET["fname"] . ',</h1>
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