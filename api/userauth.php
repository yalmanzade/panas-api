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
    $auth->name = $_POST['name'];
    $auth->login_email = $_POST['email'];
    $result = $auth->authUser();
    if ($result){
      $vars = ['message' => 'Auth Success',
              'id' => $auth->name,
              'name' => $auth->name,
              'email' => $auth->login_email,
              'confirmation' => False];
      $param = http_build_query($vars);
      $url = "http://localhost/panas/result.php?" .$param; //DevSkim: ignore DS137138 until 2022-12-12 
      header('Location:'.$url);
      exit;
    }else{
      echo json_encode(
        array('message' => 'Auth Failed')
      );
      exit;
    }
  }catch(Exception $ex){
    echo "Error: ". $ex->getMessage() . "\n";
  }finally{
    $auth = null;
    $db = null;
  }
}else{
  echo "Error: Bad Post Request.\n";
}
if ($_SERVER["REQUEST_METHOD"] == "GET"){
  try{
    $auth->generated_code = $_POST['code'];
    $result = $auth->confirmCode();
    if($result){
        $vars = ['message' => 'Auth Success',
              'id' => $auth->login_email,
              'name' => $auth->name,
              'email' => $auth->login_email,
              'confirmation' => True];
        $param = http_build_query($vars);
        $url = "http://localhost/panas/result.php?" .$param; //DevSkim: ignore DS137138 until 2022-12-12 
        header('Location:'.$url);
        exit;
    }else{
        echo 'Error, Wrong Code';
    }

  }catch(Exception $ex){
    echo "Error: ". $ex->getMessage() . "\n";
  }finally{
    $auth = null;
    $db = null;
  }
}else{
  echo "Error: Bad Get Request.\n";
}
  
