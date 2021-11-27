<?php 
require_once('db_connect.php');

$json=array();
$msg="";
$sucess=false;
	if(isset($_GET)){
		
		$id_pedido=$_GET['id_pedido'];
		$id_usuario=$_GET['id_usuario'];
		
		try{
			
			
			$sql = "UPDATE pedidos set id_usuario_mensajero=NULL, fecha_aceptado = NULL, status = 0 WHERE id_pedido = {$id_pedido}";
			
			$resultado=mysqli_query($conexion,$sql);	
			
			$msg = "Solicitud rechazada";			
			$sucess=true;
			$results["sucess"]=$sucess;
			$results["msg"]=$msg;
			$json['datos'][]=$results;
			
		}catch(Exception $e){
			$msg = $e->getMessage();
			$sucess=false;
			$results["sucess"]=$sucess;			
			$results["msg"]=$msg;
			$json['datos'][]=$results;
			
		}		
		
		mysqli_close($conexion);
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($json);
		
		
	}
	else{
			mysqli_close($conexion);
			
			$msg="No se recibieron parámetros";
			$sucess=false;
			$results["sucess"]=$sucess;
			$results["msg"]=$msg;
			$json['datos'][]=$results;
			
			echo json_encode($json);
						
	}



 ?>