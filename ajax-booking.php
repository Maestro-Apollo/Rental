<?php
session_start();
date_default_timezone_set("Asia/Hong_Kong");
include('class/database.php');
class search extends database
{
  public function searchFunction()
  {
    $user = addslashes(trim($_SESSION['name']));
    $property_name = addslashes(trim($_POST['property_name']));
    $var = $_POST['date'];
    $dateMid = str_replace('/', '-', $var);
    $date = date('Y-m-d', strtotime($dateMid));
    $agent_com = addslashes(trim($_POST['agent_com']));
    $rent = addslashes(trim($_POST['rent']));
    $land_com = addslashes(trim($_POST['land_com']));
    $tenant_com = addslashes(trim($_POST['tenant_com']));
    $agent_com_per = addslashes(trim($_POST['agent_com_per']));
    $tenant_com_per = addslashes(trim($_POST['tenant_com_per']));
    $company_com = addslashes(trim($_POST['company_com']));
    $tcc = addslashes(trim($_POST['tcc']));


    $sql = "INSERT INTO `booking_tbl` (`booking_id`, `agent_name`, `property_name`, `date`, `agent_com`, `rent`, `com_landlord`, `com_tenant`, `agent_com_landloard`, `agent_com_tenant`, `company_com`,`tcc`,`status`, `admin_comment`,`staff_comment`, `created_at`) VALUES (NULL, '$user', '$property_name', '$date', '$agent_com', '$rent', '$land_com', '$tenant_com', '$agent_com_per', '$tenant_com_per', '$company_com', '$tcc','Incomplete', '','', CURRENT_TIMESTAMP)";
    $res = mysqli_query($this->link, $sql);

    $insertId = mysqli_insert_id($this->link);

    for ($i = 0; $i < count($_FILES['booking_file']['name']); $i++) {
      $files = date("d-m-Y") . '_' . date("h-i-sa") . '_' . $user . '@' . $_FILES['booking_file']['name'][$i];

      $target = 'files/' . $files;
      move_uploaded_file($_FILES['booking_file']['tmp_name'][$i], $target);

      if ($_FILES['booking_file']['tmp_name'][$i] != '') {
        $sqlFile = "INSERT INTO `file_tbl` (`file_id`, `file_name`, `file_created_at`, `booking_id`) VALUES (NULL, '$files', CURRENT_TIMESTAMP, '$insertId')";
        mysqli_query($this->link, $sqlFile);
      }
    }

    if ($res) {
      return '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Booking is added!</strong>
          </div>';
    } else {
      return '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error!</strong>
          </div>';
    }

    # code...
  }
}
$obj = new search;
echo $obj->searchFunction();