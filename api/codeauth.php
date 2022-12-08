<?php
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
      $auth->login_email = htmlspecialchars(strip_tags($_SESSION['email']));
      // var_dump($auth);
      // exit;
      $result = $auth->confirmCode();
      if($result){
        $user->email = trim($result["login_email"]);
        $userType = trim($userTypes[htmlspecialchars(strip_tags($_POST['usertype']))]);
        $userData = $user->getUser($userType);
        
        if(isset($_SESSION['newregistration']) && $_SESSION['newregistration'] == 1){
          $user->confirmUser($userType);
        }
        $admin = $userData["isAdmin"];
        if($admin == 1 && $userType == 'tutors'){   
          $admin = $adminCodes[random_int(0,4)];
          $_SESSION['userid'] = (int)$userData["tutor_id"];
          $_SESSION['userData'] = $userData;
          $_SESSION['table'] = "tutor_id";
          // print("Admin Tutor");
          // var_dump($_SESSION['userid']);
          // var_dump($userData);
          // exit;
        }elseif($admin == 0 && $userType == "tutors"){
          $_SESSION['userid'] = $userData['tutor_id'];
          $_SESSION['table'] = "tutor_id";
          $admin = 0;
          // print("Tutor");
          // var_dump($_SESSION['userid']);
          // var_dump($userData);
          // exit;
        }elseif($admin == 0 && $userType == "student"){    
          $_SESSION['userid'] = $userData['student_id'];
          $_SESSION['table'] = "student_id";
          // var_dump($userData);
          print("Student");
          print("User Type: ".$userType. " - ");
          print("Admin: ".$admin);
          // var_dump($_SESSION['userid']+10);
          // var_dump($userData);
          $admin = 0;
          //exit;
        }else{
          $vars = ['error' => 'SeErr',
                    'return' => 'login'];
          $param = http_build_query($vars);
          header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
          exit; 
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
          $vars = ['error' => 'SeErr',
                    'return' => 'login'];
          $param = http_build_query($vars);
          header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
          exit; 
        }
      }else{
        $vars = ['error' => 'NoAuth',
                  'return' => 'result'];
        $param = http_build_query($vars);
        header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
        exit; 
      }
    }catch(Exception $ex){
      print("Error" .$ex->getMessage());
    }finally{
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