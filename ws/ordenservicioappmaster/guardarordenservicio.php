<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();

$json=array();
$msg="";

	if(isset($_POST)){
	
		$basedatos=$_POST['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();
		$debug = 0;
		if(isset($_POST['debug'])){
			$debug = 1;
		}
			
		//$postdata = file_get_contents("php://input");
		//$request = json_decode($postdata);
		$id_orden_servicio = $_POST['id_orden_servicio'];
		$id_cliente = null;
		//$nombre_cliente = $_POST['nombre_cliente'];
		//$celular = $_POST['celular'];		
		$fecha = $_POST['fecha'];	
		$datetime="$fecha";
		$fecha=date('Y-m-d',strtotime($datetime));
		
		$fecha_entrega = $_POST['fecha_entrega'];	
		$datetime="$fecha_entrega";
		$fecha_entrega=date('Y-m-d',strtotime($datetime));
		
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
		$id_usuario = $_POST['id_usuario'] ? $_POST['id_usuario']: 0;
		
						
		$tipo_servicio = $_POST['tipo_servicio'];
		$id_cliente_venta = null;
		$id_puntodeventa = null;	
		$precio_venta = 0.00;
		
		if($status_servicio == 9 || $status_servicio == 10){
			$id_puntodeventa = $_POST['id_puntodeventa'];		
		}
		
		if($tipo_servicio == 1){
			$id_cliente = $_POST['id_cliente'];
					
		}else{
			$id_cliente_venta = $_POST['id_cliente_venta'];
			$precio_venta = $_POST['precio_venta'];	
		}
		
		$imagen =  null;
		$nombre_imagen = null;
		
		$imagen_back =  null;
		$nombre_imagen_back = null;
		
		$imagen_tecnico =  null;
		$nombre_imagen_tecnico = null;
		
		if(isset($_POST['imagen'])){
			$imagen =  $_POST['imagen'];
			$nombre_imagen = $_POST['nombre_imagen'];
			/*
			try{
				$file_path = "uploads/$nombre_imagen";
				file_put_contents($file_path, base64_decode($imagen));
			}catch(Exception $e){		
			
			
			}	*/
			
		}
		
		if(isset($_POST['imagen_back'])){
			$imagen_back =  $_POST['imagen_back'];
			$nombre_imagen_back = $_POST['nombre_imagen_back'];	
		}
		
		
		if(isset($_POST['imagen_tecnico'])){
			$imagen_tecnico =  $_POST['imagen_tecnico'];
			$nombre_imagen_tecnico = $_POST['nombre_imagen_tecnico'];	
		}
		
		
		
		
		//Throw new Exception('ramon');
		
		//Throw new Exception($request->address);
		//Cambiar el estatus del pedido a recogido
		//Cambiar el estatus de la asignacion de la lavadora a 1=Asignada al trabajador porque la recogio del cliente		
		
		try{
			//Throw new Exception($debug);
			if($id_orden_servicio > 0){
				$consulta="UPDATE ordenes_servicio SET 
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
				id_tecnico = {$id_tecnico},
				tipo_servicio = {$tipo_servicio},
				precio_venta = '{$precio_venta}'
				WHERE id_orden_servicio={$id_orden_servicio}";
				
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
								
				$id = $id_orden_servicio; 
				
				
			}else{
				
				
				
				$consulta="INSERT INTO ordenes_servicio(fecha,nombre_equipo, modelo_equipo, serie_equipo, descripcion_falla, nombre_tecnico, descripcion_diagnostico, descripcion_reparacion, importe_presupuesto, status_servicio, id_tecnico, tipo_servicio, precio_venta) 
				values('{$fecha}', '{$nombre_equipo}', '{$modelo_equipo}', '{$serie_equipo}', '{$descripcion_falla}', '{$nombre_tecnico}', '{$descripcion_diagnostico}', 
				'{$descripcion_reparacion}', '{$importe_presupuesto}',{$status_servicio}, {$id_tecnico},{$tipo_servicio},'{$precio_venta}')";
				
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
			
				$id = mysqli_insert_id($conexion->getConexion());
				
				
			}
			
			
			
			
			//Actualizo la imagen en caso de traer, porque solo se manda cuando el registro es nuevo o cuando se edito y se tomo otra foto
			if(isset($_POST['imagen'])){
				$consulta="UPDATE ordenes_servicio SET 
				nombre_imagen = '{$nombre_imagen}',
				imagen = '{$imagen}'			
				WHERE id_orden_servicio={$id}";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);					
			}
		
			if(isset($_POST['imagen_back'])){
				$consulta="UPDATE ordenes_servicio SET 
				nombre_imagen_back = '{$nombre_imagen_back}',
				imagen_back = '{$imagen_back}'			
				WHERE id_orden_servicio={$id}";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);					
			}
			
			if(isset($_POST['imagen_tecnico'])){
				$consulta="UPDATE ordenes_servicio SET 
				nombre_imagen_tecnico = '{$nombre_imagen_tecnico}',
				imagen_tecnico = '{$imagen_tecnico}'			
				WHERE id_orden_servicio={$id}";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);					
			}
			
			if($status_servicio == 6 || $status_servicio == 7){
				$consulta="UPDATE ordenes_servicio SET 
				fecha_entrega = '{$fecha_entrega}'			
				WHERE id_orden_servicio={$id}";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);					
			}else{
				$consulta="UPDATE ordenes_servicio SET 
				fecha_entrega = NULL			
				WHERE id_orden_servicio={$id}";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
			}
			
			//verificar el tipo de orden, si es 1=cargo se pone el id_cliente, si es venta se pone el id_cliente_venta			
			if($tipo_servicio == 1 && isset($_POST['id_cliente'])){
				$consulta="UPDATE ordenes_servicio SET 
				id_cliente = {$id_cliente},
				id_cliente_venta = NULL,
				id_puntodeventa = NULL	
				WHERE id_orden_servicio={$id}";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
						
			}else if($tipo_servicio == 2 && isset($_POST['id_cliente_venta'])) {
				$consulta="UPDATE ordenes_servicio SET 
				id_cliente_venta = {$id_cliente_venta},
				id_cliente = NULL					
				WHERE id_orden_servicio={$id}";
				$resultado=mysqli_query($conexion->getConexion(),$consulta);
			}
			
			//verificar si el estatus es 9=En Punto de Venta o 10=Vendida
			if(($status_servicio == 9 || $status_servicio == 10) && isset($_POST['id_puntodeventa']) && $tipo_servicio == 2){
				$consulta="UPDATE ordenes_servicio SET 
					id_puntodeventa = {$id_puntodeventa}			
					WHERE id_orden_servicio={$id}";
					$resultado=mysqli_query($conexion->getConexion(),$consulta);	
			}
			
			
			//Si la orden de entrega ya esta entregada, agregar el registro a gastos
			
			if($status_servicio == 6){
				//Validar si ya se registro el gasto de esta orden de servicio, si no, registrar
				$consulta_gasto="SELECT id_gasto FROM gastos WHERE id_orden_servicio = {$id}";
				$resultado_gasto=mysqli_query($conexion->getConexion(),$consulta_gasto);				
				$row_cnt = mysqli_num_rows($resultado_gasto);				
				
				if($row_cnt > 0){					
				}else{					
					$consulta_gasto="INSERT INTO gastos(fecha,concepto, importe, tipo, usercreador, fechacreador,id_orden_servicio) 
					values('{$fecha_entrega}', '{$nombre_equipo}', '{$importe_presupuesto}',1, {$id_usuario}, now(),{$id})";
					$resultado_gasto=mysqli_query($conexion->getConexion(),$consulta_gasto);					
				}
				
			}			
			
			$consulta="SELECT o.id_orden_servicio, CAST(DATE_FORMAT(o.fecha,'%d/%m/%Y') as CHAR) as fecha,IFNULL(c.id_cliente, 0) as id_cliente,IFNULL(c2.nombre_cliente, '') as nombre_cliente_venta,
			IFNULL(c.nombre_cliente, o.nombre_cliente) as nombre_cliente,o.status_servicio,CASE o.status_servicio WHEN 1 THEN 'RECIBIDO' WHEN 2 THEN 'EN REVISIÓN' WHEN 3 THEN 'COTIZADO' WHEN 4 THEN 'EN REPARACIÓN' WHEN 5 THEN 'REPARADO' WHEN 6 THEN 'ENTREGADO' WHEN 7 THEN 'DEVOLUCION' WHEN 8 THEN 'EN BODEGA' WHEN 9 THEN 'EN TIENDA' WHEN 10 THEN 'VENDIDA' END AS status_servicio_descripcion,
			o.nombre_equipo,o.modelo_equipo,o.serie_equipo, o.descripcion_falla, o.ruta_imagen,o.nombre_imagen,o.descripcion_diagnostico,o.nombre_tecnico,
			o.descripcion_reparacion,o.importe_presupuesto,o.token, o.imagen, IFNULL(c.celular, o.celular) as celular,
			o.nombre_imagen_back,o.imagen_back,o.nombre_imagen_tecnico,o.imagen_tecnico,CAST(DATE_FORMAT(o.fecha_entrega,'%d/%m/%Y') as CHAR) as fecha_entrega, o.tipo_servicio, o.id_cliente_venta, o.id_puntodeventa, o.precio_venta
			FROM ordenes_servicio o
			LEFT JOIN cat_clientes c on c.id_cliente = o.id_cliente
			LEFT JOIN cat_clientes c2 on c2.id_cliente = o.id_cliente_venta
			WHERE o.id_orden_servicio = {$id}";
			
			$resultado=mysqli_query($conexion->getConexion(),$consulta);
			
			
			/*$consulta="SELECT p.id_pedido
			FROM pedidos p 
			WHERE p.id_pedido = {$id_pedido}";
			$resultado=mysqli_query($conexion,$consulta);*/
			
			//Throw new Exception($debug);

			if($consulta){
				
				if($reg=mysqli_fetch_array($resultado)){
					$msg = 'Se guardo la orden de servicio correctamente';
					$json['success'] = true;
					$json['msg'] = $msg;
					$json['datos'][]=$reg;
				}
				$conexion->closeConexion();
				header('Content-Type: application/json; charset=utf8');
				echo json_encode($json);
			}

			else{
				$msg = 'Error al guardar la orden de servicio.';
				$json['success'] = false;
				$json['msg'] = $msg;
				$json['datos'][]=[];
				$conexion->closeConexion();
				header('Content-Type: application/json; charset=utf8');
				echo json_encode($json);
			}		
		}catch(Exception $e){			
			$msg = $e->getMessage();
			//$results["id_pago"]="0";
			$json['success'] = false;
			$json['msg'] = $msg;
			$json['datos'][]=[];
			$conexion->closeConexion();
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
			
		
		
		}		
	
	}
	else{
			$msg = 'No se recibieron todos los parametros';
			//$results["id_pago"]="0";
			$json['success'] = false;
			$json['msg'] = $msg;
			$json['datos'][]=[];
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
	}


 ?>