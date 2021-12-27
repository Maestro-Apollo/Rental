<?php
session_start();
if (isset($_SESSION['admin'])) {
} else {
    header('location:login.php');
}
include('class/database.php');
class search extends database
{
    public function searchFunction()
    {
        $id = $_GET['id'];
        $sql = "SELECT * from booking_tbl where booking_id = $id ";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function allTransaction()
    {
        $id = $_GET['id'];
        $sql = "SELECT * from transaction_tbl INNER JOIN booking_tbl ON transaction_tbl.booking_id = booking_tbl.booking_id where booking_tbl.booking_id = $id order by transaction_tbl.t_date DESC";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function insertFunction()
    {
        if (isset($_POST['submit'])) {
            $id = $_GET['id'];
            $status = $_POST['status'];
            $admin_comment = addslashes(trim($_POST['admin_comment']));
            $x = 0;
            for ($i = 0; $i < count($_POST['description']); $i++) {
                $description = addslashes(trim($_POST['description'][$i]));
                $amount = $_POST['amount'][$i];

                $t_date = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['t_date'][$i])));

                $pay_by = addslashes(trim($_POST['pay_by'][$i]));
                $received_by = addslashes(trim($_POST['received_by'][$i]));
                $remark = addslashes(trim($_POST['remark'][$i]));
                $slip = $_POST['slip'][$i];

                if ($description == '' && $amount == '' && $pay_by == '' && $received_by == '' && $remark == '') {
                    break;
                }

                $sql = "INSERT INTO `transaction_tbl` (`transaction_id`, `t_date`, `description`, `amount`, `paid_by`, `received_by`, `remarks`, `slip`, `booking_id`, `created_at`) VALUES (NULL, '$t_date', '$description', '$amount', '$pay_by', '$received_by', '$remark', '$slip', '$id', CURRENT_TIMESTAMP)";
                $res = mysqli_query($this->link, $sql);
                if ($res) {
                    $x += 1;
                }
            }
            $sqlUpdate = "UPDATE booking_tbl SET admin_comment = '$admin_comment' , status = '$status' where booking_id = $id ";
            mysqli_query($this->link, $sqlUpdate);

            header('location:admin-transaction.php?id=' . $_GET['id']);
        }
        # code...
    }


    public function boxFunction()
    {
        $id = $_GET['id'];
        $arr = array();
        $sql = "SELECT * from transaction_tbl INNER JOIN booking_tbl ON transaction_tbl.booking_id = booking_tbl.booking_id where booking_tbl.booking_id = $id order by transaction_tbl.t_date DESC";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $paid_by = $row['paid_by'];
                $received_by = $row['received_by'];
                $amount = $row['amount'];

                // if (preg_match('~\\bben tse\\b~i', $paid_by, $m) || preg_match('~\\bben tse\\b~i', $received_by, $m)) {
                //     echo 'Okkk';
                // }
                // if ((strpos($paid_by, 'ben tse') !== true)) {
                //     echo 'Ok';
                // }
                if (preg_match('~\\bben\\b~i', $paid_by, $m) || preg_match('~\\bben\\b~i', $received_by, $m) || preg_match('~\\bbs\\b~i', $paid_by, $m) || preg_match('~\\bbs\\b~i', $received_by, $m)) {

                    if (preg_match('~\\bben tse\\b~i', $paid_by, $m)) {
                    } else if (preg_match('~\\bben\\b~i', $paid_by, $m) || preg_match('~\\bbs\\b~i', $paid_by, $m)) {
                        array_push($arr, -$amount);
                    } else {
                    }

                    if (preg_match('~\\bben tse\\b~i', $received_by, $m)) {
                    } else if (preg_match('~\\bben\\b~i', $received_by, $m) || preg_match('~\\bbs\\b~i', $received_by, $m)) {
                        array_push($arr, $amount);
                    } else {
                    }
                }
            }
            return $arr;
        }

        # code...
    }
}
$obj = new search;
$objData = $obj->searchFunction();
$objAll = $obj->allTransaction();
$row2 = mysqli_fetch_assoc($objData);
$objInsert = $obj->insertFunction();

$objBox = $obj->boxFunction();
// print_r($objBox);


$color = '';
$color1 = '';
$color2 = '';
$color3 = '';
$arr = array();
$i = 0;
if (is_object($objAll)) {
    while ($find = mysqli_fetch_assoc($objAll)) {
        $i++;
        $s = strtolower($find['description']);
        if (preg_match('~\\bcl\\b~i', $s, $m)) {
            $color = 'bg-success';
            array_push($arr, $i);
        }
        if (preg_match('~\\bct\\b~i', $s, $m)) {
            $color1 = 'bg-success';
            array_push($arr, $i);
        }
        if (preg_match('~\\bacl\\b~i', $s, $m)) {
            $color2 = 'bg-success';
            array_push($arr, $i);
        }
        if (preg_match('~\\bact\\b~i', $s, $m)) {
            $color3 = 'bg-success';
            array_push($arr, $i);
        }
    }
    mysqli_data_seek($objAll, 0);
}


// echo var_dump($arr);




// function isUsed($sourceStr, $searchPat) {
//     if (preg_match("~\b$searchPat\b~", $sourceStr)) {
//         return true;
//     } else {
//         return false;
//     }
// }

// $s = 'I lost my cat in a catastrophe event';
// $find = 'cat';

// if (preg_match('~\\bat\\b~i', $s, $m)) {
//     print 'Cat found.';
//     print '<hr><pre>' . print_r($m, true) . '</pre>';
// } else {
//     print 'Cat not found.';
// }



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

    .search-form {
        position: relative;
    }

    .panel-inner {
        position: absolute;
        z-index: 1;
        padding: 0 15px;
        left: 0;
        right: 0;
    }

    /* th,
    td {
        font-size: 10px;
    } */
    </style>

    <?php for ($j = 0; $j < count($arr); $j++) {
        echo '<style>
        #userTable tr:nth-child(' . $arr[$j] . ') {
            background-color: #4CAF50;
            color: #fff;
        }
        </style>';
    } ?>



</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <section>
        <div class="container bg-white pr-4 pl-4  log_section pb-5 pt-lg-4 pt-3">

            <div class="row mb-4">
                <div class="col-md-4">
                    <h4 class="font-weight-bold text-center ">Add Transaction</h4>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <button type="button" class="btn log_btn mb-2" data-toggle="modal" data-target="#exampleModal">
                            Transaction checking
                        </button>
                    </div>


                    <!-- Modal -->
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
                                    <?php $tot = 0;
                                    for ($i = 0; $i < count($objBox); $i++) { ?>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><?php echo $objBox[$i]; ?></li>
                                        <?php $tot += $objBox[$i]; ?>
                                    </ul>
                                    <?php } ?>

                                    <h5 class="p-3 font-weight-bold">Total: <?php echo $tot; ?></h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 search-form">
                    <form id="myForm" class="">

                        <input type="text" id="fname" placeholder="Enter property name" class="form-control bg-light">

                        <div id="output" class="panel-inner"></div>



                    </form>
                </div>
            </div>
            <?php if ($objInsert) {
                echo $objInsert;
            } ?>

            <div class="table-responsive">

                <table class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="bg-white">P. Name</th>
                            <th>A. Name</th>
                            <th>Booking Date</th>
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
                        <tr class="text-white <?php if ($row2['status'] == 'Incomplete') {
                                                    echo 'bg-danger';
                                                } else {
                                                    echo 'bg-success';
                                                } ?>">

                            <td><a href="./admin-transaction.php?id=<?php echo $row2['booking_id']; ?>"
                                    class="text-white text-decoration-none"><?php echo $row2['property_name']; ?></a>
                            </td>
                            <td><?php echo $row2['agent_name']; ?></td>
                            <td><?php echo date("d/m/Y", strtotime($row2['date'])) ?></td>
                            <td><?php echo $row2['agent_com']; ?></td>
                            <td><?php echo $row2['rent']; ?></td>
                            <td class="<?php echo $color; ?>"><?php echo $row2['com_landlord']; ?></td>
                            <td class="<?php echo $color1; ?>"><?php echo $row2['com_tenant']; ?></td>

                            <td class="<?php echo $color2; ?>"><?php echo $row2['agent_com_landloard']; ?></td>
                            <td class="<?php echo $color3; ?>"><?php echo $row2['agent_com_tenant']; ?></td>
                            <td><?php echo $row2['company_com']; ?></td>
                            <td><?php echo $row2['tcc']; ?></td>

                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="container">
                <hr>
            </div>
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

            <div class="table-responsive">

                <table id="userTable" class="table table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th style="background-color: #fff ; color: #000; ">Transaction Date</th>
                            <th style="background-color: #fff ; color: #000;">Description</th>
                            <th style="background-color: #fff ; color: #000;">Amount</th>
                            <th style="background-color: #fff ; color: #000;">Paid By</th>
                            <th style="background-color: #fff ; color: #000;">Received By</th>
                            <th style="background-color: #fff ; color: #000;">Method</th>
                            <th style="background-color: #fff ; color: #000;">Copy of Slip</th>
                            <th style="background-color: #fff ; color: #000;">Action</th>

                        </tr>
                    </thead>

                </table>
            </div>

            <!-- <h4 class="font-weight-bold pt-5 text-center">Booking History</h4> -->
            <form method="post" class="form-group">
                <div class="row">
                    <div class="col-md-4 mt-2 mb-2">
                        <label for="" class="font-weight-bold">Staff Comment</label>
                        <textarea name="" class="form-control" id="" cols="30" rows="3"
                            readonly><?php echo $row2['staff_comment']; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2 mb-2">
                        <label for="" class="font-weight-bold">Admin Comment</label>

                        <textarea name="admin_comment" class="form-control" id="" cols="30"
                            rows="3"><?php echo $row2['admin_comment']; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2 mb-2">
                        <label for="" class="font-weight-bold">Status</label>

                        <select name="status" class="form-control" id="">
                            <option value="Complete" <?php echo ($row2['status'] === 'Complete') ? 'selected' : ''; ?>>
                                Complete</option>
                            <option value="Incomplete"
                                <?php echo ($row2['status'] === 'Incomplete') ? 'selected' : ''; ?>>
                                Incomplete</option>
                        </select>
                    </div>
                </div>
                <!-- <div class="row mb-4">
                    <div class="col-md-6 offset-lg-3">
                        <input type="text" class="form-control mb-3" name="agent_name"
                            value="<?php echo $row['agent_name']; ?>" readonly>
                        <input type="text" class="form-control mb-3" name="property_name"
                            value="<?php echo $row['property_name']; ?>" readonly>
                        <input type="text" class="form-control mb-3" name="date" value="<?php echo $row['date']; ?>"
                            readonly>
                    </div>
                </div> -->
                <!-- <textarea name="free_text" class="form-control mb-4" id="" cols="30" rows="3"
                    placeholder="Notice Box"></textarea> -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Description</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Pay - By</th>
                                <th scope="col">Received By</th>
                                <th scope="col">Method</th>
                                <th scope="col">Slip of copy</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <tr>
                                <td scope="row"><input type="text" class="form-control" name="t_date[]"
                                        data-toggle="datepicker" autocomplete="off"></td>
                                <td><input type="text" class="form-control" name="description[]" autocomplete="off">
                                </td>
                                <td><input type="text" class="form-control" name="amount[]" autocomplete="off"></td>
                                <td><input type="text" class="form-control" name="pay_by[]" autocomplete="off"></td>
                                <td><input type="text" class="form-control" name="received_by[]" autocomplete="off">
                                </td>
                                <td><input type="text" class="form-control" name="remark[]" autocomplete="off"></td>
                                <td><select name="slip[]" class="form-control" id="">
                                        <option value="Yes" selected>Yes</option>
                                        <option value="No">No</option>
                                    </select></td>
                                <td>
                                    <button type="button" class="btn btn-success" id="add"><i
                                            class="fas fa-plus"></i></button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <input name="submit" value="Confirm" type="submit" class="btn font-weight-bold log_btn mt-4">
            </form>





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
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]

        });
    });
    $('[data-toggle="datepicker"]').datepicker({
        autoClose: true,
        autoHide: true,
        viewStart: 2,
        format: 'dd/mm/yyyy',

    });
    </script>
    <script>
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            i++;
            $('#tbody').prepend(
                '<tr id="row' + i +
                '"><td scope="row"><input type="text" class="form-control" name="t_date[]"data-toggle="datepicker' +
                i +
                '" autocomplete="off"></td><td><input type="text" class="form-control" name="description[]" autocomplete="off"></td><td><input type="text" class="form-control" name="amount[]" autocomplete="off"></td><td><input type="text" class="form-control" name="pay_by[]" autocomplete="off"></td><td><input type="text" class="form-control" name="received_by[]" autocomplete="off"></td><td><input type="text" class="form-control" name="remark[]" autocomplete="off"></td><td><select name="slip[]" class="form-control" id=""><option value="Yes" selected>Yes</option><option value="No">No</option></select></td><td><button type="button" name="remove" id="' +
                i +
                '" class="btn btn-danger btn_remove"><i class="fas fa-trash-alt"></i></button></td></tr>'
            );
            $('[data-toggle="datepicker' + i + '"]').datepicker({
                autoClose: true,
                autoHide: true,
                viewStart: 2,
                format: 'dd/mm/yyyy',

            });
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

    });
    </script>

    <script>
    var userDataTable = $('#userTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'columnDefs': [{
            orderable: false,
            targets: 0
        }],
        "pageLength": 10,
        'ajax': {
            'url': 'ajaxfile4.php',
            "data": {
                'booking_id': '<?php echo $_GET['id']; ?>'
            }

        },
        'columns': [{
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
            url: 'ajaxfile4.php',
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
                url: 'ajaxfile4.php',
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
                        location.reload();
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
                url: 'ajaxfile4.php',
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
                        location.reload();

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
        $('#fname').keyup(function() {
            let fname = $(this).val();
            if (fname != '') {
                $.ajax({
                    type: "POST",
                    url: "ajax-property.php",
                    data: {
                        fname: fname
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#output').fadeIn();
                        $('#output').html(data);
                    }
                });
            } else {
                $('#output').fadeOut();
                $('#output').html("");
            }

        });
        $('#output').parent().on('click', 'li', function() {
            $('#fname').val($(this).text());
            $('#output').fadeOut();
        });

    });
    </script>

</body>

</html>