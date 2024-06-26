<?php

class Users
{

    public $user_id;
    public $name;
    public $email;
    public $password;
    public $created_at;

    private $conn;
    private $users_table;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->users_table = "kullanicilar";
    }

    // Create user
    public function create_user()
    {
        $user_query = "INSERT INTO " . $this->users_table . " SET user_id = ? , name = ? , email = ? , password = ? , created_at = now()";

        $user_obj = $this->conn->prepare($user_query);

        $user_obj->bind_param("ssss", $this->user_id ,$this->name, $this->email, $this->password);

        if ($user_obj->execute()) {
            return true;
        }
        return false;
    }

    // Check email
    public function check_email()
    {
        $email_query = "SELECT * FROM " . $this->users_table . " WHERE email = ?";

        $user_obj =  $this->conn->prepare($email_query);

        $user_obj->bind_param("s", $this->email);

        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }

        return array();
    }

    // Verify token
    public function verify_token($token, $secret_key)
    {
        $token = substr($token, 7); // Remove bearer
        try {
            $payload = Token::Verify($token, $secret_key);
            return $payload;
        } catch (Exception $e) {
            return null; // Return null if token is not valid or an error occurs
        }
    }

    // Update user
    public function update_user($userId)
    {
     
        $user_query = "UPDATE " . $this->users_table . " SET name = ?, email = ?, password = ? WHERE user_id = ?";

        $user_obj = $this->conn->prepare($user_query);

 
        $user_obj->bind_param("ssss", $this->name, $this->email, $this->password, $userId);

        
        if ($user_obj->execute()) {
            return true;
        }
        return false;
    }

    // Delete user
    public function delete_user($userId)
    {
        $user_query = "DELETE FROM " . $this->users_table . " WHERE user_id = ?";

        $user_obj = $this->conn->prepare($user_query);

        $user_obj->bind_param("s", $userId);

        if ($user_obj->execute()) {
            return true;
        }
        return false;
    }
}
