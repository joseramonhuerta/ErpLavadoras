<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();


$json=array();
$msg="";

	if(isset($_POST)){
		$id_configuracion = $_POST['id_configuracion'];
		$nombre_empresa = $_POST['nombre_empresa'];
		$direccion = $_POST['direccion'];		
		$telefono = $_POST['telefono'];
		$leyenda1 = $_POST['leyenda1'];
		$leyenda2 = $_POST['leyenda2'];			
		$imprimeticket = $_POST['imprimeticket'];
		$enviamensaje = $_POST['enviamensaje'];
		
		$basedatos=$_POST['basedatos'];
		$conexion->setDataBase($basedatos);		
		$conexion->conectar();
		
		try{
			
			if($id_configuracion > 0){								
				
				$consulta="UPDATE cat_configuracion SET 
				nombre_empresa = '{$nombre_empresa}',		
				direccion = '{$direccion}',
				telefono = '{$telefono}',
				leyenda1 = '{$leyenda1}',
				leyenda2 = '{$leyenda2}',
				imprimeticket = {$imprimeticket},
				enviamensaje = {$enviamensaje}
				WHERE id_configuracion={$id_configuracion}";
				//Throw new Exception($consulta);
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
								
				$id = $id_configuracion; 
											
				
			}else{
												
				$consulta="INSERT INTO cat_configuracion(nombre_empresa,direccion,telefono, leyenda1, leyenda2, imprimeticket,enviamensaje,status) 
				values('{$nombre_empresa}','{$direccion}', '{$telefono}', '{$leyenda1}', '{$leyenda2}', {$imprimeticket}, {$enviamensaje}, 'A')";
				//Throw new Exception($consulta);
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
			
				$id = mysqli_insert_id($conexion->getConexion());
			
			
			}
			
			$consulta="SELECT id_configuracion,nombre_empresa, direccion, telefono, leyenda1, leyenda2, imprimeticket, enviamensaje  
				FROM cat_configuracion
				WHERE id_configuracion = {$id}";
				
			$resultado=mysqli_query($conexion->getConexion(),$consulta);
	

			if($consulta){
				
				if($reg=mysqli_fetch_array($resultado)){
					$msg = 'Se guardo la configuracion correctamente.';
					$json['success'] = true;
					$json['msg'] = $msg;
					$json['datos'][]=$reg;
				}
				$conexion->closeConexion();
				header('Content-Type: application/json; charset=utf8');
				echo json_encode($json);
			}
			else{
				$msg = 'Error al guardar la configuracion.';
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