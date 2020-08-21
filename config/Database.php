<?php
class Database {
  private $host = 'localhost';
  private $db_name = 'kupihitro';

  private $username = 'root';
  private $password = 'Mokorel1';
  public $conn;

  public function connect(){
    $this->conn = null;

    try{
      $dsn = 'mysql:dbname=' . $this->db_name . ';mysql:host=' . $this->host;
      $this->conn = new PDO($dsn, $this->username, $this->password);
    } catch(PDOException $e){
      echo 'Napaka v povezovanju' . '<br>';
      echo $e->getMessage();
    }
    return $this->conn;
  }
}