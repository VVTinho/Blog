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
<link rel="stylesheet" type="text/css" href="main.css" />
<title>
Blog</title>
<meta charset="UTF-8">
</head>
<body>
	<div id="wrapper">
<div id="header"><h1>
Welcome to the blog</h1>
</div>							<!-- end of header -->
<br>
<a href="post.php"><h2>Post something</h2></a>
<a href="gallery.php"><h2>Look at pictures</h2></a>
<a href="logout.php"><h2>Log out</h2></a>
							<!-- end of form -->
<div id="content">

	<?php
		
$dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon"); /*Öpnnar en kontakt med servern*/
$sql = sprintf("SELECT postID, content, date, deleted FROM posts WHERE deleted=0 ORDER BY postID DESC LIMIT 5  "); /*berättar vad som ska hämtas från servern*/


$res = mysqli_query($dbConn, $sql); /*skickar fråga till servern med de två variablarna*/
$n = 0;
 while ( $row = mysqli_fetch_assoc($res) ) /* om variablarna stämmer så skrivs detta ut och mysqli_fetch_assoc hämtar rader*/
 {
 	
 
 	
	 echo "<p>" . $row['date'] . "</p>";
	 echo "<div class='box'>".   $row['content'] ; 
	 echo "</div>";
	  if ($_SESSION['admin'] =="1")
 
 	echo "<form action='deletepost.php' method='get'>
 	<input type='hidden' name='postID' value='" . $row['postID'] ."'/>
 	<input type='submit' value='Delete post' class='styleinput'>
 	</form>";
 
	 ++$n;	
 }
 if(0 == $n)
 {

	echo "Nothing to show...yet";
 }


mysqli_close($dbConn) ;/*stänger den tidigare öppnade databasen*/

?>

</div> 					<!-- end of content -->
</div>					<!-- end of wrapper -->
</body>
</html>
<?php
function saveToDB($imgName)
{
	$dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon");
	
	//hämta orginalbilden
	$imgData = file_get_contents($_FILES['filen']['tmp_name']);
	$imgData = mysqli_real_escape_string($dbConn, $imgData);
	$catID = (int) $_POST['category'];
	$desc = safeInsert($_POST['description'], $dbConn);
	
	
	
	$sql = "INSERT INTO images (description, imageData, imageName, catID) VALUES ( '$desc', '$imgData', '$imgName', $catID)";
	
	//echo $sql;
	mysqli_query($dbConn, $sql);
	

}
function safeInsert($string, $dbConn)
{
	$dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon");
	$string = mysqli_real_escape_string($dbConn, $string);
	$string = htmlspecialchars($string);
	return $string;
	
}
?>

