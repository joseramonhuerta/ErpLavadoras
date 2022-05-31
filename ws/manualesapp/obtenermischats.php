<?php 
require_once('db_connect.php');

$json=array();
	
		$id_usuario=$_GET['id_usuario'];
				
		$consulta="SELECT um.id_usuario_manual,m.id_manual,um.id_usuario, m.nombre_manual, m.descripcion_manual, m.paginas,m.nombrepdf,m.precio,m.tipo, CASE m.tipo WHEN 1 THEN 'Manual'
					WHEN 2 THEN 'Video' WHEN 3 THEN 'Asesoria' ELSE 'No definido' END AS tipo_descripcion, m.url, m.id_usuario_tecnico,u.nombre_usuario,u2.nombre_usuario AS nombre_tecnico,u.imagen AS imagen_usuario, u.id_usuario_firebase, u2.imagen AS imagen_sender, u2.id_usuario_firebase AS id_usuario_firebase_sender
					FROM cat_manuales m
					INNER JOIN cat_usuarios_manuales um ON um.id_manual = m.id_manual
					INNER JOIN cat_usuarios u ON u.id_usuario = um.id_usuario
					LEFT JOIN cat_usuarios u2 ON u2.id_usuario = m.id_usuario_tecnico
					WHERE m.id_usuario_tecnico = {$id_usuario} AND um.autorizado = 1 AND m.tipo = 3
					ORDER BY m.id_manual ASC";
					

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
			$results["id_manual"]='';
			$results["nombre_manual"]='';
			$results["descripcion_manual"]='';
			$results["paginas1"]='';
			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	



 ?>