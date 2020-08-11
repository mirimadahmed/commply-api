<?php
include '../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $get_companies = mysqli_query($con, "select * from Company where company_id='$id'");
        $get_locations = mysqli_query($con, "SELECT * FROM `location` where compId='$id'");
        $get_owners = mysqli_query($con, "SELECT * FROM `Owner` where company_id='$id'");
        $get_visitors = mysqli_query($con, "SELECT * FROM `visitor` where compId='$id'");
        $temp = array();
        $temp['locations'] = array();
        $temp['owners'] = array();
        $temp['visitors'] = array();

        while ($company_row = mysqli_fetch_array($get_companies)) {
            $temp['company'] = $company_row;
        }
        while ($location = mysqli_fetch_array($get_locations)) {
            array_push($temp['locations'], $location);
        }
        while ($owner = mysqli_fetch_array($get_owners)) {
            array_push($temp['owners'], $owner);
        }
        while ($visitor = mysqli_fetch_array($get_visitors)) {
            array_push($temp['visitors'], $visitor);
        }
        echo json_encode(utf8ize($temp));
    } else {
        $get_companies = mysqli_query($con, "select * from Company");
        $temp = array();
        while ($company_row = mysqli_fetch_array($get_companies)) {
            array_push($temp, $company_row);
        }
        echo json_encode(utf8ize($temp));
    }
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
