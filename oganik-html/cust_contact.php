<?php
include 'cust_header.php';

$alert = "";

$n = 6;
function getID($n)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}
$name = $email = $phone = $title = $user_message = "";
$name_err = $email_err = $phone_err = $subject_err = $message_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    do {
        $id = getID($n);
        $result = mysqli_query($link, "SELECT * from cust_message where case_id = '" . $id . "'");
    } while (mysqli_num_rows($result) == 1);

    $date = date("Y-m-d H:i:s");

    if (empty($_POST['name'])) {
        $name_err = "Please enter your name";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["name"])) {
        $name_err = "Only letters and white space allowed";
    } 
    else if (strlen(trim($_POST["name"])) == 0)
    {
        $name_err = "Please enter your name";
    }
    else {
        $name = $_POST["name"];
    }

    if (empty($_POST["email"])) {
        $email_err = "Email is required";
    } else if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $_POST["email"])) {
        $email_err = "Invalid email format";
    } else {
        $email = $_POST["email"];
    }

    if (empty($_POST['phone'])) {
        $phone_err = "Please enter your phone number";
    } else if (!preg_match('/^(\+?601)[0|1|2|3|4|6|7|8|9]\-*[0-9]{7,8}$/', $_POST["phone"])) {
        $phone_err = "Please enter valid phone number (60123456789)";
    } else {
        $phone = $_POST["phone"];
    }

    if(empty($_POST['subject']))
    {
        $subject_err = "Please enter your subject";
    }
    else if (strlen(trim($_POST["subject"])) == 0)
    {
        $subject_err = "Please enter your subject";
    }
    else
    {
        $title = $_POST["subject"];
    }
    
    if(empty($_POST['message']))
    {
        $message_err = "Please enter your message";
    }
    else if (strlen(trim($_POST["message"])) == 0)
    {
        $message_err = "Please enter your subject";
    }
    else
    {
        $user_message = $_POST["message"];
    }
    

    if (empty($name_err) && empty($email_err) && empty($phone_err)  && empty($subject_err)  && empty($message_err)) {
        $to      = "1191201218@student.mmu.edu.my"; // Send email to our user //$email
        $subject = 'Contact Us | TheGrabGroceries'; // Give the email a subject 
        $message = '
        <html>
            <body style="
                padding:20px; 
                background-color:gray;
                width: 500px;
                height: 1000px;
                color: white;"
                >
            <h1>Dear ' . ucwords($name) . ',</h1>
            <br>
            
            <p style="color: white;">Thanks for contacting us! Our staff will get in touch with you as soon as possible:</p>
            <br>
            <p style="color: white;">Your message: </p>
            <br>

            <div style="
                padding:20px; 
                width: 400px; 
                height: 300px; 
                background-color:seagreen;
                color:white;
                border-radius:25px;
                margin: auto">
                <h3 style="font-size:20px; font-family:Arial, Helvetica, sans-serif;">' . ucwords($title) . '</h3>
                <p style="color: white;">' . ucfirst($user_message) . '</p>
            </div>
            <br>
            <br>
            
            <p style="color: white;">Enjoy your stay on TheGrabGroceries website!</p>
            
            <p style="color: white;">If this is not sent by you, please ignore this email</p>
            
            <h4 style="font-size:25px; font-family:Arial, Helvetica, sans-serif;">Case ID:' . $id . '</h4>
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


        $sql = "INSERT INTO cust_message 
                VALUES ('" . $id . "', '" . ucwords($name) . "', '" . $email . "', '" . $phone . "', '" . ucwords($title) . "', '" . ucfirst($user_message) . "', '" . $date . "')";

        if (mysqli_query($link, $sql)) {
            mail($to, $subject, $message, $headers);
            $alert = "true";
            //alertBox();
            echo "
            <script>
                Swal.fire({
                    title: 'Successful',
                    text: 'Message sent. Thank you for contacting us!',
                    icon: 'success'
                }).then(function() {
                location.href = 'cust_contact.php'
                })
            </script>";
        } else {
            //alertBox();
            echo "
            <script>
                alert('Some error occured, please try again');
            </script>";
        }
    }
}

/*get_brightness($hex) { 
    // returns brightness value from 0 to 255 
    // strip off any leading # 
    $hex = str_replace('#', '', $hex;)
    $c_r = hexdec(substr($hex, 0, 2)); 
    $c_g = hexdec(substr($hex, 2, 2)); 
    $c_b = hexdec(substr($hex, 4, 2)); 
    
    return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
  }
  
  $color = "#******"; 
  if ($get_brightness($color) > 130) { // will have to experiment with this number 
    echo '<font style="color:black;">Black</font>'; 
  } else {  
    echo '<font style="color:white;">White</font>'; 
  }  */
?>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2><?php echo $lang['contact'] ?></h2>
        <ul class="thm-breadcrumb list-unstyled">
            <li><a href="index.php"><?php echo $lang['home'] ?></a></li>
            <li>/</li>
            <li><span><?php echo $lang['contact'] ?></span></li>
        </ul><!-- /.thm-breadcrumb list-unstyled -->
    </div><!-- /.container -->
</section><!-- /.page-header -->


<section class="contact-one">
    <img src="assets/images/shapes/contact-bg-1-1.png" alt="" class="contact-one__shape-1">
    <img src="assets/images/shapes/contact-bg-1-2.png" alt="" class="contact-one__shape-2">
    <div class="container">
        <div class="block-title text-center">
            <div class="block-title__decor"></div><!-- /.block-title__decor -->
            <p><?php echo $lang['getintch'] ?></p>
            <h3><?php echo $lang['question'] ?> <br>
                <?php echo $lang['writemsg'] ?></h3>
        </div><!-- /.block-title -->

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="contact-one__form" method="post">
            <div class="row">
                <?php
                    if (isset($_SESSION["lname"])) 
                        $names = $_SESSION['lname'];
                    else 
                        $names = $name;

                    if (isset($_SESSION["email"])) 
                        $emails = $_SESSION['email'];
                    else 
                        $emails = $email;
                ?>
                <div class="col-md-6">
                    <label><strong><?php echo $lang['contactN'] ?></strong></label>
                    <input type="text" name="name" placeholder="(eg) Your Name" value="<?php echo $names ?>" required>
                    <span class="invalid-feedback d-block"><?php echo $name_err; ?></span>
                </div><!-- /.col-md-6 -->
                <div class="col-md-6">
                    <label><strong><?php echo $lang['contactE'] ?></strong></label>
                    <input type="email" placeholder="(eg) youremail@gmail.com" name="email" value="<?php echo $emails ?>" required>
                    <span class="invalid-feedback d-block"><?php echo $email_err; ?></span>
                </div><!-- /.col-md-6 -->
                <div class="col-md-6">
                    <label><strong><?php echo $lang['contactP'] ?></strong></label>
                    <input type="text" placeholder="(eg) 0123456789" name="phone" value="<?php echo $phone ?>" required>
                    <span class="invalid-feedback d-block"><?php echo $phone_err; ?></span>
                </div><!-- /.col-md-6 -->
                <div class="col-md-6">
                    <label><strong><?php echo $lang['contactS'] ?></strong><i id="count-subj"><?php echo $lang['contactSS'] ?></i></label>
                    <input type="text" placeholder="(eg) How to order?" name="subject" value="<?php echo $title ?>" required id="get-subj" maxlength="20">
                    <span class="invalid-feedback d-block"><?php echo $subject_err; ?></span>
                </div><!-- /.col-md-6 -->
                <div class="col-md-12">
                    <label><strong><?php echo $lang['contactM'] ?></strong><i id="count-char"><?php echo $lang['contactMM'] ?></i></label>
                    <textarea placeholder="(eg) Write a Message" name="message" value="<?php echo $user_message ?>" required id="get-char" maxlength="500"></textarea>
                    <span class="invalid-feedback d-block"><?php echo $message_err; ?></span>
                </div><!-- /.col-md-12 -->
                <script>
                    var count_char = document.querySelector("#count-char > span");
                    var get_char = document.getElementById("get-char");

                    get_char.onkeyup = () => {
                        count_char.innerHTML = 500 - get_char.value.length;
                    }

                    var count_subj = document.querySelector("#count-subj > span");
                    var get_subj = document.getElementById("get-subj");

                    get_subj.onkeyup = () => {
                        count_subj.innerHTML = 20 - get_subj.value.length;
                    }

                </script>
                <div class="col-md-12 text-center">
                    <input type="submit" class="thm-btn" value="<?php echo $lang['sendBtn'] ?>">
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </form>

    </div><!-- /.container -->
</section><!-- /.contact-one -->

<section class="contact-infos">
    <div class="container">
        <div class="thm-tiny__slider" id="contact-infos-box" data-tiny-options='{
                    "container": "#contact-infos-box",
                    "items": 1,
                    "slideBy": "page",
                    "gutter": 0,
                    "mouseDrag": true,
                    "autoplay": true,
                    "nav": false,
                    "controlsPosition": "bottom",
                    "controlsText": ["<i class=\"fa fa-angle-left\"></i>", "<i class=\"fa fa-angle-right\"></i>"],
                    "autoplayButtonOutput": false,
                    "responsive": {
                        "640": {
                        "items": 2,
                        "gutter": 30
                        },
                        "992": {
                        "gutter": 30,
                        "items": 3
                        },
                        "1200": {
                        "disable": true
                        }
                    }
                }'>
            <div>
                <div class="contact-infos__single">
                    <i class="organik-icon-location"></i>
                    <h3><?php echo $lang['visit'] ?></h3>
                    <p>66 Melaka Street, Melaka. Malaysia</p>
                </div><!-- /.contact-infos__single -->
            </div>
            <div>
                <div class="contact-infos__single">
                    <i class="organik-icon-email"></i>
                    <h3><?php echo $lang['sendmail'] ?></h3>
                    <p>
                        <a href="mailto:thegrabgroceries@gmail.com">thegrabgroceries@gmail.com</a>
                    </p>
                </div><!-- /.contact-infos__single -->
            </div>
            <div>
                <div class="contact-infos__single">
                    <i class="organik-icon-calling"></i>
                    <h3><?php echo $lang['contact'] ?></h3>
                    <p><a href="tel:0123608370">+60123608370</a> <br>
                    </p>
                </div><!-- /.contact-infos__single -->
            </div>
        </div>
    </div><!-- /.container -->
</section><!-- /.contact-infos -->

<div class="google-map__default">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7973.782605444915!2d102.23828442413114!3d2.1948269936007874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d1f1c323a61f9d%3A0x6f5f4f8fb415adee!2sTaman%20Kota%20Laksamana%2C%2075200%20Malacca!5e0!3m2!1sen!2smy!4v1630305293445!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" class="map__default" allowfullscreen></iframe>
</div>
<!-- /.google-map -->

<?php include 'cust_footer.php'; ?>