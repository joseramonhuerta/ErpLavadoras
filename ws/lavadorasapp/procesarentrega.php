<?php 
require_once('db_connect.php');

$json=array();
$msg="";
	if(isset($_GET["id_pedido"]) && isset($_GET["id_trabajador"]) && isset($_GET["id_asignacion"]) && isset($_GET["id_producto"]) && isset($_GET["precio_renta"])){
		$id_pedido=$_GET['id_pedido'];
		$id_trabajador=$_GET['id_trabajador'];
		$id_asignacion=$_GET['id_asignacion'];	
		$id_producto=$_GET['id_producto'];		
		$importe=$_GET['precio_renta'];	 
		$id_usuario=$_GET['id_usuario'];
		
		
		//Cambiar el estatus del pedido a entregada y ligar el producto al pedido, actualizar la ultima fecha pago
		//Cambiar el estatus de la asignacion de la lavadora a 3=Entregada al cliente		
		//Generar pago de la lavadora
		try{
			
			$consulta="SELECT p.plazo_pago
			FROM pedidos p
			WHERE p.id_pedido = {$id_pedido}";
			$resultado=mysqli_query($conexion,$consulta);				
			
			$reg=mysqli_fetch_array($resultado);
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
			//fecha_ultimo_vencimiento=ADDDATE(fecha_ultimo_vencimiento,{$dias})
			
			
			$consulta="UPDATE asignadas SET status_asignacion=3,id_pedido={$id_pedido} WHERE id_asignacion={$id_asignacion}";
			$resultado=mysqli_query($conexion,$consulta);
			
			
			
			$consulta="INSERT INTO pagos(id_pedido,fecha_pago,importe,status,id_trabajador,origen,usercreador,fechacreador) values({$id_pedido},now(),{$importe},'A',{$id_trabajador},2,{$id_usuario},now())";
			$resultado=mysqli_query($conexion,$consulta);
			
			$id = mysqli_insert_id($conexion);
			
			$consulta="UPDATE pedidos SET id_producto={$id_producto},status_pedido=1,fecha_ultimo_pago=now(),fecha_entrega_cliente=now(), id_ultimo_pago={$id} WHERE id_pedido={$id_pedido}";
			$resultado=mysqli_query($conexion,$consulta);
			
			$consulta="SELECT p.id_pago,CAST(DATE_FORMAT(p.fecha_pago,'%d/%m/%Y %h:%i %p') as CHAR) as fecha_pago,p.importe,
			b.descripcion, b.codigo_barra,CAST(DATE_FORMAT(IFNULL(a.fecha_ultimo_vencimiento,a.fecha_ultimo_pago),'%d/%m/%Y %h:%i %p') as CHAR) as fecha_vencimiento
			FROM pagos p 
			INNER JOIN pedidos a ON a.id_pedido = p.id_pedido
			INNER JOIN cat_productos b ON b.id_producto = a.id_producto
			WHERE p.id_pago = {$id}";
			$resultado=mysqli_query($conexion,$consulta);
			
			//Throw new Exception($id);

			if($consulta){
				
				if($reg=mysqli_fetch_array($resultado)){
					$msg = 'Asignada correctamente';
					$json['success'] = true;
					$json['msg'] = $msg;
					$json['datos'][]=$reg;
				}
				mysqli_close($conexion);
				header('Content-Type: application/json; charset=utf8');
				echo json_encode($json);
			}

			else{
				$msg = 'Error en la asignacion';
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