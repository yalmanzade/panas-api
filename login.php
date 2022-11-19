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
  </head>
  <body>
    <main class="container">
      <section class="section">
        <div class="container">
          <h1 class="title">Log In</h1>
          <form action="api/login.php" method="POST" class="form">
            <label for="email" class="label">Email</label>
            <input
              type="email"
              class="input"
              id="email"
              name="email"
              required
            />
            <select name="usertype" id="usertype" required>
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
