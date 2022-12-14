<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=\, initial-scale=1.0" />
    <title>Meetings</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"
    />
    <script src="scripts/meeting.js" defer></script>
  </head>
  <body>
    <main>
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
        <div class="container">
          <?php
            require_once './models/meeting.php';
            require_once './models/database.php';
            $db = new Database();
            $meeting = new Meeting($db);
            $courses = $meeting->getCourses();
            foreach($courses as $row){
              $name = $row['name'];
              $email = $row['email'];
              $id = $row['tutor_id'];
              $courses = json_decode($row['courses']);
              $available = json_decode($row['available']);
              echo"
              <form action='api/meetings.php?temail=$email' method='post'>        
              <div class='card'>
                  <div class='card-content'>
                  <div class='media'>
                    <div class='media-left'>
                      <figure class='image is-48x48'>
                        <img
                          src='https://bulma.io/images/placeholders/96x96.png'
                          alt='Placeholder image'
                        />
                      </figure>
                    </div>
                    <div class='media-content'>
                      <p class='title is-4'>{$name}</p>
                      <p name='email' class='subtitle is-6'>{$email}</p>
                    </div>
                  </div>
                  <div class='content'>
                  <h1 class='subtitle is-6'>Available Courses</h1>";
                  foreach($courses as $course){
                    echo "<span class='tag is-danger is-light'>{$course}</span>";
                  }
            echo "
                  <h1 class='subtitle is-6'>Available Times</h1>";
                  foreach($available as $day){
                    $startTime = $meeting->convertTime($day->starthour,$day->startminute, "00",$day->secstart);
                    $endTime = $meeting->convertTime($day->endhour,$day->endminute, "00",$day->secend);
                    echo "<h5 class='subtitle is-5'>{$day->day}</h5>";
                    echo "<h6 class='subtitle is-6'>From {$day->starthour}:{$day->startminute} {$day->secstart}
                          to {$day->endhour}:{$day->endminute} {$day->secend}</h6>";
                    echo "<input class='time-select' type='time' name='time[]' min='{$startTime}' max='{$endTime}' />";      
                    // echo "<a href='meetings.php?day={$day->day}&id={$row['tutor_id']}'><button class='button is-link is-small'>Book</button></a>";      
                  } 
            }
            ?>
            <h1 class='subtitle is-6'>Pick a date</h1>
            <input type='date' id='date' name="date"
              min="2022-11-06" required>
            <input class='input button is-link' type='submit' value='Book'>
            <?php
            // echo "<input name='email' type='text' value='{$email}' />";
            ?>
          </form>
        </div>
      </section>
    </main>
    <?php
    $meeting = null;
    ?>
  </body>
</html>
