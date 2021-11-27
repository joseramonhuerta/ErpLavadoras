<?php 
require_once('db_connect.php');

$json=array();
$msg="";
	if(isset($_GET["id_gasto"])){
		$id_gasto=$_GET['id_gasto'];		
		
		
		try{
			
			
			$consulta="DELETE FROM gastos WHERE id_gasto={$id_gasto}";
			$resultado=mysqli_query($conexion,$consulta);	
			
			

			
			$msg = 'Se elimino el gasto';
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