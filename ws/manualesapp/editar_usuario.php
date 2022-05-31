<?php 
require_once('db_connect.php');

$json=array();



if(isset($_POST["id_usuario"]) && isset($_POST["usuario"]) && isset($_POST["nombre"]) && isset($_POST["password"]) && isset($_POST["paterno"]) && isset($_POST["materno"]) && isset($_POST["celular"]) && isset($_POST["tipo_usuario"]) && isset($_POST["conocimientos_tecnicos"])){
	$id_usuario = $_POST['id_usuario'];
	$nombre = $_POST['nombre'];
	$paterno = $_POST['paterno'];
	$materno = $_POST['materno'];
	$celular = $_POST['celular'];
	$usuario = $_POST['usuario'];
	$tipo_usuario = $_POST['tipo_usuario'];	
	$pass = $_POST['password'];
	$conocimientos_tecnicos = $_POST['conocimientos_tecnicos'];
	
	$imagen = null;
	if(isset($_POST['imagen'])){
		$imagen =  $_POST['imagen'];
	}
	
	try{	
		$consulta="UPDATE cat_usuarios SET 
			nombre_usuario = '{$nombre}',
			paterno_usuario = '{$paterno}',
			materno_usuario = '{$materno}',
			celular = '{$celular}',
			email_usuario = '{$usuario}',
			pass = to_base64('{$pass}'),
			conocimientos_tecnicos = '{$conocimientos_tecnicos}',
			status = 'A',
			tipo_usuario = {$tipo_usuario}			
			WHERE id_usuario={$id_usuario}";
		$resultado=mysqli_query($conexion,$consulta);
		
		if(isset($_POST['imagen'])){
			$consulta="UPDATE cat_usuarios SET 
			imagen = '{$imagen}'			
			WHERE id_usuario={$id_usuario}";
			$resultado=mysqli_query($conexion,$consulta);					
		}
		
		$consulta="SELECT id_usuario, nombre_usuario, paterno_usuario, materno_usuario, imagen, celular,email_usuario,tipo_usuario,from_base64(pass) AS password, conocimientos_tecnicos, id_usuario_firebase
		FROM cat_usuarios
		WHERE id_usuario = {$id_usuario}";
		$resultado=mysqli_query($conexion,$consulta);


		if($consulta){			
			if($reg=mysqli_fetch_array($resultado)){
				$msg = 'Se actualizo el usuario correctamente.';
				$json['success'] = true;
				$json['msg'] = $msg;
				$json['datos'][]=$reg;
			}
			header('Content-Type: application/json; charset=utf8');
			mysqli_close($conexion);				
			echo json_encode($json);
		}else{
			$msg = 'Error al actualizar el usuario.';
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
 