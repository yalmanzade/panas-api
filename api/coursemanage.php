<?php 
session_start();
use FFI\Exception;
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
$adminCodes = array(2353212312,1287686522,4353456420,6436634575,4356436532,5644564562);
if($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
        if(in_array($_SESSION['admincode'], $adminCodes)){
            require_once '../models/database.php';
            require_once '../models/course.php';
            $db = new Database();
            $error = false;
            $errorCode = "";
            $course = new Course($db);
            $action = strip_tags($_GET['action']);
            if($action == 'add'){
                $course->name = strip_tags($_POST['name']);
                if($course->addCourse()){
                    $errorCode = "CoAdd";
                    $error = false;
                }
            }else if($action == 'delete'){
                $course->code = strip_tags($_POST['course-delete']);
                if($course->deleteCourse()){
                    $errorCode = "CoErr";
                }
            }
            if(!$error){
                $vars = ['error' => $errorCode,
                        'return' => 'courses'];
                $param = http_build_query($vars);
                header('Location: http://localhost/panas-api/success.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
                exit;
            }else{
                $vars = ['error' => $errorCode,
                        'return' => 'courses'];
                $param = http_build_query($vars);
                header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
                exit;
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
