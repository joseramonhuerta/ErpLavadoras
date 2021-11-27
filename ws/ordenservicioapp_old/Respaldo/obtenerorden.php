<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET["id_orden_servicio"])){
		$id_orden_servicio=$_GET['id_orden_servicio'];
		
		
		$consulta="SELECT id_orden_servicio, CAST(DATE_FORMAT(fecha,'%d/%m/%Y') as CHAR) as fecha,
			nombre_cliente,status_servicio,CASE status_servicio WHEN 1 THEN 'RECIBIDO' WHEN 2 THEN 'EN REVISIÓN' WHEN 3 THEN 'COTIZADO' WHEN 4 THEN 'EN REPARACIÓN' WHEN 5 THEN 'REPARADO' WHEN 6 THEN 'ENTREGADO' WHEN 7 THEN 'DEVOLUCION' END AS status_servicio_descripcion,
			nombre_equipo,modelo_equipo,serie_equipo, descripcion_falla, ruta_imagen,nombre_imagen,descripcion_diagnostico,nombre_tecnico,
			descripcion_reparacion,importe_presupuesto,nombre_imagen,imagen,token, celular,id_tecnico		
			FROM ordenes_servicio WHERE id_orden_servicio = {$id_orden_servicio}";
		
		
		$resultado=mysqli_query($conexion,$consulta);

		if($consulta){			
			if($reg=mysqli_fetch_array($resultado)){
				$json[]=$reg;
			}
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}

		else{
			$results["id_orden_servicio"]='';			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	}else{
			$results["id_orden_servicio"]='';			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	


 ?>