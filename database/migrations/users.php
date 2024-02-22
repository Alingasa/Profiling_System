<?php
include '../db/db.php';
header('Content-type: application/json; charset=UTF-8');

class Users extends Db {
    public $tableName = 'users';

    public function createTable() {
        $this->db_connection();

        $createTable = $this->conn->query("CREATE TABLE IF NOT EXISTS $this->tableName (
            id int auto_increment primary key,
            first_name varchar(255) not null,
            last_name varchar(255) not null,
            email varchar(255) not null UNIQUE,
            password varchar(255) not null
        ) engine=InnoDB");

        if ($createTable) {
            return json_encode(['message' => 'table successfully created!']);
        } else {
            return json_encode(['message' => 'table failed to create']);
        }
    }

    public function registerUser($params) {
      if($_SERVER['REQUEST_METHOD'] != 'POST'){
        return json_encode(
          [
    
              "message" => "POST method is only allowed!"
          ]
          );
      }
        $firstName = $params['first_name'];
        $lastName = $params['last_name'];
        $email = $params['email'];
        $password = $params['password'];

        if(strlen($password) < 8) {
          return json_encode([
              'message' => 'Password must be at least 8 characters'
          ]);
      }

        $Checkemail = $this->conn->query("SELECT * FROM $this->tableName WHERE email ='$email'");
        if($Checkemail->num_rows > 0){
          return json_encode([
            'message' => 'Email Already Exists'
          ]);
        }
   

        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $sql = $this->conn->query("INSERT INTO $this->tableName (first_name, last_name, email, password) 
                VALUES ('$firstName', '$lastName', '$email', '$hashPassword')");

        if($sql) {
          
            header("Location: http://localhost//laravel-Projects/Second_Semester/Profiling_System/dashboard/dashboard.html");
       
        } else {
          return json_encode(
            [
              'message' => 'failed!'
            ]
            );
        }
    }
    public function login($params) {
      $Email = $params['email'];
      $Password = $params['password'];

      if(strlen($Password) < 8) {
        return json_encode([
            'message' => 'Password must be at least 8 characters'
        ]);
    }
      $sql = "SELECT * FROM $this->tableName WHERE email='$Email'";
      $result = $this->conn->query($sql);

      if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if(password_verify($Password, $user['password'])){
          header("Location: http://localhost//laravel-Projects/Second_Semester/Profiling_System/dashboard/dashboard.html");
        }else{
          return json_encode([
            'message' => 'Wrong Password'
          ]);
        }
      } else {
          return json_encode(
            [
              'message' => 'Invalid Email'
            ]
            );
      }
  }

  public function Logout(){
    session_start();

  
    $_SESSION = array();

  
    session_destroy();

 
    header("Location: http://localhost//laravel-Projects/Second_Semester/Profiling_System/public/index.html");
  }
}
$new = new Users();
$new->createTable();


?>
