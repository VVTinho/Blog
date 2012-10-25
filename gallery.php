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
Pictures</h1>
</div>							<!-- end of header -->
<div id="wrapper">
<a href="start.php"><h2>Back to start</h2></a>
<a href="post.php"><h2>Post something</h2></a>
<a href="logout.php"><h2>Log out</h2></a>

<div id="content">
	<?php //displayImage();?>
	<?php createGallery();?>
	<?php
		
        $dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon"); /*Öpnnar en kontakt med servern*/


if (mysqli_connect_errno()) { /*Om det inte gick att få kontakt så visas detta*/
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}


mysqli_close($dbConn) ;/*stänger den tidigare öppnade databasen*/

?>

</div> 					<!-- end of content -->
</div>					<!-- end of wrapper -->
</body>
</html>
<?php

function createGallery()
{
	$dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon");
	$sql = "SELECT imageName, imageID FROM images order by imageID DESC Limit 0, 20";
	
	
	$res = mysqli_query($dbConn, $sql);
	echo"<ul>";
	while ($row = mysqli_fetch_assoc($res))
		{
			$id = $row['imageID'];
			$image = $row['imageName'];
			echo "<li><a href='imageDetail.php?id=$id'><img src='generated/thumb_$image'></a></li>";

		}
	
	
	
}//end function

function saveToDB($imgName)
{
	$dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon");
	
	//hämta orfinalbilden
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
	
	$string = mysqli_real_escape_string($dbConn, $string);
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
	$thumbname = "generated/thumb_" .$namePrefix. $_FILES['filen']['name'];
	imagejpeg($thumb, $thumbname, 60);
	imagedestroy($thumb);
	imagedestroy($image);
 
 }



?>
<?php

function displayImage()
{
	$dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon");
	$sql = "SELECT imageName, description, imageData from images";
	
	
	$res = mysqli_query($dbConn, $sql);
	if ($row = mysqli_fetch_assoc($res))
		{
			$image = $row['imageName'];
			$description = $row['description'];
			echo "<a href='orginal/$image'><img src='generated/500_$image'></a>";
			echo "<p>$description</p>";
			// här kunde vi också haft en länk till en php-sida som hämtade bilden direkt i databasen
			
		}
	else
		{
			echo "<img src='dummy.jpg'>";
		}
	
	
	
}//end function

?>