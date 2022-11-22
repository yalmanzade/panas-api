<?php
  // Headers
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
      $user = $user->getUser(trim($userTypes[htmlspecialchars(strip_tags($_POST['usertype']))]));
      if($result){
        $admin = $user["isAdmin"];
        if($admin == 1){
          $admin = $adminCodes[random_int(0,4)];
        }else{
          $admin = 0000;
        }
        $vars = ['message' => 'Auth Success',
                'name' => $result['name'],
                'email' => $result["login_email"],
                'confirmation' => True,
                'session' => $admin];
        $param = http_build_query($vars);
        $url = "http://localhost/panas-api/result.php?" .$param; //DevSkim: ignore DS137138 until 2022-12-12 
        header('Location:'.$url, true, 301);
        exit;
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
  function sendPost($user, $result){
        $url = "http://localhost/panas-api/result.php"; //DevSkim: ignore DS137138 until 2022-12-13 
        $data = array("message"=>"Success",
                      "name"=>$result['name'],
                      "email"=> $result["login_email"],
                      "confirmation"=> true,
                      "isAdmin" => $user ["isAdmin"]);
        $options = array('http' => array(
          "header" => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'POST',
          'content' => http_build_query($data)
        ));
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        // var_dump($result);
        if ($result === FALSE){
          echo "Error \n";
          return false;
        }
  }
  
