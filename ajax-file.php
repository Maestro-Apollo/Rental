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
    $columnName = ' file_tbl.file_created_at'; // Column name
    $columnSortOrder = ' DESC'; // asc or desc

    $searchValue = mysqli_escape_string($con, $_POST['search']['value']); // Search value

    $booking_id = $_POST['booking_id'];


    ## Search 
    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " and (file_tbl.file_name like '%" . $searchValue . "%' or 
            file_tbl.file_created_at like '%" . $searchValue . "%'  )  ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($con, "select count(*) as allcount from file_tbl where booking_id=" . $booking_id);
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($con, "select count(*) as allcount from file_tbl WHERE booking_id=" . $booking_id . $searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from file_tbl WHERE file_tbl.booking_id=" . $booking_id . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button
        $updateButton = "<a download class='btn btn-info' href='files/" . $row['file_name'] . "'><i class='fas fa-download'></i></a>";

        // // Delete Button
        $deleteButton = "<button class='btn btn-danger deleteUser' data-id='" . $row['file_id'] . "'><i class='fas fa-trash-alt'></i></button>";

        $action = $updateButton . ' ' . $deleteButton;


        $fileName = $row['file_name'];
        $var = explode('@', $fileName);

        $fileName = '<a href="files/' . $row['file_name'] . '">' . $var[1] . '</a>';

        if (preg_match('/\.(jpg|png|jpeg|gif|tiff)$/', strtolower($row['file_name']))) {
            $thumbnail = '<a target="_blank" href="files/' . $row['file_name'] . '"><img src="files/' . $row['file_name'] . '"</a>';
        } else {
            $thumbnail = '';
        }




        $data[] = array(

            "line_number" => 'F-' . $row['file_id'],
            "thumbnail" => $thumbnail,
            "file_name" => $fileName,
            "file_created_at" => $row['file_created_at'],
            "action" => $action
        );
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

// // Fetch user details
// if ($request == 2) {
//     $id = 0;

//     if (isset($_POST['id'])) {
//         $id = mysqli_escape_string($con, $_POST['id']);
//     }

//     $record = mysqli_query($con, "SELECT * FROM transaction_tbl WHERE transaction_id=" . $id);

//     $response = array();

//     if (mysqli_num_rows($record) > 0) {
//         $row = mysqli_fetch_assoc($record);
//         $response = array(
//             "description" => $row['description'],
//             "amount" => $row['amount'],
//             "paid_by" => $row['paid_by'],
//             "received_by" => $row['received_by'],
//             "remarks" => $row['remarks'],
//             "slip" => $row['slip'],

//         );

//         echo json_encode(array("status" => 1, "data" => $response));
//         exit;
//     } else {
//         echo json_encode(array("status" => 0));
//         exit;
//     }
// }

// // Update user
// if ($request == 3) {
//     $id = 0;

//     if (isset($_POST['id'])) {
//         $id = mysqli_escape_string($con, $_POST['id']);
//     }

//     // Check id
//     $record = mysqli_query($con, "SELECT transaction_id FROM transaction_tbl WHERE transaction_id=" . $id);
//     if (mysqli_num_rows($record) > 0) {

//         $description = mysqli_escape_string($con, trim($_POST['description']));
//         $amount = mysqli_escape_string($con, trim($_POST['amount']));
//         $paid_by = mysqli_escape_string($con, trim($_POST['paid_by']));
//         $received_by = mysqli_escape_string($con, trim($_POST['received_by']));
//         $remarks = mysqli_escape_string($con, trim($_POST['remarks']));
//         $slip = mysqli_escape_string($con, trim($_POST['slip']));


//         if ($description != '' && $amount != '' && $paid_by != '' && $received_by != '' && $remarks != '' && $slip != '') {

//             mysqli_query($con, "UPDATE transaction_tbl SET description='" . $description . "',amount='" . $amount . "',paid_by='" . $paid_by . "',received_by='" . $received_by . "',remarks='" . $remarks . "',slip='" . $slip . "' WHERE transaction_id=" . $id);

//             echo json_encode(array("status" => 1, "message" => "Record updated."));
//             exit;
//         } else {
//             echo json_encode(array("status" => 0, "message" => "Please fill all fields."));
//             exit;
//         }
//     } else {
//         echo json_encode(array("status" => 0, "message" => "Invalid ID."));
//         exit;
//     }
// }

// // Delete User
// if ($request == 4) {
//     $id = 0;

//     if (isset($_POST['id'])) {
//         $id = mysqli_escape_string($con, $_POST['id']);
//     }

//     // Check id
//     $record = mysqli_query($con, "SELECT transaction_id FROM transaction_tbl WHERE transaction_id=" . $id);
//     if (mysqli_num_rows($record) > 0) {

//         mysqli_query($con, "DELETE FROM transaction_tbl WHERE transaction_id=" . $id);

//         echo 1;
//         exit;
//     } else {
//         echo 0;
//         exit;
//     }
// }
if ($request == 4) {
    $id = 0;

    if (isset($_POST['id'])) {
        $id = mysqli_escape_string($con, $_POST['id']);
    }

    // Check id
    $record = mysqli_query($con, "SELECT file_id FROM file_tbl WHERE file_id=" . $id);
    if (mysqli_num_rows($record) > 0) {

        mysqli_query($con, "DELETE FROM file_tbl WHERE file_id=" . $id);

        echo 1;
        exit;
    } else {
        echo 0;
        exit;
    }
}