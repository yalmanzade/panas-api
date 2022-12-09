<?php
  // Headers
  session_start();
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
    $vars = ['error' => 'LogO',
              'return' => 'login'];
    $param = http_build_query($vars);
    header('Location: http://localhost/panas-api/success.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
    exit;
  }else{
    $vars = ['error' => 'BadReq',
              'return' => 'login'];
    $param = http_build_query($vars);
    header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
    exit;
  }