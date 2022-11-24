<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log In</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"
    />
    <link rel="stylesheet" href="static/style.css">
    <script src="scripts/validation.js" defer></script>
  </head>
  <body>
    <main class="container">
      <section class="section">
        <div class="container">
        <?php
          if(isset($_GET['message'])){
            $name = $_GET['message'];
            echo "<div class='notification is-success is-light'>
                Welcome <strong>$name</strong>. You may log in now.
              </div>";
          }
        ?>
          <h1 class="title">Log In</h1>
          <form action="api/userlogin.php" method="post" class="form">
            <label for="email" class="label">Email</label>
            <input
              type="email"
              class="input"
              id="email"
              name="email"
              required
            />
            <label for="usertype" class="label">Login As</label>
            <select type="select" name="usertype" id="usertype" required>
              <option value="0">Student</option>
              <option value="1">Tutor</option>
            </select>
            <br>
            <input class="button is-link" type="submit" value="Login" />
          </form>
        </div>
      </section>
      <section class="section">
        <a href="index.html"><button class="button is-light is-large">Home</button></a>
      </section>
    </main>
  </body>
</html>
