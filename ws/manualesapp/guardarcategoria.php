<?php 
require_once('db_connect.php');
$json=array();
$msg="";
if(isset($_POST)){
	$nombre_categoria = $_POST['nombre_categoria'];
	$imagen_categoria = null;
	
	if(isset($_POST['imagen_categoria'])){
		$imagen_categoria =  $_POST['imagen_categoria'];			
	}
	
	try{		
		$consulta = "SELECT id_categoria FROM cat_categorias WHERE nombre_categoria = '$nombre_categoria'";
		$resultado = mysqli_query($conexion, $consulta);
		$registro=mysqli_fetch_array($resultado);
		$id_categoria=$reg['id_categoria'];
							
		if($id_categoria > 0){
			Throw new Exception("La categoría ya existe.");					
		}		
		
		$consulta="INSERT INTO cat_categorias(nombre_categoria) 
			VALUES('$nombre_categoria')";
			
		$resultado = mysqli_query($conexion,$consulta);
		
		$id = mysqli_insert_id($conexion);
		
		if(isset($_POST['imagen_categoria'])){
			$consulta="UPDATE cat_categorias SET 
			imagen_categoria = '{$imagen_categoria}'			
			WHERE id_categoria={$id}";
			$resultado=mysqli_query($conexion,$consulta);					
		}

		$msg = 'Guardada correctamente.';
		
		$json['success'] = true;
		$json['msg'] = $msg;		
		
		mysqli_close($conexion);
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($json);
		
	}catch(Exception $e){
		mysqli_close($conexion);
		$msg = $e->getMessage;

		$json['success'] = false;
		$json['msg'] = $msg;		
		
		mysqli_close($conexion);
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($json);	
	}		
}else{
		$msg = 'No se recibieron todos los parametros';
		$json['success'] = false;
		$json['msg'] = $msg;		
		echo json_encode($json);
}

?>