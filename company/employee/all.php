<?php
include '../../connection.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $get_employees = mysqli_query($con, "select e.*,c.company_name as company_name from Employee e inner join Company c on e.company_id=c.company_id and e.company_id='$id'");
    $temp = array();
    while ($employees_row = mysqli_fetch_array($get_employees)) {
        array_push($temp, $employees_row);
    }
    echo json_encode(utf8ize($temp));
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
