<?php		

if(isset($_POST['name']))
{

$dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon");

$name = $_POST['name'];
$password = $_POST['password'];
$email = $_POST['email'];

$slump = time() . "banan" . $name;

$salt = hash('sha256', $slump);


$name = mysqli_real_escape_string($dbConn, $name);
$name = htmlspecialchars($name); 
//$pass = mysqli_real_escape_string($con, $password);
$password = hash('sha256', $salt.$password);
$password = $salt.$password;



$sql = "INSERT INTO users (name, password, email) VALUES ('$name', '$password', '$email')";

mysqli_query($dbConn, $sql);
header('http://wputvecklare.se/simon/login.php'); 


}
?>
<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="mainphone.css" />
<title>
Blog</title>
</head>
<body>
	<div id="wrapper">
<div id="header"><h1>
Create user</h1>
</div>							<!-- end of header -->


<div id="form">
<form method="post" action="createuser.php">
Name<br><input type="text" name="name"><br>
Password<br><input type="password" name="password"><br>
Email<br><input type="text" name="email"><br>
<input type="submit" value="Send" class="styleinput">
<br><br><h2><a href="login_smartphone.php">Go back</a></h2>
</form>





</div>					<!-- end of wrapper -->
</body>
</html>
<?php
function safeInsert($string, $dbConn)
{
	$dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon");
	$string = mysqli_real_escape_string($dbConn, $string);
	$string = htmlspecialchars($string);
	return $string;
	
}
?>