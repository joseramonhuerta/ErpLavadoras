<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();



$json=array();
	if(isset($_GET)){
		$id_gasto=$_GET['id_gasto'];
		
		$basedatos=$_GET['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();
		
		$consulta="SELECT g.id_gasto, CAST(DATE_FORMAT(g.fecha,'%d/%m/%Y') as CHAR) as fecha,
			g.concepto, g.tipo,CASE g.tipo WHEN 1 THEN 'INGRESO' WHEN 2 THEN 'EGRESO' END AS tipo_descripcion,
			g.importe,IFNULL(g.id_orden_servicio,0) AS id_orden_servicio,IFNULL(c.nombre_cliente,'') AS nombre_cliente  
			FROM gastos g
			LEFT JOIN ordenes_servicio o ON o.id_orden_servicio = g.id_orden_servicio
			LEFT JOIN cat_clientes c on c.id_cliente = o.id_cliente
			WHERE g.id_gasto = {$id_gasto}";
		
		
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
			$results["id_gasto"]='';			
			$json[]=$results;
			$conexion->closeConexion();
			echo json_encode($json);
		}
	}else{
			$results["id_gasto"]='';			
			$json[]=$results;
			
			echo json_encode($json);
	}
	


 ?>