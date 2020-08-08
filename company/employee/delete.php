<?php
include '../../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_id = $_POST['id'];
    mysqli_query($con, "delete from  `Employee` WHERE employee_id='$emp_id'");
    $temp = array();
    $temp['error'] = 0;
    $temp['message'] = "Employee deleted successfully";
    echo json_encode($temp);
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
