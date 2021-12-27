<?php
session_start();
include('class/database.php');
class search extends database
{
    public function searchFunction()
    {
        $arr = array();
        $sql = "SELECT * from booking_tbl";
        $res = mysqli_query($this->link, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $arr[] = $row;
        }
        return $arr;
    }
}
$obj = new search;
echo json_encode($obj->searchFunction());