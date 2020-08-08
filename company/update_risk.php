<?php
include '../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $risk_id = $_POST['id'];
    $status = $_POST['status'];
    mysqli_query($con, "UPDATE `Risk_Report` SET `status`='$status' WHERE risk_id='$risk_id'");
    $temp = array();
    $temp['error'] = 0;
    $temp['message'] = "Risk Updated Successfully";
    echo json_encode($temp);
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
