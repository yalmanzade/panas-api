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
      $meeting->action = $_POST['action'];
      $meeting->id = $_POST['id'];
      if($meeting->action){
        switch($meeting->action){
            case 'delete':
                $error = $meeting->deleteMeeting();
            case 'modify':
                $meeting->time = $_POST['time'];
                $meeting->date = $_POST['date'];
                $time = (explode(":", $meeting->time));
                $meeting->hour = $time[0];
                $meeting->minute = $time[1];
                $error = $meeting->modifyMeeting();
            default:
                $error = $meeting->confirmMeeting();
        }
      }else{
        echo 'Empty Action';
      }
      if($error == false){
        echo 'Error at managing meeting: '.$error. "\n";
      }else{
        echo 'No error: '.$meeting->action. " done. \n";
      }
    }catch(Exception $ex){
      echo 'Error: ' .$ex->getMessage() . "\n";
    }finally{
      $meeting = null;
      $db = null;
    }
  }else{
    echo "Bad Request. \n";
  }