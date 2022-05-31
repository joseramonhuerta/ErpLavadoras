<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();

$json=array();
	if(isset($_GET["id_puntodeventa"])){
		$id_puntodeventa=$_GET['id_puntodeventa'];
		
		$basedatos=$_GET['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();
		
		
		$consulta="SELECT id_puntodeventa, descripcion_puntodeventa
			FROM cat_puntosdeventas WHERE id_puntodeventa = {$id_puntodeventa}";
		
		
		$resultado=mysqli_query($conexion->getConexion(),$consulta);

		if($consulta){			
			if($reg=mysqli_fetch_array($resultado)){
				$json[]=$reg;
			}
			$conexion->closeConexion();
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}

		else{
			$results["id_puntodeventa"]='';			
			$json[]=$results;
			$conexion->closeConexion();
			echo json_encode($json);
		}
	}else{
			$results["id_puntodeventa"]='';			
			$json[]=$results;
			echo json_encode($json);
	}
	


 ?>