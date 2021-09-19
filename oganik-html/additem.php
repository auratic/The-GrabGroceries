<?php
  session_start();
  
  if(!isset($_SESSION["loggedin"]) || !isset($_SESSION["mode"]) || $_SESSION["mode"] !== "admin") {
   echo "
    <script>
      alert('You are not authorized to this page');
      location.href='index.php';
    </script>";
  }

  require "config.php";

  $item_name;
  $category;
  $desc;
  $cost;
  $stock;
  $exp_date;

  if(isset($_POST["add-item"])){

    $exp_err = $cost_err = $img_err = $category_err = $name_err = $desc_err = $stock_err = "";
            
      if($_FILES['image']['size'] == 0) {
        $img_err = "Please upload an image.";
      } else {
        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];    
        $folder = "assets/images/items/".$filename;

      }
      
      if(empty(trim($_POST["item-name"]))) {
        $name_err = "Please enter name";
      } else {
          $item_name = ucwords(trim($_POST["item-name"]));
      }

      if(empty(trim($_POST["category"]))) {
        $category_err = "Please select a category";
      } else {
          $category = trim($_POST["category"]);
      }
      
      if(empty(trim($_POST["desc"]))) {
        $desc_err = "Please fill in the description";
      } else {
          $desc = ucfirst(trim($_POST["desc"]));
      }

      if(empty(trim($_POST["cost"]))) {
        $cost_err = "Please enter cost";
      } else {
          $cost = trim($_POST["cost"]);
      }

      if(empty(trim($_POST["stock"]))) {
        $stock_err = "Please enter stock";
      } else {
        $stock = trim($_POST["stock"]);
      }

      if(empty(trim($_POST["exp-date"]))) {
        $exp_err = "Please enter expire date";
      } else {
          $exp_date = trim($_POST["exp-date"]);
      }


        // Get all the submitted data from the form
        //$sql = "INSERT INTO image (filename) VALUES ('$filename')";
        // Execute query
        //mysqli_query($db, $sql);
          
      if($name_err == "" &&
         $category_err == "" &&
         $desc_err == "" &&
         $img_err == "" &&
         $cost_err == "" &&
         $stock_err == "" &&
         $exp_err == "") {

         $sql = "INSERT INTO item (item, category, description, stock, image, cost, exp_date)
                 VALUES ('$item_name', '$category', '$desc', '$stock', '$filename', '$cost', '$exp_date')";

                  
         if (move_uploaded_file($tempname, $folder))  {

         } else {
           echo "
            <script>
              alert('Something went wrong uploading image');
              location.href = 'additem.php'
            </script>";
         }

         if (mysqli_query($link, $sql)) {
           echo "
            <script>
              alert('Items added successfully');
              location.href = 'additem.php'
            </script>";
         } else {
           echo "
            <script>
              alert('Something went wrong uploading data to database');
              location.href = 'additem.php'
            </script>";
         }

      }
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Item || TheGrabGroceries</title>
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
    <link rel="stylesheet" type="assets/css" href="css/organik.css">

    <!-- template styles -->
    <link rel="stylesheet" href="assets/css/organik.css" />
    <style>
        body { 
          font: 14px sans-serif; 
          background-image: url("https://cdn.wallpapersafari.com/68/37/Gwgjo6.jpg")
        }
        .signup-form{ 
          padding: 20px; 
          margin: 20px 50px 20px 50px;
          background-color: azure;
          overflow: auto;
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
                            <img src="assets/images/logo-dark.png" width="105" alt="">
                        </a>
                        <div class="mobile-nav__buttons">
                            <a href="#" class="search-toggler"><i class="organik-icon-magnifying-glass"></i></a>
                            <a href="#" class="mini-cart__toggler"><i class="organik-icon-shopping-cart"></i></a>
                        </div><!-- /.mobile__buttons -->

                        <span class="fa fa-bars mobile-nav__toggler"></span>
                    </div><!-- /.main-logo -->

                    <div class="topbar__left">
                        <div class="topbar__social">
                            <a href="https://twitter.com/" class="fab fa-twitter"></a>
                            <a href="https://www.facebook.com/" class="fab fa-facebook-square"></a>
                            <a href="https://www.instagram.com/" class="fab fa-instagram"></a>
                        </div><!-- /.topbar__social -->
                        <div class="topbar__info">
                            <i class="organik-icon-email"></i>
                            <p>Email <a href="mailto:thegrabgroceries@gmail.com">thegrabgroceries@gmail.com</a></p>
                        </div><!-- /.topbar__info -->
                    </div><!-- /.topbar__left -->
                    <div class="topbar__right">
                        <div class="topbar__info">
                            <i class="organik-icon-calling"></i>
                            <p>Phone <a href="tel:+92-666-888-0000">+60123456789</a></p>
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
                    <a href="<?php if(isset($_SESSION["lname"])) { echo "adminprofile.php";} else { echo "login.php"; }?>" >
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
                        <li>
                            <a href="adminprofile.php">Profile</a>
                        </li>
                        <li>
                            <a href="additem.php">Add item</a>
                        </li>
                        <li class="dropdown">
                            <a href="displayitem.php">Update product</a>
                            <ul>
                                <li><a href="displayitem.php">Update product</a></li>
                                <li><a href="archiveitem.php">Archive product</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="admin_view_transaction.php">Transactions</a>
                        </li>
                        <li><a href="adminlist.php">Admin</a></li>
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
                </div><!-- /.container -->
            </nav>
        </header>

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->

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
                        <label><b>Item name</b></label> </br>
                          <input type="text" name="item-name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" placeholder="Salmon etc.">
                        <span class="invalid-feedback"><?php echo $name_err; ?></span>
                      </div>   

                      <div class="form-group col-md-4" style="text-align: left">
                        <label><b>Category</b></label> </br>
                          <select id="category" name="category" class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>" >
                          <option value="Fruit & Vegetables">Fruit & Vegetables</option>
                          <option value="Meat">Meat</option>
                          <option value="Seafood">Seafood</option>
                          <option value="Snack">Snack</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $category_err; ?></span>
                      </div>     

                    </div>

                    <div class="form-group" style="text-align: left">
                      <label><b>Description</b></label> </br>
                      <textarea name="desc" 
                        class="form-control <?php echo (!empty($desc_err)) ? 'is-invalid' : ''; ?>" 
                        rows="4" cols="50"
                        placeholder="High-quality salmon from Africa!"></textarea>
                      <span class="invalid-feedback"><?php echo $desc_err; ?></span>
                    </div>    

                    <div class="row">

                      <div class="form-group col-md-4" style="text-align: left">
                        <label><b>Cost</b></label> </br>
                          <input type="text" name="cost" class="form-control <?php echo (!empty($cost_err)) ? 'is-invalid' : ''; ?>" placeholder="10.99 etc.">
                        <span class="invalid-feedback"><?php echo $cost_err; ?></span>
                      </div>    

                      <div class="form-group col-md-4" style="text-align: left">
                        <label><b>Stock</b></label> </br>
                        <input type="text" name="stock" class="form-control <?php echo (!empty($stock_err)) ? 'is-invalid' : ''; ?>" placeholder="999">
                        <span class="invalid-feedback"><?php echo $stock_err; ?></span>
                      </div>

                      <div class="form-group col-md-4" style="text-align: left">
                        <label><b>Expiry Date</b></label> </br>
                        <input type="text" name="exp-date" class="form-control <?php echo (!empty($exp_err)) ? 'is-invalid' : ''; ?>" placeholder="Format: 2021-05-21">
                        <span class="invalid-feedback"><?php echo $exp_err; ?></span>
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
      </div>

    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>


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
