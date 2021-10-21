<?php include 'admin_header.php' ?>

<section>
    <div class="container" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">

        <h1>Dashboard</h1>

    </div>

    <div class="container" style="padding:2%; background-color:rgba(255,255,255,0.8);">
        <!-- Modal Add Item -->
        <div class="row" style="border: solid black 1px; padding:1%">
            <div class="col-sm-10">
                <a href="logout.php">
                    <button class="btn btn-info btn-lg">Logout</button>
                </a>
            </div>
            <div class="col-sm-2">
                <!--
                        <img src="https://i.ibb.co/kMgd8hL/Capture.png" alt="Capture"style="width:50%">
                            -->
            </div>
        </div>
        <div class="row" style="border: solid black 1px; padding:1%">
            <div style="object-fit: cover">
                <img src="assets/images/digital-dashboard-for-clients.png" style="width:100%">
            </div>
        </div>
    </div>

</section>
</div> <!-- page wrapper -->

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
<script>
    $(function() {
        $('[data-toggle="popover"]').popover()
    })

    $(function() {
        $("#instruction").popover('show');
    });

    $(".instruction").click(function() {
        $(".popover").css('display', 'none');
    });
</script>
</body>

</html>