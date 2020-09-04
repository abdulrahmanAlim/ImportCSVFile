<?php
session_start();
$db_name = $_SESSION['db_name'];

	$connect = mysqli_connect("localhost", "root", "", $db_name);
	if (!$connect) 
	{
	    echo "Please go back to Database Connection Page to initialize a new Database";
	}


	if(isset($_POST["submit"]))
	{
	if($_FILES['file']['name'])
	{
		$filename = explode(".", $_FILES['file']['name']);
		if($filename[1] == 'csv')
		{
			$handle = fopen($_FILES['file']['tmp_name'], "r");
			while($data = fgetcsv($handle))
			{
				$item1 = mysqli_real_escape_string($connect, $data[0]);  
				$item2 = mysqli_real_escape_string($connect, $data[1]);
				$item3 = mysqli_real_escape_string($connect, $data[2]);
				$item4 = mysqli_real_escape_string($connect, $data[3]);
				$item5 = mysqli_real_escape_string($connect, $data[4]);
				$query = "INSERT into CSVDATA (client, deal , hour , accepted , rejected) values('$item1','$item2','$item3','$item4','$item5')";
				mysqli_query($connect, $query);
			}
			fclose($handle);
			echo "<script>alert('Import done');</script>";
		}
	}
}

		if(isset($_POST['delete_table']))
		{
			$sql = "DROP DATABASE ".$db_name;
			$result = mysqli_query($connect , $sql) or die("Please go back to Database Connection Page to initialize a new Database ");
			echo "Please go back to Database Connection Page to initialize a new Database";
		}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<style>
		table{
			border-collapse: collapse;
			width: 100%;
			color: black;
			font-size: 25px;
			text-align: left;
		}
		th{
			background-color: black;
			color: black;
		}
		tr:nth-child(even) {background-color: #f2f2f2}
	</style>
</head>
<body>
	<form method="post" enctype="multipart/form-data">
		<div align="center">
			<label>Select CSV File:</label>
			<input type="file" name="file" />
			<a href="index.php"><input value="DB Connection Page" class="btn btn-success" /></a>
			<input type="submit" name="submit" value="Import" class="btn btn-info" />
			<input type="submit" name="show_data" value="Show Data" class="btn btn-warning" />
			<input type="submit" name="delete_table" value="Delete Database" class="btn btn-danger" />
			<br><br>
			
		</div>
	</form><br><br>

	<?php
	if(isset($_POST["show_data"]))
	{
	$sql = "SELECT * FROM CSVDATA";
	$result = mysqli_query($connect , $sql) or die("bad query: $sql");
	if(mysqli_num_rows($result)> 0) 
	{
		
		echo "<table border='1'>";
		echo "<tr> <td>ID</td> <td>CLIENT</td> <td>DEAL</td> <td>HOUR</td> <td>ACCEPTED</td> <td>REJECTED</td></tr>";
		while($row = mysqli_fetch_assoc($result))
		{
			echo "<tr> <td>{$row['id']}</td> <td>{$row['client']}</td> <td>{$row['deal']}</td> <td>{$row['hour']}</td> <td>{$row['accepted']}</td> <td>{$row['rejected']}</td></tr>";
		}
		echo "</table>";
		
	}
	else
	{
		echo "No data";
	}
	}

	?>

  </body>
  </html>