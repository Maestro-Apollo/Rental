<?php
session_start();
if (isset($_SESSION['name'])) {
} else {
    header('location:login.php');
}
include('./class/database.php');
class shared extends database
{
    public function showFunction()
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
    public function updateFunction()
    {


        if (isset($_POST['submit'])) {
            $acl2 = $_POST['acl2'];
            $act2 = $_POST['act2'];
            $tac2 = $_POST['tac2'];
            $tcc2 = $_POST['tcc2'];

            $acl3 = $_POST['acl3'];
            $act3 = $_POST['act3'];
            $tac3 = $_POST['tac3'];
            $tcc3 = $_POST['tcc3'];

            $agent_name = $_POST['agent_name'];
            $property_name = $_POST['property_name'];
            $username = $_SESSION['name'];

            $userPer = $_POST['share_percentage_you'];
            $agentPer = $_POST['share_percentage'];

            $id = $_GET['id'];

            $sqlFind = "SELECT * from booking_tbl where booking_id = $id ";
            $resFind = mysqli_query($this->link, $sqlFind);
            $row2 = mysqli_fetch_assoc($resFind);

            $date = $row2['date'];
            $rent = $row2['rent'];
            $status = $row2['status'];
            $com = $row2['agent_com'];
            $cl = $row2['com_landlord'];
            $ct = $row2['com_tenant'];

            $userCom = $com * ($userPer / 100);
            $agentCom = $com * ($agentPer / 100);
            // $admin_comment = $row2['admin_comment'];
            // $staff_comment = $row2['staff_comment'];

            if ($row2['shared_with'] == '') {
                $sql = "UPDATE booking_tbl SET agent_com_landloard = '$acl2', agent_com_tenant = '$act2', company_com = '$tac2', tcc = '$tcc2', shared_with = '$agent_name', agent_com = '$userCom' WHERE booking_id = $id ";
                $res = mysqli_query($this->link, $sql);

                if ($res) {
                    $sql2 = "INSERT INTO `booking_tbl` (`booking_id`, `agent_name`, `property_name`, `date`, `agent_com`, `rent`, `com_landlord`, `com_tenant`, `agent_com_landloard`, `agent_com_tenant`, `company_com`, `tcc`, `status`, `admin_comment`, `staff_comment`, `created_at`, `shared_with`) VALUES (NULL, '$agent_name', '$property_name', '$date', '$agentCom', '$rent', '$cl', '$ct', '$acl3', '$act3', '$tac3', '$tcc3', '$status', NULL, NULL, CURRENT_TIMESTAMP, '$agent_name')";
                    $res2 = mysqli_query($this->link, $sql2);
                    if ($res2) {

                        header('location:booking-shared.php?id=' . $_GET['id'] . '&status=added');
                    }
                }
            }
            if ($row2['shared_with'] != '') {
                $sql = "UPDATE booking_tbl SET agent_com_landloard = '$acl2', agent_com_tenant = '$act2', company_com = '$tac2', tcc = '$tcc2', shared_with = '$username', agent_com = '$userCom' WHERE booking_id = $id ";
                $res = mysqli_query($this->link, $sql);

                if ($res) {



                    $sqlFind2 = "SELECT * from booking_tbl where agent_name = '$agent_name' AND shared_with = '$username' AND property_name = '$property_name' ";
                    $resFind2 = mysqli_query($this->link, $sqlFind2);
                    if (mysqli_num_rows($resFind2) > 0) {


                        $row3 = mysqli_fetch_assoc($resFind2);
                        $preAcl = $row3['agent_com_landloard'];
                        $preAct = $row3['agent_com_tenant'];
                        $preTac = $row3['company_com'];
                        $preTcc = $row3['tcc'];
                        $preCom = $row3['agent_com'];

                        $Nacl3 = $preAcl + $acl3;
                        $Nact3 = $preAct + $act3;
                        $Ntac3 = $preTac + $tac3;
                        $Ntcc3 = $preTcc + $tcc3;
                        $NuserCom = $preCom + $userCom;


                        $sql2 = "UPDATE booking_tbl SET agent_com_landloard = '$Nacl3', agent_com_tenant = '$Nact3', company_com = '$Ntac3', tcc = '$Ntcc3', agent_com = '$NuserCom' WHERE property_name = '$property_name' AND  agent_name = '$agent_name' AND shared_with = '$agent_name' ";
                        $res2 = mysqli_query($this->link, $sql2);
                        if ($res2) {


                            header('location:booking-shared.php?id=' . $_GET['id'] . '&status=update');
                        }
                    }
                }
            }
        }
        # code...
    }
}
$obj = new shared;
$objShow = $obj->showFunction();
$objUpdate = $obj->updateFunction();
$row = mysqli_fetch_assoc($objShow);
// if ($_SESSION['name'] == $row['shared_with']) {
//     echo '<div class="alert alert-danger alert-dismissible">
//     <button type="button" class="close" data-dismiss="alert">&times;</button>
//     <strong>This booking is shared with you!</strong>
//   </div>';
//     return;
// }
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

    .navbar-brand {
        width: 7%;
    }

    .bg_color {
        background-color: #274472 !important;
    }
    </style>

</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <section>
        <div class="container bg-white pr-4 pl-4  log_section pb-5">

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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td>
                                <?php echo $row['property_name']; ?>
                            </td>
                            <td><?php echo $row['agent_name']; ?></td>
                            <td><?php echo date("d/m/Y", strtotime($row['date'])) ?></td>
                            <td><?php echo $row['agent_com']; ?></td>
                            <td><?php echo $row['rent']; ?></td>
                            <td class="<?php echo $color; ?>"><?php echo $row['com_landlord']; ?></td>
                            <td class="<?php echo $color1; ?>"><?php echo $row['com_tenant']; ?></td>

                            <td class="<?php echo $color2; ?>"><?php echo $row['agent_com_landloard']; ?></td>
                            <td class="<?php echo $color3; ?>"><?php echo $row['agent_com_tenant']; ?></td>
                            <td><?php echo $row['company_com']; ?></td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <form method="post" data-parsley-validate>

                <?php if (isset($_GET['status'])) { ?>
                <?php if ($_GET['status'] == 'added') { ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Added!</strong>
                </div>
                <?php } ?>
                <?php if (strcmp($_GET['status'], 'update') == 0) { ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Updated!</strong>
                </div>
                <?php } ?>
                <?php } ?>
                <div class="row">


                    <!-- <form action="" method="post"> -->
                    <div class="col-md-6">



                        <h4 class="font-weight-bold pt-5">Booking Shared!</h4>
                        <div id="output2"></div>

                        <input type="text" value="<?php echo $row['property_name']; ?>" name="property_name"
                            class="form-control mt-4 p-4  bg-light" placeholder="Property Name" required
                            autocomplete="off" readonly>



                        <label for="" class="mt-4">Agent Name</label>
                        <input type="text" name="agent_name" class="form-control p-4  " autocomplete="off" id="fname"
                            placeholder="Find the Agent"
                            <?php if ($row['shared_with']) {
                                                                                                                                                        echo 'value=' . $row['shared_with'] . ' ' . 'readonly';
                                                                                                                                                    } ?>
                            required>
                        <div id="output"></div>


                        <label for="" class="mt-4">Percentage you want to share this agent</label>

                        <input type="number" name="share_percentage" autocomplete="off" class="form-control p-4  "
                            max="100" min="1"
                            <?php if ($row['shared_with'] == $_SESSION['name']) {
                                                                                                                                            echo 'value=' . $row['agent_com'] . ' ' . 'readonly';
                                                                                                                                        } ?>
                            placeholder="Percentage (%)" required>


                        <label for="" class="mt-4">Percentage you will have</label>

                        <input type="number" name="share_percentage_you" autocomplete="off" class="form-control p-4  "
                            max="100" min="1" placeholder="Percentage (%)" readonly required>





                        <input type="hidden" name="acl1" autocomplete="off" class="form-control p-4  "
                            value="<?php echo $row['agent_com_landloard']; ?>" placeholder="" readonly required>
                        <input type="hidden" name="act1" autocomplete="off" class="form-control  p-4  "
                            value="<?php echo $row['agent_com_tenant']; ?>" readonly placeholder="" required>
                        <input type="hidden" name="tac1" autocomplete="off" class="form-control p-4  "
                            value="<?php echo $row['company_com']; ?>" placeholder="" readonly required>
                        <input type="hidden" name="tcc1" autocomplete="off" class="form-control p-4  "
                            value="<?php echo $row['tcc']; ?>" placeholder="" readonly required>





                        <label for="" class="mt-4">Your ACL</label>
                        <input type="text" name="acl2" autocomplete="off" class="form-control p-4  " placeholder=""
                            readonly required>

                        <label for="" class="mt-4">Your ACT</label>
                        <input type="text" name="act2" autocomplete="off" class="form-control  p-4  " readonly
                            placeholder="" required>


                        <label for="" class="mt-4">Your TAC</label>
                        <input type="text" name="tac2" autocomplete="off" class="form-control p-4  " placeholder=""
                            readonly required>
                        <!-- <label for="" class="mt-4">Your TCC</label> -->
                        <input type="hidden" name="tcc2" autocomplete="off" class="form-control p-4  " placeholder=""
                            readonly required>



                    </div>
                    <div class="col-md-6">
                        <label for="" class="mt-4">New Agent's ACL</label>
                        <input type="text" name="acl3" autocomplete="off" class="form-control p-4  " placeholder=""
                            readonly required>

                        <label for="" class="mt-4">New Agent's ACT</label>
                        <input type="text" name="act3" autocomplete="off" class="form-control  p-4  " placeholder=""
                            readonly required>

                        <label for="" class="mt-4">New Agent's TAC</label>
                        <input type="text" name="tac3" autocomplete="off" class="form-control p-4  " placeholder=""
                            readonly required>

                        <!-- <label for="" class="mt-4">New Agent's TCC</label> -->
                        <input type="hidden" name="tcc3" autocomplete="off" class="form-control p-4  " placeholder=""
                            readonly required>
                    </div>
                    <!-- </form> -->
                </div>
                <div class="text-center">
                    <button name="submit" type="submit" class="btn font-weight-bold log_btn btn-lg mt-4">SUBMIT</button>
                </div>
            </form>
        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>

    <script src="js/datepicker.js"></script>
    <script>
    $('[data-toggle="datepicker"]').datepicker({
        autoClose: true,
        autoHide: true,

        viewStart: 2,
        format: 'dd/mm/yyyy',

    });
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    </script>

    <script>
    let share_percentage = document.querySelector('input[name="share_percentage"]');
    let acl1 = document.querySelector('input[name="acl1"]').value;
    let act1 = document.querySelector('input[name="act1"]').value;
    let tac1 = document.querySelector('input[name="tac1"]').value;
    let tcc1 = document.querySelector('input[name="tcc1"]').value;

    share_percentage.addEventListener('keyup', () => {

        let your_percentage = ((share_percentage.value) === '') ? document.querySelector(
            'input[name="share_percentage_you"]').value = 0 : document.querySelector(
            'input[name="share_percentage_you"]').value = parseFloat(100 - share_percentage.value);

        let agent_acl = ((share_percentage.value) === '') ? document.querySelector(
            'input[name="acl3"]').value = 0 : document.querySelector(
            'input[name="acl3"]').value = parseFloat(((
            parseFloat(
                acl1) * parseFloat(share_percentage.value)) / 100));
        let your_acl = ((share_percentage.value) === '') ? document.querySelector(
            'input[name="acl2"]').value = 0 : document.querySelector(
            'input[name="acl2"]').value = parseFloat(acl1 - agent_acl);

        let agent_act = ((share_percentage.value) === '') ? document.querySelector(
            'input[name="act3"]').value = 0 : document.querySelector(
            'input[name="act3"]').value = parseFloat(((
            parseFloat(
                act1) * parseFloat(share_percentage.value)) / 100));
        let your_act = ((share_percentage.value) === '') ? document.querySelector(
            'input[name="act2"]').value = 0 : document.querySelector(
            'input[name="act2"]').value = parseFloat(act1 - agent_act);

        let agent_tac = ((share_percentage.value) === '') ? document.querySelector(
            'input[name="tac3"]').value = 0 : document.querySelector(
            'input[name="tac3"]').value = parseFloat(((
            parseFloat(
                tac1) * parseFloat(share_percentage.value)) / 100));
        let your_tac = ((share_percentage.value) === '') ? document.querySelector(
            'input[name="tac2"]').value = 0 : document.querySelector(
            'input[name="tac2"]').value = parseFloat(tac1 - agent_tac);

        let agent_tcc = ((share_percentage.value) === '') ? document.querySelector(
            'input[name="tcc3"]').value = 0 : document.querySelector(
            'input[name="tcc3"]').value = parseFloat(((
            parseFloat(
                tcc1) * parseFloat(share_percentage.value)) / 100));
        let your_tcc = ((share_percentage.value) === '') ? document.querySelector(
            'input[name="tcc2"]').value = 0 : document.querySelector(
            'input[name="tcc2"]').value = parseFloat(tcc1 - agent_tcc);
    })
    </script>

    <script>

    </script>
    <script>
    $(document).ready(function() {
        $('#fname').keyup(function() {
            let fname = $(this).val();
            if (fname != '') {
                $.ajax({
                    type: "POST",
                    url: "ajax-agent.php",
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