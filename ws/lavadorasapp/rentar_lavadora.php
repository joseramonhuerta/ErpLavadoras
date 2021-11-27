<?php 
require_once('db_connect.php');

$json=array();
$msg="";
	if(isset($_GET)){
		
		$id_cliente=$_GET['id_cliente'];
		$fecha=$_GET['fecha'];
		$hora=$_GET['hora'];
		$producto=$_GET['producto'];
		$observaciones=$_GET['observaciones'];
		
		$datetime="$fecha $hora";
		$fecha=date('Y-m-d H:i:s',strtotime($datetime));
        
		//Throw new Exception("ramon 1");
		
		
		try{
			
			
			$sql="SELECT r.id_ruta,t.id_trabajador
				FROM cat_rutas r
				LEFT JOIN cat_trabajadores t on t.id_ruta = r.id_ruta
				WHERE r.status = 'A' 
				ORDER BY r.id_ruta ASC LIMIT 1";
			$resultado=mysqli_query($conexion,$sql);				
				
			$reg=mysqli_fetch_array($resultado);
			$id_ruta=$reg['id_ruta'];
			$id_trabajador=$reg['id_trabajador'];				
			
			$precio_renta = 0;
			if($producto == 1)
				$precio_renta = 230;
			if($producto == 2)
				$precio_renta = 100;
			if($producto == 3)
				$precio_renta = 150;
			if($producto == 4)
				$precio_renta = 180;
			
			
			$sql = "INSERT INTO pedidos(id_cliente, id_ruta,id_trabajador, id_trabajador_ocacional, plazo_pago,fecha_entrega,fecha_entrega_cliente,fecha_ultimo_vencimiento,fecha_ultimo_pago,referencia,observaciones,precio_renta,status_pedido, origen, autorizada,fechacreador) 
			VALUES({$id_cliente}, {$id_ruta}, {$id_trabajador}, {$id_trabajador}, {$producto}, '{$fecha}', '{$fecha}', '{$fecha}', '{$fecha}', '', '{$observaciones}', '{$precio_renta}',0,2,0,NOW())";
			
			$resultado=mysqli_query($conexion,$sql);	
			
			$msg = "Registro exitoso";			
			$results["msg"]=$msg;
			$json['datos'][]=$results;
			
		}catch(Exception $e){
			$msg = $e;			
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
			
			$results["msg"]=$msg;
			$json['datos'][]=$results;
			
			echo json_encode($json);
						
	}



 ?>