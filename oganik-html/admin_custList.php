<?php

include 'admin_header.php';

?>


<section class="">
    <div class="container" style="padding:1%; margin-top:1%; margin-bottom:1%; background-color:rgba(255,255,255,0.8); text-align:center">
        <h1>Customer's List</h1>
    </div>

    <div class="container" style="background-color:rgba(255,255,255,0.8); padding: 2%">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel-group" id="accordion">
                            <table class="display" style="width: 100%;" id="dtBasicExample">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Phone</th>
                                        <th>E-mail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sqll = "SELECT * FROM users where mode ='customer'";
                                        $list = mysqli_query($link, $sqll);
                                        while ($rows = mysqli_fetch_assoc($list)) {
                                        echo '
                                        <tr>
                                            <td>' . $rows['user_id'] . '</td>
                                            <td>' . $rows['firstname'] . '</td>
                                            <td>' . $rows['lastname'] . '</td>
                                            <td>' . $rows['phone'] . '</td>
                                            <td>' . $rows['email'] . '</td>
                                        </tr>';
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone</th>
                                    <th>E-mail</th>
                                </tfoot>
                            </table>
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
            //pageLength : 5
            /*
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
    
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
    
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                });
            }*/
        });

        //table.buttons().container()
        //    .appendTo('#dtBasicExample_wrapper .col-md-6:eq(0)');
    });
</script>
<!-- /.search-popup -->

<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

<!-- template js -->
<script src="assets/js/organik.js"></script>
</body>

</html>