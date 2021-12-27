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
        $name = $_SESSION['name'];

        if (isset($_POST['signup'])) {
            $fromDate = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fromDate'])));
            $toDate = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['toDate'])));
            $status = $_POST['status'];

            if ($status == 'All') {
                $sql = "SELECT * from booking_tbl where `date`>= '$fromDate' AND `date` <= '$toDate' AND agent_name = '$name' order by `date` DESC";
            } else {
                $sql = "SELECT * from booking_tbl where `date`>= '$fromDate' AND `date` <= '$toDate' AND agent_name = '$name' AND `status` = '$status' order by `date` DESC";
            }
        } else {
            $sql = "SELECT * from booking_tbl where agent_name = '$name' order by `date` DESC";
        }

        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }

        # code...
    }
    public function allTransaction($booking_id)
    {

        $id = $booking_id;
        $sql = "SELECT * from transaction_tbl INNER JOIN booking_tbl ON transaction_tbl.booking_id = booking_tbl.booking_id where booking_tbl.booking_id = $id order by transaction_tbl.t_date DESC";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            $color = '';
            $color1 = '';
            $color2 = '';
            $color3 = '';
            $i = 0;
            $arr = array();
            while ($find = mysqli_fetch_assoc($res)) {
                $i++;
                $s = strtolower($find['description']);
                // $arr['color'] = preg_match('~\\bcl\\b~i', $s, $m) ?  'bg-success' : '';
                // // if () {
                // //     $color = ;
                // //      = $color;
                // // }
                if (preg_match('~\\bcl\\b~i', $s, $m)) {
                    $color = 'bg-success';
                    $arr['color'] = $color;
                }
                if (preg_match('~\\bct\\b~i', $s, $m)) {
                    $color1 = 'bg-success';
                    $arr['color1'] = $color1;
                }
                if (preg_match('~\\bacl\\b~i', $s, $m)) {
                    $color2 = 'bg-success';
                    $arr['color2'] = $color2;
                }
                if (preg_match('~\\bact\\b~i', $s, $m)) {
                    $color3 = 'bg-success';
                    $arr['color3'] = $color3;
                }
            }
            return $arr;
        } else {
            return false;
        }
        # code...
    }
}
$obj = new search;
$objData = $obj->searchFunction();

// $originalDate = "2010-03-21";
// echo date("d/m/Y", strtotime($originalDate));
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
        background-color: #274472 !important;
    }

    th,
    td {
        font-size: 10px;
    }

    .t-row {
        -webkit-print-color-adjust: exact;
    }
    </style>

</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <section>
        <div class="container bg-white pr-4 pl-4  log_section pb-5 pt-lg-4">

            <h4 class="font-weight-bold text-center">Booking Search</h4>
            <!-- <h4 class="font-weight-bold pt-5 text-center">Booking History</h4> -->
            <form action="" method="post" class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="fromDate" data-toggle="datepicker" class="form-control mt-4  bg-light"
                            placeholder="From Date" autocomplete="off" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" data-toggle="datepicker" name="toDate" class="form-control mt-4  bg-light"
                            placeholder="To Date" autocomplete="off" required>
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-control mt-4  bg-light" id="">

                            <option value="All" selected>All</option>
                            <option value="Complete">Complete</option>
                            <option value="Incomplete">Incomplete</option>
                        </select>
                    </div>
                </div>
                <button name="signup" type="submit" class="btn font-weight-bold log_btn mt-4">Calculate</button>
                <a href="booking-search.php" class="btn font-weight-bold log_btn mt-4">Reload</a>
            </form>



            <div class="table-responsive">

                <table id="example" class="table table-striped table-bordered" style="width: 10%;">
                    <thead>
                        <tr class="t-row">
                            <th>P. Name</th>
                            <th>Date</th>
                            <th>%</th>
                            <th>Rent/Month</th>
                            <th>C.L</th>
                            <th>C.T</th>
                            <th>A.C.L</th>
                            <th>A.C.T</th>
                            <th>T.A.C</th>
                            <th class="not-export-column">Files</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($objData) {
                            $tot = 0; ?>
                        <?php while ($row = mysqli_fetch_assoc($objData)) { ?>
                        <tr class="text-white <?php if ($row['status'] == 'Incomplete') {
                                                            echo 'bg-danger';
                                                        } else {
                                                            echo 'bg-success';
                                                        } ?>">
                            <td><a class="text-white"
                                    href="./booking-shared.php?id=<?php echo $row['booking_id']; ?>"><?php echo $row['property_name']; ?>
                                    <?php if ($row['shared_with']) { ?>
                                    <i class="fas fa-share"></i>
                                    <?php } ?></a>
                            </td>
                            <td><?php echo date("d/m/Y", strtotime($row['date'])) ?></td>
                            <td><?php echo $row['agent_com']; ?></td>
                            <td><?php echo $row['rent']; ?></td>
                            <td class="<?php if (isset($obj->allTransaction($row['booking_id'])['color'])) {
                                                    echo $obj->allTransaction($row['booking_id'])['color'];
                                                } ?>"><?php echo $row['com_landlord']; ?></td>
                            <td class="<?php if (isset($obj->allTransaction($row['booking_id'])['color1'])) {
                                                    echo $obj->allTransaction($row['booking_id'])['color1'];
                                                } ?>"><?php echo $row['com_tenant']; ?></td>
                            <?php $tot += $row['company_com']; ?>
                            <td class="<?php if (isset($obj->allTransaction($row['booking_id'])['color2'])) {
                                                    echo $obj->allTransaction($row['booking_id'])['color2'];
                                                } ?>"><?php echo $row['agent_com_landloard']; ?></td>
                            <td class="<?php if (isset($obj->allTransaction($row['booking_id'])['color3'])) {
                                                    echo $obj->allTransaction($row['booking_id'])['color3'];
                                                } ?>"><?php echo $row['agent_com_tenant']; ?></td>
                            <td><?php echo $row['company_com']; ?></td>
                            <td><a href="./booking-files.php?id=<?php echo $row['booking_id']; ?>"><i
                                        class="fas fa-folder-open fa-2x text-white"></i></a></td>
                        </tr>
                        <?php } ?>
                        <!-- <tr>
                            <th colspan="9"><?php echo $tot; ?></th>
                        </tr> -->
                        <?php } ?>


                    </tbody>
                    <tfoot>
                        <tr class="bg-dark text-white">
                            <th>Total</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><?php echo $tot; ?></th>
                            <th class="not-export-column"></th>
                        </tr>
                    </tfoot>

                </table>
            </div>
            <h5 class="text-center mt-3 font-weight-bold">Total <?php if (isset($_POST['status'])) {
                                                                    echo $_POST['status'];
                                                                } ?> = $<?php if (isset($tot)) {
                                                                            echo $tot;
                                                                        } else {
                                                                            echo 0;
                                                                        }  ?> </h5>
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
            "order": false,
            'buttons': [{
                extend: 'copy',
                title: "Download",
                footer: true,
                exportOptions: {
                    columns: ":not(.not-export-column)"
                }
            }, {
                extend: 'print',
                title: "Download",
                footer: true,

                exportOptions: {
                    columns: ":not(.not-export-column)"
                }
            }, {
                extend: 'excel',
                title: "Download",
                footer: true,

                exportOptions: {
                    columns: ":not(.not-export-column)"
                }
            }],

        });
    });
    $('[data-toggle="datepicker"]').datepicker({
        autoClose: true,
        autoHide: true,

        viewStart: 2,
        format: 'dd/mm/yyyy',

    });
    </script>

</body>

</html>