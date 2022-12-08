<?php 
require_once '../models/user.php';
require_once '../models/database.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
        $db = new Database();
        $tutor = new Tutor($db);
        $arrayData = explode(',', $_POST['courses']);
        array_shift($arrayData);
        foreach($arrayData as $data){
            if(!empty($data)){
                array_push($tutor->classlist, $data);
            }
        }
        $arrayData = explode(',', $_POST['days']);
        array_shift($arrayData);
        foreach($arrayData as  $data){;
            if(!empty($data)){
                array_push($tutor->meetingdays , $data);
            }
        }
        $arrayData = explode(',', $_POST['days']);
        $tutor->meetingtimes = array();
        foreach($arrayData as  $day){
            if($day !== ' '){
                // print(str_replace(' ', '', $day.'starthour'));
                $meetingTime = array( "day" => $day,
                                    "starthour" => $_POST[str_replace(' ', '', $day.'starthour')],
                                    "startminute" => $_POST[str_replace(' ', '', $day.'startminute')],
                                    "secstart" => $_POST[str_replace(' ', '', $day.'secstart')],
                                    "endhour" => $_POST[str_replace(' ', '', $day.'endhour')],
                                    "endminute" => $_POST[str_replace(' ', '', $day.'endminute')],
                                    "secend" => $_POST[str_replace(' ', '', $day.'secend')]);
                array_push($tutor->meetingtimes, $meetingTime);
            }
        }
        $tutor->name = htmlspecialchars(strip_tags($_POST['name']));
        $tutor->email = htmlspecialchars(strip_tags($_POST['email']));
        echo "<div>Name: $tutor->name</div>";
        echo "<div>Email: $tutor->email</div>";
        echo "<div>Meeting Times: </div>";
        foreach($tutor->meetingtimes as $day){
            echo "<div>";
            echo $day['day']. ": \n";
            echo "<strong> From </strong> ";
            echo $day['starthour'] . ':' . $day['startminute'] .' '. $day['secstart'] ;
            echo '<strong> Until </strong>';
            echo $day['endhour'] . ':' . $day['endminute'] .' '. $day['secend'] ;
            echo "</div>";
        };
        echo "<div>Your are teaching:</div>";
        foreach($tutor->classlist as $course){
            echo $course . "\n";
        }
        $result = $tutor->registerTutor();
        if($result){
            echo "<div>Congratulations, $tutor->name </div>";
            echo 'You are a tutor!';
        }else{
            $vars = ['error' => 'TutorReg',
                    'return' => 'login'];
            $param = http_build_query($vars);
            header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
            exit;
        }
    }catch(Exception $ex){
        echo "Error ". $ex->getMessage(). "\n";
    }finally{
        $tutor = null;
        $db = null;
    }
}else{
    $vars = ['error' => 'BadReq',
            'return' => 'login'];
    $param = http_build_query($vars);
    header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
    exit;
}   

