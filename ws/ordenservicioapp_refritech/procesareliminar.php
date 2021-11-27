<?php 
require_once('db_connect.php');

$json=array();
$msg="";
	if(isset($_GET["id_orden_servicio"])){
		$id_orden_servicio=$_GET['id_orden_servicio'];		
		
		
		//Cambiar el estatus del pedido a recogido
		//Cambiar el estatus de la asignacion de la lavadora a 1=Asignada al trabajador porque la recogio del cliente		
		
		try{
			
			
			//actualizo la ultima fecha de pago, tambien debo actualizar la ultima fecha de pago y fecha_ultimo vencimiento que es la fecha de pago mas los dias de renta ,fecha_ultimo_vencimiento=ADDDATE(fecha_ultimo_vencimiento,{$dias})
			$consulta="DELETE FROM ordenes_servicio WHERE id_orden_servicio={$id_orden_servicio}";
			$resultado=mysqli_query($conexion,$consulta);	
			
			

			
			$msg = 'Se elimino la orden de servicio';
			$json['success'] = true;
			$json['msg'] = $msg;
				
			
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
			
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