<?php 
require_once('db_connect.php');

$json=array();
	

			

		$consulta="SELECT id_usuario, nombre_usuario, usuario
			FROM cat_usuarios WHERE rol = 1 AND status = 'A'";
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
			$results["id_usuario"]='';
			$results["nombre_usuario"]='';
			$results["usuario"]='';
			$results["rol"]='';
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}


 ?>