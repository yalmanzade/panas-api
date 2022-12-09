<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Courses</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"
    />
  </head>
  <body>
    <?php
    session_start();
    if($_SESSION['admincode'] == 0){
      $vars = ['error' => 'FAuth',
                'return' => 'index'];
      $param = http_build_query($vars);
      header('Location: http://localhost/panas-api/error.php?'.$param, true, 301); //DevSkim: ignore DS137138 until 2022-12-19 
      exit;
    }
    ?>
    <main class="container">
      <section class="section">
        <div class="container">
          <h1 class="title">Add Course</h1>
          <form method="post" action="api/coursemanage.php?action=add" class="form">
            <label for="name" class="label">Name</label>
            <input class="input" type="text" name="name" id="name" required />
            <!-- <input class="input" type="text" name="action" id="action" value="add" hidden readonly disabled> -->
            <input class="button is-link" type="submit" value="Submit"/>
          </form>
        </div>
      </section>
      <section class="section">
        <h1 class="title">Delete Course</h1>
        <div class="container select is-large is-rounded">
          <form method="post" action="api/coursemanage.php?action=delete" class="form">
            <select name="course-delete" id="course-delete">
              <?php
                require_once './data/data.php';
                foreach($courses as $row){
                  echo '<option value="' .$row['course_code']. '">'.$row['course_name'] . '<option>';
                }
              ?>
            </select>
            <input type="submit" value="Delete" class="button is-danger" />
          </form>
        </div>
      </section>
      <section class="section">
        <a href="index.html"><button class="button is-light is-large">Home</button></a>
      </section>
    </main>
  </body>
</html>
