<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create New Student</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"
    />
    <link rel="stylesheet" href="static/style.css">
    <script src="scripts/validation.js" defer></script>
  </head>
  <body>
    <main>
      <section class="section container">
        <h1 class="title">Create New Student</h1>
        <form method='POST' action="../panas/api/newstudent.php">
          <label class="label" for="name">Name</label>
          <input class="input" type="text" name="name" id="name" required />
          <label class="label" for="email">Email</label>
          <input class="input" type="email" name="email" id="email" required />
          <input class="button is-link" type="submit" value="Sign Up" />
          <input class="button is-danger" type="reset" value="Reset" />
        </form>
      </section>
    </main>
  </body>
</html>
