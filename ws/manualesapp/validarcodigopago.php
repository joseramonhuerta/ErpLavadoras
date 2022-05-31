<?php 
require_once('db_connect.php');

$json=array();

if(isset($_GET["id_usuario"]) && isset($_GET["total"]) && isset($_GET["codigo"])){
	$id_usuario = $_GET['id_usuario'];
	$total = $_GET['total'];
	$codigo = $_GET['codigo'];
	
	
	try{
		//consultar si ya existe un codigo de pago activo son usar para ese usuario con ese importe
		$consulta="SELECT IFNULL(id_usuario_codigopago,0) as id_usuario_codigopago
				FROM cat_usuarios_codigospagos
				WHERE id_usuario = {$id_usuario} AND codigo = '{$codigo}' AND importe_pago = '{$total}' AND estatus = 'A' and usado = 0";				
			
		$resultado=mysqli_query($conexion,$consulta);				
			
		$reg=mysqli_fetch_array($resultado);
		$id_user_pago=$reg['id_usuario_codigopago'];
							
		if($id_user_pago > 0){
			$consulta="UPDATE cat_usuarios_codigospagos SET usado = 1 WHERE id_usuario_codigopago = {$id_user_pago}";
			$resultado=mysqli_query($conexion,$consulta);	

			$msg = 'Códico validado correctamente.';
			$json['success'] = true;				
		}else{
			$msg = 'No se encontro el código de pago.';	
			$json['success'] = false;			
		}
		
		header('Content-Type: application/json; charset=utf8');
	
		$json['msg'] = $msg;
		$json['datos'][]=[];
		mysqli_close($conexion);
		echo json_encode($json);
				
	}catch(Exception $e){
		$msg = $e->getMessage();
		$json['success'] = false;
		$json['msg'] = $msg;
		$json['datos'][]= [];
		mysqli_close($conexion);
		echo json_encode($json);
	}
}else{
	mysqli_close($conexion);
	$msg = "No se recibieron los parámetros necesarios";
	$json["success"]=false;
	$json["msg"]=$msg;
	$json['datos'][]=[];
	echo json_encode($json);
}