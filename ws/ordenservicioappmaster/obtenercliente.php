<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();

$json=array();
	if(isset($_GET["id_cliente"])){
		$id_cliente=$_GET['id_cliente'];
		
		$basedatos=$_GET['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();
		
		
		$consulta="SELECT id_cliente, nombre_cliente, celular, direccion		
			FROM cat_clientes WHERE id_cliente = {$id_cliente}";
		
		
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
			$results["id_cliente"]='';			
			$json[]=$results;
			$conexion->closeConexion();
			echo json_encode($json);
		}
	}else{
			$results["id_cliente"]='';			
			$json[]=$results;
			echo json_encode($json);
	}
	


 ?>