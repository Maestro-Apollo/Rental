<?php
session_start();
if (isset($_SESSION['admin'])) {
} else {
    header('location:login.php');
}
// $columnSortOrder = $_POST['order'][0]['dir'];
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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
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
                                <label for="name">Description</label>
                                <input type="text" class="form-control" id="description" placeholder="Enter Description"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="email">Amount</label>
                                <input type="number" class="form-control" id="amount" placeholder="Enter Amount">
                            </div>

                            <div class="form-group">
                                <label for="city">Paid By</label>
                                <input type="text" name="paid_by" class="form-control" id="paid_by"
                                    placeholder="Enter Paid By">
                            </div>
                            <div class="form-group">
                                <label for="city">Received By</label>
                                <input type="text" class="form-control" id="received_by"
                                    placeholder="Enter Received By">
                            </div>
                            <div class="form-group">
                                <label for="city">Remarks</label>
                                <input type="text" name="remarks" class="form-control" id="remarks"
                                    placeholder="Enter Remarks">
                            </div>
                            <div class="form-group">
                                <label for="slip">Copy of Slip</label>
                                <select id='slip' class="form-control">
                                    <option value='Yes'>Yes</option>
                                    <option value='No'>No</option>
                                </select>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="txt_userid" value="0">
                            <button type="button" class="btn btn-success btn-sm" id="btn_save">Save</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

            <h4 class="font-weight-bold pt-5 text-center">Transaction History</h4>
            <div class="table-responsive">

                <table id="userTable" class="table table-striped table-bordered" style="width:10%">
                    <thead>
                        <tr>
                            <th>Agent</th>
                            <th>Property Name</th>
                            <th>Booking Date</th>
                            <th>Transaction Date</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Paid By</th>
                            <th>Received By</th>
                            <th>Remarks</th>
                            <th>Copy of Slip</th>
                            <th class="not-export-column">Action</th>
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
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: false,
            dom: 'Bfrtip',
            "ordering": false,
            buttons: [
                'copy', 'excel', 'print'
            ]

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
        'columnDefs': [{
            orderable: false,
            targets: 0
        }],
        // "ordering": false,
        'serverMethod': 'post',
        "pageLength": 10000000000,
        'dom': 'Bfrtip',
        'buttons': [{
            extend: 'copy',
            title: "Download",
            exportOptions: {
                columns: ":not(.not-export-column)"
            }
        }, {
            extend: 'print',
            title: "Download",
            exportOptions: {
                columns: ":not(.not-export-column)"
            }
        }, {
            extend: 'excel',
            title: "Download",
            exportOptions: {
                columns: ":not(.not-export-column)"
            }
        }],
        // "drawCallback": function(settings) {
        //     console,
        //     log(settings);
        // },

        'ajax': {
            'url': 'ajaxfile2.php'
        },
        'columns': [{
            data: 'agent_name'
        }, {
            data: 'property_name'
        }, {
            data: 'date'
        }, {
            data: 't_date'
        }, {
            data: 'description'
        }, {
            data: 'amount'
        }, {
            data: 'paid_by'
        }, {
            data: 'received_by'
        }, {
            data: 'remarks'
        }, {
            data: 'slip'
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
            url: 'ajaxfile2.php',
            type: 'post',
            data: {
                request: 2,
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == 1) {

                    $('#description').val(response.data.description);
                    $('#amount').val(response.data.amount);
                    $('#paid_by').val(response.data.paid_by);
                    $('#received_by').val(response.data.received_by);
                    $('#remarks').val(response.data.remarks);
                    $('#slip').val(response.data.slip);


                } else {
                    alert("Invalid ID.");
                }
            }
        });

    });


    // Save user 
    $('#btn_save').click(function() {
        var id = $('#txt_userid').val();

        var description = $('#description').val().trim();
        var amount = $('#amount').val().trim();
        var paid_by = $('#paid_by').val().trim();
        var received_by = $('#received_by').val().trim();
        var remarks = $('#remarks').val().trim();
        var slip = $('#slip').val().trim();


        if (description != '' && amount != '' && paid_by != '' && received_by != '' && remarks != '' &&
            slip != '') {

            // AJAX request
            $.ajax({
                url: 'ajaxfile2.php',
                type: 'post',
                data: {
                    request: 3,
                    id: id,
                    description: description,
                    amount: amount,
                    paid_by: paid_by,
                    received_by: received_by,
                    remarks: remarks,
                    slip: slip,

                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 1) {
                        // alert(response.message);

                        // Empty the fields
                        $('#description', '#amount', '#paid_by', '#received_by', '#remarks').val(
                            '');
                        $('#slip').val('Yes');
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
                url: 'ajaxfile2.php',
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

</body>

</html>