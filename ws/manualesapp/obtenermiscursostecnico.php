<?php 
require_once('db_connect.php');

$json=array();
	
		$id_usuario=$_GET['id_usuario'];
				
		$consulta="SELECT m.id_manual,u.id_usuario, u.nombre_usuario, m.nombre_manual, m.descripcion_manual, m.paginas,m.nombrepdf,m.precio,m.tipo, CASE m.tipo WHEN 1 THEN 'Manual'
					WHEN 2 THEN 'Video' WHEN 3 THEN 'Asesoria' ELSE 'No definido' END AS tipo_descripcion, m.url,
					m.id_categoria, c.nombre_categoria, m.esgratuito,
					m.url_portada, m.url_detalle, CASE m.status WHEN 'A' THEN 1 WHEN 'I' THEN 0 END AS status_manual			
					FROM cat_manuales m					
					INNER JOIN cat_usuarios u ON u.id_usuario = m.id_usuario_creador
					INNER JOIN cat_categorias c ON c.id_categoria = m.id_categoria									
					WHERE m.id_usuario_creador = {$id_usuario}
					ORDER BY m.id_manual ASC";
		/*mim.imagen AS imagen_miniatura, mid.imagen AS imagen_detalle			*/					

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