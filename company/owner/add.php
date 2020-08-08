<?php
include '../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $company = $_POST['company'];
    $token = "";
    $notification = "1";
    mysqli_query($con, "INSERT INTO `Owner`(`owner_email`, `owner_password`, `owner_firstname`, `owner_lastname`, `owner_token`, `notification`, `company_id`, `date_created`) VALUES ('$email','$password','$fname','$lname','$token','$notification','$company','$date_created')");
    $temp = array();
    $temp['error'] = 0;
    $temp['message'] = "Owner added successfully";
    echo json_encode($temp);
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
