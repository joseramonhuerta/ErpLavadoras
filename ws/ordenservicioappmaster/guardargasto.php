<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();



$json=array();
$msg="";

	if(isset($_POST)){
	
		$id_gasto = $_POST['id_gasto'];
		$concepto = $_POST['concepto'];
		$fecha = $_POST['fecha'];	
		$datetime="$fecha";
		$fecha=date('Y-m-d',strtotime($datetime));
		$importe = $_POST['importe'];
		$tipo = $_POST['tipo'];
		$id_usuario = $_POST['id_usuario'];
		$id_orden_servicio = $_POST['id_orden_servicio'];
		
		$basedatos=$_POST['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();
		
		try{
			
			if($id_gasto > 0){
				$consulta="UPDATE gastos SET 
				fecha = '{$fecha}',
				concepto = '{$concepto}',
				importe = '{$importe}',
				tipo = {$tipo},
				usermodif = {$id_usuario},
				fechamodif = now()
				WHERE id_gasto={$id_gasto}";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
				//Throw new Exception($consulta);
				
				$id = $id_gasto; 
				
				
			}else{
				
				
				//genero el pago
				$consulta="INSERT INTO gastos(fecha,concepto, importe, tipo, usercreador, fechacreador) 
				values('{$fecha}', '{$concepto}', '{$importe}',{$tipo}, {$id_usuario}, now())";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
			
				$id = mysqli_insert_id($conexion->getConexion());
				
				
			}	
			
			if($tipo == 1){
				$consulta="UPDATE gastos SET 
				id_orden_servicio = {$id_orden_servicio}
				WHERE id_gasto={$id}";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
			}
			
			$consulta="SELECT id_gasto, CAST(DATE_FORMAT(fecha,'%d/%m/%Y') as CHAR) as fecha,concepto,tipo,CASE tipo WHEN 1 THEN 'INGRESO' WHEN 2 THEN 'EGRESO' END AS tipo_descripcion
			FROM gastos
			WHERE id_gasto = {$id}";
			$resultado=mysqli_query($conexion->getConexion(),$consulta);
			
			
			if($consulta){
				
				if($reg=mysqli_fetch_array($resultado)){
					$msg = 'Se guardo el gasto correctamente.';
					$json['success'] = true;
					$json['msg'] = $msg;
					$json['datos'][]=$reg;
				}
				$conexion->closeConexion();
				header('Content-Type: application/json; charset=utf8');
				echo json_encode($json);
			}

			else{
				$msg = 'Error al guardar el gasto.';
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
			//$results["id_pago"]="0";
			$json['success'] = false;
			$json['msg'] = $msg;
			$json['datos'][]=[];
			echo json_encode($json);
	}


 ?>