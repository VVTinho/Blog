<?php
require_once("conn.php");
$dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon");

session_start();
 
 if ($_SESSION['admin'] =="1")
	{
		$postID = $_GET['postID'];
		$sql = "UPDATE posts SET posts.deleted=1 WHERE posts.postID=$postID";
		mysqli_query($dbConn, $sql);
		header("Location:start.php");
		}
		else
		{
				header("Location:start.php");
			die();
		}
	



?>