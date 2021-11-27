<?php 
$hostname="localhost";
$database="espaciom_nuevoOriente";
//$username="espaciom_cristan";
//$password="kunashi1400";

$username="root";
$password="";
$json=array();
	if(isset($_GET["usuario"]) && isset($_GET["clave"])){
		$usuario=$_GET['usuario'];
		$clave=$_GET['clave'];
		

		$conexion=mysqli_connect($hostname,$username,$password,$database);

		$consulta="SELECT usuario, clave, nombre FROM usuario WHERE usuario= '{$usuario}'AND clave = '{$clave}'";
		$resultado=mysqli_query($conexion,$consulta);

		if($consulta){

			if($reg=mysqli_fetch_array($resultado)){
				$json['datos'][]=$reg;
			}
			mysqli_close($conexion);
			echo json_encode($json);
		}

		else{
			$results["usuario"]='';
			$results["clave"]='';
			$results["nombre"]='';
			$json['datos'][]=$results;
			echo json_encode($json);
		}
	}
	else{
			$results["usuario"]='';
			$results["clave"]='';
			$results["nombre"]='';
			$json['datos'][]=$results;
			echo json_encode($json);
	}



 ?>