<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET)){
					
		$id_usuario = $_GET['id_usuario'];
		$limite = $_GET['limite'];
		
		$consulta="SELECT p.id_pedido, p.id_usuario,IFNULL(p.id_usuario_mensajero,0) AS id_mensajero,CAST(DATE_FORMAT(p.fecha,'%d/%m/%Y %h:%i %p') AS CHAR) AS fecha,CAST(DATE_FORMAT(p.fecha,'%d/%m/%Y %h:%i %p') AS CHAR) AS hora,
		u.nombre_usuario AS nombre,p.origen,p.destino,p.descripcion_origen,u.calificacion, p.importe,p.status, CASE p.status WHEN 0 THEN 'PENDIENTE' WHEN 1 THEN 'EN CURSO' WHEN 2 THEN 'FINALIZADA' WHEN 3 THEN 'CANCELADA'END AS descripcion_status,p.origen_latitud,p.origen_longitud,p.destino_latitud,p.destino_longitud,IFNULL(u2.nombre_usuario,'') as nombre_mensajero,u2.celular AS celular_mensajero
		FROM pedidos p
		INNER JOIN cat_usuarios u on u.id_usuario = p.id_usuario
		LEFT JOIN cat_usuarios u2 on u2.id_usuario = p.id_usuario_mensajero
		WHERE p.id_usuario = {$id_usuario} 
		ORDER BY p.fecha DESC LIMIT {$limite};";		
		
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
			$results["id_pedido"]='';
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	}else{
			$results["id_pedido"]='';
			$json[]=$results;
			echo json_encode($json);
	}


 ?>