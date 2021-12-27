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
            <div id="exampleModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <form action="" id="myForm2">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Files</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">

                                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                                <input class="multifile mt-4" type="file" name="booking_file[]">



                            </div>
                            <div class="modal-footer">

                                <button type="submit" class="btn btn-success btn-sm">Add
                                    Files</button>

                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>


            <h4 class="font-weight-bold pt-5 text-center">Booking Files</h4>
            <div class="text-center mb-4 mbt-4">
                <button type="button" class="btn btn-success font-weight-bold" data-toggle="modal"
                    data-target="#exampleModal">
                    Add Files
                </button>
            </div>
            <div class="table-responsive">

                <table id="userTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>File Number</th>
                            <th>File Name</th>
                            <th>File Created At</th>
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
    <script src="js/jquery.multifile.js"></script>
    <script src="js/jquery.multifile.preview.js"></script>
    <script>
    $('.multifile').multifile();
    </script>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: false,
            "pageLength": 50,

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
        'serverMethod': 'post',
        "pageLength": 50,
        'ajax': {
            'url': 'ajax-file.php',
            "data": {
                'booking_id': '<?php echo $_GET['id']; ?>',

            }


        },
        'columns': [{
            data: 'line_number'
        }, {
            data: 'file_name'
        }, {
            data: 'file_created_at'
        }, {
            data: 'action'
        }, ]
    });
    $('#userTable').on('click', '.deleteUser', function() {
        var id = $(this).data('id');

        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // AJAX request
            $.ajax({
                url: 'ajax-file.php',
                type: 'post',
                data: {
                    request: 4,
                    id: id
                },
                success: function(response) {

                    if (response == 1) {
                        // alert("Record deleted.");

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
    $(document).ready(function() {
        $('#myForm2').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "ajax-file-add.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    $('#output2').fadeIn().html(response);

                    userDataTable.ajax.reload();

                }
            });
            this.reset();
            $('#exampleModal').modal('toggle');

            $(".multifile_container").empty();

        });
    })
    </script>
</body>

</html>