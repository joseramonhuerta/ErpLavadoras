<?php 
require_once('db_connect.php');

$json=array();



if(isset($_POST["usuario"]) && isset($_POST["nombre"]) && isset($_POST["password"]) && isset($_POST["paterno"]) && isset($_POST["materno"]) && isset($_POST["celular"])){
	$nombre = $_POST['nombre'];
	$paterno = $_POST['paterno'];
	$materno = $_POST['materno'];
	$celular = $_POST['celular'];
	$usuario = $_POST['usuario'];
	$tipo_usuario = 1;
	$pass = $_POST['password'];
	
	$imagen = null;
	if(isset($_POST['imagen'])){
		$imagen =  $_POST['imagen'];
	}
	
	try{
		//consultar si ya existe un usuario con el mismo correo y la misma contraseña
		$consulta="SELECT IFNULL(id_usuario,0) as id_usuario
				FROM cat_usuarios
				WHERE email_usuario = '{$usuario}' AND pass = to_base64('{$pass}') AND status = 'A'";				
			
		$resultado=mysqli_query($conexion,$consulta);				
			
		$reg=mysqli_fetch_array($resultado);
		$id_user=$reg['id_usuario'];
							
		if($id_user > 0){
			Throw new Exception("El usuario ya existe.");					
		}
		
		//Si es un tipo de usuario 2=Tecnico, validar el codigo de registro que esta proporcionando
		/*
		if($tipo_usuario == 2){
			$consulta = "SELECT codigo_registro FROM cat_configuraciones_app LIMIT 1";
			$resultado = mysqli_query($conexion, $consulta);
			$reg = mysqli_fetch_array($resultado);
			if($codigo_registro != $reg['codigo_registro']){
				Throw new Exception("El codigo de registro no es válido.");	
			}
		}
		*/
		
		$consulta="INSERT INTO cat_usuarios(nombre_usuario, paterno_usuario, materno_usuario, celular,email_usuario,pass, status, tipo_usuario) 
			values('{$nombre}', '{$paterno}', '{$materno}', '{$celular}', '{$usuario}', to_base64('{$pass}'), 'A', {$tipo_usuario})";
			$resultado=mysqli_query($conexion,$consulta);
		
		$id = mysqli_insert_id($conexion);
		
		if(isset($_POST['imagen'])){
			$consulta="UPDATE cat_usuarios SET 
			imagen = '{$imagen}'			
			WHERE id_usuario={$id}";
			$resultado=mysqli_query($conexion,$consulta);					
		}
		
		$consulta="SELECT id_usuario, nombre_usuario, paterno_usuario, materno_usuario, celular,email_usuario,tipo_usuario
		FROM cat_usuarios
		WHERE id_usuario = {$id}";
		$resultado=mysqli_query($conexion,$consulta);


		if($consulta){			
			if($reg=mysqli_fetch_array($resultado)){
				$msg = 'Se guardo el usuario correctamente.';
				$json['success'] = true;
				$json['msg'] = $msg;
				$json['datos'][]=$reg;
			}
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
 