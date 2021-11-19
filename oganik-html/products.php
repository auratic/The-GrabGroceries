<?php

include 'cust_header.php';

$id_array = array();

if (isset($_GET["search"])) 
{
    $search = $_GET["search"];

    $getid_sql = "SELECT * FROM category INNER JOIN item 
                    ON item.category_id = category.category_id 
                    WHERE category.category_status = 'Active' AND category.category_name != 'Not Set' AND item.item_status = 'Active' AND 
                    item LIKE '%$search%' OR description LIKE '%$search%'";

    if ($result = mysqli_query($link, $getid_sql)) {

        while ($row = mysqli_fetch_assoc($result)) {

                array_push($id_array, $row["item_id"]);
        }
    }
}
else 
{
    $getid_sql = "SELECT * FROM category INNER JOIN item 
                    ON item.category_id = category.category_id 
                    WHERE category.category_status = 'Active' AND category.category_name != 'Not Set' AND item.item_status = 'Active'";

    if ($result = mysqli_query($link, $getid_sql)) {

        while ($row = mysqli_fetch_assoc($result)) {

                array_push($id_array, $row["item_id"]);
        }
    }
}

?>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2><?php echo $lang['products']?></h2>
        <ul class="thm-breadcrumb list-unstyled">
            <li><a href="index.php"><?php echo $lang['home']?></a></li>
            <li>/</li>
            <li><span><?php echo $lang['products']?></span></li>
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
                            <button style="width: 300px;"class="thm-btn search-toggler"><?php echo $lang['search']?></i></button>
                        </form>
                    </div><!-- /.product-sidebar__single -->
                    <div class="product-sidebar__single">
                        <h3><?php echo $lang['price']?> (RM)</h3>
                        <div class="product-sidebar__price-range">
                            <form action="" method="GET">
                                <div class="row">
                                    <label for=""><?php echo $lang['from']?>:</label> 
                                    <div class="input-group input-group-sm mb-3">
                                        <input type="number" name="start_price" min="1" value="<?php if(isset($_GET['start_price'])){echo $_GET['start_price']; }else{echo "1";} ?>" class="form-control">
                                    </div>
                                    <label for=""><?php echo $lang['to']?>:</label> 
                                    <div class="input-group input-group-sm mb-3">
                                        <input type="number" name="end_price" min="1" value="<?php if(isset($_GET['end_price'])){echo $_GET['end_price']; }else{echo "2";} ?>" class="form-control">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <button type="submit" class="thm-btn"><?php echo $lang['filter']?></button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.product-sidebar__price-range -->
                    </div><!-- /.product-sidebar__single -->
                    <form action="" method="GET">
                        <div class="product-sidebar__single">
                            <h3><?php echo $lang['cate']?></h3>
                            <ul class="list-unstyled product-sidebar__links">
                                <?php
                                    $brand_query = "SELECT * FROM category WHERE category_status = 'Active' AND category_name != 'Not Set'";
                                    $brand_query_run  = mysqli_query($link, $brand_query);

                                    if(mysqli_num_rows($brand_query_run) > 0)
                                    {
                                        foreach($brand_query_run as $brandlist)
                                        {
                                            $checked = [];
                                            if(isset($_GET['brands']))
                                            {
                                                $checked = $_GET['brands'];
                                            }
                                            ?>
                                                <div>
                                                    <input type="checkbox" name="brands[]" value="<?php echo $brandlist['category_id']; ?>" 
                                                        <?php if(in_array($brandlist['category_id'], $checked)){ echo "checked"; } ?>
                                                    />
                                                    <?php echo $brandlist['category_name']; ?>
                                                </div>
                                            <?php
                                        }
                                    }
                                    
                                ?>
                            </ul><!-- /.list-unstyled product-sidebar__links -->
                            <button type="submit" class="thm-btn" style="padding: 2px 10px;"><?php echo $lang['search']?></button>
                        </div><!-- /.product-sidebar__single -->
                    </form>
                </div><!-- /.product-sidebar -->
            </div><!-- /.col-sm-12 col-md-12 col-lg-3 -->

            <div class="col-sm-12 col-md-12 col-lg-9">

                <div class="product-sorter">
                    <p><?php echo $lang['products']?>:</p>
                    <form action="" method="GET">
                        <div class="product-sorter__select" style="margin-right: 150px;">
                            <select class="selectpicker" name="sort" >
                                <option value="ASC"><?php echo $lang['selectop']?></option>
                                <option value="ASC" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'a-z'){echo "selected";}?>><?php echo $lang['ascen']?></option>
                                <option value="DESC" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'z-a'){echo "selected";}?>><?php echo $lang['descen']?></option>
                                <option value="lth"<?php if(isset($_GET['sort']) && $_GET['sort'] == 'cost'){echo "selected";}?>><?php echo $lang['plth']?></option>
                                <option value="htl"<?php if(isset($_GET['sort']) && $_GET['sort'] == 'cost'){echo "selected";}?>><?php echo $lang['phtl']?></option>
                            </select>
                            <button style="margin-left: 300px; margin-top: -109px;"type="submit" class="thm-btn"><i class="fa fa-search"></i></button>
                        </div><!-- /.product-sorter__select -->
                    </form>
                </div><!-- /.product-sorter -->

                <div class="row">

                    <?php
                    $sql = "SELECT * from item";
                    $sort_option ="";
                    if(isset($_GET['start_price']) && isset($_GET['end_price']))
                    {
                        $startprice = $_GET['start_price'];
                        $endprice = $_GET['end_price']; 
                    
                        $query = "SELECT * FROM category INNER JOIN item 
                                    ON category.category_id = item.category_id 
                                    WHERE item.cost BETWEEN $startprice AND $endprice AND category.category_status = 'Active' AND category.category_name != 'Not Set' AND item.item_status = 'Active'";
                        $fil = mysqli_query($link, $query);
                        if(mysqli_num_rows($fil) > 0)
                        {
                            while($rows=mysqli_fetch_assoc($fil))
                            {
                                echo '
                                <div class="col-md-6 col-lg-4">
                                    <div class="product-card">
                                        <div class="product-card__image">
                                            <img src="assets/images/items/' . $rows['image'] . '" alt="">
                                            <div class="product-card__image-content" style="cursor:pointer;"
                                                onclick="location.href = `product-details.php?item_id=' . $rows['item_id'] . '`">
                                            </div><!-- /.product-card__image-content -->
                                        </div><!-- /.product-card__image -->
                                        <div class="product-card__content">
                                            <div class="product-card__left">
                                                <h3><a href="product-details.php">' . $rows['item'] . '</a></h3>
                                                <p>RM' . number_format($rows['cost'], 2) . '</p>
                                            </div><!-- /.product-card__left -->
                                        </div><!-- /.product-card__content -->
                                    </div><!-- /.product-card -->
                                </div>';
                            }
                        }
                        else
                        {
                            echo "<h1 style='padding: 50px;'>There are no product prices in this range</h1>";
                        }
                    }
                    else if (count($id_array) == 0) 
                    {
                        echo "<h4 style='margin: auto'>No search result</h4>";
                    } 
                    else if(isset($_GET['sort']))
                    {
                        if($_GET['sort'] == 'ASC')
                        {
                            $sort_option = "ASC";
                            $sort = "SELECT * FROM category INNER JOIN item 
                                    ON category.category_id = item.category_id
                                    WHERE category.category_status = 'Active' AND category.category_name != 'Not Set' AND item.item_status = 'Active'
                                    ORDER BY item.item $sort_option";
                        }
                        else if($_GET['sort'] == 'DESC')
                        {
                            $sort_option = "DESC"; 
                            $sort = "SELECT * FROM category INNER JOIN item 
                                    ON category.category_id = item.category_id
                                    WHERE category.category_status = 'Active' AND category.category_name != 'Not Set' AND item.item_status = 'Active'
                                    ORDER BY item.item $sort_option";
                        }
                        else if($_GET['sort'] == 'lth')
                        {
                            $sort_option = "ASC"; 
                            $sort = "SELECT * FROM category INNER JOIN item 
                                    ON category.category_id = item.category_id
                                    WHERE category.category_status = 'Active' AND category.category_name != 'Not Set' AND item.item_status = 'Active'
                                    ORDER BY item.cost $sort_option";
                        }
                        else if($_GET['sort'] == 'htl')
                        {
                            $sort_option = "DESC"; 
                            $sort = "SELECT * FROM category INNER JOIN item 
                                    ON category.category_id = item.category_id
                                    WHERE category.category_status = 'Active' AND category.category_name != 'Not Set' AND item.item_status = 'Active'
                                    ORDER BY item.cost $sort_option";
                        }
                        
                        
                        $sorts = mysqli_query($link, $sort);

                        if(mysqli_num_rows($sorts) > 0) 
                        {
                            while($out=mysqli_fetch_assoc($sorts))
                            {
                                echo '
                                <div class="col-md-6 col-lg-4">
                                    <div class="product-card">
                                        <div class="product-card__image">
                                            <img src="assets/images/items/' . $out['image'] . '" alt="">
                                            <div class="product-card__image-content" style="cursor:pointer;"
                                                onclick="location.href = `product-details.php?item_id=' . $out['item_id'] . '`">
                                            </div><!-- /.product-card__image-content -->
                                        </div><!-- /.product-card__image -->
                                        <div class="product-card__content">
                                            <div class="product-card__left">
                                                <h3><a href="product-details.php">' . $out['item'] . '</a></h3>
                                                <p>RM' . number_format($out[ 'cost'], 2) . '</p>
                                            </div><!-- /.product-card__left -->
                                        </div><!-- /.product-card__content -->
                                    </div><!-- /.product-card -->
                                </div>';
                            }
                        }
                    }
                    else if(isset($_GET['brands']))
                    {
                        $branchecked = [];
                        $branchecked = $_GET['brands'];
                        foreach($branchecked as $rowbrand)
                        {
                            // echo $rowbrand;
                            $products = "SELECT * FROM item WHERE category_id = $rowbrand AND item_status = 'Active'";
                            $products_run = mysqli_query($link, $products);
                            if(mysqli_num_rows($products_run) > 0)
                            {
                                foreach($products_run as $proditems)
                                {
                                    echo '
                                    <div class="col-md-6 col-lg-4">
                                        <div class="product-card">
                                            <div class="product-card__image">
                                                <img src="assets/images/items/' . $proditems['image'] . '" alt="">
                                                <div class="product-card__image-content" style="cursor:pointer;"
                                                    onclick="location.href = `product-details.php?item_id=' . $proditems['item_id'] . '`">
                                                </div><!-- /.product-card__image-content -->
                                            </div><!-- /.product-card__image -->
                                            <div class="product-card__content">
                                                <div class="product-card__left">
                                                    <h3><a href="product-details.php">' . $proditems['item'] . '</a></h3>
                                                    <p>RM' . number_format($proditems['cost'], 2) . '</p>
                                                </div><!-- /.product-card__left -->
                                            </div><!-- /.product-card__content -->
                                        </div><!-- /.product-card -->
                                    </div>';
                                }
                                
                            }
                        }
                    }
                    else 
                    {
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
                                                            </div><!-- /.product-card__image-content -->
                                                        </div><!-- /.product-card__image -->
                                                        <div class="product-card__content">
                                                            <div class="product-card__left">
                                                                <h3><a href="product-details.php">' . $row['item'] . '</a></h3>
                                                                <p>RM' . number_format($row['cost'], 2) . '</p>
                                                            </div><!-- /.product-card__left -->
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
                <!--<div class="text-center">
                    <a href="#" class="thm-btn products__load-more"><?php echo $lang['load']?></a><!-- /.thm-btn
                </div> /.text-center -->
            </div><!-- /.col-sm-12 col-md-12 col-lg-9 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.products-page -->

<?php include 'cust_footer.php'; ?>