<?php
use FFI\Exception;
require_once 'user.php';
require_once 'email.php';
class Meeting{
    private $db;
    private $connection;
    public $id;
    public $hour;
    public $minute;
    public $section;
    public $confirmed;
    public $action;
    public $place;
    public $date;
    public $day;
    public $time;
    public $studentId;
    public $tutorId;
    public $tutorEmail;
    public $table = 'meetings';

    public function __construct($db){
        $this->db = $db;
    }
    public function getCourses(){
        try{   
            $query = 'SELECT * FROM tutors;';
            $this->connection = $this->db->connect();
            $stmt = $this->connection->prepare($query);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
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
    public function postMeeting(){
        try{
            $this->id = random_int(10000000,99999999);
            $this->connection = $this->db->connect();
            $query = 'INSERT INTO ' .$this->table .' SET meeting_id = :id, date = :date,
            student_id = :studentId, tutor_id = :tutorId, hour= :hour,
            minute = :minute, time = :time, section = :sec;';
            //Prepare Data
            $stmt = $this->connection->prepare($query);
            //Get TutorId
            if($this-> getTutorId()){
                // echo 'Tutor Id is: ' .$this->tutorId;
            }else{
                echo 'Could not get ID at Meeting.php';
                exit;
            }
            //Clean Data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->hour = htmlspecialchars(strip_tags($this->hour));
            $this->minute = htmlspecialchars(strip_tags($this->minute));
            $this->section = htmlspecialchars(strip_tags($this->section));
            $this->date = htmlspecialchars(strip_tags($this->date));
            $this->studentId = htmlspecialchars(strip_tags($this->studentId));
            $this->tutorId = htmlspecialchars(strip_tags($this->tutorId));
            $this->time = htmlspecialchars(strip_tags($this->time));
            //Bind data
            $stmt->bindParam(':id', $this->id);            
            $stmt->bindParam(':date', $this->date);            
            $stmt->bindParam(':studentId', $this->studentId);            
            $stmt->bindParam(':tutorId', $this->tutorId);            
            $stmt->bindParam(':hour', $this->hour);            
            $stmt->bindParam(':minute', $this->minute);            
            $stmt->bindParam(':time', $this->time);            
            $stmt->bindParam(':sec', $this->section);            
            $email = new Email();
            $mymeeting = $this;
            if($stmt->execute()&& $email->SendMeetingConfirmation($mymeeting)&&$email->SendTutorMeetingConfirmation($mymeeting)){
                return $stmt;
            }else{
                echo "Error: %s.\r", $stmt->errorInfo()[0];
                return false;
            }

        }catch (Exception $ex){
            echo 'Error: ' .$ex->getMessage();
        }finally{
            $this->connection = null;

        }
    }
    public function getTutorId(){
        try{
            $user = new User($this->db);
            $user->email = $this->tutorEmail;
            $result = $user->getUser('tutors');
            $this->tutorId = $result['tutor_id'];
            if(!empty($this->tutorId)){
                return true;
            }else{
                return false;
            }
        }catch(Exception $ex){
            echo 'Error: '.$ex;
        }finally{
            $user = null;
        }
    }
    public function getMeeting(){
        if($this->id){
            try{
                $query = 'SELECT * FROM meetings WHERE meeting_id = :id;';
                $this->connection = $this->db->connect();
                $stmt = $this->connection->prepare($query);
                //Clean data
                $this->time = htmlspecialchars(strip_tags($this->time));
                //Bind Data
                $stmt->bindParam(':id', $this->id);
                if($stmt->execute()){
                    $row = $stmt->fetch();
                    if($row){
                        $this->date = $row['date'];
                        $this->hour = $row['hour'];
                        $this->minute = $row['minute'];
                        $this->section = $row['section'];
                        $this->studentId = $row['student_id'];
                        $this->time = $row['time'];
                        $this->tutorId = $row['tutor_id'];
                    }else{
                        echo 'Could not retrieve meeting. Please try again.';
                    }
                }else{
                    echo 'Failed to fetch Meeting.';
                    return false;
                }   
            }catch(Exception $ex){
                echo 'Error: '.$ex->getMessage();
                return false;
            }finally{
                $this->connection = null;
            }
        }else{
            echo 'There is no id: '. $this->id;
        }
    }
    public function modifyMeeting(){
        try{
            if($this->id){
                $query = 'UPDATE meetings SET time=?, date=?, hour=?, minute=? WHERE meeting_id=? ;';
                $this->connection = $this->db->connect();
                $stmt = $this->connection->prepare($query);
                //Bind Data
                if($stmt->execute([$this->time,$this->date,$this->hour,$this->minute,$this->id])){
                    return true;
                }else{
                    return false;
                }
            }
        }catch(Exception $ex){
            echo 'Error: '.$ex->getMessage();
            return false;
        }finally{
            $this->connection = null;
        }
    }
    public function confirmMeeting(){
        try{
            if($this->id){
                $query = 'UPDATE meetings SET confirmed=? WHERE meeting_id=? ;';
                $this->connection = $this->db->connect();
                $stmt = $this->connection->prepare($query);
                //Bind Data
                if($stmt->execute([1,$this->id])){
                    return true;
                }else{
                    return false;
                }
            }
        }catch(Exception $ex){
            echo 'Error: '.$ex->getMessage();
            return false;
        }finally{
            $this->connection = null;
        }
    }
    public function deleteMeeting(){
        try{
            if($this->id){
                $query = 'DELETE from meetings WHERE meeting_id = :id;';
                $this->connection = $this->db->connect();
                $stmt = $this->connection->prepare($query);
                //Bind Data
                $stmt->bindParam(':id', $this->id);
                if($stmt->execute()){
                    return true;
                }else{
                    return false;
                }
            }
        }catch(Exception $ex){
            echo 'Error: '.$ex->getMessage();
            return false;
        }finally{
            $this->connection = null;
        }
    }
    public function convertTime($hours,$minutes,$seconds,$meridiem){
        $hours = sprintf('%02d',(int) $hours);
        $minutes = sprintf('%02d',(int) $minutes);
        $seconds = sprintf('%02d',(int) $seconds);
        $meridiem = (strtolower($meridiem)=='am') ? 'am' : 'pm';
        return date('H:i:s', strtotime("{$hours}:{$minutes}:{$seconds} {$meridiem}"));
    }
}