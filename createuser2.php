<?php		

if(isset($_POST['name']))
{

$dbConn = mysqli_connect("localhost", "root", "", "nyblogg");

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


$sql = "INSERT INTO `nyblogg`.`users` ('name', 'password', 'email') VALUES ('$name', '$password', '$email')";

mysqli_query($dbConn, $sql);
/*header('location: ../Nyblogg/post.php'); */

echo $sql;

}
?>
<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="main.css" />
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
<input type="submit" value="Send">
</form>
</div>	


</div>					<!-- end of wrapper -->
</body>
</html>