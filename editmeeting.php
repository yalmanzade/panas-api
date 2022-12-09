<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Meeting</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"
    />
  </head>
  <body>
  <?php
    require_once 'models/meeting.php';
    require_once 'models/database.php';
    if($_SERVER['REQUEST_METHOD']=='GET' && $_GET['id'] && strlen($_GET['id']) > 1 ){
      $db = new Database();
      $meeting = new Meeting($db);
      $meeting->id = $_GET['id'];
      $meeting->getMeeting();
      // var_dump($meeting);
    }else{
      $vars = ['error' => 'BadUrl',
                'return' => 'newmeeting'];
      $param = http_build_query($vars);
      header('Location: http://localhost/panas-api/error.php?'.$param); //DevSkim: ignore DS137138 until 2022-12-19 
      exit;
    }
  ?>
      <section class="section">
        <div class="container">
          <form action="<?php echo 'api/managemeeting.php?id='. $meeting->id; ?>" method="post">
            <input type="text" name="id" value="<?php echo $meeting->id;?>" hidden>
            <label for="date" class="label">Date</label>
            <input class="input" type="date" name="date" value="<?php echo $meeting->date ?>"  />
            <label for="time" class="label">Time</label>
            <input class="input" type="time" name="time" value="<?php echo $meeting->time?>"  />
            <label for="action">Select an Action</label>
            <select class="input" name="action" id="action">
              <option value="modify">Modify</option>
              <?php
                if(isset($_GET['session'])&&$_GET['session']==1){
                  echo '<option value="approve">Approve</option>';
                }
              ?>>
              <option value="delete">Delete</option>
            </select> 
            <input class="is-link button" type="submit" value="Submit">
          </form>
        </div>
      </section>
  </body>
</html>
