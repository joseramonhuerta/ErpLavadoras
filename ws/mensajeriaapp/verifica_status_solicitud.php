<?php 
require_once('db_connect.php');

$json=array();
$msg="";
$sucess=false;
			
	if(isset($_GET)){
		
		$id_pedido=$_GET['id_pedido'];		
		
		try{
			
			
			$sql="SELECT status
				FROM pedidos 
				WHERE id_pedido = {$id_pedido} ";
			$resultado=mysqli_query($conexion,$sql);				
				
			$reg=mysqli_fetch_array($resultado);
			$status=$reg['status'];
					
			
			
			if($status == 3){
				//throw new Exception('La Solicitud fue cancelada.');
				$msg = "La Solicitud fue cancelada por el cliente.";
			}
				
			//$resultado=mysqli_query($conexion,$sql);	
			$sucess=true;
			$results["sucess"]=$sucess;
			$results["status"]=$status;			
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