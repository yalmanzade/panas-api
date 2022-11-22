<?php
  header('Access-Control-Allow-Origin: *');   
  header('Content-Type: application/json');   
  header('Access-Control-Allow-Methods: POST');   
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');      
  require_once '../models/database.php';
  require_once '../models/auth.php';
  require_once '../data/errormessages.php';
  var_dump($_POST);
  $userTypes = array('student', 'tutors');  
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
      $database = new Database();
      $user = new User($database);
      $user->email = htmlspecialchars(strip_tags($_POST['email']));
      $userType = htmlspecialchars(strip_tags($_POST['usertype']));
      $userArray = $user->getUser($userTypes[$userType]);
      if($userArray){
          $user->name = $userArray['name'];
          $auth = new Auth($database->connect());
          $auth->name = $user->name;
          $auth->login_email = $user->email;
          $auth->authUser();
          $vars = ['message' => 'Auth Success',
                'name' => $user->name,
                'email' => $user->email,
                'confirmation' => false,
                'usertype' => $userType];
          $param = http_build_query($vars);
          $url = "http://localhost/panas-api/result.php?".$param; //DevSkim: ignore DS137138 until 2022-12-12 
          header('Location:'.$url);
          exit;
      }else{  
        // $errorCodes['NoUser'] = "We could not find this user $user->email please try registering again or contact support.";
        $vars = ['error' => 'NoUser',
                'return' => 'newstudent'];
        $param = http_build_query($vars);
        header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
        exit;
      }
    }catch(Exception $ex){
      echo "Error: " .$ex->getMessage(). "\n";
    }finally{
      $database = null;
      $user = null;
    }
  }else{
    // $vars = ['error' => 'BadReq',
    //           'return' => 'login'];
    // $param = http_build_query($vars);
    // header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
    // exit;
  }

