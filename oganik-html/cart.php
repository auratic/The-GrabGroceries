<?php

include 'cust_header.php';

if (!isset($_SESSION['loggedin'])) {
    echo "
        <script>
            alert('Please log in first to view cart.'); location.href='login.php'
        </script>
        ";
}

if (isset($_POST['update'])) {
    $newQty = $_POST['item_quantity'];
    $cart_id = $_POST["cart_id"];

    $sql = "UPDATE cust_cart SET quantity = $newQty WHERE cart_id = $cart_id";
    if (mysqli_query($link, $sql)) {
        echo '
            <script>
                alert("Updated ' . $_POST["iname"] . ' to ' . $newQty . ' quantity");    
                location.href = "cart.php";
            </script>  
            ';
    }
}

if (isset($_POST['remove'])) {
    $cart_id = $_POST["cart_id"];

    $sql = "DELETE FROM cust_cart where cart_id = $cart_id";
    if (mysqli_query($link, $sql)) {
        echo '
            <script>
                alert("Success remove ' . $_POST["iname"] . '");    
                location.href = "cart.php";
            </script>  
            ';
    }
}
?>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2>Cart</h2>
        <ul class="thm-breadcrumb list-unstyled">
            <li><a href="index.php">Home</a></li>
            <li>/</li>
            <li><span>Cart</span></li>
        </ul><!-- /.thm-breadcrumb list-unstyled -->
    </div><!-- /.container -->
</section><!-- /.page-header -->

<section class="cart-page">

    <div class="container">
        <div class="table-responsive">
            <table class="table cart-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM cust_cart INNER JOIN item ON cust_cart.item_id = item.item_id WHERE user_id = " . $_SESSION['userid'];
                    $empty_cart = false;

                    if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) == 0) {
                            echo '
                                            <tr>
                                                <td colspan="4" style="text-align: center;">You have no products added in your Shopping Cart</td>
                                            </tr>';

                            $empty_cart = true;
                        } else {
                            $grand_total = 0.00;
                            $shipping_fee = 0.00;
                            $subtotal = 0.00;

                            while ($row = mysqli_fetch_assoc($result)) {
                                $item_total = $row['cost'] * $row['quantity'];
                                $subtotal += $item_total;

                                echo '
                                                <form action="cart.php" method="POST">
                                                    <tr>
                                                        <input name="cart_id" value="' . $row['cart_id'] . '" style="display: none;">
                                                        <td><img src="assets/images/items/' . $row['image'] . '" style="width:100px; height:100px;"></td>
                                                        <td><input type="hidden" name="iname" value="' . $row['item'] . '">' . $row['item'] . '</td>
                                                        <td><input type="hidden" name="iprice" value="' . $row['cost'] . '">RM ' . $row['cost'] . '</td>
                                                        <td>
                                                        <div class="quantity-box">
                                                            <button type="button" class="sub">-</button>
                                                                <input type="number" name="item_quantity" value="' . $row['quantity'] . '" min="1" max="' . $row['stock'] . '" data-mask="00">
                                                            <button type="button" class="add">+</button>
                                                        </div>
                                                        </td>
                                                        <td>RM ' . $item_total . '</td>
                                                        <td><button name="update" class="btn btn-warning">Update</button></td>
                                                        <td><button name="remove" class="btn btn-gray"><img src="assets/images/delete.png" alt="Remove Item" /></button></td>
                                                    </tr>
                                                </form>
                                            ';
                            }
                        }
                    }

                    ?>
            </table><!-- /.table -->

        </div><!-- /.table-responsive -->
        <div class="row">
            <div class="col-lg-8">
                <form action="#" class="contact-one__form">
                    <input type="text" placeholder="Enter Coupon Code">
                    <button type="submit" class="thm-btn">Apply Coupon</button><!-- /.thm-btn -->
                </form><!-- /.contact-one__form -->
            </div><!-- /.col-lg-8 -->
            <div class="col-lg-4">
                <ul class="cart-total list-unstyled">
                    <li>
                        <span>Subtotal</span>
                        <span>
                            RM
                            <?php
                            if ($empty_cart)
                                echo "0";
                            else {
                                echo number_format($subtotal, 2);
                            }

                            ?>
                        </span>
                    </li>
                    <li>
                        <span>Shipping Cost</span>
                        <span>
                            RM
                            <?php
                            if ($empty_cart)
                                echo "0";
                            else
                                echo $shipping_fee;
                            ?>
                        </span>
                    </li>
                    <li>
                        <span>Total</span>
                        <span>
                            RM
                            <?php

                            if ($empty_cart)
                                echo "0";
                            else {
                                $grand_total = $subtotal + $shipping_fee;
                                echo number_format($grand_total, 2);
                            }
                            ?>
                        </span>
                    </li>
                </ul><!-- /.cart-total -->
                <div class="button-box" style="margin-left: 151px;">
                    <a href="checkout.php" class="thm-btn"><i class="far fa-credit-card"></i> Checkout</a><!-- /.thm-btn -->
                </div><!-- /.button-box -->
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.cart-page -->

<?php include 'cust_footer.php'; ?>