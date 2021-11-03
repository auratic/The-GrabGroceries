<?php include 'cust_header.php'; ?>


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
                <div class="image-layer" style="background-image: url('https://images.theconversation.com/files/50485/original/b649fxyy-1402045852.jpg?ixlib=rb-1.1.0&q=45&auto=format&w=926&fit=clip'); filter:brightness(0.5)">
                </div>
                <!-- /.image-layer -->
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 text-center">
                            <h2><span><?php echo $lang['title']?></span> <br></h2>
                            <a href="products.php" class=" thm-btn"><?php echo $lang['shopnow']?></a>
                            <!-- /.thm-btn dynamic-radius -->
                        </div><!-- /.col-lg-7 text-right -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.swiper-slide -->
            <div class="swiper-slide">
                <div class="image-layer" style="background-image: url('https://www.cupitfood.com/wp-content/uploads/2018/08/fruits-delivery-2560x1280.jpg'); filter:brightness(0.5)">
                </div>
                <!-- /.image-layer -->
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 text-center">
                            <h2><span><?php echo $lang['title']?></span> <br></h2>
                            <a href="about.php" class=" thm-btn"><?php echo $lang['about']?></a>
                            <!-- /.thm-btn dynamic-radius -->
                        </div><!-- /.col-lg-7 text-right -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.swiper-slide -->
        </div><!-- /.swiper-wrapper -->

        <!-- If we need navigation buttons -->
        <!--
                <div class="main-slider__nav">
                    <div class="swiper-button-prev" id="main-slider__swiper-button-next"><i class="organik-icon-left-arrow"></i>
                    </div>
                    <div class="swiper-button-next" id="main-slider__swiper-button-prev"><i class="organik-icon-right-arrow"></i></div>
                </div>-->
        <!-- /.main-slider__nav -->

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
                            <h3><?php echo $lang['return']?></h3>
                            <p><?php echo $lang['p7']?></p>
                        </div><!-- /.feature-box__content -->
                    </div><!-- /.feature-box__single -->
                </div>
                <div>
                    <div class="feature-box__single">
                        <i class="organik-icon-delivery-truck feature-box__icon"></i>
                        <div class="feature-box__content">
                            <h3><?php echo $lang['freeship']?></h3>
                            <p><?php echo $lang['over100']?></p>
                        </div><!-- /.feature-box__content -->
                    </div><!-- /.feature-box__single -->
                </div>
                <div>
                    <div class="feature-box__single">
                        <i class="organik-icon-online-store feature-box__icon"></i>
                        <div class="feature-box__content">
                            <h3><?php echo $lang['locator']?></h3>
                            <p><?php echo $lang['nearest']?></p>
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
                <p id="p2"><?php echo $lang['recent']?></p>
                <h3><?php echo $lang['newprods']?></h3>
            </div><!-- /.block-title -->
        </div><!-- /.new-products__top -->
        <div class="row">
            <?php
            $sql = "
                SELECT * FROM category INNER JOIN item ON category.category_id = item.category_id
                WHERE item.item_status = 'Active' AND category.category_status = 'Active' AND category.category_name != 'Not Set'
                ORDER BY RAND()
                LIMIT 6";

            if ($result = mysqli_query($link, $sql)) {

                while ($row = mysqli_fetch_assoc($result)) {

                    echo '
                                <div class="col-md-6 col-lg-4">
                                    <div class="product-card">
                                        <div class="product-card__image">
                                            <img src="assets/images/items/' . $row['image'] . '" alt="">
                                            <div class="product-card__image-content" style="cursor:pointer;"
                                                onclick="location.href = `product-details.php?item_id=' . $row['item_id'] . '`">
                                                <a href="#"><i class="organik-icon-heart"></i></a>
                                                </div><!-- /.product-card__image-content -->
                                        </div><!-- /.product-card__image -->
                                        <div class="product-card__content">
                                            <div class="product-card__left">
                                                <h3><a href="product-details.php">' . $row['item'] . '</a></h3>
                                                <p>RM' . $row['cost'] . '</p>
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
                        <h3><span>100%</span> <br><?php echo $lang['ori']?></h3>
                        <p><?php echo $lang['quality']?></p>
                        <a href="products.php" class="thm-btn"><?php echo $lang['order_nw']?></a><!-- /.thm-btn -->
                    </div><!-- /.offer-banner__content -->
                </div><!-- /.offer-banner__box -->
            </div><!-- /.col-md-6 -->
            <div class="col-md-6 wow fadeInRight" data-wow-duration="1500ms" data-wow-delay="100ms">
                <div class="offer-banner__box" style="background-image: url(assets/images/resources/offer-banner-1-2.jpg);">
                    <div class="offer-banner__content">
                        <h3><span>100%</span> <br><?php echo $lang['organic']?></h3>
                        <p><?php echo $lang['qualityF']?></p>
                        <a href="products.php" class="thm-btn"><?php echo $lang['order_nw']?></a><!-- /.thm-btn -->
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
                    <p><?php echo $lang['p8']?></p>
                </div><!-- /.funfact-one__single -->
            </div><!-- /.col-md-6 col-lg-3 -->
            <div class="col-md-6 col-lg-3  wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="100ms">
                <div class="funfact-one__single">
                    <h3 class="odometer" data-count="697">00</h3>
                    <p><?php echo $lang['p9']?></p>
                </div><!-- /.funfact-one__single -->
            </div><!-- /.col-md-6 col-lg-3 -->
            <div class="col-md-6 col-lg-3  wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="200ms">
                <div class="funfact-one__single">
                    <h3 class="odometer" data-count="440">00</h3>
                    <p><?php echo $lang['p16']?></p>
                </div><!-- /.funfact-one__single -->
            </div><!-- /.col-md-6 col-lg-3 -->
            <div class="col-md-6 col-lg-3  wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="300ms">
                <div class="funfact-one__single">
                    <h3 class="odometer" data-count="2870">00</h3>
                    <p><?php echo $lang['p10']?></p>
                </div><!-- /.funfact-one__single -->
            </div><!-- /.col-md-6 col-lg-3 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.funfact-one -->

<section class="call-to-action">
    <img src="assets/images/shapes/call-shape-1.png" alt="" class="call-to-action__shape-1">
    <img src="assets/images/shapes/call-shape-2.png" alt="" class="call-to-action__shape-2 wow fadeInLeft" data-wow-duration="1500ms">
    <h2 class="floated-text"><?php echo $lang['organic']?></h2><!-- /.floated-text -->
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
                        <p><?php echo $lang['p11']?></p>
                        <h3><?php echo $lang['p12']?></h3>
                    </div><!-- /.block-title -->
                    <p><i><?php echo $lang['title']?></i> <?php echo $lang['p13']?></p>
                    <div class="call-to-action__wrap">
                        <div class="row no-gutters">
                            <div class="col-md-6">
                                <div class="call-to-action__box">
                                    <i class="organik-icon-farmer"></i>
                                    <h3><?php echo $lang['p14']?></h3>
                                </div><!-- /.call-to-action__box -->
                            </div><!-- /.col-md-6 -->
                            <div class="col-md-6">
                                <div class="call-to-action__box">
                                    <i class="organik-icon-farm"></i>
                                    <h3><?php echo $lang['p15']?></h3>
                                </div><!-- /.call-to-action__box -->
                            </div><!-- /.col-md-6 -->
                        </div><!-- /.row -->
                    </div><!-- /.call-to-action__wrap -->
                    <a href="products.php" class="thm-btn"><?php echo $lang['order_nw']?></a><!-- /.thm-btn -->
                </div><!-- /.call-to-action__content -->
            </div><!-- /.col-md-12 col-lg-12 col-xl-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.call-to-action -->


<!--
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
        -->

<script>
    /*
    var verified = document.querySelector("#verified").innerHTML;
    var snackbar = document.querySelector("#snackbar");

    if (verified == "false") {
        snackbar.style.display = "flex";
    }

    document.querySelector("#verified-btn").onclick = () => {
        snackbar.style.animation = "fadeout 1s";

        setTimeout(() => {
            snackbar.style.display = "none";

        }, 900);
    }
    */
</script>

<?php include 'cust_footer.php'; ?>