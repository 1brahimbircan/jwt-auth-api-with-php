<?php 

class Database{
    // veriable declaration
    private $hostname;
    private $dbname;
    private $username;
    private $password;
    private $conn;

    public function connect(){
        // veriable initialization
        $this->hostname = "localhost";
        $this->dbname = "api_db";
        $this->username = "root";
        $this->password = "";

        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
        if($this->conn->connect_error){
            // if connection failed
            print_r($this->conn->connect_error);
            exit;
        }else{
            // if connection success
            return $this->conn;
        }
    }
}


?>