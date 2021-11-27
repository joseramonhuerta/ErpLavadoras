<?php 
require_once('db_connect.php');

$json=array();
$msg="";

	if(isset($_POST)){
	
		
		
		//$postdata = file_get_contents("php://input");
		//$request = json_decode($postdata);
		$id_orden_servicio = $_POST['id_orden_servicio'];
		$id_cliente = $_POST['id_cliente'];
		//$nombre_cliente = $_POST['nombre_cliente'];
		//$celular = $_POST['celular'];		
		$fecha = $_POST['fecha'];	
		$datetime="$fecha";
		$fecha=date('Y-m-d',strtotime($datetime));
		
		$nombre_equipo = $_POST['nombre_equipo'];
		$modelo_equipo = $_POST['modelo_equipo'];
		$serie_equipo = $_POST['serie_equipo'];
		$descripcion_falla = $_POST['descripcion_falla'];
		$nombre_tecnico = $_POST['nombre_tecnico'];
		$descripcion_diagnostico = $_POST['descripcion_diagnostico'];
		$descripcion_reparacion = $_POST['descripcion_reparacion'];
		$importe_presupuesto = $_POST['importe_presupuesto'];
		$status_servicio = $_POST['status_servicio'];
		$id_tecnico = $_POST['id_tecnico'];
		
		$imagen =  null;
		$nombre_imagen = null;
		
		if(isset($_POST['imagen'])){
			$imagen =  $_POST['imagen'];
			$nombre_imagen = $_POST['nombre_imagen'];
			
			try{
				$file_path = "uploads/$nombre_imagen";
				file_put_contents($file_path, base64_decode($imagen));
			}catch(Exception $e){		
			
			
			}	
			
		}
		

		
		
		
		
		
		
		//Throw new Exception($request->address);
		//Cambiar el estatus del pedido a recogido
		//Cambiar el estatus de la asignacion de la lavadora a 1=Asignada al trabajador porque la recogio del cliente		
		
		try{
			
			if($id_orden_servicio > 0){
				$consulta="UPDATE ordenes_servicio SET 
				id_cliente = {$id_cliente},		
				fecha = '{$fecha}',
				nombre_equipo = '{$nombre_equipo}',
				modelo_equipo = '{$modelo_equipo}',
				serie_equipo = '{$serie_equipo}',
				descripcion_falla = '{$descripcion_falla}',
				nombre_tecnico = '{$nombre_tecnico}',
				descripcion_diagnostico = '{$descripcion_diagnostico}',
				descripcion_reparacion = '{$descripcion_reparacion}',
				importe_presupuesto = '{$importe_presupuesto}',
				status_servicio = {$status_servicio},
				id_tecnico = {$id_tecnico}
				WHERE id_orden_servicio={$id_orden_servicio}";
				$resultado=mysqli_query($conexion,$consulta);
				//Throw new Exception($consulta);
				
				$id = $id_orden_servicio; 
				
				
			}else{
				
				
				//genero el pago
				$consulta="INSERT INTO ordenes_servicio(id_cliente,fecha,nombre_equipo, modelo_equipo, serie_equipo, descripcion_falla, nombre_tecnico, descripcion_diagnostico, descripcion_reparacion, importe_presupuesto, status_servicio, id_tecnico) 
				values({$id_cliente}, '{$fecha}', '{$nombre_equipo}', '{$modelo_equipo}', '{$serie_equipo}', '{$descripcion_falla}', '{$nombre_tecnico}', '{$descripcion_diagnostico}', 
				'{$descripcion_reparacion}', '{$importe_presupuesto}',{$status_servicio}, {$id_tecnico})";
				$resultado=mysqli_query($conexion,$consulta);
			
				$id = mysqli_insert_id($conexion);
				
				
			}
			
			
			
			
			//Actualizo la imagen en caso de traer, porque solo se manda cuando el registro es nuevo o cuando se edito y se tomo otra foto
			if(isset($_POST['imagen'])){
				$consulta="UPDATE ordenes_servicio SET 
				nombre_imagen = '{$nombre_imagen}',
				imagen = '{$imagen}'			
				WHERE id_orden_servicio={$id}";
				$resultado=mysqli_query($conexion,$consulta);					
			}
		
			
			
			
			
			
			$consulta="SELECT o.id_orden_servicio, CAST(DATE_FORMAT(o.fecha,'%d/%m/%Y') as CHAR) as fecha,IFNULL(c.id_cliente, 0) as id_cliente,
			IFNULL(c.nombre_cliente, o.nombre_cliente) as nombre_cliente,o.status_servicio,CASE o.status_servicio WHEN 1 THEN 'PENDIENTE' WHEN 2 THEN 'EN REPARACION' WHEN 3 THEN 'ENTREGADO' WHEN 4 THEN 'DEVOLUCION' END AS status_servicio_descripcion,
			o.nombre_equipo,o.modelo_equipo,o.serie_equipo, o.descripcion_falla, o.ruta_imagen,o.nombre_imagen,o.descripcion_diagnostico,o.nombre_tecnico,
			o.descripcion_reparacion,o.importe_presupuesto,o.token, o.imagen, IFNULL(c.celular, o.celular) as celular
			FROM ordenes_servicio o
			LEFT JOIN cat_clientes c on c.id_cliente = o.id_cliente
			WHERE o.id_orden_servicio = {$id}";
			$resultado=mysqli_query($conexion,$consulta);
			
			
			/*$consulta="SELECT p.id_pedido
			FROM pedidos p 
			WHERE p.id_pedido = {$id_pedido}";
			$resultado=mysqli_query($conexion,$consulta);*/
			
			//Throw new Exception($id);

			if($consulta){
				
				if($reg=mysqli_fetch_array($resultado)){
					$msg = 'Se guardo la orden de servicio correctamente.';
					$json['success'] = true;
					$json['msg'] = $msg;
					$json['datos'][]=$reg;
				}
				mysqli_close($conexion);
				header('Content-Type: application/json; charset=utf8');
				echo json_encode($json);
			}

			else{
				$msg = 'Error al guardar la orden de servicio.';
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
			//$results["id_pago"]="0";
			$json['success'] = false;
			$json['msg'] = $msg;
			$json['datos'][]=[];
			echo json_encode($json);
	}


 ?>