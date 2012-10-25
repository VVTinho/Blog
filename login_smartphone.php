
<?php
require_once("conn.php"); /*hämtar inlogg till servern*/


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
Welcome, please login to continue</h1>
</div>							<!-- end of header -->

<div id="form">
	<p><strong>Login to post</strong></p>
<form method="post" action="login_smartphone.php" class="box">
Name<br><input type="text" name="name"><br>
Password<br><input type="password" name="password"><br>
<input type="submit" value="Login" class="styleinput">
</div>							<!-- end of form -->
<div id="content"><br>
	<h2>Don't have a useraccount?<h2>
		<a href="createuser_smartphone.php">Sign up</a>

<?php
		
        if(isset($_POST['name']))
{

$dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon");

$name = $_POST['name'];
$password = $_POST['password'];

$name = mysqli_real_escape_string($dbConn, $name);
$name = htmlspecialchars($name); 


$sql = "SELECT users.name, users.password, users.admin, posts.deleted from users, posts where users.name = '$name'";

$res = mysqli_query($dbConn, $sql);

if($row = mysqli_fetch_assoc($res))
{
	//det fanns en användare
	echo "<br><br>Hello " . $row["name"];
	$dbpass = $row['password'];
	$salt = substr($dbpass, 0,64);
	$skickatPass = hash('sha256', $salt.$password);
	$skickatMedSalt = $salt . $skickatPass ;

	if ($skickatMedSalt == $dbpass)

	{
		session_start();
		$_SESSION['inloggad'] = "japp";
		$_SESSION['admin'] = $row['admin'];
		$_SESSION['deleted'] = $row['deleted'];
		header("Location:start_smartphone.php");
		die();
		

	}

	else
	{

		echo "<br>Do you remember your password?";
		die();
	}
}
}
?>


</div> 					<!-- end of content -->
</div>					<!-- end of wrapper -->
</body>
</html>
<?php
function safeInsert($string, $dbConn)
{
	$dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "nyblogg");
	$string = mysqli_real_escape_string($dbConn, $string);
	$string = htmlspecialchars($string);
	return $string;
	
}
?>