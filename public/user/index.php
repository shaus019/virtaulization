<!DOCTYPE html>
<html>
	<head>
		<title> To do list app </title>
	</head>
    <body>
        <div class="heading">
        <h2>This is an app for to do list.</h2>
        </div>

        <form method = "POST" action="index.php">
            <input type = "text" name = "task" class = "task_input">
            <button type = "submit" class = "task_btn" name = "submit"> Add Task </button>
        </form>
        <?php
 
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

        $q = $conn->query("SELECT * FROM todo_item");
        
        echo "<br><table border>";
        while($row = $q->fetch()){
            echo "<tr><td>".$row["list_id"]."</td><td>".$row["task_name"]."</td><td>".$row["task_details"]."</td></tr>\n";
        }
        echo "</table>";
        ?>

	</body>
</html>
