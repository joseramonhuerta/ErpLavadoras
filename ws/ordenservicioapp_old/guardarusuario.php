<?php 
require_once('db_connect.php');

$json=array();
$msg="";

	if(isset($_POST)){
	
		$id_usuario = $_POST['id_usuario'];
		$nombre_usuario = $_POST['nombre_usuario'];
		$usuario = $_POST['usuario'];		
		$pass = $_POST['pass'];	
		$rol = $_POST['rol'];
		
		try{
			
			if($id_usuario > 0){
				$consulta="UPDATE cat_usuarios SET 
				nombre_usuario = '{$nombre_usuario}',		
				usuario = '{$usuario}',
				pass = to_base64('{$pass}'),
				rol = {$rol}
				WHERE id_usuario={$id_usuario}";
				$resultado=mysqli_query($conexion,$consulta);
								
				$id = $id_usuario; 
				
				
			}else{
				
				
				//genero el pago
				$consulta="INSERT INTO cat_usuarios(nombre_usuario,usuario,pass, rol) 
				values('{$nombre_usuario}', '{$usuario}',  to_base64('{$pass}'), $rol)";
				$resultado=mysqli_query($conexion,$consulta);
			
				$id = mysqli_insert_id($conexion);
				
				
			}
			
			$consulta="SELECT id_usuario, nombre_usuario, usuario, from_base64(pass), rol
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
				mysqli_close($conexion);
				header('Content-Type: application/json; charset=utf8');
				echo json_encode($json);
			}

			else{
				$msg = 'Error al guardar el cliente.';
				$json['success'] = false;
				$json['msg'] = $msg;
				$json['datos'][]=[];
				mysqli_close($conexion);
				echo json_encode($json);
			}		
		}catch(Exception $e){
			mysqli_close($conexion);
			$msg = $e;
			
		
		
		}		
	
	}
	else{
			$msg = 'No se recibieron todos los parametros';
			$json['success'] = false;
			$json['msg'] = $msg;
			$json['datos'][]=[];
			echo json_encode($json);
	}


 ?>