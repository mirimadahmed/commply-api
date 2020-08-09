<?php
include '../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $get_companies = "";
    $get_risk_report = mysqli_query($con, "select r.*,c.company_name from Risk_Report r inner join Company c on c.company_id=r.company_id");
    $temp = array();
    while ($risk_report_row = mysqli_fetch_array($get_risk_report)) {
        array_push($temp, $risk_report_row);
    }
    echo json_encode($temp);
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
