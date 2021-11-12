<?php
include 'cust_header.php';

if (!isset($_SESSION["loggedin"])) {
    echo "
        <script>
        Swal.fire({
            title: 'Error',
            text: 'Please log in.',
            icon: 'error'
        }).then(function() {
        location.href = 'login.php'
        })
        </script>";
}

$fname = $lname = $default_address = $default_phone = $default_pcode = $default_state = $default_area = "";
$name = array();
$lastname = array();
$address = array();
$phone = array();
$email = array();
$pcode = array();
$state = array();
$area  = array();

if (isset($_POST["details"])) {
    if ($_POST["no"] == 0) {
        $sql = "
            UPDATE users
            SET 
            default_name = '" . ucwords($_POST['name']) . "',
            default_lname = '" . ucwords($_POST['lname']) . "',
            default_address = '" . ucwords($_POST['address']) . "', 
            default_postcode = '" . $_POST["pcode"] . "',
            default_state = '" . $_POST["state"] . "',
            default_area = '" . $_POST["area"] . "',
            default_phone= '" . $_POST["phone"] . "',
            default_email = '" . $_POST['email'] . "'
            WHERE user_id = " . $_SESSION["userid"];
    } else {
        $sql = "
                UPDATE cust_address
                SET 
                address" . $_POST["no"] . " = '" . ucwords($_POST['address']) . "', 
                phone" . $_POST["no"] . "= '" . $_POST["phone"] . "', 
                postcode" . $_POST["no"] . "= '" . $_POST["pcode"] . "', 
                name" . $_POST["no"] . " = '" . ucwords($_POST["name"]) . "',
                lname" . $_POST["no"] . " = '" . ucwords($_POST["lname"]) . "',
                state" . $_POST["no"] . " = '" . $_POST["state"] . "',
                area" . $_POST["no"] . " = '" . $_POST["area"] . "',
                email" . $_POST["no"] . " = '" . $_POST["email"] . "'
                WHERE user_id = " . $_SESSION["userid"];
    }

    if (mysqli_query($link, $sql)) {
        echo "
            <script>
                alert('Details updated.');
            </script>";
    } else {
        echo "
            <script>
                alert('Something went wrong, please try again');
            </script>";
    }
}

if (isset($_GET["setdefault"])) {
    $counter = $_GET["counter"];
    $sql_get_default = "SELECT * FROM users WHERE user_id = " . $_SESSION["userid"];
    $sql_get_others = "SELECT * FROM cust_address WHERE user_id =" . $_SESSION["userid"];

    if ($others_result = mysqli_query($link, $sql_get_others)) {
        while ($others_row = mysqli_fetch_assoc($others_result)) {
            if ($default_result =  mysqli_query($link, $sql_get_default)) {
                while ($default_row = mysqli_fetch_assoc($default_result)) {

                    if ($others_row["name" . $counter] != "" || $others_row["name" . $counter] != NULL) {
                        $new_name = ucwords($others_row["name" . $counter]);
                        $new_lname = ucwords($others_row["lname" . $counter]);
                        $new_address = ucwords($others_row["address" . $counter]);
                        $new_postcode = $others_row["postcode" . $counter];
                        $new_state = $others_row["state" . $counter];
                        $new_area = $others_row["area" . $counter];
                        $new_phone = $others_row["phone" . $counter];
                        $new_email = $others_row["email" . $counter];

                        $old_name = ucwords($default_row["default_name"]);
                        $old_lname = ucwords($default_row["default_lname"]);
                        $old_address = ucwords($default_row['default_address']);
                        $old_postcode = $default_row["default_postcode"];
                        $old_state = $default_row["default_state"];
                        $old_area = $default_row["default_area"];
                        $old_phone = $default_row["default_phone"];
                        $old_email = $default_row["default_email"];

                        $sql_set_default = "
                                UPDATE users
                                SET 
                                default_name = '$new_name',
                                default_lname = '$new_lname',
                                default_address = '$new_address', 
                                default_postcode = '$new_postcode',
                                default_state = '$new_state',
                                default_area = '$new_area',
                                default_phone= '$new_phone',
                                default_email = '$new_email'
                                WHERE user_id = " . $_SESSION["userid"];

                        $sql_set_others = "
                                UPDATE cust_address
                                SET 
                                address$counter = '$old_address', 
                                phone$counter = '$old_phone', 
                                postcode$counter = '$old_postcode', 
                                name$counter = '$old_name',
                                lname$counter = '$old_lname',
                                state$counter = '$old_state',
                                area$counter = '$old_area',
                                email$counter  = '$old_email'
                                WHERE user_id = " . $_SESSION["userid"];

                        if (mysqli_query($link, $sql_set_others)) {

                            if (mysqli_query($link, $sql_set_default)) {
                                echo "
                                    <script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Successful',
                                            text: 'New default address set',
                                            confirmButtonText: 'Okay',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                            }
                                        })
                                    </script>
                                    ";
                            } else {
                                echo "
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Some error occured..',
                                            confirmButtonText: 'Okay',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                            }
                                        })
                                    </script>
                                    ";
                            }
                        } else {
                            echo "
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Some error occured..',
                                        confirmButtonText: 'Okay',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                        }
                                    })
                                </script>
                                ";
                        }
                    } else {
                        echo "
                            <script>
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'No details set for this addresss',
                                    confirmButtonText: 'Okay',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                    }
                                })
                            </script>
                            ";
                    }
                }
            }
        }
    } else {
    }
}



$sql = "SELECT * FROM cust_address where user_id = " . $_SESSION["userid"];
if ($result = mysqli_query($link, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($name,    $row['name1'], $row['name2'], $row['name3'], $row['name4'], $row['name5']);
        array_push($lastname,    $row['lname1'], $row['lname2'], $row['lname3'], $row['lname4'], $row['lname5']);
        array_push($address, $row['address1'], $row['address2'], $row['address3'], $row['address4'], $row['address5']);
        array_push($pcode,   $row['postcode1'], $row['postcode2'], $row['postcode3'], $row['postcode4'], $row['postcode5']);
        array_push($phone,   $row['phone1'], $row['phone2'], $row['phone3'], $row['phone4'], $row['phone5']);
        array_push($email,   $row['email1'], $row['email2'], $row['email3'], $row['email4'], $row['email5']);
        array_push($state,   $row['state1'], $row['state2'], $row['state3'], $row['state4'], $row['state5']);
        array_push($area,   $row['area1'], $row['area2'], $row['area3'], $row['area4'], $row['area5']);
    }
}

?>

<style>
    #edit-address,
    #edit-address1,
    #edit-address2,
    #edit-address3,
    #edit-address4,
    #edit-address5 {
        cursor: pointer;
    }

    .div1 {
        border: 2px solid var(--thm-base);
    }
</style>

<!-- :::::::::: Profile :::::::::: -->
<?php include 'cust_profile_layout.php' ?>

<!-- :::::::::: Page Content :::::::::: -->

<div class="col-xl-10 col-md-10">
    <div class="tab-content my-account-tab" id="pills-tabContent">
        <div class="#" id="pills-address" aria-labelledby="pills-address-tab">
            <div class="my-account-address account-wrapper">
                <h4 class="account-title"><?php echo $lang['address'] ?></h4>
                <div class="account-address m-t-30 div1" style="padding:20px">
                    <?php
                    $sql = "SELECT * FROM users WHERE user_id = '" . $_SESSION['userid'] . "'";
                    $result = mysqli_query($link, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $default_fname = $row['default_name'];
                        $default_lname = $row['default_lname'];
                        $default_address = $row['default_address'];
                        $default_phone = $row['default_phone'];
                        $default_email = $row['default_email'];
                        $default_pcode = $row['default_postcode'];
                        $default_state = $row['default_state'];
                        $default_area = $row['default_area'];
                    }

                    echo '
                        <h4>Default Address</h4>
                        <hr>
                        <div class="row">
                            <div class="col-5" style="background-color: rgba(255,255,255,0.5); margin: 1%; padding: 1%;">
                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%; ">
                                        <p>' . $lang['fullname'] . ': </p>
                                    </div>
                                    <div class="col-9" style="margin-bottom: 5%; ">
                                        <p><strong>  ' . $default_fname . ' ' . $default_lname . '</strong></p>
                                    </div>
                                </div>
                                
                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%; ">
                                        <p>' . $lang['email'] . ': </p> 
                                    </div>
                                    <div class="col-9" style="margin-bottom: 5%; ">
                                        <p>' . $default_email . '</p>
                                    </div>
                                </div>

                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%; ">
                                        <p>' . $lang['address'] . ': </p>
                                    </div>
                                    <div class="col-9" style="margin-bottom: 5%; ">
                                        <p>' . $default_address . '</p>
                                    </div>
                                </div>

                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%;">
                                        <p>' . $lang['area'] . ': </p>
                                    </div>
                                    <div class="col-9" style="margin-bottom: 5%; ">
                                        <p>' . $default_area . '</p>
                                    </div>
                                </div>

                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%; ">
                                        <p>' . $lang['state'] . ': </p>
                                    </div>
                                    <div class="col-9" style="margin-bottom: 5%; ">
                                        <p>' . $default_state . '</p>
                                    </div>
                                </div>

                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%; ">
                                        <p>' . $lang['pcode'] . ': </p>
                                        </div>
                                    <div class="col-9" style="margin-bottom: 5%; ">
                                        <p>' . $default_pcode . '</p>
                                    </div>
                                </div>

                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%; ">
                                        <p>' . $lang['tel'] . ': </p>
                                        </div>
                                    <div class="col-9" style="margin-bottom: 5%; ">
                                        <p>' . $default_phone . '</p>
                                    </div>
                                </div>
                                <div style="display:flex;">
                                    <div class="col-12" style="margin-bottom: 5%; ">
                                        <p><a class="box-btn m-t-25 " id="edit-address0" onclick="return edit(0)" ><i class="far fa-edit"></i>' . $lang['edit'] . '</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4>Other addresses</h4>
                        <hr>
                        <div class="row">';
                    $counterr = 0;
                    for ($x = 0; $x < 5; $x++) {
                        $counterr++;
                        echo '
                            <div class="col-5" style="background-color: rgba(255,255,255,0.5); margin: 1%; padding: 1%;">
                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>' . $lang['fullname'] . ': </p>
                                    </div>
                                    <div class="col-9" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p><strong>  ' . $name[$x] . ' ' . $lastname[$x] . '</strong></p>
                                    </div>
                                </div>
                                
                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>' . $lang['email'] . ': </p> 
                                    </div>
                                    <div class="col-9" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>' . $email[$x] . '</p>
                                    </div>
                                </div>

                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>' . $lang['address'] . ': </p>
                                    </div>
                                    <div class="col-9" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>' . $address[$x] . '</p>
                                    </div>
                                </div>

                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>' . $lang['area'] . ': </p>
                                    </div>
                                    <div class="col-9" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>' . $area[$x] . '</p>
                                    </div>
                                </div>

                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>' . $lang['state'] . ': </p>
                                    </div>
                                    <div class="col-9" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>' . $state[$x] . '</p>
                                    </div>
                                </div>

                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>' . $lang['pcode'] . ': </p>
                                        </div>
                                    <div class="col-9" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>' . $pcode[$x] . '</p>
                                    </div>
                                </div>

                                <div style="display:flex">
                                    <div class="col-3" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>' . $lang['tel'] . ': </p>
                                        </div>
                                    <div class="col-9" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>' . $phone[$x] . '</p>
                                    </div>
                                </div>
                                <div style="display:flex;">
                                    <div class="col-12" style="margin-bottom: 5%; margin-top: 1%;">
                                        <p>
                                            <a class="box-btn m-t-25 " id="edit-address' . $counterr . '" onclick="return edit(' . $counterr . ')" ><i class="far fa-edit"></i>' . $lang['edit'] . '</a>
                                            or
                                            <a class="box-btn m-t-25 " href="cust_address.php?setdefault&counter=' . $counterr . '" >Set default</a>
                                        </p>
                                    </div>
                                </div>
                                
                            </div>
                        ';
                    }
                    echo '</div>';
                    ?>
                </div>
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

<?php
//:::::::::::::::::::::::::::Default Address::::::::::::::::::::::::::://
echo '
                <div class="modal" id="address-modal0" role="dialog">
                    <div class="modal-dialog modal-lg">
                        
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:var(--thm-base)">
                                <h4 class="modal-title"><span style="color:white;">' . $lang['editd'] . '</span></h4>
                                <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                            </div> 
                            <!-- Modal Header-->

                            <div class="modal-body">
                            
                                <form> 
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>' . $lang['fname'] . '</label>
                                                <input type="" name="name0" id="name0" required class="form-control ' . ((!empty($code_err)) ? "is-invalid" : '') . '" value="' . $default_fname . '" >
                                                <span class="con-pass-err" style="color:crimson" id="name_err0"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>' . $lang['lname'] . '</label>
                                                <input type="" name="lname0" id="lname0" required class="form-control ' . ((!empty($code_err)) ? "is-invalid" : '') . '" value="' . $default_lname . '" >
                                                <span class="con-pass-err" style="color:crimson" id="lname_err0"></span>
                                            </div>
                                        </div>
                                    </div> 
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>' . $lang['email'] . '</label>
                                                <input type="" name="email0" id="email0" required class="form-control ' . ((!empty($code_err)) ? "is-invalid" : '') . '" value="' . $default_email . '" >
                                                <span class="con-pass-err" style="color:crimson" id="email_err0"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>' . $lang['address'] . '</label>
                                                <input type="" name="address0" id="address0" required class="form-control ' . ((!empty($address_err)) ? "is-invalid" : '') . '" value="' . $default_address . '">
                                                <span class="invalid-feedback d-block" id="address_err0"><?php echo $address_err; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>' . $lang['area'] . '</label>
                                                <select name="area0" id="area0" class="form-control ' . ((!empty($area_err)) ? "is-invalid" : '') . '" >
                                                    <option hidden disabled selected value="' . $default_area . '">' . $default_area . '</option>
                                                    <option hidden value="" id="input-area0"></option>
                                                    <option value="Alor Gajah">Alor Gajah</option>
                                                    <option value="Melaka Tengah">Melaka Tengah</option>
                                                    <option value="Jasin">Jasin</option>
                                                </select>
                                                <span class="invalid-feedback d-block" id="area_err0"><?php echo $area_err; ?></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="state">' . $lang['state'] . '</label>
                                                <select name="state0" id="state0" class="form-control ' . ((!empty($state_err)) ? "is-invalid" : '') . '" >
                                                    <option hidden disabled selected value="' . $default_state . '">' . $default_state . '</option>
                                                    <option hidden value="" id="input-state0"></option>
                                                    <option value="Melaka">Melaka</option>
                                                </select>
                                                <span class="invalid-feedback d-block" id="state_err0"><?php echo $state_err; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>' . $lang['pcode'] . '</label>
                                                <select name="pcode0" id="pcode0" class="form-control ' . ((!empty($pcode_err)) ? "is-invalid" : '') . '">
                                                <option hidden disabled selected value="' . $default_pcode . '">' . $default_pcode . '</option>
                                                <option hidden value="" id="input-pcode0"></option>
                                                    <option value="75000">75000</option>
                                                    <option value="75050">75050</option>
                                                    <option value="75100">75100</option>
                                                    <option value="75150">75150</option>
                                                    <option value="75200">75200</option>
                                                    <option value="75250">75250</option>
                                                    <option value="75260">75260</option>
                                                    <option value="75300">75300</option>
                                                    <option value="75350">75350</option>
                                                    <option value="75400">75400</option>
                                                    <option value="75430">75430</option>
                                                    <option value="75450">75450</option>
                                                    <option value="75460">75460</option>
                                                    <option value="76300">76300</option>
                                                    <option value="76400">76400</option>
                                                    <option value="76450">76450</option>
                                                    <option value="77200">77200</option>
                                                </select>
                                                <span class="invalid-feedback d-block" id="pcode_err0"><?php echo $pcode_err; ?></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>' . $lang['phone'] . '</label>
                                                <input type="" name="phone0" id="phone0" required class="form-control ' . ((!empty($phone_err)) ? "is-invalid" : '') . '" value="' . $default_phone . '" placeholder="60123456789">
                                                <span class="invalid-feedback d-block" id="phone_err0"><?php echo $phone_err; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                            
                                    <div class="row">
                                        <div class="form-group" style="margin-left: 13px;">
                                            <input type="submit" class="btn btn-primary" value="' . $lang['save'] . '" onclick="return updateAddress(0);">
                                            <input type="reset" onclick="return ResetForm(0)" class="btn btn-secondary" value="' . $lang['reset'] . '">
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <!-- Modal Body-->

                            <div class="modal-footer" style="background-color:var(--thm-base)">
                                <button type="button" class="btn btn-danger" onclick="return closeModal(0)">' . $lang['close'] . '</button>
                            </div> 
                            <!-- Modal Footer-->
                        </div>
                    </div>
                        
                </div>
            ';
//:::::::::::::::::::::::::::Other Address::::::::::::::::::::::::::://
$counter = 0;
for ($x = 0; $x < 5; $x++) {
    $counter++;

    echo '
                <div class="modal" id="address-modal' . $counter . '" role="dialog">
                    <div class="modal-dialog modal-lg">
                        
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:var(--thm-base)">
                                <h4 class="modal-title"><span style="color:white;">' . $lang['editd'] . '</span></h4>
                                <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                            </div> 
                            <!-- Modal Header-->

                            <div class="modal-body">
                            
                                <form> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>' . $lang['fname'] . '</label>
                                            <input type="" name="name' . $counter . '" id="name' . $counter . '" class="form-control ' . ((!empty($name_err)) ? "is-invalid" : '') . '" value="' . $name[$x] . '" placeholder="(eg) John" required />
                                            <span class="invalid-feedback d-block" id="name_err' . $counter . '"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>' . $lang['lname'] . '</label>
                                            <input type="" name="lname' . $counter . '" id="lname' . $counter . '" class="form-control ' . ((!empty($lname_err)) ? "is-invalid" : '') . '" value="' . $lastname[$x] . '" placeholder="(eg) Doe" required />
                                            <span class="invalid-feedback d-block" id="lname_err' . $counter . '"></span>
                                        </div>
                                    </div>
                                </div>  

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>' . $lang['email'] . '</label>
                                                <input type="email" name="email' . $counter . '" id="email' . $counter . '" class="form-control ' . ((!empty($email_err)) ? "is-invalid" : '') . '" value="' . $email[$x] . '" placeholder="(eg) JohnDoe@gmail.com" required />
                                                <span class="invalid-feedback d-block" id="email_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>' . $lang['address'] . '</label>
                                                <input type="" name="address' . $counter . '" id="address' . $counter . '" class="form-control ' . ((!empty($address_err)) ? "is-invalid" : '') . '" value="' . $address[$x] . '" placeholder="(eg) No 1 Tmn Asin 70000" required />
                                                <span class="invalid-feedback d-block" id="address_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="area">' . $lang['area'] . '</label>
                                                <select name="area' . $counter . '" id="area' . $counter . '" class="form-control ' . ((!empty($area_err)) ? "is-invalid" : '') . '"  >
                                                    <option hidden disabled selected value="' . $area[$x] . '">' . $area[$x] . '</option>
                                                    <option hidden value="" id="input-area' . $counter . '"></option>
                                                    <option value="Alor Gajah">Alor Gajah</option>
                                                    <option value="Melaka Tengah">Melaka Tengah</option>
                                                    <option value="Jasin">Jasin</option>
                                                </select>
                                                <span class="invalid-feedback d-block" id="area_err' . $counter . '"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="state">' . $lang['state'] . '</label>
                                                <select name="state' . $counter . '" id="state' . $counter . '" class="form-control ' . ((!empty($state_err)) ? "is-invalid" : '') . '"  >
                                                    <option hidden disabled selected value="' . $state[$x] . '">' . $state[$x] . '</option>
                                                    <option hidden value="" id="input-state' . $counter . '"></option>
                                                    <option value="Melaka">Melaka</option>
                                                </select>
                                                <span class="invalid-feedback d-block" id="state_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>' . $lang['pcode'] . '</label>
                                                <select name="pcode' . $counter . '" id="pcode' . $counter . '" class="form-control ' . ((!empty($pcode_err)) ? "is-invalid" : '') . '"  >
                                                    <option hidden disabled selected value="' . $pcode[$x] . '">' . $pcode[$x] . '</option>
                                                    <option hidden value="" id="input-pcode' . $counter . '"></option>
                                                    <option value="75000">75000</option>
                                                    <option value="75050">75050</option>
                                                    <option value="75100">75100</option>
                                                    <option value="75150">75150</option>
                                                    <option value="75200">75200</option>
                                                    <option value="75250">75250</option>
                                                    <option value="75260">75260</option>
                                                    <option value="75300">75300</option>
                                                    <option value="75350">75350</option>
                                                    <option value="75400">75400</option>
                                                    <option value="75430">75430</option>
                                                    <option value="75450">75450</option>
                                                    <option value="75460">75460</option>
                                                    <option value="76300">76300</option>
                                                    <option value="76400">76400</option>
                                                    <option value="76450">76450</option>
                                                    <option value="77200">77200</option>
                                                </select>
                                                <span class="invalid-feedback d-block" id="pcode_err' . $counter . '"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>' . $lang['phone'] . '</label>
                                                <input type="" name="phone' . $counter . '" id="phone' . $counter . '" class="form-control ' . ((!empty($phone_err)) ? "is-invalid" : '') . '" value="' . $phone[$x] . '" placeholder="(eg) 60123456789" maxlength=12 required />
                                                <span class="invalid-feedback d-block" id="phone_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group" style="margin-left: 13px;">
                                            <input type="submit" class="btn btn-primary" value="' . $lang['save'] . '" onclick="return updateAddress(' . $counter . ');">
                                            <input type="reset" onclick="return ResetForm(' . $counter . ')" class="btn btn-secondary" value="' . $lang['reset'] . '">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Modal Body-->

                            <div class="modal-footer" style="background-color:var(--thm-base)">
                                <a href="cust_address.php?setdefault&counter=' . $counter . '" >
                                    <button type="button" class="btn btn-info">Set as default</button>
                                </a>
                                <button type="button" class="btn btn-danger" onclick="return closeModal(' . $counter . ')">' . $lang['close'] . '</button>
                            </div> 
                            <!-- Modal Footer-->
                        </div>
                    </div>
                </div>';
}
?>

<script>
    function updateAddress(counter) {
        var address = document.getElementById("address" + counter).value;
        var pcode = document.getElementById("pcode" + counter).value;
        var phone = document.getElementById("phone" + counter).value;
        var name = document.getElementById("name" + counter).value;
        var email = document.getElementById("email" + counter).value;
        var state = document.getElementById("state" + counter).value;
        var area = document.getElementById("area" + counter).value;
        var lname = document.getElementById("lname" + counter).value;
        document.getElementById("address_err" + counter).innerHTML = "";
        document.getElementById("phone_err" + counter).innerHTML = "";
        document.getElementById("name_err" + counter).innerHTML = "";
        document.getElementById("email_err" + counter).innerHTML = "";
        document.getElementById("pcode_err" + counter).innerHTML = "";
        document.getElementById("state_err" + counter).innerHTML = "";
        document.getElementById("area_err" + counter).innerHTML = "";
        document.getElementById("lname_err" + counter).innerHTML = "";

        var pass = true;

        if (address == "") {
            document.getElementById("address_err" + counter).innerHTML = "Address is required";
            pass = false;
        } else if (!address.replace(/\s/g, '').length) {
            document.getElementById("address_err" + counter).innerHTML = "Address is required";
            pass = false;
        }

        if (phone == "") {
            document.getElementById("phone_err" + counter).innerHTML = "Phone Number is required";
            pass = false;
        } else if (!/^(\+?601)[0|1|2|3|4|6|7|8|9]\-*[0-9]{7,8}$/.test(phone)) {
            document.getElementById("phone_err" + counter).innerHTML = "Please enter valid number (60123456789)";
            pass = false;
        }

        if (pcode == "") {
            document.getElementById("pcode_err" + counter).innerHTML = "Postcode is required";
            pass = false;
        }

        if (area == "") {
            document.getElementById("area_err" + counter).innerHTML = "Area is required";
            pass = false;
        }

        if (state == "") {
            document.getElementById("state_err" + counter).innerHTML = "State is required";
            pass = false;
        }

        if (name == "") {
            document.getElementById("name_err" + counter).innerHTML = "Name is required";
            pass = false;
        } else if (!/^[a-zA-Z-' ]*$/.test(name)) {
            document.getElementById("name_err" + counter).innerHTML = "Please enter valid name";
            pass = false;
        }

        if (lname == "") {
            document.getElementById("lname_err" + counter).innerHTML = "Name is required";
            pass = false;
        } else if (!/^[a-zA-Z-' ]*$/.test(lname)) {
            /* else if (!/^(([A-Za-z]+[\-\']?)*([A-Za-z]+)?\s)+([A-Za-z]+[\-\']?)*([A-Za-z]+)?$/.test(lname)) */
            document.getElementById("lname_err" + counter).innerHTML = "Please enter valid name";
            pass = false;
        }

        if (email == "") {
            document.getElementById("email_err" + counter).innerHTML = "Email is required";
            pass = false;
        } else if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
            document.getElementById("email_err" + counter).innerHTML = "Please enter valid email";
            pass = false;
        }

        if (pass) {
            $.ajax({
                type: "post",
                url: "cust_address.php",
                data: {
                    'details': true,
                    'no': counter,
                    'name': name,
                    'lname': lname,
                    'address': address,
                    'pcode': pcode,
                    'phone': phone,
                    'state': state,
                    'area': area,
                    'email': email
                },
                cache: false,
                success: function(html) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Details updated!',
                        confirmButtonText: 'Okay',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = 'cust_address.php';
                        }
                    })
                }
            });
        }
        return false;
    }

    function edit(counter) {
        $('#address-modal' + counter).fadeIn();
        return false;
    }

    function closeModal(counter) {

        $('#address-modal' + counter).fadeOut();
        return false;
    }

    function ResetForm(counter) {
        document.getElementById("address" + counter).value = "";
        document.getElementById("input-pcode" + counter).selected = true;
        document.getElementById("phone" + counter).value = "";
        document.getElementById("input-state" + counter).selected = true;
        document.getElementById("input-area" + counter).selected = true;

        if (counter != 0) {
            document.getElementById("name" + counter).value = "";
            document.getElementById("email" + counter).value = "";
            document.getElementById("lname" + counter).value = "";
        }

        return false;
    }

    if (window.performance) {
        console.info("window.performance works fine on this browser");
    }
    if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
        location.href = "cust_address.php";
    } else {}
</script>


<?php include 'cust_footer.php'; ?>