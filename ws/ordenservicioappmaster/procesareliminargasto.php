<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();

$json=array();
$msg="";
	if(isset($_GET)){
		$id_gasto=$_GET['id_gasto'];		
		$basedatos=$_GET['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();
		
		try{
			
			
			$consulta="DELETE FROM gastos WHERE id_gasto={$id_gasto}";
			$resultado=mysqli_query($conexion->getConexion(),$consulta);	
			
			

			
			$msg = 'Se elimino el gasto';
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