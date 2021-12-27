<?php
session_start();
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
            status like'%" . $searchValue . "%' or 
            agent_name like'%" . $searchValue . "%' or 
            admin_comment like'%" . $searchValue . "%' or 
            staff_comment like'%" . $searchValue . "%' or 
            tcc like'%" . $searchValue . "%')  ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($con, "select count(*) as allcount from booking_tbl");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($con, "select count(*) as allcount from booking_tbl WHERE 1"  . $searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from booking_tbl WHERE 1" . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button
        $updateButton = "<button class='btn btn-sm btn-block btn-info updateUser' data-id='" . $row['booking_id'] . "' data-toggle='modal' data-target='#updateModal' >Update</button>";

        // Delete Button
        // $deleteButton = "<button class='btn btn-sm btn-block btn-danger deleteUser' data-id='" . $row['booking_id'] . "'>Delete</button>";

        $action = $updateButton;

        if ($row['status'] == 'Complete') {
            $data[] = array(
                "property_name" => $row['property_name'],
                "agent_name" => $row['agent_name'],
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
                "status" => '<h6 class="badge badge-success">' . $row['status'] . '</h6>',
                "action" => $action
            );
        } else {
            $data[] = array(
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
                "agent_name" => $row['agent_name'],
                "status" => '<h6 class="badge badge-danger">' . $row['status'] . '</h6>',
                "action" => $action
            );
        }
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
            "agent_name" => $row['agent_name'],
            "date" => date("d/m/Y", strtotime($row['date'])),
            "agent_com" => $row['agent_com'],
            "rent" => $row['rent'],
            "com_landlord" => $row['com_landlord'],
            "com_tenant" => $row['com_tenant'],
            "agent_com_landloard" => $row['agent_com_landloard'],
            "agent_com_tenant" => $row['agent_com_tenant'],
            "status" => $row['status'],
            "admin_comment" => $row['admin_comment'],
            "staff_comment" => $row['staff_comment'],
            "company_com" => $row['company_com'],
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

        // $property_name = mysqli_escape_string($con, trim($_POST['property_name']));
        // $date = mysqli_escape_string($con, trim($_POST['date']));
        // $agent_com = mysqli_escape_string($con, trim($_POST['agent_com']));
        // $rent = mysqli_escape_string($con, trim($_POST['rent']));
        // $com_landlord = mysqli_escape_string($con, trim($_POST['com_landlord']));
        // $com_tenant = mysqli_escape_string($con, trim($_POST['com_tenant']));
        // $agent_com_landloard = mysqli_escape_string($con, trim($_POST['agent_com_landloard']));
        // $agent_com_tenant = mysqli_escape_string($con, trim($_POST['agent_com_tenant']));
        // $company_com = mysqli_escape_string($con, trim($_POST['company_com']));
        $status = mysqli_escape_string($con, trim($_POST['status']));
        $admin_comment = mysqli_escape_string($con, trim($_POST['admin_comment']));
        // $staff_comment = mysqli_escape_string($con, trim($_POST['staff_comment']));

        if ($status != '') {

            mysqli_query($con, "UPDATE booking_tbl SET status='" . $status . "', admin_comment='" . $admin_comment . "' WHERE booking_id=" . $id);

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

        echo 1;
        exit;
    } else {
        echo 0;
        exit;
    }
}