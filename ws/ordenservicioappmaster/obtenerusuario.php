<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();


$json=array();
	if(isset($_GET)){
		$id_usuario=$_GET['id_usuario'];
		
		$basedatos=$_GET['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();
		
		
		$consulta="SELECT id_usuario, nombre_usuario, usuario, from_base64(pass) AS pass, rol		
			FROM cat_usuarios WHERE id_usuario = {$id_usuario}";
		
		
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
			$results["id_usuario"]='';			
			$json[]=$results;
			$conexion->closeConexion();
			echo json_encode($json);
		}
	}else{
			$results["id_usuario"]='';			
			$json[]=$results;
			echo json_encode($json);
	}
	


 ?>