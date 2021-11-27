<?php 
//produccion
/*
$hostname="localhost";
$database="user_electronicaoriente";
$username="user_cristian";
$password="kunashi1400";
*/

//produccion cliente refritech
$hostname="localhost";
$database="user_refritech";
$username="user_refritech";
$password="kunashi1400";


//local
/*
$hostname="localhost";
$database="electronicaoriente";
$username="root";
$password="";
*/


	$conexion=mysqli_connect($hostname,$username,$password,$database) or die('No se pudo conectar a la base de datos');
	mysqli_set_charset($conexion, "utf8");
	
	
	?>