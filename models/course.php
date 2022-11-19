<?php 
class Course{
    public $name;
    public $code;
    private $courses;
    public $connection;
    public $database;

    public function __construct($db)
    {    
        $this->connection = $db->connect();
        $this->database = $db;
        $this->getCourses();
    }
    public function addCourse(){
        $this->name = htmlspecialchars(strip_tags( $this->name));
        if($this->exists($this->name)){
            echo 'Course already exists';
        }else{
            $query = 'INSERT INTO courses SET course_name = :name;'; 

            //Prepare
            $stmt= $this->connection->prepare($query);
            $stmt->bindParam(':name', $this->name);

            $count = $stmt->execute();
            if($count){
                echo 'Course '. $this->name . ' added';
                return true;
            }else{ 
                return false;
            }   
        }
    }
    public function deleteCourse(){
        if($this->code){
            $query = 'DELETE FROM courses WHERE course_code = ' . $this->code;
            //Prepare
            $stmt = $this->connection->prepare($query);
            $result = $stmt->execute();
            if($result){
                echo 'Course was deleted.';
            }else{  
                echo 'Course could not be deleted.';
            }
        }
    }
    private function exists($value){
        foreach ($this->courses as $course){
            if($course['course_name'] == $value){
                return true;
            }else{
                return false;
            }
        }
    }
    public function getCourses(){
        try{
            $query = 'SELECT * FROM courses;';
            $this->courses = $this->connection->query($query);
            return $this->courses;
        }catch (Exception $ex ){
            echo $ex->getMessage();
            return false;
        }
    } 
}
?>