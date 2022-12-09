<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Dates</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"
    />
  </head>
  <body>
    <main>
      <section class="section">
        <div class="container">
          <h1 class="title is-4">Add Availability</h1>
          <form method="POST" action="../panas-api/api/tutorregistration.php">
            <label class="label" for="email">Email</label>
            <input
              class="input"
              type="email"
              name="email"
              id="email"
              value="<?php
              $email = htmlspecialchars($_POST['email']);
              echo $email;
              ?>"
              readonly
            />
            <?php 
              $days = $_POST['days'];
              foreach($days as $day){
                $daystartMinute = str_replace(' ', '', $day.'startminute');
                $daysendMinute = str_replace(' ', '', $day.'endminute');
                $daystartHour = str_replace(' ', '', $day.'starthour');
                $daysendHour = str_replace(' ', '', $day.'endhour');
                $sectionstart = str_replace(' ', '', $day.'secstart');
                $sectionend = str_replace(' ', '', $day.'secend');
                echo "<label for='$day' class='label'>".$day."</label>";
                echo "<label for='startTimes' class='label'>From</label>
                    <select name='$daystartHour'>
                      <option value='01'>01</option>
                      <option value='02'>02</option>
                      <option value='03'>03</option>
                      <option value='04'>04</option>
                      <option value='05'>05</option>
                      <option value='06'>06</option>
                      <option value='07'>07</option>
                      <option value='08'>08</option>
                      <option value='09'>09</option>
                      <option value='10'>10</option>
                      <option value='11'>11</option>
                      <option value='12'>12</option>
                    </select>
                    <span>:</span>
                    <select name='$daystartMinute'>
                      <option value='00'>00</option>
                      <option value='10'>10</option>
                      <option value='20'>20</option>
                      <option value='30'>30</option>
                      <option value='40'>40</option>
                      <option value='50'>50</option>
                    </select>
                    <select name='$sectionstart'>
                      <option value='PM'>PM</option>
                      <option value='AM'>AM</option>
                    </select>
                    <label for='end_times' class='label'>To</label>
                    <select name='$daysendHour'>
                      <option value='01'>01</option>
                      <option value='02'>02</option>
                      <option value='03'>03</option>
                      <option value='04'>04</option>
                      <option value='05'>05</option>
                      <option value='07'>07</option>
                      <option value='08'>08</option>
                      <option value='09'>09</option>
                      <option value='10'>10</option>
                      <option value='11'>11</option>
                      <option value='12'>12</option>
                    </select>
                    <span>:</span>
                    <select name='$daysendMinute'>
                      <option value='00'>00</option>
                      <option value='10'>10</option>
                      <option value='20'>20</option>
                      <option value='30'>30</option>
                      <option value='40'>40</option>
                      <option value='50'>50</option>
                    </select>
                    <select name='$sectionend'>
                      <option value='PM'>PM</option>
                      <option value='AM'>AM</option>
                    </select>";
              };
            
            $courses = $_POST['courses'];
            $returnText = '';
            foreach ($courses as $course){
              $returnText = $returnText . ','. $course;
            };
            echo "</br><input name='courses' value=' ". $returnText ."' readonly/>";
            $daysoftheweek = $_POST['days'];
            $returnText = '';
            foreach ($daysoftheweek as $day){
              $returnText =  $returnText . ',' . $day;
            };
            $name = htmlspecialchars($_POST['name']);
            echo "</br><input name='days' value=' ". $returnText ."' readonly />";
            echo "</br><input name='name' value=' ". $name ."' readonly />";
            ?>
          <br/>
          <input class="button is-link" type="submit" value="Submit"> 
          </form>
        </div>
      </section>
    </main>
  </body>
</html>
