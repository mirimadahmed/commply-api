<?php
include '../../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $get_subsidaries = "";
    if($_GET['is_owner'] == 'true') {
        $company_id = $_GET['company_id'];
        $get_subsidaries=mysqli_query($con,"select distinct subsidary from Employee where subsidary!='' and company_id='$company_id'");
    } else {
        $get_subsidaries = mysqli_query($con, "select distinct subsidary from Employee where subsidary!=''");
    }
    $temp = array();
    while ($subsidary_row = mysqli_fetch_array($get_subsidaries)) {
        array_push($temp, $subsidary_row);
    }
    echo json_encode($temp);
    
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
