<?php 
	$currency = '$ ';
    // These variables define the connection information for your MySQL database 
    $username = "root"; 
    $password = "sa123"; 
    $host = "localhost"; 
    $dbname = "dvdhop_schema"; 
    
    
	$db = new mysqli("localhost", "root", "sa123", "dvdshop_schema"); 
	if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
	}
    header('Content-Type: text/html; charset=utf-8'); 
    session_start(); 
?>