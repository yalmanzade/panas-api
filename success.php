<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Success</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"
    />
  </head>
  <body>
    <main>
      <section class="section">
        <div class="container">
          <div class="notification is-success is-light">
            <h1 class="title is-3">Success</h1>
            <p class="subtitle is-4">
              <?php 
              require_once 'data/errormessages.php';
              $code = $_GET['error'];
              echo $errorCodes[$code];
              ?>
            </p>
          </div>
          <a href="<?php 
          $returnText = $_GET['return']. ".php";
          echo $returnText ?>"
            ><button class="button is-light is-large">Return</button></a
          >
        </div>
      </section>
    </main>
  </body>
</html>
