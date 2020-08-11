<?php
include '../../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $get_declaration = mysqli_query($con, "SELECT * FROM Declaration where employee_id='$id'");
        $get_location_logs = mysqli_query($con, "SELECT * FROM location_logs where employee_id='$id'");
        $get_daily_checks = mysqli_query($con, "SELECT * FROM Daily_check where employee_id='$id'");
        $get_meetings = mysqli_query($con, "SELECT * FROM Meeting where employee_id = '$id'");
        $get_employee = mysqli_query($con, "select * from Employee where employee_id='$id'");
        $temp = array();
        $temp['declaration'] = array();
        $temp['location_logs'] = array();
        $temp['daily_checks'] = array();
        $temp['meetings'] = array();
        $temp['employee'] = array();
        while ($declaration = mysqli_fetch_array($get_declaration)) {
            array_push($temp['declaration'], $declaration);
        }
        while ($location_log = mysqli_fetch_array($get_location_logs)) {
            array_push($temp['location_logs'], $location_log);
        }
        while ($daily_check = mysqli_fetch_array($get_daily_checks)) {
            array_push($temp['daily_checks'], $daily_check);
        }
        while ($meeting = mysqli_fetch_array($get_meetings)) {
            $meeting_id = $meeting['meeting_id'];
            $meeters = array();
            $get_meeters = mysqli_query($con, "SELECT * FROM `Meeting_Persons` where meeting_id='$meeting_id'");
            while ($meeter = mysqli_fetch_array($get_meeters)) {
                array_push($meeters, $meeter['person_name']);
            }
            $meeting['meeters'] = $meeters;
            array_push($temp['meetings'], $meeting);
        }
        while ($employee = mysqli_fetch_array($get_employee)) {
            array_push($temp['employee'], $employee);
        }
        echo json_encode(utf8ize($temp));
    } else {
        $get_employees = mysqli_query($con, "select e.*,c.company_name as company_name from Employee e left outer join Company c on e.company_id=c.company_id");
        $temp = array();
        while ($employees_row = mysqli_fetch_array($get_employees)) {
            array_push($temp, $employees_row);
        }
        echo json_encode(utf8ize($temp));
    }
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
