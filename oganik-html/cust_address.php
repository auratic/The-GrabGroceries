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
            address = '" . ucwords($_POST['address']) . "', 
            postcode = '" . $_POST["pcode"] . "',
            state = '" . $_POST["state"] . "',
            area = '" . $_POST["area"] . "',
            phone= '" . $_POST["phone"] . "'
            WHERE user_id = " . $_SESSION["userid"];
    } else {
        $sql = "
                UPDATE cust_address
                SET 
                address" . $_POST["no"] . " = '" . ucwords($_POST['address']) . "', 
                phone" . $_POST["no"] . "= '" . $_POST["phone"] . "', 
                postcode" . $_POST["no"] . "= '" . $_POST["pcode"] . "', 
                name" . $_POST["no"] . " = '" . $_POST["name"] . "',
                lname" . $_POST["no"] . " = '" . $_POST["lname"] . "',
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
                <h4 class="account-title"><?php echo $lang['address']?></h4>
                <div class="account-address m-t-30 div1">
                    <?php
                    $sql = "SELECT * FROM users WHERE user_id = '" . $_SESSION['userid'] . "'";
                    $result = mysqli_query($link, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $fname = $row['firstname'];
                        $lname = $row['lastname'];
                        $default_address = $row['address'];
                        $default_phone = $row['phone'];
                        $default_email = $row['email'];
                        $default_pcode = $row['postcode'];
                        $default_state = $row['state'];
                        $default_area = $row['area'];
                    }

                    echo '
                        <div class="row">
                            <div class="col-4" style="margin-bottom: 5%; margin-top: 1%;">
                                <p>'.$lang['fullname'].': <strong>  ' . $fname . ' ' . $lname . '</strong></p>
                                <p>'.$lang['email'].'   &#160&#160&#160&#160&#160 : ' . $default_email . '</span></p>
                                <p>'.$lang['address'].'  &#160&#160: ' . $default_address . '</span> </p>
                                <p>'.$lang['area'].'    &#160&#160&#160&#160&#160&#160&#160 : ' . $default_area . '</span> </p>
                                <p>'.$lang['state'].'    &#160&#160&#160&#160&#160&#160&#160: ' . $default_state . '</span> </p>
                                <p>'.$lang['pcode'].' : ' . $default_pcode . '</span> </p>
                                <p>'.$lang['tel'].'  &#160&#160: ' . $default_phone . '</span></p>
                                <a class="box-btn m-t-25 " id="edit-address" onclick="return edit(0)"><i class="far fa-edit"></i>'.$lang['edit'].'</a> <span style="background-color: var(--thm-base); color: white; border-radius: 5px; padding: 4px;">'.$lang['default'].'</span>
                            </div>';
                    $counterr = 0;
                    for ($x = 0; $x < 5; $x++) {
                        $counterr++;
                        echo '
                            <div class="col-4" style="margin-bottom: 5%; margin-top: 1%;">
                                <p>'.$lang['fullname'].': <strong>  ' . $name[$x] . ' ' . $lastname[$x] . '</strong></p>
                                <p>'.$lang['email'].'    &#160&#160&#160&#160&#160 : ' . $email[$x] . '</span></p>
                                <p>'.$lang['address'].' &#160 : ' . $address[$x] . '</span></p>
                                <p>'.$lang['area'].'    &#160&#160&#160&#160&#160&#160&#160 : ' . $area[$x] . '</span></p>
                                <p>'.$lang['state'].'    &#160&#160&#160&#160&#160&#160&#160: ' . $state[$x] . '</span></p>
                                <p>'.$lang['pcode'].'&#160: ' . $pcode[$x] . '</span></p>
                                <p>'.$lang['tel'].' &#160&#160 : ' . $phone[$x] . '</span></p>
                                <a class="box-btn m-t-25 " id="edit-address' . $counterr . '" onclick="return edit(' . $counterr . ')" ><i class="far fa-edit"></i>'.$lang['edit'].'</a>
                            </div>';
                    }

                    echo "</div>";
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
echo '
                <div class="modal" id="address-modal0" role="dialog">
                    <div class="modal-dialog modal-lg">
                        
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:var(--thm-base)">
                                <h4 class="modal-title"><span style="color:white;">'.$lang['editd'].'</span></h4>
                                <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                            </div> 
                            <!-- Modal Header-->

                            <div class="modal-body">
                            
                                <form> 
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>'.$lang['fname'].'</label>
                                                <input type="" name="name0" id="name0" required class="form-control ' . ((!empty($code_err)) ? "is-invalid" : '') . '" value="' . $fname . '" disabled>
                                                <span class="con-pass-err" style="color:crimson" id="name_err0"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>'.$lang['lname'].'</label>
                                                <input type="" name="lname0" id="lname0" required class="form-control ' . ((!empty($code_err)) ? "is-invalid" : '') . '" value="' . $lname . '" disabled>
                                                <span class="con-pass-err" style="color:crimson" id="lname_err0"></span>
                                            </div>
                                        </div>
                                    </div> 
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>'.$lang['email'].'</label>
                                                <input type="" name="email0" id="email0" required class="form-control ' . ((!empty($code_err)) ? "is-invalid" : '') . '" value="' . $default_email . '" disabled>
                                                <span class="con-pass-err" style="color:crimson" id="email_err0"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>'.$lang['address'].'</label>
                                                <input type="" name="address0" id="address0" required class="form-control ' . ((!empty($address_err)) ? "is-invalid" : '') . '" value="' . $default_address . '">
                                                <span class="invalid-feedback d-block" id="address_err0"><?php echo $address_err; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>'.$lang['area'].'</label>
                                                <select name="area0" id="area0" class="form-control ' . ((!empty($area_err)) ? "is-invalid" : '') . '" >
                                                    <option hidden disabled selected value="' . $default_area . '">'. $default_area .'</option>
                                                    <option value="Alor Gajah">Alor Gajah</option>
                                                    <option value="Melaka Tengah">Melaka Tengah</option>
                                                    <option value="Jasin">Jasin</option>
                                                </select>
                                                <span class="invalid-feedback d-block" id="area_err0"><?php echo $area_err; ?></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="state">'.$lang['state'].'</label>
                                                <select name="state0" id="state0" class="form-control ' . ((!empty($state_err)) ? "is-invalid" : '') . '" >
                                                    <option hidden disabled selected value="' . $default_state . '">' . $default_state . '</option>
                                                    <option value="Melaka">Melaka</option>
                                                </select>
                                                <span class="invalid-feedback d-block" id="state_err0"><?php echo $state_err; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>'.$lang['pcode'].'</label>
                                                <select name="pcode0" id="pcode0" class="form-control ' . ((!empty($pcode_err)) ? "is-invalid" : '') . '">
                                                <option hidden disabled selected value="' . $default_pcode . '">' . $default_pcode . '</option>
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
                                                <label>'.$lang['phone'].'</label>
                                                <input type="" name="phone0" id="phone0" required class="form-control ' . ((!empty($phone_err)) ? "is-invalid" : '') . '" value="' . $default_phone . '" placeholder="60123456789">
                                                <span class="invalid-feedback d-block" id="phone_err0"><?php echo $phone_err; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                            
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="'.$lang['save'].'" onclick="return updateAddress(0);">
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <!-- Modal Body-->

                            <div class="modal-footer" style="background-color:var(--thm-base)">
                                <button type="button" class="btn btn-danger" onclick="return closeModal(0)">'.$lang['close'].'</button>
                            </div> 
                            <!-- Modal Footer-->
                        </div>
                    </div>
                        
                </div>
            ';
$counter = 0;
for ($x = 0; $x < 5; $x++) {
    $counter++;

    echo '
                <div class="modal" id="address-modal' . $counter . '" role="dialog">
                    <div class="modal-dialog modal-lg">
                        
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:var(--thm-base)">
                                <h4 class="modal-title"><span style="color:white;">'.$lang['editd'].'</span></h4>
                                <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                            </div> 
                            <!-- Modal Header-->

                            <div class="modal-body">
                            
                                <form> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>'.$lang['fname'].'</label>
                                            <input type="" name="name' . $counter . '" id="name' . $counter . '" class="form-control ' . ((!empty($name_err)) ? "is-invalid" : '') . '" value="' . $name[$x] . '" placeholder="John" required />
                                            <span class="invalid-feedback d-block" id="name_err' . $counter . '"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>'.$lang['lname'].'</label>
                                            <input type="" name="lname' . $counter . '" id="lname' . $counter . '" class="form-control ' . ((!empty($lname_err)) ? "is-invalid" : '') . '" value="' . $lastname[$x] . '" placeholder="Doe" required />
                                            <span class="invalid-feedback d-block" id="lname_err' . $counter . '"></span>
                                        </div>
                                    </div>
                                </div>  

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>'.$lang['email'].'</label>
                                                <input type="email" name="email' . $counter . '" id="email' . $counter . '" class="form-control ' . ((!empty($email_err)) ? "is-invalid" : '') . '" value="' . $email[$x] . '" placeholder="JohnDoe@gmail.com" required />
                                                <span class="invalid-feedback d-block" id="email_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>'.$lang['address'].'</label>
                                                <input type="" name="address' . $counter . '" id="address' . $counter . '" class="form-control ' . ((!empty($address_err)) ? "is-invalid" : '') . '" value="' . $address[$x] . '" placeholder="No 1 Tmn Asin 70000" required />
                                                <span class="invalid-feedback d-block" id="address_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="area">'.$lang['area'].'</label>
                                                <select name="area' . $counter . '" id="area' . $counter . '" class="form-control ' . ((!empty($area_err)) ? "is-invalid" : '') . '"  >
                                                    <option hidden disabled selected value="' . $area[$x] . '">' . $area[$x] . '</option>
                                                    <option value="Alor Gajah">Alor Gajah</option>
                                                    <option value="Melaka Tengah">Melaka Tengah</option>
                                                    <option value="Jasin">Jasin</option>
                                                </select>
                                                <span class="invalid-feedback d-block" id="area_err' . $counter . '"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="state">'.$lang['state'].'</label>
                                                <select name="state' . $counter . '" id="state' . $counter . '" class="form-control ' . ((!empty($state_err)) ? "is-invalid" : '') . '"  >
                                                    <option hidden disabled selected value="' . $state[$x] . '">' . $state[$x] . '</option>
                                                    <option value="Melaka">Melaka</option>
                                                </select>
                                                <span class="invalid-feedback d-block" id="state_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>'.$lang['pcode'].'</label>
                                                <select name="pcode' . $counter . '" id="pcode' . $counter . '" class="form-control ' . ((!empty($pcode_err)) ? "is-invalid" : '') . '"  >
                                                    <option hidden disabled selected value="' . $pcode[$x] . '">' . $pcode[$x] . '</option>
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
                                                <label>'.$lang['phone'].'</label>
                                                <input type="" name="phone' . $counter . '" id="phone' . $counter . '" class="form-control ' . ((!empty($phone_err)) ? "is-invalid" : '') . '" value="' . $phone[$x] . '" placeholder="60123456789" maxlength=12 required />
                                                <span class="invalid-feedback d-block" id="phone_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="'.$lang['save'].'" onclick="return updateAddress(' . $counter . ');">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Modal Body-->

                            <div class="modal-footer" style="background-color:var(--thm-base)">
                                <button type="button" class="btn btn-danger" onclick="return closeModal(' . $counter . ')">'.$lang['close'].'</button>
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
        }else if(!address.replace(/\s/g, '').length) {
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

        if (counter != 0) {
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
</script>


<?php include 'cust_footer.php'; ?>