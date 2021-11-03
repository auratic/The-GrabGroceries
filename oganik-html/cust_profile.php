<?php
include 'cust_header.php';

if (!isset($_SESSION["loggedin"])) {
    echo "
        <script>
        $('.preloader').css('display','none');
        Swal.fire({
            title: 'Error',
            text: 'Please log in.',
            icon: 'error'
        }).then(function() {
        location.href = 'login.php'
        })
        </script>";
}
?>
<!-- :::::::::: Profile :::::::::: -->
<?php include 'cust_profile_layout.php' ?>

<div class="col-xl-10 col-md-10">
    <div class="tab-content my-account-tab" id="pills-tabContent">
        <div class="#" id="pills-dashboard" aria-labelledby="pills-dashboard-tab">
            <div class="my-account-dashboard account-wrapper">
                <h4 class="account-title"><?php echo $lang['dboard']?></h4>
                <div class="welcome-dashboard m-t-30">
                    <p>
                        <?php echo $lang['p1'];
                        $sql = "SELECT * FROM users WHERE user_id = " . $_SESSION['userid'];
                        $result = mysqli_query($link, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $fname = $row['firstname'];
                            $lname = $row['lastname'];
                        }
                        echo "<strong>  " . $fname . " " . $lname . " </strong>"
                        .$lang['p2']?>

                        <a href="logout.php"> <?php echo $lang['p3']?></a>)
                    </p>
                </div>
                <p class="m-t-25"> <?php echo $lang['p4']?>
                </p>
            </div>
        </div>
        <div class="col-md-3">
            <a href="index.php">
                <img src="assets/images/Logo6.png" style="width: 100%; object-fit: contain; border-radius: 25px; margin-left: 350px;">
            </a>
        </div>
    </div>
</div>
</div>
</div><!-- :::::::::: End My Account Section :::::::::: -->
</div>
</div>
</div>
</main>

<?php include 'cust_footer.php'; ?>