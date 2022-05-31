<?php 
//produccion
$hostname="localhost";
$database="servfix_manualesapp";
$username="servfix_electron_oriente";
$password="kunashi1400";


//Pruebas
$hostname="localhost";
$database="servfix_manualesapptest";
$username="servfix_electron_oriente";
$password="kunashi1400";



	$conexion=mysqli_connect($hostname,$username,$password,$database) or die('No se pudo conectar a la base de datos');
	mysqli_set_charset($conexion, "utf8");
	
	
	
	?>