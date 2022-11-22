<?php 
  class Database {
    // DB Params
    private $host = 'localhost';
    private $db_name = 'panas';
    private $username = 'panas';
    private $password = '1234';
    private $conn;

    // DB Connect
    public function connect() {
      $this->conn = null;
      try { 
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
        // $vars = ['error' => 'Data',
        //         'return' => 'login'];
        // $param = http_build_query($vars);
        // header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
        // exit;
      }
      return $this->conn;
    }
  }