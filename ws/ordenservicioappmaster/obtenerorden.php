<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();

$json=array();
	if(isset($_GET["id_orden_servicio"])){
		$id_orden_servicio=$_GET['id_orden_servicio'];
		
		$basedatos=$_GET['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();		
		
		
		$consulta="SELECT o.id_orden_servicio, CAST(DATE_FORMAT(o.fecha,'%d/%m/%Y') as CHAR) as fecha, IFNULL(c.id_cliente, 0) as id_cliente,
			IFNULL(c.nombre_cliente, o.nombre_cliente) as nombre_cliente,o.status_servicio,CASE o.status_servicio WHEN 1 THEN 'RECIBIDO' WHEN 2 THEN 'EN REVISIÓN' WHEN 3 THEN 'COTIZADO' WHEN 4 THEN 'EN REPARACIÓN' WHEN 5 THEN 'REPARADO' WHEN 6 THEN 'ENTREGADO' WHEN 7 THEN 'DEVOLUCION' END AS status_servicio_descripcion,
			o.nombre_equipo,o.modelo_equipo,o.serie_equipo, o.descripcion_falla, o.ruta_imagen,o.nombre_imagen,o.descripcion_diagnostico,o.nombre_tecnico,
			o.descripcion_reparacion,o.importe_presupuesto,o.nombre_imagen,o.imagen,o.token, IFNULL(c.celular, o.celular) as celular,o.id_tecnico,o.nombre_imagen_back,o.imagen_back,o.nombre_imagen_tecnico,o.imagen_tecnico,CAST(DATE_FORMAT(o.fecha_entrega,'%d/%m/%Y') as CHAR) as fecha_entrega		
			FROM ordenes_servicio o
			LEFT JOIN cat_clientes c on c.id_cliente = o.id_cliente
			WHERE o.id_orden_servicio = {$id_orden_servicio}";
		
		
		$resultado=mysqli_query($conexion->getConexion(),$consulta);

		if($consulta){			
			if($reg=mysqli_fetch_array($resultado)){
				$json[]=$reg;
			}
			$conexion->closeConexion();
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}

		else{
			$results["id_orden_servicio"]='';			
			$json[]=$results;
			$conexion->closeConexion();
			echo json_encode($json);
		}
	}else{
			$results["id_orden_servicio"]='';			
			$json[]=$results;
			echo json_encode($json);
	}
	


 ?>