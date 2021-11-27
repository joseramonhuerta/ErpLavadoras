<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();

$json=array();
	
		$basedatos=$_GET['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();
	
				

		$consulta="SELECT id_cliente, nombre_cliente, celular, direccion
			FROM cat_clientes";
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
			$results["id_cliente"]='';
			$results["nombre_cliente"]='';
			$results["celular"]='';
			$results["direccion"]='';
			$json[]=$results;
			$conexion->closeConexion();
			echo json_encode($json);
		}


 ?>