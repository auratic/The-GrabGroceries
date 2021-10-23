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
                            <a href="cust_contact.php">Contact</a>
                        </li>
                        <li>
                            <a href="cust_contact.php">Help</a>
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
                            <a href="cust_profile.php">My Account</a>
                        </li>
                        <li>
                            <a href="cust_contact.php">Support</a>
                        </li>
                        <li>
                            <a href="cust_contact.php">FAQs</a>
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
                                echo "cust_profile.php";
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

<!--back to top!-->
<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

<!-- template js -->
<script src="assets/js/organik.js"></script>

</body>

</html>