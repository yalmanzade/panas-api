<?php 
session_start();
use FFI\Exception;
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
require_once '../data/data.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
        if(in_array($_SESSION['admincode'], $adminCodes)){
            require_once '../models/database.php';
            require_once '../models/course.php';
            $db = new Database();
            $course = new Course($db);
            $action = strip_tags($_GET['action']);
            if($action == 'add'){
                $course->name = strip_tags($_POST['name']);
                $course->addCourse();
            }if($action == 'delete'){
                $course->code = strip_tags($_POST['course-delete']);
                $course->deleteCourse();
            }
        }else{
            $vars = ['error' => 'FAuth',
                    'return' => 'courses'];
            $param = http_build_query($vars);
            header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
            exit;
        }
    }
    catch(Exception $ex){
        echo "Error ". $ex->getMessage(). "\n";
    }finally{
        $db = null;
        $course = null;
    }
}else{
    $vars = ['error' => 'BadReq',
              'return' => 'courses'];
    $param = http_build_query($vars);
    header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
    exit;
}
