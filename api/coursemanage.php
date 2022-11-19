<?php 
use FFI\Exception;
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
if($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
        require_once '../models/database.php';
        require_once '../models/course.php';
        $db = new Database();
        $course = new Course($db);
        $action = $_GET['action'];
        if($action == 'add'){
            $course->name = htmlspecialchars(strip_tags($_POST['name']));
            $course->addCourse();
        }if($action == 'delete'){
            $course->code = htmlspecialchars(strip_tags($_POST['course-delete']));
            $course->deleteCourse();
        }
    }
    catch(Exception $ex){
        echo "Error ". $ex->getMessage(). "\n";
    }finally{
        $db = null;
        $course = null;
    }
}else{
    echo "Invalid POST Request \n";
}
