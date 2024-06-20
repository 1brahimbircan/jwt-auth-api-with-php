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
    if (!empty($data->name) && !empty($data->email) && !empty($data->password)) {

        $user_obj->name = $data->name;
        $user_obj->email = $data->email;
        $user_obj->user_id = uniqid('', true);
        $user_obj->password = password_hash($data->password, PASSWORD_DEFAULT);

        $email_data = $user_obj->check_email();

        // If the email is not empty
        if (!empty($email_data)) {
            http_response_code(500);
            echo json_encode(array(
                "status" => 0,
                "message" => "User already exists, try another email address"
            ));
        } else { // If the email is empty
            // If the user is created
            if ($user_obj->create_user()) {

                $secret_key = "qwe1234";
                $user_arr_data = array(
                    "userId" => $user_obj->user_id,
                    "name" => $user_obj->name,
                    "email" => $user_obj->email
                );
                $token = Token::Sign($user_arr_data, $secret_key, 60);

                http_response_code(200);
                echo json_encode(array(
                    "status" => 1,
                    "message" => "User has been registered successfully",
                    "user" => $user_arr_data,
                    "token" => $token
                ));
            } else {// If the user is not created
                http_response_code(500);
                echo json_encode(array(
                    "status" => 0,
                    "message" => "Failed to save user"
                ));
            }
        }
    } else { // If the data is empty
        http_response_code(500);
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
