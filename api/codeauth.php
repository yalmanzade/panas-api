<?php
  // Headers
  session_start();
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  require_once '../models/database.php';
  require_once '../models/auth.php';
  $adminCodes = array(2353212312,1287686522,4353456420,6436634575,4356436532,5644564562);
  $database = new Database();
  $auth = new Auth($database);
  $userTypes = array('student', 'tutors'); 
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
      $user = new User($database);
      $auth->generated_code = htmlspecialchars(strip_tags($_POST['code']));
      $result = $auth->confirmCode();
      $user->email = trim($result["login_email"]);
      $userType = trim($userTypes[htmlspecialchars(strip_tags($_POST['usertype']))]);
      $userData = $user->getUser($userType);
      if($result){
        if(isset($_SESSION['newregistration']) && $_SESSION['newregistration'] == 1){
          $user->confirmUser($userType);
        }
        $admin = $userData["isAdmin"];
        if($admin == 1 && $userType == 'tutors'){
          $admin = $adminCodes[random_int(0,4)];
          $_SESSION['userid'] = $userData['tutor_id'];
        if($admin == 0 && $userType == 'tutors'){
          $_SESSION['userid'] = $userData['tutor_id'];
          $admin = 0;
        }
        }else{
          $_SESSION['userid'] = $userData['student_id'];
          // var_dump($userData);
          $admin = 0;
        }
        if(session_status() === 2){
          $_SESSION['admincode'] = $admin;
          $_SESSION['user'] = 0;
          $_SESSION['name'] = htmlspecialchars(strip_tags($result['name']));
          $_SESSION['email'] = htmlspecialchars(strip_tags($result['login_email']));
          $_SESSION['confirmation'] = 1;
          $_SESSION['session'] = 1;
          header("Location: http://localhost/panas-api/portal.php",true, 301); //DevSkim: ignore DS137138 until 2022-12-12  
          exit; 
        }else{
          // session_start();
          $vars = ['error' => 'SeErr',
                    'return' => 'login'];
          $param = http_build_query($vars);
          header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
          exit; 
        }
      }else{
        $vars = ['error' => 'NoAuth',
                'return' => 'login'];
        $param = http_build_query($vars);
        header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
        exit;
      }
    }catch(Exception $ex){  
      echo "Error: ". $ex->getMessage() . "\n";
    }
    finally{
      $connection = null;
      $database = null;
      $auth = null;
    }
  }else{
    $vars = ['error' => 'BadReq',
              'return' => 'login'];
    $param = http_build_query($vars);
    header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
    exit;
  }