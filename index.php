<?php
session_start();


?>

<!DOCTYPE html>
<html>
<head>
	<title>Connect to Your Database</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
	<form action="index.php" method="post">
		
		<div class="main-wrapper">
			<h1>Enter your Database Information</h1>

			<label>Database Server</label>
			<input type="text" name="db_server" class="input-form"><br>

			<label>Database User</label>
			<input type="text" name="db_user" class="input-form"><br>

			<label>Database Password</label>
			<input type="text" name="db_password" class="input-form"><br>

			<label>Database Name</label>
			<input type="text" name="db_name" class="input-form"><br>


			
			<button class="login-btn" name="submit_btn" type="submit" >Submit</button>
			<a href="import.php"><input  type="button"  id="button2" class="register-btn" value="Go to Import page"></a>
			
			
		</div>
		
	</form>

	<?php

	if(isset($_POST["submit_btn"]))
	{

	$conn = new mysqli($_POST['db_server'],$_POST['db_user'],$_POST['db_password']);

	if ($conn->connect_error) 
	{
	    die("Connection failed: " . $conn->connect_error);
	}

	$sql = "CREATE DATABASE ".$_POST['db_name'];
	$_SESSION['db_name']=$_POST['db_name'];
	if ($conn->query($sql) === TRUE) 
	{

    echo "1. Database created successfully <br/>";
    $conn->select_db($_POST['db_name']);


    $sql_members = "CREATE TABLE CSVDATA (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client VARCHAR(255),
    deal VARCHAR(255),
    hour DATETIME(6),
    accepted VARCHAR(255),
    rejected VARCHAR(255)
    )";


    if ($conn->query($sql_members) === TRUE) 
    {
        echo "2. CSV Table created successfully into <br/>". $_POST['db_name'];

    } 
    else 
    {
        echo "Error creating table: " . $conn->error;
    }
	}
	 else 
    {
    	echo "Database already Exists";
    }
	$conn->close();
	}
	
	?>
	
</body>
</html>