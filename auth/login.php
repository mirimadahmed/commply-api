<?php
include '../connection.php';

if ($_POST['type'] === "owner") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $authenticate = mysqli_query($con, "select * from Owner where owner_email='$email' and owner_password='$password'");
    if (mysqli_num_rows($authenticate) > 0) {
        $result = mysqli_fetch_array($authenticate);
        $temp = array();
        $temp['email'] = $result['owner_email'];
        $temp['firstname'] = $result['owner_firstname'];
        $temp['company_id'] = $result['company_id'];
        $temp['is_owner'] = 'true';
        echo json_encode($temp);
    } else {
        $temp = array();
        $temp['error'] = 1;
        $temp['message'] = "User not found.";
        echo json_encode($temp);
    }
} else if ($_POST['type'] === "admin") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $authenticate = mysqli_query($con, "select * from admin where admin_email='$email' and admin_password='$password'");
    if (mysqli_num_rows($authenticate) > 0) {
        $result = mysqli_fetch_array($authenticate);
        $temp = array();
        $temp['email'] = $result['admin_email'];
        $temp['is_owner'] = 'false';
        $temp['firstname'] = $result['admin_firstname'];
        echo json_encode($temp);
    } else {
        $temp = array();
        $temp['error'] = 1;
        $temp['message'] = "User not found.";
        echo json_encode($temp);
    }
}