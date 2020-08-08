<?php
include '../../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $owner_id = $_POST['id'];
    mysqli_query($con, "delete from  `Owner` WHERE owner_id='$owner_id'");
    $temp = array();
    $temp['error'] = 0;
    $temp['message'] = "Owner deleted successfully";
    echo json_encode($temp);
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
