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

$id_orden_servicio=$_GET['id_orden_servicio'];	
$token = md5($id_orden_servicio);
$json=array();
$msg="Id: {$id_orden_servicio} \n\n
El equipo  Celular Samsung J4 \n\n
esta en Reparacion \n\n
token {$token}";
	
	echo $msg;



 ?>