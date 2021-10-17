<?php
    session_start();
    
    require "config.php";

    if(isset($_GET["item_id"])) {
        $sql = "SELECT * FROM item WHERE item_id = " . $_GET["item_id"];
    } else {
        $sql = "SELECT * FROM item WHERE item_id = 200000001";
    }

    if($result = mysqli_query($link, $sql)) {
        $row = mysqli_fetch_assoc($result);
    }

    if(isset($_POST["addtocart"]))
    {
        $sqll = "SELECT * FROM cust_cart WHERE user_id = ".$_SESSION['userid']." AND item_id = ".$_POST['iid'];
        if($result=mysqli_query($link, $sqll))
        {
            if (mysqli_num_rows($result) == 1) 
            {
                while($row = mysqli_fetch_assoc($result))
                {
                    $Quantity = $row['quantity'] + $_POST['item_quantity'];
                    $sql = "UPDATE cust_cart SET quantity = $Quantity WHERE cart_id = ".$row['cart_id'];
                }
            }
            else
            {
                $sql = "INSERT INTO cust_cart (user_id, item_id, quantity)VALUES (".$_SESSION['userid'].", ".$_POST['iid'].", ".$_POST['item_quantity']." )";
            }
        }
        
        if (mysqli_query($link, $sql))
        {
            echo "
                <script>
                    location.href = 'cart.php';
                </script>";
        }
        else
        {
            echo "
                <script>
                    alert('Error: " . $sql . "\n" . mysqli_error($link) . "')
                </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product || TheGrabGroceries</title>
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
                            <img src="assets/images/logo-dark.png" width="105" alt="">
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
                        <a href="<?php if(isset($_SESSION["lname"])) { echo "profile.php";} else { echo "login.php"; }?>" >
                            <i class="organik-icon-user"></i>
                                <?php 

                                if(isset($_SESSION["lname"])) { 
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
                            <?php 
                                if(isset($_SESSION["loggedin"]))
                                    echo "
                                    <ul>
                                        <li><a href='cart.php'>Cart Page</a></li>
                                        <li><a href='checkout.php'>Checkout</a></li>
                                    </ul>";
                            ?>
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
                <h2>Product</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li>/</li>
                    <li><span>Product</span></li>
                </ul><!-- /.thm-breadcrumb list-unstyled -->
            </div><!-- /.container -->
        </section><!-- /.page-header -->


        <section class="product_detail">
            <div class="container">
            <form action="#" method="POST">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="product_detail_image">
                            <img src="<?php echo "assets/images/items/".$row["image"]; ?>" alt="">
                            <input type="hidden" name="ipic" value="<?php echo $row["image"] ?>">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="product_detail_content">
                            <h2><?php echo $row["item"] ?></h2>
                            <input type="hidden" name="iname" value="<?php echo $row["item"] ?>">
                            <div class="product_detail_review_box">
                                <div class="product_detail_price_box">
                                    <p>RM<?php echo $row["cost"] ?></p>
                                    <input type="hidden" name="iprice" value="<?php echo $row["cost"] ?>">
                                </div>
                                <div class="product_detail_review">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#" class="deactive"><i class="fa fa-star"></i></a>
                                    <span>2 Customer Reviews</span>
                                </div>
                            </div>
                            <div class="product_detail_text">
                                <p><?php echo $row["description"] ?></p>
                            </div>
                            <ul class="list-unstyled product_detail_address">
                                <li>Item ID: <?php echo $row["item_id"] ?></li>
                                <input type="hidden" name="iid" value="<?php echo $row["item_id"] ?>">
                                <li><i><?php echo $row["stock"] ?> piece available</i></li>
                            </ul>
                                <div class="product-quantity-box">
                                    <div class="quantity-box">
                                        <button type="button" class="sub">-</button>
                                        <input type="number" name="item_quantity" id="item_quantity" value="1" />
                                        <button type="button" class="add">+</button>
                                    </div>
                                    <div class="addto-cart-box">
                                        <input type="submit" class="thm-btn" value="Add to Cart" name="addtocart">
                                    </div>
                                    <div class="wishlist_btn">
                                        <a href="#" class="thm-btn">Add to Wishlist</a>
                                    </div>
                                </div>
                        </form>
                            <ul class="list-unstyled category_tag_list">
                                <li><span>Category:</span> <?php echo $row["category"] ?></li>
                            </ul>
                            <div class="product_detail_share_box">
                                <div class="share_box_title">
                                    <h2>Share with friends</h2>
                                </div>
                                <div class="share_box_social">
                                    <a href="#"><i class="fab fa-facebook-square"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="product-tab-box tabs-box">
                            <ul class="tab-btns tab-buttons clearfix list-unstyled">
                                <li data-tab="#desc" class="tab-btn"><span>description</span></li>
                                <li data-tab="#addi__info" class="tab-btn"><span>Additional info</span></li>
                                <li data-tab="#review" class="tab-btn active-btn"><span>reviews</span></li>
                            </ul>
                            <div class="tabs-content">
                                <div class="tab" id="desc">
                                    <div class="product-details-content">
                                        <div class="desc-content-box">
                                            <p>Lorem ipsum dolor sit amet sectetur adipiscin elit cras feuiat antesed
                                                ces condimentum viverra duis autue nim convallis id diam vitae duis
                                                egety dictum erosin dictum sem. Vivamus sed molestie sapien aliquam et
                                                facilisis arcu dut molestie augue suspendisse sodales tortor nunced quis
                                                cto ligula posuere cursus keuis aute irure dolor in reprehenderit in
                                                voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                                                sint occaecated cupidatat non proident sunt in culpa qui officia
                                                deserunt mollit anim id est laborum ivamus sed molestie sapien.</p>
                                            <p class="desc-content-box_bottom">Aliquam et facilisis arcuut olestie
                                                augue. Suspendisse sodales tortor nunc quis auctor ligula posuere cursus
                                                duis aute irure dolor in reprehenderit in voluptate velit esse cill
                                                doloreeu fugiat nulla pariatur excepteur sint occaecat cupidatat non
                                                proident sunt in culpa qui officia deserunt mollit anim id est laborum.
                                                Vivaus sed delly molestie sapien. Aliquam et facilisis arcuut molestie
                                                augue. </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab" id="addi__info">
                                    <ul class="additionali_nfo list-unstyled">
                                        <li><span>Name:</span><?php echo $row["item"] ?></li>
                                        <li><span>Expiry Date:</span><?php echo $row["exp_date"] ?></li>
                                        <li><span>Category:</span><?php echo $row["category"] ?></li>
                                        <li><span>Stock:</span><?php echo $row["stock"] ?></li>
                                    </ul>
                                </div>

                                <div class="tab active-tab" id="review">
                                    <div class="reviews-box">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="product_reviews_box">
                                                    <h3 class="product_reviews_title">2 Product reviews</h3>
                                                    <div class="product_reviews_single">
                                                        <div class="product_reviews_image">
                                                            <img src="assets/images/products/review-1.jpg" alt="">
                                                        </div>
                                                        <div class="product_reviews_content">
                                                            <h3>Kevin Martins<span>15 Nov, 2019</span></h3>
                                                            <p>Lorem ipsum is simply free text used by copytyping refreshing.
                                                                Neque porro est qui dolorem ipsum quia quaed inventore veritatis
                                                                et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                                            <div class="product_reviews_rating product_detail_review">
                                                                <a href="#"><i class="fa fa-star"></i></a>
                                                                <a href="#"><i class="fa fa-star"></i></a>
                                                                <a href="#"><i class="fa fa-star"></i></a>
                                                                <a href="#"><i class="fa fa-star"></i></a>
                                                                <a href="#" class="deactive"><i class="fa fa-star"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product_reviews_single">
                                                        <div class="product_reviews_image">
                                                            <img src="assets/images/products/review-2.jpg" alt="">
                                                        </div>
                                                        <div class="product_reviews_content">
                                                            <h3>Kevin Martins<span>15 Nov, 2019</span></h3>
                                                            <p>Lorem ipsum is simply free text used by copytyping refreshing.
                                                                Neque porro est qui dolorem ipsum quia quaed inventore veritatis
                                                                et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                                            <div class="product_reviews_rating product_detail_review">
                                                                <a href="#"><i class="fa fa-star"></i></a>
                                                                <a href="#"><i class="fa fa-star"></i></a>
                                                                <a href="#"><i class="fa fa-star"></i></a>
                                                                <a href="#"><i class="fa fa-star"></i></a>
                                                                <a href="#" class="deactive"><i class="fa fa-star"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="add_review_box">
                                                    <h3 class="add_review_title">Add a review</h3>
                                                    <div class="add_review_rating">
                                                        <span>Rate this Product?</span>
                                                        <a href="#"><i class="fa fa-star"></i></a>
                                                        <a href="#"><i class="fa fa-star"></i></a>
                                                        <a href="#"><i class="fa fa-star"></i></a>
                                                        <a href="#"><i class="fa fa-star"></i></a>
                                                        <a href="#" class="deactive"><i class="fa fa-star"></i></a>
                                                    </div>
                                                    <form class="add_review_form" action="#">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="input-box">
                                                                    <textarea name="review" placeholder="Write review" required=""></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="input-box">
                                                                    <input type="text" name="name" placeholder="Full name" required="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-box">
                                                                    <input type="email" name="email" placeholder="Email address" required="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <div class="review_submit_btn">
                                                                    <a href="#" class="thm-btn">Submit Review</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="product-two">
            <div class="container">
                <div class="block-title text-center">
                    <div class="block-title__decor"></div><!-- /.block-title__decor -->
                    <p>Recently Added</p>
                    <h3>Similar Products</h3>
                </div><!-- /.block-title -->
                <div class="thm-tiny__slider" id="product-two__carousel" data-tiny-options='{
                    "container": "#product-two__carousel",
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
                        <div class="product-card__two">
                            <div class="product-card__two-image">
                                <span class="product-card__two-sale">sale</span>
                                <img src="assets/images/products/product-2-1.jpg" alt="">
                                <div class="product-card__two-image-content">
                                    <a href="#"><i class="organik-icon-visibility"></i></a>
                                    <a href="#"><i class="organik-icon-heart"></i></a>
                                    <a href="cart.php"><i class="organik-icon-shopping-cart"></i></a>
                                </div><!-- /.product-card__two-image-content -->
                            </div><!-- /.product-card__two-image -->
                            <div class="product-card__two-content">
                                <h3><a href="product-details.php">Banana</a></h3>
                                <div class="product-card__two-stars">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div><!-- /.product-card__two-stars -->
                                <p>$1.00</p>

                            </div><!-- /.product-card__two-content -->
                        </div><!-- /.product-card__two -->
                    </div>
                    <div>
                        <div class="product-card__two">
                            <div class="product-card__two-image">
                                <img src="assets/images/products/product-2-2.jpg" alt="">
                                <div class="product-card__two-image-content">
                                    <a href="#"><i class="organik-icon-visibility"></i></a>
                                    <a href="#"><i class="organik-icon-heart"></i></a>
                                    <a href="cart.php"><i class="organik-icon-shopping-cart"></i></a>
                                </div><!-- /.product-card__two-image-content -->
                            </div><!-- /.product-card__two-image -->
                            <div class="product-card__two-content">
                                <h3><a href="product-details.php">Olive Oil</a></h3>
                                <div class="product-card__two-stars">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div><!-- /.product-card__two-stars -->
                                <p>$7.00</p>

                            </div><!-- /.product-card__two-content -->
                        </div><!-- /.product-card__two -->
                    </div>
                    <div>
                        <div class="product-card__two">
                            <div class="product-card__two-image">
                                <img src="assets/images/products/product-2-3.jpg" alt="">
                                <div class="product-card__two-image-content">
                                    <a href="#"><i class="organik-icon-visibility"></i></a>
                                    <a href="#"><i class="organik-icon-heart"></i></a>
                                    <a href="cart.php"><i class="organik-icon-shopping-cart"></i></a>
                                </div><!-- /.product-card__two-image-content -->
                            </div><!-- /.product-card__two-image -->
                            <div class="product-card__two-content">
                                <h3><a href="product-details.php">Eggs</a></h3>
                                <div class="product-card__two-stars">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div><!-- /.product-card__two-stars -->
                                <p>$3.00</p>

                            </div><!-- /.product-card__two-content -->
                        </div><!-- /.product-card__two -->
                    </div>
                </div>
            </div><!-- /.container -->
        </section><!-- /.product-two -->

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
                    <a href="<?php if(isset($_SESSION["lname"])) { echo "profile.php";} else { echo "login.php"; }?>" >
                            <i class="organik-icon-user"></i>
                                <?php 

                                if(isset($_SESSION["lname"])) { 
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
    <script src="assets/js/store.js" async></script>

    <script>
        function addToCartFunction(){
            // Get the value from the span
            quantityValue = $('.number').html();
            prodIdValue = $('.prodID').html();

            // Store the values in hidden entry elements
            $("#item_quantity").val(quantityValue);
            $("#item_id").val(prodIdValue);

            // Submit form using ID "add-to-cart-form"
            $("#add-to-cart-form").action = "cart.php";
            $("#add-to-cart-form").submit();
        }
    </script>
</body>

</html>