<?php 
require_once('db_connect.php');

$json=array();
	
	
				//1=Administrador,2=Supervisor,3=Vendedor,4=Tecnico,5=Super

		$consulta="SELECT id_usuario, nombre_usuario, usuario, rol, CASE rol WHEN 1 THEN 'Administrador' WHEN 2 THEN 'Supervisor' 
		WHEN 3 THEN 'Vendedor' WHEN 4 THEN 'Tecnico' END AS rol_descripcion
			FROM cat_usuarios WHERE rol != 5";
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