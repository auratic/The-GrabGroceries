<?php
include 'cust_header.php';

if (isset($_GET["item_id"])) {
    $sql = "SELECT * FROM item WHERE item_id = " . $_GET["item_id"];
} else {
    $sql = "SELECT * FROM item WHERE item_id = 200000001";
}

if ($result = mysqli_query($link, $sql)) {
    $row = mysqli_fetch_assoc($result);

    $sql_category = "SELECT * FROM item INNER JOIN category ON item.category_id = category.category_id";
    $category_result =  mysqli_query($link, $sql_category);
    $category_row = mysqli_fetch_assoc($category_result);
}

if (isset($_POST["addtocart"])) {
    $sqll = "SELECT * FROM cust_cart WHERE user_id = " . $_SESSION['userid'] . " AND item_id = " . $_POST['iid'];
    if ($result = mysqli_query($link, $sqll)) {
        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                $Quantity = $row['quantity'] + $_POST['item_quantity'];
                $sql = "UPDATE cust_cart SET quantity = $Quantity WHERE cart_id = " . $row['cart_id'];
            }
        } else {
            $sql = "INSERT INTO cust_cart (user_id, item_id, quantity)VALUES (" . $_SESSION['userid'] . ", " . $_POST['iid'] . ", " . $_POST['item_quantity'] . " )";
        }
    }

    if (mysqli_query($link, $sql)) {
        echo "
                <script>
                    location.href = 'cart.php';
                </script>";
    } else {
        echo "
                <script>
                    alert('Error: " . $sql . "\n" . mysqli_error($link) . "')
                </script>";
    }
}
?>

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
                        <img src="<?php echo "assets/images/items/" . $row["image"]; ?>" alt="">
                        <input type="hidden" name="ipic" value="<?php echo $row["image"] ?>">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="product_detail_content">
                        <h2><?php echo $row["item"] ?></h2>
                        <input type="hidden" name="iname" value="<?php echo $row["item"] ?>">
                        <div class="product_detail_review_box">
                            <div class="product_detail_price_box">
                                <p>RM<?php echo number_format($row["cost"], 2); ?></p>
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
                                <input type="number" name="item_quantity" id="item_quantity" value="1" min="1" max="<?php echo $row['stock'] ?>" data-mask="00" />
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
            <li><span>Category:</span> <?php echo $category_row["category_name"] ?></li>
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
    <div class="row">
        <div class="col-xl-12">
            <div class="product-tab-box tabs-box">
                <ul class="tab-btns tab-buttons clearfix list-unstyled">
                    <li data-tab="#addi__info" class="tab-btn active-btn"><span>Additional info</span></li>
                </ul>
                <div class="tabs-content">

                    <div class="tab active-tab" id="addi__info">
                        <ul class="additionali_nfo list-unstyled">
                            <li><span>Name:</span><?php echo $row["item"] ?></li>
                            <li><span>Expiry Date:</span><?php echo $row["exp_date"] ?></li>
                            <li><span>Category:</span><?php echo $category_row["category_name"] ?></li>
                            <li><span>Stock:</span><?php echo $row["stock"] ?></li>
                        </ul>
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

<script>
    function addToCartFunction() {
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


<?php include 'cust_footer.php'; ?>