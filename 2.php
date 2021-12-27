<?php
session_start();
// error_reporting(0);
if (isset($_SESSION['admin'])) {
} else {
    header('location:login.php');
}
include('class/database.php');
class search extends database
{
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
    public function searchFunction()
    {


        if (isset($_POST['signup'])) {
            $fromDate = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fromDate'])));
            $toDate = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['toDate'])));
            $status = $_POST['status'];
            $agent_name = addslashes(trim($_POST['agent_name']));

            if ($agent_name == '') {
                if ($status == 'All') {
                    $sql = "SELECT * from booking_tbl where `date`>= '$fromDate' AND `date` <= '$toDate' order by `date` DESC";
                } else {
                    $sql = "SELECT * from booking_tbl where `date`>= '$fromDate' AND `date` <= '$toDate'  AND `status` = '$status' order by `date` DESC";
                }
            } else {
                if ($status == 'All') {
                    $sql = "SELECT * from booking_tbl where `date`>= '$fromDate' AND `date` <= '$toDate' AND `agent_name` = '$agent_name' order by `date` DESC";
                } else {
                    $sql = "SELECT * from booking_tbl where `date`>= '$fromDate' AND `date` <= '$toDate'  AND `status` = '$status' AND `agent_name` = '$agent_name' order by `date` DESC";
                }
            }
        } else {
            $sql = "SELECT * from booking_tbl order by `date` DESC";
        }

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

// echo var_dump($obj->allTransaction(21)['color1']);
// if (isset($obj->allTransaction(21)['color'])) {
//     echo $obj->allTransaction(21)['color'];
// }
// echo var_dump($obj->allTransaction(21));

// $arr = array();
// $i = 0;
// if (is_object($objAll)) {
//     while ($find = mysqli_fetch_assoc($objAll)) {
//         $i++;
//         $s = strtolower($find['description']);
//         if (preg_match('~\\bcl\\b~i', $s, $m)) {
//             $color = 'bg-success';
//             array_push($arr, $i);
//         }
//         if (preg_match('~\\bct\\b~i', $s, $m)) {
//             $color1 = 'bg-success';
//             array_push($arr, $i);
//         }
//         if (preg_match('~\\bacl\\b~i', $s, $m)) {
//             $color2 = 'bg-success';
//             array_push($arr, $i);
//         }
//         if (preg_match('~\\bact\\b~i', $s, $m)) {
//             $color3 = 'bg-success';
//             array_push($arr, $i);
//         }
//     }
//     mysqli_data_seek($objAll, 0);
// }
// echo var_dump($arr);
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
        background-color: #116530 !important;
    }



    @media (max-width: 575.98px) {

        th,
        td {
            font-size: 10px;
        }

        table {
            width: 10%;
        }
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
                    <div class="col-md-3">
                        <input type="text" name="fromDate" data-toggle="datepicker" class="form-control mt-4  bg-light"
                            placeholder="From Date" autocomplete="off" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" data-toggle="datepicker" name="toDate" class="form-control mt-4  bg-light"
                            placeholder="To Date" autocomplete="off" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="agent_name" class="form-control mt-4  bg-light"
                            placeholder="Agent Name" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control mt-4  bg-light" id="">
                            <option value="" disabled>Choose an option</option>
                            <option value="All" selected>All</option>
                            <option value="Complete">Complete</option>
                            <option value="Incomplete">Incomplete</option>
                        </select>
                    </div>
                </div>
                <button name="signup" type="submit" class="btn font-weight-bold log_btn mt-4">Calculate</button>
                <a href="./admin-booking-history.php" class="btn font-weight-bold log_btn mt-4">Reload</a>
            </form>



            <div class="table-responsive">

                <table id="example" class="table table-striped table-bordered">
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($objData) {
                            $tot = 0;
                            $tot2 = 0; ?>
                        <?php while ($row = mysqli_fetch_assoc($objData)) { ?>
                        <tr class="text-white <?php if ($row['status'] == 'Incomplete') {
                                                            echo 'bg-danger';
                                                        } else {
                                                            echo 'bg-success';
                                                        } ?>">

                            <td><a href="./admin-transaction.php?id=<?php echo $row['booking_id']; ?>"
                                    class="text-white text-decoration-none"><?php echo $row['property_name']; ?><?php if ($row['shared_with'] == $row['agent_name']) {
                                                                                                                                                                                                echo ' (M)';
                                                                                                                                                                                            } else if ($row['shared_with']) {
                                                                                                                                                                                                echo ' (S)';
                                                                                                                                                                                            } else {
                                                                                                                                                                                                echo '';
                                                                                                                                                                                            } ?></a>
                            </td>
                            <td>


                                <?php echo $row['agent_name']; ?> </td>
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
                            <?php $tot2 += $row['tcc']; ?>
                            <td class="<?php if (isset($obj->allTransaction($row['booking_id'])['color2'])) {
                                                    echo $obj->allTransaction($row['booking_id'])['color2'];
                                                } ?>"><?php echo $row['agent_com_landloard']; ?></td>
                            <td class="<?php if (isset($obj->allTransaction($row['booking_id'])['color3'])) {
                                                    echo $obj->allTransaction($row['booking_id'])['color3'];
                                                } ?>"><?php echo $row['agent_com_tenant']; ?></td>
                            <td><?php echo $row['company_com']; ?></td>
                            <td><?php echo $row['tcc']; ?></td>

                        </tr>
                        <?php } ?>
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
                            <th></th>
                            <th><?php echo $tot; ?></th>
                            <th><?php echo $tot2; ?></th>
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
            "ordering": false,
            buttons: [{
                    extend: 'copy',
                    footer: true
                },
                {
                    extend: 'excel',
                    footer: true
                },

                {
                    extend: 'print',
                    footer: true
                }
            ],
            "pageLength": 50

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