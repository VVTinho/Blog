<?php
require_once("conn.php"); /*hämtar inlogg till servern*/


?>
<?php
session_start();

if (isset ($_SESSION['inloggad']))
	{
		if (!$_SESSION['inloggad'] =="japp")
		{
				echo "this site demands a valid useraccount";
			die();
		}
	}
	else 

	{
		echo "Don't have a useraccount? <a href='createuser.php'>Create one</a><br>Already user?<a href='login.php'>Login</a>";
		die();
	}


	/*     LOGGA UT ANVÄNDARE
	session_start();
	$_SESSION = array();
	session_destroy();  */
?>
<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="mainphone.css" />
<title>
Blog</title>
<meta charset="UTF-8">
</head>
<body>
	<div id="wrapper">
<div id="header"><h1>
Post a post</h1><br>
</div>							<!-- end of header -->
<form method="post" action="post_smartphone.php">
        Post:<br><textarea name="content"></textarea><br>
        <input type="submit" value="post" class="styleinput">
        </form>
</form>
<a href="start_smartphone.php"><h2>Return to first page</h2></a>

<?php
		
        $dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon"); /*Öpnnar en kontakt med servern*/


if (mysqli_connect_errno()) { /*Om det inte gick att få kontakt så visas detta*/
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

if (isset($_POST['content']))
{
	
	$content = safeInsert($_POST['content'] );
	
	
	$insertSQL = "INSERT INTO posts (content, date) VALUE ('$content', NOW() ) ";
	mysqli_query($dbConn, $insertSQL);
	//header("Location:start.php");
	
}
?>
</div>					<!-- end of wrapper -->

</body>
</html>
<?php
function safeInsert($string)
{
	$string = htmlspecialchars($string);
	return $string;
	
}
?>
