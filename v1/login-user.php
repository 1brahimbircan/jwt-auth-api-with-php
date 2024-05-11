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

    if (!empty($data->email) && !empty($data->password)) {

        $user_obj->email = $data->email;

        $user_data = $user_obj->check_login();

        if (!empty($user_data)) {

            $name = $user_data['name'];
            $email = $user_data['email'];
            $password = $user_data['password'];

            if (password_verify($data->password, $password)) {

                $secret_key = "qwe1234";
                $user_arr_data = array(
                    "id" => $user_data['id'],
                    "name" => $user_data['name'],
                    "email" => $user_data['email']
                );
                $token = Token::Sign($user_arr_data, $secret_key, 60);

                http_response_code(200);
                echo json_encode(array(
                    "status" => 1,
                    "message" => "User logged in successfully",
                    "token" => $token
                ));
            } else {
                http_response_code(404);
                echo json_encode(array(
                    "status" => 0,
                    "message" => "Invalid credentials"
                ));
            }
        } else {
            http_response_code(404);
            echo json_encode(array(
                "status" => 0,
                "message" => "Invalid credentials"
            ));
        }
    } else {
        http_response_code(404);
        echo json_encode(array(
            "status" => 0,
            "message" => "All data needed"
        ));
    }
}
