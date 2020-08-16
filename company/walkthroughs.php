<?php
include '../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['is_owner'] == 'true') {
        $company_id = $_GET['company_id'];
        $get_data = mysqli_query($con, "SELECT r.*,e.employee_firstname,c.company_name FROM `Risk_Assessment` r left outer join Employee e  on e.employee_id=r.employee_id LEFT outer join Company c on c.company_id=r.company_id where  r.company_id='$company_id'");
    } else {
        $get_data = mysqli_query($con, "SELECT r.*,e.employee_firstname,c.company_name FROM `Risk_Assessment` r left outer join Employee e  on e.employee_id=r.employee_id LEFT outer join Company c on c.company_id=r.company_id");
    }
    $temp = array();
    while ($risk_report_row = mysqli_fetch_array($get_data)) {
        array_push($temp, $risk_report_row);
    }
    echo json_encode($temp);
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
