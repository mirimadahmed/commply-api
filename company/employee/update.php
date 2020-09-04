<?php
include '../../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_id = $_POST['id'];
    $edit_emp_id_num = $_POST['newid'];
    $fname = $_POST['firstname'];
    $mname = $_POST['middlename'];
    $lname = $_POST['lastname'];
    $job = $_POST['job'];
    $emp_num = $_POST['number'];
    $emp_tel = $_POST['tel'];
    $man_id = $_POST['manager'];
    $company = $_POST['company'];
    $token = "";
    $notification = "1";
    $date_created=date("Y-m-d H:i:s");
    mysqli_query($con, "UPDATE `Employee` SET `employee_id_number`='$edit_emp_id_num',`employee_firstname`='$fname',`employee_middlename`='$mname',`employee_lastname`='$lname',`employee_job`='$job',`employee_number`='$emp_num',`employee_telephone`='$emp_tel',`employee_token`='',`manager_id`='$man_id',`company_id`='$company',`date_created`='$date_created' WHERE employee_id='$emp_id'");
    $temp = array();
    $temp['error'] = 0;
    $temp['message'] = "Employee updated successfully";
    echo json_encode($temp);
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
