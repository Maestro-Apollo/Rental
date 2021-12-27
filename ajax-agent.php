<?php
session_start();
include('./config.php');
if ($con) {

    $user = addslashes(trim($_POST['fname']));

    if (isset($user)) {
        $output = '';
        $name = $_SESSION['name'];
        $sql = "SELECT * from user_tbl where username like '%$user%' AND username <> '$name' ";
        $res = mysqli_query($con, $sql);
        $output = '<ul class="list-group w-100">';
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '<li class="list-group-item list-group-item-action list-group-item-dark"><strong>' . $row['username'] . '</strong></li>';
            }
        } else {
            $output .= '<li>No Agent found</li>';
        }
        $output .= '</ul>';
        echo $output;
    }
}