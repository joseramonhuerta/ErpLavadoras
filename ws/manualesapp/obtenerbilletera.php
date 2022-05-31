<?php
require_once('db_connect.php');

$json = array();
$msg = "";
if(isset($_GET['id_usuario']) && isset($_GET['fechainicio']) && isset($_GET['fechafin'])){
	$id_usuario = $_GET['id_usuario'];
	$fechainicio = $_GET['fechainicio'];
	$fechafin = $_GET['fechafin'];	
	$fechainicio .= " 00:00:00";
	$fechafin .= " 23:59:59";
	
	try{
		
		$consulta = "SELECT IFNULL(SUM(uec.cargo),0) AS cargos FROM cat_usuarios_estadocuenta uec
					INNER JOIN cat_usuarios u ON u.id_usuario = uec.id_usuario
					WHERE uec.fecha BETWEEN '{$fechainicio}' AND '{$fechafin}'
					AND uec.id_usuario = {$id_usuario} AND uec.tipo = 1";
					
		$resultado=mysqli_query($conexion,$consulta);				
			
		$reg=mysqli_fetch_array($resultado);
		$cargos=$reg['cargos'];

		$consulta = "SELECT IFNULL(uec.saldo,0) AS saldo FROM cat_usuarios_estadocuenta uec
					INNER JOIN cat_usuarios u ON u.id_usuario = uec.id_usuario
					WHERE uec.id_usuario = {$id_usuario} ORDER BY uec.fecha DESC LIMIT 1";
					
		$resultado=mysqli_query($conexion,$consulta);				
			
		$reg=mysqli_fetch_array($resultado);
		$saldo=$reg['saldo'];
		
		$data = array();
		$data['cargos'] = $cargos;
		$data['saldo'] = $saldo;

		$msg = '';
		$json['success'] = true;
		$json['msg'] = $msg;
		$json['datos'][]=$data;
		
			
		header('Content-Type: application/json; charset=utf8');
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


?>