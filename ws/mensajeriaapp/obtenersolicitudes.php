<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET)){
					

		
		$consulta="SELECT p.id_pedido, p.id_usuario,CAST(DATE_FORMAT(p.fecha,'%d/%m/%Y %h:%i %p') AS CHAR) AS fecha,
		u.nombre_usuario AS nombre,p.origen,p.destino,p.descripcion_origen,u.calificacion, p.importe,p.status, CASE p.status WHEN 0 THEN 'PENDIENTE' WHEN 1 THEN 'EN CURSO' WHEN 2 THEN 'FINALIZADA' END AS descripcion_status,p.origen_latitud,p.origen_longitud,p.destino_latitud,p.destino_longitud,u.celular
		FROM pedidos p
		INNER JOIN cat_usuarios u on u.id_usuario = p.id_usuario
		WHERE  p.status = 0
		ORDER BY p.fecha DESC";
		
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
			mysqli_close($conexion);
			echo json_encode($json);
	}


 ?>