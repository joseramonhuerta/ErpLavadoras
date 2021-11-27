<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();
$basedatos=$_GET['basedatos'];
$conexion->setDataBase($basedatos);
$conexion->conectar();
$json=array();
	
					
			
		
		$consulta="SELECT id_usuario,nombre_usuario FROM cat_usuarios WHERE rol = 4 ORDER BY id_usuario";
		
		
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
			$results["id_usuario"]='';
			$results["nombre_usuario"]='';
			$json[]=$results;
			$conexion->closeConexion();
			echo json_encode($json);
		}
	
	


 ?>