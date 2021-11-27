<?php 
require_once('db_connect.php');

$json=array();
$msg="";
	if(isset($_GET)&& isset($_GET["id_cliente"])){
		
		$id_cliente = $_GET['id_cliente'];
		$nombre=$_GET['nombre'];
		$calle=$_GET['calle'];
		$colonia=$_GET['colonia'];
		$cp=$_GET['cp'];
        $curp=$_GET['curp'];
		$num_credencial=$_GET['num_credencial'];
		$email=$_GET['email'];
		$telefono1=$_GET['telefono1'];
		$telefono2=$_GET['telefono2'];
        $celular=$_GET['celular'];
		$usuario=$_GET['usuario'];
		$pass=$_GET['password'];
		
		
		try{
						
			if($id_cliente > 0){	
				$sql = "UPDATE cat_clientes SET nombre = '{$nombre}',calle = '{$calle}',colonia = '{$colonia}',cp = '{$cp}',
					curp = '{$curp}', num_credencial = '{$num_credencial}',	correo = '{$email}',	telefono1 = '{$telefono1}',	telefono2 = '{$telefono2}',
					celular = '{$celular}',	pass =  to_base64('{$pass}') WHERE id_cliente = {$id_cliente}";
				$msg = "Usuario Actualizado";		
				
			}else{
				
				$msg = "No se recibio el parametro ID";		
			}		
			
			
			$resultado=mysqli_query($conexion,$sql);	
			
				
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