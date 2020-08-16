<?php
// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     header('Access-Control-Allow-Origin: http://localhost:8080');
//     header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
//     header('Access-Control-Allow-Headers: token, Content-Type');
//     die();
// }
// header('Access-Control-Allow-Origin: http://localhost:8080');
$con = mysqli_connect('localhost', 'root', '', 'gonxttec_commply');
// $con = mysqli_connect('localhost', 'gonxttec', 'Then1sawherface###', 'gonxttec_commply');
function utf8ize( $mixed ) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } elseif (is_string($mixed)) {
        return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
    }
    return $mixed;
}