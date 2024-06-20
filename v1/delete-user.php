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

if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
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

    // If the user is deleted
    if ($user_obj->delete_user($payload['userId'])) {
        http_response_code(200);
        echo json_encode(array(
            "status" => 1,
            "message" => "User delete successful"
        ));
    } else { // If the user is not deleted
        http_response_code(500);
        echo json_encode(array(
            "status" => 0,
            "message" => "Failed to delete user"
        ));
    }
} else { // If the request method is not DELETE
    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}
