<?php

class Users{

    public $name;
    public $email;
    public $password;
    public $created_at;
    
    private $conn;
    private $users_table;

    public function __construct($db){
        $this->conn = $db;
        $this->users_table = "kullanicilar";
    }

    public function create_user(){
        $user_query = "INSERT INTO " . $this->users_table . " SET name = ? , email = ? , password = ? , created_at = now()";

        $user_obj = $this->conn->prepare($user_query);

        $user_obj->bind_param("sss", $this->name, $this->email, $this->password);

        if($user_obj->execute()){
            return true;
        }
        return false;
    }

    public function check_email(){
        $email_query = "SELECT * FROM " . $this->users_table . " WHERE email = ?";

        $user_obj =  $this->conn->prepare($email_query);

        $user_obj->bind_param("s", $this->email);

        if($user_obj->execute()){
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }

        return array();
    }

}

?>