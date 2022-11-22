<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  require_once  '../models/meeting.php';
  require_once  '../models/database.php';
  if($_SERVER['REQUEST_METHOD'] =='POST'){
    try{
      $db = new Database();
      $meeting = new Meeting($db);
      $time = $_POST['time'];
      foreach($time as $hour){
        if($hour != ''){
          $meeting->time =  date("g:i a", strtotime($hour));
        }
      }
      $time = (explode(":", $meeting->time));
      $meeting->hour = $time[0];
      $time = (explode(" ", $time[1]));
      $meeting->minute = $time[0];
      $meeting->section = $time[1];
      $meeting->place = 'See Email';
      $meeting->studentId = htmlspecialchars(strip_tags($_GET["id"]));
      $meeting->tutorEmail = htmlspecialchars(strip_tags($_POST['email']));
      $meeting->date = htmlspecialchars(strip_tags($_POST['date']));
      $result = $meeting->postMeeting();
      if($result){
        header("Location:http://localhost/panas/email.html", true, 301); //DevSkim: ignore DS137138 until 2022-12-15 
        exit();
      }
    }catch(Exception $ex){
      echo 'Error: ' .$ex->getMessage(). "\n";
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