<?php
session_start();
$name = "'" . $_SESSION['name'] . "'";
include 'config.php';

$request = 1;
if (isset($_POST['request'])) {
    $request = $_POST['request'];
}

// DataTable data
if ($request == 1) {
    ## Read value
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = ' date'; // Column name
    $columnSortOrder = ' DESC'; // asc or desc

    $searchValue = mysqli_escape_string($con, $_POST['search']['value']); // Search value

    ## Search 
    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " and (property_name like '%" . $searchValue . "%' or 
            date like '%" . $searchValue . "%' or 
            agent_com like'%" . $searchValue . "%' or 
            rent like'%" . $searchValue . "%' or 
            com_landlord like'%" . $searchValue . "%' or 
            com_tenant like'%" . $searchValue . "%' or 
            agent_com_landloard like'%" . $searchValue . "%' or 
            agent_com_tenant like'%" . $searchValue . "%' or 
            company_com like'%" . $searchValue . "%' or 
            admin_comment like'%" . $searchValue . "%' or 
            staff_comment like'%" . $searchValue . "%' )  ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($con, "select count(*) as allcount from booking_tbl where agent_name=" . $name);
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($con, "select count(*) as allcount from booking_tbl WHERE agent_name=" . $name  . $searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from booking_tbl WHERE agent_name=" . $name . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
    $arr = array();
    $i = 0;
    while ($row = mysqli_fetch_assoc($empRecords)) {


        $b_id = $row['booking_id'];
        $sql = "SELECT * from transaction_tbl INNER JOIN booking_tbl ON transaction_tbl.booking_id = booking_tbl.booking_id where booking_tbl.booking_id = $b_id";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res) > 0) {
            $color = '';
            $color1 = '';
            $color2 = '';
            $color3 = '';
            $i++;
            while ($find = mysqli_fetch_assoc($res)) {
                $i++;
                $s = strtolower($find['description']);

                if (preg_match('~\\bcl\\b~i', $s, $m)) {
                    $color = 'bg-success p-2 text-white';
                    $arr['color'] = $color;
                }
                if (preg_match('~\\bct\\b~i', $s, $m)) {
                    $color1 = 'bg-success p-2 text-white';
                    $arr['color1'] = $color1;
                }
                if (preg_match('~\\bacl\\b~i', $s, $m)) {
                    $color2 = 'bg-success p-2 text-white';
                    $arr['color2'] = $color2;
                }
                if (preg_match('~\\bact\\b~i', $s, $m)) {
                    $color3 = 'bg-success p-2 text-white';
                    $arr['color3'] = $color3;
                }
            }
        }
        $bg_1 = '';
        $bg_2 = '';
        $bg_3 = '';
        $bg_4 = '';
        if (isset($arr['color'])) {
            $bg_1 = $arr['color'];
        }
        if (isset($arr['color1'])) {
            $bg_2 = $arr['color1'];
        }
        if (isset($arr['color2'])) {
            $bg_3 = $arr['color2'];
        }
        if (isset($arr['color3'])) {
            $bg_4 = $arr['color3'];
        }

        // echo var_dump($arr);
        // echo $bg_1;
        // echo $bg_2;
        // echo $bg_3;
        // echo $bg_4;

        // Update Button
        $updateButton = "<button class='btn btn-sm btn-block btn-info updateUser' data-id='" . $row['booking_id'] . "' data-toggle='modal' data-target='#updateModal' >Update</button>";

        if ($i > 0) {
            $deleteButton = '';
        } else {
            // Delete Button
            $deleteButton = "<button class='btn btn-sm btn-block btn-danger deleteUser' data-id='" . $row['booking_id'] . "'>Delete</button>";
        }



        $action = $updateButton . " " . $deleteButton;
        if ($row['status'] == 'Complete') {
            $action = "<button class='btn btn-sm btn-block btn-success'>Complete</button>";
            $data[] = array(
                "property_name" => '<a href="all-transaction.php?name=' . $row['property_name'] . '">' . $row['property_name'] . '</a>',
                "date" => date("d/m/Y", strtotime($row['date'])),
                "agent_com" => $row['agent_com'],
                "rent" => $row['rent'],
                "com_landlord" => '<div class="' . $bg_1 . '">' . $row['com_landlord'] . '</div>',
                "com_tenant" => '<div class="' . $bg_2 . '">' . $row['com_tenant'] . '</div>',
                "agent_com_landloard" => '<div class="' . $bg_3 . '">' . $row['agent_com_landloard'] . '</div>',
                "agent_com_tenant" => '<div class="' . $bg_4 . '">' . $row['agent_com_tenant'] . '</div>',
                "company_com" => $row['company_com'],

                "tcc" => $row['tcc'],
                "admin_comment" => $row['admin_comment'],
                "staff_comment" => $row['staff_comment'],
                "action" => $action
            );
        } else {
            $data[] = array(
                "property_name" => '<a href="all-transaction.php?name=' . $row['property_name'] . '">' . $row['property_name'] . '</a>',
                "date" => date("d/m/Y", strtotime($row['date'])),
                "agent_com" => $row['agent_com'],
                "rent" => $row['rent'],
                "com_landlord" => '<div class="' . $bg_1 . '">' . $row['com_landlord'] . '</div>',
                "com_tenant" => '<div class="' . $bg_2 . '">' . $row['com_tenant'] . '</div>',
                "agent_com_landloard" => '<div class="' . $bg_3 . '">' . $row['agent_com_landloard'] . '</div>',
                "agent_com_tenant" => '<div class="' . $bg_4 . '">' . $row['agent_com_tenant'] . '</div>',
                "company_com" => $row['company_com'],
                "tcc" => $row['tcc'],
                "admin_comment" => $row['admin_comment'],
                "staff_comment" => $row['staff_comment'],
                "action" => $action
            );
        }
        $arr = [];
        $i = 0;
    }

    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);
    exit;
}

// Fetch user details
if ($request == 2) {
    $id = 0;

    if (isset($_POST['id'])) {
        $id = mysqli_escape_string($con, $_POST['id']);
    }

    $record = mysqli_query($con, "SELECT * FROM booking_tbl WHERE booking_id=" . $id);

    $response = array();

    if (mysqli_num_rows($record) > 0) {
        $row = mysqli_fetch_assoc($record);
        $response = array(
            "property_name" => $row['property_name'],
            "date" => date("d/m/Y", strtotime($row['date'])),
            "agent_com" => $row['agent_com'],
            "rent" => $row['rent'],
            "com_landlord" => $row['com_landlord'],
            "com_tenant" => $row['com_tenant'],
            "agent_com_landloard" => $row['agent_com_landloard'],
            "agent_com_tenant" => $row['agent_com_tenant'],
            "company_com" => $row['company_com'],
            "tcc" => $row['tcc'],
            "admin_comment" => $row['admin_comment'],
            "staff_comment" => $row['staff_comment'],
        );

        echo json_encode(array("status" => 1, "data" => $response));
        exit;
    } else {
        echo json_encode(array("status" => 0));
        exit;
    }
}

// Update user
if ($request == 3) {
    $id = 0;

    if (isset($_POST['id'])) {
        $id = mysqli_escape_string($con, $_POST['id']);
    }

    // Check id
    $record = mysqli_query($con, "SELECT booking_id FROM booking_tbl WHERE booking_id=" . $id);
    if (mysqli_num_rows($record) > 0) {

        $property_name = mysqli_escape_string($con, trim($_POST['property_name']));

        $date = date('Y-m-d', strtotime(str_replace('/', '-', mysqli_escape_string($con, trim($_POST['date'])))));

        $agent_com = mysqli_escape_string($con, trim($_POST['agent_com']));
        $rent = mysqli_escape_string($con, trim($_POST['rent']));
        $com_landlord = mysqli_escape_string($con, trim($_POST['com_landlord']));
        $com_tenant = mysqli_escape_string($con, trim($_POST['com_tenant']));
        $agent_com_landloard = mysqli_escape_string($con, trim($_POST['agent_com_landloard']));
        $agent_com_tenant = mysqli_escape_string($con, trim($_POST['agent_com_tenant']));
        $company_com = mysqli_escape_string($con, trim($_POST['company_com']));
        $tcc = mysqli_escape_string($con, trim($_POST['tcc']));
        $admin_comment = mysqli_escape_string($con, trim($_POST['admin_comment']));
        $staff_comment = mysqli_escape_string($con, trim($_POST['staff_comment']));

        if ($property_name != '' && $date != '' && $agent_com != '' && $rent != '' && $com_landlord != '' && $com_tenant != '' && $agent_com_landloard != '' && $agent_com_tenant != '' && $company_com != '' && $tcc != '') {

            mysqli_query($con, "UPDATE booking_tbl SET property_name='" . $property_name . "',date='" . $date . "',agent_com='" . $agent_com . "',rent='" . $rent . "',com_landlord='" . $com_landlord . "',com_tenant='" . $com_tenant . "',agent_com_landloard='" . $agent_com_landloard . "',agent_com_tenant='" . $agent_com_tenant . "',company_com='" . $company_com . "', tcc='" . $tcc . "', admin_comment='" . $admin_comment . "', staff_comment='" . $staff_comment . "' WHERE booking_id=" . $id);

            echo json_encode(array("status" => 1, "message" => "Record updated."));
            exit;
        } else {
            echo json_encode(array("status" => 0, "message" => "Please fill all fields."));
            exit;
        }
    } else {
        echo json_encode(array("status" => 0, "message" => "Invalid ID."));
        exit;
    }
}

// Delete User
if ($request == 4) {
    $id = 0;

    if (isset($_POST['id'])) {
        $id = mysqli_escape_string($con, $_POST['id']);
    }

    // Check id
    $record = mysqli_query($con, "SELECT booking_id FROM booking_tbl WHERE booking_id=" . $id);
    if (mysqli_num_rows($record) > 0) {

        mysqli_query($con, "DELETE FROM booking_tbl WHERE booking_id=" . $id);

        mysqli_query($con, "DELETE FROM booking_tbl WHERE shared_id=" . $id);

        echo 1;
        exit;
    } else {
        echo 0;
        exit;
    }
}