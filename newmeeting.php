<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Meeting</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"
    />
    <link rel="stylesheet" href="static/style.css">
</head>
    <header>
        <?php
            session_start();
            if(session_status() === 0 || session_status() === 1){
                $vars = ['error' => 'FAuth',
                          'return' => 'index'];
                $param = http_build_query($vars);
                header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
                exit;
            }
        ?>
    </header>
    <main>
        <section class="section">
            <?php
                require_once 'models/database.php';                
                require_once 'models/user.php';                
                require_once 'models/meeting.php';                
                $db = new Database();
                $tutor = new Tutor($db);
                $meeting = new Meeting($db);
                $tutors = $tutor->getallTutors();
                foreach ($tutors as $row){
                    $name = $row['name'];
                    $email = $row['email'];
                    $id = $row['tutor_id'];
                    $courses = json_decode($row['courses']);
                    $available = json_decode($row['available']);
                    echo "<form action='api/meetings.php?temail=$email' method='post' class='my-form'>";
                    echo "<div class='card'>";
                    echo "<div class='card-content'>";
                    echo "<div class='content'>";
                    echo "<span class='tag is-link is-light is-large'>$name</span>";
                    echo "<h1 class='subtitle is-3'>Courses Available</h1>";
                    foreach($courses as $course){
                        echo "<span class='tag is-danger is-light is-medium'>$course</span>";
                    }
                    echo "<h1 class='subtitle is-3'>Available Times</h1>";
                    foreach($available as $day){
                        $startTime = $meeting->convertTime($day->starthour,$day->startminute, "00",$day->secstart);
                        $endTime = $meeting->convertTime($day->endhour,$day->endminute, "00",$day->secend);
                        echo "<h5 class='subtitle is-5'>{$day->day}</h5>";
                        echo "<h6 class='subtitle is-6'>From {$day->starthour}:{$day->startminute} {$day->secstart}
                              to {$day->endhour}:{$day->endminute} {$day->secend}</h6>";
                        echo "<input class='time-select' type='time' name='time[]' min='{$startTime}' max='{$endTime}' />";
                    }
                    echo "<h1 class='subtitle is-3'>Pick a date</h1>";
                    echo "<input type='date' id='date' name='date' min='2022-11-06' required>";
                    echo "<input class='input button is-link' type='submit' value='Book'>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</form>";
                }
            ?>
        </section>
    </main>
<body>
    
</body>
</html>