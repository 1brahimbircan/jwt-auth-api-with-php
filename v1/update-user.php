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

if ($_SERVER['REQUEST_METHOD'] === "PATCH") {

    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->name) && !empty($data->email) && !empty($data->password)) {

        $user_obj->name = $data->name;
        $user_obj->email = $data->email;
        $user_obj->password = password_hash($data->password, PASSWORD_DEFAULT);

        // Token'ı al
        $headers = apache_request_headers();
        $token = $headers['Authorization'];
        // Secret key
        $secret_key = "qwe1234";
        // Token'ı doğrula
        $payload = $user_obj->verify_token($token, $secret_key);
    
        // Eğer token geçerli değilse veya bir hata varsa
        if (!$payload) {
            http_response_code(404);
            echo json_encode(array(
                "status" => 0,
                "message" => "Invalid token"
            ));
            exit(); // İşlemi sonlandır
        }

        if ($user_obj->update_user($payload['id'])) {
            http_response_code(200);
            echo json_encode(array(
                "status" => 1,
                "message" => "User update successful"
            ));
        } else {
            http_response_code(500);
            echo json_encode(array(
                "status" => 0,
                "message" => "Failed to update user"
            ));
        }
    } else {
        http_response_code(500);
        echo json_encode(array(
            "status" => 0,
            "message" => "All data needed"
        ));
    }
} else {
    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}
