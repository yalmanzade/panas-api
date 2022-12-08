<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"
    />
</head>
<body>
  <header>
    <form action="api/logout.php" method="post">
      <input class="button is-danger" type="submit" value="LogOut">
    </form>
  </header>
       <?php
        require_once 'data/data.php';
        session_start();
        if(isset($_SESSION['confirmation'])&& $_SESSION['confirmation'] == "1"){
          $name = $_SESSION['name'];
          $email =  $_SESSION['email'];
          echo "<section class='section'>
            <div class='container'>
            <h1 class='title is-3'>$name, you are authenticated.</h1>
            <h1 class='subtitle is-4'>You can perform the following actions.</h1>
            </div>      
          </section>";
          echo " <div class='container'>
                  <form method='POST' action='../panas-api/newmeeting.php'>
                    <input class='button is-link' type='submit' value='New Meeting' />
                    <input type='text' name='name' id='name' value= ;'{$name}' hidden />
                    <input type='text' name='email' id='email' value='{$email}' hidden />
                  </form>
                </div>";
          if(isset($_SESSION['admincode'])&& in_array($_SESSION['admincode'],$adminCodes )){
            echo "<div class='container'>
                    <form method='GET' action='../panas-api/newtutor.php'>
                    <input class='button is-link' type='submit' value='Register Tutor' />
                    </form>      
                  </div>";
            // $admincode = $_GET['session'];
            echo "<div class='container'>
                    <form method='GET' action='courses.php'>
                    <input class='button is-link' type='submit' value='Manage Courses'/>
                    </form>      
                  </div>";
            require_once 'models/user.php';
            require_once 'models/database.php';
            $database = new Database();
            $tutors = new Tutor($database);
            $result = $tutors->getallTutors();
            echo "
            <div class='container'> 
            <h1 class='subtitle is-5'>Manage Tutors</h1>
            <form action='api/deletetutor.php' method='post'>
            <select name='tutorId'>";
            foreach($result as $row){
              $id = $row['tutor_id'];
              $name=$row['name'];
              echo "<option value='$id'>$name</option>";
            }
            echo "
            </select>
            <input type='submit' value='Delete'/>
            </form>
            </div>";
          }
        }
    ?>
    <section class="section">
      <div class="container">
        <table class="table">
          <h1 class="subtitle is-3">Your Meetings</h1>
          <thead>
            <th>Time</th>
            <th>Date</th>
          </thead>
          <tbody>
            <?php
              require_once 'data/data.php';
              $meeting = new Meeting($db);
              print("User ID: ".$_SESSION['userid']);
              // print("Session ID: ".$_SESSION['userID']);
              $meetings = $meeting->getMeetings($_SESSION['userid'],$_SESSION['table']);
              if($meetings){
                foreach ($meetings as $row){
                  // $time = $meeting->convertTime($row['hour'],$row['minute'],00,$row['section']);
                  $time = $row['time'];
                  $date = $row['date'];
                  echo "<tr>
                    <td>$time</td>      
                    <td>$date</td>
                  </tr>";
                }
              }
            ?>
          </tbody>
        </table>
      </div>
    </section>
</body>
</html>