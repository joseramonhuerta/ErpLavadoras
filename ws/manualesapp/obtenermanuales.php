<?php 
require_once('db_connect.php');

$json=array();
		$id_usuario=(empty($_GET['id_usuario'])) ? 0 : $_GET['id_usuario'];	
		$busqueda=$_GET['busqueda'];
		$filtro_tipo = (empty($_GET['filtro_tipo'])) ? 0 : $_GET['filtro_tipo'];
		$filtro_categoria = (empty($_GET['filtro_categoria'])) ? 0 : $_GET['filtro_categoria'];
		$filtroString="";

		$like = "";
		if(strlen($busqueda) > 0){
			$like = " m.nombre_manual LIKE '%{$busqueda}%' AND ";	
		}

		if($filtro_tipo > 0){
			$filtroString = " WHERE $like m.tipo={$filtro_tipo} AND m.status = 'A' AND m.id_usuario_creador <> {$id_usuario} ";
			
			if($filtro_categoria > 0)
					$filtroString .= " AND id_categoria={$filtro_categoria}";
			
		}else{
			$filtroString = " WHERE $like m.status = 'A' AND m.id_usuario_creador <> {$id_usuario} ";
			
			if($filtro_categoria > 0)
					$filtroString .= " AND id_categoria={$filtro_categoria}";
	
		}			

		
		
		$consulta="SELECT m.id_manual, m.nombre_manual, m.descripcion_manual, IFNULL(m.paginas,'') AS paginas,m.nombrepdf,m.precio,m.tipo, CASE m.tipo WHEN 1 THEN 'Manual'
					WHEN 2 THEN 'Video' WHEN 3 THEN 'Asesoria' ELSE 'No definido' END AS tipo_descripcion, m.esgratuito, IFNULL(um.id_usuario_manual,0) AS obtenido, m.calificacion, CONCAT(u.nombre_usuario,' ',u.paterno_usuario,' ',IFNULL(u.materno_usuario,'')) as nombre_usuario, u.id_usuario AS id_usuario_creador,
					'' AS imagen_miniatura, '' as imagen_usuario, '' as imagen_detalle, m.url_portada, m.url_detalle,CASE WHEN IFNULL(TIMESTAMPDIFF(DAY, m.fecha_creador, NOW()),0) > 7 THEN 0 ELSE 1 END AS esnuevo
					FROM cat_manuales m
					INNER JOIN cat_usuarios u ON u.id_usuario = m.id_usuario_creador					
					LEFT JOIN cat_usuarios_manuales um ON um.id_manual = m.id_manual AND um.id_usuario = $id_usuario
					$filtroString
					ORDER BY m.id_manual ASC";
					

		$resultado=mysqli_query($conexion,$consulta);

		if($consulta){			
			while ($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
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
			$results["paginas"]='';
			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	



 ?>