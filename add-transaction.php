<?php
session_start();
if (isset($_SESSION['admin'])) {
} else {
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.0.0/css/fixedColumns.dataTables.min.css"> -->
    <link rel="stylesheet" href="css/datepicker.css">

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
        background-color: #274472 !important;
    }

    @media (max-width: 575.98px) {
        td {
            width: auto;
        }
    }

    @media only screen and (max-width: 568px) {
        #table thead {
            display: none;
        }

        #table tbody td {
            border: none !important;
            display: block;
        }

        #table tbody td:before {
            content: attr(data-th) ": ";
            display: inline-block;
            font-weight: bold;
            width: 6.5em;
        }

        #table tbody td.bt-hide {
            display: none;
        }
    }
    </style>

</head>

<body class="bg-light">
    <?php include('layout/navbar2.php'); ?>

    <section>
        <div class="container bg-white  log_section pb-5 pt-lg-4">
            <h4 class="font-weight-bold pt-5 text-center">Add Transaction Entry</h4>

            <input type="text" name="name" class="form-control mt-4 p-4  bg-light" placeholder="Agent" required>
            <input type="text" name="name" class="form-control mt-4 p-4  bg-light" placeholder="Property Name" required>
            <input type="text" class="form-control mt-4 p-4  bg-light" data-toggle="datepicker" name="dob"
                placeholder="Date" required>
            <textarea name="" class="form-control mt-4 p-4  bg-light" id="" cols="30" rows="10"
                placeholder="Description"></textarea>
            <input type="number" name="company" class="form-control mt-4 p-4  bg-light" placeholder="Amount" required>
            <input type="text" name="age" class="form-control mt-4 p-4  bg-light" placeholder="Pay By" required>
            <input type="text" name="phone" class="form-control mt-4 p-4  bg-light" placeholder="Receive By" required>
            <input type="text" class="form-control mt-4 p-4  bg-light" placeholder="Remake" required>
            <select name="" class="form-control mt-4" id="">
                <option value="" selected disabled>Copy of Slip</option>
                <option value="">Yes</option>
                <option value="">No</option>
            </select>
            <!-- <div class="custom-file mt-4">
                            <input type="file" name="image" class="custom-file-input" accept="image/*" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose image</label>
                        </div> -->
            <button name="signup" type="submit"
                class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SUBMIT</button>

        </div>
    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>
    <script src="js/datepicker.js"></script>

    <script src="js/tableToCards.js"></script>
    <script>
    // var table = $('#example').DataTable();
    // let tot = table.column(4).data().sum();
    // console.log(tot);

    $('[data-toggle="datepicker"]').datepicker({
        autoClose: true,
        autoHide: true,

        viewStart: 2,
        format: 'dd/mm/yyyy',

    });


    // $('#example').DataTable({
    //     drawCallback: function() {
    //         var api = this.api();
    //         $(api.table().footer()).html(
    //             api.column(4, {
    //                 page: 'current'
    //             }).data().sum()
    //         );
    //     }
    // });
    </script>
    <script>

    </script>
</body>

</html>