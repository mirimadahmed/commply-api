<?php
include '../../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $company = $_POST['company'];
    $token = "";
    $notification = "1";
    $date_created=date("Y-m-d H:i:s");
    mysqli_query($con, "INSERT INTO `Owner`(`owner_email`, `owner_password`, `owner_firstname`, `owner_lastname`, `owner_token`, `notification`, `company_id`, `date_created`) VALUES ('$email','$password','$fname','$lname','$token','$notification','$company','$date_created')");
    $id = mysqli_insert_id($con);
    $get_owners = mysqli_query($con, "SELECT * FROM Owner WHERE owner_id ='$id'");
    $temp = array();
    while ($owner_row = mysqli_fetch_array($get_owners)) {
        $temp = $owner_row;
    }
    echo json_encode($temp);
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
