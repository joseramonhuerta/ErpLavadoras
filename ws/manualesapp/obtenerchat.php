<?php 
require_once('db_connect.php');

$json=array();
$mensajes=array();


if(isset($_POST["id_usuario_manual"])){
	$id_usuario_manual = $_POST['id_usuario_manual'];
	
	
	try{
		
		//Buscar una conversacion, si no existe crearla
		
		
				
		$consulta="SELECT c.id_conversacion, c.fecha_conversacion, c.id_usuario, c.id_usuario_tecnico, c.fecha_ultimo_mensaje,c.ultimo_mensaje,c.status_conversacion	,IFNULL(u.imagen,'') AS imagen_tecnico,u.nombre_usuario, m.nombre_manual
		FROM conversaciones c
		INNER JOIN cat_usuarios_manuales um ON um.id_usuario_manual = c.id_usuario_manual
		INNER JOIN cat_manuales m ON m.id_manual = um.id_manual
		INNER JOIN cat_usuarios u ON u.id_usuario = c.id_usuario_tecnico
		WHERE c.id_usuario_manual = {$id_usuario_manual}";
		$resultado=mysqli_query($conexion,$consulta);

		$reg=mysqli_fetch_array($resultado);

		$id_conversacion = $reg['id_conversacion'];
		
		$consulta_mensajes="SELECT cm.id_conversacion_mensaje, cm.id_conversacion, cm.id_usuario_envia, cm.id_usuario_recibe,CAST(DATE_FORMAT(cm.fecha_mensaje,'%d/%m/%Y %h:%i %p') AS CHAR) AS fecha_mensaje, cm.mensaje
		FROM conversaciones_mensajes cm
		INNER JOIN conversaciones c ON cm.id_conversacion = c.id_conversacion
		WHERE c.id_conversacion = {$id_conversacion}";
		$resultado_mensajes=mysqli_query($conexion,$consulta_mensajes);
		
		if($consulta_mensajes){			
			while ($row = mysqli_fetch_array($resultado_mensajes)) {
                $mensajes[] = $row;
            }			
		}else{
			$mensajes=[];
		}
		
		$reg['mensajes']=$mensajes;

		if($consulta){		
			$msg = '';
			$json['success'] = true;
			$json['msg'] = $msg;
			$json['datos'][]=$reg;
			
			
			header('Content-Type: application/json; charset=utf8');
			mysqli_close($conexion);				
			echo json_encode($json);
		}else{
			$msg = 'Error al obtener el usuario.';
			$json['success'] = false;
			$json['msg'] = $msg;
			$json['datos'][]=[];
			mysqli_close($conexion);
			echo json_encode($json);
		}		
	}catch(Exception $e){
		$msg = $e->getMessage();
		$json['success'] = false;
		$json['msg'] = $msg;
		$json['datos'][]= [];
		mysqli_close($conexion);
		echo json_encode($json);
	}
}else{
	mysqli_close($conexion);
	$msg = "No se recibieron los parámetros necesarios";
	$json["success"]=false;
	$json["msg"]=$msg;
	$json['datos'][]=[];
	echo json_encode($json);
}