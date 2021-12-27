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
                $arr['thick1'] = '';
                $arr['thick2'] = false;
                $tot3 = 0;

                $s = strtolower($find['description']);

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
                if (isset($arr['color']) != '' and isset($arr['color2']) == '') {
                    $tot3 += $find['agent_com_landloard'];
                    $arr['thick1'] = "thick";
                }
                if (preg_match('~\\bact\\b~i', $s, $m)) {
                    $color3 = 'bg-success';
                    $arr['color3'] = $color3;
                }
                if (isset($arr['color1']) != '' and isset($arr['color3']) == '') {
                    $tot3 += $find['agent_com_tenant'];
                    $arr['thick2'] = "thick";
                }

                $arr['tot3'] = $tot3;
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
            } else if ($agent_name != '' and $toDate == '1970-01-01' and $fromDate == '1970-01-01') {
                if ($status == 'All') {
                    $sql = "SELECT * from booking_tbl where agent_name = '$agent_name' order by `date` DESC";
                } else {
                    $sql = "SELECT * from booking_tbl where agent_name = '$agent_name'  AND `status` = '$status' order by `date` DESC";
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

// echo var_dump($obj->allTransaction(21));
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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
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

    /* .thick {
        font-weight: 600
    } */
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
                            placeholder="From Date" autocomplete="off">
                        <div class="form-group form-check mt-2">
                            <input type="checkbox" class="form-check-input" name="tcr" value="1" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">For TCR</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" data-toggle="datepicker" name="toDate" class="form-control mt-4  bg-light"
                            placeholder="To Date" autocomplete="off">
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

            <div class="text-center">
                <button type="button" class="btn btn-lg log_btn mb-2" data-toggle="modal" data-target="#exampleModal">
                    <i class="fas fa-calculator"></i>
                </button>
            </div>

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
                            <th>Files</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $tot = 0;
                        $tot2 = 0;
                        $comTot = 0;
                        $totCl = 0;
                        $totCt = 0;
                        $rTotCl = 0;
                        $rTotCt = 0;
                        $rTotACL = 0;
                        $rTotACT = 0;

                        $totACL = 0;
                        $totACT = 0;
                        if ($objData) {


                        ?>
                        <?php while ($row = mysqli_fetch_assoc($objData)) { ?>
                        <?php
                                if (isset($_POST['tcr'])) {
                                    $equ = !empty(($obj->allTransaction($row['booking_id'])['tot3']));
                                } else {
                                    $equ = true;
                                }
                                if ($equ) { ?>

                        <tr class="text-white <?php if ($row['status'] == 'Incomplete') {

                                                                echo 'bg-danger';
                                                            } else {
                                                                $totCl += $row['com_landlord'];
                                                                $totCt += $row['com_tenant'];
                                                                $totACL += $row['agent_com_landloard'];
                                                                $totACT += $row['agent_com_tenant'];
                                                                echo 'bg-success';
                                                            } ?>">

                            <td><a href="./admin-transaction.php?id=<?php echo $row['booking_id']; ?>"
                                    class="text-white text-decoration-none"><?php echo $row['property_name']; ?><?php if ($row['shared_with'] == $row['agent_name']) {
                                                                                                                                                                                                    echo ' (S)';
                                                                                                                                                                                                } else if ($row['shared_with']) {
                                                                                                                                                                                                    echo ' (M)';
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
                                                        if ($row['status'] == 'Incomplete') {
                                                            $totCl += $row['com_landlord'];
                                                        }

                                                        echo $obj->allTransaction($row['booking_id'])['color'];
                                                    } ?>"><?php echo $row['com_landlord']; ?></td>
                            <td class="<?php if (isset($obj->allTransaction($row['booking_id'])['color1'])) {
                                                        if ($row['status'] == 'Incomplete') {
                                                            $totCt += $row['com_tenant'];
                                                        }

                                                        echo $obj->allTransaction($row['booking_id'])['color1'];
                                                    } ?>"><?php echo $row['com_tenant']; ?></td>

                            <?php $tot += $row['company_com']; ?>
                            <?php $tot2 += $row['tcc'];
                                        $rTotCl += $row['com_landlord'];
                                        $rTotCt += $row['com_tenant'];
                                        $rTotACL += $row['agent_com_landloard'];
                                        $rTotACT += $row['agent_com_tenant'];
                                        ?>
                            <?php if (isset($obj->allTransaction($row['booking_id'])['tot3'])) {
                                            $comTot += $obj->allTransaction($row['booking_id'])['tot3'];
                                        } ?>


                            <td class="<?php if (isset($obj->allTransaction($row['booking_id'])['color2'])) {
                                                        if ($row['status'] == 'Incomplete') {
                                                            $totACL += $row['agent_com_landloard'];
                                                        }

                                                        echo $obj->allTransaction($row['booking_id'])['color2'];
                                                    }
                                                    if (isset($obj->allTransaction($row['booking_id'])['thick1'])) {
                                                        echo $obj->allTransaction($row['booking_id'])['thick1'];
                                                    } ?>"><?php echo $row['agent_com_landloard']; ?></td>
                            <td class="<?php if (isset($obj->allTransaction($row['booking_id'])['color3'])) {
                                                        if ($row['status'] == 'Incomplete') {
                                                            $totACT += $row['agent_com_tenant'];
                                                        }

                                                        echo $obj->allTransaction($row['booking_id'])['color3'];
                                                    }
                                                    if (isset($obj->allTransaction($row['booking_id'])['thick2'])) {
                                                        echo $obj->allTransaction($row['booking_id'])['thick2'];
                                                    } ?> ">
                                <?php echo $row['agent_com_tenant']; ?></td>
                            <td><?php echo $row['company_com']; ?></td>
                            <td><?php echo $row['tcc']; ?></td>
                            <td><a href="./admin-booking-files.php?id=<?php echo $row['booking_id']; ?>"><i
                                        class="fas fa-folder-open fa-2x text-white"></i></a></td>

                        </tr>
                        <?php } ?>
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
                            <th>T.C.R =</th>
                            <th><?php echo $comTot; ?></th>
                            <th><?php echo $tot; ?></th>
                            <th><?php echo $tot2; ?></th>
                            <th></th>
                        </tr>
                    </tfoot>


                </table>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Transaction checking</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">


                            <h5 class="p-3 font-weight-bold">Total Receivable CL & CT:
                                <?php echo ($rTotCl - $totCl) + ($rTotCt - $totCt); ?></h5>

                            <h5 class="p-3 font-weight-bold">Total Payable:
                                <?php echo ($rTotACL - $totACL) + ($rTotACT - $totACT); ?></h5>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        </div>
                    </div>
                </div>
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
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>
    $(document).ready(function() {
        var output_table = $('#example').DataTable({
            responsive: false,
            dom: 'Bfrtip',
            "ordering": false,
            buttons: [{
                    extend: 'copy',
                    footer: true
                },
                {
                    extend: 'excelHtml5',
                    footer: true,


                    customize: function(xlsx) {

                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        console.log(sheet);
                        var row = 0;
                        var num_columns = 11;

                        $('row', sheet).each(function(x) {
                            if (x > 2) {

                                console.log("");
                                console.log("---- row x: " + x);

                                for (var i = 0; i < num_columns; i++) {

                                    console.log("---- column i: " + i);

                                    console.log(output_table.row(':eq(' + row + ')')
                                        .data());

                                    if ($(output_table.cell(':eq(' + row + ')', i)
                                            .node()).hasClass('thick')) {
                                        console.log('YES - sig-w - row ' + row +
                                            ', column ' + i);
                                        $('row:nth-child(' + (x) + ') c', sheet).eq(i)
                                            .attr('s', '20');

                                    }

                                }

                                row++;
                            }

                        });

                    }
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

    // document.getElementById("example").deleteRow(4);
    </script>

</body>

</html>