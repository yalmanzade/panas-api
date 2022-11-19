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
    ?>
  </head>
  <body>
    <?php 
     if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['confirmation'])){
        if($_GET['confirmation'] == "0"){
          $name = $_GET['name'];
          $login_email = $_GET['email'];
          $user_type = $_GET['usertype'];
          echo "<div class='container'>
                <p>Hello, $name </p>
                <p>We've sent an email to: $login_email </p>
                <div/>";
          echo "<div class='container'>
                <form method='POST' action='../panas/api/codeauth.php'>
                  <label for='code' class='label'>Confirmation Code</label>
                  <input type='number' name='code' id='code' class='input'/>
                  <input type='text' name='usertype'value='$user_type' hidden />
                  <input class='button is-link' type='submit' value='Submit' />
                </form>
                <p class='subtitle is-6'>We just sent an email to  $login_email</p>
              </div>"; 
        }
        if(isset($_GET['confirmation'])&& $_GET['confirmation'] == "1"){
          $name = $_GET['name'];
          $email = $_GET['email'];
          // $id = $_GET['id'];
          echo $name . ', you have been authenticated.';
          echo " <div class='container'>
                  <form method='POST' action='../panas/newmeeting.php'>
                    <input class='button is-link' type='submit' value='New Meeting' />
                    <input type='text' name='name' id='name' value= ;'{$name}' hidden />
                    <input type='text' name='email' id='email' value='{$email}' hidden />
                  </form>
                </div>";
          if(isset($_GET['session'])&& in_array($_GET['session'],$adminCodes )){
            echo "<div class='container'>
                    <form method='GET' action='../panas/newtutor.php'>
                    <input class='button is-link' type='submit' value='Register Tutor' />
                    </form>      
            </div>";
          }
        }
     } 
    ?>
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      var_dump($_POST);
    }
    ?>
  </body>
</html>
