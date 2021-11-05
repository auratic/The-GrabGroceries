<?php

include 'cust_header.php';

if (!isset($_SESSION['loggedin'])) {
    echo "
        <script>
            Swal.fire({
                title: 'Error',
                text: 'Please log in first to view cart.',
                icon: 'error'
            }).then(function() {
            location.href = 'login.php'
            })
        </script>
        ";
}

if (isset($_POST['update'])) {
    $newQty = $_POST['item_quantity'];
    $cart_id = $_POST["cart_id"];

    $sql = "UPDATE cust_cart SET quantity = $newQty WHERE cart_id = $cart_id";
    if (mysqli_query($link, $sql)) {
        echo "
            <script>
                Swal.fire({
                    title: 'Successful',
                    text: 'Updated ".$_POST["iname"]." to ".$newQty." quantity.',
                    icon: 'success'
                }).then(function() {
                location.href = 'cart.php'
                })
            </script>  
            ";
    }
}

if (isset($_POST['remove'])) {
    $cart_id = $_POST["cart_id"];

    $sql = "DELETE FROM cust_cart where cart_id = $cart_id";
    if (mysqli_query($link, $sql)) {
        echo "
            <script>
                Swal.fire({
                    title: 'Successful',
                    text: 'Removed all ".$_POST["iname"]."',
                    icon: 'success'
                }).then(function() {
                location.href = 'cart.php'
                })
            </script>  
            ";
    }
}
?>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2><?php echo $lang['cart']?></h2>
        <ul class="thm-breadcrumb list-unstyled">
            <li><a href="index.php"><?php echo $lang['home']?></a></li>
            <li>/</li>
            <li><span><?php echo $lang['cart']?></span></li>
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
                        <th><?php echo $lang['items']?></th>
                        <th><?php echo $lang['prices']?></th>
                        <th><?php echo $lang['qtys']?></th>
                        <th><?php echo $lang['totals']?></th>
                        <th style="text-align: center;"><?php echo $lang['acts']?></th>
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
                                                                <input type="number" name="item_quantity" value="' . $row['quantity'] . '" min="1" max="' . $row['stock'] . '" data-mask="000">
                                                            <button type="button" class="add">+</button>
                                                        </div>
                                                        </td>
                                                        <td>RM ' . $item_total . '</td>
                                                        <td style="text-align: center;"><button style="" class="btn btn-gray" name="update"><img src="assets/images/update.png" alt="Update Item" /></button>
                                                        <button name="remove" class="btn btn-gray"><img src="assets/images/delete.png" alt="Remove Item" /></button></td>
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
                <!--<form action="#" class="contact-one__form">
                    <input type="text" placeholder="Enter Coupon Code">
                    <button type="submit" class="thm-btn">Apply Coupon</button> /.thm-btn -->
                <!-- /.contact-one__form -->
            </div><!-- /.col-lg-8 -->
            <div class="col-lg-4">
                <i style="margin-left: 90px;"><?php echo $lang['freeshps']?></i> <i class="fas fa-truck-moving"></i>
                <i style="margin-left: 20px;"><?php echo $lang['shipsame']?></i> <i class="fas fa-shipping-fast"></i><hr>
                <ul class="cart-total list-unstyled">
                    <li>
                        <span><?php echo $lang['subtots']?></span>
                        <span>
                            RM
                            <?php
                            if ($empty_cart)
                            {
                                $subtotal = 0;
                                echo number_format($subtotal,2);
                            }
                            else {
                                echo number_format($subtotal, 2);
                            }

                            ?>
                        </span>
                    </li>
                    <li>
                      <span><?php echo $lang['shpcosts']?></span>
                        <span>
                            RM
                           <?php
                           
                            
                            if ($empty_cart)
                            {
                                $shipping_fee = 0;
                            }
                            else if($subtotal<=99)
                            {
                                $shipping_fee = 8.00;
                            }
                            else if($subtotal>=100)
                            {
                                $shipping_fee = 0;
                            }
                                echo number_format($shipping_fee,2);
                            ?>
                        </span>
                    </li>
                    <li>
                        <span><?php echo $lang['totals']?></span>
                        <span>
                            RM
                            <?php

                            if ($empty_cart)
                            {
                                $grand_total = 0;
                                echo number_format($grand_total,2);
                            }

                            else {
                                $grand_total = $subtotal + $shipping_fee;
                                echo number_format($grand_total, 2);
                            }
                            ?>
                        </span>
                    </li>
                </ul><!-- /.cart-total -->
                <div class="button-box" style="margin-left: -20px;">
                    <a href="index.php" class="thm-btn" style="text-decoration: none;"></i> <?php echo $lang['cancels']?></a><!-- /.thm-btn -->
                    <a href="checkout.php" class="thm-btn" style="text-decoration: none;"><i class="far fa-credit-card"></i> <?php echo $lang['chkout']?></a><!-- /.thm-btn -->
                </div><!-- /.button-box -->
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.cart-page -->

<?php include 'cust_footer.php'; ?>