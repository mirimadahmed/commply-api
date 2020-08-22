<?php
include 'connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $company_check = "";
    if ($_GET['is_owner'] == 'true') {
        $company_id = $_GET['company_id'];
        $company_check = " Where company_id='$company_id'";
    }

    $declarations = "SELECT COUNT(*) FROM `declaration`" . $company_check;
    $total_declarations = "SELECT COUNT(*) FROM `employee`" . $company_check;
    $total_daily_checks = "SELECT COUNT(*) FROM `daily_check`" . $company_check;

    $total_visitors = "SELECT COUNT(*) FROM `visitor`";
    if ($_GET['is_owner'] == 'true') {
        $total_visitors .= "WHERE compId='$company_id'";
    }

    $total_risks = "SELECT COUNT(*) FROM `risk_report`" . $company_check;
    $open_risks = "SELECT COUNT(*) FROM `risk_report` WHERE status ='open'";
    if ($_GET['is_owner'] == 'true') {
        $open_risks .= "AND company_id='$company_id'";
    }

    $get_declarations = mysqli_query($con, $declarations);
    $get_total_declarations = mysqli_query($con, $total_declarations);
    $get_total_daily_checks = mysqli_query($con, $total_daily_checks);
    $get_total_visitors = mysqli_query($con, $total_visitors);
    $get_total_risks = mysqli_query($con, $total_risks);
    $get_open_risks = mysqli_query($con, $open_risks);

    $declarations = mysqli_fetch_array($get_declarations);
    $total_declarations = mysqli_fetch_array($get_total_declarations);
    $total_daily_checks = mysqli_fetch_array($get_total_daily_checks);
    $total_visitors = mysqli_fetch_array($get_total_visitors);
    $total_risks = mysqli_fetch_array($get_total_risks);
    $open_risks = mysqli_fetch_array($get_open_risks);

    $temp = array(
        'declarations' => intval($declarations[0]),
        'totalDeclarations' => intval($total_declarations[0]),
        'totalDailyChecks' => intval($total_daily_checks[0]),
        'totalVisitors' => intval($total_visitors[0]),
        'totalRisks' => intval($total_risks[0]),
        'openRisks' => intval($open_risks[0]),
    );
    echo json_encode(utf8ize($temp));
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
