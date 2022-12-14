<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  require_once  '../models/meeting.php';
  require_once  '../models/database.php';
  if($_SERVER['REQUEST_METHOD'] =='POST'){
    try{
      $error = false;
      $db = new Database();
      $meeting = new Meeting($db);
      $meeting->action = htmlspecialchars(strip_tags($_POST['action']));
      $meeting->id = $_POST['id'];
      if($meeting->action){
        switch($meeting->action){
            case 'delete':
                $error = $meeting->deleteMeeting();
            case 'modify':
                $meeting->time = htmlspecialchars(strip_tags($_POST['time']));
                $meeting->date = htmlspecialchars(strip_tags($_POST['date']));
                $time = (explode(":", $meeting->time));
                $meeting->hour = $time[0];
                $meeting->minute = $time[1];
                $error = $meeting->modifyMeeting();
            default:
                $error = $meeting->confirmMeeting();
        }
      }else{
        $vars = ['error' => 'NoAct',
                'return' => 'login'];
        $param = http_build_query($vars);
        header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
        exit;
      }
      if($error == false){
        $vars = ['error' => 'MeetError',
                'return' => 'newstudent'];
        $param = http_build_query($vars);
        header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
        exit;
      }else{
        echo 'Success: '.$meeting->action. " done. \n";
      }
    }catch(Exception $ex){
      echo 'Error: ' .$ex->getMessage() . "\n";
    }finally{
      $meeting = null;
      $db = null;
    }
  }else{
    $vars = ['error' => 'BadReq',
              'return' => 'login'];
    $param = http_build_query($vars);
    header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
    exit;
  }