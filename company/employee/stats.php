<?php
include '../../connection.php';
$next_monday = date("Y-m-d", strtotime("next monday"));
$previous_monday = date("Y-m-d", strtotime("previous monday"));
$date_month = date('m');
$date_year = date('Y');
$date = date('Y-m-d');
$first_date = date('Y-m-01');
$last_date = date('Y-m-t');
$barchart_fever_array = array();
$barchart_cough_array = array();
$barchart_breathing_array = array();
$line_chart_dates = array();
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 1 days')));
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 2 days')));
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 3 days')));
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 4 days')));
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 5 days')));
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 6 days')));
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 7 days')));
$symptomatic_count = 0;
$asymptomatic_count = 0;
$total_employee_age = 0;
$age_above_60 = 0;
$age_under_60 = 0;
$subsidary_check = "";
$subsidary_single_check = "";
if ($_GET['is_owner'] == 'true') {
    $company_id = $_GET['company_id'];
    $get_comorbidity_employee = mysqli_query($con, "SELECT count(*) as comorbidity_employee FROM `Comorbidity` c inner join Employee e on e.employee_id=c.employee_id where e.company_id='$company_id'");
    $get_total_employee_comorbity = mysqli_query($con, "select count(*) as total_employee_comorbidity from Employee where company_id='$company_id'");
    $get_barchart_emp_fever = mysqli_query($con, "select count(*) as total_employee_fever from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and company_id='$company_id' and fever='yes' group by date_created limit 7");
    $array_date = $previous_monday;
    while ($barchar_row = mysqli_fetch_array($get_barchart_emp_fever)) {
        $barchart_fever_array[$array_date] = $barchar_row['total_employee_fever'];
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
    $get_barchart_emp_cough = mysqli_query($con, "select count(*) as total_employee_cough from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and company_id='$company_id' and cough='yes' group by date_created limit 7");
    $array_date = $previous_monday;
    while ($barchar_row_cough = mysqli_fetch_array($get_barchart_emp_cough)) {
        $barchart_cough_array[$array_date] = $barchar_row_cough['total_employee_cough'];
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
    $get_barchart_emp_breathing = mysqli_query($con, "select count(*) as total_employee_breathing from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and company_id='$company_id' and shortness_of_breath='yes' group by date_created limit 7");
    $array_date = $previous_monday;
    while ($barchar_row_breathing = mysqli_fetch_array($get_barchart_emp_breathing)) {
        $barchart_breathing_array[$array_date] = $barchar_row_breathing['total_employee_breathing'];
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
    $get_employee_age = mysqli_query($con, "select * from Employee where company_id='$company_id'");
    $total_employee_age = mysqli_num_rows($get_employee_age);
    while ($employee_age = mysqli_fetch_array($get_employee_age)) {
        $age_string = $employee_age['employee_id_number'];
        $year = substr($age_string, 0, 2);
        if ($year > date('y')) {
            $year = '19' . $year;
        } else {
            $year = '20' . $year;
        }
        $month = substr($age_string, 2, 2);
        $day = substr($age_string, 4, 2);
        $date_of_birth = date('Y-m-d', strtotime($year . $month . $day));
        $age = round((time() - strtotime($date_of_birth)) / (3600 * 24 * 365.25));
        if ($age < 60) {
            $age_under_60 += 1;
        } else {
            $age_above_60 += 1;
        }
    }
} else {
    $get_total_employee_comorbity = mysqli_query($con, "select count(*) as total_employee_comorbidity from Employee");
    $get_comorbidity_employee = mysqli_query($con, "select count(*) as comorbidity_employee  from Comorbidity");
    $get_barchart_emp_fever = mysqli_query($con, "select count(*) as total_employee_fever from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday'  and fever='yes'  group by date_created limit 7");
    $array_date = $previous_monday;
    while ($barchar_row = mysqli_fetch_array($get_barchart_emp_fever)) {
        $barchart_fever_array[$array_date] = $barchar_row['total_employee_fever'];
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
    $get_barchart_emp_cough = mysqli_query($con, "select count(*) as total_employee_cough from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and cough='yes' group by date_created limit 7");
    $array_date = $previous_monday;
    while ($barchar_row_cough = mysqli_fetch_array($get_barchart_emp_cough)) {
        $barchart_cough_array[$array_date] = $barchar_row_cough['total_employee_cough'];
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
    $get_barchart_emp_breathing = mysqli_query($con, "select count(*) as total_employee_breathing from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and shortness_of_breath='yes' group by date_created limit 7");
    $array_date = $previous_monday;
    while ($barchar_row_breathing = mysqli_fetch_array($get_barchart_emp_breathing)) {
        $barchart_breathing_array[$array_date] = $barchar_row_breathing['total_employee_breathing'];
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
    $subsidary = $_GET['subsidary'];
    if ($subsidary != 'all') {
        $subsidary_check = " where subsidary=" . "'" . $subsidary . "'";
    } else {
        $subsidary_check = '';
    }
    $get_employee_age = mysqli_query($con, "select * from Employee" . $subsidary_check);
    $total_employee_age = mysqli_num_rows($get_employee_age);
    while ($employee_age = mysqli_fetch_array($get_employee_age)) {
        $age_string = $employee_age['employee_id_number'];
        $year = substr($age_string, 0, 2);
        if ($year > date('y')) {
            $year = '19' . $year;
        } else {
            $year = '20' . $year;
        }
        $month = substr($age_string, 2, 2);
        $day = substr($age_string, 4, 2);
        $date_of_birth = date('Y-m-d', strtotime($year . $month . $day));
        $age = round((time() - strtotime($date_of_birth)) / (3600 * 24 * 365.25));
        if ($age < 60) {
            $age_under_60 += 1;
        } else {
            $age_above_60 += 1;
        }
    }
}

$subsidary = $_GET['subsidary'];
if ($subsidary != 'all') {
    $subsidary_check = " and subsidary=" . "'" . $subsidary . "'";
    $subsidary_single_check = " where subsidary=" . "'" . $subsidary . "'";
} else {
    $subsidary_check = '';
}

$comorbidity_employee = mysqli_fetch_array($get_comorbidity_employee);
$total_employee_comorbidity = mysqli_fetch_array($get_total_employee_comorbity);


if ($_GET['daterange_report'] == 'true') {
    $start = date("Y-m-d", strtotime($_GET['start']));
    $end = date("Y-m-d", strtotime($_GET['end']));
    $report_type = $start . ' To ' . $end;
    if ($_GET['is_owner'] == 'true') {
        $company_id = $_GET['company_id'];
        $get_screened_distinct_employees = mysqli_query($con, "select count(distinct(employee_id)) as total_emp_screened from Daily_check where date(date_created)>='$start' and date(date_created)<='$end' and company_id='$company_id'");
        $get_symtomatic_employee = mysqli_query($con, "select distinct(employee_id) as employee_id from Daily_check where date(date_created)>='$start' and date(date_created)<='$end' and company_id='$company_id'" . $subsidary_check);
        $get_total_employees = mysqli_query($con, "select count(*) as total_employee from Employee where company_id='$company_id'");
        $get_registered_employees = mysqli_query($con, "select count(*) as registered_employee from Employee where  company_id='$company_id' and (employee_token!='' or employee_token!=null)" . $subsidary_check);
        $get_screened_employees = mysqli_query($con, "select count(*) as total_emp_screened from Daily_check where date(date_created)>='$start' and date(date_created)<='$end' and company_id='$company_id'");
        $get_employee_declaration = mysqli_query($con, "select count(*) as total_emp_declaration from Declaration where date(date_created)>='$start' and date(date_created)<='$end' and company_id='$company_id'");
        $get_employee_fever = mysqli_query($con, "select count(*) as total_emp_fever from Daily_check where date(date_created)>='$start' and date(date_created)<='$end' and company_id='$company_id' and fever='Yes'");
        $get_employee_cough = mysqli_query($con, "select count(*) as total_emp_cough from Daily_check where date(date_created)>='$start' and date(date_created)<='$end' and company_id='$company_id' and cough='Yes'");
        $get_employee_breathing = mysqli_query($con, "select count(*) as total_emp_breathing from Daily_check where date(date_created)>='$start' and date(date_created)<='$end' and company_id='$company_id' and shortness_of_breath='Yes'");
    } else {
        $get_screened_distinct_employees = mysqli_query($con, "select count(distinct(employee_id)) as total_emp_screened from Daily_check where date(date_created)>='$start' and date(date_created)<='$end'");
        $get_symtomatic_employee = mysqli_query($con, "select distinct(employee_id) as employee_id from Daily_check where date(date_created)>='$start' and date(date_created)<='$end'");
        $get_total_employees = mysqli_query($con, "select count(*) as total_employee from Employee " . $subsidary_single_check);
        $get_registered_employees = mysqli_query($con, "select count(*) as registered_employee from Employee where  (employee_token!='' or employee_token!=null)" . $subsidary_check);
        $get_screened_employees = mysqli_query($con, "select count(*) as total_emp_screened from Daily_check where date(date_created)>='$start' and date(date_created)<='$end'");
        $get_employee_declaration = mysqli_query($con, "select count(*) as total_emp_declaration from Declaration where date(date_created)>='$start' and date(date_created)<='$end'");
        $get_employee_fever = mysqli_query($con, "select count(*) as total_emp_fever from Daily_check where date(date_created)>='$start' and date(date_created)<='$end' and fever='Yes'");
        $get_employee_cough = mysqli_query($con, "select count(*) as total_emp_cough from Daily_check where date(date_created)>='$start' and date(date_created)<='$end' and cough='Yes'");
        $get_employee_breathing = mysqli_query($con, "select count(*) as total_emp_breathing from Daily_check where date(date_created)>='$start' and date(date_created)<='$end' and shortness_of_breath='Yes'");
    }
    while ($symtomatic_row = mysqli_fetch_array($get_symtomatic_employee)) {
        $employee_id = $symtomatic_row['employee_id'];
        $check_symptoms = mysqli_query($con, "select distinct d.col from( select sore_throat as col from Daily_check where employee_id='$employee_id' and date(date_created)>='$start' and date(date_created)<='$end' union all select cough from Daily_check where employee_id='$employee_id' and date(date_created)>='$start' and date(date_created)<='$end' union all select loss_of_smell from Daily_check where employee_id='$employee_id' and date(date_created)>='$start' and date(date_created)<='$end' union all select body_aches from Daily_check where employee_id='$employee_id' and date(date_created)>='$start' and date(date_created)<='$end' union all select fever from Daily_check where employee_id='$employee_id' and date(date_created)>='$start' and date(date_created)<='$end' union all select fever from Daily_check where employee_id='$employee_id' and date(date_created)>='$start' and date(date_created)<='$end' union all select redness from Daily_check where employee_id='$employee_id' and date(date_created)>='$start' and date(date_created)<='$end' union all select shortness_of_breath from Daily_check where employee_id='$employee_id' and date(date_created)>='$start' and date(date_created)<='$end' union all select nausea from Daily_check where employee_id='$employee_id' and date(date_created)>='$start' and date(date_created)<='$end' union all select vomiting from Daily_check where employee_id='$employee_id' and date(date_created)>='$start' and date(date_created)<='$end' union all select diarrhea from Daily_check where employee_id='$employee_id' and date(date_created)>='$start' and date(date_created)<='$end' union all select weakness from Daily_check where employee_id='$employee_id' and date(date_created)>='$start' and date(date_created)<='$end' union all select contact_with from Daily_check where employee_id='$employee_id' and date(date_created)>='$start' and date(date_created)<='$end') d");
        if (mysqli_num_rows($check_symptoms) > 1) {
            $symptomatic_count += 1;
        } else if (mysqli_num_rows($check_symptoms) == 1) {
            $check_result = mysqli_fetch_array($check_symptoms);
            if ($check_result['col'] == 'Yes' || $check_result['col'] == 'YES') {
                $symptomatic_count += 1;
            } else if ($check_result['col'] == 'No' || $check_result['col'] == 'NO') {
                $asymptomatic_count += 1;
            }
        }
    }
    $total_employee = mysqli_fetch_array($get_total_employees);
    $registered_employee = mysqli_fetch_array($get_registered_employees);
    $screened_employee = mysqli_fetch_array($get_screened_employees);
    $screened_distinct_employee = mysqli_fetch_array($get_screened_distinct_employees);
    $declaration_employee = mysqli_fetch_array($get_employee_declaration);
    $fever_employee = mysqli_fetch_array($get_employee_fever);
    $cough_employee = mysqli_fetch_array($get_employee_cough);
    $breathing_employee = mysqli_fetch_array($get_employee_breathing);
    $temp = array(
        'chartDates' => $line_chart_dates,
        'chartFever' => $barchart_fever_array,
        'chartCough' => $barchart_cough_array,
        'chartBreathing' => $barchart_breathing_array,
        'totalAge' => $total_employee_age,
        'aboveSixty' => $age_above_60,
        'belowSixty' => $age_under_60,
        'totalEmployee' => intval($total_employee[0]),
        'registeredEmployee' => intval($registered_employee[0]),
        'comorbidityEmployee' => intval($comorbidity_employee[0]),
        'totalCombordittyEmployee' => intval($total_employee_comorbidity[0]),
        'screenedEmployee' => intval($screened_employee[0]),
        'screenedDistinctEmployee' => intval($screened_distinct_employee[0]),
        'declarationEmployee' => intval($declaration_employee[0]),
        'feverEmployee' => intval($fever_employee[0]),
        'coughEmployee' => intval($cough_employee[0]),
        'breathingEmployee' => intval($breathing_employee[0]),
        'symptomaticCount' => $symptomatic_count,
        'aSymptomaticCount' => $asymptomatic_count
    );

    echo json_encode($temp);
} else if ($_GET['report'] == '') {
    $report_type = 'Today';
    if ($_GET['is_owner'] == 'true') {
        $company_id = $_GET['company_id'];
        $get_screened_distinct_employees = mysqli_query($con, "select count(distinct(employee_id)) as total_emp_screened from Daily_check where date(date_created)='$date' and company_id='$company_id'");
        $get_symtomatic_employee = mysqli_query($con, "select distinct(employee_id) as employee_id from Daily_check where date(date_created)='$date' and company_id='$company_id'");
        $get_total_employees = mysqli_query($con, "select count(*) as total_employee from Employee where company_id='$company_id'");
        $get_registered_employees = mysqli_query($con, "select count(*) as registered_employee from Employee where date(date_created)='$date' and company_id='$company_id'  and (employee_token!='' or employee_token!=null)");
        $get_screened_employees = mysqli_query($con, "select count(*) as total_emp_screened from Daily_check where date(date_created)='$date' and company_id='$company_id'");
        $get_employee_declaration = mysqli_query($con, "select count(*) as total_emp_declaration from Declaration where date(date_created)='$date' and company_id='$company_id'");
        $get_employee_fever = mysqli_query($con, "select count(*) as total_emp_fever from Daily_check where date(date_created)='$date' and company_id='$company_id' and fever='Yes'");
        $get_employee_cough = mysqli_query($con, "select count(*) as total_emp_cough from Daily_check where date(date_created)='$date' and company_id='$company_id' and cough='Yes'");
        $get_employee_breathing = mysqli_query($con, "select count(*) as total_emp_breathing from Daily_check where date(date_created)='$date' and company_id='$company_id' and shortness_of_breath='Yes'");
    } else {
        $get_screened_distinct_employees = mysqli_query($con, "select count(distinct(employee_id)) as total_emp_screened from Daily_check where date(date_created)='$date'");
        $get_symtomatic_employee = mysqli_query($con, "select distinct(employee_id) as employee_id from Daily_check where date(date_created)='$date'");
        $get_total_employees = mysqli_query($con, "select count(*) as total_employee from Employee");
        $get_registered_employees = mysqli_query($con, "select count(*) as registered_employee from Employee where date(date_created)='$date' and  (employee_token!='' or employee_token!=null)");
        $get_screened_employees = mysqli_query($con, "select count(*) as total_emp_screened from Daily_check where date(date_created)='$date'");
        $get_employee_declaration = mysqli_query($con, "select count(*) as total_emp_declaration from Declaration where date(date_created)='$date'");
        $get_employee_fever = mysqli_query($con, "select count(*) as total_emp_fever from Daily_check where date(date_created)='$date' and fever='Yes'");
        $get_employee_cough = mysqli_query($con, "select count(*) as total_emp_cough from Daily_check where date(date_created)='$date' and cough='Yes'");
        $get_employee_breathing = mysqli_query($con, "select count(*) as total_emp_breathing from Daily_check where date(date_created)='$date' and shortness_of_breath='Yes'");
    }
    while ($symtomatic_row = mysqli_fetch_array($get_symtomatic_employee)) {
        $employee_id = $symtomatic_row['employee_id'];
        $check_symptoms = mysqli_query($con, "select distinct d.col from( select sore_throat as col from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select cough from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select loss_of_smell from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select body_aches from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select fever from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select fever from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select redness from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select shortness_of_breath from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select nausea from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select vomiting from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select diarrhea from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select weakness from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select contact_with from Daily_check where employee_id='$employee_id' and date(date_created)='$date') d");
        if (mysqli_num_rows($check_symptoms) > 1) {
            $symptomatic_count += 1;
        } else if (mysqli_num_rows($check_symptoms) == 1) {
            $check_result = mysqli_fetch_array($check_symptoms);
            if ($check_result['col'] == 'Yes' || $check_result['col'] == 'YES') {
                $symptomatic_count += 1;
            } else if ($check_result['col'] == 'No' || $check_result['col'] == 'NO') {
                $asymptomatic_count += 1;
            }
        }
    }
    $total_employee = mysqli_fetch_array($get_total_employees);
    $registered_employee = mysqli_fetch_array($get_registered_employees);
    $screened_employee = mysqli_fetch_array($get_screened_employees);
    $screened_distinct_employee = mysqli_fetch_array($get_screened_distinct_employees);
    $declaration_employee = mysqli_fetch_array($get_employee_declaration);
    $fever_employee = mysqli_fetch_array($get_employee_fever);
    $cough_employee = mysqli_fetch_array($get_employee_cough);
    $breathing_employee = mysqli_fetch_array($get_employee_breathing);
    $temp = array(
        'chartDates' => $line_chart_dates,
        'chartFever' => $barchart_fever_array,
        'chartCough' => $barchart_cough_array,
        'chartBreathing' => $barchart_breathing_array,
        'totalAge' => $total_employee_age,
        'aboveSixty' => $age_above_60,
        'belowSixty' => $age_under_60,
        'totalEmployee' => intval($total_employee[0]),
        'registeredEmployee' => intval($registered_employee[0]),
        'comorbidityEmployee' => intval($comorbidity_employee[0]),
        'totalCombordittyEmployee' => intval($total_employee_comorbidity[0]),
        'screenedEmployee' => intval($screened_employee[0]),
        'screenedDistinctEmployee' => intval($screened_distinct_employee[0]),
        'declarationEmployee' => intval($declaration_employee[0]),
        'feverEmployee' => intval($fever_employee[0]),
        'coughEmployee' => intval($cough_employee[0]),
        'breathingEmployee' => intval($breathing_employee[0]),
        'symptomaticCount' => $symptomatic_count,
        'aSymptomaticCount' => $asymptomatic_count
    );

    echo json_encode($temp);
} else if (isset($_GET['report']) && $_GET['report'] == 'today') {
    $report_type = 'Today';
    if ($_GET['is_owner'] == 'true') {
        $company_id = $_GET['company_id'];
        $get_screened_distinct_employees = mysqli_query($con, "select count(distinct(employee_id)) as total_emp_screened from Daily_check where date(date_created)='$date' and company_id='$company_id'");
        $get_symtomatic_employee = mysqli_query($con, "select distinct(employee_id) as employee_id from Daily_check where date(date_created)='$date' and company_id='$company_id'");
        $get_total_employees = mysqli_query($con, "select count(*) as total_employee from Employee where company_id='$company_id' " . $subsidary_check);
        $get_registered_employees = mysqli_query($con, "select count(*) as registered_employee from Employee where date(date_created)='$date' and company_id='$company_id'  and (employee_token!='' or employee_token!=null)");
        $get_screened_employees = mysqli_query($con, "select count(*) as total_emp_screened from Daily_check where date(date_created)='$date' and company_id='$company_id'");
        $get_employee_declaration = mysqli_query($con, "select count(*) as total_emp_declaration from Declaration where date(date_created)='$date' and company_id='$company_id'");
        $get_employee_fever = mysqli_query($con, "select count(*) as total_emp_fever from Daily_check where date(date_created)='$date' and company_id='$company_id' and fever='Yes'");
        $get_employee_cough = mysqli_query($con, "select count(*) as total_emp_cough from Daily_check where date(date_created)='$date' and company_id='$company_id' and cough='Yes'");
        $get_employee_breathing = mysqli_query($con, "select count(*) as total_emp_breathing from Daily_check where date(date_created)='$date' and company_id='$company_id' and shortness_of_breath='Yes'");
    } else {
        $get_screened_distinct_employees = mysqli_query($con, "select count(distinct(employee_id)) as total_emp_screened from Daily_check where date(date_created)='$date'");
        $get_symtomatic_employee = mysqli_query($con, "select distinct(employee_id) as employee_id from Daily_check where date(date_created)='$date'");
        $get_total_employees = mysqli_query($con, "select count(*) as total_employee from Employee " . $subsidary_single_check);
        $get_registered_employees = mysqli_query($con, "select count(*) as registered_employee from Employee where date(date_created)='$date' and (employee_token!='' or employee_token!=null)" . $subsidary_check);
        $get_screened_employees = mysqli_query($con, "select count(*) as total_emp_screened from Daily_check where date(date_created)='$date'");
        $get_employee_declaration = mysqli_query($con, "select count(*) as total_emp_declaration from Declaration where date(date_created)='$date'");
        $get_employee_fever = mysqli_query($con, "select count(*) as total_emp_fever from Daily_check where date(date_created)='$date' and fever='Yes'");
        $get_employee_cough = mysqli_query($con, "select count(*) as total_emp_cough from Daily_check where date(date_created)='$date' and cough='Yes'");
        $get_employee_breathing = mysqli_query($con, "select count(*) as total_emp_breathing from Daily_check where date(date_created)='$date' and shortness_of_breath='Yes'");
    }
    while ($symtomatic_row = mysqli_fetch_array($get_symtomatic_employee)) {
        $employee_id = $symtomatic_row['employee_id'];
        $check_symptoms = mysqli_query($con, "select distinct d.col from( select sore_throat as col from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select cough from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select loss_of_smell from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select body_aches from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select fever from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select fever from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select redness from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select shortness_of_breath from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select nausea from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select vomiting from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select diarrhea from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select weakness from Daily_check where employee_id='$employee_id' and date(date_created)='$date' union all select contact_with from Daily_check where employee_id='$employee_id' and date(date_created)='$date') d");
        if (mysqli_num_rows($check_symptoms) > 1) {
            $symptomatic_count += 1;
        } else if (mysqli_num_rows($check_symptoms) == 1) {
            $check_result = mysqli_fetch_array($check_symptoms);
            if ($check_result['col'] == 'Yes' || $check_result['col'] == 'YES') {
                $symptomatic_count += 1;
            } else if ($check_result['col'] == 'No' || $check_result['col'] == 'NO') {
                $asymptomatic_count += 1;
            }
        }
    }
    $total_employee = mysqli_fetch_array($get_total_employees);
    $registered_employee = mysqli_fetch_array($get_registered_employees);
    $screened_employee = mysqli_fetch_array($get_screened_employees);
    $screened_distinct_employee = mysqli_fetch_array($get_screened_distinct_employees);
    $declaration_employee = mysqli_fetch_array($get_employee_declaration);
    $fever_employee = mysqli_fetch_array($get_employee_fever);
    $cough_employee = mysqli_fetch_array($get_employee_cough);
    $breathing_employee = mysqli_fetch_array($get_employee_breathing);
    $temp = array(
        'chartDates' => $line_chart_dates,
        'chartFever' => $barchart_fever_array,
        'chartCough' => $barchart_cough_array,
        'chartBreathing' => $barchart_breathing_array,
        'totalAge' => $total_employee_age,
        'aboveSixty' => $age_above_60,
        'belowSixty' => $age_under_60,
        'totalEmployee' => intval($total_employee[0]),
        'registeredEmployee' => intval($registered_employee[0]),
        'comorbidityEmployee' => intval($comorbidity_employee[0]),
        'totalCombordittyEmployee' => intval($total_employee_comorbidity[0]),
        'screenedEmployee' => intval($screened_employee[0]),
        'screenedDistinctEmployee' => intval($screened_distinct_employee[0]),
        'declarationEmployee' => intval($declaration_employee[0]),
        'feverEmployee' => intval($fever_employee[0]),
        'coughEmployee' => intval($cough_employee[0]),
        'breathingEmployee' => intval($breathing_employee[0]),
        'symptomaticCount' => $symptomatic_count,
        'aSymptomaticCount' => $asymptomatic_count
    );

    echo json_encode($temp);
} else if (isset($_GET['report']) && $_GET['report'] == 'week') {
    $report_type = 'This Week';
    if ($_GET['is_owner'] == 'true') {
        $company_id = $_GET['company_id'];
        $get_screened_distinct_employees = mysqli_query($con, "select count(distinct(employee_id)) as total_emp_screened from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday'  and company_id='$company_id'");
        $get_symtomatic_employee = mysqli_query($con, "select distinct(employee_id) as employee_id from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday'  and company_id='$company_id'");
        $get_total_employees = mysqli_query($con, "select count(*) as total_employee from Employee where company_id='$company_id'" . $subsidary_check);
        $get_registered_employees = mysqli_query($con, "select count(*) as registered_employee from Employee where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and company_id='$company_id'  and (employee_token!='' or employee_token!=null)" . $subsidary_check);
        $get_screened_employees = mysqli_query($con, "select count(*) as total_emp_screened from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday'  and company_id='$company_id'");
        $get_employee_declaration = mysqli_query($con, "select count(*) as total_emp_declaration from Declaration where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and company_id='$company_id'");
        $get_employee_fever = mysqli_query($con, "select count(*) as total_emp_fever from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and company_id='$company_id' and fever='Yes'");
        $get_employee_cough = mysqli_query($con, "select count(*) as total_emp_cough from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and company_id='$company_id' and cough='Yes'");
        $get_employee_breathing = mysqli_query($con, "select count(*) as total_emp_breathing from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and company_id='$company_id' and shortness_of_breath='Yes'");
    } else {
        $get_screened_distinct_employees = mysqli_query($con, "select count(distinct(employee_id)) as total_emp_screened from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday'");
        $get_symtomatic_employee = mysqli_query($con, "select distinct(employee_id) as employee_id from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday'");
        $get_total_employees = mysqli_query($con, "select count(*) as total_employee from Employee " . $subsidary_single_check);
        $get_registered_employees = mysqli_query($con, "select count(*) as registered_employee from Employee where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and (employee_token!='' or employee_token!=null)" . $subsidary_check);
        $get_screened_employees = mysqli_query($con, "select count(*) as total_emp_screened from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday'");
        $get_employee_declaration = mysqli_query($con, "select count(*) as total_emp_declaration from Declaration where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday'");
        $get_employee_fever = mysqli_query($con, "select count(*) as total_emp_fever from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and fever='Yes'");
        $get_employee_cough = mysqli_query($con, "select count(*) as total_emp_cough from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and cough='Yes'");
        $get_employee_breathing = mysqli_query($con, "select count(*) as total_emp_breathing from Daily_check where date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' and shortness_of_breath='Yes'");
    }
    while ($symtomatic_row = mysqli_fetch_array($get_symtomatic_employee)) {
        $employee_id = $symtomatic_row['employee_id'];
        $check_symptoms = mysqli_query($con, "select distinct d.col from( select sore_throat as col from Daily_check where employee_id='$employee_id' and date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' union all select cough from Daily_check where employee_id='$employee_id' and date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' union all select loss_of_smell from Daily_check where employee_id='$employee_id' and date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' union all select body_aches from Daily_check where employee_id='$employee_id' and date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' union all select fever from Daily_check where employee_id='$employee_id' and date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' union all select fever from Daily_check where employee_id='$employee_id' and date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' union all select redness from Daily_check where employee_id='$employee_id' and date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' union all select shortness_of_breath from Daily_check where employee_id='$employee_id' and date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' union all select nausea from Daily_check where employee_id='$employee_id' and date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' union all select vomiting from Daily_check where employee_id='$employee_id' and date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' union all select diarrhea from Daily_check where employee_id='$employee_id' and date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' union all select weakness from Daily_check where employee_id='$employee_id' and date(date_created)>='$previous_monday' and date(date_created)<'$next_monday' union all select contact_with from Daily_check where employee_id='$employee_id' and date(date_created)>='$previous_monday' and date(date_created)<'$next_monday') d");
        if (mysqli_num_rows($check_symptoms) > 1) {
            $symptomatic_count += 1;
        } else if (mysqli_num_rows($check_symptoms) == 1) {
            $check_result = mysqli_fetch_array($check_symptoms);
            if ($check_result['col'] == 'Yes' || $check_result['col'] == 'YES') {
                $symptomatic_count += 1;
            } else if ($check_result['col'] == 'No' || $check_result['col'] == 'NO') {
                $asymptomatic_count += 1;
            }
        }
    }
    $total_employee = mysqli_fetch_array($get_total_employees);
    $registered_employee = mysqli_fetch_array($get_registered_employees);
    $screened_employee = mysqli_fetch_array($get_screened_employees);
    $screened_distinct_employee = mysqli_fetch_array($get_screened_distinct_employees);
    $declaration_employee = mysqli_fetch_array($get_employee_declaration);
    $fever_employee = mysqli_fetch_array($get_employee_fever);
    $cough_employee = mysqli_fetch_array($get_employee_cough);
    $breathing_employee = mysqli_fetch_array($get_employee_breathing);
    $temp = array(
        'chartDates' => $line_chart_dates,
        'chartFever' => $barchart_fever_array,
        'chartCough' => $barchart_cough_array,
        'chartBreathing' => $barchart_breathing_array,
        'totalAge' => $total_employee_age,
        'aboveSixty' => $age_above_60,
        'belowSixty' => $age_under_60,
        'totalEmployee' => intval($total_employee[0]),
        'registeredEmployee' => intval($registered_employee[0]),
        'comorbidityEmployee' => intval($comorbidity_employee[0]),
        'totalCombordittyEmployee' => intval($total_employee_comorbidity[0]),
        'screenedEmployee' => intval($screened_employee[0]),
        'screenedDistinctEmployee' => intval($screened_distinct_employee[0]),
        'declarationEmployee' => intval($declaration_employee[0]),
        'feverEmployee' => intval($fever_employee[0]),
        'coughEmployee' => intval($cough_employee[0]),
        'breathingEmployee' => intval($breathing_employee[0]),
        'symptomaticCount' => $symptomatic_count,
        'aSymptomaticCount' => $asymptomatic_count
    );

    echo json_encode($temp);
} else if (isset($_GET['report']) && $_GET['report'] == 'month') {
    $report_type = 'Month';
    if ($_GET['is_owner'] == 'true') {
        $company_id = $_GET['company_id'];
        $get_screened_distinct_employees = mysqli_query($con, "select count(distinct(employee_id)) as total_emp_screened from Daily_check where date(date_created)>='$first_date' and date(date_created)<='$last_date'  and company_id='$company_id'");
        $get_symtomatic_employee = mysqli_query($con, "select distinct(employee_id) as employee_id from Daily_check where date(date_created)>='$first_date' and date(date_created)<'$last_date'  and company_id='$company_id'");
        $get_total_employees = mysqli_query($con, "select count(*) as total_employee from Employee where  company_id='$company_id'" . $subsidary_check);
        $get_registered_employees = mysqli_query($con, "select count(*) as registered_employee from Employee where date(date_created)>='$first_date' and date(date_created)<'$last_date' and company_id='$company_id'  and (employee_token!='' or employee_token!=null)" . $subsidary_check);
        $get_screened_employees = mysqli_query($con, "select count(*) as total_emp_screened from Daily_check where date(date_created)>='$first_date' and date(date_created)<='$last_date'  and company_id='$company_id'");
        $get_employee_declaration = mysqli_query($con, "select count(*) as total_emp_declaration from Declaration where date(date_created)>='$first_date' and date(date_created)<='$last_date' and company_id='$company_id'");
        $get_employee_fever = mysqli_query($con, "select count(*) as total_emp_fever from Daily_check where date(date_created)>='$first_date' and date(date_created)<'$last_date' and company_id='$company_id' and fever='Yes'");
        $get_employee_cough = mysqli_query($con, "select count(*) as total_emp_cough from Daily_check where date(date_created)>='$first_date' and date(date_created)<'$last_date' and company_id='$company_id' and cough='Yes'");
        $get_employee_breathing = mysqli_query($con, "select count(*) as total_emp_breathing from Daily_check where date(date_created)>='$first_date' and date(date_created)<'$last_date' and company_id='$company_id' and shortness_of_breath='Yes'");
    } else {
        $get_screened_distinct_employees = mysqli_query($con, "select count(distinct(employee_id)) as total_emp_screened from Daily_check where date(date_created)>='$first_date' and date(date_created)<='$last_date'");
        $get_symtomatic_employee = mysqli_query($con, "select distinct(employee_id) as employee_id from Daily_check where date(date_created)>='$first_date' and date(date_created)<'$last_date'");
        $get_total_employees = mysqli_query($con, "select count(*) as total_employee from Employee " . $subsidary_single_check);
        $get_registered_employees = mysqli_query($con, "select count(*) as registered_employee from Employee where date(date_created)>='$first_date' and date(date_created)<'$last_date' and (employee_token!='' or employee_token!=null)" . $subsidary_check);
        $get_screened_employees = mysqli_query($con, "select count(*) as total_emp_screened from Daily_check where date(date_created)>='$first_date' and date(date_created)<='$last_date'");
        $get_employee_declaration = mysqli_query($con, "select count(*) as total_emp_declaration from Declaration where date(date_created)>='$first_date' and date(date_created)<='$last_date'");
        $get_employee_fever = mysqli_query($con, "select count(*) as total_emp_fever from Daily_check where date(date_created)>='$first_date' and date(date_created)<'$last_date'  and fever='Yes'");
        $get_employee_cough = mysqli_query($con, "select count(*) as total_emp_cough from Daily_check where date(date_created)>='$first_date' and date(date_created)<'$last_date'  and cough='Yes'");
        $get_employee_breathing = mysqli_query($con, "select count(*) as total_emp_breathing from Daily_check where date(date_created)>='$first_date' and date(date_created)<'$last_date'  and shortness_of_breath='Yes'");
    }
    while ($symtomatic_row = mysqli_fetch_array($get_symtomatic_employee)) {
        $employee_id = $symtomatic_row['employee_id'];
        $check_symptoms = mysqli_query($con, "select distinct d.col from( select sore_throat as col from Daily_check where employee_id='$employee_id' and date(date_created)>='$first_date' and date(date_created)<='$last_date' union all select cough from Daily_check where employee_id='$employee_id' and date(date_created)>='$first_date' and date(date_created)<='$last_date' union all select loss_of_smell from Daily_check where employee_id='$employee_id' and date(date_created)>='$first_date' and date(date_created)<='$last_date' union all select body_aches from Daily_check where employee_id='$employee_id' and date(date_created)>='$first_date' and date(date_created)<='$last_date' union all select fever from Daily_check where employee_id='$employee_id' and date(date_created)>='$first_date' and date(date_created)<='$last_date' union all select fever from Daily_check where employee_id='$employee_id' and date(date_created)>='$first_date' and date(date_created)<='$last_date' union all select redness from Daily_check where employee_id='$employee_id' and date(date_created)>='$first_date' and date(date_created)<='$last_date' union all select shortness_of_breath from Daily_check where employee_id='$employee_id' and date(date_created)>='$first_date' and date(date_created)<='$last_date' union all select nausea from Daily_check where employee_id='$employee_id' and date(date_created)>='$first_date' and date(date_created)<='$last_date' union all select vomiting from Daily_check where employee_id='$employee_id' and date(date_created)>='$first_date' and date(date_created)<='$last_date' union all select diarrhea from Daily_check where employee_id='$employee_id' and date(date_created)>='$first_date' and date(date_created)<='$last_date' union all select weakness from Daily_check where employee_id='$employee_id' and date(date_created)>='$first_date' and date(date_created)<='$last_date' union all select contact_with from Daily_check where employee_id='$employee_id' and date(date_created)>='$first_date' and date(date_created)<='$last_date') d");
        if (mysqli_num_rows($check_symptoms) > 1) {
            $symptomatic_count += 1;
        } else if (mysqli_num_rows($check_symptoms) == 1) {
            $check_result = mysqli_fetch_array($check_symptoms);
            if ($check_result['col'] == 'Yes' || $check_result['col'] == 'YES') {
                $symptomatic_count += 1;
            } else if ($check_result['col'] == 'No' || $check_result['col'] == 'NO') {
                $asymptomatic_count += 1;
            }
        }
    }
    $total_employee = mysqli_fetch_array($get_total_employees);
    $registered_employee = mysqli_fetch_array($get_registered_employees);
    $screened_employee = mysqli_fetch_array($get_screened_employees);
    $screened_distinct_employee = mysqli_fetch_array($get_screened_distinct_employees);
    $declaration_employee = mysqli_fetch_array($get_employee_declaration);
    $fever_employee = mysqli_fetch_array($get_employee_fever);
    $cough_employee = mysqli_fetch_array($get_employee_cough);
    $breathing_employee = mysqli_fetch_array($get_employee_breathing);
    $temp = array(
        'chartDates' => $line_chart_dates,
        'chartFever' => $barchart_fever_array,
        'chartCough' => $barchart_cough_array,
        'chartBreathing' => $barchart_breathing_array,
        'totalAge' => $total_employee_age,
        'aboveSixty' => $age_above_60,
        'belowSixty' => $age_under_60,
        'totalEmployee' => intval($total_employee[0]),
        'registeredEmployee' => intval($registered_employee[0]),
        'comorbidityEmployee' => intval($comorbidity_employee[0]),
        'totalCombordittyEmployee' => intval($total_employee_comorbidity[0]),
        'screenedEmployee' => intval($screened_employee[0]),
        'screenedDistinctEmployee' => intval($screened_distinct_employee[0]),
        'declarationEmployee' => intval($declaration_employee[0]),
        'feverEmployee' => intval($fever_employee[0]),
        'coughEmployee' => intval($cough_employee[0]),
        'breathingEmployee' => intval($breathing_employee[0]),
        'symptomaticCount' => $symptomatic_count,
        'aSymptomaticCount' => $asymptomatic_count
    );

    echo json_encode($temp);
}
