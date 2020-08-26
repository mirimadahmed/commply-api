<?php
include '../../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_name = '';
    $emp = array();
    $emp_before_10_min_array = array();
    $emp_after_10_min_array = array();
    $emp_meeting_array = array();
    $emp_meeting_person_array = array();
    if (isset($_POST['employee_number'])) {
        $emp_number = $_POST['employee_number'];
        $date = $_POST['date'];
        $simple_date = date("Y-m-d", strtotime($date));
        $date_for_before = date("Y-m-d H:i:s", strtotime("+1 minutes", strtotime($date)));
        $date_for_after = date("Y-m-d H:i:s", strtotime($date));
        $date_10_min_before = date("Y-m-d H:i:s", strtotime("-10 minutes", strtotime($date)));
        $date_10_min_after = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($date)));
        $get_emp = mysqli_query($con, "select * from Employee where employee_id_number='$emp_number' or employee_number='$emp_number'");
        if (mysqli_num_rows($get_emp) > 0) {
            $result = mysqli_fetch_array($get_emp);
            $emp_name = $result['employee_firstname'];
            $emp = $result;
            $emp_last_name = $result['employee_lastname'];
            $emp_telephone = $result['employee_telephone'];
            $emp_id = $result['employee_id'];
            $emp_company = $result['company_id'];
            $get_company_emp_earlier = mysqli_query($con, "select * from Daily_check where company_id='$emp_company' and date_created>='$date_10_min_before' and date_created<='$date_for_before'");
            if (mysqli_num_rows($get_company_emp_earlier) > 0) {
                while ($row = mysqli_fetch_array($get_company_emp_earlier)) {
                    $id = $row['employee_id'];
                    $get_emp = mysqli_query($con, "select * from Employee where employee_id='$id'");
                    if (mysqli_num_rows($get_emp) > 0) {
                        $result = mysqli_fetch_array($get_emp);
                        $emp_before_10_min_array[] = $result;
                    }
                }
            }
            $get_company_emp_after = mysqli_query($con, "select * from Daily_check where company_id='$emp_company' and date_created<='$date_10_min_after' and date_created>='$date_for_after'");
            if (mysqli_num_rows($get_company_emp_after) > 0) {
                while ($row = mysqli_fetch_array($get_company_emp_after)) {
                    $id = $row['employee_id'];
                    $get_emp = mysqli_query($con, "select * from Employee where employee_id='$id'");
                    if (mysqli_num_rows($get_emp) > 0) {
                        $result = mysqli_fetch_array($get_emp);
                        $emp_after_10_min_array[] = $result;
                    }
                }
            }
            $get_employee_meeting = mysqli_query($con, "SELECT m.*,c.company_name FROM `Meeting` m left outer join Company c on m.company_id=c.company_id where date(m.date_created)='$simple_date' and m.employee_id='$emp_id'");
            if (mysqli_num_rows($get_employee_meeting) > 0) {
                while ($meeting_row = mysqli_fetch_array($get_employee_meeting)) {
                    $array = array("company_name" => $meeting_row['company_name'], "admin_id" => $meeting_row['admin_id']);
                    $emp_meeting_array[] = $array;
                }
            }
            $get_employee_meeting_person = mysqli_query($con, "SELECT * FROM `Meeting_persons` where (person_name='$emp_name' OR person_name='$emp_last_name' OR person_phone='$emp_telephone')");
            if (mysqli_num_rows($get_employee_meeting_person) > 0) {
                while ($meeting_person_row = mysqli_fetch_array($get_employee_meeting_person)) {
                    $array = array("person_name" => $meeting_person_row['person_name'], "person_phone" => $meeting_person_row['person_phone']);
                    $emp_meeting_person_array[] = $array;
                }
            }

            $temp = array(
                'error' => 0,
                'employee' => $emp,
                'before10' => $emp_before_10_min_array,
                'after10' => $emp_after_10_min_array,
                'empMeeting' => $emp_meeting_array,
                'empMeetingPerson' => $emp_meeting_person_array,
            );
            echo json_encode($temp);
        } else {
            $temp = array();
            $temp['error'] = 1;
            $temp['message'] = "Employee not found";
            echo json_encode($temp);
        }
    }
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
