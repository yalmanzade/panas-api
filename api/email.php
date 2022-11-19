<?php
// // require_once '../models/email.php';
require_once '../models/meeting.php';
require_once '../models/database.php';

// // $email = new Email();

// // $email->SendWelcomeEmail("Yosep");
// $the_date = "2022-11-07"; // The date from the previous section
// $name_of_the_day = date('l', strtotime($the_date));
// echo "The date " . $the_date . " falls on a " . $name_of_the_day;
if($_SERVER['REQUEST_METHOD']=='GET' && $_GET['id'] && strlen($_GET['id']) > 1 ){
    $db = new Database();
    $meeting = new Meeting($db);
    $meeting->id = $_GET['id'];
    $meeting->getMeeting();
    // var_dump($meeting);
}else{
    echo "There is a problem with the url \n";
}