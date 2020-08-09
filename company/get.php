<?php
include '../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $get_companies = "";
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $get_companies = mysqli_query($con, "select * from Company where company_id='$id'");
    } else {
        $get_companies = mysqli_query($con, "select * from Company");
    }
    $temp = array();
    while ($company_row = mysqli_fetch_array($get_companies)) {
        array_push($temp, $company_row);
    }
    echo json_encode($temp);
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
