<?php 
require_once('db_connect.php');

$json=array();
$msg="";
	if(isset($_GET)){
		
		
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
		$password=$_GET['password'];
		
		
		try{
			
			$sql="SELECT id_ruta
			FROM cat_rutas
			WHERE status = 'A' ORDER BY id_ruta ASC LIMIT 1";
			$resultado=mysqli_query($conexion,$sql);				
			
			$reg=mysqli_fetch_array($resultado);
			$id_ruta=$reg['id_ruta'];
			
			$sql = "INSERT INTO cat_clientes(nombre, calle, colonia, cp, curp, num_credencial, correo, telefono1, telefono2, celular, usuario, pass, id_ruta) 
			VALUES('{$nombre}', '{$calle}', '{$colonia}', '{$cp}', '{$curp}', '{$num_credencial}', '{$email}', '{$telefono1}', '{$telefono2}', '{$celular}', '{$usuario}', to_base64('{$password}'),{$id_ruta})";
			
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