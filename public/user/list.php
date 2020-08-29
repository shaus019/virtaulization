<!DOCTYPE html>
<html>
	<head>
		<title> Todo list user portal </title>
	</head>
    <body>
        <div class="heading">
        <h2>Todo list</h2>
        </div>

        <form method = "POST" action="list.php">
            <input type = "text" name = "task_name" class = "login_data" placeholder="Task name">
            <br>
            <input type="hidden" name="username" value="<?php echo $_POST['username'] ?>" />
            <input type = "text" name = "task_detail" class = "login_data" placeholder="Task details">
            <button type = "submit" name = "submit" class = "login_data"> Add </button>
        </form>

        <?php
 
        $username = $_POST['username'];
        $task_name = $_POST['task_name'];
        $task_detail = $_POST['task_detail'];
 
        $db_host   = '192.168.33.20';
        $db_name   = 'todo';
        $db_user   = 'webuser';
        $db_passwd = 'insecure_db_pw';

        $pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

        try {
            $conn = new PDO($pdo_dsn, $db_user, $db_passwd);
            
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        $user_id = $conn -> query("SELECT user_id FROM todo_list") -> fetch()[0];
        print_r($conn -> query("SELECT * FROM todo_list") -> fetch());

        if(isset($task_name) && isset($task_detail)) {
            $conn -> query("INSERT INTO task_item (task_name, task_detail, list_id) VALUE (" . $task_name . ", "
                . $task_detail . ", " . $user_id . ")");
        }

        $q = $conn->query("SELECT * FROM todo_item INNER JOIN todo_list ON todo_list.user_id = todo_item.list_id 
            WHERE todo_list.username = \"". $username . "\"");
        
        echo "<br><table border>";
        while($row = $q->fetch()){
            echo "<tr><td>".$row["task_name"]."</td><td>".$row["task_details"]."</td></tr>\n";
        }
        echo "</table>";
        ?>

	</body>
</html>
