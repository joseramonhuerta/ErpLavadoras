<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();

$json=array();
$msg="";

	if(isset($_GET)){
	
		$id_orden = $_GET['id_orden'];
		$basedatos= $_GET['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();		
		
		try{
			
			$consulta="SELECT  o.id_orden_servicio,o.descripcion_falla,o.descripcion_diagnostico,o.descripcion_reparacion,o.importe_presupuesto,o.nombre_equipo,
			IFNULL(c.nombre_cliente, o.nombre_cliente) AS nombre_cliente,CAST(DATE_FORMAT(o.fecha,'%d/%m/%Y') AS CHAR) AS fecha,
CASE o.status_servicio WHEN 1 THEN 'RECIBIDO' WHEN 2 THEN 'EN REVISIÓN' WHEN 3 THEN 'COTIZADO' WHEN 4 THEN 'EN REPARACIÓN' WHEN 5 THEN 'REPARADO' WHEN 6 THEN 'ENTREGADO' WHEN 7 THEN 'DEVOLUCION' END AS status_servicio_descripcion
FROM ordenes_servicio o
LEFT JOIN cat_clientes c ON c.id_cliente = o.id_cliente
WHERE o.id_orden_servicio = {$id_orden}";
			//throw new Exception($consulta);
			$resultado=mysqli_query($conexion->getConexion(),$consulta);
	

			if($consulta){				
				if($reg=mysqli_fetch_array($resultado)){
					$msg = '<table>';
					$msg .= '<tr><td colspan="2" bgcolor="#19c7ff"><h1>Estatus Orden Servicio</h1></td></tr>';
					$msg .= '<tr><td bgcolor="#ccc"><h1>Folio: </h1></td><td><h1>'.$reg['id_orden_servicio'].' </h1></td></tr>';
					$msg .= '<tr><td bgcolor="#ccc"><h1>Fecha: </h1></td><td><h1>'.$reg['fecha'].' </h1></td></tr>';
					$msg .= '<tr><td bgcolor="#ccc"><h1>Cliente: </h1></td><td><h1>'.$reg['nombre_cliente'].' </h1></td></tr>';
					$msg .= '<tr><td bgcolor="#ccc"><h1>Equipo: </h1></td><td><h1>'.$reg['nombre_equipo'].' </h1></td></tr>';
					$msg .= '<tr><td bgcolor="#ccc"><h1>Falla: </h1></td><td><h1>'.$reg['descripcion_falla'].' </h1></td></tr>';
					$msg .= '<tr><td bgcolor="#ccc"><h1>Diagnóstico: </h1></td><td><h1>'.$reg['descripcion_diagnostico'].' </h1></td></tr>';
					$msg .= '<tr><td bgcolor="#ccc"><h1>Reparación: </h1></td><td><h1>'.$reg['descripcion_reparacion'].' </h1></td></tr>';
					$msg .= '<tr><td bgcolor="#ccc"><h1>Presupuesto: </h1></td><td><h1> $'.$reg['importe_presupuesto'].' </h1></td></tr>';
					$msg .= '<tr><td bgcolor="#ccc"><h1>Estatus: </h1></td><td><h1>'.$reg['status_servicio_descripcion'].' </h1></td></tr>';
					$msg .= '</table>';
					

					
				}
				$conexion->closeConexion();
				//header('Content-Type: application/json; charset=utf8');
				echo $msg;
			}else{
				$msg = 'Error al guardar el cliente.';
				
				$conexion->closeConexion();
				echo $msg;
			}		
		}catch(Exception $e){
			$conexion->closeConexion();
			$msg = $e;
			echo $msg;
		
		
		}		
	
	}
	else{
			$msg = 'No se recibieron todos los parametros';
			
			echo $msg;
	}


 ?>