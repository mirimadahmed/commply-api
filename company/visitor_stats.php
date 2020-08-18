<?php
include '../connection.php';
$next_monday = date("Y-m-d", strtotime("next monday"));
$previous_monday = date("Y-m-d", strtotime("previous monday"));
$date_month = date('m');
$date_year = date('Y');
$date = date('Y-m-d');
$first_date = date('Y-m-01');
$last_date = date('Y-m-t');
$donut_location_array = array();
$barchart_fever_array = array();
$barchart_cough_array = array();
$barchart_breathing_array = array();
$total_visitors_count = 0;
$symptomatic_count = 0;
$asymptomatic_count = 0;
$temp = array();
$line_chart_dates = array();
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 1 days')));
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 2 days')));
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 3 days')));
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 4 days')));
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 5 days')));
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 6 days')));
array_push($line_chart_dates, date('Y-m-d', strtotime($previous_monday. ' + 7 days')));
$temp['chartDates'] = $line_chart_dates;

if ($_GET['is_owner'] == 'true') {
    $compId = $_GET['company_id'];
    $get_donut_visitor_location = mysqli_query($con, "SELECT v.dateCreated,count(v.id) as total_visitor_location,v.locationId,l.description FROM `visitor` v inner join location l on l.locationId=v.locationId where date(v.dateCreated)>='$previous_monday' and date(v.dateCreated)<'$next_monday' and v.compId='$compId' group by v.locationId");
    $array_date = $previous_monday;
    while ($barchar_row = mysqli_fetch_array($get_donut_visitor_location)) {
        $array = array("date" => $array_date, "total_visitor_location" => intval($barchar_row['total_visitor_location']), "description" => $barchar_row['description']);
        $donut_location_array[] = $array;
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
    $get_barchart_visitor_fever = mysqli_query($con, "select count(*) as total_visitor_fever from visitor where date(dateCreated)>='$previous_monday' and date(dateCreated)<'$next_monday' and compId='$compId' and fever='yes' group by dateCreated limit 7");
    $array_date = $previous_monday;
    while ($barchar_row = mysqli_fetch_array($get_barchart_visitor_fever)) {
        $barchart_fever_array[$array_date] = $barchar_row['total_visitor_fever'];
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
    $get_barchart_visitor_cough = mysqli_query($con, "select count(*) as total_visitor_cough from visitor where date(dateCreated)>='$previous_monday' and date(dateCreated)<'$next_monday' and compId='$compId' and cough='yes' group by dateCreated limit 7");
    $array_date = $previous_monday;
    while ($barchar_row_cough = mysqli_fetch_array($get_barchart_visitor_cough)) {
        $barchart_cough_array[$array_date] = $barchar_row_cough['total_visitor_cough'];
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
    $get_barchart_visitor_breathing = mysqli_query($con, "select count(*) as total_visitor_breathing from visitor where date(dateCreated)>='$previous_monday' and date(dateCreated)<'$next_monday' and compId='$compId' and shortnessOfBreath='yes' group by dateCreated limit 7");
    $array_date = $previous_monday;
    while ($barchar_row_breathing = mysqli_fetch_array($get_barchart_visitor_breathing)) {
        $barchart_breathing_array[$array_date] = $barchar_row_breathing['total_visitor_breathing'];
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
} else {
    $get_donut_visitor_location = mysqli_query($con, "SELECT v.dateCreated,count(v.id) as total_visitor_location,v.locationId,l.description FROM `visitor` v inner join location l on l.locationId=v.locationId where date(v.dateCreated)>='$previous_monday' and date(v.dateCreated)<'$next_monday' group by v.locationId");
    $array_date = $previous_monday;
    while ($barchar_row = mysqli_fetch_array($get_donut_visitor_location)) {
        $array = array("date" => $array_date, "total_visitor_location" => intval($barchar_row['total_visitor_location']), "description" => $barchar_row['description']);
        $donut_location_array[] = $array;
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
    $get_barchart_visitor_fever = mysqli_query($con, "select count(*) as total_visitor_fever from visitor where date(dateCreated)>='$previous_monday' and date(dateCreated)<'$next_monday'  and fever='yes'  group by dateCreated limit 7");
    $array_date = $previous_monday;
    while ($barchar_row = mysqli_fetch_array($get_barchart_visitor_fever)) {
        $barchart_fever_array[$array_date] = $barchar_row['total_visitor_fever'];
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
    $get_barchart_visitor_cough = mysqli_query($con, "select count(*) as total_visitor_cough from visitor where date(dateCreated)>='$previous_monday' and date(dateCreated)<'$next_monday' and cough='yes' group by dateCreated limit 7");
    $array_date = $previous_monday;
    while ($barchar_row_cough = mysqli_fetch_array($get_barchart_visitor_cough)) {
        $barchart_cough_array[$array_date] = $barchar_row_cough['total_visitor_cough'];
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
    $get_barchart_visitor_breathing = mysqli_query($con, "select count(*) as total_visitor_breathing from visitor where date(dateCreated)>='$previous_monday' and date(dateCreated)<'$next_monday' and shortnessOfBreath='yes' group by dateCreated limit 7");
    $array_date = $previous_monday;
    while ($barchar_row_breathing = mysqli_fetch_array($get_barchart_visitor_breathing)) {
        $barchart_breathing_array[$array_date] = $barchar_row_breathing['total_visitor_breathing'];
        $array_date = date('Y-m-d', strtotime($array_date . ' + 1 days'));
    }
}
$temp['locations'] = $donut_location_array;
$temp['chartCough'] = $barchart_fever_array;
$temp['chartFever'] = $barchart_cough_array;
$temp['chartBreathing'] = $barchart_breathing_array;


if ($_GET['daterange_report'] == 'true') {
    $start = date("Y-m-d", strtotime($_GET['start']));
    $end = date("Y-m-d", strtotime($_GET['end']));
    $report_type = $start . ' To ' . $end;
    if ($_GET['is_owner'] == 'true') {
        $compId = $_GET['company_id'];
        $get_screened_visitors = mysqli_query($con, "select count(id) as total_vis_screened from visitor where date(dateCreated)>='$start' and date(dateCreated)<='$end' and compId='$compId'");
        $get_symtomatic_visitor = mysqli_query($con, "select id as visitor_id from visitor where date(dateCreated)>='$start' and date(dateCreated)<='$end' and compId='$compId'");
    } else {
        $get_screened_visitors = mysqli_query($con, "select count(id) as total_vis_screened from visitor where date(dateCreated)>='$start' and date(dateCreated)<='$end'");
        $get_symtomatic_visitor = mysqli_query($con, "select id as visitor_id from visitor where date(dateCreated)>='$start' and date(dateCreated)<='$end'");
    }
    while ($symtomatic_row = mysqli_fetch_array($get_symtomatic_visitor)) {
        $visitor_id = $symtomatic_row['visitor_id'];
        $check_symptoms = mysqli_query($con, "select distinct d.col from( select soreThroat as col from visitor where id='$visitor_id' union all select cough from visitor where id='$visitor_id' union all select lossOfSmell from visitor where id='$visitor_id' union all select bodyAches from visitor where id='$visitor_id' union all select fever from visitor where id='$visitor_id' union all select fever from visitor where id='$visitor_id' union all select redness from visitor where id='$visitor_id' union all select shortnessOfBreath from visitor where id='$visitor_id' union all select nausea from visitor where id='$visitor_id' union all select vomiting from visitor where id='$visitor_id' union all select diarrhea from visitor where id='$visitor_id' union all select weekness from visitor where id='$visitor_id' union all select contactWith from visitor where id='$visitor_id') d");
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
    $screened_distinct_visitor = mysqli_fetch_array($get_screened_visitors);
    $temp['totalScreened'] = intval($screened_distinct_visitor[0]);
    $temp['symptoticVisitors'] = intval($symptomatic_count);
    $temp['asymptoticVisitors'] = intval($asymptomatic_count);
}
else if ($_GET['report'] == '') {
    $report_type = 'Today';
    if ($_GET['is_owner'] == 'true') {
        $compId = $_GET['company_id'];
        $get_screened_visitors = mysqli_query($con, "select count(id) as total_vis_screened from visitor where date(dateCreated)='$date' and compId='$compId'");
        $get_symtomatic_visitor = mysqli_query($con, "select id as visitor_id from visitor where date(dateCreated)='$date' and compId='$compId'");
    } else {
        $get_screened_visitors = mysqli_query($con, "select count(id) as total_vis_screened from visitor where date(dateCreated)='$date'");
        $get_symtomatic_visitor = mysqli_query($con, "select id as visitor_id from visitor where date(dateCreated)='$date'");
    }
    while ($symtomatic_row = mysqli_fetch_array($get_symtomatic_visitor)) {
        $visitor_id = $symtomatic_row['visitor_id'];
        $check_symptoms = mysqli_query($con, "select distinct d.col from( select soreThroat as col from visitor where id='$visitor_id' union all select cough from visitor where id='$visitor_id' union all select lossOfSmell from visitor where id='$visitor_id' union all select bodyAches from visitor where id='$visitor_id' union all select fever from visitor where id='$visitor_id' union all select fever from visitor where id='$visitor_id' union all select redness from visitor where id='$visitor_id' union all select shortnessOfBreath from visitor where id='$visitor_id' union all select nausea from visitor where id='$visitor_id' union all select vomiting from visitor where id='$visitor_id' union all select diarrhea from visitor where id='$visitor_id' union all select weekness from visitor where id='$visitor_id' union all select contactWith from visitor where id='$visitor_id') d");
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
    $screened_distinct_visitor = mysqli_fetch_array($get_screened_visitors);
    $temp['totalScreened'] = intval($screened_distinct_visitor[0]);
    $temp['symptoticVisitors'] = intval($symptomatic_count);
    $temp['asymptoticVisitors'] = intval($asymptomatic_count);
} else if (isset($_GET['report']) && $_GET['report'] == 'today') {
    $report_type = 'Today';
    if ($_GET['is_owner'] == 'true') {
        $compId = $_GET['company_id'];
        $get_screened_visitors = mysqli_query($con, "select count(id) as total_vis_screened from visitor where date(dateCreated)='$date' and compId='$compId'");
        $get_symtomatic_visitor = mysqli_query($con, "select id as visitor_id from visitor where date(dateCreated)='$date' and compId='$compId'");
    } else {
        $get_screened_visitors = mysqli_query($con, "select count(id) as total_vis_screened from visitor where date(dateCreated)='$date'");
        $get_symtomatic_visitor = mysqli_query($con, "select id as visitor_id from visitor where date(dateCreated)='$date'");
    }
    while ($symtomatic_row = mysqli_fetch_array($get_symtomatic_visitor)) {
        $visitor_id = $symtomatic_row['visitor_id'];
        $check_symptoms = mysqli_query($con, "select distinct d.col from( select soreThroat as col from visitor where id='$visitor_id' union all select cough from visitor where id='$visitor_id' union all select lossOfSmell from visitor where id='$visitor_id' union all select bodyAches from visitor where id='$visitor_id' union all select fever from visitor where id='$visitor_id' union all select fever from visitor where id='$visitor_id' union all select redness from visitor where id='$visitor_id' union all select shortnessOfBreath from visitor where id='$visitor_id' union all select nausea from visitor where id='$visitor_id' union all select vomiting from visitor where id='$visitor_id' union all select diarrhea from visitor where id='$visitor_id' union all select weekness from visitor where id='$visitor_id' union all select contactWith from visitor where id='$visitor_id') d");
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
    $screened_distinct_visitor = mysqli_fetch_array($get_screened_visitors);
    $temp['totalScreened'] = intval($screened_distinct_visitor[0]);
    $temp['symptoticVisitors'] = intval($symptomatic_count);
    $temp['asymptoticVisitors'] = intval($asymptomatic_count);
} else if (isset($_GET['report']) && $_GET['report'] == 'week') {
    $report_type = 'This Week';
    if ($_GET['is_owner'] == 'true') {
        $compId = $_GET['company_id'];
        $get_screened_visitors = mysqli_query($con, "select count(id) as total_vis_screened from visitor where date(dateCreated)>='$previous_monday' and date(dateCreated)<'$next_monday'  and compId='$compId'");
        $get_symtomatic_visitor = mysqli_query($con, "select id as visitor_id from visitor where date(dateCreated)>='$previous_monday' and date(dateCreated)<'$next_monday'  and compId='$compId'");
    } else {
        $get_screened_visitors = mysqli_query($con, "select count(id) as total_vis_screened from visitor where date(dateCreated)>='$previous_monday' and date(dateCreated)<'$next_monday'");
        $get_symtomatic_visitor = mysqli_query($con, "select id as visitor_id from visitor where date(dateCreated)>='$previous_monday' and date(dateCreated)<'$next_monday'");
    }
    while ($symtomatic_row = mysqli_fetch_array($get_symtomatic_visitor)) {
        $visitor_id = $symtomatic_row['visitor_id'];
        $check_symptoms = mysqli_query($con, "select distinct d.col from( select soreThroat as col from visitor where id='$visitor_id' union all select cough from visitor where id='$visitor_id' union all select lossOfSmell from visitor where id='$visitor_id' union all select bodyAches from visitor where id='$visitor_id' union all select fever from visitor where id='$visitor_id' union all select fever from visitor where id='$visitor_id' union all select redness from visitor where id='$visitor_id' union all select shortnessOfBreath from visitor where id='$visitor_id' union all select nausea from visitor where id='$visitor_id' union all select vomiting from visitor where id='$visitor_id' union all select diarrhea from visitor where id='$visitor_id' union all select weekness from visitor where id='$visitor_id' union all select contactWith from visitor where id='$visitor_id') d");
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
    $screened_distinct_visitor = mysqli_fetch_array($get_screened_visitors);
    $temp['totalScreened'] = intval($screened_distinct_visitor[0]);
    $temp['symptoticVisitors'] = intval($symptomatic_count);
    $temp['asymptoticVisitors'] = intval($asymptomatic_count);
} else if (isset($_GET['report']) && $_GET['report'] == 'month') {
    $report_type = 'Month';
    if ($_GET['is_owner'] == 'true') {
        $compId = $_GET['company_id'];
        $get_screened_visitors = mysqli_query($con, "select count(id) as total_vis_screened from visitor where date(dateCreated)>='$first_date' and date(dateCreated)<='$last_date'  and compId='$compId'");
        $get_symtomatic_visitor = mysqli_query($con, "select id as visitor_id from visitor where date(dateCreated)>='$first_date' and date(dateCreated)<'$last_date'  and compId='$compId'");
    } else {
        $get_screened_visitors = mysqli_query($con, "select count(id) as total_vis_screened from visitor where date(dateCreated)>='$first_date' and date(dateCreated)<='$last_date'");
        $get_symtomatic_visitor = mysqli_query($con, "select id as visitor_id from visitor where date(dateCreated)>='$first_date' and date(dateCreated)<'$last_date'");
    }
    while ($symtomatic_row = mysqli_fetch_array($get_symtomatic_visitor)) {
        $visitor_id = $symtomatic_row['visitor_id'];
        $check_symptoms = mysqli_query($con, "select distinct d.col from( select soreThroat as col from visitor where id='$visitor_id' union all select cough from visitor where id='$visitor_id' union all select lossOfSmell from visitor where id='$visitor_id' union all select bodyAches from visitor where id='$visitor_id' union all select fever from visitor where id='$visitor_id' union all select fever from visitor where id='$visitor_id' union all select redness from visitor where id='$visitor_id' union all select shortnessOfBreath from visitor where id='$visitor_id' union all select nausea from visitor where id='$visitor_id' union all select vomiting from visitor where id='$visitor_id' union all select diarrhea from visitor where id='$visitor_id' union all select weekness from visitor where id='$visitor_id' union all select contactWith from visitor where id='$visitor_id') d");
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
    $screened_distinct_visitor = mysqli_fetch_array($get_screened_visitors);
    $temp['totalScreened'] = intval($screened_distinct_visitor[0]);
    $temp['symptoticVisitors'] = intval($symptomatic_count);
    $temp['asymptoticVisitors'] = intval($asymptomatic_count);
}

echo json_encode($temp);