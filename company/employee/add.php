<?php
include '../../connection.php';
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
    $subsidary = $_POST['subsidary'];
    $token = "";
    $notification = "1";
    $date_created=date("Y-m-d H:i:s");
    $result = mysqli_query($con, "INSERT INTO `Employee`(`employee_id_number`, `employee_firstname`, `employee_middlename`, `employee_lastname`, `employee_job`, `employee_number`, `employee_telephone`, `employee_token`, `manager_id`, `company_id`, `subsidary`, `date_created`) VALUES ('$employee_id_number','$fname','$mname','$lname','$job','$emp_num','$emp_tel','','$man_id','$company', '$subsidary','$date_created')");
    if($result) {
        $temp = array();
        $temp['error'] = 0;
        $temp['message'] = "Employee added successfully";
        $id = mysqli_insert_id($con);
        $employees = mysqli_query($con, "select e.*,c.company_name as company_name from Employee e left outer join Company c on e.company_id=c.company_id where e.employee_id='$id'");
        while($employee = mysqli_fetch_array($employees)) {
            $temp['employee'] = $employee;
        }
        echo json_encode($temp);
    } else {
        $temp = array();
        $temp['error'] = 1;
        $temp['message'] = "Could not add employee";
        echo json_encode($temp);
    }
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
