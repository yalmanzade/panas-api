<?php
    require_once '../models/email.php';
    require_once '../models/user.php';
    class Auth{
        public $db;
        public $generated_code;
        public $name;
        public $login_email;
        public $login_id;
        public $login_time;
        public $connection;
        public $table = 'auth';
        public $login_date ;

        public function __construct($db) {
            $currentDate = new DateTime();
            $this->db = $db;
            $this->login_date = $currentDate->format('Y-m-d');
            $this->connection = $db;
            $this->generated_code = rand(100000,999999); //DevSkim: ignore DS148264 until 2022-12-12 
        }
        public function authUser(){
            $query = 'INSERT INTO ' .$this->table . ' SET name = :name, generated_code = :generated_code,
                     login_email = :login_email';
            // Prepare statement
            $stmt = $this->connection->prepare($query);
            // Clean data
            $this->login_email = htmlspecialchars(strip_tags($this->login_email));
            $this->name = htmlspecialchars(strip_tags($this->name));
            // Bind data
            $stmt->bindParam(':login_email', $this->login_email);
            $stmt->bindParam(':generated_code', $this->generated_code);
            $stmt->bindParam(':name', $this->name);
            try{
                $email = new Email();
                // Execute query
                if($stmt->execute() && $email->SendAuthEmail($this->name, $this->generated_code)) {
                    return $stmt;
                }else{
                    echo "Error: %s.\n", $stmt->error;
                    return false;
                }
            }catch (Exception $ex){
                echo 'There has been an error: '.$ex->getMessage();
            }
    }
    private function registerUser(){
        $student = new Student($this->db);
        $student->name = $this->name;
        $student->email = $this->login_email;
        if($student->registerUser()){
            echo "User $student->name was registered.\n";
            return true;
        }else{
            echo "User could not be registered.\n";
            return false;
        }
    }
    public function confirmCode(){
        $this->connection = $this->db->connect();
        $query = 'SELECT * FROM auth WHERE generated_code = :code' ;
        $stmt = $this->connection->prepare($query);
        //Clean Data
        $this->generated_code = htmlspecialchars(strip_tags($this->generated_code));
        //Bind Data
        $stmt->bindParam(':code',$this->generated_code);
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($this->generated_code == $row["generated_code"]){
                if($row){
                    return $row;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }

    }
}