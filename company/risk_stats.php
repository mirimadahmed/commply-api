<?php
include '../connection.php';
$next_monday = date("Y-m-d", strtotime("next monday"));
$previous_monday = date("Y-m-d", strtotime("previous monday"));
$date_month = date('m');
$date_year = date('Y');
$date = date('Y-m-d');
$first_date = date('Y-m-01');
$last_date = date('Y-m-t');
$temp = array();
$no_of_risk_logged = "";
$no_of_risk_assessed = "";
$total_open_risk = "";
$total_closed_risk = "";

if ($_GET['daterange_report'] == 'true') {
    $start = $_GET['start'];
    $end = $_GET['end'];
    $report_type = $start . ' To ' . $end;
    if ($_GET['is_owner'] == 'true') {
        $company_id = $_GET['company_id'];
        $get_risk_logged = mysqli_query($con, "select count(*) as total_risk_logged from Risk_Report where date(date_created)>='$start' and date(date_created)<='$end' and company_id='$company_id'");
        $get_risk_assessed = mysqli_query($con, "select count(*) as total_risk_assessed from Risk_Assessment where date(date_created)>='$start' and date(date_created)<='$end' and company_id='$company_id'");
        $get_open_risk = mysqli_query($con, "select count(*) as total_open_risk from Risk_Report where date(date_created)>='$start' and date(date_created)<='$end' and company_id='$company_id' and status='Open'");
        $get_closed_risk = mysqli_query($con, "select count(*) as total_closed_risk from Risk_Report where date(date_created)>='$start' and date(date_created)<='$end' and company_id='$company_id' and status='Closed'");
    } else {
        $get_risk_logged = mysqli_query($con, "select count(*) as total_risk_logged from Risk_Report where date(date_created)>='$start' and date(date_created)<='$end'");
        $get_risk_assessed = mysqli_query($con, "select count(*) as total_risk_assessed from Risk_Assessment where date(date_created)>='$start' and date(date_created)<='$end'");
        $get_open_risk = mysqli_query($con, "select count(*) as total_open_risk from Risk_Report where date(date_created)>='$start' and date(date_created)<='$end' and status='Open'");
        $get_closed_risk = mysqli_query($con, "select count(*) as total_closed_risk from Risk_Report where date(date_created)>='$start' and date(date_created)<='$end' and status='Closed'");
    }
    $no_of_risk_logged = mysqli_fetch_array($get_risk_logged);
    $no_of_risk_assessed = mysqli_fetch_array($get_risk_assessed);
    $total_open_risk = mysqli_fetch_array($get_open_risk);
    $total_closed_risk = mysqli_fetch_array($get_closed_risk);
} else if ($_GET['report'] == '') {
    $report_type = 'Today';
    if ($_GET['is_owner'] == 'true') {
        $company_id = $_GET['company_id'];
        $get_risk_logged = mysqli_query($con, "select count(*) as total_risk_logged from Risk_Report where date(date_created)='$date' and company_id='$company_id'");
        $get_risk_assessed = mysqli_query($con, "select count(*) as total_risk_assessed from Risk_Assessment where date(date_created)='$date' and company_id='$company_id'");
        $get_open_risk = mysqli_query($con, "select count(*) as total_open_risk from Risk_Report where date(date_created)='$date' and company_id='$company_id' and status='Open'");
        $get_closed_risk = mysqli_query($con, "select count(*) as total_closed_risk from Risk_Report where date(date_created)='$date' and company_id='$company_id' and status='Closed'");
    } else {
        $get_risk_logged = mysqli_query($con, "select count(*) as total_risk_logged from Risk_Report where date(date_created)='$date'");
        $get_risk_assessed = mysqli_query($con, "select count(*) as total_risk_assessed from Risk_Assessment where date(date_created)='$date'");
        $get_open_risk = mysqli_query($con, "select count(*) as total_open_risk from Risk_Report where date(date_created)='$date'  and status='Open'");
        $get_closed_risk = mysqli_query($con, "select count(*) as total_closed_risk from Risk_Report where date(date_created)='$date' and status='Closed'");
    }
    $no_of_risk_logged = mysqli_fetch_array($get_risk_logged);
    $no_of_risk_assessed = mysqli_fetch_array($get_risk_assessed);
    $total_open_risk = mysqli_fetch_array($get_open_risk);
    $total_closed_risk = mysqli_fetch_array($get_closed_risk);
} else if (isset($_GET['report']) && $_GET['report'] == 'today') {
    $report_type = 'Today';
    if ($_GET['is_owner'] == 'true') {
        $company_id = $_GET['company_id'];
        $get_risk_logged = mysqli_query($con, "select count(*) as total_risk_logged from Risk_Report where date(date_created)='$date' and company_id='$company_id'");
        $get_risk_assessed = mysqli_query($con, "select count(*) as total_risk_assessed from Risk_Assessment where date(date_created)='$date' and company_id='$company_id'");
        $get_open_risk = mysqli_query($con, "select count(*) as total_open_risk from Risk_Report where date(date_created)='$date'  and company_id='$company_id' and status='Open'");
        $get_closed_risk = mysqli_query($con, "select count(*) as total_closed_risk from Risk_Report where date(date_created)='$date'  and company_id='$company_id' and status='Closed'");
    } else {
        $get_risk_logged = mysqli_query($con, "select count(*) as total_risk_logged from Risk_Report where date(date_created)='$date'");
        $get_risk_assessed = mysqli_query($con, "select count(*) as total_risk_assessed from Risk_Assessment where date(date_created)='$date'");
        $get_open_risk = mysqli_query($con, "select count(*) as total_open_risk from Risk_Report where date(date_created)='$date' and status='Open'");
        $get_closed_risk = mysqli_query($con, "select count(*) as total_closed_risk from Risk_Report where date(date_created)='$date' and status='Closed'");
    }
    $no_of_risk_logged = mysqli_fetch_array($get_risk_logged);
    $no_of_risk_assessed = mysqli_fetch_array($get_risk_assessed);
    $total_open_risk = mysqli_fetch_array($get_open_risk);
    $total_closed_risk = mysqli_fetch_array($get_closed_risk);
} else if (isset($_GET['report']) && $_GET['report'] == 'week') {
    $report_type = 'This Week';
    if ($_GET['is_owner'] == 'true') {
        $company_id = $_GET['company_id'];
        $get_risk_logged = mysqli_query($con, "select count(*) as total_risk_logged from Risk_Report where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and company_id='$company_id'");
        $get_risk_assessed = mysqli_query($con, "select count(*) as total_risk_assessed from Risk_Assessment where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and company_id='$company_id'");
        $get_open_risk = mysqli_query($con, "select count(*) as total_open_risk from Risk_Report where date(date_created)>='$previous_monday' and date(date_created)<='$next_monday' and company_id='$company_id' and status='Open'");
        $get_closed_risk = mysqli_query($con, "select count(*) as total_closed_risk from Risk_Report where date(date_created)>='$previous_monday' and date(date_created)<='$next_monday' and company_id='$company_id' and status='Closed'");
    } else {
        $get_risk_logged = mysqli_query($con, "select count(*) as total_risk_logged from Risk_Report where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday'");
        $get_risk_assessed = mysqli_query($con, "select count(*) as total_risk_assessed from Risk_Assessment where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday'");
        $get_open_risk = mysqli_query($con, "select count(*) as total_open_risk from Risk_Report where date(date_created)>='$previous_monday' and date(date_created)<='$next_monday' and status='Open'");
        $get_closed_risk = mysqli_query($con, "select count(*) as total_closed_risk from Risk_Report where date(date_created)>='$previous_monday' and date(date_created)<='$next_monday' and status='Closed'");
    }
    $no_of_risk_logged = mysqli_fetch_array($get_risk_logged);
    $no_of_risk_assessed = mysqli_fetch_array($get_risk_assessed);
    $total_open_risk = mysqli_fetch_array($get_open_risk);
    $total_closed_risk = mysqli_fetch_array($get_closed_risk);
} else if (isset($_GET['report']) && $_GET['report'] == 'month') {
    $report_type = 'Month';
    if ($_GET['is_owner'] == 'true') {
        $company_id = $_GET['company_id'];
        $get_risk_logged = mysqli_query($con, "select count(*) as total_risk_logged from Risk_Report where date(date_created)>='$first_date' and date(date_created)<='$last_date' and company_id='$company_id'");
        $get_risk_assessed = mysqli_query($con, "select count(*) as total_risk_assessed from Risk_Assessment where date(date_created)>='$first_date' and date(date_created)<='$last_date' and company_id='$company_id'");
        $get_open_risk = mysqli_query($con, "select count(*) as total_open_risk from Risk_Report where date(date_created)>='$first_date' and date(date_created)<='$last_date' and company_id='$company_id' and status='Open'");
        $get_closed_risk = mysqli_query($con, "select count(*) as total_closed_risk from Risk_Report where date(date_created)>='$first_date' and date(date_created)<='$last_date' and company_id='$company_id' and status='Closed'");
    } else {
        $get_risk_logged = mysqli_query($con, "select count(*) as total_risk_logged from Risk_Report where date(date_created)>='$first_date' and date(date_created)<='$last_date'");
        $get_risk_assessed = mysqli_query($con, "select count(*) as total_risk_assessed from Risk_Assessment where date(date_created)>='$first_date' and date(date_created)<='$last_date'");
        $get_open_risk = mysqli_query($con, "select count(*) as total_open_risk from Risk_Report where date(date_created)>='$first_date' and date(date_created)<='$last_date'  and status='Open'");
        $get_closed_risk = mysqli_query($con, "select count(*) as total_closed_risk from Risk_Report where date(date_created)>='$first_date' and date(date_created)<='$last_date' and status='Closed'");
    }
    $no_of_risk_logged = mysqli_fetch_array($get_risk_logged);
    $no_of_risk_assessed = mysqli_fetch_array($get_risk_assessed);
    $total_open_risk = mysqli_fetch_array($get_open_risk);
    $total_closed_risk = mysqli_fetch_array($get_closed_risk);
}

$temp['riskLogged'] = intval($no_of_risk_logged[0]);
$temp['riskAssessed'] = intval($no_of_risk_assessed[0]);
$temp['openRisk'] = intval($total_open_risk[0]);
$temp['closedRisk'] = intval($total_closed_risk[0]);

echo json_encode($temp);