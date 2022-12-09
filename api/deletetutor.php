<?php
  // Headers
  session_start();
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST, GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
        require_once '../models/database.php';
        require_once '../models/user.php';
        $database = new Database();
        $tutor = new Tutor($database);
        $tutor->id = strip_tags(htmlspecialchars($_POST['tutorId']));
        $result = $tutor->deleteTutor();
        if($result){
            $vars = ['error' => 'DTSuc',
                    'return' => 'portal'];
            $param = http_build_query($vars);
            header('Location: http://localhost/panas-api/success.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
            exit;
        }else{
            $vars = ['error' => 'DTErr',
                    'return' => 'portal'];
            $param = http_build_query($vars);
            header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
            exit;
        }
    }catch (Exception $e){
        print("Error: ". $ex->getMessage());
    }finally{
        $database = null;
        $tutor = null;
    }
  }else{
    $vars = ['error' => 'BadReq',
            'return' => 'portal'];
    $param = http_build_query($vars);
    header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
    exit;
  }