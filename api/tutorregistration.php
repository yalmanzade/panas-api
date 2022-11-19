<?php 
require_once '../models/user.php';
require_once '../models/database.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
        $db = new Database();
        $tutor = new Tutor($db);
        $arrayData = explode(',', $_POST['courses']);
        foreach($arrayData as $data){
            array_push($tutor->classlist, $data);
        }
        $arrayData = explode(',', $_POST['days']);
        foreach($arrayData as  $data){;
            array_push($tutor->meetingdays , $data);
        }
        $arrayData = explode(',', $_POST['days']);
        foreach($arrayData as  $day){
            if($day !== ' '){
                $meetingTime = array( "day" => $day,
                                    "starthour" => $_POST[$day.'starthour'],
                                    "startminute" => $_POST[$day.'startminute'],
                                    "secstart" => $_POST[$day.'secstart'],
                                    "endhour" => $_POST[$day.'endhour'],
                                    "endminute" => $_POST[$day.'endminute'],
                                    "secend" => $_POST[$day.'secend']);
                array_push($tutor->meetingtimes, $meetingTime);
            }
        }
        $tutor->name = $_POST['name'];
        $tutor->email = $_POST['email'];
        echo "\nName: " . $tutor->name;
        echo "\nEmail: " . $tutor->email; 
        echo "\n Meeting Times: ";
        foreach($tutor->meetingtimes as $day){
            echo $day['day']. ": \n";
            echo "<strong> From </strong> ";
            echo $day['starthour'] . ':' . $day['startminute'] .' '. $day['secstart'] ;
            echo '<strong> Until </strong>';
            echo $day['endhour'] . ':' . $day['endminute'] .' '. $day['secend'] ;
            echo "\n";
        };
        echo 'Your are teaching:';
        foreach($tutor->classlist as $course){
            echo $course . "\n";
        }
        $result = $tutor->registerTutor();
        if($result){
            echo 'Congratulatrions, ' .$tutor->name . "\n";
            echo 'You are a tutor!';
        }else{
            echo "Error, Please try creating the account again \n";
        }
    }catch(Exception $ex){
        echo "Error ". $ex->getMessage(). "\n";
    }finally{
        $tutor = null;
        $db = null;
    }
}else{
    echo "Bad Request \n";
}   

