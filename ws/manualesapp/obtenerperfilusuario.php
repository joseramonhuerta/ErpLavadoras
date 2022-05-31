<?php 
require_once('db_connect.php');

$json=array();



if(isset($_POST["id_usuario"])){
	$id_usuario = $_POST['id_usuario'];
	
	
	try{
				
		$consulta="SELECT id_usuario, nombre_usuario, paterno_usuario, materno_usuario, celular,email_usuario,IFNULL(imagen,'') AS imagen
		FROM cat_usuarios
		WHERE id_usuario = {$id_usuario}";
		$resultado=mysqli_query($conexion,$consulta);


		if($consulta){			
			if($reg=mysqli_fetch_array($resultado)){
				$msg = '';
				$json['success'] = true;
				$json['msg'] = $msg;
				$json['datos'][]=$reg;
			}
			header('Content-Type: application/json; charset=utf8');
			mysqli_close($conexion);				
			echo json_encode($json);
		}else{
			$msg = 'Error al obtener el usuario.';
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