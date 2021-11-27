<?php 
require_once('db_connect.php');

$json=array();
	
		$filtro=$_GET['filtro'];
		$filtroString="";	
		$id_usuario=(empty($_GET['id_usuario'])) ? 0 : $_GET['id_usuario'];
		$rol = (empty($_GET['rol'])) ? 0 : $_GET['rol'];

		if($filtro > 0){
			$filtroString=" WHERE status_servicio={$filtro}";
			if($rol == 4)
				$filtroString .= " AND id_tecnico={$id_usuario}";
		}else{
			if($rol == 4)
				$filtroString .= " WHERE id_tecnico={$id_usuario}";
		}		
			

		
			
		
		$consulta="SELECT p.id_orden_servicio, CAST(DATE_FORMAT(p.fecha,'%d/%m/%Y') as CHAR) as fecha,p.nombre_equipo,
			p.nombre_cliente,p.descripcion_falla,p.status_servicio,CASE p.status_servicio WHEN 1 THEN 'RECIBIDO' WHEN 2 THEN 'EN REVISIÓN' WHEN 3 THEN 'COTIZADO' WHEN 4 THEN 'EN REPARACIÓN' WHEN 5 THEN 'REPARADO' WHEN 6 THEN 'ENTREGADO' WHEN 7 THEN 'DEVOLUCION' END AS status_servicio_descripcion,
			p.id_tecnico
			FROM ordenes_servicio p $filtroString ORDER BY p.fecha DESC";
		
		
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
			$results["id_orden_servicio"]='';
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	


 ?>