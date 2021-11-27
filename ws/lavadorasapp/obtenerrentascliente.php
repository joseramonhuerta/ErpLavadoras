<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET["id_cliente"])){
		$id_cliente=$_GET['id_cliente'];
				

		
		$consulta="SELECT p.id_pedido, CAST(DATE_FORMAT(p.fecha_entrega,'%d/%m/%Y %h:%i %p') as CHAR) as fecha, p.precio_renta as precio,
		c.calle as direccion,c.colonia, IFNULL(c.celular,'') as celular, p.observaciones,IFNULL(CONCAT(pr.codigo_barra,' - ',pr.descripcion),'') as descripcion, CAST(DATE_FORMAT(p.fecha_ultimo_vencimiento,'%d/%m/%Y %h:%i %p') as CHAR) as fecha_vencimiento,
		CASE p.status_pedido WHEN 0 THEN 'Pendiente' WHEN 1 THEN 'Rentada' WHEN 2 THEN 'Cobrada' WHEN 3 THEN 'Recogida' END as status,
		CASE p.autorizada WHEN 0 THEN 'No Autorizada' WHEN 1 THEN 'Autorizada' END as status_autorizada
		FROM pedidos p
		INNER JOIN cat_clientes c on c.id_cliente = p.id_cliente
		LEFT JOIN cat_productos pr ON pr.id_producto = p.id_producto
		WHERE  p.status = 'A' AND c.id_cliente = {$id_cliente}
		ORDER BY p.fecha_entrega DESC";
		
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
			$results["fecha"]='';
			$results["fecha_vencimiento"]='';
			$results["precio"]='';
			$results["direccion"]='';
			$results["colonia"]='';
			$results["status"]='';
			$results["celular"]='';
			$results["descripcion"]='';
			$results["observaciones"]='';
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	}else{
			$results["id_pedido"]='';
			$results["fecha"]='';
			$results["fecha_vencimiento"]='';
			$results["precio"]='';
			$results["direccion"]='';
			$results["colonia"]='';
			$results["status"]='';
			$results["celular"]='';
			$results["descripcion"]='';
			$results["observaciones"]='';
			$json[]=$results;
			echo json_encode($json);
	}


 ?>