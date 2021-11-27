<?php 
//produccion
$hostname="localhost";
$database="user_nuevooriente";
$username="user_cristian";
$password="kunashi1400";

//local
// $hostname="localhost";
// $database="nuevooriente";
// $username="root";
// $password="";



	$conexion=mysqli_connect($hostname,$username,$password,$database) or die('No se pudo conectar a la base de datos');
	mysqli_set_charset($conexion, "utf8");
	
	
	?>