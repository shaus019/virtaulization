<!DOCTYPE html>
<html>

<head>
<title> Todo list admin portal </title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="heading">
        <h2>Todo list</h2>
    </div>

    <form class="form" method="POST" action="index.php">
        <input type = "text" name = "task-id" class = "task_input" placeholder="ID">
        <input type = "text" name = "task" class = "task_input" placeholder="Task">
        <button type = "submit" class = "task_btn" name = "submit"> Edit Task </button>
    </form>
    <br>

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
    
    // delete task
    if (isset($_GET['del_task'])) {

        $id = $_GET['del_task'];

        //send delete request and reload page
        $conn-> exec("DELETE FROM todo_list WHERE id=" . $id);
        header('location: index.php');
    }

    if(isset($_POST['submit'])){

        //is edited task name non-existant
        if(empty($_POST['task']) || empty($_POST['task-id'])){
          $errors = "you must fill in the task and/or ID";
       
        }else{    
            $task = $_POST['task'];
            $id = $_POST['task-id'];

            //update task and reload page
            $up = $conn-> prepare("UPDATE todo_list SET task=\"$task\" WHERE id=$id");
            $up -> execute();
            header('location: index.php');
      }
    }
    
    //retrive the data(tasks) from the databse and put in a table.
    $q = $conn->query("SELECT * FROM todo_list");

    ?>

    <br>
    <table border>
        <thead>
            <tr>
                <th>ID</th>
                <th style="width: 80px;">Task</th>
                <th>Delete</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // print all tasks
            $q = $conn->query("SELECT * FROM todo_list");

            while ($row = $q->fetch()) { 
            ?>
                <tr>
                    <td> <?php echo $row['id']; ?> </td>
                    <td class="task"> <?php echo $row['task']; ?> </td>
                    <td class="delete">
                        <a href="index.php?del_task=<?php echo $row['id'] ?>">x</a>
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>
</body>

</html>