<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();

$json=array();
$msg="";

	if(isset($_POST)){
	
		$id_cliente = $_POST['id_cliente'];
		$nombre_cliente = $_POST['nombre_cliente'];
		$celular = $_POST['celular'];		
		$direccion = $_POST['direccion'];

		$basedatos=$_POST['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();		
		
		try{
			
			if($id_cliente > 0){
				$consulta="UPDATE cat_clientes SET 
				nombre_cliente = '{$nombre_cliente}',		
				celular = '{$celular}',
				direccion = '{$direccion}'
				WHERE id_cliente={$id_cliente}";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
								
				$id = $id_cliente; 
				
				
			}else{
				
				
				//genero el pago
				$consulta="INSERT INTO cat_clientes(nombre_cliente,celular,direccion) 
				values('{$nombre_cliente}', '{$celular}', '{$direccion}')";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
			
				$id = mysqli_insert_id($conexion->getConexion());
				
				
			}
			
			$consulta="SELECT id_cliente, nombre_cliente, celular, direccion
			FROM cat_clientes 
			WHERE id_cliente = {$id}";
			$resultado=mysqli_query($conexion->getConexion(),$consulta);
	

			if($consulta){
				
				if($reg=mysqli_fetch_array($resultado)){
					$msg = 'Se guardo el cliente correctamente.';
					$json['success'] = true;
					$json['msg'] = $msg;
					$json['datos'][]=$reg;
				}
				$conexion->closeConexion();
				header('Content-Type: application/json; charset=utf8');
				echo json_encode($json);
			}

			else{
				$msg = 'Error al guardar el cliente.';
				$json['success'] = false;
				$json['msg'] = $msg;
				$json['datos'][]=[];
				$conexion->closeConexion();
				echo json_encode($json);
			}		
		}catch(Exception $e){
			$conexion->closeConexion();
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