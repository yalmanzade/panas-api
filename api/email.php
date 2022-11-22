<div>
    <h1>HTML Entities</h1>
    <?php 
    echo htmlentities($_POST['email']); //DevSkim: ignore DS163877 until 2022-12-21
    ?>
</div>
<div>
    <h1>Strip Tags</h1>
    <?php 
    echo strip_tags($_POST['email']); //DevSkim: ignore DS163877 until 2022-12-21 
    ?>
</div>
<div>
    <h1>HTML Special Chars</h1>
    <?php 
    echo htmlspecialchars(strip_tags($_POST['email'])); //DevSkim: ignore DS163877 until 2022-12-21 
    ?>
</div>
<!-- <div>
    <h1>Decode</h1>
    <?php 
    echo htmlspecialchars_decode($_POST['email']) //DevSkim: ignore DS163877 until 2022-12-21 
    ?>
</div> -->


<?php
// // require_once '../models/email.php';
// require_once '../models/meeting.php';
// require_once '../models/database.php';
// var_dump($_POST);



// // $email = new Email();

// // $email->SendWelcomeEmail("Yosep");
// $the_date = "2022-11-07"; // The date from the previous section
// $name_of_the_day = date('l', strtotime($the_date));
// echo "The date " . $the_date . " falls on a " . $name_of_the_day;
// if($_SERVER['REQUEST_METHOD']=='GET' && $_GET['id'] && strlen($_GET['id']) > 1 ){
//     $db = new Database();
//     $meeting = new Meeting($db);
//     $meeting->id = $_GET['id'];
//     $meeting->getMeeting();
//     // var_dump($meeting);
// }else{
//     $vars = ['error' => 'BadReq',
//               'return' => 'login'];
//     $param = http_build_query($vars);
//     header('Location: http://localhost/panas-api/error.php?'.$param); //DevSkim: ignore DS137138 until 2022-12-19 
//     exit;
// }