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
        
		
		
		
		try{
			/*
			$sql = "INSERT INTO cat_clientes(nombre, calle, colonia, cp, curp, num_credencial, correo, telefono1, telefono2, celular, usuario, pass) 
			VALUES('{$nombre}', '{$calle}', '{$colonia}', '{$cp}', '{$curp}', '{$num_credencial}', '{$email}', '{$telefono1}', '{$telefono2}', '{$celular}', '{$usuario}', to_base64('{$password}'))";
			
			$resultado=mysqli_query($conexion,$sql);	
			*/
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