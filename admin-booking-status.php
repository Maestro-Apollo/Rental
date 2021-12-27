<?php
session_start();
if (isset($_SESSION['admin'])) {
} else {
    header('location:login.php');
}
// $name = "'" . $_SESSION['name'] . "'";
// echo $name;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <style>
    body {
        font-family: 'Lato', sans-serif;

    }

    table.dataTable {
        border-collapse: collapse !important;
    }

    .navbar-brand {
        width: 7%;
    }

    .bg_color {
        background-color: #116530 !important;
    }

    th,
    td {
        font-size: 10px;
    }
    </style>

</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <section>
        <div class="container bg-white pr-4 pl-4  log_section pb-5 pt-lg-4">


            <!-- <h4 class="font-weight-bold pt-5 text-center">Booking History</h4> -->
            <!-- <form action="">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="name" data-toggle="datepicker" class="form-control mt-4 p-4  bg-light"
                            placeholder="From Date" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" data-toggle="datepicker" name="name" class="form-control mt-4 p-4  bg-light"
                            placeholder="To Date" required>
                    </div>
                    <div class="col-md-4">
                        <select name="" class="form-control mt-4  bg-light" id="">
                            <option value="">Choose an option</option>
                            <option value="">Done</option>
                            <option value="">Incomplete</option>
                        </select>
                    </div>
                </div>
                <button name="signup" type="submit" class="btn font-weight-bold log_btn mt-4">Calculate</button>
            </form> -->
            <div id="updateModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id='status' class="form-control">
                                    <option value='Complete'>Complete</option>
                                    <option value='Incomplete'>Incomplete</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="city">Admin Comment</label>
                                <textarea class="form-control" name="admin_comment" id="admin_comment"
                                    placeholder="Admin Comment" cols="30" rows="3"></textarea>

                            </div>
                            <div class="form-group">
                                <label for="city">Staff Comment</label>
                                <textarea class="form-control" name="staff_comment" id="staff_comment"
                                    placeholder="Staff Comment" cols="30" rows="3" readonly></textarea>

                            </div>
                            <!-- <div class="form-group">
                                <label for="name">Property Name</label>
                                <input type="text" class="form-control" id="property_name"
                                    placeholder="Enter property name" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="email">Date</label>
                                <input type="text" class="form-control" id="date" readonly placeholder="Enter date">
                            </div>

                            <div class="form-group">
                                <label for="city">Agent Com</label>
                                <input type="text" name="agent_com" class="form-control" id="agent_com" readonly
                                    placeholder="Enter agent com">
                            </div>
                            <div class="form-group">
                                <label for="city">Rent/Month</label>
                                <input type="text" class="form-control" id="rent" readonly placeholder="Enter Rent">
                            </div>
                            <div class="form-group">
                                <label for="city">CL</label>
                                <input type="text" name="land_com" class="form-control" readonly id="com_landlord"
                                    placeholder="Enter L.C">
                            </div>
                            <div class="form-group">
                                <label for="city">CT</label>
                                <input type="text" name="tenant_com" class="form-control" id="com_tenant" readonly
                                    placeholder="Enter T.C">
                            </div>
                            <div class="form-group">
                                <label for="city">ACL</label>
                                <input type="text" name="agent_com_per" class="form-control" readonly
                                    id="agent_com_landloard" placeholder="Enter ACL" readonly>
                            </div>
                            <div class="form-group">
                                <label for="city">ACT</label>
                                <input type="text" name="tenant_com_per" class="form-control" id="agent_com_tenant"
                                    placeholder="Enter ACT" readonly>
                            </div>
                            <div class="form-group">
                                <label for="city">CC</label>
                                <input type="text" class="form-control" name="company_com" id="company_com"
                                    placeholder="Enter Company Com" readonly>
                            </div> -->


                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="txt_userid" value="0">
                            <button type="button" class="btn btn-success btn-sm" id="btn_save">Save</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

            <h4 class="font-weight-bold pt-5 text-center">Booking History</h4>
            <div class="table-responsive">

                <table id="userTable" class="table table-striped table-bordered" style="width:10%">
                    <thead>
                        <tr>
                            <th>P. Name</th>
                            <th>A. Name</th>
                            <th>Date</th>
                            <th>%</th>
                            <th>Rent/Month</th>
                            <th>C.L</th>
                            <th>C.T</th>
                            <th>A.C.L</th>
                            <th>A.C.T</th>
                            <th>T.A.C</th>
                            <th>T.C.C</th>
                            <th>Status</th>
                            <th>Admin Comment</th>
                            <th>Staff Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>


                </table>
            </div>

        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>
    <script src="js/datepicker.js"></script>


    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: false,

        });
    });
    $('[data-toggle="datepicker"]').datepicker({
        autoClose: true,
        viewStart: 2,
        format: 'dd/mm/yyyy',

    });
    </script>
    <script>
    var userDataTable = $('#userTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "order": [
            [0, "desc"]
        ],
        "pageLength": 50,
        'ajax': {
            'url': 'ajaxfile3.php'
        },
        'columns': [{
            data: 'property_name'
        }, {
            data: 'agent_name'
        }, {
            data: 'date'
        }, {
            data: 'agent_com'
        }, {
            data: 'rent'
        }, {
            data: 'com_landlord'
        }, {
            data: 'com_tenant'
        }, {
            data: 'agent_com_landloard'
        }, {
            data: 'agent_com_tenant'
        }, {
            data: 'company_com'
        }, {
            data: 'tcc'
        }, {
            data: 'status'
        }, {
            data: 'admin_comment'
        }, {
            data: 'staff_comment'
        }, {
            data: 'action'
        }, ]
    });

    // Update record
    $('#userTable').on('click', '.updateUser', function() {
        var id = $(this).data('id');

        $('#txt_userid').val(id);

        // AJAX request
        $.ajax({
            url: 'ajaxfile3.php',
            type: 'post',
            data: {
                request: 2,
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == 1) {

                    $('#property_name').val(response.data.property_name);
                    $('#date').val(response.data.date);
                    $('#agent_com').val(response.data.agent_com);
                    $('#rent').val(response.data.rent);
                    $('#com_landlord').val(response.data.com_landlord);
                    $('#com_tenant').val(response.data.com_tenant);
                    $('#agent_com_landloard').val(response.data.agent_com_landloard);
                    $('#agent_com_tenant').val(response.data.agent_com_tenant);
                    $('#company_com').val(response.data.company_com);
                    $('#status').val(response.data.status);
                    $('#admin_comment').val(response.data.admin_comment);
                    $('#staff_comment').val(response.data.staff_comment);

                } else {
                    alert("Invalid ID.");
                }
            }
        });

    });


    // Save user 
    $('#btn_save').click(function() {
        var id = $('#txt_userid').val();

        // var property_name = $('#property_name').val().trim();
        // var date = $('#date').val().trim();
        // var agent_com = $('#agent_com').val().trim();
        // var rent = $('#rent').val().trim();
        // var com_landlord = $('#com_landlord').val().trim();
        // var com_tenant = $('#com_tenant').val().trim();
        // var agent_com_landloard = $('#agent_com_landloard').val().trim();
        // var agent_com_tenant = $('#agent_com_tenant').val().trim();
        // var company_com = $('#company_com').val().trim();
        var status = $('#status').val().trim();
        var admin_comment = $('#admin_comment').val().trim();

        if (status != '') {

            // AJAX request
            $.ajax({
                url: 'ajaxfile3.php',
                type: 'post',
                data: {
                    request: 3,
                    id: id,
                    // property_name: property_name,
                    // date: date,
                    // agent_com: agent_com,
                    // rent: rent,
                    // com_landlord: com_landlord,
                    // com_tenant: com_tenant,
                    // agent_com_landloard: agent_com_landloard,
                    // agent_com_tenant: agent_com_tenant,
                    // company_com: company_com,
                    status: status,
                    admin_comment: admin_comment,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 1) {
                        // alert(response.message);

                        // Empty the fields
                        $('#admin_comment').val('');

                        $('#status').val('Complete');

                        $('#txt_userid').val(0);

                        // Reload DataTable
                        userDataTable.ajax.reload();

                        // Close modal
                        $('#updateModal').modal('toggle');
                    } else {
                        alert(response.message);
                    }
                }
            });

        } else {
            alert('Please fill all fields.');
        }
    });

    //Delete
    $('#userTable').on('click', '.deleteUser', function() {
        var id = $(this).data('id');

        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // AJAX request
            $.ajax({
                url: 'ajaxfile3.php',
                type: 'post',
                data: {
                    request: 4,
                    id: id
                },
                success: function(response) {

                    if (response == 1) {
                        alert("Record deleted.");

                        // Reload DataTable
                        userDataTable.ajax.reload();
                    } else {
                        alert("Invalid ID.");
                    }

                }
            });
        }

    });
    </script>
    <script>
    let land_com = document.querySelector('input[name="land_com"]');
    let tenant_com = document.querySelector('input[name="tenant_com"]');


    land_com.addEventListener('keyup', () => {
        // let agent_com_per = ;
        let agent_com = document.querySelector('input[name="agent_com"]').value;
        let agent_com_per = document.querySelector('input[name="agent_com_per"]').value = parseFloat(((
            parseFloat(
                land_com
                .value) * parseFloat(
                agent_com)) / 100));
        final_calc(agent_com_per, document.querySelector('input[name="tenant_com_per"]').value);
    });

    tenant_com.addEventListener('keyup', () => {
        // let agent_com_per = ;

        let agent_com = document.querySelector('input[name="agent_com"]').value;
        let tenant_com_per = document.querySelector('input[name="tenant_com_per"]').value = parseFloat(((
            parseFloat(
                tenant_com.value) * parseFloat(
                agent_com)) / 100));
        final_calc(document.querySelector('input[name="agent_com_per"]').value, tenant_com_per);

        /* let b = document.querySelector('input[name="tenant_com"]').value;
        let a = document.querySelector('input[name="land_com"]').value;

        tot = ((100 - agent_com) / 100) * (a + b);

        console.log(a, b); */
    });

    function final_calc(agent_com_per, tenant_com_per) {
        agent_com_per = (agent_com_per === '') ? 0 : parseFloat(agent_com_per);
        tenant_com_per = (tenant_com_per === '') ? 0 : parseFloat(tenant_com_per);
        document.querySelector('input[name="company_com"]').value = agent_com_per + tenant_com_per;
    }
    </script>
</body>

</html>