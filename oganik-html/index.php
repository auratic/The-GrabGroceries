<?php
  session_start();  

  require "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home || TheGrabGroceries</title>
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

    <style>
    .mode
    {
        color: #fff;
        background-color: #4CAF50;
        border: none;
        border-radius: 5px;
        text-align:center;
        font-size: 16px;
        margin-left: 20px;
    }

    .dark-mode 
    {
        background-color: black;
        color: white;
    }

    </style>
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
                            <a href="https://twitter.com/" class="fab fa-twitter" target="_blank"></a>
                            <a href="https://www.facebook.com/" class="fab fa-facebook-square" target="_blank"></a>
                            <a href="https://www.instagram.com/" class="fab fa-instagram" target="_blank"></a>
                        </div><!-- /.topbar__social -->
                        <div class="topbar__info">
                            <i class="organik-icon-email"></i>
                            <p>Email <a href="mailto:thegrabgroceries@gmail.com">thegrabgroceries@gmail.com</a></p>
                        </div><!-- /.topbar__info -->
                    </div><!-- /.topbar__left -->
                    <div class="topbar__right">
                        <div class="topbar__info">
                            <i class="organik-icon-calling"></i>
                            <p>Phone <a href="tel:+60186620551">+60123456789</a></p>
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
                    <div>
                        <button style="outline: none;" class="mode" onclick="myFunction()">Mode</button>
                    </div>
                </div><!-- /.container -->
            </nav>
            <!-- /.main-menu -->
        </header><!-- /.main-header -->

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->


        <section class="main-slider">
            <div class="swiper-container thm-swiper__slider" data-swiper-options='{
                "slidesPerView": 1,
                "loop": true,
                "effect": "fade",
                "autoplay": {
                    "delay": 5000
                },
                "navigation": {
                    "nextEl": "#main-slider__swiper-button-next",
                    "prevEl": "#main-slider__swiper-button-prev"
                }
                }'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="image-layer" style="background-image: url(assets/images/main-slider/main-slider-1-1.jpg);">
                        </div>
                        <!-- /.image-layer -->
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 text-center">
                                    <h2><span>The</span> <br>
                                        Grab Groceries</h2>
                                    <a href="products.php" class=" thm-btn">Shop Now</a>
                                    <!-- /.thm-btn dynamic-radius -->
                                </div><!-- /.col-lg-7 text-right -->
                            </div><!-- /.row -->
                        </div><!-- /.container -->
                    </div><!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="image-layer" style="background-image: url(assets/images/main-slider/main-slider-1-2.jpg);">
                        </div>
                        <!-- /.image-layer -->
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 text-center">
                                    <h2><span>The</span> <br>
                                        Grab Groceries</h2>
                                    <a href="about.php" class=" thm-btn">About Us</a>
                                    <!-- /.thm-btn dynamic-radius -->
                                </div><!-- /.col-lg-7 text-right -->
                            </div><!-- /.row -->
                        </div><!-- /.container -->
                    </div><!-- /.swiper-slide -->
                </div><!-- /.swiper-wrapper -->

                <!-- If we need navigation buttons -->
                <div class="main-slider__nav">
                    <div class="swiper-button-prev" id="main-slider__swiper-button-next"><i class="organik-icon-left-arrow"></i>
                    </div>
                    <div class="swiper-button-next" id="main-slider__swiper-button-prev"><i class="organik-icon-right-arrow"></i></div>
                </div><!-- /.main-slider__nav -->

            </div><!-- /.swiper-container thm-swiper__slider -->
        </section><!-- /.main-slider -->

        <section class="feature-box">
            <div class="container">
                <div class="inner-container wow fadeInUp" data-wow-duration="1500ms">
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
                            <div class="feature-box__single">
                                <i class="organik-icon-global-shipping feature-box__icon"></i>
                                <div class="feature-box__content">
                                    <h3>Return Policy</h3>
                                    <p>Money back guarantee</p>
                                </div><!-- /.feature-box__content -->
                            </div><!-- /.feature-box__single -->
                        </div>
                        <div>
                            <div class="feature-box__single">
                                <i class="organik-icon-delivery-truck feature-box__icon"></i>
                                <div class="feature-box__content">
                                    <h3>Free Shipping</h3>
                                    <p>On all orders over $25.00</p>
                                </div><!-- /.feature-box__content -->
                            </div><!-- /.feature-box__single -->
                        </div>
                        <div>
                            <div class="feature-box__single">
                                <i class="organik-icon-online-store feature-box__icon"></i>
                                <div class="feature-box__content">
                                    <h3>Store Locator</h3>
                                    <p>Find your nearest store</p>
                                </div><!-- /.feature-box__content -->
                            </div><!-- /.feature-box__single -->
                        </div>
                    </div>
                </div><!-- /.inner-container -->
            </div><!-- /.container -->
        </section><!-- /.feature-box -->

        <section class="new-products">
            <img src="assets/images/shapes/new-product-shape-1.png" alt="" class="new-products__shape-1">
            <div class="container">
                <div class="new-products__top">
                    <div class="block-title ">
                        <div class="block-title__decor"></div><!-- /.block-title__decor -->
                        <p id="p2">Recently Added</p>
                        <h3>New Products</h3>
                    </div><!-- /.block-title -->

                    <ul class="post-filter filters list-unstyled">
                        <li class="active filter" data-filter=".filter-item">All</li>
                        <li class="filter" data-filter=".dairy">Dairy</li>
                        <li class="filter" data-filter=".pantry">Pantry
                        </li>
                        <li class="filter" data-filter=".meat">Meat
                        </li>
                        <li class="filter" data-filter=".fruits">Fruits
                        </li>
                        <li class="filter" data-filter=".veg">Vagetables
                        </li>
                    </ul>
                </div><!-- /.new-products__top -->
                <div class="row">
                    <?php
                        $sql = "SELECT * from item";

                        if ($result = mysqli_query($link, $sql)) 
                        {

                            while ($row = mysqli_fetch_assoc($result)) 
                            {

                                echo'
                                <div class="col-md-6 col-lg-4">
                                    <div class="product-card">
                                        <div class="product-card__image">
                                            <img src="assets/images/items/'.$row['image'].'" alt="">
                                            <div class="product-card__image-content" style="cursor:pointer;"
                                                onclick="location.href = `product-details.php?item_id='.$row['item_id'].'`">
                                                <a href="#"><i class="organik-icon-heart"></i></a>
                                                <a href="cart.php"><i class="organik-icon-shopping-cart"></i></a>
                                                </div><!-- /.product-card__image-content -->
                                        </div><!-- /.product-card__image -->
                                        <div class="product-card__content">
                                            <div class="product-card__left">
                                                <h3><a href="product-details.php">'.$row['item'].'</a></h3>
                                                <p>RM'.$row['cost'].'</p>
                                            </div><!-- /.product-card__left -->
                                            <div class="product-card__right">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div><!-- /.product-card__right -->
                                        </div><!-- /.product-card__content -->
                                    </div><!-- /.product-card -->
                                </div>';
                            }
                        } 
                    ?>
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.new-products -->

        <section class="offer-banner">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="0ms">
                        <div class="offer-banner__box" style="background-image: url(assets/images/resources/offer-banner-1-1.jpg);">
                            <div class="offer-banner__content">
                                <h3><span>100%</span> <br>Original</h3>
                                <p>Best quality products</p>
                                <a href="products.php" class="thm-btn">Order Now</a><!-- /.thm-btn -->
                            </div><!-- /.offer-banner__content -->
                        </div><!-- /.offer-banner__box -->
                    </div><!-- /.col-md-6 -->
                    <div class="col-md-6 wow fadeInRight" data-wow-duration="1500ms" data-wow-delay="100ms">
                        <div class="offer-banner__box" style="background-image: url(assets/images/resources/offer-banner-1-2.jpg);">
                            <div class="offer-banner__content">
                                <h3><span>100%</span> <br>Organic</h3>
                                <p>Quality Organic Food Store</p>
                                <a href="products.php" class="thm-btn">Order Now</a><!-- /.thm-btn -->
                            </div><!-- /.offer-banner__content -->
                        </div><!-- /.offer-banner__box -->
                    </div><!-- /.col-md-6 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.offer-banner -->

        <section class="funfact-one jarallax" data-jarallax data-speed="0.3" data-imgPosition="50% 50%">
            <img src="assets/images/backgrounds/funfact-bg-1-1.jpg" class="jarallax-img" alt="">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-md-6 col-lg-3  wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="0ms">
                        <div class="funfact-one__single">
                            <h3 class="odometer" data-count="8080">00</h3>
                            <p>Organic Products Available</p>
                        </div><!-- /.funfact-one__single -->
                    </div><!-- /.col-md-6 col-lg-3 -->
                    <div class="col-md-6 col-lg-3  wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="100ms">
                        <div class="funfact-one__single">
                            <h3 class="odometer" data-count="697">00</h3>
                            <p>Healthy Recipes</p>
                        </div><!-- /.funfact-one__single -->
                    </div><!-- /.col-md-6 col-lg-3 -->
                    <div class="col-md-6 col-lg-3  wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="200ms">
                        <div class="funfact-one__single">
                            <h3 class="odometer" data-count="440">00</h3>
                            <p>Expert Team Mebers</p>
                        </div><!-- /.funfact-one__single -->
                    </div><!-- /.col-md-6 col-lg-3 -->
                    <div class="col-md-6 col-lg-3  wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="300ms">
                        <div class="funfact-one__single">
                            <h3 class="odometer" data-count="2870">00</h3>
                            <p>Satisfied Customers</p>
                        </div><!-- /.funfact-one__single -->
                    </div><!-- /.col-md-6 col-lg-3 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.funfact-one -->

        <section class="call-to-action">
            <img src="assets/images/shapes/call-shape-1.png" alt="" class="call-to-action__shape-1">
            <img src="assets/images/shapes/call-shape-2.png" alt="" class="call-to-action__shape-2 wow fadeInLeft" data-wow-duration="1500ms">
            <h2 class="floated-text">Oragnic</h2><!-- /.floated-text -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-6 clearfix">
                        <img src="assets/images/resources/call-1-1.jpg" class="call-to-action__image" alt="">
                    </div><!-- /.col-md-12 col-lg-12 col-xl-12 -->
                    <div class="col-md-12 col-lg-12 col-xl-6 clearfix">
                        <div class="call-to-action__content">
                            <div class="block-title text-left">
                                <div class="block-title__decor" style="background-image: url(assets/images/shapes/leaf-2-1.png);"></div>
                                <!-- /.block-title__decor -->
                                <p>Shopping Store</p>
                                <h3>Organic Food Only</h3>
                            </div><!-- /.block-title -->
                            <p><i>TheGrabGroceries</i> is a low-cost online general store that gets items crosswise over classifications like 
                                grocery, natural products and vegetables, excellence and health, family unit care, infant care, pet consideration 
                                and meats and fish conveyed to your doorstep.</p>
                            <div class="call-to-action__wrap">
                                <div class="row no-gutters">
                                    <div class="col-md-6">
                                        <div class="call-to-action__box">
                                            <i class="organik-icon-farmer"></i>
                                            <h3>Professional
                                                Farmers</h3>
                                        </div><!-- /.call-to-action__box -->
                                    </div><!-- /.col-md-6 -->
                                    <div class="col-md-6">
                                        <div class="call-to-action__box">
                                            <i class="organik-icon-farm"></i>
                                            <h3>Solution
                                                for Farming</h3>
                                        </div><!-- /.call-to-action__box -->
                                    </div><!-- /.col-md-6 -->
                                </div><!-- /.row -->
                            </div><!-- /.call-to-action__wrap -->
                            <a href="products.php" class="thm-btn">Order Now</a><!-- /.thm-btn -->
                        </div><!-- /.call-to-action__content -->
                    </div><!-- /.col-md-12 col-lg-12 col-xl-12 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.call-to-action -->

        <div class="client-carousel ">
            <div class="container">
                <div class="thm-swiper__slider swiper-container" data-swiper-options='{"spaceBetween": 140, "slidesPerView": 5, "autoplay": { "delay": 5000 }, "breakpoints": {
                "0": {
                    "spaceBetween": 30,
                    "slidesPerView": 2
                },
                "375": {
                    "spaceBetween": 30,
                    "slidesPerView": 2
                },
                "575": {
                    "spaceBetween": 30,
                    "slidesPerView": 3
                },
                "767": {
                    "spaceBetween": 50,
                    "slidesPerView": 4
                },
                "991": {
                    "spaceBetween": 50,
                    "slidesPerView": 5
                },
                "1199": {
                    "spaceBetween": 100,
                    "slidesPerView": 5
                }
            }}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/brand-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                    </div><!-- /.swiper-wrapper -->
                </div><!-- /.thm-swiper__slider -->
            </div><!-- /.container -->
        </div><!-- /.client-carousel -->

        <section class="call-to-action-two">
            <img src="assets/images/shapes/call-shape-2-1.png" alt="" class="call-to-action-two__shape-1">
            <img src="assets/images/shapes/call-shape-2-2.png" alt="" class="call-to-action-two__shape-2">
            <img src="assets/images/shapes/call-shape-2-3.png" alt="" class="call-to-action-two__shape-3">
            <img src="assets/images/shapes/call-shape-2-4.png" alt="" class="call-to-action-two__shape-4">
            <img src="assets/images/shapes/call-shape-2-5.png" alt="" class="call-to-action-two__shape-5">
            <img src="assets/images/shapes/call-shape-2-6.png" alt="" class="call-to-action-two__shape-6">
            <div class="container">
                <div class="row flex-xl-row-reverse">
                    <div class="col-lg-12 col-xl-6">
                        <div class="call-to-action-two__image">
                            <h2 class="floated-text">Healthy</h2><!-- /.floated-text -->
                            <img src="assets/images/resources/call-2-1.png" alt="">
                        </div><!-- /.call-to-action-two__image -->
                    </div><!-- /.col-md-6 -->
                    <div class="col-lg-12 col-xl-6">
                        <div class="call-to-action-two__content">
                            <div class="block-title text-left">
                                <div class="block-title__decor"></div><!-- /.block-title__decor -->
                                <p>Pure Organic Products</p>
                                <h3>Everyday Fresh Food</h3>
                            </div><!-- /.block-title -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Look no further! We got everything for you.</h4>
                                    <p>Browse more than 5,000 items at costs lower than markets each day!</p>
                                </div><!-- /.col-md-6 -->
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li>
                                            <i class="far fa-check-circle"></i>
                                                We focus on what you need.
                                        </li>
                                        <li>
                                            <i class="far fa-check-circle"></i>
                                                Amazing finds only here!
                                        </li>
                                        <li>
                                            <i class="far fa-check-circle"></i>
                                                Exciting treats available daily.
                                        </li>
                                        <li>
                                            <i class="far fa-check-circle"></i>
                                                Make delicious creations.
                                        </li>
                                        <li>
                                            <i class="far fa-check-circle"></i>
                                                Stocked for your needs.
                                        </li>
                                    </ul><!-- /.list-unstyled -->
                                </div><!-- /.col-md-6 -->
                            </div><!-- /.row -->
                            <a href="products.php" class="thm-btn">Order Now</a><!-- /.thm-btn -->
                        </div><!-- /.call-to-action-two__content -->
                    </div><!-- /.col-md-6 -->

                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.call-to-action-two -->

        <section class="testimonials-one">
            <div class="testimonials-one__head">
                <div class="container">
                    <div class="block-title text-center">
                        <div class="block-title__decor"></div><!-- /.block-title__decor -->
                        <p>Our Testimonials</p>
                        <h3>What People Say?</h3>
                    </div><!-- /.block-title -->
                </div><!-- /.container -->
            </div><!-- /.testimonials-one__head -->
            <div class="container">
                <div class="thm-tiny__slider" id="testimonials-one-box" data-tiny-options='{
            "container": "#testimonials-one-box",
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
                        <div class="testimonials-one__single">
                            <div class="testimonials-one__image">
                                <img src="assets/images/resources/testi-1-1.png" alt="">
                            </div><!-- /.testimonials-one__image -->
                            <div class="testimonials-one__content">
                                <p>Great independent grocery store with a wide variety of gourmet items and hard to find food stuffs. 
                                    A great butcher offering local seafood and grass fed meats.</p>
                                <h3>Winnie Collier</h3>
                                <span>Customer</span>
                            </div><!-- /.testimonials-one__content -->
                        </div><!-- /.testimonials-one__single -->
                    </div>
                    <div>
                        <div class="testimonials-one__single">
                            <div class="testimonials-one__image">
                                <img src="assets/images/resources/testi-1-2.png" alt="">
                            </div><!-- /.testimonials-one__image -->
                            <div class="testimonials-one__content">
                                <p>Staff is the best in a health food store and locally owned. I only get my supplements from Staff 
                                    because they have a knowledgeable staff.</p>
                                <h3>Helen Woods</h3>
                                <span>Customer</span>
                            </div><!-- /.testimonials-one__content -->
                        </div><!-- /.testimonials-one__single -->
                    </div>
                    <div>
                        <div class="testimonials-one__single">
                            <div class="testimonials-one__image">
                                <img src="assets/images/resources/testi-1-3.png" alt="">
                            </div><!-- /.testimonials-one__image -->
                            <div class="testimonials-one__content">
                                <p>Staff allows me to live out my dreams of becoming a zero-waster. The best bulk selection around. 
                                    Organic, beautiful produce.</p>
                                <h3>Ethan Thomas</h3>
                                <span>Customer</span>
                            </div><!-- /.testimonials-one__content -->
                        </div><!-- /.testimonials-one__single -->
                    </div>
                </div>
            </div><!-- /.container -->
        </section><!-- /.testimonials-one -->

        <section class="gallery-one">
            <div class="container-fluid">
                <div class="block-title text-center">
                    <div class="block-title__decor"></div><!-- /.block-title__decor -->
                    <p>We’re On Instagram</p>
                    <h3>Shop on Instagram</h3>
                </div><!-- /.block-title -->
                <div class="swiper-container thm-swiper__slider" data-swiper-options='{"slidesPerView": 1, "loop": true,
        "autoplay": {
            "delay": 5000
        }, "breakpoints": {
            "0": {
                "spaceBetween": 0,
                "slidesPerView": 1
            },
            "375": {
                "spaceBetween": 0,
                "slidesPerView": 1
            },
            "575": {
                "spaceBetween": 10,
                "slidesPerView": 2
            },
            "767": {
                "spaceBetween": 10,
                "slidesPerView": 3
            },
            "991": {
                "spaceBetween": 10,
                "slidesPerView": 5
            },
            "1199": {
                "spaceBetween": 10,
                "slidesPerView": 5
            }
        }}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-1.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-1.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-2.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-2.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-3.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-3.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-4.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-4.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-5.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-5.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-1.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-1.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-2.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-2.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-3.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-3.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-4.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-4.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-5.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-5.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-1.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-1.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-2.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-2.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-3.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-3.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-4.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-4.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-5.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-5.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-1.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-1.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-2.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-2.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-3.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-3.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-4.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-4.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-5.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-5.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-1.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-1.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-2.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-2.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-3.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-3.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-4.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-4.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <div class="gallery-one__item">
                                <img src="assets/images/gallery/gallery-1-5.jpg" alt="">
                                <a href="assets/images/gallery/gallery-1-5.jpg" class="img-popup"><i class="fa fa-plus"></i></a>
                            </div><!-- /.gallery-one__item -->
                        </div><!-- /.swiper-slide -->
                    </div><!-- /.swiper-wrapper -->
                </div><!-- /.swiper-container thm-swiper__slider -->
            </div><!-- /.container-fluid -->
        </section><!-- /.gallery-one -->

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
            <form action="#">
                <label for="search" class="sr-only">search here</label><!-- /.sr-only -->
                <input type="text" id="search" placeholder="Search Here..." />
                <button type="submit" aria-label="search submit" class="thm-btn">
                    <i class="organik-icon-magnifying-glass"></i>
                </button>
            </form>
        </div>
        <!-- /.search-popup__content -->
    </div>
    <!-- /.search-popup -->
    
    <p id="verified" style="display: none;"><?php echo (isset($_SESSION["loggedin"]) && (isset($_SESSION["verified"]) && $_SESSION["verified"] == "false")) ? "false" : "true"; ?></p>

    <div id="snackbar">
        <div>
            <h4 style="color: var(--thm-base)">Verify email</h4>
            <p>Verify email enable transaction functionality</p>
        </div>
        <div>
            <a href="verify.php">
                <button type="button" class="btn btn-default" style="background-color: var(--thm-base); color: white;">Verify</button>
            </a>
            <button type="button" class="btn btn-default" id="verified-btn">Close</button>
        </div>
    </div>
    
    <!--back to top!-->
    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

    <script>
        var verified = document.querySelector("#verified").innerHTML;
        var snackbar = document.querySelector("#snackbar");

        if(verified == "false") {
            snackbar.style.display = "flex";
        }

        document.querySelector("#verified-btn").onclick = () => {
            snackbar.style.animation = "fadeout 1s";

            setTimeout(() => {
                snackbar.style.display = "none";

            }, 900);
        }
    </script>

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

    <script>
        function myFunction() 
        {
            var element = document.body;
            element.classList.toggle("dark-mode");
            document.querySelector("#p2").style.color = "white";
        }
        
    </script>
</body>

</html>