<?php 
require_once('db_connect.php');

$json=array();
$datos=array();
try{
	$id_usuario_tecnico=(empty($_GET['id_usuario_tecnico'])) ? 0 : $_GET['id_usuario_tecnico'];	
	$id_usuario=(empty($_GET['id_usuario'])) ? 0 : $_GET['id_usuario'];	
	
	$consulta="SELECT CONCAT(nombre_usuario,' ',paterno_usuario,' ', IFNULL(materno_usuario,'')) AS nombre_usuario,conocimientos_tecnicos, imagen FROM cat_usuarios
				WHERE id_usuario = {$id_usuario_tecnico}";
				

	$resultado=mysqli_query($conexion,$consulta);
	$row = mysqli_fetch_array($resultado);
	
	$datos['nombre_usuario'] = $row['nombre_usuario'];
	$datos['conocimientos_tecnicos'] = $row['conocimientos_tecnicos'];
	$datos['imagen'] = $row['imagen'];
	
	$consulta="SELECT m.id_manual, m.nombre_manual, m.descripcion_manual, m.calificacion,m.precio, c.nombre_categoria,m.paginas,
				CONCAT(u.nombre_usuario,' ',u.paterno_usuario,' ',IFNULL(u.materno_usuario,'')) as nombre_usuario, u.imagen as imagen_usuario, u.id_usuario AS id_usuario_creador, m.esgratuito, IFNULL(um.id_usuario_manual,0) AS obtenido,
				m.url_portada,m.url_detalle,CASE WHEN IFNULL(TIMESTAMPDIFF(DAY, m.fecha_creador, NOW()),0) > 7 THEN 0 ELSE 1 END AS esnuevo
				FROM cat_manuales m
				INNER JOIN cat_usuarios u ON u.id_usuario = m.id_usuario_creador
				LEFT JOIN cat_categorias c ON c.id_categoria = m.id_categoria
				LEFT JOIN cat_usuarios_manuales um ON um.id_manual = m.id_manual AND um.id_usuario = {$id_usuario}		
				WHERE m.status = 'A' AND m.id_usuario_creador = {$id_usuario_tecnico}
				ORDER BY m.id_manual ASC";
				

	$resultado=mysqli_query($conexion,$consulta);
		
	while ($row = mysqli_fetch_array($resultado)) {
		$datos['manuales'][] = $row;
	}		
		
	$msg = "ok";
	$json['success'] = true;
	$json['msg'] = $msg;
	$json['datos'][] = $datos;	
	
	mysqli_close($conexion);
	header('Content-Type: application/json; charset=utf8');
	echo json_encode($json);	
	
}catch(Exception $e){
	$msg = $e->getMessage();
	$json['success'] = false;
	$json['msg'] = $msg;
	$json['datos'][]= [];
	mysqli_close($conexion);
	echo json_encode($json);
}

 ?>