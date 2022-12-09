<?php
class User {
    public $name;
    public $email;
    public $id;
    public $membersince;
    public $connection;
    public $db;
    public $isTutor = false;
    public $userType;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function confirmUser($table){
        try{
            $this->connection = $this->db->connect();
            // $query = 'SELECT * FROM ' .$table. ' WHERE email = ' . $this->email . ';';
            $query = 'UPDATE ' .$table. ' SET email_confirmed = :code'. ' WHERE email = :email';
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':email', $this->email);
            $code = "1";
            $stmt->bindParam(':code', $code);
            $result =$stmt->execute();
            if($result){
                return true;
            }else{
                return false;
            }
        }catch(Exception $ex){
            echo $ex->getMessage();
            return false;
        }finally{
            $this->connection = null;
        }
    }
    public function exists($table){
        try{
            $this->connection = $this->db->connect();
            // $query = 'SELECT * FROM ' .$table. ' WHERE email = ' . $this->email . ';';
            $query = 'SELECT * FROM ' .$table. ' WHERE email = :email';
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':email', $this->email);
            $count =$stmt->fetchAll(PDO::FETCH_ASSOC);
            if($count > 0){
                return $table;
            }else{
                return false;
            }
        }catch(Exception $ex){
            echo $ex->getMessage();
            return false;
        }finally{
            $this->connection = null;
        }
    }
    public function getUser($table){
        try{
            $this->connection = $this->db->connect();
            $query = 'SELECT * FROM ' .$table. ' WHERE email = :email';
            // echo $query;
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':email', $this->email);
            // echo $query;
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                if(!$result){
                    return false;
                }
                return $result[0];
            }else{
                return false;
            }
        }catch(Exception $ex){
            echo $ex->getMessage();
            return false;
        }finally{
            $this->connection = null;
        }
    }
}
class Tutor extends User{
    public $meetingdays = array();
    public $meetingtimes = array();
    public $classlist = array();
    public $tutortable = 'tutors';
    public $teachestable = 'teaches';
    public $availabletable = 'available';
    public $coursecode = 0;
    public $tutorId = 0;
    public $error = False;

    public function __construct($db){
        $this->meetingdays = array();
        $this->meetingtimes = array();
        $this->classlist = array();
        $this->db = $db;
        $this->connection = $db;
    }
    public function getallTutors(){ 
        try{
            $query = "SELECT * FROM tutors";
            $this->connection = $this->db->connect();
            $result = $this->connection->query($query);
            if($result){
                return $result;
            }else{
                return false;
            }
        }catch(Exception $ex){
            echo "Error: " .$ex->getMessage();
        }finally{
            $this->db = null;
            $this->connection = null;
        }
    }
    public function deleteTutor(){
        try{
            $query = "DELETE FROM tutors WHERE tutor_id = :id";
            $this->connection = $this->db->connect();
            //Prepare Statement
            $stmt = $this->connection->prepare($query);
            //Bind Data
            $stmt->bindParam(':id', $this->id);
            $result = $stmt->execute();
            if($result){
                return $result;
            }else{
                return false;
            }
        }catch(Exception $ex){
            echo "Error: " .$ex->getMessage();
        }finally{
            $this->db = null;
            $this->connection = null;
        }
    } 
    public function registerTutor(){
        try{
            $this->connection = $this->connection->connect();
            $query = 'INSERT INTO '. $this->tutortable. ' SET name = :name,
                    email = :email, available = :available, courses = :courses, meetingdays = :meetingdays;';
            $stmt = $this->connection->prepare($query);

            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->name = htmlspecialchars(strip_tags($this->name));

            $this->prepareJson();
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':available', $this->meetingtimes);
            $stmt->bindParam(':courses', $this->classlist);
            $stmt->bindParam(':meetingdays', $this->meetingdays);

            // echo $query;
            // Execute query
            if($stmt->execute() && $this->error == False) {
                return $stmt;
            }else{
                echo "Error: %s.\n", $stmt->error;
                $this->error = True;
                return false;
            }     
        }catch (Exception $ex ){
            echo $ex->getMessage();
            return false;
        }finally{
            $stmt = null;
            $this->connection = null;
        }
    } 
    private function postClasses($course, $tutorid){
        try{
            $query = 'INSERT INTO teaches SET course_name = :coursename, tutor_id = :tutorid,
                    course_code = :coursecode;';
            $stmt = $this->connection->prepare($query);
            $this->coursecode = $this->getCourseCode($course);
            
            $stmt->bindParam(':course_name', $this->$course);
            $stmt->bindParam(':tutor_id', $this->$tutorid);
            $stmt->bindParam(':course_code', $this->coursecode);

            // Execute query
            if($stmt->execute() && $this->error == False) {
                return $stmt;
            }else{
                echo "Error: %s.\n", $stmt->error;
                $this->error = True;
                return false;
            }   

        }catch (Exception $ex ){
            echo $ex->getMessage();
            $this->error = True;
            return false;
        }
    }
    private function getTutorId(){
        try{
            $sql = 'SELECT tutor_id, email  FROM tutors WHERE is_active = 0';
            $result = $this->connection->query($sql);
            foreach( $result as $row){
                if($this->email == $row['email']){
                    $this->tutorId = $row['tutor_id'];
                }else{
                    $this->error = True; 
                    return False;
                }
            }
        }catch (Exception $ex ){
            echo $ex->getMessage();
            $this->error = True;
            return false;
        }
    }
    private function getCourseCode($course){
        switch ($course) {
            case "Skills":
                return 100;
            case "Reading":
                return 200;
            case "Writing":
                return 300;
            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }    
    }
    private function prepareJson(){
        $this->meetingdays = json_encode($this->meetingdays);
        $this->meetingtimes = json_encode($this->meetingtimes);
        $this->classlist = json_encode($this->classlist);
    }
}
class Student extends User{
    private $studentTable = 'student';
    private $error = false;
    public function __construct($db){
        $this->db = $db;
    }
    public function getUserName(){
        return $this->name;
    }
    public function registerUser(){
        try{
            $this->connection = $this->db->connect();
            $query = 'INSERT INTO '. $this->studentTable. ' SET student_id = :id, name = :name, email = :email;';
            $stmt = $this->connection->prepare($query);
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':email', $this->email);
            // Execute query
            if($stmt->execute() && $this->error == False) {
                return $stmt;
            }else{
                echo "Error: %s.\n", $stmt->error;
                $this->error = True;
                return false;
            }     
        }catch (Exception $ex ){
            echo $ex->getMessage();
            $this->error = true;
            return False;
        }finally{
            $this->connection = null;
        }
    }
    public function studentExists2(){
        try{
            $this->connection = $this->db->connect();
            $query = 'SELECT * FROM ' .$this->studentTable. " WHERE email = " . ' "' . "$this->email" . '"';
            $count = $this->connection->query($query);
            $count = $count->fetchColumn();
            if($count > 0){
                echo "Student $this->name exists";
                return true;
            }else{
                return false;
            }
        }catch(Exception $ex){
            echo $ex->getMessage();
            return false;
        }finally{
            $this->connection = null;
        }
    }
    public function studentExists(){
        try{
            $this->connection = $this->db->connect();
            $query = 'SELECT * FROM student WHERE email = ?';
            $stmt = $this->connection->prepare($query);
            $this->email = strip_tags($this->email);
            $stmt->bindValue(1, $this->email, PDO::PARAM_STR);
            $stmt->execute();            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);            
            if($result){
                $count = count($result);
                if($count > 0){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }catch(Exception $ex){
            echo $ex->getMessage();
            return false;
        }finally{
            $this->connection = null;
        }
    }
}

