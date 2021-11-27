<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();


$json=array();
$msg="";

	if(isset($_POST)){
		$id_usuario = $_POST['id_usuario'];
		$nombre_usuario = $_POST['nombre_usuario'];
		$usuario = $_POST['usuario'];		
		$pass = $_POST['pass'];	
		$rol = $_POST['rol'];
		
		$basedatos=$_POST['basedatos'];
		$id_empresa=$_POST['id_empresa'];
		$conexion->setDataBase($basedatos);
		
		
		try{
			
			if($id_usuario > 0){
				$conexion->conectarMaster();
				//verificar que el usuario nuevo no exista en la master y sea diferente al que se esta editando
				$consulta="SELECT IFNULL(id_usuario_empresa,0) as id_usuario_empresa  
					FROM cat_usuarios_empresas ue 
					INNER JOIN cat_usuarios u on u.id_usuario_master = ue.id_usuario_master
					INNER JOIN cat_empresas e on e.id_empresa = ue.id_empresa 	
					WHERE ue.usuario = '{$usuario}' AND ue.pass = to_base64('{$pass}') AND u.estatus = 'A' AND ue.id_usuario <> {$id_usuario}";				
				
				$resultado=mysqli_query($conexion->getConexionMaster(),$consulta);				
					
				$reg=mysqli_fetch_array($resultado);
				$id_user_master=$reg['id_usuario_empresa'];
							
				if($id_user_master > 0){
					$conexion->closeConexionMaster();
					Throw new Exception("El usuario ya existe en la master.");					
				}
				
				//sacar el id_usuaio_master con el id_usuario y id_empresa
				
				$consulta="SELECT ue.id_usuario_empresa,ue.id_usuario_master  
					FROM cat_usuarios_empresas ue 
					INNER JOIN cat_usuarios u on u.id_usuario_master = ue.id_usuario_master
					INNER JOIN cat_empresas e on e.id_empresa = ue.id_empresa 	
					WHERE ue.id_usuario = {$id_usuario} AND ue.id_empresa = {$id_empresa}";				
				
				$resultado=mysqli_query($conexion->getConexionMaster(),$consulta);				
					
				$reg=mysqli_fetch_array($resultado);
				$id_usuario_empresa=$reg['id_usuario_empresa'];
				$id_usuario_master=$reg['id_usuario_master'];
				
				$consulta="UPDATE cat_usuarios SET 
				nombre_usuario = '{$nombre_usuario}',		
				usuario = '{$usuario}',
				rol = {$rol}
				WHERE id_usuario_master={$id_usuario_master}";
				$resultado=mysqli_query($conexion->getConexionMaster(),$consulta);
				
				$consulta="UPDATE cat_usuarios_empresas SET 
				usuario = '{$usuario}',
				pass = to_base64('{$pass}')
				WHERE id_usuario_empresa={$id_usuario_empresa}";
				$resultado=mysqli_query($conexion->getConexionMaster(),$consulta);
				
				$conexion->closeConexionMaster();
				
				//actualizar el usuario en la bd del cliente
				
				$conexion->conectar();
				$consulta="UPDATE cat_usuarios SET 
				nombre_usuario = '{$nombre_usuario}',		
				usuario = '{$usuario}',
				pass = to_base64('{$pass}'),
				rol = {$rol}
				WHERE id_usuario={$id_usuario}";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
								
				$id = $id_usuario; 
				
				$conexion->closeConexion();				
				
			}else{
				//validar que el usuario no exista en la master para ninguna empresa, ya que debe ser unico	
				$conexion->conectarMaster();
				
				$consulta="SELECT IFNULL(id_usuario_empresa,0) as id_usuario_empresa  
					FROM cat_usuarios_empresas ue 
					INNER JOIN cat_usuarios u on u.id_usuario_master = ue.id_usuario_master
					INNER JOIN cat_empresas e on e.id_empresa = ue.id_empresa 	
					WHERE ue.usuario = '{$usuario}' AND ue.pass = to_base64('{$pass}') AND u.estatus = 'A'";				
				
				$resultado=mysqli_query($conexion->getConexionMaster(),$consulta);				
					
				$reg=mysqli_fetch_array($resultado);
				$id_user_master=$reg['id_usuario_empresa'];
							
				if($id_user_master > 0){
					$conexion->closeConexionMaster();
					Throw new Exception("El usuario ya existe en la master.");					
				}
				
				$conexion->closeConexionMaster();
				
				//insertar usuario en la base de datos del cliente
				
				$conexion->conectar();
				
				$consulta="SELECT IFNULL(id_usuario,0) as id FROM cat_usuarios WHERE usuario = '{$usuario}' AND from_base64(pass) = '{$pass}' AND status='A'";				
				
				$resultado=mysqli_query($conexion->getConexion(),$consulta);				
					
				$reg=mysqli_fetch_array($resultado);
				$id_user=$reg['id'];
							
				if($id_user > 0){
					$conexion->closeConexion();
					Throw new Exception("El usuario ya existe.");					
				}
					
				$consulta="INSERT INTO cat_usuarios(nombre_usuario,usuario,pass, rol) 
				values('{$nombre_usuario}', '{$usuario}',  to_base64('{$pass}'), $rol)";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
			
				$id = mysqli_insert_id($conexion->getConexion());
				
				$conexion->closeConexion();


				//insertar el usuario en la base de datos master
				
				$conexion->conectarMaster();
				
				$consulta="INSERT INTO cat_usuarios(id_usuario,nombre_usuario,usuario, rol) 
				values({$id},'{$nombre_usuario}', '{$usuario}', {$rol})";
				$resultado=mysqli_query($conexion->getConexionMaster(),$consulta);
				
				$id_usuario_master = mysqli_insert_id($conexion->getConexionMaster());
			
				$consulta="INSERT INTO cat_usuarios_empresas(id_usuario_master,id_usuario,id_empresa,usuario,pass) 
				values({$id_usuario_master},{$id}, {$id_empresa},'{$usuario}',  to_base64('{$pass}'))";
				$resultado=mysqli_query($conexion->getConexionMaster(),$consulta);
			
				//$id = mysqli_insert_id($conexion->getConexion());
			
				$conexion->closeConexionMaster();
			
			
			}
			
			$conexion->conectar();
			
			$consulta="SELECT id_usuario, nombre_usuario, usuario, from_base64(pass), rol
			FROM cat_usuarios 
			WHERE id_usuario = {$id}";
			$resultado=mysqli_query($conexion->getConexion(),$consulta);
	

			if($consulta){
				
				if($reg=mysqli_fetch_array($resultado)){
					$msg = 'Se guardo el usuario correctamente.';
					$json['success'] = true;
					$json['msg'] = $msg;
					$json['datos'][]=$reg;
				}
				$conexion->closeConexion();
				header('Content-Type: application/json; charset=utf8');
				echo json_encode($json);
			}
			else{
				$msg = 'Error al guardar el usuario.';
				$json['success'] = false;
				$json['msg'] = $msg;
				$json['datos'][]=[];
				$conexion->closeConexion();
				header('Content-Type: application/json; charset=utf8');
				echo json_encode($json);
			}		
		}catch(Exception $e){
			$msg = $e->getMessage();
			$json['success'] = false;
			$json['msg'] = $msg;
			$json['datos'][]=[];
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
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