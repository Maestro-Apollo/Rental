<?php
include('./config.php');
if ($con) {

    $user = addslashes(trim($_POST['fname']));

    if (isset($user)) {
        $output = '';
        $sql = "SELECT * from booking_tbl where property_name like '%$user%' ";
        $res = mysqli_query($con, $sql);
        $output = '<ul class="list-group w-100">';
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '<a style="text-decoration: none;" class="text-decoration-none" target="_blank" href="admin-transaction.php?id=' . $row['booking_id'] . '"><li class="list-group-item list-group-item-action list-group-item-dark"><strong>' . $row['property_name'] . '</strong> (' . $row['agent_name'] . ' - ' . date("d/m/Y", strtotime($row['date'])) . ')</li></a>';
            }
        } else {
            $output .= '<li>No property found</li>';
        }
        $output .= '</ul>';
        echo $output;
    }
}