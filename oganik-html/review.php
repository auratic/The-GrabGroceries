<?php
include 'cust_header.php';

$sql = "SELECT * FROM cust_review";
$review_array = array();

if ($result = mysqli_query($link, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($review_array, $row["review_id"]);
    }
}

$rating_err = $review_err = $name_err = "";
$rating = $review = $name = "";
$registering = "";

if (isset($_POST['add'])) {
    $registering = "true";
    if (empty($_POST['name'])) {
        $name_err = "Please enter your name.";
    } else {
        $name = $_POST['name'];
    }

    if (empty($_POST['rating'])) {
        $rating_err = "Choose one option";
    } else {
        $rating = $_POST['rating'];
    }

    if (empty($_POST['review'])) {
        $review_err = "Please leave a review.";
    } else {
        $review = $_POST['review'];
    }

    if (empty($name_err) && empty($rating_err) && empty($review_err)) {
        $sql = "INSERT INTO cust_review (user_id, reviews, rating, cust_name) VALUES (" . $_SESSION['userid'] . ", '$review', '$rating', '$name');";
        $sql_reset_review = "UPDATE users SET review = 'false' WHERE user_id = " . $_SESSION["userid"];

        if (mysqli_query($link, $sql)) {
            if (mysqli_query($link, $sql_reset_review)) {
            } else {
                echo '
                    <script>
                        alert("Something went wrong.")
                    </script>
                    ';
            }
            echo "
                <script>
                    Swal.fire({
                        title: 'Successful',
                        text: 'We have received your comment',
                        icon: 'success'
                    }).then(function() {
                    location.href = 'review.php'
                    })
                </script>
                ";
        } else {
            echo '
                <script>
                    alert("Something went wrong.")
                </script>
                ';
        }
    }
}
?>

<style>
    .carousel-control-next-icon:after {
        font-size: 34px;
        color: black;
    }

    .carousel-control-prev-icon:after {
        font-size: 34px;
        color: black;
    }

    .carousel-control-prev-icon {
        width: 50px;
        height: 50px;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23c593d8' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath d='M5.25 0l-4 4 4 4 1.5-1.5L4.25 4l2.5-2.5L5.25 0z'/%3e%3c/svg%3e");
    }

    .carousel-control-next-icon {
        width: 50px;
        height: 50px;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23c593d8' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath d='M2.75 0l-1.5 1.5L3.75 4l-2.5 2.5L2.75 8l4-4-4-4z'/%3e%3c/svg%3e");
    }
</style>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2>Testimonials</h2>
        <ul class="thm-breadcrumb list-unstyled">
            <li><a href="index.php">Home</a></li>
            <li>/</li>
            <li><span>Testimonials</span></li>
        </ul><!-- /.thm-breadcrumb list-unstyled -->
    </div><!-- /.container -->
</section><!-- /.page-header -->

<section class="testimonials-one">
    <div class="testimonials-one__head">
        <div class="container">
            <div class="block-title text-center">
                <div class="block-title__decor"></div><!-- /.block-title__decor -->
                <p>Our Testimonials</p>
                <h3>What People Say?</h3>
            </div><!-- /.block-title -->
        </div><!-- /.container -->
    </div><!-- /.testimonials-one__head -->
    <div class="container">
        <div class="testimonials-one__single">
            <div class="testimonials-one__content">
                <?php
                $sql_review = "SELECT * FROM cust_review";
                $result = mysqli_query($link, $sql_review);
                while ($row = mysqli_fetch_assoc($result)) {
                    if($row['rating'] == 'Poor')
                    {
                        $star = "<i class='fa fa-star'></i><i class='far fa-star'></i><i class='far fa-star'></i><i class='far fa-star'></i><i class='far fa-star'></i>";
                    }
                    else if($row['rating'] == 'Fair')
                    {
                        $star = "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='far fa-star'></i><i class='far fa-star'></i><i class='far fa-star'></i>";
                    }
                    else if($row['rating'] == 'Average')
                    {
                        $star = "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='far fa-star'></i><i class='far fa-star'></i>";
                    }
                    else if($row['rating'] == 'Good')
                    {
                        $star = "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='far fa-star'></i>";
                    }
                    else if($row['rating'] == 'Excellent')
                    {
                        $star = "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i>";
                    }
                    echo "
                        <div class='row'style='text-align: left;'>
                            <div class='col-2'>
                                <img src='assets/images/cust.jpg' alt='' style='margin-left: -10px; margin-top: 20px; width: 140px; height: 140px;'>
                            </div>
                            <div class='col-10'>
                                <h3>" . $row['cust_name'] . "</h3><span style>" .$star. "</span>
                                <p>" . $row['reviews'] . "</p>
                                <hr>
                            </div>
                        </div>
                    ";
                }
                ?>
            </div><!-- /.testimonials-one__content -->
        </div><!-- /.testimonials-one__single -->

        <?php
            if (isset($_SESSION["loggedin"])) {
                $sql = "SELECT review FROM users WHERE user_id = " . $_SESSION["userid"];
                $result = mysqli_query($link, $sql);
                $row = mysqli_fetch_assoc($result);
        
                if (isset($_SESSION["loggedin"]) && ($row["review"] == 'true')) {
                    echo "
                                    <div class='form-group' style='text-align: left; margin-right: 1rem'>
                                        <button class='thm-btn' style='margin-left: 950px;' onclick='return addReview();'>Leave a review</button>
                                    </div>
                                ";
                }

            }
        ?>


        <div class="modal" id="add-modal" role="dialog">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header" style="background-color:var(--thm-base)">
                        <h4 class="modal-title"><span style="color:white;">Leave a Message</span></h4>
                        <!--<button type="button" class="close" style="margin-right: 10px">&times;</button>-->
                    </div>
                    <!-- Modal Header-->

                    <div class="modal-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); /* $_SERVER["PHP_SELF"] Returns the filename of the currently executing script */ ?>" method="post" style="text-align: left">
                            <div class="form-group">
                                <label>Your Name</label> </br>
                                <input type="name" name="name" class="form-control" placeholder="John Doe" value="<?php echo $name; ?>">
                                <span class="invalid-feedback d-block"><?php echo $name_err; ?></span>
                            </div>

                            <div class="form-group">
                                <label>Rating</label> </br>
                                <select name="rating" id="rating" class="form-control" value="<?php echo $rating; ?>">
                                    <option disabled selected value></option>
                                    <option value="Poor">Poor</option>
                                    <option value="Fair">Fair</option>
                                    <option value="Average">Average</option>
                                    <option value="Good">Good</option>
                                    <option value="Excellent">Excellent</option>
                                </select>
                                <span class="invalid-feedback d-block"><?php echo $rating_err; ?></span>
                            </div>

                            <div class="form-group" style="text-align: left">
                                <label><b>Your comment</b></label> </br>
                                <textarea name="review" class="form-control" rows="4" cols="50" value="<?php echo $review; ?>"></textarea>
                                <span class="invalid-feedback d-block"><?php echo $review_err; ?></span>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="add" class="btn btn-primary" value="Send">
                            </div>
                        </form>
                    </div>
                    <!-- Modal Body-->

                    <div class="modal-footer" style="background-color:var(--thm-base)">
                        <button type="button" class="btn btn-danger" onclick="return closeModal()">Cancel</button>
                    </div>
                    <!-- Modal Footer-->
                </div>
                <!-- Modal content-->
            </div>
        </div>
        <!--Modal-->
    </div><!-- /.container -->
</section><!-- /.testimonials-one -->

<p id="registering"><?php echo $registering ?></p>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    if (document.getElementById("registering").innerHTML != "") {
        $('#add-modal').fadeIn();
    }

    function addReview() {
        $('#add-modal').fadeIn();
        return false;
    }

    function closeModal() {
        $('#add-modal').fadeOut();
        return false;
    }
</script>

<?php include 'cust_footer.php'; ?>