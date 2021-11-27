<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();

$json=array();
$msg="";
	if(isset($_GET["id_cliente"])){
		$id_cliente=$_GET['id_cliente'];

		$basedatos=$_GET['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();	
		
		
		//Cambiar el estatus del pedido a recogido
		//Cambiar el estatus de la asignacion de la lavadora a 1=Asignada al trabajador porque la recogio del cliente		
		
		try{
			
			
			//actualizo la ultima fecha de pago, tambien debo actualizar la ultima fecha de pago y fecha_ultimo vencimiento que es la fecha de pago mas los dias de renta ,fecha_ultimo_vencimiento=ADDDATE(fecha_ultimo_vencimiento,{$dias})
			$consulta="DELETE FROM cat_clientes WHERE id_cliente={$id_cliente}";
			$resultado=mysqli_query($conexion->getConexion(),$consulta);	
			
			

			
			$msg = 'Se elimino el cliente';
			$json['success'] = true;
			$json['msg'] = $msg;
			$json['datos'][]=[];	
			
			$conexion->closeConexion();
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
			
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