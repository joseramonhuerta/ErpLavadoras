<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();


$json=array();
	if(isset($_GET)){
		
		
		$basedatos=$_GET['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();
		
		
		$consulta="SELECT id_configuracion,nombre_empresa, direccion, telefono, leyenda1, leyenda2, imprimeticket, enviamensaje  
				FROM cat_configuracion
				WHERE status = 'A' LIMIT 1";
		
		
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
			$results["id_configuracion"]='';			
			$json[]=$results;
			$conexion->closeConexion();
			echo json_encode($json);
		}
	}else{
			$results["id_configuracion"]='';			
			$json[]=$results;
			echo json_encode($json);
	}
	


 ?>