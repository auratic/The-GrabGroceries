<?php

include 'admin_header.php';

if (isset($_GET["restore"])) {

    $item_id = $_GET["item_id"];

    $date = date('Y-m-d H:i:s');
    $activity_sql = "INSERT INTO admin_activity (user_id, activity, activity_time, target) VALUES (" . $_SESSION["userid"] . ", 'restore item', '$date', '";

    for ($i = 0; $i < count($item_id); $i++) {
        $sql = "UPDATE item SET item_status = 'Active' WHERE item_id = " . $item_id[$i];

        if ($i < 1) {
            $activity_sql .= $item_id[$i];
        } else {
            $activity_sql .= "," . $item_id[$i];
        }

        if (mysqli_query($link, $sql)) {
            echo "<script>alert('Updated');</script>";
        } else {
            echo "<script>alert('Some error occured');</script>";
        }
    }
    $activity_sql .= "')";
    mysqli_query($link, $activity_sql);
}
?>

<section>
    <div class="container" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(245,245,220,0.8); text-align:center">
        <h1>Archive products</h1>
    </div>

    <div class="container" style="padding:2%; background-color:rgba(245,245,220,0.8);">
        <div class="row">

            <div class="col-sm-2" style="
                        border: gray solid 1px;
                        border-radius: 10px;
                        padding: 1%;">
                <form>
                    <div class="form-group" style="text-align: left">
                        <label><b>Search by name</b></label> </br>
                        <input type="text" name="search_name" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo ""; ?>">
                        <span class="invalid-feedback"><?php echo $name_err; ?></span>
                    </div>

                    <div class="form-group" style="text-align: left">
                        <label><b>Search by id</b></label> </br>
                        <input type="text" name="search_id" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo ""; ?>">
                        <span class="invalid-feedback"><?php echo $id_err; ?></span>
                    </div>

                    <hr>

                    <div class="form-group" style="text-align: left">
                        <label><b>Search by category</b></label> </br>
                        <select id="category" name="category" class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $category; ?>">
                            <option value="Fruit & Vegetables">Fruit & Vegetables</option>
                            <option value="Meat">Meat</option>
                            <option value="Seafood">Seafood</option>
                            <option value="Snack">Snack</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $category_err; ?></span>
                    </div>

                    <hr>

                    <label><b>Date added</b></label> </br>
                    <div class="form-group" style="text-align: left">
                        <p>from</p>
                        <input type="date" name="date_added_from" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $added_from_err; ?></span>
                    </div>

                    <div class="form-group" style="text-align: left">
                        <p>to</p>
                        <input type="date" name="date_added_to" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $added_to_err; ?></span>
                    </div>

                    <hr>

                    <label><b>Expiry Date</b></label> </br>
                    <div class="form-group" style="text-align: left">
                        <p>from</p>
                        <input type="date" name="exp_date_from" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $exp_from_err; ?></span>
                    </div>

                    <div class="form-group" style="text-align: left">
                        <p>to</p>
                        <input type="date" name="exp_date_to" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $exp_to_err; ?></span>
                    </div>

                    <hr>

                    <div class="form-group" style="text-align: left">
                        <input type="submit" class="btn btn-primary" value="Filter">
                    </div>

                </form>
            </div>

            <div class="col-sm-10">

                <div class="product-tab-box tabs-box" style="margin:0">

                    <ul class="tab-btns tab-buttons clearfix list-unstyled">
                        <li data-tab="#desc" class="tab-btn" onclick="location.href='admin_displayitem.php'"><span>Active products</span></li>
                        <li data-tab="#addi__info" class="tab-btn active-btn"><span>Archived products</span></li>
                    </ul>

                    <div class="tabs-content">

                        <div class="tab active-tab" id="addi__info">

                            <div class="product-details-content" style="padding: 0;">

                                <div class="desc-content-box">

                                    <div class='row' style="margin: 1%">
                                        <div class="col-sm-8">
                                            <!--
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <label><b>Date added</b></label> </br>
                                                                <div class="form-group" style="text-align: left">
                                                                    <p>from</p>
                                                                    <input type="date" name="date_added_from" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                                                                    <span class="invalid-feedback"><?php echo $added_from_err; ?></span>
                                                                </div>   
                                                                
                                                                <div class="form-group" style="text-align: left">
                                                                    <p>to</p>
                                                                    <input type="date" name="date_added_to" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                                                                    <span class="invalid-feedback"><?php echo $added_to_err; ?></span>
                                                                </div>
                                                            </div>      

                                                            <div class="col-sm-6">
                                                                <label><b>Expiry Date</b></label> </br>
                                                                <div class="form-group" style="text-align: left">
                                                                    <p>from</p>
                                                                    <input type="date" name="exp_date_from" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                                                                    <span class="invalid-feedback"><?php echo $exp_from_err; ?></span>
                                                                </div>   

                                                                <div class="form-group" style="text-align: left">
                                                                    <p>to</p>
                                                                    <input type="date" name="exp_date_to" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                                                                    <span class="invalid-feedback"><?php echo $exp_to_err; ?></span>
                                                                </div>   
                                                            </div>      
                                                        </div>

                                                    </form>
                                                    -->
                                        </div>

                                        <!--
                                                <div class="col-sm-3" 
                                                    style="
                                                    display:flex; 
                                                    align-items:flex-end; 
                                                    justify-content: flex-end" 
                                                    >
                                                -->
                                        <div class="col-sm-4">
                                            <form style="
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: flex-end;">
                                                <div class="form-group" style="text-align: left; margin-right: 1rem">
                                                    <input type="checkbox" id="select-all" />
                                                    <label for="select-all">Select All</label>
                                                </div>
                                                <div class="form-group" style="text-align: left; margin-right: 1rem">
                                                    <button class="btn btn-info btn-sm" onclick="return restoreItem();">Restore</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div style="padding: 1%;">
                                        <table class="table table-bordered table-striped table-hover table-condensed">
                                            <tr>
                                                <th>ID</th>
                                                <th>Item name</th>
                                                <th>Category</th>
                                                <th>Description</th>
                                                <th>Stock</th>
                                                <th>Image</th>
                                                <th>Cost</th>
                                                <th>Expiry Date</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            <?php
                                            $sql = "SELECT * from item INNER JOIN category ON item.category_id = category.category_id";

                                            if ($result = mysqli_query($link, $sql)) {

                                                while ($row = mysqli_fetch_assoc($result)) {

                                                    if ($row["item_status"] == "Inactive") {
                                                        echo '
                                                    <tr>
                                                        <td>' . $row['item_id'] . '</td>
                                                        <td>' . $row['item'] . '</td>
                                                        <td>' . $row['category_name'] . '</td>
                                                        <td>' . $row['description'] . '</td>
                                                        <td>' . $row['stock'] . '</td>
                                                        <td><img src="assets/images/items/' . $row['image'] . '" style="width:100%;height:200px;object-fit:contain;"></td>
                                                        <td>RM' . $row['cost'] . '</td>
                                                        <td>' . $row['exp_date'] . '</td>
                                                        <td>
                                                            <a href="admin_updateitem.php?id=' . $row['item_id'] . '">
                                                            <button class="btn btn-info btn-sm">Edit</button>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="select-item" value="' . $row['item_id'] . '">
                                                        </td>
                                                    </tr>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div><!-- tab-content -->

                </div> <!-- product-tab-box -->

            </div> <!-- col-sm-10 -->

        </div>
    </div>
</section>
</div> <!-- page wrapper -->

<!-- /.search-popup -->

<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>
<script>
    var checkboxes = document.getElementsByName('select-item');
    var select_all = document.getElementById("select-all");

    select_all.onclick = () => {

        if (select_all.checked) {
            //console.log("yes")
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = true;
            }
        } else {
            //console.log("no")
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = false;
            }
        }
    }

    function restoreItem() {
        var item_id = [];

        for (var i = 0, n = checkboxes.length; i < n; i++) {
            if (checkboxes[i].checked == true) {
                item_id.push(checkboxes[i].value);
            }
        }
        if (confirm("Restore product? Press 'OK' to continue")) {
            $.ajax({
                type: "get",
                url: "admin_archiveitem.php",
                data: {
                    'restore': true,
                    'item_id': item_id
                },
                cache: false,
                success: function(html) {
                    alert('Updated');
                    location.href = 'admin_archiveitem.php';
                }
            });

            //alert("Updated");
        } else {}

        return false;
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
</body>

</html>