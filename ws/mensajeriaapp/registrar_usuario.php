<?php

require_once('db_connect.php');

$json=array();
$msg="";
$success=false;
	if(isset($_GET)){
		
		$id_usuario = 0;
		$nombre = $_GET['nombre_usuario'];
		$usuario = $_GET['usuario'];
		$pass = $_GET['pass'];
        $celular = $_GET['celular'];
		$rol = (empty($_GET['rol'])) ? "2" : $_GET['rol'];
		$status = "A";
		
		
		try{
			$sql="SELECT IFNULL(id_usuario,0) as id_usuario FROM cat_usuarios WHERE status = 'A' AND usuario = '{$usuario}' AND from_base64(pass)='{$pass}' LIMIT 1";
			$resultado=mysqli_query($conexion,$sql);				
			
			$reg=mysqli_fetch_array($resultado);
			$id_usuario=$reg['id_usuario'];

			//throw new Exception($sql);

			if($id_usuario > 0){						
				$msg = "El usuario ya existe";
				$success=false;
				throw new Exception($msg);							
			}	
			
			$sql = "INSERT INTO cat_usuarios(nombre_usuario, usuario, pass, celular, rol, status) 
				VALUES('{$nombre}', '{$usuario}', to_base64('{$pass}'), '{$celular}', '{$rol}', '{$status}')";
				
			$msg = "Registro exitoso";	
			$success=true;
			$resultado=mysqli_query($conexion,$sql);	
			$results["success"]=$success;	
			$results["msg"]=$msg;
			$json['datos'][]=$results;
			
		}catch(Exception $e){
			$msg = $e->getMessage();	
			$results["success"]=$success;			
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
		$success=false;
		$results["success"]=$success;
		$results["msg"]=$msg;
		$json['datos'][]=$results;
		
		echo json_encode($json);					
	}
 ?>