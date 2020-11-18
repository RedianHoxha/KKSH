<?php
	//session_start();
	if(!isset($_SESSION['UserID'])){
		header("location: ../HTML/Homepage.html");
	}
?>