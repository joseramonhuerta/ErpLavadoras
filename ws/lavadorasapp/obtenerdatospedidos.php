<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET["id_trabajador"])){
		$id_trabajador=$_GET['id_trabajador'];
				

		
		$consulta="SELECT p.id_pedido, CAST(DATE_FORMAT(p.fecha_entrega,'%d/%m/%Y %h:%i %p') as CHAR) as fecha_entrega, p.precio_renta,
		c.nombre as nombre_cliente,c.calle as direccion,c.colonia, CONCAT(IFNULL(c.telefono1,''),', ',IFNULL(c.telefono2,'')) AS telefonos,IFNULL(c.celular,'') as celular, p.observaciones,p.status_pedido,
		t.nombre as nombre_trabajador	
		FROM pedidos p
		INNER JOIN cat_clientes c on c.id_cliente = p.id_cliente
		INNER JOIN cat_trabajadores t on t.id_trabajador = p.id_trabajador_ocacional
		WHERE  p.status = 'A' AND p.status_pedido = 0 AND p.id_trabajador_ocacional = {$id_trabajador} AND autorizada = 1
		ORDER BY p.fecha_entrega ASC
		";
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
			$results["fecha_entrega"]='';
			$results["precio_renta"]='';
			$results["nombre_cliente"]='';
			$results["direccion"]='';
			$results["colonia"]='';
			$results["telefonos"]='';
			$results["celular"]='';
			$results["observaciones"]='';
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	}else{
			$results["id_pedido"]='';
			$results["fecha_entrega"]='';
			$results["precio_renta"]='';
			$results["nombre_cliente"]='';
			$results["direccion"]='';
			$results["colonia"]='';
			$results["telefonos"]='';
			$results["celular"]='';
			$results["observaciones"]='';
			$json[]=$results;
			echo json_encode($json);
	}


 ?>