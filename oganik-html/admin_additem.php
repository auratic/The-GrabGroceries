<?php

include 'admin_header.php';

$item_name = $category = $desc = $cost = $stock = $exp_date = "";

if (isset($_POST["add-item"])) {

  $exp_err = $cost_err = $img_err = $category_err = $name_err = $desc_err = $stock_err = "";

  if ($_FILES['image']['size'] == 0) {
    $img_err = "Please upload an image.";
  } else {
    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "assets/images/items/" . $filename;
  }

  if (empty(trim($_POST["item-name"]))) {
    $name_err = "Please enter name";
  } else {

    $sql = "SELECT * FROM item WHERE item = '" . ucfirst(trim($_POST["item-name"])) . "'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) > 0) {
      $name_err = "Name is taken";
    } else {
      $item_name = ucwords(trim($_POST["item-name"]));
    }
  }

  if (empty(trim($_POST["category_id"]))) {
    $category_err = "Please select a category";
  } else {
    $category = trim($_POST["category_id"]);
  }

  if (empty(trim($_POST["desc"]))) {
    $desc_err = "Please fill in the description";
  } else {
    $desc = ucfirst(trim($_POST["desc"]));
  }

  if (empty(trim($_POST["cost"]))) {

    $cost_err = "Please enter cost";
  } else if (trim($_POST["cost"]) <= 0) {

    $cost_err = "Please enter valid cost";
  } else if (!is_numeric(trim($_POST["cost"]))) {

    $cost_err = "Please enter valid cost";
  } else {

    $cost = trim($_POST["cost"]);
  }

  if (empty(trim($_POST["stock"]))) {

    $stock_err = "Please enter stock";
  } else if (!is_numeric(trim($_POST["stock"]))) {

    $stock_err = "Please enter valid stock";
  } else if (trim($_POST["stock"]) <= 0) {

    $stock_err = "Please enter valid stock";
  } else {

    $stock = trim($_POST["stock"]);
  }

  if (empty(trim($_POST["exp-date"]))) {
    $exp_err = "Please enter expire date";
  } else {
    //$exp_date = trim($_POST["exp-date"]);
    $exp_date = date('Y-m-d', strtotime($_POST['exp-date']));
  }


  // Get all the submitted data from the form
  //$sql = "INSERT INTO image (filename) VALUES ('$filename')";
  // Execute query
  //mysqli_query($db, $sql);

  if (
    $name_err == "" &&
    $category_err == "" &&
    $desc_err == "" &&
    $img_err == "" &&
    $cost_err == "" &&
    $stock_err == "" &&
    $exp_err == ""
  ) {

    $sql = "INSERT INTO item (item, category_id, description, stock, image, cost, exp_date)
                 VALUES ('$item_name', '$category', '$desc', '$stock', '$filename', '$cost', '$exp_date')";


    if (move_uploaded_file($tempname, $folder)) {
    } else {
      echo "
            <script>
              alert('Something went wrong uploading image');
              location.href = 'admin_additem.php'
            </script>";
    }

    if (mysqli_query($link, $sql)) {

      $date = date('Y-m-d H:i:s');
      $sql = "INSERT INTO admin_activity (user_id, activity, target, activity_time) VALUES (" . $_SESSION["userid"] . ", 'add item', '$item_name', '$date')";
      mysqli_query($link, $sql);

      echo "
            <script>
              alert('Items added successfully');
              location.href = 'admin_additem.php'
            </script>";
    } else {
      echo "
            <script>
              alert('Something went wrong uploading data to database');
              location.href = 'admin_additem.php'
            </script>";
    }
  }
}

?>

<section>
  <div class="container" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">

    <h1>Add item</h1>

  </div>

  <div class="container" style="padding:2%; background-color:rgba(255,255,255,0.8);">
    <form action="" method="post" enctype="multipart/form-data">

      <div class="row">

        <div class="col-md-9">

          <div class="row">

            <div class="form-group col-md-8" style="text-align: left">
              <label><b>Item name </b><i> (Max-length:20)</i></label> </br>
              <input type="text" name="item-name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" placeholder="Salmon etc." value="<?php echo $item_name; ?>" maxlength="20">
              <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>

            <div class="form-group col-md-4" style="text-align: left">
              <label><b>Category</b></label> </br>
              <select id="category" name="category_id" class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>">

                <?php
                $get_category = "SELECT * FROM category WHERE category_status = 'Active'";

                if ($result = mysqli_query($link, $get_category)) {

                  while ($row = mysqli_fetch_assoc($result)) {

                    if ($category == $row["category_id"]) {
                      echo  "<option value='$category' selected hidden>" . $row["category_name"] . "</option>";
                    } else if (empty($category)) {
                      echo  "<option value='$category' selected hidden>$category</option>";
                    }

                    echo '<option value="' . $row["category_id"] . '">' . $row["category_name"] . '</option>';
                  }
                }
                ?>
              </select>
              <span class="invalid-feedback"><?php echo $category_err; ?></span>
            </div>

          </div>

          <div class="form-group" style="text-align: left">
            <label><b>Description </b><i id="count-desc"> (Max-length:<span>500</span>)</i></label> </br>
            <textarea id="get-desc" name="desc" class="form-control <?php echo (!empty($desc_err)) ? 'is-invalid' : ''; ?>" rows="4" cols="50" placeholder="High-quality salmon from Africa!" maxlength="500"><?php echo $desc; ?></textarea>
            <span class="invalid-feedback"><?php echo $desc_err; ?></span>
          </div>
          <script>
            var count_desc = document.querySelector("#count-desc > span");
            var get_desc = document.getElementById("get-desc");

            get_desc.onkeyup = () => {
              count_desc.innerHTML = 500 - get_desc.value.length;
            }

          </script>
          <div class="row">

            <div class="form-group col-md-4" style="text-align: left">
              <label><b>Cost</b></label> </br>
              <input type="text" name="cost" class="form-control <?php echo (!empty($cost_err)) ? 'is-invalid' : ''; ?>" placeholder="10.99 etc." value="<?php echo $cost; ?>">
              <span class="invalid-feedback"><?php echo $cost_err; ?></span>
            </div>

            <div class="form-group col-md-4" style="text-align: left">
              <label><b>Stock</b></label> </br>
              <input type="text" name="stock" class="form-control <?php echo (!empty($stock_err)) ? 'is-invalid' : ''; ?>" placeholder="999" value="<?php echo $stock; ?>">
              <span class="invalid-feedback"><?php echo $stock_err; ?></span>
            </div>

            <div class="form-group col-md-4" style="text-align: left">
              <label><b>Expiry Date</b></label> </br>
              <input id="datefield" type='date' name="exp-date" class="form-control <?php echo (!empty($exp_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $exp_date; ?>" /></input>
              <span class="invalid-feedback"><?php echo $exp_err; ?></span>
              <script>
                var today = new Date();
                today.setDate(today.getDate() + 7);
                var dd = today.getDate();
                var mm = today.getMonth() + 1; //January is 0!
                var yyyy = today.getFullYear();

                if (dd < 10) {
                  dd = '0' + dd;
                }

                if (mm < 10) {
                  mm = '0' + mm;
                }

                today = yyyy + '-' + mm + '-' + dd;
                document.getElementById("datefield").setAttribute("min", today);
              </script>
            </div>

          </div>

          <div class="row">

            <div class="form-group col-md-3" style="text-align: left">
              <label><b>Image</b></label> </br>
              <input type="file" name="image" class="form-control <?php echo (!empty($img_err)) ? 'is-invalid' : ''; ?>">
              <span class="invalid-feedback"><?php echo $img_err; ?></span>
            </div>

          </div>

          <div class="form-group" style="margin-top: 50px">
            <input type="submit" name="add-item" class="btn btn-info btn-lg" value="Submit">
          </div>

        </div>

        <div class="col-md-3">
          <img src="assets/images/Logo3.png" style="width: 100%; object-fit: contain; border-radius: 25px;">
        </div>

      </div>

    </form>
  </div>
</section>
</div><!-- page wrapper -->

<!-- /.search-popup -->

<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

<!-- template js -->
<script src="assets/js/organik.js"></script>
</body>

</html>