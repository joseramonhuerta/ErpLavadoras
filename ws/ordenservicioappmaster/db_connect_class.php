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

class Conexion{
	var $hostname="localhost";
	var $database="";
	var $database_master="user_master_ordenesservicio";
	var	$username="user_cristian";
	var $password="kunashi1400";
	var $conexion="";
	var $conexion_master="";
	
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
	
	public function getConexionMaster(){
		
		return $this->conexion_master;
	}
	
	public function closeConexionMaster(){
		mysqli_close($this->conexion_master);
	}
	
	public function conectarMaster(){
		$this->conexion_master=mysqli_connect($this->hostname,$this->username,$this->password,$this->database_master) or die('No se pudo conectar a la base de datos Master');
		mysqli_set_charset($this->conexion_master, "utf8");
	}
	
	
}
	
	
?>