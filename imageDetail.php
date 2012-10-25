<!doctype html>
<html>
<head>
<title>Bilduppladdning</title>
</head>
<body>
<h1>Bigger picture</h1>




<?php displayImage();?>




</body>

</html>

<?php

function displayImage()
{
	$dbConn = mysqli_connect("simon-163804.mysql.binero.se", "163804_iz98210", "plusplus", "163804-simon");
	$imageID = (int) $_GET['id'];
	$sql = "SELECT imageName, description from images where imageID = $imageID";
	
	
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