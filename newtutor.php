<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Tutor</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"
    />
  </head>
</head>
<body>
    <main>
        <section class="section container">
            <h1 class="title">Create New Tutor</h1>
            <form class="form" method='POST' action="../panas/dates.php">
                <label class="label" for="name">Name</label>
                <input class="input" type="text" name="name" id="name" required />
                <label class="label" for="email">Email</label>
                <input class="input" type="email" name="email" id="email" required />
                <label for="courses" class="label"
                    >What courses will you tutor?</label
                >
                <?php 
                    require_once 'data/data.php';
                    foreach ($courses as $course){
                    echo '<label for="'.$course["course_name"].'" class="label">';
                    echo '<input class="checkbox" type="checkbox"
                            id="'.$course['course_name'].'"
                            name="courses[]"
                            value="'.$course["course_name"].' "               
                        />';
                    echo " " . $course['course_name'] . "</label>";
                    };
                ?>
                <label for="available" class="label"> What days are you available?</label>
                <?php
                    $label = "label";
                    $checkbox = "checkbox";
                    foreach ($daysoftheweek as $day){
                        echo "<label for='$day' class='$label $checkbox'>
                        <input class='$checkbox' type='$checkbox' name='days[]' value='$day' id='$day' />
                        $day</label>";};
                ?>
                <input class="button is-link" type="submit" value="Sign Up" />
                <input class="button is-danger" type="reset" value="Reset" />
            </form>
        </section>
        <section class="section">
            <a href="index.html"><button class="button is-light is-large">Home</button></a>
        </section>
    </main>
</body>
</html>