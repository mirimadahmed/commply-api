<?php
include '../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $vat = $_POST['vat'];
    $email = $_POST['email'];
    mysqli_query($con, "update Company set company_name='$name',company_address='$address',company_vat='$vat',company_email='$email' where company_id='$id'");
    $temp = array();
    $temp['error'] = 0;
    $temp['message'] = "Company Updated Successfully";
    echo json_encode($temp);
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
