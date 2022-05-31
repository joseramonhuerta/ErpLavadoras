<?php 
require_once('db_connect.php');
$json=array();
$msg="";
if(isset($_POST)){
	$id_usuario = $_POST['id_usuario'];
	$id_manual = $_POST['id_manual'];
	$id_usuario_manual = $_POST['id_usuario_manual'];
	$calificacion = $_POST['calificacion'];
	
	
	try{		
	
		
				
		//calificar el usuario manual
		$consulta="UPDATE cat_usuarios_manuales SET 
		calificacion = '{$calificacion}'	
		WHERE id_usuario_manual = {$id_usuario_manual}";
		$resultado=mysqli_query($conexion,$consulta);
		
		$consulta = "SELECT SUM(calificacion) AS calificacion FROM cat_usuarios_manuales WHERE id_manual = {$id_manual}";
		$resultado=mysqli_query($conexion, $consulta);
		$reg = mysqli_fetch_array($resultado);
		$suma_calificaciones=$reg['calificacion'];
		
		$consulta = "SELECT COUNT(id_usuario_manual) AS calificaron FROM cat_usuarios_manuales WHERE id_manual = {$id_manual} AND calificacion > 0";
		$resultado=mysqli_query($conexion, $consulta);
		$reg = mysqli_fetch_array($resultado);
		$num_calificaron=$reg['calificaron'];
		
		$calificacion_manual = 0.00;
		if($suma_calificaciones > 0){
			$calificacion_manual = $suma_calificaciones / $num_calificaron;
			
			$consulta="UPDATE cat_manuales SET 
						calificacion = '{$calificacion_manual}'	
						WHERE id_manual = {$id_manual}";
			$resultado=mysqli_query($conexion,$consulta);
		}
			
		
		//obtener suma calificacion del usuario manual
		
		//obtener cuantos han calificado el curso calificacion count > 0
		
		//calificar manual con el promedio suma calificaciones / num calificadores
		
		$msg = 'Gracias por calificar';
		
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