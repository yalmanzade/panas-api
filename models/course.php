<?php 
class Course{
    public $name;
    public $code;
    private $courses;
    public $connection;
    public $database;
    public function __construct($db)
    {    
        // $this->connection = $db->connect();
        $this->database = $db;
        $this->getCourses();
    }
    public function addCourse(){
        try{
            $this->connection = $this->database->connect();
            $this->name = htmlspecialchars(strip_tags( $this->name));
            if($this->exists($this->name)){
                echo 'Course already exists';
            }else{
                $query = 'INSERT INTO courses SET course_name = :name;'; 
                //Prepare
                $stmt= $this->connection->prepare($query);
                //Clean data
                $this->name = htmlspecialchars(strip_tags($this->name));
                //Bind data
                $stmt->bindParam(':name', $this->name);
                $count = $stmt->execute();
                if($count){
                    echo 'Course '. $this->name . ' added';
                    return true;
                }else{ 
                    return false;
                }   
            }
        }catch (Exception $ex){
            print("Error: ". $ex->getMessage());
        }finally{
            $this->connection = null;
        }
    }
    public function deleteCourse(){
        try{
		    $this->connection = $this->database->connect();
            if($this->code){
                $query = 'DELETE FROM courses WHERE course_code = ' . $this->code;
                //Prepare
                $stmt = $this->connection->prepare($query);
                //Execute
                $result = $stmt->execute();
                if($result){
                    $vars = ['error' => 'CoSuc',
                            'return' => 'courses'];
                    $param = http_build_query($vars);
                    header('Location: http://localhost/panas-api/success.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
                    exit;
                }else{  
                    $vars = ['error' => 'CoErr',
                            'return' => 'courses'];
                    $param = http_build_query($vars);
                    header('Location: http://localhost/panas-api/success.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
                    exit;
                }
            }
        }catch (Exception $ex){
            print("Error: ". $ex->getMessage());
        }finally{
            $this->connection = null;
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
            $this->connection = $this->database->connect();
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