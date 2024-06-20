<?php

ini_set('display_errors', 1);

//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

//include files
include_once("../config/database.php");
include_once("../classes/Users.php");
include_once("../jwt/token.php");

//objects
$db = new Database();
$connection = $db->connect();
$user_obj = new Users($connection);

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    //get token
    $headers = apache_request_headers();
    $token = $headers['Authorization'];
    // Secret key
    $secret_key = "qwe1234";
    // Verify token
    $payload = $user_obj->verify_token($token, $secret_key);

    // If the token is not valid or there is an error
    if (!$payload) {
        http_response_code(404);
        echo json_encode(array(
            "status" => 0,
            "message" => "Invalid token"
        ));
        exit(); // End process
    }

    $token = substr($token, 7);
    $user_arr_data = array(
        "userId" => $payload['userId'],
        "name" => $payload['name'],
        "email" => $payload['email']
    );

    http_response_code(200);
    echo json_encode(array(
        "status" => 1,
        "message" => "Get User successfully",
        "user" => $user_arr_data,
        "token" => $token
    ));

} else { // If the request method is not POST
    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}
