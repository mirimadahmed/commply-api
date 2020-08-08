<?php
include '../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id_number = $_POST['id'];
    $fname = $_POST['firstname'];
    $mname = $_POST['middlename'];
    $lname = $_POST['lastname'];
    $job = $_POST['job'];
    $emp_num = $_POST['num'];
    $emp_tel = $_POST['tel'];
    $man_id = $_POST['manager'];
    $company = $_POST['company'];
    $token = "";
    $notification = "1";
    mysqli_query($con, "INSERT INTO `Employee`(`employee_id_number`, `employee_firstname`, `employee_middlename`, `employee_lastname`, `employee_job`, `employee_number`, `employee_telephone`, `employee_token`, `manager_id`, `company_id`, `date_created`) VALUES ('$employee_id_number','$fname','$mname','$lname','$job','$emp_num','$emp_tel','','$man_id','$company','$date_created')");
    $temp = array();
    $temp['error'] = 0;
    $temp['message'] = "Employee added successfully";
    echo json_encode($temp);
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
