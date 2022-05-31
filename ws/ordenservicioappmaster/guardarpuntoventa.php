<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();

$json=array();
$msg="";

	if(isset($_POST)){
	
		$id_puntodeventa = $_POST['id_puntodeventa'];
		$descripcion_puntodeventa = $_POST['descripcion_puntoventa'];
		
		$basedatos=$_POST['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();		
		
		try{
			
			if($id_puntodeventa > 0){
				$consulta="UPDATE cat_puntosdeventas SET 
				descripcion_puntodeventa = '{$descripcion_puntodeventa}'
				WHERE id_puntodeventa={$id_puntodeventa}";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
								
				$id = $id_puntodeventa; 
				
				
			}else{
				
				
				//genero el pago
				$consulta="INSERT INTO cat_puntosdeventas(descripcion_puntodeventa) 
				values('{$descripcion_puntodeventa}')";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
			
				$id = mysqli_insert_id($conexion->getConexion());
				
				
			}
			
			$consulta="SELECT id_puntodeventa, descripcion_puntodeventa
			FROM cat_puntosdeventas
			WHERE id_puntodeventa = {$id}";
			$resultado=mysqli_query($conexion->getConexion(),$consulta);
	

			if($consulta){
				
				if($reg=mysqli_fetch_array($resultado)){
					$msg = 'Se guardo el punto de venta correctamente.';
					$json['success'] = true;
					$json['msg'] = $msg;
					$json['datos'][]=$reg;
				}
				$conexion->closeConexion();
				header('Content-Type: application/json; charset=utf8');
				echo json_encode($json);
			}

			else{
				$msg = 'Error al guardar el punto de venta.';
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