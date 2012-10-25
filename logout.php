<?php

//LOGGA UT ANVÄNDARE
	session_start();
	$_SESSION = array();
	session_destroy(); 
	header("Location:login.php");

?>