<?php 
require_once('db_connect.php');

$json=array();



if(isset($_POST["id_usuario"]) && isset($_POST["id_usuario_firebase"])){
	$id_usuario = $_POST['id_usuario'];
	$id_usuario_firebase = $_POST['id_usuario_firebase'];	
		
	try{
	
		
		$consulta="UPDATE cat_usuarios SET id_usuario_firebase = '{$id_usuario_firebase}' WHERE id_usuario = {$id_usuario}";
		$resultado=mysqli_query($conexion,$consulta);
		
		if($consulta){
			
			$msg = 'Se guardo el usuario correctamente.';
			$json['success'] = true;
			$json['msg'] = $msg;
			$json['datos'][]=$reg;
			
			header('Content-Type: application/json; charset=utf8');
			mysqli_close($conexion);				
			echo json_encode($json);
		}else{
			$msg = 'Error al guardar el usuario.';
			$json['success'] = false;
			$json['msg'] = $msg;
			$json['datos'][]=[];
			mysqli_close($conexion);
			echo json_encode($json);
		}		
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