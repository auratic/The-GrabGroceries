<?php

    if(!isset($_SESSION['lang']))
    {
        $_SESSION['lang'] = 'en';
    }
    else if(isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang']))
    {
        if($_GET['lang'] == 'en')
        $_SESSION['lang'] = 'en';
        else if($_GET['lang'] == 'cn')
        $_SESSION['lang'] = 'cn';
    }

    include  $_SESSION['lang']. ".php";
?>
<style>
    body {
        font: 14px sans-serif;
        background-image: url("https://cdn.wallpapersafari.com/68/37/Gwgjo6.jpg")
    }
</style>

<main id="main-container" class="main-container">
    <div class="container" style="background-color: rgba(255,255,255,0.9); margin: 20px auto;">
        <div class="row">
            <div class="col-12">
                <!-- :::::::::: Start My Account Section :::::::::: -->
                <div class="my-account-area">
                    <div class="row">
                        <div class="col-xl-2 col-md-2" style="border-right: 1px solid black">
                            <div class="my-account-menu">
                                <ul class="nav account-menu-list flex-column nav-pills" id="pills-tab" role="tablist">
                                    <li>
                                        <a href="cust_profile.php">
                                            <i class="fas fa-tachometer-alt"></i>&nbsp<?php echo $lang['dboard']?></a>
                                    </li>
                                    <li>
                                        <a href="cust_view_order.php">
                                            <i class="fas fa-shopping-cart"></i>&nbsp<?php echo $lang['order']?></a>
                                    </li>
                                    <li>
                                        <a href="cust_payment.php">
                                            <i class="fas fa-credit-card"></i>&nbsp<?php echo $lang['payment']?></a>
                                    </li>
                                    <li>
                                        <a href="cust_address.php">
                                            <i class="fas fa-map-marker-alt"></i>&nbsp<?php echo $lang['address']?></a>
                                    </li>
                                    <li>
                                        <a href="cust_accdetails.php">
                                            <i class="fas fa-user"></i>&nbsp<?php echo $lang['accountd']?></a>
                                    </li>
                                    <li>
                                        <a href="cust_password.php">
                                            <i class="fas fa-lock"></i>&nbsp<?php echo $lang['pwd_chg']?></a>
                                    </li>
                                    <li>
                                        <a class="link--icon-left" href="logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp<?php echo $lang['logout']?></a>
                                    </li>
                                </ul>
                            </div>

                        </div>