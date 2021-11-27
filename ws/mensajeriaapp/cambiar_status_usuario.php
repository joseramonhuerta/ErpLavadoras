<?php 
require_once('db_connect.php');

$json=array();
$msg="";
$sucess=false;
			
	if(isset($_GET)){
		
		$status=$_GET['status'];
		$id_usuario=$_GET['id_usuario'];
		
		try{
			
			
			$sql = "UPDATE cat_usuarios set status = '{$status}' WHERE id_usuario = {$id_usuario}";
			//throw new Exception($sql);
			$resultado=mysqli_query($conexion,$sql);	
			$sucess=true;
			$results["sucess"]=$sucess;
			
			if($status=="A")
				$msg = "Usuario Activado.";
			else		
				$msg = "Usuario Inactivado.";
			
			$results["msg"]=$msg;
			$json['datos'][]=$results;
			
		}catch(Exception $e){
			$msg = $e->getMessage();
			$sucess=false;
			$results["sucess"]=$sucess;			
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
			$sucess=false;
			$results["sucess"]=$sucess;	
			$results["msg"]=$msg;
			$json['datos'][]=$results;
			
			echo json_encode($json);
						
	}



 ?>