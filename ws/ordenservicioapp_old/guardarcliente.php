<?php 
require_once('db_connect.php');

$json=array();
$msg="";

	if(isset($_POST)){
	
		$id_cliente = $_POST['id_cliente'];
		$nombre_cliente = $_POST['nombre_cliente'];
		$celular = $_POST['celular'];		
		$direccion = $_POST['direccion'];	
		
		try{
			
			if($id_cliente > 0){
				$consulta="UPDATE cat_clientes SET 
				nombre_cliente = '{$nombre_cliente}',		
				celular = '{$celular}',
				direccion = '{$direccion}'
				WHERE id_cliente={$id_cliente}";
				$resultado=mysqli_query($conexion,$consulta);
								
				$id = $id_cliente; 
				
				
			}else{
				
				
				//genero el pago
				$consulta="INSERT INTO cat_clientes(nombre_cliente,celular,direccion) 
				values('{$nombre_cliente}', '{$celular}', '{$direccion}')";
				$resultado=mysqli_query($conexion,$consulta);
			
				$id = mysqli_insert_id($conexion);
				
				
			}
			
			$consulta="SELECT id_cliente, nombre_cliente, celular, direccion
			FROM cat_clientes 
			WHERE id_cliente = {$id}";
			$resultado=mysqli_query($conexion,$consulta);
	

			if($consulta){
				
				if($reg=mysqli_fetch_array($resultado)){
					$msg = 'Se guardo el cliente correctamente.';
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