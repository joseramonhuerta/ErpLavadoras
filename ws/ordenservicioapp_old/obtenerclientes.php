<?php 
require_once('db_connect.php');

$json=array();
	
	
				

		$consulta="SELECT id_cliente, nombre_cliente, celular, direccion
			FROM cat_clientes";
		$resultado=mysqli_query($conexion,$consulta);

		if($consulta){			
			while ($row = mysqli_fetch_array($resultado)) {
                $json[] = $row;
            }
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}

		else{
			$results["id_cliente"]='';
			$results["nombre_cliente"]='';
			$results["celular"]='';
			$results["direccion"]='';
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}


 ?>