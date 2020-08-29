<!DOCTYPE html>
<html>

<head>
    <title> To do list app </title>
</head>

<body>
    <div class="heading">
        <h2>This is an app for to do list.</h2>
    </div>

    <form method="POST" action="index.php">
        <input type="text" name="task" class="task_input">
        <button type="submit" class="task_btn" name="submit"> Edit Task </button>
    </form>

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

        $conn->query("DELETE FROM todo_list WHERE id=" . $id);
        header('location: index.php');
    }
    //retrive the data(tasks) from the databse and put in a table.
    $q = $conn->query("SELECT * FROM todo_list");
    ?>
    <table border>
        <thead>
            <tr>
                <th>ID</th>
                <th style="width: 80px;">Task</th>
                <th style="width: 20px;">Delete</th>
            </tr>
        </thead>

        <tbody>
            <?php
            // select all tasks if page is visited or refreshed
            $q = $conn->query("SELECT * FROM todo_list");

            $i = 1;
            while ($row = $q->fetch()) { ?>
                <tr>
                    <td> <?php echo $i; ?> </td>
                    <td class="task"> <?php echo $row['task']; ?> </td>
                    <td class="delete">
                        <a href="index.php?del_task=<?php echo $row['id'] ?>">x</a>
                    </td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
</body>

</html>