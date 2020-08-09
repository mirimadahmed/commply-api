<?php
include '../../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $get_owners = mysqli_query($con, "select o.*,c.company_name as company_name from Owner o left outer join Company c on o.company_id=c.company_id");
    $temp = array();
    while ($owner_row = mysqli_fetch_array($get_owners)) {
        array_push($temp, $owner_row);
    }
    echo json_encode(utf8ize($temp));
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}