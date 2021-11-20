<?php

include 'admin_header.php';

if (isset($_GET["deactivate"])) {
    $user_id = $_GET["user_id"];

    $sql = "UPDATE users SET mode = 'deactivateCust' where user_id = $user_id";

    if (mysqli_query($link, $sql)) {
        header("Location: admin_custList.php");
        die();
    }
}

if (isset($_GET["activate"])) {
    $user_id = $_GET["user_id"];

    $sql = "UPDATE users SET mode = 'customer' where user_id = $user_id";

    if (mysqli_query($link, $sql)) {
        header("Location: admin_custList.php");
        die();
    }
}
?>


<section class="">
    <div class="container" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">
        <h1>Customer's List</h1>
    </div>

    <div class="container admin-content" style="background-color:rgba(255,255,255,0.8); padding: 2%">
        <div class="row">
            
            <div class="col-sm-12">
                <div class="product-tab-box tabs-box" style="margin:0">
                    <ul class="tab-btns tab-buttons clearfix list-unstyled">
                        <li data-tab="#desc" class="tab-btn active-btn"><span>Active Customer</span></li>
                        <li data-tab="#addi__info" class="tab-btn"><span>Inactive Customer</span></li>
                    </ul>
                    <div class="tabs-content">
                        <div class="tab active-tab" id="desc">
                            <div class="product-details-content" style="padding: 20px 30px;">
                                <div class="desc-content-box">
                                    <table id="dtBasicExample" class="display">
                                        <thead>
                                            <tr>
                                                <th>User ID</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $sql = "SELECT * FROM users WHERE mode = 'customer'";

                                        if ($result = mysqli_query($link, $sql)) {

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '
                                            <tr>
                                                <td>' . $row['user_id'] . '</td>
                                                <td>' . $row['firstname'] . '</td>
                                                <td>' . $row['lastname'] . '</td>
                                                <td>' . $row['email'] . '</td>
                                                <td>' . $row['phone'] . '</td>
                                                <td>
                                                    <div class="form-group" style="text-align: left">
                                                        <button class="btn btn-info btn-sm" onclick="return deactivateCust(' . $row['user_id'] . ');">Deactivate</button>
                                                    </div>
                                                </td>
                                            </tr>';
                                            }
                                        }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>User ID</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="tab" id="addi__info">
                            <div class="product-details-content" style="padding: 20px 30px;">
                                <div class="desc-content-box">

                                    <table id="dtTableInactive" class="display">
                                        <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $sql = "SELECT * FROM users WHERE mode = 'deactivateCust'";

                                        if ($result = mysqli_query($link, $sql)) {

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '
                                        <tr>
                                            <td>' . $row['user_id'] . '</td>
                                            <td>' . $row['firstname'] . '</td>
                                            <td>' . $row['lastname'] . '</td>
                                            <td>' . $row['email'] . '</td>
                                            <td>' . $row['phone'] . '</td>
                                            <td>
                                                <div class="form-group" style="text-align: left">
                                                    <button class="btn btn-info btn-sm" onclick="return activateCust(' . $row['user_id'] . ');">Activate</button>
                                                </div>
                                            </td>
                                        </tr>';
                                            }
                                        }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>User ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div> <!-- page wrapper -->

<script>
    $(document).ready(function() {
        var table = $('#dtBasicExample').DataTable({
            "scrollY": "50vh",
            "scrollCollapse": true,
            "pagingType": "full_numbers",
            dom: 'Bfrtip',
            buttons: [
                'pdf',
                'csv',
                'excel', 
                'colvis'
            ],
            
            "order": [[ 0, "dsc" ]]
        });

        var table = $('#dtTableInactive').DataTable({
            "scrollY": "50vh",
            "scrollCollapse": true,
            "pagingType": "full_numbers",
            dom: 'Bfrtip',
            buttons: [
            ],
        });
    });

    function deactivateCust(id) 
    {
        Swal.fire({
            title: 'Deactivate this customer ?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: "admin_custList.php",
                    data: {
                        'deactivate': true,
                        'user_id': id
                    },
                    cache: false,
                    success: function(html) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully Updated',
                            confirmButtonText: 'Okay',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'admin_custList.php';
                            }
                        })
                    }
                });
            }
        });
        return false;
    }

    function activateCust(id) 
    {
        Swal.fire({
            title: 'Activate this customer ?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: "admin_custList.php",
                    data: {
                        'activate': true,
                        'user_id': id
                    },
                    cache: false,
                    success: function(html) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully Updated',
                            confirmButtonText: 'Okay',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'admin_custList.php';
                            }
                        })
                    }
                });
            }
        });
        return false;
    }
</script>
<!-- /.search-popup -->

<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

<!-- template js -->
<script src="assets/js/organik.js"></script>
</body>

</html>