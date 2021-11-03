<?php
include 'cust_header.php';

if (!isset($_SESSION['loggedin'])) {
	echo "
        <script>
            Swal.fire({
                title: 'Error',
                text: 'Please log in first to checkout.',
                icon: 'error'
            }).then(function() {
            location.href = 'login.php'
            })
        </script>
    ";
}

date_default_timezone_set("Asia/Kuala_Lumpur");

$sql = "SELECT * FROM cust_address 
		INNER JOIN users ON cust_address.user_id = users.user_id 
		INNER JOIN cust_card ON cust_address.user_id = cust_card.user_id
		WHERE cust_address.user_id = " . $_SESSION["userid"];

if ($result = mysqli_query($link, $sql)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$fname = array($row["firstname"], $row["name1"], $row["name2"], $row["name3"], $row["name4"], $row["name5"]);
		$lname = array($row["lastname"], $row["lname1"], $row["lname2"], $row["lname3"], $row["lname4"], $row["lname5"]);
		$email = array($row["email"], $row["email1"], $row["email2"], $row["email3"], $row["email4"], $row["email5"]);
		$phone = array($row["phone"], $row["phone1"], $row["phone2"], $row["phone3"], $row["phone4"], $row["phone5"]);
		$address = array($row["address"], $row["address1"], $row["address2"], $row["address3"], $row["address4"], $row["address5"]);
		$area = array($row["area"], $row["area1"], $row["area2"], $row["area3"], $row["area4"], $row["area5"]);
		$state = array($row["state"], $row["state1"], $row["state2"], $row["state3"], $row["state4"], $row["state5"]);
		$postcode = array($row["postcode"], $row["postcode1"], $row["postcode2"], $row["postcode3"], $row["postcode4"], $row["postcode5"]);

		$cardname = array($row["cardName1"], $row["cardName2"], $row["cardName3"], $row["cardName4"], $row["cardName5"]);
		$cardno = array($row["cardNo1"], $row["cardNo2"], $row["cardNo3"], $row["cardNo4"], $row["cardNo5"]);
		$cardcvv = array($row["cardCvv1"], $row["cardCvv2"], $row["cardCvv3"], $row["cardCvv4"], $row["cardCvv5"]);
		$expmonth = array($row["cardExp1"], $row["cardExp2"], $row["cardExp3"], $row["cardExp4"], $row["cardExp5"]);
		$expyear = array($row["cardExpYr1"], $row["cardExpYr2"], $row["cardExpYr3"], $row["cardExpYr4"], $row["cardExpYr5"]);

		echo "
			<script>
				var fname = ['" . $row["firstname"] . "', '" . $row["name1"] . "', '" . $row["name2"] . "', '" . $row["name3"] . "', '" . $row["name4"] . "', '" . $row["name5"] . "'];
				var lname = ['" . $row["lastname"] . "', '" . $row["lname1"] . "', '" . $row["lname2"] . "', '" . $row["lname3"] . "', '" . $row["lname4"] . "', '" . $row["lname5"] . "'];
				var email= ['" . $row["email"] . "', '" . $row["email1"] . "', '" . $row["email2"] . "', '" . $row["email3"] . "', '" . $row["email4"] . "', '" . $row["email5"] . "'];
				var address = ['" . $row["address"] . "', '" . $row["address1"] . "', '" . $row["address2"] . "', '" . $row["address3"] . "', '" . $row["address4"] . "', '" . $row["address5"] . "'];
				var area = ['" . $row["area"] . "', '" . $row["area1"] . "', '" . $row["area2"] . "', '" . $row["area3"] . "', '" . $row["area4"] . "', '" . $row["area5"] . "'];
				var state = ['" . $row["state"] . "', '" . $row["state1"] . "', '" . $row["state2"] . "', '" . $row["state3"] . "', '" . $row["state4"] . "', '" . $row["state5"] . "'];
				var postcode= ['" . $row["postcode"] . "', '" . $row["postcode1"] . "', '" . $row["postcode2"] . "', '" . $row["postcode3"] . "', '" . $row["postcode4"] . "', '" . $row["postcode5"] . "'];
				var phone= [" . $row["phone"] . ", " . $row["phone1"] . ", " . $row["phone2"] . ", " . $row["phone3"] . ", " . $row["phone4"] . ", " . $row["phone5"] . "];

				var cardno = ['" . $row["cardNo1"] . "', '" . $row["cardNo2"] . "', '" . $row["cardNo3"] . "', '" . $row["cardNo4"] . "', '" . $row["cardNo5"] . "'];
				var cardcvv = [" . $row["cardCvv1"] . ", " . $row["cardCvv2"] . ", " . $row["cardCvv3"] . ", " . $row["cardCvv4"] . ", " . $row["cardCvv5"] . "];
				var expmonth = [" . $row["cardExp1"] . ", " . $row["cardExp2"] . ", " . $row["cardExp3"] . ", " . $row["cardExp4"] . ", " . $row["cardExp5"] . "];
				var expyear = [" . $row["cardExpYr1"] . ", " . $row["cardExpYr2"] . ", " . $row["cardExpYr3"] . ", " . $row["cardExpYr4"] . ", " . $row["cardExpYr5"] . "];
			</script>";
	}
}

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
	
$fname_err = $lname_err = $email_err = $address_err = $phone_err = $area_err = $state_err = $postcode_err = $cardcvv_err = $cardnum_err = $cardexpm_err = $cardexpy_err = "";
if (isset($_POST["place-order"])) {

	// Validate first name
	if (empty($_POST["fname"])) {
		$fname_err = "Name is required";
	} else if (!preg_match("/^[a-zA-Z-' ]*$/", test_input($_POST["fname"]))) {
		$fname_err = "Only letters and white space allowed";
	} else {
		$receipt_fname = ucwords(test_input($_POST["fname"]));
	}

	// Validate last name
	if (empty($_POST["lname"])) {
		$lname_err = "Name is required";
	} else if (!preg_match("/^[a-zA-Z-' ]*$/", test_input($_POST["lname"]))) {
		$lname_err = "Only letters and white space allowed";
	} else {
		$receipt_lname = ucwords(test_input($_POST["lname"]));
	}

	// Validate email
	if (empty($_POST["email"])) {
		$email_err = "Email is required";
	} else if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", test_input($_POST["email"]))) {
		$email_err = "Invalid email format";
	} else {
		$receipt_email = test_input($_POST["email"]);
	}

	if (empty($_POST["phone"])) {
		$phone_err = "Phone number is required";
	} else if (!preg_match('/^(\+?601)[0|1|2|3|4|6|7|8|9]\-*[0-9]{7,8}$/', $_POST["phone"])) {
		$phone_err = "Please enter valid phone number";
	} else {
		$receipt_phone = $_POST['phone'];
	}

	if (empty($_POST["address"])) {
		$address_err = "Address is required";
	} else {
		$receipt_address = $_POST['address'];
	}

	if (empty($_POST["area"])) {
		$area_err = "Area is required";
	} else {
		$receipt_area = $_POST['area'];
	}

	if (empty($_POST["state"])) {
		$state_err = "State is required";
	} else {
		$receipt_state = $_POST['state'];
	}

	if (empty($_POST["postcode"])) {
		$postcode_err = "Postcode is required";
	} else {
		$receipt_postcode = $_POST['postcode'];
	}

	$cardnum = $_POST["cardno"];

	if (empty($_POST["cardno"])) {
		$cardnum_err = "Card Number is required";
	} elseif (ctype_alpha($cardnum) /*preg_match("/^[a-zA-Z]+$/", $cardnum)*/ ) {
		$cardnum_err = "Only number allowed";
	} else {
		$receipt_cardnum = $_POST['cardno'];
	}

	if (empty($_POST["cvv"])) {
		$cardcvv_err = "CVV is required";
	} else {
		$receipt_ccvv = $_POST['cvv'];
	}

	if (empty($_POST["expmonth"])) {
		$cardexpm_err = "Month is required";
	} else if ($_POST["expmonth"] > 12) {
		$cardexpm_err = "Invalid month";
	} else {
		$receipt_cexpm = $_POST['expmonth'];
	}

	if (empty($_POST["expyear"])) {
		$cardexpy_err = "Year is required";
	} else {
		$receipt_cexpm = $_POST['expyear'];
	}

	if ($_POST["cart_empty"] != 'true') {

		if (empty($fname_err) && empty($lname_err) && empty($email_err) && empty($phone_err) && empty($address_err) && empty($area_err) && empty($state_err) && empty($postcode_err)) {

			$date = date('Y-m-d H:i:s');
			$sql_receipt = "INSERT INTO cust_receipt 
						(receipt_date, receipt_fname, receipt_lname, receipt_email, receipt_phone,  receipt_address, receipt_area, receipt_state, receipt_postcode, rating, user_id, payment_cost, payment_method, receipt_cardno) 
						VALUES ('$date', '$receipt_fname', '$receipt_lname', '$receipt_email', '" . $_POST["phone"] . "', 
						'" . $_POST["address"] . "', '" . $_POST["area"] . "', '" . $_POST["state"] . "', '" . $_POST["postcode"] . "', 'Not delivered', " . $_SESSION["userid"] . ", 
						" . $_POST["total"] . ", 'Credit/Debit Cards', '" . $_POST["cardno"] . "')";

			$sql_chk_address = "SELECT address FROM users WHERE address is null AND user_id = " . $_SESSION["userid"];
			$result_add = mysqli_query($link, $sql_chk_address);
	
			if(mysqli_num_rows($result_add) != 0)
			{
				$insert_add = "UPDATE users SET phone = ('".$_POST["phone"]."') , address = ('" . $_POST["address"] . "'), postcode = ('" . $_POST["postcode"] . "'), state = ('" . $_POST["state"] . "'), area = ('" . $_POST["area"] . "') WHERE user_id = ". $_SESSION["userid"];
				mysqli_query($link, $insert_add);
			}

			if (mysqli_query($link, $sql_receipt)) {

				$last_id = mysqli_insert_id($link);

				for ($x = 0; $x < count($_POST["item_id"]); $x++) {
					$sql_transaction = "INSERT INTO cust_transaction (item_id, receipt_id, amount, total_cost) 
									VALUES (" . $_POST["item_id"][$x] . ", $last_id, " . $_POST["item_quantity"] . ", " . $_POST["item_total_cost"][$x] . ")";

					$sql_delete = "DELETE FROM cust_cart WHERE item_id = " . $_POST["item_id"][$x] . " AND user_id = " . $_SESSION["userid"];

					$sql_get_stock = "SELECT stock FROM item WHERE item_id = " . $_POST["item_id"][$x];
					$result_stock = mysqli_query($link, $sql_get_stock);
					while ($stock_row = mysqli_fetch_assoc($result_stock)) {
						$new_stock = $stock_row["stock"] - $_POST["item_quantity"];
					}

					$sql_update_stock = "UPDATE item SET stock = $new_stock WHERE item_id = " . $_POST["item_id"][$x];

					$sql_review = "UPDATE users SET review = 'true' WHERE user_id = " . $_SESSION['userid'];

					if (mysqli_query($link, $sql_transaction)) {

						if (mysqli_query($link, $sql_delete)) {
						} else {

							echo "<script>alert('Error: Delete cart fail')</script>";
						}

						if (mysqli_query($link, $sql_update_stock)) {
						} else {

							echo "<script>alert('Error: Fail to update stock')</script>";
						}

						if (mysqli_query($link, $sql_review)) {
						} else {

							echo "<script>alert('Error: Fail update review.')</script>";
						}
					} else {
						echo "<script>alert('Error: Transaction fail')</script>";
					}
				}

				echo "
				<script>
					Swal.fire({
						title: 'Successful',
						text: 'Transaction success',
						icon: 'success'
					}).then(function() {
					location.href = 'cust_view_order.php'
					})
				</script>";
			} else {

				echo "<script>alert('Error: Receipt fail')</script>";
			}
		}
	} else {

		echo "
		<script>
			Swal.fire({
				title: 'Error',
				text: 'Your cart is empty.',
				icon: 'error'
			}).then(function() {
			location.href = 'cart.php'
			})
		</script>";
	}
}
?>
<section class="page-header">
	<div class="page-header__bg" style="background-image: url(assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
	<!-- /.page-header__bg -->
	<div class="container">
		<h2><?php echo $lang['chkout']?></h2>
		<ul class="thm-breadcrumb list-unstyled">
			<li><a href="index.php"><?php echo $lang['home']?></a></li>
			<li>/</li>
			<li><span><?php echo $lang['chkout']?></span></li>
		</ul><!-- /.thm-breadcrumb list-unstyled -->
	</div><!-- /.container -->
</section><!-- /.page-header -->

<section class="checkout-page">

	<div class="container">
		<form action="#" class="contact-one__form" method="POST">
			<div class="row">
				<div class="col-md-6">
					<h3><?php echo $lang['shipD']?></h3>
					<div class="row">
						<div class="col-md-12">
							<select class="selectpicker" id="choose-address" onchange="chooseAddress()">
								<option value="" style="display:none"><?php echo $lang['existAdd']?></option>
								<option value="" style="<?php
														if (
															$address[0] == "" &&
															$address[1] == "" &&
															$address[2] == "" &&
															$address[3] == "" &&
															$address[4] == "" &&
															$address[5] == ""
														) {
															echo 'display:block';
														} else {
															echo 'display:none';
														}
														?>" disabled>
									<?php echo $lang['noAdd']?>
								</option>
								<option value="1" style="<?php if ($address[0] == "") echo 'display:none'; ?>"><?php echo $address[0] ?></option>
								<option value="2" style="<?php if ($address[1] == "") echo 'display:none'; ?>"><?php echo $address[1] ?></option>
								<option value="3" style="<?php if ($address[2] == "") echo 'display:none'; ?>"><?php echo $address[2] ?></option>
								<option value="4" style="<?php if ($address[3] == "") echo 'display:none'; ?>"><?php echo $address[3] ?></option>
								<option value="5" style="<?php if ($address[4] == "") echo 'display:none'; ?>"><?php echo $address[4] ?></option>
								<option value="6" style="<?php if ($address[5] == "") echo 'display:none'; ?>"><?php echo $address[5] ?></option>
							</select>
						</div><!-- /.col-md-12 -->
						<div class="col-md-6">
							<label><?php echo $lang['fname']?> <i style="color:lightgray"> (eg. Ah Meng etc.)</i></label>
							<input type="text" name="fname" id="set-fname">
							<span class="invalid-feedback d-block"><?php echo $fname_err; ?></span>
						</div><!-- /.col-md-6 -->

						<div class="col-md-6">
							<label><?php echo $lang['lname']?> <i style="color:lightgray"> (eg. Lim etc.)</i></label>
							<input type="text" name="lname" id="set-lname">
							<span class="invalid-feedback d-block"><?php echo $lname_err; ?></span>
						</div><!-- /.col-md-6 -->

						<div class="col-md-12">
							<label><?php echo $lang['email']?> <i style="color:lightgray"> (eg. grabgrocery@gmail.com)</i></label>
							<input type="text" name="email" id="set-email">
							<span class="invalid-feedback d-block"><?php echo $email_err; ?></span>
						</div><!-- /.col-md-12 -->

						<div class="col-md-12">
							<label><?php echo $lang['phone']?> <i style="color:lightgray"> (eg. 60123334444)</i></label>
							<input type="text" name="phone" id="set-phone">
							<span class="invalid-feedback d-block"><?php echo $phone_err; ?></span>
						</div><!-- /.col-md-12 -->

						<div class="col-md-12">
							<label><?php echo $lang['address']?> <i style="color:lightgray"> (eg. No. 1, Tmn Asin, Ujong Pasir)</i></label>
							<input type="text" name="address" id="set-address">
							<span class="invalid-feedback d-block"><?php echo $address_err; ?></span>
						</div><!-- /.col-md-12 -->

						<div class="col-md-6">
							<label><?php echo $lang['area']?></label> <br>
							<select name="area" class="form-select form-select-lg" style="width: 100%">
								<option disabled selected style="display: none;"></option>
								<option id="set-area" style="display: none;"></option>
								<option value="Alor Gajah">Alor Gajah</option>
								<option value="Melaka Tengah">Melaka Tengah</option>
								<option value="Jasin">Jasin</option>
							</select>
							<span class="invalid-feedback d-block"><?php echo $area_err; ?></span>
						</div><!-- /.col-md-6 -->

						<div class="col-md-6">
							<label><?php echo $lang['state']?></label> <br>
							<select name="state" class="form-select form-select-lg" style="width: 100%">
								<option disabled selected style="display: none;"></option>
								<option id="set-state" style="display: none;"></option>
								<option value="Melaka">Melaka</option>
							</select>
							<span class="invalid-feedback d-block"><?php echo $state_err; ?></span>
						</div><!-- /.col-md-6 -->

						<div class="col-md-6">
							<label><?php echo $lang['pcode']?></label> <br>
							<select name="postcode" class="form-select form-select-lg" style="width: 100%">
								<option disabled selected style="display: none;"></option>
								<option id="set-postcode" style="display: none;"></option>
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
							<span class="invalid-feedback d-block"><?php echo $postcode_err; ?></span>
						</div><!-- /.col-md-6 -->
					</div>
				</div>


				
				<div class="col-md-6">
					<h3><?php echo $lang['payD']?></h3>
					<div class="row">
				
						<div class="col-md-12">
							<select class="selectpicker" id="choose-card" onchange="chooseCard()">
								<option value="" style="display:none"><?php echo $lang['existC']?></option>
								<option value="" style="<?php
														if (
															$cardno[0] == "" &&
															$cardno[1] == "" &&
															$cardno[2] == "" &&
															$cardno[3] == "" &&
															$cardno[4] == ""
														) {
															echo 'display:block';
														} else {
															echo 'display:none';
														}
														?>" disabled>
									<?php echo $lang['noCard']?>
								</option>
								<option value="1" style="<?php if ($cardno[0] == "") echo 'display:none'; ?>"><?php echo $cardno[0] . " (" . $cardname[0] . ")"; ?></option>
								<option value="2" style="<?php if ($cardno[1] == "") echo 'display:none'; ?>"><?php echo $cardno[1] . " (" . $cardname[1] . ")"; ?></option>
								<option value="3" style="<?php if ($cardno[2] == "") echo 'display:none'; ?>"><?php echo $cardno[2] . " (" . $cardname[2] . ")"; ?></option>
								<option value="4" style="<?php if ($cardno[3] == "") echo 'display:none'; ?>"><?php echo $cardno[3] . " (" . $cardname[3] . ")"; ?></option>
								<option value="5" style="<?php if ($cardno[4] == "") echo 'display:none'; ?>"><?php echo $cardno[4] . " (" . $cardname[4] . ")"; ?></option>
							</select>

						</div><!-- /.col-md-12 -->

						<div class="col-md-12">
							<label>Card Number <i style="color:lightgray" required>(0000 0000 0000 0000)</i></label>
							<input type="text" name="cardno" id="set-cardno" maxlength="19">
							<span class="invalid-feedback d-block"><?php echo $cardnum_err; ?></span>
						</div><!-- /.col-md-12 -->

						<div class="col-md-4">
							<label>CVV<i style="color:lightgray" required> (123)</i></label>
							<input type="text" name="cvv" id="set-cvv" maxlength="3">
							<span class="invalid-feedback d-block"><?php echo $cardcvv_err; ?></span>
						</div><!-- /.col-md-4 -->

						<div class="col-md-4">
							<label>Expiry Month <i style="color:lightgray" required> (1 - 12)</i></label>
							<input type="number" name="expmonth" id="set-expmonth" min="1" max="12" maxlength="2" data-mask="00">
							<span class="invalid-feedback d-block"><?php echo $cardexpm_err; ?></span>
						</div><!-- /.col-md-4 -->

						<div class="col-md-4">
							<label>Expiry Year <i style="color:lightgray" required> (21 , 22..) </i></label>
							<input type="number" name="expyear" id="set-expyear" min="21" max="28" maxlength="2" data-mask="00" >
							<span class="invalid-feedback d-block"><?php echo $cardexpy_err; ?></span>
						</div><!-- /.col-md-4 -->

						<input type="hidden" id="cart-empty" name="cart_empty">

					</div><!-- /.row -->
				</div><!-- /.col-md-6 -->
			</div>

				<div class="row">
					<div class="col-md-12">
					<hr>
						<h3>
							<?php echo $lang['yourOdr']?>
						</h3>
						<div class="table-responsive">
							<table class="table cart-table">
								<thead>
									<tr>
										<th></th>
										<th><?php echo $lang['items']?></th>
										<th><?php echo $lang['prices']?></th>
										<th><?php echo $lang['qtys']?></th>
										<th><?php echo $lang['totals']?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = "SELECT * FROM cust_cart INNER JOIN item ON cust_cart.item_id = item.item_id WHERE user_id = " . $_SESSION['userid'];
									$empty = false;
									$counter = 0;
									$item_total_cost = 0;
									$subtotal = 0;
									$total = 0;
									$shipping_cost = 0;

									if ($result = mysqli_query($link, $sql)) {
										if (mysqli_num_rows($result) == 0) {
											$empty = true;
											echo '
												<tr>
													<td colspan="4" style="text-align: center;">You have no products added in your Shopping Cart</td>
												</tr>';

											echo "
												<script>
													document.getElementById('cart-empty').value = 'true'
												</script>";
										} else {
											while ($row = mysqli_fetch_assoc($result)) {

												$counter++;
												$item_total_cost = $row["quantity"] * $row["cost"];
												$subtotal += $item_total_cost;
												$shipping_cost = 0;

												echo '
														<tr>
															<td style="display:none"><input type="hidden" name="item_id[]" value="' . $row["item_id"] . '"></td>
															<td><img src="assets/images/items/' . $row['image'] . '" style="width:100px; height:100px;"></td>
															<td><input type="hidden" name="item_name" value="' . $row['item'] . '">' . $row['item'] . '</td>
															<td><input type="hidden" name="item_price" value="' . $row['cost'] . '">RM ' . $row['cost'] . '</td>
															<td><input type="hidden" name="item_quantity" value="' . $row['quantity'] . '" min="1" max="999">' . $row['quantity'] . '</td>
															<td><input type="hidden" name="item_total_cost[]" value="' . $item_total_cost . '">RM ' . $item_total_cost . '</td>
														</tr>
														';
											}
										}
										if ($subtotal>99)
										{
											$shipping_cost = 0;
										}
										else if($empty)
										{
											$shipping_cost = 0;
										}else
										{
											$shipping_cost = 8;
										}
										$total = $subtotal + $shipping_cost;
										echo "<input type='hidden' style='display: none;' name='total' value='$total'>";
									}
									?>
							</table><!-- /.table -->
						</div><!-- /.table-responsive -->

						<div class="order-details">
							<div class="order-details__top">
								<p><?php echo $lang['pdt']?></p>
								<p><?php echo $lang['price']?></p>
							</div><!-- /.order-details__top -->
							<p>
								<span><?php echo $lang['sbbtots']?> (RM)</span>
								<span><?php echo number_format($subtotal,2) ?></span>
							</p>
							<p>
								<span><?php echo $lang['ships']?> (RM)</span>
								<span><?php echo number_format($shipping_cost,2)?></span>
							</p>
							<p>
								<span><?php echo $lang['gtotal']?> (RM)</span>
								<span><?php echo number_format($total,2) ?></span>
							</p>
							<hr>
							<i><?php echo $lang['freeshps']?>   </i><i class="fas fa-truck-moving"></i>
							<a href="index.php" class="thm-btn" style="text-decoration: none; margin-left: 436px;"><?php echo $lang['cancels']?></a>
							<input type="submit" class="thm-btn" value="<?php echo $lang['placeOdr']?>" name="place-order">
						</div><!-- /.order-details -->
					</div><!-- /.col-lg-6 -->
				</div>
		</form>
	</div><!-- /.container -->
</section><!-- /.checkout-page -->

<script>
	function chooseAddress() {
		var choose = document.getElementById("choose-address").value;

		document.getElementById("set-area").selected = "true";
		document.getElementById("set-state").selected = "true";
		document.getElementById("set-postcode").selected = "true";


		switch (choose) {
			case '1':
				document.getElementById("set-fname").value = fname[0];
				document.getElementById("set-lname").value = lname[0];
				document.getElementById("set-email").value = email[0];
				document.getElementById("set-phone").value = phone[0];
				document.getElementById("set-address").value = address[0];

				document.getElementById("set-area").innerHTML = area[0];
				document.getElementById("set-state").innerHTML = state[0];
				document.getElementById("set-postcode").innerHTML = postcode[0];

				document.getElementById("set-area").value = area[0];
				document.getElementById("set-state").value = state[0];
				document.getElementById("set-postcode").value = postcode[0];

				break;
			case '2':
				document.getElementById("set-fname").value = fname[1];
				document.getElementById("set-lname").value = lname[1];
				document.getElementById("set-email").value = email[1];
				document.getElementById("set-phone").value = phone[1];
				document.getElementById("set-address").value = address[1];

				document.getElementById("set-area").value = area[1];
				document.getElementById("set-state").value = state[1];
				document.getElementById("set-postcode").value = postcode[1];

				document.getElementById("set-area").innerHTML = area[1];
				document.getElementById("set-state").innerHTML = state[1];
				document.getElementById("set-postcode").innerHTML = postcode[1];

				break;
			case '3':
				document.getElementById("set-fname").value = fname[2];
				document.getElementById("set-lname").value = lname[2];
				document.getElementById("set-email").value = email[2];
				document.getElementById("set-phone").value = phone[2];
				document.getElementById("set-address").value = address[2];
				document.getElementById("set-area").value = area[2];
				document.getElementById("set-state").value = state[2];
				document.getElementById("set-postcode").value = postcode[2];
				break;
			case '4':
				document.getElementById("set-fname").value = fname[3];
				document.getElementById("set-lname").value = lname[3];
				document.getElementById("set-email").value = email[3];
				document.getElementById("set-phone").value = phone[3];
				document.getElementById("set-address").value = address[3];
				document.getElementById("set-area").value = area[3];
				document.getElementById("set-state").value = state[3];
				document.getElementById("set-postcode").value = postcode[3];
				break;
			case '5':
				document.getElementById("set-fname").value = fname[4];
				document.getElementById("set-lname").value = lname[4];
				document.getElementById("set-email").value = email[4];
				document.getElementById("set-phone").value = phone[4];
				document.getElementById("set-address").value = address[4];
				document.getElementById("set-area").value = area[4];
				document.getElementById("set-state").value = state[4];
				document.getElementById("set-postcode").value = postcode[4];
				break;
			case '6':
				document.getElementById("set-fname").value = fname[5];
				document.getElementById("set-lname").value = lname[5];
				document.getElementById("set-email").value = email[5];
				document.getElementById("set-phone").value = phone[5];
				document.getElementById("set-address").value = address[5];
				document.getElementById("set-area").value = area[5];
				document.getElementById("set-state").value = state[5];
				document.getElementById("set-postcode").value = postcode[5];
				break;
		}
	}


	function chooseCard() {
		var choose = document.getElementById("choose-card").value;

		switch (choose) {
			case '1':
				document.getElementById("set-cardno").value = cardno[0];
				document.getElementById("set-cvv").value = cardcvv[0];
				document.getElementById("set-expmonth").value = expmonth[0];
				document.getElementById("set-expyear").value = expyear[0];
				break;
			case '2':
				document.getElementById("set-cardno").value = cardno[1];
				document.getElementById("set-cvv").value = cardcvv[1];
				document.getElementById("set-expmonth").value = expmonth[1];
				document.getElementById("set-expyear").value = expyear[1];

				break;
			case '3':
				document.getElementById("set-cardno").value = cardno[2];
				document.getElementById("set-cvv").value = cardcvv[2];
				document.getElementById("set-expmonth").value = expmonth[2];
				document.getElementById("set-expyear").value = expyear[2];
				break;
			case '4':
				document.getElementById("set-cardno").value = cardno[3];
				document.getElementById("set-cvv").value = cardcvv[3];
				document.getElementById("set-expmonth").value = expmonth[3];
				document.getElementById("set-expyear").value = expyear[3];
				break;
			case '5':
				document.getElementById("set-cardno").value = cardno[4];
				document.getElementById("set-cvv").value = cardcvv[4];
				document.getElementById("set-expmonth").value = expmonth[4];
				document.getElementById("set-expyear").value = expyear[4];
				break;
		}
	}

	document.getElementById("set-cardno").onkeyup = function() {

		var CCNValue = $("#set-cardno").val();
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

		$("#set-cardno").val(ccnnewval);
	}
</script>

<?php include 'cust_footer.php'; ?>