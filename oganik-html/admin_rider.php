<?php

include 'admin_header.php';

$no_rider = 0;

$sql_rider = "SELECT * FROM rider";
if ($rider_result = mysqli_query($link, $sql_rider)) {
    $total_rider = mysqli_num_rows($rider_result);

    while ($rider_row = mysqli_fetch_assoc($rider_result)) {
        if ($rider_row["rider_status"] == "Available") {
            $no_rider++;
        }
    }
}


// Define variables and initialize with empty values
$email = $fname = $lname = $area = $phone = "";
$fname_err = $lname_err = $email_err = $password_err = $confirm_password_err = $phone_err = "";
$registering = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registering = "true";

    if (empty($_POST["phone"])) {
        $phone_err = "Phone number is required";
    } else if (!preg_match('/^(\+?601)[0|1|2|3|4|6|7|8|9]\-*[0-9]{7,8}$/', $_POST["phone"])) {
        $phone_err = "Please enter valid phone number";
    } else {
        $phone = $_POST["phone"];
    }

    // Validate first name
    if (empty($_POST["fname"])) {
        $fname_err = "Name is required";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", test_input($_POST["fname"]))) {
        $fname_err = "Only letters and white space allowed";
    } else if (strlen(test_input($_POST["fname"])) == 0) {
        $fname_err = "Please enter name";
    } else {
        $fname = ucwords(test_input($_POST["fname"]));
    }

    // Validate last name
    if (empty($_POST["lname"])) {
        $lname_err = "Name is required";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", test_input($_POST["lname"]))) {
        $lname_err = "Only letters and white space allowed";
    } else if (strlen(test_input($_POST["lname"])) == 0) {
        $lname_err = "Please enter name";
    }else {
        $lname = ucwords(test_input($_POST["lname"]));
    }

    // Validate email
    if (empty($_POST["email"])) {
        $email_err = "Email is required";
    } else if (!filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format";
    } else {
        // Prepare a select statement

        $sql = "SELECT * FROM rider WHERE rider_email = '" . test_input($_POST["email"]) . "'";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            $email_err = "Email is taken";
        } else {
            $email = test_input($_POST["email"]);
        }
    }

    // Validate password
    if (isset($_POST["area"])) {

        if(!empty($_POST["area"]))
            $area = $_POST["area"];
        else
            $area_err = "Please choose an area";

    } else {
        $area_err = "Please choose an area";
    }

    // Check input errors before inserting in database
    if (empty($lname_err) && empty($fname_err) && empty($email_err) && empty($area_err) && empty($phone_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO rider (rider_id, rider_email, rider_status, rider_name, rider_lastname, rider_phone, rider_location) VALUES (600000000, '$email', 'Available', '$fname', '$lname', '$phone', '$area');";

        if (mysqli_query($link, $sql)) {
            $date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO admin_activity (user_id, activity, target, activity_time) VALUES (" . $_SESSION["userid"] . ", 'add rider', '$lname $fname', '$date')";
            mysqli_query($link, $sql);

            $date = date("F j, Y, g:i a");
            $to = "1191201218@student.mmu.edu.my"; //send to our email
            $subject = "Hi rider!";
            $message = '
                <html>
                    <body style="
                        padding:20px; 
                        background-color:gray;
                        width: 500px;
                        height: 600px;
                        color: white;"
                        >
                    <h1>Dear ' . $lname . ' ' . $fname . ',</h1>
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
                        Rider Registration Successful
                    </h1>
                    <br>
                    <h3>
                        Congratulations, you have been added as TheGrabGroceries rider on  <i>' . $date . '</i>.
                    </h3>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>

                    <p style="color: white;">This is auto generated email</p></br>
                    </body>
                </html>
                ';

            $headers = 'From: TheGrabGroceries <thegrabgroceries@gmail.com>' . "\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  // Set from headers
            mail($to, $subject, $message, $headers);


            echo "
                <script>
                Swal.fire({
                    icon: 'success',
                    title: 'New rider added',
                    confirmButtonText: 'Okay',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = 'admin_rider.php';
                    }
                })
                </script>";
        } else {
            
            echo "
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error updating to database',
                    confirmButtonText: 'Okay',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = 'admin_rider.php';
                    }
                })
                </script>";

        }
    }
}

if (isset($_GET["deactivate"])) {
    $rider_id = $_GET["rider_id"];

    $sql = "UPDATE rider SET rider_status = 'Inactive', current_delivery = NULL where rider_id = $rider_id";

    if (mysqli_query($link, $sql)) {
        header("Location: admin_rider.php");
        die();
    }
}

if (isset($_GET["activate"])) {
    $rider_id = $_GET["rider_id"];

    $sql = "UPDATE rider SET rider_status = 'Available' where rider_id = $rider_id";

    if (mysqli_query($link, $sql)) {
        header("Location: admin_rider.php");
        die();
    }
}

?>

<section class="">
    <div class="container admin-header" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">
        <h1>Riders</h1>
    </div>

    <div class="container admin-content" style="background-color:rgba(255,255,255,0.8); padding: 2%">
        <div class="row">

            <div class="col-sm-12">
                <!--
                
                -->
                <div class="product-tab-box tabs-box" style="margin:0">
                    <ul class="tab-btns tab-buttons clearfix list-unstyled">
                        <li data-tab="#desc" class="tab-btn active-btn"><span>Active riders</span></li>
                        <li data-tab="#addi__info" class="tab-btn"><span>Inactive riders</span></li>
                    </ul>
                    <div class="tabs-content">
                        <div class="tab active-tab" id="desc">
                            <div class="product-details-content" style="padding: 20px 30px;">
                                <div class="desc-content-box">
                                    <table id="dtBasicExample" class="display">
                                        <thead>
                                            <tr>
                                                <th>Rider ID</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Current Delivery</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $sql = "SELECT * FROM rider WHERE rider_status != 'Inactive'";

                                            if ($result = mysqli_query($link, $sql)) {

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '
                                            <tr>
                                                <td>' . $row['rider_id'] . '</td>
                                                <td>' . $row['rider_name'] . ' ' . $row['rider_lastname'] . '</td>
                                                <td>' . $row['rider_email'] . '</td>
                                                <td>' . $row['rider_phone'] . '</td>
                                                <td>' . $row['rider_status'] . '</td>
                                                <td>' . $row['current_delivery'] .'</td>
                                                <td>
                                                    <button class="btn btn-info btn-sm" onclick="return deactivateRider(' . $row['rider_id'] . ', `' . $row['current_delivery'] .'`);">Deactivate</button>
                                                </td>
                                            </tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Rider ID</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Current Delivery</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="tab" id="addi__info">
                            <div class="product-details-content" style="padding: 20px 30px;">
                                <div class="desc-content-box">

                                    <table id="dtTableInactive" class="display">
                                        <thead>
                                            <tr>
                                                <th>Rider ID</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $sql = "SELECT * FROM rider WHERE rider_status = 'Inactive'";

                                            if ($result = mysqli_query($link, $sql)) {

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '
                                        <tr>
                                            <td>' . $row['rider_id'] . '</td>
                                            <td>' . $row['rider_name'] . ' ' . $row['rider_lastname'] . '</td>
                                            <td>' . $row['rider_email'] . '</td>
                                            <td>' . $row['rider_phone'] . '</td>
                                            <td>' . $row['rider_status'] . '</td>
                                            <td>
                                                <button class="btn btn-info btn-sm" onclick="return activateRider(' . $row['rider_id'] . ');">Activate</button>
                                            </td>
                                        </tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Rider ID</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div><!-- page wrapper -->

<div class="modal" id="add-modal" role="dialog">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header" style="background-color:var(--thm-base)">
                <h4 class="modal-title"><span style="color:white;">Add Rider</span></h4>
                <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
            </div>
            <!-- Modal Header-->

            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); /* $_SERVER["PHP_SELF"] Returns the filename of the currently executing script */ ?>" method="post" style="text-align: left">
                    <div class="form-group">
                        <label>E-mail</label> </br>
                        <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="grocery@gmail.com">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <div>
                                <label>First Name</label> </br>
                                <input type="text" name="fname" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fname; ?>">
                                <span class="invalid-feedback"><?php echo $fname_err; ?></span>
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <div>
                                <label>Last Name</label> </br>
                                <input type="text" name="lname" class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lname; ?>">
                                <span class="invalid-feedback"><?php echo $lname_err; ?></span>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-6">
                            <label>Phone</label> <i>(eg.60123456789)</i></br>
                            <input type="text" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>" placeholder="60123334444" maxlength="12">
                            <span class="invalid-feedback"><?php echo $phone_err; ?></span>
                        </div>

                        <div class="form-group col-6">
                            <label for="area">Area</label>
                            <select name="area" id="area" class="form-control <?php echo ((!empty($area_err)) ? " is-invalid" : '') ?>">
                                <option hidden disabled selected value="<?php echo $area ?>"><?php echo $area ?></option>
                                <option value="Alor Gajah">Alor Gajah</option>
                                <option value="Melaka Tengah">Melaka Tengah</option>
                                <option value="Jasin">Jasin</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $area_err; ?></span>
                        </div>
                    </div>

                    <!--
                    <div class="form-group">
                        <label>Password</label> </br>
                        <input id="pass" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                        
                    <div class="form-group" style="text-align: left">
                        <label>Confirm Password</label> </br>
                        <input id="con-pass" type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>

                    <input type="checkbox" onclick="showPass()"><label style="margin: 2%; margin-top: 0;">Show password</label>
                    <script>
                        function showPass() {
                            var x = document.getElementById("pass");
                            var y = document.getElementById("con-pass");

                            if(x.type == "password") {
                                x.type = "text";
                                y.type = "text";
                            } else {
                                x.type = "password";
                                y.type = "password";
                            }
                        }
                    </script>
                    -->
                    <div class="form-group">
                        <input type="submit" name="add" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
            <!-- Modal Body-->

            <div class="modal-footer" style="background-color:var(--thm-base)">
                <button type="button" class="btn btn-danger" onclick="return closeModal()">Cancel</button>
            </div>
            <!-- Modal Footer-->
        </div>
        <!-- Modal content-->
    </div>
</div>
<!--Modal-->

<!-- /.search-popup -->
<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>
<p id="registering"><?php echo $registering ?></p>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    if (document.getElementById("registering").innerHTML != "") {
        $(' #add-modal').fadeIn();
    }

    function addAdmin() {
        $('#add-modal').fadeIn();
        return false;
    }

    function closeModal() {
        $('#add-modal').fadeOut();
        return false;
    }
    
    function deactivateRider(id, delivery) {
        if(delivery != "") {
            Swal.fire({
                title: 'This rider is delivering ! ',
                icon: "warning"
            });
        } else {
            Swal.fire({
                title: 'Deactivate this rider ?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "get",
                        url: "admin_rider.php",
                        data: {
                            'deactivate': true,
                            'rider_id': id
                        },
                        cache: false,
                        success: function(html) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully Updated',
                                confirmButtonText: 'Okay',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'admin_rider.php';
                                }
                            })
                        }
                    });
                }
            });
        }
        return false;
    }

    function activateRider(id) {

        Swal.fire({
            title: 'Activate this rider ?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: "admin_rider.php",
                    data: {
                        'activate': true,
                        'rider_id': id
                    },
                    cache: false,
                    success: function(html) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully Updated',
                            confirmButtonText: 'Okay',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'admin_rider.php';
                            }
                        })
                    }
                });
            }
        });
        return false;
    }
    $(document).ready(function() {
        var table = $('#dtBasicExample').DataTable({
            //"scrollY": "50vh",
            "scrollCollapse": true,
            "pagingType": "full_numbers",
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Add new rider',
                    action: function(e, dt, node, config) {
                        $('#add-modal').fadeIn();
                    },
                },
                {
                    text: 'Rider available : <?php echo $no_rider . " / " . $total_rider ?>',
                    className: "displayRider",
                }],
        });

        $(".displayRider").css({"color":"black", "background-color": "rgba(255,255,255,0.8)"});
        $(".displayRider").attr("disabled", "true");

        var table = $('#dtTableInactive').DataTable({
            //"scrollY": "50vh",
            "scrollCollapse": true,
            "pagingType": "full_numbers",
            dom: 'Bfrtip',
            buttons: [],
        });
        //table.buttons().container()
        // .appendTo('#dtBasicExample_wrapper .col-md-6:eq(0)');
        $('.dataTable').wrap('<div class="dataTables_scroll" />');
        $('.dataTables_scroll').css({"overflow": "auto", "position": "relative"});
    });
</script>
<!-- template js -->
<script src="assets/js/organik.js"></script>
</body>

</html>