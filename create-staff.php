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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>
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

    .table {
        display: table;
        width: 100%;
    }

    .table-row {
        display: table-row;
        width: 100%;
    }

    .table-cell {
        display: table-cell;
    }

    @media screen and (max-width: 479px) {

        .table,
        .table-row {
            display: block;
        }

        .table-cell {
            display: inline-block;
        }
    }

    th {
        white-space: nowrap;
    }
    </style>

</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <section>
        <div class="container bg-white pr-4 pl-4  log_section pb-5">

            <div class="row">
                <div class="col-md-6 offset-lg-3 ">
                    <form id="myForm" data-parsley-validate>

                        <div class="text-center">
                            <h4 class="font-weight-bold pt-5 pb-4">CREATE STAFF</h4>
                            <div id="output2"></div>

                            <input type="text" name="agent_name" class="form-control p-4  border-0 bg-light"
                                placeholder="Enter  username name" autocomplete="off" required>
                            <input type="password" class="form-control mt-4 p-4 border-0 bg-light" name="passwordLogIn"
                                placeholder="Enter  password" required>


                            <button type="submit"
                                class="btn btn-block font-weight-bold log_btn btn-lg mt-4">CREATE</button>



                    </form>
                </div>

                <!-- <form action="" method="post"> -->

                <!-- </form> -->
            </div>

        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>
    <script>
    $(document).ready(function() {

        $('#myForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "staffAjax.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    $('#output2').fadeIn().html(response);

                }
            });
            this.reset();
        });
    })
    </script>
</body>

</html>