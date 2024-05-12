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

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data = json_decode(file_get_contents("php://input"));

    // Check if the data is not empty
    if (!empty($data->email)) {

        $user_obj->email = $data->email;

        $user_data = $user_obj->get_user_by_email();

        // If the user is not empty
        if (!empty($user_data)) {

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

            $user_arr_data = array(
                "id" => $user_data['id'],
                "name" => $user_data['name'],
                "email" => $user_data['email']
            );

            http_response_code(200);
            echo json_encode(array(
                "status" => 1,
                "message" => "Get User successfully",
                "user" => $user_arr_data
            ));
        } else { // If the user is empty
            http_response_code(404);
            echo json_encode(array(
                "status" => 0,
                "message" => "Invalid user"
            ));
        }
    } else { // If the data is empty
        http_response_code(404);
        echo json_encode(array(
            "status" => 0,
            "message" => "All data needed"
        ));
    }
} else { // If the request method is not POST
    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}
