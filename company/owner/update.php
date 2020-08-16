<?php
include '../../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $owner_id = $_POST['id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $company = $_POST['company'];
    $token = "";
    $notification = "1";
    $date_created=date("Y-m-d H:i:s");
    mysqli_query($con, "UPDATE `Owner` SET `owner_email`='$email',`owner_password`='$password',`owner_firstname`='$fname',`owner_lastname`='$lname',`owner_token`='$token',`notification`='$notification',`company_id`='$company',`date_created`='$date_created' WHERE owner_id='$owner_id'");
    $temp = array();
    $temp['error'] = 0;
    $temp['message'] = "Owner updated successfully";
    echo json_encode($temp);
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
