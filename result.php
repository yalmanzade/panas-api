<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Result</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"
    />
    <?php
      require_once 'data/data.php';
      session_start();
    ?>
  </head>
  <body>
    <?php 
     if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_SESSION['confirmation'])){
        if($_SESSION['confirmation']== "0"){
          $name = $_SESSION['name'];
          $login_email = $_SESSION['email'];
          $user_type = $_SESSION['usertype'];
          echo "<div class='container'>
                <p>Hello, $name </p>
                <p>We've sent an email to: $login_email </p>
                <div/>";
          echo "<div class='container'>
                <form method='POST' action='./api/codeauth.php'>
                  <label for='code' class='label'>Confirmation Code</label>
                  <input type='number' name='code' id='code' class='input'/>
                  <input type='text' name='usertype'value='$user_type' hidden />
                  <input class='button is-link' type='submit' value='Submit' />
                </form>
                <p class='subtitle is-6'>We just sent an email to  $login_email</p>
              </div>"; 
        }
     }else{
        $vars = ['error' => 'BadReq',
                  'return' => 'login'];
        $param = http_build_query($vars);
        header('Location: http://localhost/panas-api/error.php?'.$param); //DevSkim: ignore DS137138 until 2022-12-19 
        exit;
     } 
    ?>
    <?php
    // if($_SERVER["REQUEST_METHOD"] == "POST"){
    //   var_dump($_POST);
    // }else{
    //   $vars = ['error' => 'BadReq',
    //             'return' => 'login'];
    //   $param = http_build_query($vars);
    //   header('Location: http://localhost/panas-api/error.php?'.$param); //DevSkim: ignore DS137138 until 2022-12-19 
    //   exit;
    // }
    ?> 
  </body>
</html>
