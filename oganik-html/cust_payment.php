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

$card_name = array();
$card_no = array();
$card_exp = array();
$card_cvv = array();
$card_expyr = array();


if (isset($_POST['detail'])) {
    $sql_insert_cc = "
            UPDATE cust_card
            SET 
            cardName" . $_POST["no"] . " = '" . ucwords($_POST['card_name']) . "', 
            cardNo" . $_POST["no"] . "= '" . $_POST["card_no"] . "', 
            cardExp" . $_POST["no"] . " = '" . $_POST["card_exp"] . "',
            cardExpYr" . $_POST["no"] . " = '" . $_POST["card_expyr"] . "',
            cardCvv" . $_POST["no"] . " = '" . $_POST["card_cvv"] . "'
            WHERE user_id = " . $_SESSION["userid"];

    if (mysqli_query($link, $sql_insert_cc)) {
        echo "
            <script>
                Swal.fire({
                    title: 'Successful',
                    text: 'Payment method updated!',
                    icon: 'success'
                })
            </script>";
    } else {
        echo "
            <script>
                alert('Something went wrong, please try again');
            </script>";
    }
}

$sql = "SELECT * FROM cust_card where user_id = " . $_SESSION["userid"];
if ($result = mysqli_query($link, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($card_name, $row['cardName1'], $row['cardName2'], $row['cardName3'], $row['cardName4'], $row['cardName5']);
        array_push($card_no, $row['cardNo1'], $row['cardNo2'], $row['cardNo3'], $row['cardNo4'], $row['cardNo5']);
        array_push($card_cvv, $row['cardCvv1'], $row['cardCvv2'], $row['cardCvv3'], $row['cardCvv4'], $row['cardCvv5']);
        array_push($card_exp, $row['cardExp1'], $row['cardExp2'], $row['cardExp3'], $row['cardExp4'], $row['cardExp5']);
        array_push($card_expyr, $row['cardExpYr1'], $row['cardExpYr2'], $row['cardExpYr3'], $row['cardExpYr4'], $row['cardExpYr5']);
    }
}

?>
<style>
    #add-card1,
    #add-card2,
    #add-card3,
    #add-card4,
    #add-card5 {
        cursor: pointer;
    }

    .form-control {
        text-align: center;
        width: 100%;
        border: 2px solid #dddddd;
        border-radius: 5px;
        letter-spacing: 1px;
        word-spacing: 3px;
        outline: none;
        font-size: 16px;
        color: #555555;
    }

    .card-grp {
        display: flex;
        justify-content: space-between;
    }

    .space {
        margin-bottom: 20px;
    }

    .label {
        margin-left: -95px;
    }

    .card {
        width: 280px;
        height: 160px;
        background: linear-gradient(to left, gray, black);
        margin-bottom: 1%;
        font-family: 'Gemunu Libre';
    }

    .card_type {
        color: white;
        font-size: 20px;
        margin-left: 90px;
        margin-top: 15px;

    }

    .card_numberr {
        margin-left: 35px;
        margin-top: -10px;
        color: white;
        font-size: 25px;
    }

    .card_expp {
        margin-left: 55px;
        margin-top: -10px;
        color: white;
    }

    .card_namee {
        color: white;
        margin-left: 45px;
        margin-top: -5px;
    }

    .fas {
        margin-left: 0;
    }
</style>

<!-- :::::::::: Profile :::::::::: -->
<?php include 'cust_profile_layout.php' ?>
<!-- :::::::::: Page Content :::::::::: -->
<div class="col-xl-10 col-md-10">
    <div class="tab-content my-account-tab" id="pills-tabContent">
        <div class="#" id="pills-payment" aria-labelledby="pills-payment-tab">
            <div class="my-account-payment account-wrapper">
                <h4 class="account-title">Payment Method</h4>
                <div class="row">
                    <?php
                    $counterr = 0;
                    for ($x = 0; $x < 5; $x++) {
                        $counterr++;
                        echo '
                            <div class="col-4" style="margin-bottom:3%">
                                <div class="card">
                                    <p class="card_type">Black Card</p>
                                    <img src="assets/images/chippp.png" style="width: 50px; object-fit: contain; margin-top:-30px; margin-left: 23px;">
                                    <p class="card_numberr">' . $card_no[$x] . '</p>
                                    <p class="card_expp">' . $card_exp[$x] . ' / ' . $card_expyr[$x] . '</p>
                                    <p class="card_namee">' . $card_name[$x] . ' </p>
                                    <i class="fab fa-cc-mastercard fa-2x" style="margin-left: 230px; margin-top:-35px; color: black;"></i>
                                </div>
                                <a class="box-btn m-t-25 " id="add-card' . $counterr . '" onclick="return addCard(' . $counterr . ')"><i class="far fa-edit"></i>Edit</a>
                            </div>';
                    }
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

$counter = 0;
for ($x = 0; $x < 5; $x++) {
    $counter++;
    echo '
                <!--Modal-->
                <div class="modal" id="card-modal' . $counter . '" role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:var(--thm-base)">
                                <h4 class="modal-title"><span style="color:white;">Credit Cards</span></h4>
                                <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                            </div> 
                            <!-- Modal Header-->

                            <div class="modal-body">
                            
                                <form> 
                                    <div class="row cardd space iconn-relative">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="label" style="margin-left:5px;"><i class="fas fa-user"> Card Holder</i></label>
                                                <input type="text" name="card_name' . $counter . '" id="card_name' . $counter . '" placeholder="Your Name" class="form-control ' . ((!empty($cname_err)) ? "is-invalid" : '') . '" value="' . $card_name[$x] . '">
                                                <span class="invalid-feedback d-block" id="cname_err' . $counter . '"></span>   <span class="invalid-feedback"><?php echo $cname_err; ?></span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="label" style="margin-left:5px;"><i class="fas fa-lock"> CVV</i></label>
                                                <input type="text" name="card_cvv' . $counter . '" id="card_cvv' . $counter . '" data-mask="000" placeholder="000" class="form-control ' . ((!empty($ccvv_err)) ? "is-invalid" : '') . '" value="' . $card_cvv[$x] . ' ">
                                                <span class="invalid-feedback d-block" id="ccvv_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div> 
                                    
                                    <div class="row cardd space iconn-relative">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label" style="margin-left:5px;"><i class="fas fa-credit-card"> Card Number</i></label>
                                                <input type="" name="card_no' . $counter . '" id="card_no' . $counter . '" onkeyup="censor(' . $counter . ')" placeholder="Card Number" maxlength="19" class="form-control ' . ((!empty($cno_err)) ? "is-invalid" : '') . '" value="' . $card_no[$x] . '">
                                                <span class="invalid-feedback d-block" id="cno_err' . $counter . '"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row space iconn-relative">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="label" style="margin-left:5px;"><i class="fas fa-calendar-alt"> Expiry Date</i></label>
                                                <select name="card_exp' . $counter . '" id="card_exp' . $counter . '" class="form-control ' . ((!empty($cxep_err)) ? "is-invalid" : '') . '" value="' . $card_exp[$x] . '" >
                                                    <option disabled selected value></option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                </select>
                                                <span class="invalid-feedback d-block" id="cexp_err' . $counter . '"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="label" style="margin-top: 42px; margin-right: 50px;"></label>
                                                <select name="card_expyr' . $counter . '" id="card_expyr' . $counter . '" class="form-control ' . ((!empty($cxepyr_err)) ? "is-invalid" : '') . '" value="' . $card_expyr[$x] . '" >
                                                    <option disabled selected value></option>
                                                    <option value="21">2021</option>
                                                    <option value="22">2022</option>
                                                    <option value="23">2023</option>
                                                    <option value="24">2024</option>
                                                    <option value="25">2025</option>
                                                    <option value="26">2026</option>
                                                    <option value="27">2027</option>
                                                    <option value="28">2028</option>
                                                    <option value="29">2029</option>
                                                    <option value="30">2030</option>
                                                    <option value="31">2031</option>
                                                    <option value="32">2032</option>
                                                </select>
                                                <span class="invalid-feedback d-block" id="cexpyr_err' . $counter . '"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group" style="margin-top: 50px; margin-left: 140px;">
                                                <img src="assets/images/mastercard.jpg" alt="">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group" style="margin-top: 50px; margin-left: 90px;">
                                                <img src="assets/images/visa.jpg" alt="">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group" style="margin-top: 50px; margin-left: 40px;">
                                                <img src="assets/images/amex.jpg" alt="">
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="Save" onclick="return updateCard(' . $counter . ');">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </form>

                            </div>
                            <!-- Modal Body-->

                            <div class="modal-footer" style="background-color:var(--thm-base)">
                                <button type="button" class="btn btn-danger"  onclick="return closeModal(' . $counter . ')">Close</button>
                            </div> 
                            <!-- Modal Footer-->
                        </div>
                    </div>
                </div>';
}
?>

<script>
    function updateCard(counter) {
        var cardName = document.getElementById("card_name" + counter).value;
        var cardNum = document.getElementById("card_no" + counter).value;
        var cardExp = document.getElementById("card_exp" + counter).value;
        var cardExpYr = document.getElementById("card_expyr" + counter).value;
        var cardCvv = document.getElementById("card_cvv" + counter).value;
        document.getElementById("cname_err" + counter).innerHTML = "";
        document.getElementById("cno_err" + counter).innerHTML = "";
        document.getElementById("cexp_err" + counter).innerHTML = "";
        document.getElementById("ccvv_err" + counter).innerHTML = "";

        var pass = true;

        if (cardName == "") {
            document.getElementById("cname_err" + counter).innerHTML = "Card Name is required";
            pass = false;
        }else if (!/^[a-zA-Z-' ]*$/.test(cardName)) {
            document.getElementById("cname_err" + counter).innerHTML = "Please enter valid Card Name";
            pass = false;
        }

        if (cardNum == "") {
            document.getElementById("cno_err" + counter).innerHTML = "Card Number is required";
            pass = false;
        }else if(/[a-zA-Z]/g.test(cardNum))
        {
            document.getElementById("cno_err" + counter).innerHTML = "Only number allowed";
            pass = false;
        }

        if (cardExp == "") {
            document.getElementById("cexp_err" + counter).innerHTML = "Month is required";
            pass = false;
        }

        if (cardExpYr == "") {
            document.getElementById("cexpyr_err" + counter).innerHTML = "Year is required";
            pass = false;
        }

        if (cardCvv == "") {
            document.getElementById("ccvv_err" + counter).innerHTML = "CVV is required";
            pass = false;
        }

        if (pass) {
            $.ajax({
                type: "post",
                url: "cust_payment.php",
                data: {
                    'detail': true,
                    'no': counter,
                    'card_name': cardName,
                    'card_no': cardNum,
                    'card_exp': cardExp,
                    'card_expyr': cardExpYr,
                    'card_cvv': cardCvv
                },
                cache: false,
                success: function(html) {
                        Swal.fire({
                        icon: 'success',
                        title: 'Payment method updated!',
                        confirmButtonText: 'Okay',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = 'cust_payment.php';
                        }
                    })
                }
            });
        }
        return false;
    }

    function addCard(counter) {
        $('#card-modal' + counter).fadeIn();
        return false;
    }

    function closeModal(counter) {
        $('#card-modal' + counter).fadeOut();
        return false;
    }

    function censor(counter) {
        var CCNValue = $("#card_no" + counter).val();
        CCNValue = CCNValue.replace(/ /g, '');
        var CCNLength = CCNValue.length;
        var m = 1;
        var arr = CCNValue.split('');
        var ccnnewval = "";

        if (arr.length > 0) {
            for (var m = 0; m < arr.length; m++) {
                if (m == 4 || m == 8 || m == 12) {
                    ccnnewval = ccnnewval + ' ';
                }

                if (m <= 11) {
                    ccnnewval = ccnnewval + arr[m].replace(/[0-9]/g, "*");
                } else {
                    ccnnewval = ccnnewval + arr[m];
                }
            }
        }

        $("#card_no" + counter).val(ccnnewval);
    }

    /*
    $(document).ready(function () {

        $("#card_no").keyup(function (e) {
            
        });
    });
    */

    /*
     String.prototype.replaceAt = function(index, char) {
         var a = this.split("");
         a[index] = char;
         return a.join("");
     }

     window.onload = function() {
         
         for(var j = 0 ; j < 5 ; j ++) {
             var card_no = document.getElementById("card_no"+(j+1)).value;
             
             if(card_no != "") {

             for(var i = 0 ; i < 15 ; i++) {
                 var char = "*";
                 if (i == 4 || i == 9 || i == 14) {
                     char = " ";
                 }
                 card_no = card_no.replaceAt(i, char);
             }
                 
             document.getElementById("card_no"+(j+1)).value = card_no;
             }
         }

         for(var j = 0 ; j < 5 ; j ++) {

             var card_no = document.getElementById("card_display_no"+(j+1)).innerHTML;
                 
             if(card_no != "") {

                 for(var i = 0 ; i < 15 ; i++) {
                     var char = "*";
                     if (i == 4 || i == 9 || i == 14) {
                         char = " ";
                     }
                     card_no = card_no.replaceAt(i, char);
                 }
                     
                 document.getElementById("card_display_no"+(j+1)).innerHTML = card_no;
             }
         }
     }
    */
</script>

<?php include 'cust_footer.php'; ?>