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
                <h4 class="account-title">Dashboard</h4>
                <div class="welcome-dashboard m-t-30">
                    <p>Hello, (If not
                        <?php
                        $sql = "SELECT * FROM users WHERE user_id = " . $_SESSION['userid'];
                        $result = mysqli_query($link, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $fname = $row['firstname'];
                            $lname = $row['lastname'];
                        }
                        echo "<strong>  " . $fname . " " . $lname . "</strong>"
                        ?>

                        please <a href="logout.php">Logout</a> )
                    </p>
                </div>
                <p class="m-t-25">From your account dashboard. you can easily check &amp; view your
                    recent orders, manage your shipping and billing addresses and edit your password and
                    account details.
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