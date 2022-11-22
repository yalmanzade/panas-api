<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST, GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  require_once '../models/database.php';
  require_once '../models/auth.php';
  require_once '../models/user.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $student = new Student($database);
    $db = $database->connect();
    $auth = new Auth($db);
    try{
        $auth->name = strip_tags($_POST['name']);
        $student->name = strip_tags($_POST['name']);
        $student->email = strip_tags($_POST['email']);
        $auth->login_email = strip_tags($_POST['email']);
        $userExists = $student->studentExists();
        if($userExists == true){
            $vars = ['error' => 'UserEx',
                    'return' => 'login'];
            $param = http_build_query($vars);
            header('Location: http://localhost/panas-api/warning.php?'.$param); //DevSkim: ignore DS137138 until 2022-12-19 
            exit;
        }else{
            $student->id = random_int(100000,999999);
            $result = $student->registerUser();
            if ($result){
                $vars = ['message' => $student->name];
                $param = http_build_query($vars);
                $url = "http://localhost/panas-api/login.php?" .$param; //DevSkim: ignore DS137138 until 2022-12-12 
                header('Location:'.$url);
                exit;
            }else{
                $vars = ['error' => 'StuReg',
                        'return' => 'login'];
                $param = http_build_query($vars);
                header('Location: http://localhost/panas-api/error.php?'.$param); //DevSkim: ignore DS137138 until 2022-12-19 
                exit;
            }
        }
    }catch(Exception $ex){
        echo "Error: ". $ex->getMessage() . "\n";
    }finally{
        $auth = null;
        $db = null;
    }
}else{
    $vars = ['error' => 'BadReq',
              'return' => 'login'];
    $param = http_build_query($vars);
    header('Location: http://localhost/panas-api/error.php?'.$param); //DevSkim: ignore DS137138 until 2022-12-19 
    exit;
}