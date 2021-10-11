<?php
session_start();

require "config.php";

if (!isset($_SESSION['loggedin'])) 
{
	echo "<script>alert('Please log in first to checkout.'); location.href = 'login.php'</script>";
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

if (isset($_POST["place-order"])) {
	$fname_err = $lname_err = $email_err = "";

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
	} else if (!filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
		$email_err = "Invalid email format";
	} else {
		$receipt_email = test_input($_POST["email"]);
	}

	if (empty($fname_err) && empty($lname_err) && empty($email_err)) {

		$date = date('Y-m-d H:i:s');
		$sql_receipt = "INSERT INTO cust_receipt 
						(receipt_date, receipt_fname, receipt_lname, receipt_email, receipt_phone,  receipt_address, receipt_area, receipt_state, receipt_postcode, rating, user_id, payment_cost, payment_method, receipt_cardno) 
						VALUES ('$date', '$receipt_fname', '$receipt_lname', '$receipt_email', '" . $_POST["phone"] . "', 
						'" . $_POST["address"] . "', '" . $_POST["area"] . "', '" . $_POST["state"] . "', '" . $_POST["postcode"] . "', 'Not delivered', " . $_SESSION["userid"] . ", 
						" . $_POST["total"] . ", 'Online Banking', '" .$_POST["cardno"]. "')";

		if (mysqli_query($link, $sql_receipt)) {

			$last_id = mysqli_insert_id($link);

			for ($x = 0; $x < count($_POST["item_id"]); $x++) {
				$sql_transaction = "INSERT INTO cust_transaction (item_id, receipt_id, amount, total_cost) 
									VALUES (" . $_POST["item_id"][$x] . ", $last_id, " . $_POST["item_quantity"] . ", " . $_POST["item_total_cost"][$x] . ")";

				$sql_delete = "DELETE FROM cust_cart WHERE item_id = " . $_POST["item_id"][$x] . " AND user_id = " . $_SESSION["userid"];

				if (mysqli_query($link, $sql_transaction)) {


					if (mysqli_query($link, $sql_delete)) {


					} else {

						echo "<script>alert('Error: Delete fail')</script>";
					
					}
				} else {
					echo "<script>alert('Error: Transaction fail')</script>";
				}
			}

			echo "<script>alert('Transaction success'); location.href = 'view_order.php'</script>";

		} else {

			echo "<script>alert('Error: Receipt fail')</script>";

		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Checkout || TheGrabGroceries</title>
	<!-- favicons Icons -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicons/apple-touch-icon.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicons/favicon-32x32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicons/favicon-16x16.png" />
	<link rel="manifest" href="assets/images/favicons/site.webmanifest" />
	<meta name="description" content="Agrikon HTML Template For Agriculture Farm & Farmers" />

	<!-- fonts -->
	<link rel="preconnect" href="https://fonts.gstatic.com" />
	<link href="https://fonts.googleapis.com/css2?family=Homemade+Apple&family=Abril+Fatface&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />


	<link rel="stylesheet" href="assets/vendors/bootstrap/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/vendors/bootstrap-select/bootstrap-select.min.css" />
	<link rel="stylesheet" href="assets/vendors/animate/animate.min.css" />
	<link rel="stylesheet" href="assets/vendors/fontawesome/css/all.min.css" />
	<link rel="stylesheet" href="assets/vendors/jarallax/jarallax.css" />
	<link rel="stylesheet" href="assets/vendors/organik-icon/organik-icons.css" />
	<link rel="stylesheet" href="assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css" />
	<link rel="stylesheet" href="assets/vendors/nouislider/nouislider.min.css" />
	<link rel="stylesheet" href="assets/vendors/nouislider/nouislider.pips.css" />
	<link rel="stylesheet" href="assets/vendors/odometer/odometer.min.css" />
	<link rel="stylesheet" href="assets/vendors/swiper/swiper.min.css" />
	<link rel="stylesheet" href="assets/vendors/tiny-slider/tiny-slider.min.css" />

	<!-- template styles -->
	<link rel="stylesheet" href="assets/css/organik.css" />
</head>

<body>
	<div class="preloader">
		<img class="preloader__image" width="55" src="assets/images/loaderr.png" alt="" />
	</div>
	<!-- /.preloader -->
	<div class="page-wrapper">
		<header class="main-header">
			<div class="topbar">
				<div class="container">
					<div class="main-logo">
						<a href="index.php" class="logo">
							<img src="assets/images/Logo6.png" width="105" alt="">
						</a>
						<div class="mobile-nav__buttons">
							<a href="#" class="search-toggler"><i class="organik-icon-magnifying-glass"></i></a>
							<a href="#" class="mini-cart__toggler"><i class="organik-icon-shopping-cart"></i></a>
						</div><!-- /.mobile__buttons -->

						<span class="fa fa-bars mobile-nav__toggler"></span>
					</div><!-- /.main-logo -->

					<div class="topbar__left">
						<div class="topbar__social">
							<a href="https://twitter.com/" class="fab fa-twitter"></a>
							<a href="https://www.facebook.com/" class="fab fa-facebook-square"></a>
							<a href="https://www.instagram.com/" class="fab fa-instagram"></a>
						</div><!-- /.topbar__social -->
						<div class="topbar__info">
							<i class="organik-icon-email"></i>
							<p>Email <a href="mailto:info@organik.com">thegrabgroceries@gmail.com</a></p>
						</div><!-- /.topbar__info -->
					</div><!-- /.topbar__left -->
					<div class="topbar__right">
						<div class="topbar__info">
							<i class="organik-icon-calling"></i>
							<p>Phone <a href="tel:+92-666-888-0000">+60123456789</a></p>
						</div><!-- /.topbar__info -->
						<div class="topbar__buttons">
							<a href="#" class="search-toggler"><i class="organik-icon-magnifying-glass"></i></a>
							<a href="#" class="mini-cart__toggler"><i class="organik-icon-shopping-cart"></i></a>
						</div><!-- /.topbar__buttons -->
					</div><!-- /.topbar__left -->

				</div><!-- /.container -->
			</div><!-- /.topbar -->
			<nav class="main-menu">
				<div class="container">
					<div class="main-menu__login">
						<a href="<?php if (isset($_SESSION["lname"])) {
										echo "profile.php";
									} else {
										echo "login.php";
									} ?>">
							<i class="organik-icon-user"></i>
							<?php

							if (isset($_SESSION["lname"])) {
								echo $_SESSION['lname'];
							} else {
								echo "Login / Register";
							}

							?>
						</a>
					</div><!-- /.main-menu__login -->
					<ul class="main-menu__list">
						<li class="dropdown">
							<a href="index.php">Home</a>
						</li>
						<li>
							<a href="about.php">About</a>
						</li>
						<li class="dropdown">
							<a href="products.php">Shop</a>
							<ul>
								<li><a href="cart.php">Cart Page</a></li>
								<li><a href="checkout.php">Checkout</a></li>
							</ul>
						</li>
						<li>
							<a href="news.php">News</a>
						</li>
						<li>
							<a href="review.php">Review</a>
						</li>
						<li><a href="contact.php">Contact</a></li>
					</ul>
					<div class="main-menu__language">
						<img src="assets/images/resources/flag-1-1.jpg" alt="">
						<label class="sr-only" for="language-select">select language</label>
						<!-- /#language-select.sr-only -->
						<select class="selectpicker" id="language-select-header">
							<option value="english">English</option>
							<option value="arabic">Arabic</option>
						</select>
					</div><!-- /.main-menu__language -->
				</div><!-- /.container -->
			</nav>
			<!-- /.main-menu -->
		</header><!-- /.main-header -->

		<div class="stricky-header stricked-menu main-menu">
			<div class="sticky-header__content"></div><!-- /.sticky-header__content -->
		</div><!-- /.stricky-header -->
		<section class="page-header">
			<div class="page-header__bg" style="background-image: url(assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
			<!-- /.page-header__bg -->
			<div class="container">
				<h2>Checkout</h2>
				<ul class="thm-breadcrumb list-unstyled">
					<li><a href="index.php">Home</a></li>
					<li>/</li>
					<li><span>Checkout</span></li>
				</ul><!-- /.thm-breadcrumb list-unstyled -->
			</div><!-- /.container -->
		</section><!-- /.page-header -->

		<section class="checkout-page">

			<div class="container">
				<form action="#" class="contact-one__form" method="POST">
					<p>Returning Customer? <a href="#">Click here to Login</a></p>
					<div class="row">
						<div class="col-lg-6">
							<h3>
								Your Orders
							</h3>
							<div class="table-responsive">
								<table class="table cart-table">
									<thead>
										<tr>
											<th></th>
											<th>Item</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql = "SELECT * FROM cust_cart INNER JOIN item ON cust_cart.item_id = item.item_id WHERE user_id = " . $_SESSION['userid'];

										$counter = 0;
										$item_total_cost = 0;
										$subtotal = 0;
										$total = 0;
										$shipping_cost = 0;

										if ($result = mysqli_query($link, $sql)) {
											if (mysqli_num_rows($result) == 0) {
												echo '
                                            <tr>
                                                <td colspan="4" style="text-align: center;">You have no products added in your Shopping Cart</td>
                                            </tr>';
											} else {
												while ($row = mysqli_fetch_assoc($result)) {

													$counter++;
													$item_total_cost = $row["quantity"] * $row["cost"];
													$subtotal += $item_total_cost;

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
											$total = $subtotal + $shipping_cost;
											echo "<input type='hidden' style='display: none;' name='total' value='$total'>";
										}
										?>
								</table><!-- /.table -->
							</div><!-- /.table-responsive -->

							<div class="order-details">
								<div class="order-details__top">
									<p>Product</p>
									<p>Price</p>
								</div><!-- /.order-details__top -->
								<p>
									<span>Subtotal (RM)</span>
									<span><?php echo $subtotal ?></span>
								</p>
								<p>
									<span>Shipping (RM)</span>
									<span>0.00</span>
								</p>
								<p>
									<span>Total (RM)</span>
									<span><?php echo $total ?></span>
								</p>
							</div><!-- /.order-details -->
						</div><!-- /.col-lg-6 -->
						<div class="col-lg-6">
							<h3>Shipping Details</h3>
							<div class="row">
								<div class="col-md-12">
									<select class="selectpicker" id="choose-address" onchange="chooseAddress()">
										<option value="" style="display:none">Choose existing address</option>
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
											No existing address
										</option>
										<option value="1" style="<?php if ($address[0] == "") echo 'display:none'; ?>">Default Address</option>
										<option value="2" style="<?php if ($address[1] == "") echo 'display:none'; ?>">Address 1</option>
										<option value="3" style="<?php if ($address[2] == "") echo 'display:none'; ?>">Address 2</option>
										<option value="4" style="<?php if ($address[3] == "") echo 'display:none'; ?>">Address 3</option>
										<option value="5" style="<?php if ($address[4] == "") echo 'display:none'; ?>">Address 4</option>
										<option value="6" style="<?php if ($address[5] == "") echo 'display:none'; ?>">Address 5</option>
									</select>
								</div><!-- /.col-md-12 -->
								<div class="col-md-6">
									<label>First Name <i style="color:lightgray"> (eg. Ah Meng etc.)</i></label>
									<input type="text" name="fname" id="set-fname">
								</div><!-- /.col-md-6 -->

								<div class="col-md-6">
									<label>Last Name / Surname <i style="color:lightgray"> (eg. Lim etc.)</i></label>
									<input type="text" name="lname" id="set-lname">
								</div><!-- /.col-md-6 -->

								<div class="col-md-12">
									<label>E-mail <i style="color:lightgray"> (eg. grabgrocery@gmail.com)</i></label>
									<input type="text" name="email" id="set-email">
								</div><!-- /.col-md-12 -->

								<div class="col-md-12">
									<label>Phone <i style="color:lightgray"> (eg. 60123334444)</i></label>
									<input type="text" name="phone" id="set-phone">
								</div><!-- /.col-md-12 -->

								<div class="col-md-12">
									<label>Address <i style="color:lightgray"> (eg. No. 1, Tmn Asin, Ujong Pasir)</i></label>
									<input type="text" name="address" id="set-address">
								</div><!-- /.col-md-12 -->

								<div class="col-md-6">
									<label>Area</label> <br>
									<select name="area" class="form-select form-select-lg" style="width: 100%">
										<option disabled selected style="display: none;"></option>
										<option id="set-area" style="display: none;"></option>
										<option value="Alor Gajah">Alor Gajah</option>
										<option value="Melaka Tengah">Melaka Tengah</option>
										<option value="Jasin">Jasin</option>
									</select>
								</div><!-- /.col-md-6 -->

								<div class="col-md-6">
									<label>State</label> <br>
									<select name="state" class="form-select form-select-lg" style="width: 100%">
										<option disabled selected style="display: none;"></option>
										<option id="set-state" style="display: none;"></option>
										<option value="Melaka">Melaka</option>
									</select>
								</div><!-- /.col-md-6 -->

								<div class="col-md-6">
									<label>Postcode</label> <br>
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
								</div><!-- /.col-md-6 -->


								<div class="col-md-12">
									<hr>
									<h3>Payment Details</h3>
								</div>
								<!--
										<ul id="accordion" class="list-unstyled" data-wow-duration="1500ms">
											<li>
												<h2 class="para-title active">
													<span class="collapsed" role="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
														Direct Bank Transfer
													</span>
												</h2>
												<div id="collapseTwo" class="collapse show" role="button" aria-labelledby="collapseTwo" data-parent="#accordion">
													<p>Make your payment directly into our bank account. Please
														use your Order ID as the payment reference. Your order
														wont be shipped until the funds have cleared.</p>
												</div>
											</li>
											<li>
												<h2 class="para-title ">
													<span class="collapsed" role="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
														Paypal Payment
														<img src="assets/images/products/paypal-1-1.jpg" alt="">
													</span>
												</h2>
												<div id="collapseOne" class="collapse " aria-labelledby="collapseOne" data-parent="#accordion">
													<p>Make your payment directly into our bank account. Please
														use your Order ID as the payment reference. Your order
														wont be shipped until the funds have cleared.</p>
												</div>
											</li>
										</ul>
										-->
								<div class="col-md-12">
									<select class="selectpicker" id="choose-card" onchange="chooseCard()">
										<option value="" style="display:none">Choose existing card</option>
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
											No existing address
										</option>
										<option value="1" style="<?php if ($cardno[0] == "") echo 'display:none'; ?>">Card 1</option>
										<option value="2" style="<?php if ($cardno[1] == "") echo 'display:none'; ?>">Card 2</option>
										<option value="3" style="<?php if ($cardno[2] == "") echo 'display:none'; ?>">Card 3</option>
										<option value="4" style="<?php if ($cardno[3] == "") echo 'display:none'; ?>">Card 4</option>
										<option value="5" style="<?php if ($cardno[4] == "") echo 'display:none'; ?>">Card 5</option>
									</select>
								</div><!-- /.col-md-12 -->

								<div class="col-md-12">
									<label>Card Number <i style="color:lightgray" >(0000 0000 0000 0000)</i></label>
									<input type="text" name="cardno" maxlength="19" id="set-cardno" required>
								</div><!-- /.col-md-12 -->

								<div class="col-md-4">
									<label>CVV<i style="color:lightgray" > (123)</i></label>
									<input type="text" name="cvv" maxlength="3" id="set-cvv" required>
								</div><!-- /.col-md-4 -->

								<div class="col-md-4">
									<label>Expiry Month <i style="color:lightgray" > (1 - 12)</i></label>
									<input type="text" name="expmonth" id="set-expmonth" maxlength="2" required>
								</div><!-- /.col-md-4 -->

								<div class="col-md-4">
									<label>Expiry Year <i style="color:lightgray" > (21 , 22..) </i></label>
									<input type="text" name="expmonth" id="set-expyear" maxlength="2" required>
								</div><!-- /.col-md-4 -->

								<div class="col-md-6">
									<div class="text-right">
										<input type="submit" class="thm-btn" value="Place Your Order" name="place-order">
									</div><!-- /.text-right -->
								</div><!-- /.col-md-6 -->


							</div><!-- /.row -->
						</div><!-- /.col-lg-6 -->
					</div><!-- /.row -->
				</form>
			</div><!-- /.container -->
		</section><!-- /.checkout-page -->

		<footer class="site-footer background-black-2">
			<img src="assets/images/shapes/footer-bg-1-1.png" alt="" class="site-footer__shape-1">
			<img src="assets/images/shapes/footer-bg-1-2.png" alt="" class="site-footer__shape-2">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
						<div class="footer-widget footer-widget__about-widget">
							<a href="index.php" class="footer-widget__logo">
								<img src="assets/images/tgg.png" alt="" width="150" height="150">
							</a>
							<p class="thm-text-dark">We are here to provide you <br>with just the greatest stuff.</p>
						</div><!-- /.footer-widget -->
					</div><!-- /.col-sm-12 col-md-6 -->
					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
						<div class="footer-widget footer-widget__contact-widget">
							<h3 class="footer-widget__title">Contact</h3><!-- /.footer-widget__title -->
							<ul class="list-unstyled footer-widget__contact">
								<li>
									<i class="fa fa-phone-square"></i>
									<a href="tel:666-888-0000">60123456789</a>
								</li>
								<li>
									<i class="fa fa-envelope"></i>
									<a href="mailto:thegrabgroceries@gmail.com">thegrabgroceries@gmail.com</a>
								</li>
								<li>
									<i class="fa fa-map-marker-alt"></i>
									<a href="https://goo.gl/maps/kLV5kZiqyVc5PKrH9" target="_blank">66 Melaka Street
										Malacca Malaysia</a>
								</li>
							</ul><!-- /.list-unstyled footer-widget__contact -->
						</div><!-- /.footer-widget -->
					</div><!-- /.col-sm-12 col-md-6 col-lg-2 -->
					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
						<div class="footer-widget footer-widget__links-widget">
							<h3 class="footer-widget__title">Links</h3><!-- /.footer-widget__title -->
							<ul class="list-unstyled footer-widget__links">
								<li>
									<a href="index.php">Top Sellers</a>
								</li>
								<li>
									<a href="products.php">Shopping</a>
								</li>
								<li>
									<a href="about.php">About</a>
								</li>
								<li>
									<a href="contact.php">Contact</a>
								</li>
								<li>
									<a href="contact.php">Help</a>
								</li>
							</ul><!-- /.list-unstyled footer-widget__contact -->
						</div><!-- /.footer-widget -->
					</div><!-- /.col-sm-12 col-md-6 col-lg-2 -->
					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-2">
						<div class="footer-widget">
							<h3 class="footer-widget__title">Explore</h3><!-- /.footer-widget__title -->
							<ul class="list-unstyled footer-widget__links">
								<li>
									<a href="products.php">New Products</a>
								</li>
								<li>
									<a href="profile.php">My Account</a>
								</li>
								<li>
									<a href="contact.php">Support</a>
								</li>
								<li>
									<a href="contact.php">FAQs</a>
								</li>
							</ul><!-- /.list-unstyled footer-widget__contact -->
						</div><!-- /.footer-widget -->
					</div><!-- /.col-sm-12 col-md-6 col-lg-2 -->
				</div><!-- /.row -->
			</div><!-- /.container -->
			<div class="bottom-footer">
				<div class="container">
					<hr>
					<div class="inner-container text-center">
						<div class="bottom-footer__social">
							<a href="https://twitter.com/" class="fab fa-twitter" target="_blank"></a>
							<a href="https://facebook.com/" class="fab fa-facebook-square" target="_blank"></a>
							<a href="https://instagram.com/" class="fab fa-instagram" target="_blank"></a>
						</div><!-- /.bottom-footer__social -->
						<p class="thm-text-dark">© Copyright <span class="dynamic-year"></span> by TGG</p>
					</div><!-- /.inner-container -->
				</div><!-- /.container -->
			</div><!-- /.bottom-footer -->
		</footer><!-- /.site-footer -->

	</div><!-- /.page-wrapper -->


	<div class="mobile-nav__wrapper">
		<div class="mobile-nav__overlay mobile-nav__toggler"></div>
		<!-- /.mobile-nav__overlay -->
		<div class="mobile-nav__content">
			<span class="mobile-nav__close mobile-nav__toggler"><i class="organik-icon-close"></i></span>

			<div class="logo-box">
				<a href="index.php" aria-label="logo image"><img src="assets/images/logo-light.png" width="155" alt="" /></a>
			</div>
			<!-- /.logo-box -->
			<div class="mobile-nav__container"></div>
			<!-- /.mobile-nav__container -->

			<ul class="mobile-nav__contact list-unstyled">
				<li>
					<i class="organik-icon-email"></i>
					<a href="mailto:needhelp@organik.com">needhelp@organik.com</a>
				</li>
				<li>
					<i class="organik-icon-calling"></i>
					<a href="tel:666-888-0000">666 888 0000</a>
				</li>
			</ul><!-- /.mobile-nav__contact -->
			<div class="mobile-nav__top">
				<div class="mobile-nav__language">
					<img src="assets/images/resources/flag-1-1.jpg" alt="">
					<label class="sr-only" for="language-select">select language</label>
					<!-- /#language-select.sr-only -->
					<select class="selectpicker" id="language-select">
						<option value="english">English</option>
						<option value="arabic">Arabic</option>
					</select>
				</div><!-- /.mobile-nav__language -->
				<div class="main-menu__login">
					<a href="<?php if (isset($_SESSION["lname"])) {
									echo "profile.php";
								} else {
									echo "login.php";
								} ?>">
						<i class="organik-icon-user"></i>
						<?php

						if (isset($_SESSION["lname"])) {
							echo $_SESSION['lname'];
						} else {
							echo "Login / Register";
						}

						?>
					</a>
				</div><!-- /.main-menu__login -->
			</div><!-- /.mobile-nav__top -->



		</div>
		<!-- /.mobile-nav__content -->
	</div>
	<!-- /.mobile-nav__wrapper -->

	<div class="mini-cart">
		<div class="mini-cart__overlay mini-cart__toggler"></div>
		<div class="mini-cart__content">
			<div class="mini-cart__top">
				<h3 class="mini-cart__title">Shopping Cart</h3>
				<span class="mini-cart__close mini-cart__toggler"><i class="organik-icon-close"></i></span>
			</div><!-- /.mini-cart__top -->
			<div class="mini-cart__item">
				<img src="assets/images/products/cart-1-1.jpg" alt="">
				<div class="mini-cart__item-content">
					<div class="mini-cart__item-top">
						<h3><a href="product-details.php">Banana</a></h3>
						<p>$9.99</p>
					</div><!-- /.mini-cart__item-top -->
					<div class="quantity-box">
						<button type="button" class="sub">-</button>
						<input type="number" id="2" value="1" />
						<button type="button" class="add">+</button>
					</div>
				</div><!-- /.mini-cart__item-content -->
			</div><!-- /.mini-cart__item -->
			<div class="mini-cart__item">
				<img src="assets/images/products/cart-1-2.jpg" alt="">
				<div class="mini-cart__item-content">
					<div class="mini-cart__item-top">
						<h3><a href="product-details.php">Tomato</a></h3>
						<p>$9.99</p>
					</div><!-- /.mini-cart__item-top -->
					<div class="quantity-box">
						<button type="button" class="sub">-</button>
						<input type="number" id="2" value="1" />
						<button type="button" class="add">+</button>
					</div>
				</div><!-- /.mini-cart__item-content -->
			</div><!-- /.mini-cart__item -->
			<div class="mini-cart__item">
				<img src="assets/images/products/cart-1-3.jpg" alt="">
				<div class="mini-cart__item-content">
					<div class="mini-cart__item-top">
						<h3><a href="product-details.php">Bread</a></h3>
						<p>$9.99</p>
					</div><!-- /.mini-cart__item-top -->
					<div class="quantity-box">
						<button type="button" class="sub">-</button>
						<input type="number" id="2" value="1" />
						<button type="button" class="add">+</button>
					</div>
				</div><!-- /.mini-cart__item-content -->
			</div><!-- /.mini-cart__item -->
			<a href="checkout.php" class="thm-btn mini-cart__checkout">Proceed To Checkout</a>
		</div><!-- /.mini-cart__content -->
	</div><!-- /.cart-toggler -->

	<div class="search-popup">
		<div class="search-popup__overlay search-toggler"></div>
		<!-- /.search-popup__overlay -->
		<div class="search-popup__content">
			<form action="products.php" method="GET">
				<label for="search" class="sr-only">search here</label><!-- /.sr-only -->
				<input type="text" id="search" name="search" placeholder="Search Here..." />
				<button type="submit" aria-label="search submit" class="thm-btn">
					<i class="organik-icon-magnifying-glass"></i>
				</button>
			</form>
		</div>
		<!-- /.search-popup__content -->
	</div>
	<!-- /.search-popup -->
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
	<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

	<script src="assets/vendors/jquery/jquery-3.5.1.min.js"></script>
	<script src="assets/vendors/bootstrap/bootstrap.bundle.min.js"></script>
	<script src="assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
	<script src="assets/vendors/jarallax/jarallax.min.js"></script>
	<script src="assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js"></script>
	<script src="assets/vendors/jquery-appear/jquery.appear.min.js"></script>
	<script src="assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js"></script>
	<script src="assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js"></script>
	<script src="assets/vendors/jquery-validate/jquery.validate.min.js"></script>
	<script src="assets/vendors/nouislider/nouislider.min.js"></script>
	<script src="assets/vendors/odometer/odometer.min.js"></script>
	<script src="assets/vendors/swiper/swiper.min.js"></script>
	<script src="assets/vendors/tiny-slider/tiny-slider.min.js"></script>
	<script src="assets/vendors/wnumb/wNumb.min.js"></script>
	<script src="assets/vendors/wow/wow.js"></script>
	<script src="assets/vendors/isotope/isotope.js"></script>
	<script src="assets/vendors/countdown/countdown.min.js"></script>
	<!-- template js -->
	<script src="assets/js/organik.js"></script>
</body>

</html>