<?php
	session_start();

	if (!empty($_POST["Username"]) && isset($_POST["Username"])) {
	  $_SESSION["username"] = $_POST["Username"];
	  $_SESSION["password"] = $_POST["Password"];
	} else {
	  $_SESSION["username"] = NULL;
	  $_SESSION["password"] = NULL;
	}
	
	header("Location: /index.php");
	exit();
?>