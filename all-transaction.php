<?php
session_start();
if (isset($_SESSION['name'])) {
} else {
    header('location:login.php');
}
include('class/database.php');
class search extends database
{
    public function searchFunction()
    {
        $name = $_GET['name'];
        $sql = "SELECT * FROM `transaction_tbl` JOIN booking_tbl ON transaction_tbl.booking_id = booking_tbl.booking_id where property_name = '$name' order by transaction_tbl.t_date DESC";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
}
$obj = new search;
$objData = $obj->searchFunction();

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
        background-color: #274472 !important;
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


            <h4 class="font-weight-bold pt-5 text-center">Property History</h4>
            <div class="table-responsive">

                <table id="example" class="table table-striped table-bordered" style="width:10%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Paid By</th>
                            <th>Received By</th>
                            <th>Remarks</th>
                            <th>Copy of Slip</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($objData) { ?>
                        <?php while ($row = mysqli_fetch_assoc($objData)) { ?>
                        <tr>
                            <td><?php echo $row['t_date']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['amount']; ?></td>
                            <td><?php echo $row['paid_by']; ?></td>
                            <td><?php echo $row['received_by']; ?></td>
                            <td><?php echo $row['remarks']; ?></td>
                            <td><?php echo $row['slip']; ?></td>
                        </tr>
                        <?php } ?>
                        <?php } ?>

                    </tbody>


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
            order: false,
            "pageLength": 50

        });
    });
    $('[data-toggle="datepicker"]').datepicker({
        autoClose: true,
        viewStart: 2,
        format: 'dd/mm/yyyy',

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