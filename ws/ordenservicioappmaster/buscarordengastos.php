<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();

$json=array();
$msg="";
	if(isset($_GET)){
		$id_orden=$_GET['id_orden'];		
		$basedatos=$_GET['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();
		
		try{
			
			
			$consulta="SELECT o.id_orden_servicio, o.nombre_equipo,
			c.nombre_cliente,o.importe_presupuesto
			FROM ordenes_servicio o
			LEFT JOIN cat_clientes c on c.id_cliente = o.id_cliente
			WHERE o.status_servicio = 5 AND o.id_orden_servicio = {$id_orden}";
		
		
			$resultado=mysqli_query($conexion->getConexion(),$consulta);
			
			if($consulta){

				$reg=mysqli_fetch_array($resultado);
				
				if($reg['id_orden_servicio'] > 0){
					
				}else{
					Throw new Exception("No se encontro la orden.");	
					
				}
				
			}
			
			$msg = 'Solicitud encontrada';
			$json['success'] = true;
			$json['msg'] = $msg;
			$json['datos'][]=$reg;	
			
			$conexion->closeConexion();
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
			
		}catch(Exception $e){
			$msg = $e->getMessage();
			$json['msg'] = $msg;
			$json['success'] = false;
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
			echo json_encode($json);
	}



 ?>