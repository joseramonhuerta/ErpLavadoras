<?php 	
//produccion
/*$hostname="localhost";
$database="user_electronicaoriente";
$username="user_cristian";
$password="kunashi1400";
*/
//local
/*
$hostname="localhost";
$database="electronicaoriente";
$username="root";
$password="";
*/

public class Conexion{
	var $hostname="localhost";
	var $database="";
	var	$username="root";
	var $password="";
	var $conexion="";
	
	public function getConexion(){
		
		return $this->conexion;
	}
	
	public function setDataBase($database){
		
		$this->database = $database;
	}
	
	public function conectar(){
		$this->conexion=mysqli_connect($this->hostname,$this->username,$this->password,$this->database) or die('No se pudo conectar a la base de datos');
		mysqli_set_charset($this->conexion, "utf8");
	}
	
	public function closeConexion(){
		mysqli_close($this->conexion);
	}
	
}
	
	
?>