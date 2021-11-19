<?php

include 'admin_header.php';

if (isset($_GET["restore"])) {

    $item_id = $_GET["item_id"];

    $date = date('Y-m-d H:i:s');
    $activity_sql = "INSERT INTO admin_activity (user_id, activity, activity_time, target) VALUES (" . $_SESSION["userid"] . ", 'restore item', '$date', '$item_id')";

    $sql = "UPDATE item SET item_status = 'Active' WHERE item_id = " . $item_id;

    if (mysqli_query($link, $sql)) {
        echo "<script>alert('Updated');</script>";
        mysqli_query($link, $activity_sql);
    } else {
        echo "<script>alert('Some error occured');</script>";
    }
}
?>

<section>
    <div class="container" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(245,245,220,0.8); text-align:center">
        <h1>Archive products</h1>
    </div>

    <div class="container" style="padding:2%; background-color:rgba(245,245,220,0.8);">
        <div class="row">

            <div class="col-sm-12">

                <div class="product-tab-box tabs-box" style="margin:0">

                    <ul class="tab-btns tab-buttons clearfix list-unstyled">
                        <li data-tab="#desc" class="tab-btn" onclick="location.href='admin_displayitem.php'"><span>Active products</span></li>
                        <li data-tab="#addi__info" class="tab-btn active-btn"><span>Archived products</span></li>
                    </ul>

                    <div class="tabs-content">

                        <div class="tab active-tab" id="addi__info">

                            <div class="product-details-content" style="padding: 0;">

                                <div class="desc-content-box">

                                    <div style="padding: 1%;">
                                        <table id="dtBasicExample" class="display">
                                            <thead>
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
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                                            <td><b><div class="exp-date" data-toggle="tooltip" data-placement="bottom" data-html="true" title="">' . date("Y-m-d",strtotime($row['exp_date'])) . '</div></b></td>
                                                            <td>
                                                                <button class="btn btn-info btn-sm" onclick="return restoreItem(' . $row['item_id'] . ')">Restore</button>
                                                            </td>
                                                        </tr>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
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
                                                </tr>
                                            </tfoot>
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
    function restoreItem(id) {
        Swal.fire({
            title: 'Restore this item ?',
            showCancelButton: true,
            confirmButtonText: 'Save',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: "admin_archiveitem.php",
                    data: {
                        'restore': true,
                        'item_id': id
                    },
                    cache: false,
                    success: function(html) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully Updated',
                            confirmButtonText: 'Okay',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'admin_archiveitem.php';
                            }
                        })
                    }
                });
            }
        });

        return false;
    }
    $(document).ready(function() {
        var table = $('#dtBasicExample').DataTable({
            "scrollY": "50vh",
            "scrollCollapse": true,
            "pagingType": "full_numbers",
            dom: 'Bfrtip',
            buttons: [
                'colvis'
            ],
        });

        table.buttons().container()
            .appendTo('#dtBasicExample_wrapper .col-md-6:eq(0)');
    });

    
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    }) //Bootstrap tooltip

    window.onload = () => {
        var exp_date = document.getElementsByClassName("exp-date");
        var today = new Date();   

        $('.exp-date').each(function() {
            var get_date = new Date(this.innerHTML);
            //test
            
            var dateOneUTC = Date.UTC(today.getFullYear(), today.getMonth(), today.getDate())
            var dateTwoUTC = Date.UTC(get_date.getFullYear(), get_date.getMonth(), get_date.getDate())
            var difference = (dateTwoUTC - dateOneUTC) / (1000 * 60 * 60* 24);

            $(this).attr({
                /*
                'date-toggle': 'tooltip',
                'data-placement': "bottom",
                'data-html': "true",
                */
                'title': "Expires within " + ((difference <= 0) ? '0' : difference) + " days"
            });
            
            if(difference <= 7)
                this.style.color = "red";
            else if(difference <= 30)
                this.style.color = "orange";

        });
    }
</script>

<!-- template js -->
<script src="assets/js/organik.js"></script>
</body>

</html>