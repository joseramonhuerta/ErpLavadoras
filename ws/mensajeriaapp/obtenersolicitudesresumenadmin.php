<?php 
require_once('db_connect.php');

$json=array();
		$busqueda=$_GET['busqueda'];
		$filtro_repartidor=(empty($_GET['filtro_repartidor'])) ? 0 : $_GET['filtro_repartidor'];
		$filtroString="";			
		$filtro=(empty($_GET['filtro'])) ? -1 : $_GET['filtro']-1;
		$limite=(empty($_GET['limite'])) ? 1000 : $_GET['limite'];
		
		$like = "";
		if(strlen($busqueda) > 0){
			$like = " (u.nombre_usuario LIKE '%{$busqueda}%' OR p.origen LIKE '%{$busqueda}%' OR p.destino LIKE '%{$busqueda}%' OR p.descripcion_origen LIKE '%{$busqueda}%') ";	
		}

		if($filtro > -1){
			$filtroString=" WHERE p.status={$filtro} ";
			
			if(strlen($like) > 0)
				$filtroString .=" AND $like";
			
			if($filtro_repartidor > 0)
					$filtroString .= " AND p.id_usuario_mensajero={$filtro_repartidor}";
			
		}else{
			if(strlen($like) > 0){
				$filtroString .=" WHERE $like";
				
				if($filtro_repartidor > 0)
					$filtroString .= " AND id_usuario_mensajero={$filtro_repartidor}";
			}else{
				if($filtro_repartidor > 0)
					$filtroString .= " WHERE id_usuario_mensajero={$filtro_repartidor}";
			}		
			
			
					
			
		}	

		
			
		
		$consulta="SELECT p.id_pedido, p.id_usuario,IFNULL(p.id_usuario_mensajero,0) AS id_mensajero,CAST(DATE_FORMAT(p.fecha,'%d/%m/%Y %h:%i %p') AS CHAR) AS fecha,CAST(DATE_FORMAT(p.fecha,'%d/%m/%Y %h:%i %p') AS CHAR) AS hora,
		u.nombre_usuario AS nombre,p.origen,p.destino,p.descripcion_origen,u.calificacion, p.importe,p.status, CASE p.status WHEN 0 THEN 'PENDIENTE' WHEN 1 THEN 'EN CURSO' WHEN 2 THEN 'FINALIZADA' WHEN 3 THEN 'CANCELADA'END AS descripcion_status,p.origen_latitud,p.origen_longitud,p.destino_latitud,p.destino_longitud,IFNULL(u2.nombre_usuario,'') as nombre_mensajero,u2.celular AS celular_mensajero
		FROM pedidos p
		INNER JOIN cat_usuarios u on u.id_usuario = p.id_usuario
		LEFT JOIN cat_usuarios u2 on u2.id_usuario = p.id_usuario_mensajero
		$filtroString ORDER BY p.fecha DESC LIMIT $limite;";
			
		//Throw new Exception($consulta);
		
		
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
	
	


 ?>