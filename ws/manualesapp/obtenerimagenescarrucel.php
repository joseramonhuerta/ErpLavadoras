<?php

require_once('db_connect.php');

$json = array();

$consulta = "SELECT descripcion_carrucel, imagen_carrucel, url_carrucel FROM carrucel WHERE status = 'A' ORDER BY orden";

$resultado = mysqli_query($conexion, $consulta);
	
if($consulta){
	while($row = mysqli_fetch_array($resultado)){
		$json[] = $row;
	}
	mysqli_close($conexion);
	header('Content-Type: Application/json; charset=utf8');
	echo json_encode($json);
}else{
	$results['descripcion_carrucel'] = '';
	$results['imagen_carrucel'] = '';
	$results['url_carrucel'] = '';
	$json[] = $results;
	mysqli_close($conexion);
	echo json_encode($json);
}