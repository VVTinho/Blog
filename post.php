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
<?php

if (isset ($_FILES['filen']))
{
	//om det finns en fil, och den är ok, så sparar vi orginalet,  vi skapar en thumbnail och vi skapar en 
	//mellanstorbild med watermrk på.
	
	if (checkImage($_FILES['filen']['tmp_name']) )
	{
		$tempfile =  $_FILES['filen']['tmp_name'] ;
		//slumpa fram namnet så att vi inte skriver över en befintlig fil
		$slumpnamn =   substr (  md5(uniqid(rand())) ,0, 5)  ;
		$uniqueName = false;
		while (!$uniqueName)
		{
			if (!file_exists ("orginal/". $slumpnamn. $_FILES['filen']['name'] ))
			{
				$uniqueName = true;
				break; 
			}
			else
			{
				$slumpnamn =   substr (  md5(uniqid(rand())) ,0, 5)  ;
			}
		}
		
		//skapa en thumnbail
		generateImage($tempfile, 200, false, "thumb_".$slumpnamn);
		generateImage($tempfile , 500, true, "500_".$slumpnamn);
		$img=  $_FILES['filen']['name'];
		saveToDB($slumpnamn.$img);
		
		
		//flytta filen...
		move_uploaded_file($tempfile,"orginal/".$slumpnamn.$img );
		
	}
}


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
Post a post or post a picture</h1><br>
</div>							<!-- end of header -->
<form method="post" action="post.php">
        Post:<br><textarea name="content"></textarea><br>
        <input type="submit" value="post" class="styleinput">
        		<p>Upload picture</p>
        </form><br>
<textarea name="description">Describe picture:</textarea><br>

<form method="post" action="post.php"  enctype="multipart/form-data">
<input type="file" name="filen"><br>
<input type="submit" value="save picture" class="styleinput">
</form>
<a href="start.php"><h2>Return to first page</h2></a>

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

function saveToDB($imgName)
{
	$dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon");
	
	//hämta orginalbilden
	$imgData = file_get_contents($_FILES['filen']['tmp_name']);
	$imgData = mysqli_real_escape_string($dbConn, $imgData);
	$desc = safeInsert($_POST['description'], $dbConn);
	
	
	
	$sql = "INSERT INTO images (description, imageData, imageName) VALUES ( '$desc', '$imgData', '$imgName')";
	
	//echo $sql;
	mysqli_query($dbConn, $sql);
	

}

function safeInsert($string)
{
	$string = htmlspecialchars($string);
	return $string;
	
}



function checkImage($file)
{
	//simpel check - om det är en bild så har den en höjd
	$check = getimagesize($file);
	
	return $check;

}

function generateImage($tempfile, $thumbHeight, $watermark, $namePrefix)
 {
	
	//Hr kunde man kontrollerat om det är en JPG eller png och använrt imagecreatefromjpeg / imagecreatefrompng
 
	$image = imagecreatefromjpeg($tempfile);
	$orgWidth = imagesx($image);
	$orgHeight = imagesy($image);
	//Här kunde man kollat så att den uppladdade filen inte förstoras beroende på den önskade storleken
	
	if($watermark)
	{
	//Lägg till copyrighttext
	$textcolor =  imagecolorallocate($image, 255,153,0); 
	imagettftext($image, 25, 0 ,10, $orgHeight - 25 , $textcolor, "Chalkduster.ttf","Blog"); 
	}
	
	
	$thumbWidth = ceil( ($orgWidth / $orgHeight) * $thumbHeight);
	$thumb = imagecreatetruecolor ($thumbWidth, $thumbHeight);
	imagecopyresampled($thumb, $image,0,0, 0,0,$thumbWidth,$thumbHeight, $orgWidth,$orgHeight);
	$thumbname = "generated/" .$namePrefix. $_FILES['filen']['name'];
	imagejpeg($thumb, $thumbname, 60);
	imagedestroy($thumb);
	imagedestroy($image);
 
 }
?>