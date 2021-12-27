<?php
session_start();
date_default_timezone_set("Asia/Hong_Kong");
include('class/database.php');
class search extends database
{
    public function searchFunction()
    {

        $user = $_SESSION['name'];
        $insertId = $_POST['id'];

        if (count($_FILES['booking_file']['name']) > 1) {
            $sql = "DELETE from file_tbl where booking_id = '$insertId' ";
            mysqli_query($this->link, $sql);
        }

        echo count($_FILES['booking_file']);


        for ($i = 0; $i < count($_FILES['booking_file']['name']); $i++) {
            $files = date("d-m-Y") . '_' . date("h-i-sa") . '_' . $user . '@' . $_FILES['booking_file']['name'][$i];

            $target = 'files/' . $files;
            move_uploaded_file($_FILES['booking_file']['tmp_name'][$i], $target);

            if ($_FILES['booking_file']['tmp_name'][$i] != '') {
                $sqlFile = "INSERT INTO `file_tbl` (`file_id`, `file_name`, `file_created_at`, `booking_id`) VALUES (NULL, '$files', CURRENT_TIMESTAMP, '$insertId')";
                $res = mysqli_query($this->link, $sqlFile);
            }
        }

        if (isset($res)) {
            return '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Files are changed!</strong>
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