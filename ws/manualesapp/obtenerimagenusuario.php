<?php 
require_once('db_connect.php');

$json=array();
	
		$id_usuario=$_POST['id_usuario'];
				
		$consulta="SELECT imagen AS imagen_usuario
					FROM cat_usuarios 											
					WHERE id_usuario = {$id_usuario}";
					

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
			$results["imagen_usuario"]='';			
			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	



 ?>