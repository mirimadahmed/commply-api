<?php
include '../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $get_buildings = mysqli_query($con, "SELECT * FROM `Risk_Assessment`");
    $temp = array();
    while ($building_row = mysqli_fetch_array($get_buildings)) {
        array_push($temp, $building_row);
    }
    echo json_encode(utf8ize($temp));
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
