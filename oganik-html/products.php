<?php

include 'cust_header.php';

$id_array = array();

if (isset($_GET["search"])) {
    $search = $_GET["search"];

    $getid_sql = "SELECT * FROM item 
                    WHERE item LIKE '%$search%'
                    OR description LIKE '%$search%'";

    if ($result = mysqli_query($link, $getid_sql)) {

        while ($row = mysqli_fetch_assoc($result)) {

            if ($row['item_status'] == "Active")
                array_push($id_array, $row["item_id"]);
        }
    }
} else {
    $getid_sql = "SELECT * FROM item";

    if ($result = mysqli_query($link, $getid_sql)) {

        while ($row = mysqli_fetch_assoc($result)) {

            if ($row['item_status'] == "Active")
                array_push($id_array, $row["item_id"]);
        }
    }
}


?>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2>Products</h2>
        <ul class="thm-breadcrumb list-unstyled">
            <li><a href="index.php">Home</a></li>
            <li>/</li>
            <li><span>Products</span></li>
        </ul><!-- /.thm-breadcrumb list-unstyled -->
    </div><!-- /.container -->
</section><!-- /.page-header -->


<section class="products-page">

    <div class="container">

        <div class="row">

            <div class="col-sm-12 col-md-12 col-lg-3">

                <div class="product-sidebar">
                    <div class="product-sidebar__single product-sidebar__search-widget">
                        <form action="#">
                            <input type="text" placeholder="Search">
                            <button class="organik-icon-magnifying-glass" type="submit"></button>
                        </form>
                    </div><!-- /.product-sidebar__single -->
                    <div class="product-sidebar__single">
                        <h3>Price</h3>
                        <div class="product-sidebar__price-range">
                            <div class="range-slider-price" id="range-slider-price"></div>
                            <div class="form-group">
                                <div class="left">
                                    <p>$<span id="min-value-rangeslider"></span></p>
                                    <span>-</span>
                                    <p>$<span id="max-value-rangeslider"></span></p>
                                </div><!-- /.left -->
                                <div class="right">
                                    <input type="submit" class="thm-btn" value="Filter">
                                </div><!-- /.right -->
                            </div>
                        </div><!-- /.product-sidebar__price-range -->
                    </div><!-- /.product-sidebar__single -->
                    <div class="product-sidebar__single">
                        <h3>Categories</h3>
                        <ul class="list-unstyled product-sidebar__links">
                            <li><a href="#">Vegetables <i class="fa fa-angle-right"></i></a></li>
                            <li><a href="#">Fresh Fruits <i class="fa fa-angle-right"></i></a></li>
                            <li><a href="#">Dairy Products <i class="fa fa-angle-right"></i></a></li>
                            <li><a href="#">Tomatos <i class="fa fa-angle-right"></i></a></li>
                            <li><a href="#">Oranges <i class="fa fa-angle-right"></i></a></li>
                        </ul><!-- /.list-unstyled product-sidebar__links -->
                    </div><!-- /.product-sidebar__single -->
                </div><!-- /.product-sidebar -->
            </div><!-- /.col-sm-12 col-md-12 col-lg-3 -->

            <div class="col-sm-12 col-md-12 col-lg-9">

                <div class="product-sorter">
                    <p>Showing 1–9 of 12 results</p>
                    <div class="product-sorter__select">
                        <select class="selectpicker">
                            <option value="#">Sort by popular</option>
                            <option value="#">Sort by popular</option>
                            <option value="#">Sort by popular</option>
                            <option value="#">Sort by popular</option>
                        </select>
                    </div><!-- /.product-sorter__select -->
                </div><!-- /.product-sorter -->

                <div class="row">

                    <?php
                    $sql = "SELECT * from item";

                    if (count($id_array) == 0) {
                        echo "<h4 style='margin: auto'>No search result</h4>";
                    } else {

                        for ($i = 0; $i < count($id_array); $i++) {
                            $sql = "SELECT * from item WHERE item_id = " . $id_array[$i];

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
                                                                <p>RM' . number_format($row['cost'], 2) . '</p>
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
                        }
                    }

                    ?>
                    <!-- /.col-md-6 col-lg-4 -->
                </div><!-- /.row -->
                <div class="text-center">
                    <a href="#" class="thm-btn products__load-more">Load More</a><!-- /.thm-btn -->
                </div><!-- /.text-center -->
            </div><!-- /.col-sm-12 col-md-12 col-lg-9 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.products-page -->

<?php include 'cust_footer.php'; ?>