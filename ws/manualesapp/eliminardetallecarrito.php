<?php 
require_once('db_connect.php');

$json=array();
$msg="";
	if(isset($_GET)){
		$id_carrito_compras_detalle=$_GET['id_carrito_compras_detalle'];		
				
		try{		
			
			$consulta="DELETE FROM carrito_compras_detalles WHERE id_carrito_compras_detalle={$id_carrito_compras_detalle}";
			$resultado=mysqli_query($conexion,$consulta);	
			
			$msg = 'Se elimino el detalle';
			$json['success'] = true;
			$json['msg'] = $msg;
			$json['datos'][]=[];	
			
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
			
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