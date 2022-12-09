<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST, GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  require_once '../models/database.php';
  require_once '../models/auth.php';
  $database = new Database();
  $db = $database->connect();
  $auth = new Auth($db);
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  try{
    $auth->name = htmlspecialchars(strip_tags($_POST['name']));
    $auth->login_email = htmlspecialchars(strip_tags($_POST['email']));
    $result = $auth->authUser();
    if ($result){
      $vars = ['message' => 'Auth Success',
              'id' => $auth->name,
              'name' => $auth->name,
              'email' => $auth->login_email,
              'confirmation' => False];
      $param = http_build_query($vars);
      $url = "http://localhost/panas/result.php?" .$param; //DevSkim: ignore DS137138 until 2022-12-12 
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
  }finally{
    $auth = null;
    $db = null;
  }
}else{
  $vars = ['error' => 'BadReq',
          'return' => 'login'];
  $param = http_build_query($vars);
  header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
  exit;
}
  
