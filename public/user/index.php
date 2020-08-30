<?php 
//connect to the databse
  $db_host   = '192.168.33.20';
  $db_name   = 'todo';
  $db_user   = 'webuser';
  $db_passwd = 'insecure_db_pw';

  $pdo_dsn = "mysql:host=$db_host;dbname=$db_name";
  //initialize the error variable
  $errors = "";
  try {
    $conn = new PDO($pdo_dsn, $db_user, $db_passwd);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
  
  //insert a task, when submit button is clicked, and show an error if nothing has entered.
  if (isset($_POST['submit'])) {

    //is the added task empty?
    if (empty($_POST['task'])) {
      $errors = "you must fill in the task";

    } else {
      $task = $_POST['task'];

      //add task and reload page
      $conn->query("INSERT INTO todo_list (task) VALUES ('$task')");
      header('location: index.php');
    }
  }
  ?>
<!DOCTYPE html>
<html>

<head>
  <title> Todo list user portal </title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div class="heading">
    <h2>Todo list</h2>
  </div>

  <form method="POST" action="index.php">
  <?php if (isset($errors)) { ?>
  	<p><?php echo $errors; ?></p>
  <?php } ?>
    <input type="text" name="task" class="task_input">
    <button type="submit" class="task_btn" name="submit"> Add Task </button>
  </form>
  <?php
  //retrive the data(tasks) from the databse and put in a table.
  $q = $conn->query("SELECT * FROM todo_list");

  //print table of all tasks
 echo "<br><table border>";

  while ($row = $q->fetch()) {
    echo "<tr><td>" . $row["id"] . "</td><td>" . $row["task"] . "</td></tr>\n";
  }
  echo "</table>";
  ?>
 
</body>

</html>