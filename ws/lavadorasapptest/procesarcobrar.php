<?php 
require_once('db_connect.php');

$json=array();
$msg="";
	if(isset($_GET["id_pedido"])){
		$id_pedido=$_GET['id_pedido'];		
		
		
		//Cambiar el estatus del pedido a recogido
		//Cambiar el estatus de la asignacion de la lavadora a 1=Asignada al trabajador porque la recogio del cliente		
		
		try{
			//busco el precio de renta para generar el pago  DATE_FORMAT(p.fecha_ultimo_vencimiento,'%d/%m/%Y %h:%i %p')
			$consulta="SELECT p.precio_renta,p.fecha_ultimo_vencimiento,p.plazo_pago
			FROM pedidos p
			WHERE p.id_pedido = {$id_pedido}";
			$resultado=mysqli_query($conexion,$consulta);				
			
			$reg=mysqli_fetch_array($resultado);
			$importe=$reg['precio_renta'];
			$fecha_ultimo_vencimiento=$reg['fecha_ultimo_vencimiento'];
			$plazo_pago=$reg['plazo_pago'];
			$dias = 0;
			switch ($plazo_pago) {
				case 1:
					$dias = 7;
					break;
				case 2:
					$dias = 1;
					break;
				case 3:
					$dias = 2;
					break;
				case 4:
					$dias = 3;
					break;
			}
			
						
			
				
			
			//genero el pago
			$consulta="INSERT INTO pagos(id_pedido,fecha_pago,importe,status, origen) values({$id_pedido},now(),{$importe},'A',2)";
			$resultado=mysqli_query($conexion,$consulta);
			
			$id = mysqli_insert_id($conexion);
			
			//actualizo la ultima fecha de pago, tambien debo actualizar la ultima fecha de pago y fecha_ultimo vencimiento que es la fecha de pago mas los dias de renta ,fecha_ultimo_vencimiento=ADDDATE(fecha_ultimo_vencimiento,{$dias})
			$consulta="UPDATE pedidos SET fecha_ultimo_pago=now(),fecha_ultimo_vencimiento=ADDDATE(fecha_ultimo_vencimiento,{$dias}),
			status_renta = 1,id_ultimo_pago={$id},Observaciones='' WHERE id_pedido={$id_pedido}";
			$resultado=mysqli_query($conexion,$consulta);	
			
			$consulta="SELECT p.id_pago,CAST(DATE_FORMAT(p.fecha_pago,'%d/%m/%Y %h:%i %p') as CHAR) as fecha_pago,p.importe,
			b.descripcion, b.codigo_barra,CAST(DATE_FORMAT(IFNULL(a.fecha_ultimo_vencimiento,a.fecha_ultimo_pago),'%d/%m/%Y %h:%i %p') as CHAR) as fecha_vencimiento
			FROM pagos p 
			INNER JOIN pedidos a ON a.id_pedido = p.id_pedido
			INNER JOIN cat_productos b ON b.id_producto = a.id_producto
			WHERE p.id_pago = {$id}";
			$resultado=mysqli_query($conexion,$consulta);
			
			
			/*$consulta="SELECT p.id_pedido
			FROM pedidos p 
			WHERE p.id_pedido = {$id_pedido}";
			$resultado=mysqli_query($conexion,$consulta);*/
			
			//Throw new Exception($id);

			if($consulta){
				
				if($reg=mysqli_fetch_array($resultado)){
					$msg = 'Se realizo el cobro';
					$json['success'] = true;
					$json['msg'] = $msg;
					$json['datos'][]=$reg;
				}
				mysqli_close($conexion);
				header('Content-Type: application/json; charset=utf8');
				echo json_encode($json);
			}

			else{
				$msg = 'Error al realizar el cobro';
				$json['success'] = false;
				$json['msg'] = $msg;
				$json['datos'][]=[];
				mysqli_close($conexion);
				echo json_encode($json);
			}		
		}catch(Exception $e){
			mysqli_close($conexion);
			$msg = $e;
			
		
		
		}		
	}
	else{
			$msg = 'No se recibieron todos los parametros';
			//$results["id_pago"]="0";
			$json['success'] = false;
			$json['msg'] = $msg;
			$json['datos'][]=[];
			echo json_encode($json);
	}



 ?>