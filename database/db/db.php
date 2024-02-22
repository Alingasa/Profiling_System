<?php

class Db{
  protected $conn;
  protected $servername = 'localhost';
  protected $username = 'root';
  protected $password = '';
  public $dbName = 'profiling_system';

  public function db_connection(){
    $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName);
    if($this->conn->error){
      return json_encode(
        [
          'message' => 'Connection Failed'
        ]
        );
    }else{
      return json_encode(
        [
          'message' => 'Successfully Connected'
        ]
        );
    }
  }
}

?>