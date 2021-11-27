<?php 
require_once('db_connect.php');

$json=array();
	
		$filtro=$_GET['filtro'];
		$filtro_tecnico=(empty($_GET['filtro_tecnico'])) ? 0 : $_GET['filtro_tecnico'];
		$filtroString="";	
		$id_usuario=(empty($_GET['id_usuario'])) ? 0 : $_GET['id_usuario'];
		$rol = (empty($_GET['rol'])) ? 0 : $_GET['rol'];
		
		$fechainicio = $_GET['fechainicio'];	
		$datetime="$fechainicio";
		$fechainicio=date('Y-m-d',strtotime($datetime));
		
		$fechafin = $_GET['fechafin'];	
		$datetime="$fechafin";
		$fechafin=date('Y-m-d',strtotime($datetime));

		if($filtro > 0){
		$filtroString=" WHERE status_servicio={$filtro} AND ((p.fecha BETWEEN '{$fechainicio}' AND '{$fechafin}') OR status_servicio NOT IN (6,7))";
			if($rol == 4){
				$filtroString .= " AND id_tecnico={$id_usuario}";
			}else{
				if($filtro_tecnico > 0)
					$filtroString .= " AND id_tecnico={$filtro_tecnico}";
			}
		}else{
			$filtroString .= " WHERE ((p.fecha BETWEEN '{$fechainicio}' AND '{$fechafin}') OR status_servicio NOT IN (6,7))";
			if($rol == 4)
				$filtroString .= " AND id_tecnico={$id_usuario}";
			else{
				if($filtro_tecnico > 0)
					$filtroString .= " AND id_tecnico={$filtro_tecnico}";
			}
		}	

		
			
		
		$consulta="SELECT p.id_orden_servicio, CAST(DATE_FORMAT(p.fecha,'%d/%m/%Y') as CHAR) as fecha,p.nombre_equipo,
			CONCAT(IFNULL(c.nombre_cliente,p.nombre_cliente),' ( ',IFNULL(c.celular,p.celular),' )') AS nombre_cliente,p.descripcion_falla,p.status_servicio,CASE p.status_servicio WHEN 1 THEN 'RECIBIDO' WHEN 2 THEN 'EN REVISIÓN' WHEN 3 THEN 'COTIZADO' WHEN 4 THEN 'EN REPARACIÓN' WHEN 5 THEN 'REPARADO' WHEN 6 THEN 'ENTREGADO' WHEN 7 THEN 'DEVOLUCION' END AS status_servicio_descripcion,
			p.id_tecnico
			FROM ordenes_servicio p 
			LEFT JOIN cat_clientes c on c.id_cliente = p.id_cliente
			$filtroString ORDER BY p.fecha DESC";
			
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
			$results["id_orden_servicio"]='';
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	


 ?>