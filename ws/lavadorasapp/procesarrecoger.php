<?php 
require_once('db_connect.php');

$json=array();
$msg="";
	if(isset($_GET["id_pedido"])){
		$id_pedido=$_GET['id_pedido'];
		$id_usuario=$_GET['id_usuario'];	
		$id_trabajador=$_GET['id_trabajador'];	

		//Cambiar el estatus del pedido a recogido
		//Cambiar el estatus de la asignacion de la lavadora a 1=Asignada al trabajador porque la recogio del cliente		
		
		try{
			
			$consulta="UPDATE pedidos SET status_pedido=3,fecha_recogida=now() WHERE id_pedido={$id_pedido}";
			$resultado=mysqli_query($conexion,$consulta);			
			
			$consulta="SELECT a.id_asignacion
			FROM asignadas a
			INNER JOIN pedidos p ON p.id_pedido = a.id_pedido
			WHERE p.id_pedido = {$id_pedido}";
			$resultado=mysqli_query($conexion,$consulta);			
			
			
			$reg=mysqli_fetch_array($resultado);
			$id_asignacion=$reg['id_asignacion'];
			
			//throw new Exception($id_asignacion);
			
			$consulta="UPDATE asignadas SET status_asignacion=1 WHERE id_asignacion={$id_asignacion}";
			$resultado=mysqli_query($conexion,$consulta);	
			
			
			$consulta="SELECT p.id_pedido
			FROM pedidos p 
			WHERE p.id_pedido = {$id_pedido}";
			$resultado=mysqli_query($conexion,$consulta);
			
			//Throw new Exception($id);

			if($consulta){
				
				if($reg=mysqli_fetch_array($resultado)){
					$msg = 'Se recogio lavadora';
					$json['success'] = true;
					$json['msg'] = $msg;
					$json['datos'][]=$reg;
				}
				mysqli_close($conexion);
				header('Content-Type: application/json; charset=utf8');
				echo json_encode($json);
			}

			else{
				$msg = 'Error al recoger lavadora';
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