<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();
$basedatos=$_GET['basedatos'];
$conexion->setDataBase($basedatos);
$conexion->conectar();
$json=array();
	
					
			
		
		$consulta="SELECT id_puntodeventa,descripcion_puntodeventa FROM cat_puntosdeventas WHERE status = 'A' ORDER BY id_puntodeventa";
		
		
		$resultado=mysqli_query($conexion->getConexion(),$consulta);

		if($consulta){			
			while ($row = mysqli_fetch_array($resultado)) {
                $json[] = $row;
            }
			$conexion->closeConexion();
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}

		else{
			$results["id_puntodeventa"]='';
			$results["descripcion_puntodeventa"]='';
			$json[]=$results;
			$conexion->closeConexion();
			echo json_encode($json);
		}
	
	


 ?>